<?php
if (isset($_GET['ticket_id']) && isset($_GET['customer_id'])) {
  $ticketID = $_GET['ticket_id'];
  $customerID = $_GET['customer_id'];

  // Establish a database connection (replace these values with your actual database credentials)
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

  /* SQL query to delete the registered concert for the specified customer
  $delete_query = "DELETE FROM Orders 
                   WHERE Customer_ID = $customerID 
                   AND Purchase_ID IN (
                     SELECT Ticket_ID 
                     FROM Tickets 
                     WHERE Concert_ID = $concertID
                   )";*/
    $delete_query = "DELETE FROM Orders 
                     WHERE Customer_ID = $customerID 
                     AND Purchase_ID = $ticketID
                     LIMIT 1";

  if ($conn->query($delete_query) === TRUE) {
    // Redirect back to the customer dashboard after successful cancellation
    header("Location: customer_dashboard.php?customer_ID=$customerID");
    exit();
  } else {
    echo "Error canceling registration: " . $conn->error;
  }

  // Close connection
  $conn->close();
} else {
  // Handle the case when concert_id or customer_id is not provided
  echo "Invalid request";
}
?>
