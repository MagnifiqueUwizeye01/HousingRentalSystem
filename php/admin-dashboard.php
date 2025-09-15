<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Admin Dashboard - Housing & Rental System</title>
<link rel="stylesheet" href="../css/styles.css" />
</head>
<body class="admin-dashboard">
<div class="admin-wrapper">
<div class="dashboard-container">
<h2>Welcome Admin, <?php echo htmlspecialchars($_SESSION['username']); ?> </h2>
<p>This is the admin dashboard. You can manage all properties and users from here.</p>

<div class="dashboard-actions">
<a href="manage-properties.php" class="btn">Manage Properties</a>
<a href="manage-users.php" class="btn">Manage Users</a>
<a href="../homepage.php" class="btn">Go to Homepage</a>
<a href="logout.php" class="btn logout">Logout</a>
</div>
</div>
</div>
</body>
</html>
