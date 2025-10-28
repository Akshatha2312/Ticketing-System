<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'STAFF') {
    header('Location: ../../login.php');
    exit();
}

include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $message = trim($_POST['message']);
    $posted_by = $_SESSION['username'];
    $file_path = '';

    if (!empty($_FILES['file']['name'])) {
        $allowed_types = ['pdf', 'jpg', 'jpeg', 'png'];
        $file_info = pathinfo($_FILES['file']['name']);
        $file_ext = strtolower($file_info['extension']);
        $file_size = $_FILES['file']['size'];

        if (in_array($file_ext, $allowed_types) && $file_size <= 5 * 1024 * 1024) {
            $fileName = time() . '_' . basename($_FILES['file']['name']);
            $targetDir = "../../uploads/";
            $targetPath = $targetDir . $fileName;

            if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
                $file_path = $fileName;
            }
        }
    }

    $stmt = $conn->prepare("INSERT INTO announcements (title, message, file_path, posted_by) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $message, $file_path, $posted_by);
    $stmt->execute();

    header("Location: dashboard.php");
    exit();
}
?>

