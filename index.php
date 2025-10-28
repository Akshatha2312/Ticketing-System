<?php include("includes/header.php"); ?>

<div class="page-wrapper">
  <section id="hero" class="hero-section">
    <h1>OFFICE OF THE CONTROLLER OF EXAMINATIONS</h1>
  </section>

  <section id="about-exam-cell" class="about-section">
    <div class="container">
      <p>
        The Office of the Controller of Examinations at Sri Shakthi Institute of Engineering and Technology is responsible for the fair and efficient conduct of examinations. It ensures timely publishing of results, facilitates re-evaluation processes, and maintains academic records with transparency and integrity.
      </p>
    </div>
  </section>

  <section id="announcements" class="announcement-section">
    <h2>📂 Public Announcements</h2>
    <div class="container">
      <?php
      include 'config/db.php';
      $query = "SELECT * FROM announcements ORDER BY created_at DESC";
      $result = $conn->query($query);

      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo "<div class='announcement-card'>";
              echo "<h4>{$row['title']}</h4>";
              if (!empty($row['message'])) {
                  echo "<p>{$row['message']}</p>";
              }
              if (!empty($row['file_path'])) {
                  echo "<a href='uploads/{$row['file_path']}' target='_blank' class='btn btn-green'>View/Download File</a>";
              }
              echo "<small>Posted on " . date("d M Y, h:i A", strtotime($row['created_at'])) . "</small>";
              echo "</div>";
          }
      } else {
          echo "<p class='no-announcements'>No announcements available at the moment.</p>";
      }
      ?>
    </div>
  </section>
</div>

<?php include("includes/footer.php"); ?>
