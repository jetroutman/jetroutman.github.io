<?php include 'menu.php';?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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

$oldstop = $_GET["oldstop"];
$next_destination = $_GET["next_destination"];
$previous_destination = $_GET["previous_destination"];
$newtime = $_GET["waittime"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//first display of table
$sql = "UPDATE Route_tbl
	SET next_destination ='$next_destination', wait_time = $newtime, active_stop = 1
	WHERE stop_name = '$oldstop';";
if ($conn->query($sql) === TRUE) {
    echo "<div>New record created successfully</div>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$sql = "UPDATE Route_tbl
	SET next_destination = '$oldstop'
	WHERE stop_name = '$previous_destination'";
if ($conn->query($sql) === TRUE) {
    echo "<div>New record Updated successfully</div>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
<?php include 'displayroutes.php';?>