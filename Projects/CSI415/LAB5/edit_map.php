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
	<h1>Heres your current map choose a tile to edit or build off of</h1>
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

include 'addlock.php';
include 'addkey.php';

if (isset($_GET["mapname"])){
	$map = $_GET["mapname"];
	$_SESSION['editmap'] = $map;
	$mapname = $_GET["newmap"];
	if($map == "new map"){ //checks that it may be a new map
		//Creates a starting room
		$sql = "INSERT INTO Map_tbl (goal_ns, goal_ew, start_ns, start_ew, map_name)
		VALUES (0, 0, 0, 0, '$mapname');";
		if ($conn->query($sql) === TRUE) {
		    echo "<script language='javascript'> alert('New Map Created'); </script>";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}

		//updates the sessions map id
		$sql = "SELECT map_id FROM Map_tbl WHERE map_name = '$mapname';";
		if ($stmt = $conn->prepare($sql)){
			/*execute query*/
			$stmt->execute();

			/*bind result to temp variable*/
			$stmt->bind_result($temp);
			// Debug Statment
			// echo "Set Variable new next\n";

			/*rebinds variable to another variable thats available outside of function*/
			while ($stmt->fetch()) {
				$map = $temp;
				$_SESSION['editmap'] = $map;
			}

			/*Closes Statment*/
			$stmt->close();
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}

		//finish making room by puting it in the map table
		$sql = "INSERT INTO Available_Rooms_tbl (map_id, ns, ew, room_id)
		VALUES ('$_SESSION[editmap]', 0, 0, 1);";
		if ($conn->query($sql) === TRUE) {
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
}

include 'mapdisplay.php';
?>
<table>
	<tr>Map Key</tr>
	<tr><th>Room Type</th><th>Color</th></tr>
	<tr><td>Goal Room</td><td>Green</td></tr>
	<tr><td>Enemy Room</td><td>Red</td></tr>
	<tr><td>Key Room</td><td>Light Blue</td></tr>
	<tr><td>Lock Room</td><td>Dark Blue</td></tr>
	<tr><td>Unused</td><td>Black</td></tr>
</table>