<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'COE') {
    header('Location: ../../login.php');
    exit();
}

include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $department = $_POST['department'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $from_role = 'COE';

    // File upload handling
    $attachment = '';
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../uploads/';
        $attachment = basename($_FILES['attachment']['name']);
        move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadDir . $attachment);
    }

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO issues (from_role, to_dept, subject, message, attachment) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $from_role, $department, $subject, $message, $attachment);
    $stmt->execute();
    $stmt->close();
}

// Redirect back to the form page to avoid form re-submission on refresh (PRG pattern)
// header('Location: send_query_form.php');
header('Location: send_query_form.php?submitted=true');
exit();
