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
	<a class="resume col-xs-12 col-md-12" href="game.php">Resume previous game</a>
  </body>
</html>
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

$user = $_GET["username"];
$passcode = $_GET["password"];

// Checks to see if Stops get skipped
$sql = "SELECT user_id FROM Login_tbl WHERE username = '$user'";
if ($stmt = $conn->prepare($sql)){
	/*execute query*/
	$stmt->execute();

	/*bind result to temp variable*/
	$stmt->bind_result($temp);
	// Debug Statment
	// echo "Set Variable new next\n";

	/*rebinds variable to another variable thats available outside of function*/
	while ($stmt->fetch()) {
		$id = $temp;
	}

	/*Closes Statment*/
	$stmt->close();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$_SESSION['id'] = $id;
include 'selectmap.php';
?>