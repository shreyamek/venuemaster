<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tickets for CONCERT NAME</title>
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

		h2 {
			color: #666;
			margin-bottom: 10px;
		}

		form {
			max-width: 1000px;
			margin: 0 auto;
			background-color: #fff;
			padding: 20px;
			border-radius: 5px;
			box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
		}

		label {
			display: block;
			margin-bottom: 10px;
			color: #666;
		}

		input[type="text"],
		input[type="number"] {
			width: 50%;
			padding: 10px;
			border: 1px solid #ccc;
			border-radius: 4px;
			margin-bottom: 20px;
		}

		textarea {
			width: 100%;
			padding: 10px;
			border: 1px solid #ccc;
			border-radius: 4px;
			margin-bottom: 20px;
		}

		button {
			display: inline-block;
			margin: 10px auto 0;
			background-color: #ff0000;
			color: #fff;
			border: none;
			padding: 10px 20px;
			font-size: 16px;
			border-radius: 4px;
			cursor: pointer;
		}

		.ticket-options {
			display: flex;
			justify-content: space-between;
			margin-bottom: 20px;
		}

		.ticket-option {
			flex-basis: 22%;
			padding: 10px;
			border: 1px solid #ccc;
			border-radius: 4px;
			text-align: center;
			cursor: pointer;
		}

		.ticket-option.selected {
			background-color: #ff0000;
			color: #fff;
		}

		.payment-info {
			margin-top: 40px;
		}

		.form-actions {
			display: flex;
			justify-content: flex-end;
			margin-top: 20px;
		}
	</style>
</head>

<body>
	<h1>Tickets for CONCERT NAME</h1>
	<form action="process_ticket.php" method="post">
		<h2>Available Tickets</h2>
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

			if (isset($_GET['id'])) {
				$id = $_GET['id'];
			}
			
			// function to get the price
			function getPriceForTicketType($conn, $ticket_type) {
				// Query the database to retrieve the price of the ticket type
				$sql = "SELECT Price FROM Ticket_Type WHERE Ticket_Type = '$ticket_type'";
				$result = $conn->query($sql);
			
				// Check if a result is returned
				if ($result->num_rows > 0) {
					// Fetch the row and return the price
					$row = $result->fetch_assoc();
					return $row['Price'];
				} else {
					// Return a default value or handle the case when the ticket type is not found
					return "N/A";
				}
			}

			// function to retrieve number of available Tickets
			function getAvailabilityForTicketType($conn, $ticket_type, $concert_id) {
				// Query the database to retrieve the availability of the ticket type for the selected concert
				$sql = "SELECT COUNT(*) AS AvailableTickets FROM Tickets WHERE Concert_ID = $concert_id AND Ticket_Type = '$ticket_type' AND Availability = 1";
				$result = $conn->query($sql);

				// Check if a result is returned
				if ($result->num_rows > 0) {
					// Fetch the row and return the availability
					$row = $result->fetch_assoc();
					return $row['AvailableTickets'];
				} else {
					// Return a default value or handle the case when the availability information is not found
					return "N/A";
				}
			}


			// Fetch ticket options from the database
			$sql = "SELECT Ticket_Type, Price FROM Ticket_Type";
			$result = $conn->query($sql);
			
			$concert_id = 1; 
			// Check if any ticket options are returned
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					// Dynamically generate ticket option boxes
					echo '<div class="ticket-option">';
					echo '<h3>' . $row['Ticket_Type'] . '</h3>';
					echo '<p>Price: $' . getPriceForTicketType($conn, $row['Ticket_Type']) . '</p>';
					echo '<p>Availability: ' . getAvailabilityForTicketType($conn, $row['Ticket_Type'], $concert_id) . '</p>';
					echo '</div>';
				}
			} else {
				echo "No ticket options available.";
			}

			// Close connection
			$conn->close();
		?>

		<div class="form-actions">
			<button type="submit" class="buy-ticket-button">Purchase Ticket</button>
		</div>
	</form>

	<input type="hidden" name="ticket_type" id="selected_ticket_type" value="">
	
	<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ticketOptions = document.querySelectorAll('.ticket-option');
        ticketOptions.forEach(option => {
            option.addEventListener('click', function() {
                ticketOptions.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                // Get the selected ticket type
                const selectedTicketType = this.querySelector('h3').textContent;
                // Update the hidden input value
                document.getElementById('selected_ticket_type').value = selectedTicketType;
            });
        });

        // Handle form submission
        const form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            const ticketType = document.getElementById('selected_ticket_type').value;
            const customerId = <?php echo json_encode($id); ?>; // Get customer ID from PHP
            // Redirect to process_ticket.php with the selected ticket type and customer ID in the URL
            window.location.href = `process_ticket.php?ticket_type=${encodeURIComponent(ticketType)}&id=${encodeURIComponent(customerId)}`;
        });
    });
	</script>
</body>

</html>