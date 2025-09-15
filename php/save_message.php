<?php
require 'db.php';
require 'user-auth.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    $query = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')";

    if (mysqli_query($con, $query)) {
        header("Location: ../homepage.php?success=1");
        exit;
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>            




