<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'COE') {
    header('Location: ../../login.php');
    exit();
}

include '../../config/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $issue_id = $_POST['issue_id'];
    $reply = trim($_POST['reply']);
    $status = $_POST['status'];
    $reply_attachment = "";

    // Handle file upload
    if (!empty($_FILES['reply_attachment']['name'])) {
        $upload_dir = "../../uploads/";
        $reply_attachment = basename($_FILES["reply_attachment"]["name"]);
        $target_path = $upload_dir . $reply_attachment;

        if (!move_uploaded_file($_FILES["reply_attachment"]["tmp_name"], $target_path)) {
            echo "❌ File upload failed!";
            exit();
        }
    }

    // Update issue
    $stmt = $conn->prepare("UPDATE issues SET reply = ?, reply_attachment = ?, status = ? WHERE id = ?");
    $stmt->bind_param("sssi", $reply, $reply_attachment, $status, $issue_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "❌ Error updating issue: " . $stmt->error;
    }

    $stmt->close();
}
?>
