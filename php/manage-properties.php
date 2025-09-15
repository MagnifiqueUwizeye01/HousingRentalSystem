<?php
require 'auth.php'; // Centralized session + role check
require 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Properties - Admin</title>
  <link rel="stylesheet" href="../css/styles.css" />
  <style>
    /* Print button hidden on print */
    @media print {
      .no-print {
        display: none !important;
      }
    }
  </style>
</head>
<body class="manage-properties-page">
  <div class="dashboard-container">
    <h2>All Properties</h2>
    <p>Review and manage all posted properties.</p>

    <!-- Print button -->
    <button class="btn no-print" onclick="window.print()">Print Properties</button>

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

              // Show image if available
              if (!empty($row['image'])) {
                  echo "<img src='../uploads/" . htmlspecialchars($row['image']) . "' alt='Property Image' style='max-width: 300px; display: block; margin-bottom: 10px;'>";
              }

              echo "<p><strong>Posted by:</strong> " . htmlspecialchars($row['username']) . "</p>";
              echo "<p>" . nl2br(htmlspecialchars($row['description'])) . "</p>";
              echo "<p><strong>Type:</strong> " . htmlspecialchars($row['type']) . "</p>";
              echo "<p><strong>Price:</strong> $" . htmlspecialchars($row['price']) . "</p>";
              echo "<p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>";
              echo "<p><strong>Contact:</strong> " . htmlspecialchars($row['contact_phone']) . "</p>";

              echo "<a href='delete-property.php?id=" . $row['id'] . "' class='btn small danger' onclick='return confirm(\"Delete this property?\")'>Delete</a>";
              echo "</div>";
          }
      } else {
          echo "<p>No properties found.</p>";
      }
      ?>
    </div>

    <a href="admin-dashboard.php" class="btn back no-print">Back to Dashboard</a>
  </div>
</body>
</html>
