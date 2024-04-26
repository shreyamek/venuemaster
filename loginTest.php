<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "venue_master_db";

// Retrieve the submitted email and password
$email = $_POST['email'];
$u_password = $_POST['password'];

// Check if the "is_artist" checkbox is checked
$is_artist = isset($_POST['is_artist']);

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    if ($is_artist) {
        // Check the artist table for matching credentials (vulnerable to SQL injection)
        $query = "SELECT Artist_ID FROM Artists WHERE Email = '$email' AND Password = '$u_password'";
        $stmt = $pdo->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $artist_ID = $row['Artist_ID'];

        if ($artist_ID) {
            // Artist login successful, redirect to artist dashboard
            header("Location: artist_dashboard.php?id=$artist_ID");
            exit();
        }
    } else {
        // Check the customer table for matching credentials (vulnerable to SQL injection)
        $query = "SELECT Customer_ID FROM Customer WHERE Email = '$email' ";
        $stmt = $pdo->query($query);
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if any rows were returned
        if ($stmt->rowCount() == 0) {
            header("Location: errorlogin.html");
            exit(); // Terminate script execution
        }
    }

    // Login failed, redirect back to the login page with an error message
    header("Location: login.html?error=1");
    exit();
} catch (PDOException $e) {
    // Handle database connection errors
    echo "Database error: " . $e->getMessage();
}
?>
