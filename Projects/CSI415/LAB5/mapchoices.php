<?php
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

//first display of table
$sql = "SELECT map_id, map_name FROM Map_tbl;";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	// output data of each row
	echo "<form action='edit_map.php' method='GET'>";
    while($row = $result->fetch_assoc()) {
        echo "<label><input type='radio' name='mapname' value='".$row["map_id"]."' checked='checked'>".$row["map_name"]."</label>";
    }
    echo "<label class='radioinputs'><input type='radio' name='mapname' value='new map'>Create a New Map
	<div class='newmap'>Map Name:<input type='text' name='newmap' placeholder='Enter desired map name'><br></div></label>
    <input type='submit' value='Submit'>
	</form>";
} else {
    echo "<form action='edit_map.php' method='GET'>";
    echo "<label class='radioinputs'><input type='radio' name='mapname' value='new map'>Create a New Map
    <div class='newmap'>Map Name:<input type='text' name='newmap' placeholder='Enter desired map name'><br></div></label>
    <input type='submit' value='Submit'>
    </form>";
}
?>