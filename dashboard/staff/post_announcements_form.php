<?php
// session_start();
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'STAFF') {
//     header('Location: ../../login.php');
//     exit();
// }
include '../../config/db.php';
// include '../../includes/header.php';
?>

<!-- STAFF DASHBOARD NAVBAR -->

<div style="background: #f9f9f9; padding: 10px 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center;">
  <div style="font-size: 20px; font-weight: bold; color: #1b5e20;">
    Staff Dashboard
  </div>
  <div>
    <a href="dashboard.php" style="margin: 0 15px; text-decoration: none; color: #333; font-weight: bold;">Home</a>
    <!-- <a href="post_announcements_form.php" style="margin: 0 15px; text-decoration: none; color: #333; font-weight: bold;">Post Announcement</a>
    <a href="view_announcements.php" style="margin: 0 15px; text-decoration: none; color: #333; font-weight: bold;">View Announcements</a> -->
    <a href="../../logout.php" style="margin: 0 15px; text-decoration: none; color: #c0392b; font-weight: bold;">Logout</a>
  </div>
</div>


<main class="content">
    <div class="center-box" style="max-width: 700px; margin-top: 30px;">
        <h2>Post New Announcement</h2>
        <form action="post_announcement.php" method="POST" enctype="multipart/form-data">
            <label>Title*</label>
            <input type="text" name="title" required class="form-control"><br>

            <label>Message</label>
            <textarea name="message" rows="3" class="form-control"></textarea><br>

            <label>Attach File (PDF/Image)</label>
            <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png" class="form-control"><br>

            <button type="submit" class="btn btn-success">Post</button>
        </form>
    </div>
</main>

<!-- <?php include '../../includes/footer.php'; ?> -->

