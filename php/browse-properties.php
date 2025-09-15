<?php

require 'db.php';
require 'user-auth.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.html");
    exit();
}

$userId = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Browse Properties - Housing & Rental System</title>
  <link rel="stylesheet" href="../css/styles.css" />
</head>
<body class="properties-page">
  <div class="dashboard-container">
    <h2>Browse All Properties </h2>
    <p>See all properties listed by users. You can only modify your own listings.</p>

    <div class="property-list">
      <?php
      $query = "SELECT properties.*, users.username FROM properties 
                JOIN users ON properties.user_id = users.id 
                ORDER BY created_at DESC";
      $result = mysqli_query($con, $query);

      if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              echo "<div class='property-card'>";
              echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";

              // Show image if exists
              if (!empty($row['image'])) {
                  echo "<img src='../uploads/" . htmlspecialchars($row['image']) . "' alt='Property Image' style='max-width: 300px; display: block; margin-bottom: 10px;'>";
              }

              echo "<p><strong>Posted by:</strong> " . htmlspecialchars($row['username']) . "</p>";
              echo "<p>" . nl2br(htmlspecialchars($row['description'])) . "</p>";
              echo "<p><strong>Type:</strong> " . htmlspecialchars($row['type']) . "</p>";
              echo "<p><strong>Price:</strong> $" . htmlspecialchars($row['price']) . "</p>";
              echo "<p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>";
              echo "<p><strong>Contact:</strong> " . htmlspecialchars($row['contact_phone']) . "</p>";
              if ($row['user_id'] == $userId) {
                  echo "<a href='delete-property.php?id=" . $row['id'] . "' class='btn small danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
              }
              echo "</div>";
          }
      } else {
          echo "<p>No properties found.</p>";
      }
      ?>
    </div>

    <a href="dashboard.php" class="btn back">Back to Dashboard</a>
  </div>
</body>
</html>
