<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Artist Dashboard</title>
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
			max-width: 800px;
			margin: 0 auto;
			background-color: #fff;
			padding: 20px;
			border-radius: 5px;
			box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
			}
			.upcoming-concerts, .concert-history {
			margin-bottom: 30px;
			}
			table {
			width: 100%;
			border-collapse: collapse;
			}
			th, td {
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
			.action-buttons .update-button {
			background-color: #007bff;
			color: #fff;
			}
			.action-buttons .cancel-button {
			background-color: #dc3545;
			color: #fff;
			}
			.profile-section {
			display: flex;
			margin-top: 30px;
			}
			.profile {
			flex: 1;
			margin-right: 20px;
			}
			.profile h2 {
			margin-bottom: 10px;
			}
			.profile p {
			margin-bottom: 5px;
			}
			.profile button {
			margin-top: 10px;
			padding: 8px 16px;
			background-color: #28a745;
			color: #fff;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			}
			.recent-reviews {
			flex: 1;
			}
			.recent-reviews h2 {
			margin-bottom: 10px;
			}
			.review {
			background-color: #f2f2f2;
			padding: 10px;
			margin-bottom: 10px;
			border-radius: 4px;
			}
			.review p {
			margin: 0;
			}
			.review .reviewer {
			font-weight: bold;
			margin-bottom: 5px;
			}
			.overall-rating {
			display: flex;
			justify-content: flex-end;
			align-items: center;
			margin-bottom: 20px;
			}
			.star {
			font-size: 24px;
			color: #ccc;
			margin-left: 5px;
			}
			.star.gold {
			color: gold;
			}
		</style>
	</head>
	<body>
		<h1>Artist Dashboard</h1>
		<div class="dashboard">
			<div class="overall-rating">
				<span class="star gold">&#9733;</span>
				<span class="star gold">&#9733;</span>
				<span class="star gold">&#9733;</span>
				<span class="star gold">&#9733;</span>
				<span class="star">&#9733;</span>
			</div>
			<div class="upcoming-concerts">
				<h2>UPCOMING CONCERTS:</h2>
				<table>
					<thead>
						<tr>
							<th>Concert Name</th>
							<th>Date</th>
							<th>Time</th>
							<th>Location</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php
						if(isset($_GET['id'])) {
							$artist_id = $_GET['id'];
						} else {
							// Handle the case where artist_id is not provided
							$artist_id = 0; // default value or handle error
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
                        $registered_concerts_query = "SELECT Concert_Name, Date, Time, Location FROM Concert WHERE artist_id=$artist_id AND Date >= CURDATE()"; //  WHERE artist_id = $artist_id Added condition for registered concerts

                        $result = $conn->query($registered_concerts_query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["Concert_Name"] . "</td>";
                                echo "<td>" . $row["Date"] . "</td>";
                                echo "<td>" . $row["Time"] . "</td>";
                                echo "<td>" . $row["Location"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "0 results";
                        }

                        // Close connection
                        $conn->close();
                    ?>
						<!-- Add more rows for upcoming concerts -->
					</tbody>
				</table>
			</div>
			<div class="concert-history">
				<h2>CONCERT HISTORY</h2>
				<table>
					<thead>
						<tr>
							<th>Concert Name</th>
							<th>Venue</th>
							<th>Date</th>
							<th>Time</th>
							<th>Location</th>
							<th>Audience Size</th>
							<th>Ratings</th>
						</tr>
					</thead>
					<tbody>
					<?php
						if(isset($_GET['id'])) {
							$artist_id = $_GET['id'];
						} else {
							// Handle the case where artist_id is not provided
							$artist_id = 0; // default value or handle error
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
                        $registered_concerts_query = "SELECT Concert_Name, Date, Time, Location FROM Concert WHERE artist_id=$artist_id AND Date < CURDATE()"; //  WHERE artist_id = $artist_id Added condition for registered concerts

                        $result = $conn->query($registered_concerts_query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["Concert_Name"] . "</td>";
                                echo "<td>" . $row["Date"] . "</td>";
                                echo "<td>" . $row["Time"] . "</td>";
                                echo "<td>" . $row["Location"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "0 results";
                        }

                        // Close connection
                        $conn->close();
                    ?>
						<!-- Add more rows for concert history -->
					</tbody>
				</table>
			</div>
			<div class="profile-section">
				<div class="profile">
					<h2>PROFILE</h2>
					<p>Name: John Smith</p>
					<!--<p>Genre: Rap</p> -->
					<!-- <p>Bio: I'm John Smith</p> -->
					<button>Edit</button>
				</div>
				<div class="recent-reviews">
					<h2>RECENT REVIEWS</h2>
					<div class="review">
						<p class="reviewer">Jane Doe</p>
						<p>Great performance! John Smith rocked the stage!</p>
					</div>
					<div class="review">
						<p class="reviewer">Mike Johnson</p>
						<p>Amazing concert! John Smith's energy was incredible.</p>
					</div>
					<!-- Add more reviews -->
				</div>
			</div>
		</div>
	</body>
</html>