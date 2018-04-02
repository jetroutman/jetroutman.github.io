<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db2";
$dbname1 = "db1";

// Create connection
$conn1 = new mysqli($servername, $username, $password, $dbname1);
// Check connection
if ($conn1->connect_error) {
    die("Connection failed: " . $conn1->connect_error);
}

$conn2 = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn2->connect_error) {
    die("Connection failed: " . $conn2->connect_error);
}

//storing old location in case you have to move back
$oldns = "$_SESSION[ns]";
$oldew = "$_SESSION[ew]";

//move up
if (isset($_GET['up'])){
	$ns = "$_SESSION[ns]" + 1;
	$sql = "UPDATE Save_State_tbl
	SET current_location_ns = '$ns'
	WHERE user_id = '$_SESSION[id]';";
	if ($conn2->query($sql) === TRUE) {
	    echo "<div>You moved up</div>";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}
}

//move left
if (isset($_GET['left'])){
	$ew = "$_SESSION[ew]" - 1;
	$sql = "UPDATE Save_State_tbl
	SET current_location_ew = '$ew'
	WHERE user_id = '$_SESSION[id]';";
	if ($conn2->query($sql) === TRUE) {
	    echo "<div>You moved left</div>";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}
}

//move right
if (isset($_GET['right'])){
	$ew = "$_SESSION[ew]" + 1;
	$sql = "UPDATE Save_State_tbl
	SET current_location_ew = '$ew'
	WHERE user_id = '$_SESSION[id]';";
	if ($conn2->query($sql) === TRUE) {
	    echo "<div>You moved right</div>";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}
}

