<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname1 = "db1";
// Create connection for 1st database
$con = new mysqli($servername, $username, $password, $dbname1);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

	// Creates a list of hyperlinks ans displays them in div tags so that the user can select which map he would to use
	$sql = "SELECT map_id, map_name FROM Map_tbl;";

	echo "<div class='selectMap'>";
	$result = $con->query($sql);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
				echo "<div class='map' style='col-xs-12 col-md-12'><a class='map-text' href='selectMapAction?map=".$row["map_id"]."'>".$row["map_name"]."</a></div>";
		}
	}
	echo "</div>";
?>