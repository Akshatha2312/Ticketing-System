<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'HOD') {
    header('Location: ../../login.php');
    exit();
}

include '../../config/db.php';
include '../../includes/header.php';

$department = $_SESSION['department'];
$issue_id = isset($_GET['issue_id']) ? intval($_GET['issue_id']) : 0;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $reply = trim($_POST['reply']);
    $issue_id = intval($_POST['issue_id']);
    $reply_attachment = "";

    // Handle attachment if present
    if (isset($_FILES['reply_attachment']) && $_FILES['reply_attachment']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = "../../uploads/";
        $original_name = basename($_FILES['reply_attachment']['name']);
        $safe_name = time() . "_" . preg_replace("/[^a-zA-Z0-9.\-_]/", "_", $original_name);
        $target_file = $upload_dir . $safe_name;

        if (move_uploaded_file($_FILES['reply_attachment']['tmp_name'], $target_file)) {
            $reply_attachment = $safe_name;
        }
    }

    // Update issue if it was sent by COE to this department
    $stmt = $conn->prepare("UPDATE issues SET reply = ?, reply_attachment = ?, status = 'Completed' WHERE id = ? AND from_role = 'COE' AND to_dept = ?");
    $stmt->bind_param("ssis", $reply, $reply_attachment, $issue_id, $department);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Reply successfully sent to COE.";
    } else {
        $_SESSION['error'] = "Failed to send reply: " . $stmt->error;
    }

    header("Location: dashboard.php?view=queries");
    exit();
}
?>

<!-- === Reply Form === -->
<div class="page-wrapper">
  <main class="content" style="margin-top: 100px;">
    <div class="center-box" style="max-width: 700px;">
      <h2 style="margin-bottom: 20px;">Reply to COE Query</h2>

      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="issue_id" value="<?= htmlspecialchars($issue_id) ?>">

        <div class="form-group">
          <label>Your Reply</label>
          <textarea name="reply" rows="5" required style="width: 100%; padding: 10px;"></textarea>
        </div>

        <div class="form-group" style="margin-top: 10px;">
          <label>Attachment (optional)</label>
          <input type="file" name="reply_attachment" accept=".pdf,.jpg,.jpeg,.png" style="margin-top: 5px;">
        </div>

        <div class="form-group" style="margin-top: 20px;">
          <button type="submit" class="btn-green" style="padding: 10px 20px;">Send Reply</button>
        </div>
      </form>
    </div>
  </main>
</div>

<?php include '../../includes/footer.php'; ?>
