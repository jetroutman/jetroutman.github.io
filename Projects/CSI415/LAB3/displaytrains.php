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


$sql = "SELECT train_num, location, location_timestamp FROM Train_tbl";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	 echo "<table><tr><th>Train</th><th>Current Location</th><th>Arrival Time</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["train_num"]."</td><td>".$row["location"]."</td><td>".$row["location_timestamp"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "failed on student table";
}

?>