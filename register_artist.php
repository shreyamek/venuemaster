<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "venue_master_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    

    $artist_name = $first_name . ' ' . $last_name;

    // Perform validation/sanitization if needed

    // Insert data into database
    $sql = "INSERT INTO Artist (Artist_Name) VALUES ('$artist_name')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>