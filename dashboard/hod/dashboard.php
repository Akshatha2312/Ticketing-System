<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'HOD') {
    header('Location: ../../login.php');
    exit();
}

include '../../config/db.php';
include '../../includes/header.php';

$department = $_SESSION['department'];
?>

<!-- === HOD DASHBOARD NAVIGATION BAR === -->

<div style="background: #f9f9f9; padding: 10px 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center;">
  <div style="font-size: 20px; font-weight: bold; color: #1b5e20;">
    HOD Dashboard - <?= htmlspecialchars($department ?? 'Department') ?>
  </div>
  <div>
    <a href="dashboard.php" style="margin: 0 15px; text-decoration: none; color: #333; font-weight: bold;">COE</a>
    <a href="submit_issue.php" style="margin: 0 15px; text-decoration: none; color: #333; font-weight: bold;">HOD</a>
    <a href="../../logout.php" style="margin: 0 15px; text-decoration: none; color: #c0392b; font-weight: bold;">Logout</a>
  </div>
</div>


<!-- Spacer -->
<div style="height: 60px;"></div>

<div style="max-width: 1200px; margin: 20px auto; padding: 20px 10px; background-color: #f5f5f5; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

    <h2 style="color: #1b5e20; margin-bottom: 30px; text-align: center;">
        Queries from COE to <?= htmlspecialchars($department) ?> Department
    </h2>

    <table style="width: 100%; border-collapse: collapse; background-color: white;">
        <thead style="background-color: #1b5e20; color: #fff;">
            <tr>
                <th style="padding: 10px; border: 1px solid #ccc;">Subject</th>
                <th style="padding: 10px; border: 1px solid #ccc;">Message</th>
                <th style="padding: 10px; border: 1px solid #ccc;">Attachment</th>
                <th style="padding: 10px; border: 1px solid #ccc;">Reply</th>
                <th style="padding: 10px; border: 1px solid #ccc;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt2 = $conn->prepare("SELECT * FROM issues WHERE from_role = 'COE' AND to_dept = ? ORDER BY created_at DESC");
            $stmt2->bind_param("s", $department);
            $stmt2->execute();
            $result2 = $stmt2->get_result();

            if ($result2->num_rows > 0) {
                while ($row = $result2->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td style='padding: 10px; border: 1px solid #ccc;'>" . htmlspecialchars($row['subject']) . "</td>";
                    echo "<td style='padding: 10px; border: 1px solid #ccc;'>" . htmlspecialchars($row['message']) . "</td>";

                    if (!empty($row['attachment'])) {
                        echo "<td style='padding: 10px; border: 1px solid #ccc;'><a href='../../uploads/" . urlencode($row['attachment']) . "' target='_blank'>View</a></td>";
                    } else {
                        echo "<td style='padding: 10px; border: 1px solid #ccc;'>No Attachment</td>";
                    }

                    echo "<td style='padding: 10px; border: 1px solid #ccc;'>";
                    if (!empty($row['reply'])) {
                        echo htmlspecialchars($row['reply']);
                        if (!empty($row['reply_attachment'])) {
                            echo "<br><a href='../../uploads/" . urlencode($row['reply_attachment']) . "' target='_blank'>View Reply File</a>";
                        }
                    } else {
                        echo "<span style='color:#888;'>Not yet replied</span>";
                    }
                    echo "</td>";

                    echo "<td style='padding: 10px; border: 1px solid #ccc;'>";
                    if (empty($row['reply'])) {
                        echo "<form method='POST' action='reply_to_query.php' enctype='multipart/form-data'>
                                <input type='hidden' name='issue_id' value='" . $row['id'] . "'>
                                <textarea name='reply' required placeholder='Enter reply' style='width: 100%; height: 60px;'></textarea><br>
                                <input type='file' name='reply_attachment'><br><br>
                                <button type='submit' class='btn-green'>Send Reply</button>
                              </form>";
                    } else {
                        echo "Reply sent.";
                    }
                    echo "</td>";

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='text-align:center; padding: 20px; color: #888;'>No queries received from COE.</td></tr>";
            }

            $stmt2->close();
            ?>
        </tbody>
    </table>
    <br>
    <br>
    <br>
    <br>
    <br>
</div>

<?php 
include '../../includes/footer.php'; 
?>
