<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "venue_master_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted
// Check if the ticket_type parameter is set in the URL
if (isset($_GET['ticket_type']) && isset($_GET['id'])) {
    $ticket_type = $_GET['ticket_type'];
    $customer_ID = $_GET['id'];
    // Proceed with processing the ticket type...

    // Fetch next available ticket for the selected type
    $sql_next_ticket = "SELECT Ticket_ID FROM Tickets WHERE Ticket_Type = '$ticket_type' AND Availability = 1 LIMIT 1";
    $result_next_ticket = $conn->query($sql_next_ticket);

    if ($result_next_ticket->num_rows > 0) {
        // Retrieve the Ticket_ID of the next available ticket
        $row = $result_next_ticket->fetch_assoc();
        $next_ticket_id = $row['Ticket_ID'];

        // Insert data into Orders table
        $purchase_date = date("Y-m-d H:i:s");
        $sql_insert_order = "INSERT INTO Orders (Purchase_Date, Customer_ID) VALUES ('$purchase_date', '$customer_ID')";
        
        if ($conn->query($sql_insert_order) === TRUE) {
            $purchase_id = $conn->insert_id;

            // Update Availability of the selected ticket type to 0
            $sql_update_availability = "UPDATE Tickets SET Availability = 0 WHERE Ticket_ID = '$next_ticket_id'";
            if ($conn->query($sql_update_availability) === TRUE) {
                // Update Purchase_ID of the ticket
                $sql_update_ticket_purchase_id = "UPDATE Tickets SET Purchase_ID = '$purchase_id' WHERE Ticket_ID = '$next_ticket_id'";
                if ($conn->query($sql_update_ticket_purchase_id) === TRUE) {
                    echo "Ticket purchased successfully!";
                } else {
                    echo "Error updating ticket purchase ID: " . $conn->error;
                }
            } else {
                echo "Error updating availability: " . $conn->error;
            }
        } else {
            echo "Error inserting order: " . $conn->error;
        }
    } else {
        echo "No available tickets of the selected type.";
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Confirmation</title>
    <style>
        .return-button {
            display: inline-block;
            margin: 10px auto 0;
            background-color: #333; /* Adjust color as needed */
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
        }

        .return-button:hover {
            background-color: #555; /* Adjust hover color as needed */
        }
    </style>
</head>

<body>
    <!-- Your existing HTML content -->

    <h2> Your ticket was successfully purchased!</h2>
    <a href="customer_dashboard.php?id=<?php echo $id; ?>" class="return-button">Return to Customer Dashboard</a>
</body>

</html>
