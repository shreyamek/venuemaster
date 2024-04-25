<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_GET['concert_id'])) {
    $concertID = $_GET['concert_id'];
} else {
    $concertID = 0; // default value or handle error
}

if(isset($_GET['ticket_id'])) {
    $ticketID = $_GET['ticket_id'];
} else {
    $ticketID = 0; // default value or handle error
}

if(isset($_GET['track_id'])) {
    $track_id = $_GET['track_id'];
} else {
    $track_id = 0; // default value or handle error
}

if(isset($_GET['artist_id'])) {
    $artistID = $_GET['artist_id'];
} else {
    $artistID = 0; // default value or handle error
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "venue_master_db"; // Change this to your actual database name


// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $concert_name = $_POST['concert_name'];
    $concert_date = $_POST['concert_date'];
    $concert_location = $_POST['concert_location'];
    $concert_time = $_POST['concert_time'];
    $song_name = $_POST['song_name'];
    $ticket_types = $_POST['ticket_type'];
    $ticket_quantities = $_POST['ticket_quantity'];

    $sql = "INSERT INTO Concert (Concert_ID, Concert_Name, Location, Date, Time, Artist_ID) VALUES ('$concertID', '$concert_name', '$concert_location', '$concert_date', '$concert_time', 1)";
    if ($conn->query($sql) === TRUE) {
        // Insert songs
        foreach ($song_name as $key => $song_name) {
            $sql = "INSERT INTO TrackList (Track_ID, Track_Name, Concert_ID) VALUES ('$track_id', '$song_name', '$concertID')";
            $conn->query($sql);
        }

        // Insert tickets
        foreach ($ticket_types as $key => $ticket_type) {
            $ticket_quantity = $ticket_quantities[$key];
            $sql = "INSERT INTO Tickets (Ticket_ID, Ticket_Type, Availability, Purchase_ID, Concert_ID) VALUES ('$ticketID', '$ticket_type', 1, Null, '$concertID')";
            $conn->query($sql);
        }

        echo "Form submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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
		<title>Sign Up for a Venue for Your Next Concert</title>
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
			input[type="text"], input[type="number"] {
			width: 50%;
			padding: 10px;
			border: 1px solid #ccc;
			border-radius: 4px;
			margin-bottom: 20px;
			}
			input[type="date"] {
			width: 20%;
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
			.venue-options {
			display: flex;
			justify-content: space-between;
			margin-bottom: 20px;
			}
			.venue-option {
			flex-basis: 22%;
			padding: 10px;
			border: 1px solid #ccc;
			border-radius: 4px;
			text-align: center;
			cursor: pointer;
			}
			.venue-option.selected {
			background-color: #ff0000;
			color: #fff;
			}
			.song-input, .ticket-input {
			display: flex;
			align-items: center;
			margin-bottom: 10px;
			}
			.song-input input[type="text"], .song-input input[type="number"],
			.ticket-input input[type="text"], .ticket-input input[type="number"] {
			width: 45%;
			margin-right: 10px;
			}
			.song-input input[type="number"], .ticket-input input[type="number"] {
			width: 20%;
			}
			.delete-icon {
			margin-left: 10px;
			color: #ff0000;
			cursor: pointer;
			}
			.submit-button {
			display: block;
			margin: 20px auto 0;
			}
			.ticket-section {
			margin-top: 40px;
			}
		</style>
	</head>
	<body>
		<h1>SIGN UP FOR A VENUE FOR YOUR NEXT CONCERT!</h1>
		<form action="venue_signup.php" method="post">
			<label for="concert_date">DATE OF CONCERT:</label>
			<input type="date" id="concert_date" name="concert_date" required>
			<label for="concert_time">TIME OF CONCERT:</label>
			<input type="time" id="concert_time" name="concert_time" required>
			<br> <br>
			<label>SELECT A VENUE FOR YOUR CONCERT:</label>
			<input type="text" id="concert_location" name="concert_location" required>
			<label for="concert_name">YOUR CONCERT'S NAME:</label>
			<input type="text" id="concert_name" name="concert_name" required>
			<label for="concert_description">ADD A DESCRIPTION:</label>
			<input type="text" id="concert_description" name="concert_description" required>
			<label>ENTER THE SONGS YOU WILL BE PERFORMING:</label>
			<div class="song-inputs">
				<div class="song-input">
					<span class="delete-icon" onclick="deleteSong(this)">&#10005;</span>
					<input type="text" name="song_name[]" placeholder="Song #1 Name:" required>
					<input type="number" name="song_duration[]" placeholder="Duration:" required>
				</div>
				<div class="song-input">
					<span class="delete-icon" onclick="deleteSong(this)">&#10005;</span>
					<input type="text" name="song_name[]" placeholder="Song #2 Name:" required>
					<input type="number" name="song_duration[]" placeholder="Duration:" required>
				</div>
				<!-- Repeat for additional song inputs -->
			</div>
			<button type="button" onclick="addSong()">+ ADD ANOTHER SONG</button>
			<div class="ticket-section">
				<label>ENTER THE PRICE OF EACH TICKET TYPE:</label>
				<div class="ticket-inputs">
					<div class="ticket-input">
						<span class="delete-icon" onclick="deleteTicket(this)">&#10005;</span>
						<input type="text" name="ticket_type[]" value="General Admission" readonly>
						<input type="number" name="ticket_quantity[]" placeholder="Quantity" required>
					</div>
					<div class="ticket-input">
						<span class="delete-icon" onclick="deleteTicket(this)">&#10005;</span>
						<input type="text" name="ticket_type[]" value="VIP Admission" readonly>
						<input type="number" name="ticket_quantity[]" placeholder="Quantity" required>
					</div>
					<!-- Repeat for additional ticket types -->
				</div>
				<button type="button" onclick="addTicket()">+ ADD CUSTOM TICKET</button>
			</div>
			<button type="submit" class="submit-button">SUBMIT FORM</button>
		</form>
		<script>
			function addSong() {
			  var songInputs = document.querySelector('.song-inputs');
			  var newSongInput = document.createElement('div');
			  newSongInput.className = 'song-input';
			  newSongInput.innerHTML = `
			    <span class="delete-icon" onclick="deleteSong(this)">&#10005;</span>
			    <input type="text" name="song_name[]" placeholder="Song Name:" required>
			    <input type="number" name="song_duration[]" placeholder="Duration:" required>
			  `;
			  songInputs.appendChild(newSongInput);
			}
			
			function deleteSong(element) {
			  var songInput = element.parentNode;
			  songInput.parentNode.removeChild(songInput);
			}
			
			function addTicket() {
			  var ticketInputs = document.querySelector('.ticket-inputs');
			  var newTicketInput = document.createElement('div');
			  newTicketInput.className = 'ticket-input';
			  newTicketInput.innerHTML = `
			    <span class="delete-icon" onclick="deleteTicket(this)">&#10005;</span>
			    <input type="text" name="ticket_type[]" placeholder="Ticket Type" required>
			    <input type="number" name="ticket_quantity[]" placeholder="Quantity" required>
			  `;
			  ticketInputs.appendChild(newTicketInput);
			}
			
			function deleteTicket(element) {
			  var ticketInput = element.parentNode;
			  ticketInput.parentNode.removeChild(ticketInput);
			}
		</script>
	</body>
</html>