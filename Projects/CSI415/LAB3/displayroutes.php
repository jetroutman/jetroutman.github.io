<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "traindb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//first display of table
$sql = "SELECT stop_name, next_destination, wait_time FROM Route_tbl WHERE active_stop = 1 ORDER BY stop_name ASC";
$result = $conn->query($sql);

echo "<table><tr><th>Current Destinations and routes</th><th></th><th></th></tr><tr><th>Stop Name</th><th>Leads To</th><th>Travel Time</th></tr>";

if ($result->num_rows > 0) {
	// output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["stop_name"]."</td><td>".$row["next_destination"]."</td><td>".$row["wait_time"]."</td></tr>";
    }
} else {
    echo "failed on route table";
}

//displays inactive routes
$sql = "SELECT stop_name, next_destination, wait_time FROM Route_tbl WHERE active_stop = 0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	// output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr class = 'inactive'><td>".$row["stop_name"]."</td><td>".$row["next_destination"]."</td><td>".$row["wait_time"]."</td></tr>";
    }
}
    echo "</table>";
?>