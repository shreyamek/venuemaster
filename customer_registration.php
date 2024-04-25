<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "venue_master_db";

// Retrieve the submitted customer details
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$phone_number = $_POST['phone_number'];
$email = $_POST['email'];
$u_password = $_POST['password'];

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Prepare the SQL statement to insert the customer details into the Customer table
    $stmt = $pdo->prepare("INSERT INTO Customer (Firstname, Lastname, Phone_Number, Email, Password) VALUES (?, ?, ?, ?, ?)");

    // Execute the prepared statement with the customer details
    $stmt->execute([$firstname, $lastname, $phone_number, $email, $u_password]);

    // Get the last inserted customer ID
    $customer_ID = $pdo->lastInsertId();

    // Registration successful, redirect to the customer dashboard with the customer ID
    header("Location: customer_dashboard.php?id=$customer_ID");
    exit();
} catch (PDOException $e) {
    // Handle database errors
    echo "Database error: " . $e->getMessage();
}
?>
