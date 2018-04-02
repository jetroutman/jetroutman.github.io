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


//Add route
$sql = "SELECT stop_name FROM Route_tbl WHERE active_stop = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	 echo "<label for='delete_destination'>Skip Route</label>
	 <select id='delete_destination' name='delete_destination'>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<option value=".$row["stop_name"].">".$row["stop_name"]."</option>";
    }
    echo "</select>";
} else {
    echo "failed on route table";
}
?>