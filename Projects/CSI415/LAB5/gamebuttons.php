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

echo "<div id='arrow'>Choose a direction to move</div>";

//up
$ns = "$_SESSION[ns]" + 1;
$ew = "$_SESSION[ew]";
$sql = "SELECT room_id FROM Available_Rooms_tbl Where ns = '$ns' and ew = '$ew' and map_id = '$_SESSION[map]';";
$result = $conn1->query($sql);
while ($row = $result->fetch_assoc()) {
	echo "<form method='POST' action='game.php?up=true'>
	<input type='hidden' name='up' value='up' />";
    if ($row['room_id'] != NULL){
    	echo "<input type='submit' name='submit' id='up' value='&#8593'/>";
    }
    echo "</form>";
}

//left
$ns = "$_SESSION[ns]";
$ew = "$_SESSION[ew]" - 1;
$sql = "SELECT room_id FROM Available_Rooms_tbl Where ns = '$ns' and ew = '$ew' and map_id = '$_SESSION[map]';";
$result = $conn1->query($sql);
while ($row = $result->fetch_assoc()) {
	echo "<form method='POST' action='game.php?left=true'>
	<input type='hidden' name='left' value='left' />";
    if ($row['room_id'] != NULL){
    	echo "<input type='submit' name='submit' id='left' value='&#8592'/>";
    }
    echo "</form>";
}

//right
$ns = "$_SESSION[ns]";
$ew = "$_SESSION[ew]" + 1;
$sql = "SELECT room_id FROM Available_Rooms_tbl Where ns = '$ns' and ew = '$ew' and map_id = '$_SESSION[map]';";
$result = $conn1->query($sql);
while ($row = $result->fetch_assoc()) {
	echo "<form method='POST' action='game.php?right=true'>
	<input type='hidden' name='right' value='right' />";
    if ($row['room_id'] != NULL){
    	echo "<input type='submit' name='submit' id='right' value='&#8594'/>";
    }
    echo "</form>";
}

//down
$ns = "$_SESSION[ns]" - 1;
$ew = "$_SESSION[ew]";
$sql = "SELECT room_id FROM Available_Rooms_tbl Where ns = '$ns' and ew = '$ew' and map_id = '$_SESSION[map]';";
$result = $conn1->query($sql);
while ($row = $result->fetch_assoc()) {
	echo "<form method='POST' action='game.php?down=true'>
	<input type='hidden' name='down' value='down' />";
    if ($row['room_id'] != NULL){
    	echo "<input type='submit' name='submit' id='down' value='&#8595'/>";
    }
    echo "</form>";
}
?>