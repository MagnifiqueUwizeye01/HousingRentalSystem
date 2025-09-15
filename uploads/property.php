<?php

$message = "";

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
            mkdir($targetDir, 0777, true); // Create uploads folder if not exists
        }

        $filename = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . time() . "_" . $filename;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Basic validation
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                $image = basename($targetFilePath); // Save filename only
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
  <link rel="stylesheet" href="../css/styles.css" />
</head>
<body>
  <div class="dashboard-container">
    <h2>Post a New Property</h2>

    <?php if (!empty($message)): ?>
      <div class="toast"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form action="post-property.php" method="POST" enctype="multipart/form-data">
      <label>Title:</label>
      <input type="text" name="title" required>

      <label>Description:</label>
      <textarea name="description" rows="4" required></textarea>
      <label>Type:</label>
      <select name="type" required>
        <option value="">Select Type</option>
        <option value="rent">Rent</option>
        <option value="sale">Sale</option>
      </select>

      <label>Price:</label>
      <input type="number" name="price" required>

      <label>Location:</label>
      <input type="text" name="location" required>

      <label>Contact Phone:</label>
      <input type="text" name="contact_phone" required>

      <label>Property Image:</label>
      <input type="file" name="image" accept="image/*" required>

      <button type="submit" class="btn">Submit Property</button>
    </form>

    <a href="dashboard.php" class="btn back">Back to Dashboard</a>
  </div>
</body>
</html>
