<?php
session_start();
require 'db.php';
require 'user-auth.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['user', 'admin'])) {
    header("Location: login.html");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid request.");
}

$propertyId = intval($_GET['id']);
$role = $_SESSION['role'];
$userId = $_SESSION['user_id'];

// If user: check ownership. If admin: skip check
if ($role === 'user') {
    $query = "SELECT * FROM properties WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ii", $propertyId, $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) !== 1) {
        echo "You are not allowed to delete this property.";
        exit();
    }
}

// Now proceed to delete (allowed for admin or user who owns it)
$deleteQuery = "DELETE FROM properties WHERE id = ?";
$deleteStmt = mysqli_prepare($con, $deleteQuery);
mysqli_stmt_bind_param($deleteStmt, "i", $propertyId);
mysqli_stmt_execute($deleteStmt);
mysqli_stmt_close($deleteStmt);

// Redirect appropriately
if ($role === 'admin') {
    header("Location: manage-properties.php?deleted=1");
} else {
    header("Location: view-my-properties.php?deleted=1");
}
exit();
?>
