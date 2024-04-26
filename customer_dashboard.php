<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      padding: 20px;
    }
    h1 {
      color: #333;
      text-align: center;
    }
    .dashboard {
      max-width: 1000px;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .registered-concerts,
    .past-concerts {
      margin-bottom: 30px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th,
    td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ccc;
    }
    th {
      background-color: #f2f2f2;
    }
    .action-buttons {
      display: flex;
      justify-content: flex-end;
    }
    .action-buttons button {
      margin-left: 10px;
      padding: 8px 16px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .action-buttons .cancel-button {
      background-color: #dc3545;
      color: #fff;
    }
    .action-buttons .review-button {
      background-color: #007bff;
      color: #fff;
    }
    .personal-rating {
      font-weight: bold;
    }
  </style>
</head>
<body>
  <h1>Customer Dashboard</h1>
  <div class="dashboard">
    <div class="registered-concerts">
      <h2>REGISTERED CONCERTS:</h2>
      <table>
        <thead>
          <tr>
            <th>Concert Name</th>
            <th>Artist:</th>
            <th>Date:</th>
            <th>Time:</th>
            <th>Location:</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (isset($_GET['customer_ID'])) {
            $customerID = $_GET['customer_ID'];
          } else {
            // Handle the case where artist_id is not provided
            $customerID = 0; // default value or handle error
          }

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

          // SQL query to fetch registered concerts for the specified customer and with date greater than current date
          $registered_concerts_query = "SELECT Orders.Purchase_ID, Concert.Concert_ID, Concert.Concert_Name, Artists.Artist_Name, Concert.Date, Concert.Time, Concert.Location, Tickets.Ticket_ID
                                        FROM Concert
                                        INNER JOIN Artists ON Artists.Artist_ID = Concert.Artist_ID
                                        INNER JOIN Tickets ON Tickets.Concert_ID = Concert.Concert_ID
                                        INNER JOIN Orders ON Orders.Purchase_ID = Tickets.Purchase_ID
                                        WHERE Orders.Customer_ID = $customerID AND Concert.Date > CURRENT_DATE";
          $registered_concerts_result = $conn->query($registered_concerts_query);

          if ($registered_concerts_result->num_rows > 0) {
            while ($row = $registered_concerts_result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row["Concert_Name"] . "</td>";
              echo "<td>" . $row["Artist_Name"] . "</td>";
              echo "<td>" . $row["Date"] . "</td>";
              echo "<td>" . $row["Time"] . "</td>";
              echo "<td>" . $row["Location"] . "</td>";
              echo "<td><a href='cancel_registration.php?ticket_id=" . $row["Purchase_ID"] . "&customer_id=" . $customerID . "' class='action-buttons'><button class='cancel-button'>Cancel</button></a></td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='6'>No registered concerts</td></tr>";
          }

          // Close connection
          $conn->close();
          ?>
        </tbody>
      </table>
    </div>
    <div class="past-concerts">
      <h2>PAST CONCERTS:</h2>
      <table>
        <thead>
          <tr>
            <th>Concert Name</th>
            <th>Artist:</th>
            <th>Date:</th>
            <th>Time:</th>
            <th>Location:</th>
            <th>Personal Rating:</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (isset($_GET['customer_ID'])) {
            $customerID = $_GET['customer_ID'];
          } else {
            // Handle the case where artist_id is not provided
            $customerID = 0; // default value or handle error
          }

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

          // SQL query to fetch registered concerts for the specified customer and with date less than current date
          $registered_concerts_query = "SELECT Concert.Concert_Name, Artists.Artist_Name, Concert.Date, Concert.Time, Concert.Location
                                        FROM Concert
                                        INNER JOIN Artists ON Artists.Artist_ID = Concert.Artist_ID
                                        INNER JOIN Tickets ON Tickets.Concert_ID = Concert.Concert_ID
                                        INNER JOIN Orders ON Orders.Purchase_ID = Tickets.Ticket_ID
                                        WHERE Orders.Customer_ID = $customerID AND Concert.Date < CURRENT_DATE";
          $registered_concerts_result = $conn->query($registered_concerts_query);

          if ($registered_concerts_result->num_rows > 0) {
            while ($row = $registered_concerts_result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row["Concert_Name"] . "</td>";
              echo "<td>" . $row["Artist_Name"] . "</td>";
              echo "<td>" . $row["Date"] . "</td>";
              echo "<td>" . $row["Time"] . "</td>";
              echo "<td>" . $row["Location"] . "</td>";
              echo "<td><span class='personal-rating'>4.5</span></td>";
              echo "<td><div class='action-buttons'><button class='review-button'>Review</button></div></td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='7'>No past concerts</td></tr>";
          }

          // Generate the link to purchase_ticket.php with customer ID in the URL parameters
          // Close connection
          $conn->close();
          ?>
        </tbody>
      </table>
      <p></p>
      <p></p>
      <?php
      if (isset($_GET['customer_ID'])) {
        $customerID = $_GET['customer_ID'];
      } else {
        // Handle the case where artist_id is not provided
        $customerID = 0; // default value or handle error
      }
      echo "<a href='purchase_ticket.php?id=" . $customerID . "'>Purchase Tickets</a>";
      ?>
    </div>
    <!-- Link to purchase_ticket.php with customer ID included -->
  </div>
</body>
</html>
