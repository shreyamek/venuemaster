<?php
// Database connection details
$host = 'localhost';
$dbname = 'your_database_name';
$username = 'your_username';
$password = 'your_password';

// Retrieve the submitted email and password
$email = $_POST['email'];
$password = $_POST['password'];

// Check if the "is_artist" checkbox is checked
$is_artist = isset($_POST['is_artist']);

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    if ($is_artist) {
        // Check the artist table for matching credentials
        $stmt = $pdo->prepare("SELECT * FROM artists WHERE email = ? AND password = ?");
        $stmt->execute([$email, $password]);
        $artist = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($artist) {
            // Artist login successful, redirect to artist dashboard
            header("Location: artist_dashboard.html");
            exit();
        }
    } else {
        // Check the customer table for matching credentials
        $stmt = $pdo->prepare("SELECT * FROM customers WHERE email = ? AND password = ?");
        $stmt->execute([$email, $password]);
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($customer) {
            // Customer login successful, redirect to customer dashboard
            header("Location: customer_dashboard.html");
            exit();
        }
    }
    
    // Login failed, redirect back to the login page with an error message
    header("Location: login.html?error=1");
    exit();
} catch (PDOException $e) {
    // Handle database connection errors
    echo "Database error: " . $e->getMessage();
}
