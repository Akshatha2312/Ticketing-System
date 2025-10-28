<?php
session_start();
require 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];  // Should be HOD, STAFF, or COE

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND role = ?");
    $stmt->bind_param("ss", $username, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if ($user['password'] === $password) {
            // Set session variables
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['department'] = $user['department'];

            // Redirect by role
            if ($role === 'HOD') {
                header("Location: dashboard/hod/dashboard.php");
            } elseif ($role === 'STAFF') {
                header("Location: dashboard/staff/dashboard.php");
            } elseif ($role === 'COE') {
                header("Location: dashboard/coe/dashboard.php");
            }
            exit();
        } else {
            echo "<script>alert('Incorrect password.'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('Incorrect username or role.'); window.location='login.php';</script>";
    }

    $stmt->close();
}
?>
