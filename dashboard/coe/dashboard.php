<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'COE') {
    header('Location: ../../login.php');
    exit();
}

include '../../config/db.php';
include '../../includes/header.php';
?>

<!-- COE Navigation Bar -->
<div style="background: #f9f9f9; padding: 10px 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center;">
  <div style="font-size: 20px; font-weight: bold; color: #1b5e20;">
    COE Dashboard
  </div>
  <div>
    <a href="dashboard.php" style="margin: 0 15px; text-decoration: none; color: #333; font-weight: bold;">HOD</a>
    <a href="send_query_form.php" style="margin: 0 15px; text-decoration: none; color: #333; font-weight: bold;">COE</a>
    <!-- <a href="view_queries.php" style="margin: 0 15px; text-decoration: none; color: #333; font-weight: bold;">HOD's</a> -->
    <a href="publish_result_form.php" style="margin: 0 15px; text-decoration: none; color: #333; font-weight: bold;">Publish Result</a>
    <a href="../../logout.php" style="margin: 0 15px; text-decoration: none; color: #c0392b; font-weight: bold;">Logout</a>
  </div>
</div>


<div class="page-wrapper">
  <main class="content">
    <div class="center-box" style="max-width: 1000px; width: 100%; text-align: left;">
      <h2 style="text-align:center; margin-bottom: 30px; color: #1b5e20;">HOD Submitted Issues - COE Dashboard</h2>

      <table style="width: 100%; border-collapse: collapse;">
        <thead style="background-color: #1b5e20; color: white;">
          <tr>
            <th style="padding: 10px; border: 1px solid #ccc;">Department</th>
            <th style="padding: 10px; border: 1px solid #ccc;">Subject</th>
            <th style="padding: 10px; border: 1px solid #ccc;">Message</th>
            <th style="padding: 10px; border: 1px solid #ccc;">Attachment</th>
            <th style="padding: 10px; border: 1px solid #ccc;">Status</th>
            <th style="padding: 10px; border: 1px solid #ccc;">Reply</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = "SELECT * FROM issues WHERE from_role = 'HOD' ORDER BY created_at DESC";
          $result = $conn->query($query);

          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td style='padding: 10px; border: 1px solid #ccc;'>" . htmlspecialchars($row['from_dept']) . "</td>";
                  echo "<td style='padding: 10px; border: 1px solid #ccc;'>" . htmlspecialchars($row['subject']) . "</td>";
                  echo "<td style='padding: 10px; border: 1px solid #ccc;'>" . htmlspecialchars($row['message']) . "</td>";

                  if (!empty($row['attachment'])) {
                      echo "<td style='padding: 10px; border: 1px solid #ccc;'><a href='../../uploads/" . urlencode($row['attachment']) . "' target='_blank'>View</a></td>";
                  } else {
                      echo "<td style='padding: 10px; border: 1px solid #ccc;'>No Attachment</td>";
                  }

                  echo "<td style='padding: 10px; border: 1px solid #ccc;'>" . htmlspecialchars($row['status']) . "</td>";

                  echo "<td style='padding: 10px; border: 1px solid #ccc;'>";
                  echo "<form method='POST' action='reply_to_issue.php' enctype='multipart/form-data'>";
                  echo "<input type='hidden' name='issue_id' value='" . $row['id'] . "'>";
                  echo "<textarea name='reply' required placeholder='Write reply...' style='width: 100%;'></textarea><br>";
                  echo "<input type='file' name='reply_attachment'><br><br>";
                  echo "<select name='status' style='width: 100%; padding: 6px; border-radius: 5px;'>";
                  echo "<option value='Pending'" . ($row['status'] == 'Pending' ? ' selected' : '') . ">Pending</option>";
                  echo "<option value='In Progress'" . ($row['status'] == 'In Progress' ? ' selected' : '') . ">In Progress</option>";
                  echo "<option value='Resolved'" . ($row['status'] == 'Resolved' ? ' selected' : '') . ">Resolved</option>";
                  echo "</select><br><br>";
                  echo "<button type='submit' class='btn-green'>Send Reply</button>";
                  echo "</form>";
                  echo "</td>";

                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='6' style='text-align:center; padding: 20px; color: #888;'>No issues submitted by HODs.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>
</div>

<?php include '../../includes/footer.php'; ?>