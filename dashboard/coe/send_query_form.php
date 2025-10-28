<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'COE') {
    header('Location: ../../login.php');
    exit();
}
include '../../includes/header.php';
?>

<!-- COE NAVBAR -->
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
<div>
  <br>
</div>

<?php if (isset($_GET['submitted']) && $_GET['submitted'] == 'true'): ?>
  <div style="color: green; margin-bottom: 10px; font-weight: bold;">
    Query sent successfully!
  </div>
<?php endif; ?>

<!-- QUERY FORM SECTION -->
<div class="page-wrapper">
  <main class="content">
    <div class="center-box">
      <h2 class="section-title">Send Query to HOD</h2>
      <form method="POST" action="submit_query.php" enctype="multipart/form-data">

        <div class="form-group">
          <label for="department">Select Department</label>
          <select name="department" id="department" class="form-control" required>
            <option value="">-- Select --</option>
            <option value="CSE">CSE</option>
            <option value="ECE">ECE</option>
            <option value="IT">IT</option>
            <option value="AIML">AIML</option>
            <option value="CYBER">CYBER</option>
            <option value="AIDS">AIDS</option>
            <option value="EEE">EEE</option>
            <option value="MECH">MECH</option>
            <option value="CIVIL">CIVIL</option>
            <option value="AGRI">AGRI</option>
            <option value="FOODTECH">FOODTECH</option>
            <option value="BIOTECH">BIOTECH</option>
            <option value="BIOMEDICAL">BIOMEDICAL</option>
            <option value="VLSI">VLSI</option>
          </select>
        </div>

        <div class="form-group">
          <label for="subject">Subject</label>
          <input type="text" name="subject" id="subject" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="message">Message</label>
          <textarea name="message" id="message" rows="5" class="form-control" required></textarea>
        </div>

        <div class="form-group">
          <label for="attachment">Attachment (optional)</label>
          <input type="file" name="attachment" id="attachment" class="form-control">
        </div>

        <div class="form-group text-center">
          <button type="submit" class="btn-green">Send Query</button>
        </div>
      </form>
    </div>
  </main>
</div>


<?php include '../../dashboard/coe/view_queries.php'; ?>

<?php include '../../includes/footer.php'; ?>
