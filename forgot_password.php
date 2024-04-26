<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "venue_master_db";

// Retrieve the submitted email, current password, and new password
$email = $_POST['email'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];

//$conn = new mysqli("localhost", "root", "", "venue_master_db");

$sql = "UPDATE Artists SET Password='$new_password' WHERE Email='$email' and Password='$current_password'";

$result = $conn->query($sql);

if ($conn->affected_rows > 0) {
    echo "Password has been reset successfully.";
} else {
    echo "Failed to reset password. Please check your email and current password.";
}

$conn->close();
?>