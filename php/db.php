<?php
$con = mysqli_connect("127.0.0.1", "root", "", "housing_rental_db", 3307);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
