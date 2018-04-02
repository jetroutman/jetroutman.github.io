<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db2";
$dbname1 = "db1";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create connection for 1st database
$con = new mysqli($servername, $username, $password, $dbname1);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$map_id = $_GET["map"];

//Delete old map data
$sql = "DELETE FROM Save_State_tbl WHERE user_id = ".$_SESSION['id'].";";
if ($conn->query($sql) === TRUE) {
    echo "<div>New record created successfull</div>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$sql = "DELETE FROM Enemy_tbl WHERE user_id = ".$_SESSION['id'].";";
if ($conn->query($sql) === TRUE) {
    echo "<div>New record created successfull</div>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$sql = "DELETE FROM Key_Lock_tbl WHERE user_id = ".$_SESSION['id'].";";
if ($conn->query($sql) === TRUE) {
    echo "<div>New record created successfull</div>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

//Insert new map into user database
$sql = "INSERT INTO Save_State_tbl (user_id, map_id, current_location_ns, current_location_ew) VALUES (".$_SESSION['id'].", $map_id, 0, 0);";
if ($conn->query($sql) === TRUE) {
    echo "<div>New record created successfull</div>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

//Pulls and inserts enemy data
$sql = "SELECT enemy_id FROM Enemy_tbl WHERE map_id=$map_id";
$result = $con->query($sql);
if ($result->num_rows > 0) {
	// output data of each row
	while($row = $result->fetch_assoc()) {
		$sql2 = "INSERT INTO Enemy_tbl (user_id, enemy_id, state) VALUES (".$_SESSION['id'].", ".$row['enemy_id'].", 0);";
		if ($conn->query($sql2) === TRUE) {
		    echo "<div>New Enemies created successfull</div>";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

//Pulls and inserts key data
$sql = "SELECT key_id FROM Key_Lock_tbl WHERE map_id=$map_id";
$result = $con->query($sql);
if ($result->num_rows > 0) {
	// output data of each row
	while($row = $result->fetch_assoc()) {
		$sql2 = "INSERT INTO Key_Lock_tbl (user_id, key_id, state) VALUES (".$_SESSION['id'].", ".$row['key_id'].", 0);";
		if ($conn->query($sql2) === TRUE) {
		    echo "<div>New Keys added created successfull</div>";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

//Takes the user into the game page
header( 'Location: game.php' );
?>