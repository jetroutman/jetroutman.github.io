<?php include 'menu.php';?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta http-equiv="refresh" content="5;URL='lab3pg3.php'" /> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>CSI 415</title>

	<link type="text/css" rel="stylesheet" href="../webcss.css"/>
	<style>
		body{
			background-color: #171717;
			font-size: 24px;
			color: white;
		}
	</style>
  </head>


  <body class="container-fluid">
	<div class="header row">
		<div class="col-xs-12 col-sm-5 col-md-4">
			<h1>Group 1</h1>
		</div>
		<div class="col-xs-12 col-sm-7 col-md-8 text-center">
			<h3>The Collaboration of McKendree Knowledge</h3>
		</div>
	</div>
	<h1>What would you like to do with your room</h1>
  </body>
</html>
<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$room = $_GET["room"];

//binding location
$sql = "SELECT ns FROM available_rooms_tbl WHERE available_room_id = '$room';";
if ($stmt = $conn->prepare($sql)){
	/*execute query*/
	$stmt->execute();

	/*bind result to temp variable*/
	$stmt->bind_result($temp);
	// Debug Statment
	// echo "Set Variable new next\n";

	/*rebinds variable to another variable thats available outside of function*/
	while ($stmt->fetch()) {
		$_SESSION["ns"] = $temp;
	}

	/*Closes Statment*/
	$stmt->close();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$sql = "SELECT ew FROM available_rooms_tbl WHERE available_room_id = '$room';";
if ($stmt = $conn->prepare($sql)){
	/*execute query*/
	$stmt->execute();

	/*bind result to temp variable*/
	$stmt->bind_result($temp);
	// Debug Statment
	// echo "Set Variable new next\n";

	/*rebinds variable to another variable thats available outside of function*/
	while ($stmt->fetch()) {
		$_SESSION["ew"] = $temp;
	}

	/*Closes Statment*/
	$stmt->close();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

echo "Room selected is '$_SESSION[ns]', '$_SESSION[ew]'";

$sql = "SELECT room_id, room_type FROM Room_tbl;";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo "<form action='roomchecker.php'>
		<div class='selector'>
		<label class='Upper'><input type='checkbox'>Edit Upper Room
		<select class='UpperAdj' id='rooms' name='Upper'>
		<option value='none'>Please Select the desired room</option>";
	// output data of each row
	while($row = $result->fetch_assoc()) {
		echo "<option value='".$row["room_id"]."'>".$row["room_type"]."</option>";
    }
    echo "</select>
    </label>";
} else {
    echo "failed on room table";
}
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo "<label class='Left'><input type='checkbox'>Edit Left Room
		<select class='LeftAdj'id='rooms' name='Left'>
		<option value='none'>Please Select the desired room</option>";
	// output data of each row
	while($row = $result->fetch_assoc()) {
		echo "<option value='".$row["room_id"]."'>".$row["room_type"]."</option>";
    }
    echo "</select>
	</label>";
} else {
    echo "failed on room table";
}
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo "<label class='Right'><input type='checkbox'>Edit Right Room
		<select class='RightAdj'id='rooms' name='Right'>
		<option value='none'>Please Select the desired room</option>";
	// output data of each row
	while($row = $result->fetch_assoc()) {
		echo "<option value='".$row["room_id"]."'>".$row["room_type"]."</option>";
    }
    echo "</select>
	</label>";
} else {
    echo "failed on room table";
}
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo "<label class='Lower'><input type='checkbox'>Edit Lower Room
		<select class='LowerAdj'id='rooms' name='Lower'>
		<option value='none'>Please Select the desired room</option>";
	// output data of each row
	while($row = $result->fetch_assoc()) {
		echo "<option value='".$row["room_id"]."'>".$row["room_type"]."</option>";
    }
    echo "</select>
    </label>";
} else {
    echo "failed on room table";
}
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo "<label class='Selected'><input type='checkbox'>Edit Selected Room
		<select class='SelectedAdj'id='rooms' name='Current'>
		<option value='none'>Please Select the desired room</option>";
	// output data of each row
	while($row = $result->fetch_assoc()) {
		echo "<option value='".$row["room_id"]."'>".$row["room_type"]."</option>";
    }
    echo "</select>
    </label>
    </div>
    <input type='submit' name='Submit'>
    </form>
	";
} else {
    echo "failed on room table";
}
?>