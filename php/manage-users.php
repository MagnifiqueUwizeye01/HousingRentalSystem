<?php
require 'auth.php'; // Centralized session + role protection
require 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Users - Admin</title>
  <link rel="stylesheet" href="../css/styles.css" />
  <style>
    @media print {
      .no-print {
        display: none;
      }
    }
  </style>
</head>
<body class="manage-users-page">
  <div class="dashboard-container">
    <h2>Registered Users</h2>
    <p>List of all users in the system.</p>

    <div class="property-list">
      <?php
      $query = "SELECT id, username, role FROM users WHERE role = 'user' ORDER BY username ASC";
      $result = mysqli_query($con, $query);

      if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              echo "<div class='property-card'>";
              echo "<p><strong>Username:</strong> " . htmlspecialchars($row['username']) . "</p>";
              echo "<p><strong>User ID:</strong> " . htmlspecialchars($row['id']) . "</p>";
              echo "<a href='delete-user.php?id=" . $row['id'] . "' class='btn small danger' onclick='return confirm(\"Delete this user?\")'>Delete User</a>";
              echo "</div>";
          }
      } else {
          echo "<p>No users found.</p>";
      }
      ?>
    </div>

    <!-- Print button added here -->
    <button onclick="window.print()" class="btn no-print">Print Users</button>

    <a href="admin-dashboard.php" class="btn back">Back to Dashboard</a>
  </div>
</body>
</html>
