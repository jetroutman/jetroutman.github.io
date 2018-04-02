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
	<h1>Here's the change you made to your map</h1>
  </body>
</html>
<?php
$lockchanges = [
	"Upper" => "none",
	"Left" => "none",
	"Right" => "none",
	"Lower" => "none",
	"Current" => "none",
];
$keychanges = [
	"Upper" => "none",
	"Left" => "none",
	"Right" => "none",
	"Lower" => "none",
	"Current" => "none",
];
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

//Upper Room Update
if(isset($_GET["Upper"])){
	if($_GET["Upper"] != 'none'){
		$newroom = $_GET["Upper"];
		$ns = $_SESSION["ns"] + 1;
		$ew = $_SESSION["ew"];
		$sql = "SELECT room_id, available_room_id FROM Available_Rooms_tbl WHERE map_id = '$_SESSION[editmap]' and ns = '$ns' and ew = '$ew';";
		$result = $conn->query($sql);
		if ($result ->num_rows > 0){
			while($row = $result->fetch_assoc()){
				if ($row["room_id"] == 2){
					$sql2 = "DELETE FROM Enemy_tbl WHERE map_id = '$_SESSION[editmap]' and coor_ns = '$ns' and coor_ew = '$ew';";
					if ($conn->query($sql2) === TRUE) {
						} else {
							echo "Error: " . $sql2 . "<br>" . $conn->error;
					}
				}else if ($row["room_id"] == 3){
					$keychanges["Upper"] = "update";
					echo "<div class='error'>You are changing a room with a key in it you will need to change the location of the key</div>";
				}else if ($row["room_id"] == 4){
					$lockchanges["Upper"] = "update";
					echo "<div class='error'>You are changing a gated room you will need to change the location of the gate</div>";
				}
			}
			$sql2 = "UPDATE Available_Rooms_tbl
			SET room_id = '$newroom'
			WHERE map_id = '$_SESSION[editmap]' and ns = '$ns' and ew = '$ew';";
			if ($conn->query($sql2) === TRUE) {
				echo "<script language='javascript'> alert('Room updated'); </script>";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}else{
			$sql = "INSERT INTO Available_Rooms_tbl (ns, ew, map_id, room_id) VALUES ('$ns', '$ew', '$_SESSION[editmap]', '$newroom')";
			if ($conn->query($sql) === TRUE) {
				echo "<script language='javascript'> alert('Room Added'); </script>";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
		if($_GET["Upper"] == 1){
			$sql= "UPDATE map_tbl
			SET goal_ns = '$ns', goal_ew = '$ew'
			WHERE map_id = '$_SESSION[editmap]'";
			if ($conn->query($sql) === TRUE) {
				echo "<script language='javascript'> alert('Goal room updated'); </script>";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
		else if($_GET["Upper"] == 2){
			$sql = "INSERT INTO Enemy_tbl(map_id, coor_ns, coor_ew) VALUES('$_SESSION[editmap]', '$ns', '$ew')";
			if ($conn->query($sql) === TRUE) {
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}else if($_GET["Upper"] == 3){
			if($lockchanges["Upper"] != "update"){
				$lockchanges["Upper"] = "insert";
				echo "<div class='error'>You are inserting a key therefore you'll need a lock</div>";
			}
		}else if($_GET["Upper"] == 4){
			if($keychanges["Upper"] != "update"){
				$keychanges["Upper"] = "insert";
				echo "<div class='error'>You are inserting a gate therefore you'll need a key</div>";
			}
		}
	}
}

if(isset($_GET["Left"])){
	if($_GET["Left"] != 'none'){
		$newroom = $_GET["Left"];
		$ns = $_SESSION["ns"];
		$ew = $_SESSION["ew"] - 1;
		$sql = "SELECT room_id FROM Available_Rooms_tbl WHERE map_id = '$_SESSION[editmap]' and ns = '$ns' and ew = '$ew';";
		$result = $conn->query($sql);
		if ($result ->num_rows > 0){
			while($row = $result->fetch_assoc()){
				if ($row["room_id"] == 2){
					$sql2 = "DELETE FROM Enemy_tbl WHERE map_id = '$_SESSION[editmap]' and coor_ns = '$ns' and coor_ew = '$ew';";
					if ($conn->query($sql2) === TRUE) {
						} else {
							echo "Error: " . $sql2 . "<br>" . $conn->error;
					}
				}else if ($row["room_id"] == 3){
					$keychanges["Left"] = "update";
					echo "<div class='error'>You are changing a room with a key in it you will need to change the location of the key</div>";
				}else if ($row["room_id"] == 4){
					$lockchanges["Left"] = "update";
					echo "<div class='error'>You are changing a gated room you will need to change the location of the gate</div>";
				}
			}
			$sql2 = "UPDATE Available_Rooms_tbl
			SET room_id = '$newroom'
			WHERE map_id = '$_SESSION[editmap]' and ns = '$ns' and ew = '$ew';";
			if ($conn->query($sql2) === TRUE) {
				echo "<script language='javascript'> alert('Room updated'); </script>";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}else{
			$sql = "INSERT INTO Available_Rooms_tbl (ns, ew, map_id, room_id) VALUES ('$ns', '$ew', '$_SESSION[editmap]', '$newroom')";
			if ($conn->query($sql) === TRUE) {
				echo "<script language='javascript'> alert('Room Added'); </script>";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
		if($_GET["Left"] == 1){
			$sql= "UPDATE map_tbl
			SET goal_ns = '$ns', goal_ew = '$ew'
			WHERE map_id = '$_SESSION[editmap]'";
			if ($conn->query($sql) === TRUE) {
				echo "<script language='javascript'> alert('Goal room updated'); </script>";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
		else if($_GET["Left"] == 2){
			$sql = "INSERT INTO Enemy_tbl(map_id, coor_ns, coor_ew) VALUES('$_SESSION[editmap]', '$ns', '$ew')";
			if ($conn->query($sql) === TRUE) {
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}else if($_GET["Left"] == 3){
			if($lockchanges["Left"] != "update"){
				$lockchanges["Left"] = "insert";
				echo "<div class='error'>You are inserting a key therefore you'll need a lock</div>";
			}
		}else if($_GET["Left"] == 4){
			if($keychanges["Left"] != "update"){
				$keychanges["Left"] = "insert";
				echo "<div class='error'>You are inserting a gate therefore you'll need a key</div>";
			}
		}
	}
}

if(isset($_GET["Right"])){
	if($_GET["Right"] != 'none'){
		$newroom = $_GET["Right"];
		$ns = $_SESSION["ns"];
		$ew = $_SESSION["ew"] + 1;
		$sql = "SELECT room_id FROM Available_Rooms_tbl WHERE map_id = '$_SESSION[editmap]' and ns = '$ns' and ew = '$ew';";
		$result = $conn->query($sql);
		if ($result ->num_rows > 0){
			while($row = $result->fetch_assoc()){
				if ($row["room_id"] == 2){
					$sql2 = "DELETE FROM Enemy_tbl WHERE map_id = '$_SESSION[editmap]' and coor_ns = '$ns' and coor_ew = '$ew';";
					if ($conn->query($sql2) === TRUE) {
						} else {
							echo "Error: " . $sql2 . "<br>" . $conn->error;
					}
				}else if ($row["room_id"] == 3){
					$keychanges["Right"] = "update";
					echo "<div class='error'>You are changing a room with a key in it you will need to change the location of the key</div>";
				}else if ($row["room_id"] == 4){
					$lockchanges["Right"] = "update";
					echo "<div class='error'>You are changing a gated room you will need to change the location of the gate</div>";
				}
			}
			$sql2 = "UPDATE Available_Rooms_tbl
			SET room_id = '$newroom'
			WHERE map_id = '$_SESSION[editmap]' and ns = '$ns' and ew = '$ew';";
			if ($conn->query($sql2) === TRUE) {
				echo "<script language='javascript'> alert('Room updated'); </script>";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}else{
			$sql = "INSERT INTO Available_Rooms_tbl (ns, ew, map_id, room_id) VALUES ('$ns', '$ew', '$_SESSION[editmap]', '$newroom')";
			if ($conn->query($sql) === TRUE) {
				echo "<script language='javascript'> alert('Room Added'); </script>";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
		if($_GET["Right"] == 1){
			$sql= "UPDATE map_tbl
			SET goal_ns = '$ns', goal_ew = '$ew'
			WHERE map_id = '$_SESSION[editmap]'";
			if ($conn->query($sql) === TRUE) {
				echo "<script language='javascript'> alert('Goal room updated'); </script>";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
		else if($_GET["Right"] == 2){
			$sql = "INSERT INTO Enemy_tbl(map_id, coor_ns, coor_ew) VALUES('$_SESSION[editmap]', '$ns', '$ew')";
			if ($conn->query($sql) === TRUE) {
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}else if($_GET["Right"] == 3){
			if($lockchanges["Right"] != "update"){
				$lockchanges["Right"] = "insert";
				echo "<div class='error'>You are inserting a key therefore you'll need a lock</div>";
			}
		}else if($_GET["Right"] == 4){
			if($keychanges["Right"] != "update"){
				$keychanges["Right"] = "insert";
				echo "<div class='error'>You are inserting a gate therefore you'll need a key</div>";
			}
		}
	}
}

if(isset($_GET["Lower"])){
	if($_GET["Lower"] != 'none'){
		$newroom = $_GET["Lower"];
		$ns = $_SESSION["ns"] - 1;
		$ew = $_SESSION["ew"];
		$sql = "SELECT room_id FROM Available_Rooms_tbl WHERE map_id = '$_SESSION[editmap]' and ns = '$ns' and ew = '$ew';";
		$result = $conn->query($sql);
		if ($result ->num_rows > 0){
			while($row = $result->fetch_assoc()){
				if ($row["room_id"] == 2){
					$sql2 = "DELETE FROM Enemy_tbl WHERE map_id = '$_SESSION[editmap]' and coor_ns = '$ns' and coor_ew = '$ew';";
					if ($conn->query($sql2) === TRUE) {
						} else {
							echo "Error: " . $sql2 . "<br>" . $conn->error;
					}
				}else if ($row["room_id"] == 3){
					$keychanges["Lower"] = "update";
					echo "<div class='error'>You are changing a room with a key in it you will need to change the location of the key</div>";
				}else if ($row["room_id"] == 4){
					$lockchanges["Lower"] = "update";
					echo "<div class='error'>You are changing a gated room you will need to change the location of the gate</div>";
				}
			}
			$sql2 = "UPDATE Available_Rooms_tbl
			SET room_id = '$newroom'
			WHERE map_id = '$_SESSION[editmap]' and ns = '$ns' and ew = '$ew';";
			if ($conn->query($sql2) === TRUE) {
				echo "<script language='javascript'> alert('Room updated'); </script>";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}else{
			$sql = "INSERT INTO Available_Rooms_tbl (ns, ew, map_id, room_id) VALUES ('$ns', '$ew', '$_SESSION[editmap]', '$newroom')";
			if ($conn->query($sql) === TRUE) {
				echo "<script language='javascript'> alert('Room Added'); </script>";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
		if($_GET["Lower"] == 1){
			$sql= "UPDATE map_tbl
			SET goal_ns = '$ns', goal_ew = '$ew'
			WHERE map_id = '$_SESSION[editmap]'";
			if ($conn->query($sql) === TRUE) {
				echo "<script language='javascript'> alert('Goal room updated'); </script>";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
		else if($_GET["Lower"] == 2){
			$sql = "INSERT INTO Enemy_tbl(map_id, coor_ns, coor_ew) VALUES('$_SESSION[editmap]', '$ns', '$ew')";
			if ($conn->query($sql) === TRUE) {
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}else if($_GET["Lower"] == 3){
			if($lockchanges["Lower"] != "update"){
				$lockchanges["Lower"] = "insert";
				echo "<div class='error'>You are inserting a key therefore you'll need a lock</div>";
			}
		}else if($_GET["Lower"] == 4){
			if($keychanges["Lower"] != "update"){
				$keychanges["Lower"] = "insert";
				echo "<div class='error'>You are inserting a gate therefore you'll need a key</div>";
			}
		}
	}
}

if(isset($_GET["Current"])){
	if($_GET["Current"] != 'none'){
		$newroom = $_GET["Current"];
		$ns = $_SESSION["ns"];
		$ew = $_SESSION["ew"];
		$sql = "SELECT room_id FROM Available_Rooms_tbl WHERE map_id = '$_SESSION[editmap]' and ns = '$ns' and ew = '$ew';";
		$result = $conn->query($sql);
		if ($result ->num_rows > 0){
			while($row = $result->fetch_assoc()){
				if ($row["room_id"] == 2){
					$sql2 = "DELETE FROM Enemy_tbl WHERE map_id = '$_SESSION[editmap]' and coor_ns = '$ns' and coor_ew = '$ew';";
					if ($conn->query($sql2) === TRUE) {
						} else {
							echo "Error: " . $sql2 . "<br>" . $conn->error;
					}
				}else if ($row["room_id"] == 3){
					$keychanges["Current"] = "update";
					echo "<div class='error'>You are changing a room with a key in it you will need to change the location of the key</div>";
				}else if ($row["room_id"] == 4){
					$lockchanges["Current"] = "update";
					echo "<div class='error'>You are changing a gated room you will need to change the location of the gate</div>";
				}
			}
			$sql2 = "UPDATE Available_Rooms_tbl
			SET room_id = '$newroom'
			WHERE map_id = '$_SESSION[editmap]' and ns = '$ns' and ew = '$ew';";
			if ($conn->query($sql2) === TRUE) {
				echo "<script language='javascript'> alert('Room updated'); </script>";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}else{
			$sql = "INSERT INTO Available_Rooms_tbl (ns, ew, map_id, room_id) VALUES ('$ns', '$ew', '$_SESSION[editmap]', '$newroom')";
			if ($conn->query($sql) === TRUE) {
				echo "<script language='javascript'> alert('Room Added'); </script>";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
		if($_GET["Current"] == 1){
			$sql= "UPDATE map_tbl
			SET goal_ns = '$ns', goal_ew = '$ew'
			WHERE map_id = '$_SESSION[editmap]'";
			if ($conn->query($sql) === TRUE) {
				echo "<script language='javascript'> alert('Goal room updated'); </script>";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
		else if($_GET["Current"] == 2){
			$sql = "INSERT INTO Enemy_tbl(map_id, coor_ns, coor_ew) VALUES('$_SESSION[editmap]', '$ns', '$ew')";
			if ($conn->query($sql) === TRUE) {
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}else if($_GET["Current"] == 3){
			if($lockchanges["Current"] != "update"){
				$lockchanges["Current"] = "insert";
				echo "<div class='error'>You are inserting a key therefore you'll need a lock</div>";
			}
		}else if($_GET["Current"] == 4){
			if($keychanges["Current"] != "update"){
				$keychanges["Current"] = "insert";
				echo "<div class='error'>You are inserting a gate therefore you'll need a key</div>";
			}
		}
	}
}
include 'mapview.php';
echo "<form action='edit_map.php' method='GET'>";
include 'key_modal.php';
include 'lock_modal.php';
?>
<div style="text-align: center;" class="button"><input type="submit" value="Go Back to Map Editor"></a></div>
</form>
<table>
	<tr>Map Key</tr>
	<tr><th>Room Type</th><th>Color</th></tr>
	<tr><td>Goal Room</td><td>Green</td></tr>
	<tr><td>Enemy Room</td><td>Red</td></tr>
	<tr><td>Key Room</td><td>Light Blue</td></tr>
	<tr><td>Lock Room</td><td>Dark Blue</td></tr>
	<tr><td>Unused</td><td>Black</td></tr>
</table>