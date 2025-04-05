<?php
require 'db.php'; // Database connection

$new_password = password_hash("123456", PASSWORD_BCRYPT);
$sql = "UPDATE users SET password='$new_password' WHERE username='admin'";

if (mysqli_query($conn, $sql)) {
    echo "Admin password has been reset to 123456!";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
