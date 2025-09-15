<?php
session_start();
require '../php/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: ../php/admin-dashboard.php");
            } else {
                header("Location: ../php/dashboard.php");
            }
            exit();
        } else {
            // Redirect with error message
            header("Location: ../login.html?error=" . urlencode("Invalid password."));
            exit();
        }
    } else {
        // Redirect with error message
        header("Location: ../login.html?error=" . urlencode("User not found."));
        exit();
    }
}
?>
