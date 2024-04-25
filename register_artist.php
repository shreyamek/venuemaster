<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "venue_master_db";

// Retrieve the submitted artist details
$artist_name = $_POST['artist_name'];
$email = $_POST['email'];
$u_password = $_POST['password'];

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Prepare the SQL statement to insert the artist details into the Artists table
    $stmt = $pdo->prepare("INSERT INTO Artists (Artist_Name, Email, Password) VALUES (?, ?, ?)");

    // Execute the prepared statement with the artist details
    $stmt->execute([$artist_name, $email, $u_password]);

    // Get the last inserted artist ID
    $artist_ID = $pdo->lastInsertId();

    // Registration successful, redirect to the artist dashboard with the artist ID
    header("Location: artist_dashboard.php?id=$artist_ID");
    exit();
} catch (PDOException $e) {
    // Handle database errors
    echo "Database error: " . $e->getMessage();
}
?>
