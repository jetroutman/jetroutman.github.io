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
	<h1>The Train Database</h1>
	<div class="navigation row" style="margin-left: 0px;">
		<a href="../lab3.php">Train Current Location</a>
		<a href="../lab3pg2.php">Train History</a>
		<a class="current disabled" href="../lab3pg3.php">Change Route</a>
	</div>
  </body>
</html>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "traindb";

$newstop = $_GET["sname"];
$next_destination = $_GET["next_destination"];
$previous_destination = $_GET["previous_destination"];
$newtime = $_GET["waittime"];
$fromtime = $_GET["fromwaittime"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Checks to see if Stops get skipped
$sql = "SELECT next_destination FROM Route_tbl WHERE stop_name = '$previous_destination'";
if ($stmt = $conn->prepare($sql)){
	/*execute query*/
	$stmt->execute();

	/*bind result to temp variable*/
	$stmt->bind_result($temp);
	// Debug Statment
	// echo "Set Variable new next\n";

	/*rebinds variable to another variable thats available outside of function*/
	while ($stmt->fetch()) {
		$oldnext = $temp;
	}

	/*Closes Statment*/
	$stmt->close();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
echo "<div>old next = $oldnext and new next = $next_destination</div>";
if ($oldnext === $next_destination){
	$noskips = true;
}else {
	$noskips = 0;
	echo "It does execute else";
}
echo "Thus skips = $noskips";

$sql = "INSERT INTO Route_tbl (stop_name, next_destination, wait_time, active_stop)
	VALUES ('$newstop', '$next_destination', $newtime, 1);";
if ($conn->query($sql) === TRUE) {
    echo "<div>New record created successfull</div>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$sql = "UPDATE Route_tbl
	SET next_destination = '$newstop', wait_time = '$fromtime'
	WHERE stop_name = '$previous_destination'";
if ($conn->query($sql) === TRUE) {
    echo "<div>New record Updated successfully</div>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$flag = true;
if ($noskips != true){
	while($flag == true){
		$sql = "UPDATE Route_tbl
		SET active_stop = false
		WHERE stop_name = '$oldnext'";
		if ($conn->query($sql) === TRUE) {
		    echo "<div>Skipped Route Detected Detected</div>";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}

		// Checks to see if Stops get skipped
		$sql = "SELECT next_destination FROM Route_tbl WHERE stop_name = '$oldnext'";
		if ($stmt = $conn->prepare($sql)){
			/*execute query*/
			$stmt->execute();

			/*bind result to temp variable*/
			$stmt->bind_result($temp);
			// Debug Statment
			// echo "Set Variable new next\n";

			/*rebinds variable to another variable thats available outside of function*/
			while ($stmt->fetch()) {
				$oldnext = $temp;
			}

			/*Closes Statment*/
			$stmt->close();
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
		echo "<div>old next = $oldnext and new next = $next_destination</div>";
		if ($oldnext === $next_destination){
			$flag = false;
		}
	}
}
?>
<?php include 'displayroutes.php';?>