//move down
if (isset($_GET['down'])){
	$ns = "$_SESSION[ns]" - 1;
	$sql = "UPDATE Save_State_tbl
	SET current_location_ns = '$ns'
	WHERE user_id = '$_SESSION[id]';";
	if ($conn2->query($sql) === TRUE) {
	    echo "<div>You moved down</div>";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
//Pulls y coordinate
$sql = "SELECT current_location_ns FROM Save_State_tbl WHERE user_id = '$_SESSION[id]';";
if ($stmt = $conn2->prepare($sql)){
	/*execute query*/
	$stmt->execute();

	/*bind result to temp variable*/
	$stmt->bind_result($temp);
	// Debug Statment
	// echo "Set Variable new next\n";

	/*rebinds variable to another variable thats available outside of function*/
	while ($stmt->fetch()) {
		$_SESSION['ns'] = $temp;
	}

	/*Closes Statment*/
	$stmt->close();
} else {
    echo "Error: " . $sql . "<br>" . $conn2->error;
}

//Pulls x coordinate
$sql = "SELECT current_location_ew FROM Save_State_tbl WHERE user_id = '$_SESSION[id]';";
if ($stmt = $conn2->prepare($sql)){
	/*execute query*/
	$stmt->execute();

	/*bind result to temp variable*/
	$stmt->bind_result($temp);
	// Debug Statment
	// echo "Set Variable new next\n";

	/*rebinds variable to another variable thats available outside of function*/
	while ($stmt->fetch()) {
		$_SESSION['ew'] = $temp;
	}

	/*Closes Statment*/
	$stmt->close();
} else {
    echo "Error: " . $sql . "<br>" . $conn2->error;
}

// Pulls map id
$sql = "SELECT map_id FROM Save_State_tbl WHERE user_id = '$_SESSION[id]';";
if ($stmt = $conn2->prepare($sql)){
	/*execute query*/
	$stmt->execute();

	/*bind result to temp variable*/
	$stmt->bind_result($temp);
	// Debug Statment
	// echo "Set Variable new next\n";

	/*rebinds variable to another variable thats available outside of function*/
	while ($stmt->fetch()) {
		$_SESSION['map'] = $temp;
	}

	/*Closes Statment*/
	$stmt->close();
} else {
    echo "Error: " . $sql . "<br>" . $conn2->error;
}

//Checks other what the status of the current room is
$sql = "SELECT room_id FROM Available_Rooms_tbl Where ns = '$_SESSION[ns]' and ew = '$_SESSION[ew]'and map_id = '$_SESSION[map]';";
if ($stmt = $conn1->prepare($sql)){
	/*execute query*/
	$stmt->execute();

	/*bind result to temp variable*/
	$stmt->bind_result($temp);
	// Debug Statment
	// echo "Set Variable new next\n";

	/*rebinds variable to another variable thats available outside of function*/
	while ($stmt->fetch()) {
		$roomid = $temp;
	}

	/*Closes Statment*/
	$stmt->close();
} else {
    echo "Error: " . $sql . "<br>" . $conn1->error;
}
$sql = "SELECT room_type FROM Room_tbl Where room_id = '$roomid';";
if ($stmt = $conn1->prepare($sql)){
	/*execute query*/
	$stmt->execute();

	/*bind result to temp variable*/
	$stmt->bind_result($temp);
	// Debug Statment
	// echo "Set Variable new next\n";

	/*rebinds variable to another variable thats available outside of function*/
	while ($stmt->fetch()) {
		$room_type = $temp;
	}

	/*Closes Statment*/
	$stmt->close();
} else {
    echo "Error: " . $sql . "<br>" . $conn1->error;
}

if ($room_type != "enemy room"){
	echo "<div>You are currently in a $room_type<div>";
}else{
	$sql = "SELECT enemy_id FROM Enemy_tbl WHERE coor_ns = '$_SESSION[ns]' and coor_ew = '$_SESSION[ew]';";
	if ($stmt = $conn1->prepare($sql)){
		/*execute query*/
		$stmt->execute();

		/*bind result to temp variable*/
		$stmt->bind_result($temp);
		// Debug Statment
		// echo "Set Variable new next\n";

		/*rebinds variable to another variable thats available outside of function*/
		while ($stmt->fetch()) {
			$enemy = $temp;
		}
		/*Closes Statment*/
		$stmt->close();
	} else {
	    echo "Error: " . $sql . "<br>" . $conn1->error;
	}
	$sql = "SELECT state FROM Enemy_tbl WHERE enemy_id ='$enemy' and user_id = '$_SESSION[id]';";
	$result = $conn2->query($sql);
	while ($row = $result->fetch_assoc()) {
		if ($row['state'] == 0){
			echo "<div>You've encountered an enemy and have successfully defended yourself</div>";
			$sql = "UPDATE Enemy_tbl
			SET state = 1
			WHERE enemy_id = '$enemy';";
			if ($conn2->query($sql) === TRUE) {
			    echo "<div>We've successfully updated the vanquishing of this enemy</div>";
			} else {
			    echo "Error: " . $sql . "<br>" . $conn2->error;
			}
		}else echo "You've entered an empty room the enemies state is death";
	}
}
if ($room_type === 'key room'){
	//Pulling the key id from the first database
	$sql = "SELECT key_id FROM Key_Lock_tbl WHERE key_coor_ns = '$_SESSION[ns]' and key_coor_ew = '$_SESSION[ew]' and map_id = '$_SESSION[map]';";
	if ($stmt = $conn1->prepare($sql)){
		/*execute query*/
		$stmt->execute();

		/*bind result to temp variable*/
		$stmt->bind_result($temp);
		// Debug Statment
		// echo "Set Variable new next\n";

		/*rebinds variable to another variable thats available outside of function*/
		while ($stmt->fetch()) {
			$keyid = $temp;
		}
		/*Closes Statment*/
		$stmt->close();
	} else {
	    echo "Error: " . $sql . "<br>" . $conn1->error;
	}
	$sql = "UPDATE Key_Lock_tbl
	SET state = 1
	WHERE user_id = '$_SESSION[id]' AND key_id = $keyid;";
	if ($conn2->query($sql) === TRUE) {
	    echo "<div>We've successfully updated you picking up the key</div>";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn2->error;
	}
}
if ($room_type === 'goal room'){
	echo "<div>You have earned the right to choose a different map</div>";
	include 'selectmap.php';
	echo "<div>Unless you'd like to continue exploring</div>";
}
if ($room_type === 'lock room'){
	$sql = "SELECT key_id FROM Key_Lock_tbl WHERE lock_coor_ns = '$_SESSION[ns]' and lock_coor_ew = '$_SESSION[ew]' and map_id = '$_SESSION[map]';";
	if ($stmt = $conn1->prepare($sql)){
		/*execute query*/
		$stmt->execute();

		/*bind result to temp variable*/
		$stmt->bind_result($temp);
		// Debug Statment
		// echo "Set Variable new next\n";

		/*rebinds variable to another variable thats available outside of function*/
		while ($stmt->fetch()) {
			$keyid = $temp;
		}
		/*Closes Statment*/
		$stmt->close();
	} else {
	    echo "Error: " . $sql . "<br>" . $conn1->error;
	}
	$sql = "SELECT state FROM Key_Lock_tbl WHERE  user_id = '$_SESSION[id]' AND key_id = $keyid;";
	$result = $conn2->query($sql);
	while ($row = $result->fetch_assoc()) {
		if ($row['state'] == 0){
			echo "<div id='lock'>You should not be here this room is still locked</div>";
			$sql = "UPDATE Save_State_tbl
			SET current_location_ew = '$oldew', current_location_ns = '$oldns'
			WHERE user_id = '$_SESSION[id]';";
			if ($conn2->query($sql) === TRUE) {
			    echo "<div>Sooooooo We moved you back</div>";
			} else {
			    echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
	}
}
$sql = "SELECT current_location_ns FROM Save_State_tbl WHERE user_id = '$_SESSION[id]';";
if ($stmt = $conn2->prepare($sql)){
	/*execute query*/
	$stmt->execute();

	/*bind result to temp variable*/
	$stmt->bind_result($temp);
	// Debug Statment
	// echo "Set Variable new next\n";

	/*rebinds variable to another variable thats available outside of function*/
	while ($stmt->fetch()) {
		$_SESSION['ns'] = $temp;
	}

	/*Closes Statment*/
	$stmt->close();
} else {
    echo "Error: " . $sql . "<br>" . $conn2->error;
}

//Pulls x coordinate
$sql = "SELECT current_location_ew FROM Save_State_tbl WHERE user_id = '$_SESSION[id]';";
if ($stmt = $conn2->prepare($sql)){
	/*execute query*/
	$stmt->execute();

	/*bind result to temp variable*/
	$stmt->bind_result($temp);
	// Debug Statment
	// echo "Set Variable new next\n";

	/*rebinds variable to another variable thats available outside of function*/
	while ($stmt->fetch()) {
		$_SESSION['ew'] = $temp;
	}

	/*Closes Statment*/
	$stmt->close();
} else {
    echo "Error: " . $sql . "<br>" . $conn2->error;
}

?>