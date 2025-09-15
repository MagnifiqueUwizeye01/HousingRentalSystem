<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);

    // Optional: First delete properties linked to this user
    $con->query("DELETE FROM properties WHERE user_id = $user_id");

    $stmt = $con->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        header("Location: manage-users.php?msg=User+deleted+successfully");
        exit();
    } else {
        echo "Error deleting user.";
    }

    $stmt->close();
} else {
    echo "Invalid user ID.";
}
?>
