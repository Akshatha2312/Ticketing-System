<?php 
include '../../includes/header.php'; 
include '../../config/db.php'; 

$message = "";

if (isset($_POST['upload'])) {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
        $filename = $_FILES['csv_file']['tmp_name'];

        if (($handle = fopen($filename, "r")) !== FALSE) {
            $inserted = 0;
            $skipped = 0;
            $rowNum = 0;

            // 🔄 Step 1: Unpublish all previous results
            $conn->query("UPDATE results SET publish = 0");

            while (($line = fgets($handle)) !== FALSE) {
                $rowNum++;
                $line = trim($line);

                if ($line === "") continue;

                // Skip header row
                if ($rowNum == 1 && !preg_match('/^\d+$/', substr($line, 0, 3))) {
                    continue;
                }

                $data = explode(",", $line);

                if (count($data) < 5) {
                    $skipped++;
                    continue;
                }

                $regno        = trim($data[0], " \t\n\r\0\x0B\"");
                $subject_code = trim($data[1], " \t\n\r\0\x0B\"");
                $subject_name = trim($data[2], " \t\n\r\0\x0B\"");
                $grade        = trim($data[3], " \t\n\r\0\x0B\"");
                $result_status= trim($data[4], " \t\n\r\0\x0B\"");

                $sql = "INSERT INTO results 
                        (reg_no, semester, subject_code, subject_name, grade, result_status, exam_month, publish) 
                        VALUES (?, ?, ?, ?, ?, ?, 'Sep-2025', 1)";

                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $semester = 3; // Fixed for now
                    $stmt->bind_param("sissss", $regno, $semester, $subject_code, $subject_name, $grade, $result_status);

                    if ($stmt->execute()) {
                        $inserted++;
                    } else {
                        $skipped++;
                    }
                    $stmt->close();
                } else {
                    $skipped++;
                }
            }
            fclose($handle);

            $message = "🎉 Import completed!<br>✅ Inserted: $inserted records<br>⚠️ Skipped: $skipped records";
        } else {
            $message = "❌ Could not open CSV file.";
        }
    } else {
        $message = "❌ File upload error.";
    }
}
?>

<!-- ===== Page Layout ===== -->
<div style="background: #f9f9f9; padding: 10px 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center;">
  <div style="font-size: 20px; font-weight: bold; color: #1b5e20;">COE Dashboard</div>
  <div>
    <a href="dashboard.php" style="margin: 0 15px; text-decoration: none; color: #333; font-weight: bold;">HOD</a>
    <a href="send_query_form.php" style="margin: 0 15px; text-decoration: none; color: #333; font-weight: bold;">COE</a>
    <a href="publish_result_form.php" style="margin: 0 15px; text-decoration: none; color: #333; font-weight: bold;">Publish Result</a>
    <a href="../../logout.php" style="margin: 0 15px; text-decoration: none; color: #c0392b; font-weight: bold;">Logout</a>
  </div>
</div>

<div class="page-wrapper">
    <div class="content">
        <div class="center-box">
            <h2>📤 Publish Student Results</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="csv_file">Upload CSV File</label>
                    <input type="file" name="csv_file" id="csv_file" accept=".csv" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="upload">Upload & Publish</button>
                </div>
            </form>

            <?php if (!empty($message)): ?>
                <div style="margin-top:20px; padding:15px; background:#f0fdf4; border:1px solid #1b5e20; border-radius:8px; text-align:left; color:#1b5e20; font-weight:bold;">
                    <?= $message ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
