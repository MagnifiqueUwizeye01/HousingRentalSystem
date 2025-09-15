<?php
session_start();
require '../php/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $phone    = trim($_POST['phone']);

    // Basic validation
    if (empty($fullname) || empty($username) || empty($email) || empty($password) || empty($phone)) {
        header("Location: ../register.html?error=" . urlencode("All fields are required."));
        exit();
    }

    // Hash password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if username or email already exists
    $checkQuery = "SELECT id FROM users WHERE username = ? OR email = ?";
    $stmt = mysqli_prepare($con, $checkQuery);
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        header("Location: ../register.html?error=" . urlencode("Username or email already exists."));
        exit();
    }

    // Insert new user
    $insertQuery = "INSERT INTO users (fullname, username, email, password, phone) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $insertQuery);
    mysqli_stmt_bind_param($stmt, "sssss", $fullname, $username, $email, $hashedPassword, $phone);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect to login page after successful registration
        header("Location: ../login.html?success=" . urlencode("Registration successful! Please login."));
    } else {
        header("Location: ../register.html?error=" . urlencode("Something went wrong. Please try again."));
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
}
?>
