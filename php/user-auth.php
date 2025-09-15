<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.html"); // Adjust path based on file location
    exit();
}
?>
