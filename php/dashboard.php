<?php

require 'db.php';
require 'user-auth.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>User Dashboard - Housing & Rental System</title>
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<div class="dashboard-wrapper dashboard-page no-scroll">
    <div class="dashboard-container">
      <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> </h2>
      <p>This is your dashboard. From here, you can manage your listed properties.</p>

      <div class="dashboard-actions">
  <div class="card"><a href="post-property.php" class="btn">Post New Property</a></div>
  <div class="card"><a href="view-my-properties.php" class="btn">View My Properties</a></div>
  <div class="card"><a href="browse-properties.php" class="btn">Browse All Properties</a></div>
  <div class="card"><a href="../homepage.php" class="btn">Go to Homepage</a></div>
  <div class="card"><a href="logout.php" class="btn logout">Logout</a></div>
</div>

    </div>
  </div>
</body>
</html>
