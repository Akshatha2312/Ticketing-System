<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'HOD') {
    header('Location: ../../login.php');
    exit();
}

include '../../config/db.php';
include '../../includes/header.php';

$department = $_SESSION['department'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $attachment = "";
    if (!empty($_FILES['attachment']['name'])) {
        $target_dir = "../../uploads/";
        $attachment = basename($_FILES["attachment"]["name"]);
        $target_file = $target_dir . $attachment;
        move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file);
    }

    $stmt = $conn->prepare("INSERT INTO issues (from_role, from_dept, subject, message, attachment, status) VALUES ('HOD', ?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("ssss", $department, $subject, $message, $attachment);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Issue submitted successfully!";
    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
    }
    $stmt->close();
    header("Location: dashboard.php");
    exit();
}
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


<!-- HTML FORM -->
<div class="page-wrapper">
  <main class="content">
    <section class="center-box">
      <h2>Submit an Issue to COE</h2>

      <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label>Subject</label>
          <input type="text" name="subject" required>
        </div>

        <!-- <div class="form-group">
          <label>Message</label>
          <input type="text" rows="5" name="subject" required>
          <textarea name="message" rows="6" required></textarea>
        </div> -->

        <div class="form-group">
          <label for="message">Message</label>
          <textarea name="message" id="message" rows="5" class="form-control" required></textarea>
        </div>

        <div class="form-group">
          <label>Attachment (optional)</label>
          <input type="file" name="attachment">
        </div>

        <div class="form-group">
          <button type="submit">Submit Issue</button>
        </div>
      </form>
    </section>
  </main>
</div>

<?php include 'view_queries.php'; ?>

<?php include '../../includes/footer.php'; ?>
