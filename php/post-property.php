<?php

require 'db.php';
require 'user-auth.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.html");
    exit();
}

$message = "";

// Show message only after POST submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $contact = $_POST['contact_phone'];

    // Handle Image Upload
    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $filename = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . time() . "_" . $filename;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                $image = basename($targetFilePath);
            } else {
                $message = "❌ Failed to upload image.";
            }
        } else {
            $message = "❌ Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    }

    if (empty($message)) {
        $query = "INSERT INTO properties (user_id, title, description, image, type, price, location, contact_phone)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "issssdss", $user_id, $title, $desc, $image, $type, $price, $location, $contact);

        if (mysqli_stmt_execute($stmt)) {
            $message = "✅ Property posted successfully!";
        } else {
            $message = "❌ Error: " . mysqli_error($con);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Post New Property</title>
  <link rel="stylesheet" href="../css/post-property.css" />
</head>
<body>
  <div class="form-wrapper">
    <h2>Post a New Property</h2>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($message)): ?>
      <div class="toast"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form action="post-property.php" method="POST" enctype="multipart/form-data">
      <label for="title">Title</label>
      <input type="text" name="title" id="title" required>

      <label for="description">Description</label>
      <textarea name="description" id="description" rows="4" required></textarea>

      <label for="type">Type</label>
      <select name="type" id="type" required>
        <option value="">Select Type</option>
        <option value="rent">Rent</option>
        <option value="sale">Sale</option>
      </select>

      <label for="price">Price</label>
      <input type="number" name="price" id="price" required>

      <label for="location">Location</label>
      <input type="text" name="location" id="location" required>

      <label for="contact_phone">Contact Phone</label>
      <input type="text" name="contact_phone" id="contact_phone" required>

      <label for="image">Property Image</label>
      <input type="file" name="image" id="image" accept="image/*" required>

      <button type="submit" class="btn-submit">Submit Property</button>
    </form>

    <a href="dashboard.php" class="btn-back">Back to Dashboard</a>
  </div>
</body>
</html>
