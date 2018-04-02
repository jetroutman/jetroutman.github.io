<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "traindb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT train_num, location, location_timestamp FROM Train_tbl";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	echo "<select id='target'><option value=''>Select a train...</option>";
    while($row = $result->fetch_assoc()) {
        echo "<option value='content_".$row["train_num"]."'>Train ".$row["train_num"]."</option>";
    }
    //echo "</select>";
    echo "</select>";
} else {
    echo "failed on Train_tbl table";
}

$myfilename1 = "LAB3/trainhistory1.txt";
if(file_exists($myfilename1)){
    echo "<div id='content_1' class='inv'>";
	echo file_get_contents($myfilename1);
    echo "</div>";
}
$myfilename2 = "LAB3/trainhistory2.txt";
if(file_exists($myfilename2)){
	echo "<div id='content_2' class='inv'>";
    echo file_get_contents($myfilename2);
    echo "</div>";
}
$myfilename3 = "LAB3/trainhistory3.txt";
if(file_exists($myfilename3)){
	echo "<div id='content_3' class='inv'>";
    echo file_get_contents($myfilename3);
    echo "</div>";
}

?>