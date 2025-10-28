<?php
// session_start();
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'COE') {
//     header('Location: ../../login.php');
//     exit();
// }
include '../../config/db.php';
// include '../../includes/header.php';
?>

<!-- COE NAVBAR -->
<!-- <div style="background: #f9f9f9; padding: 10px 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center;">
  <div style="font-size: 20px; font-weight: bold; color: #1b5e20;">
    COE Dashboard
  </div>
  <div>
    <a href="dashboard.php" style="margin: 0 15px; text-decoration: none; color: #333; font-weight: bold;">HOD</a>
    <a href="send_query_form.php" style="margin: 0 15px; text-decoration: none; color: #333; font-weight: bold;">COE</a>
    <a href="view_queries.php" style="margin: 0 15px; text-decoration: none; color: #333; font-weight: bold;">HOD's</a>
    <a href="publish_result_form.php" style="margin: 0 15px; text-decoration: none; color: #333; font-weight: bold;">Publish Result</a>
    <a href="../../logout.php" style="margin: 0 15px; text-decoration: none; color: #c0392b; font-weight: bold;">Logout</a>
  </div>
</div> -->


<div class="page-wrapper">
  <main class="content">
    <div class="center-box" style="max-width: 1000px;">
      <h2>Queries Sent to HODs</h2>
      <table style="width: 100%; border-collapse: collapse;">
        <thead style="background-color: #1b5e20; color: #fff;">
          <tr>
            <th>Department</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Attachment</th>
            <th>Reply</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $stmt = $conn->prepare("SELECT * FROM issues WHERE from_role = 'COE' ORDER BY created_at DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['to_dept']}</td>";
                echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
                echo "<td>" . htmlspecialchars($row['message']) . "</td>";
                echo "<td>";
                if (!empty($row['attachment'])) {
                    echo "<a href='../../uploads/{$row['attachment']}' target='_blank'>View</a>";
                } else {
                    echo "None";
                }
                echo "</td>";
                echo "<td>";
                if (!empty($row['reply'])) {
                    echo htmlspecialchars($row['reply']);
                    if (!empty($row['reply_attachment'])) {
                        echo "<br><a href='../../uploads/{$row['reply_attachment']}' target='_blank'>View File</a>";
                    }
                } else {
                    echo "<span style='color: gray;'>No reply yet</span>";
                }
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5' style='text-align:center;'>No queries sent.</td></tr>";
        }
        ?>
        </tbody>
      </table>
    </div>
  </main>
</div>

<!-- include '../../includes/footer.php'; ?> -->
