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


//Add route
$sql = "SELECT stop_name FROM Route_tbl WHERE active_stop = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	 echo "<label for='next_destination'>Leads To</label>
	 <select id='next_destination' name='next_destination'>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<option value=".$row["stop_name"].">".$row["stop_name"]."</option>";
    }
    echo "</select>";
} else {
    echo "failed on route table";
}

echo "<label for='waittime'>Leads To Travel Time in Minuites</label>
        <select id='waittime' name='waittime'>
            <option value='1'>:30</option>
            <option value='2'>1:00</option>
            <option value='3'>1:30</option>
            <option value='4'>2:00</option>
            <option value='5'>2:30</option>
            <option value='6'>3:00</option>
            <option value='7'>4:30</option>
            <option value='8'>5:00</option>
        </select>";

//comes from
$sql = "SELECT stop_name FROM Route_tbl WHERE active_stop = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	 echo "<label for='previous_destination'>Comes From</label>
	 <select id='previous_destination' name='previous_destination'>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<option value=".$row["stop_name"].">".$row["stop_name"]."</option>";
    }
    echo "</select>";
} else {
    echo "failed on route table";
}

echo "<label for='fromwaittime'>Comes From Travel Time in Minuites</label>
        <select id='waittime' name='fromwaittime'>
            <option value='1'>:30</option>
            <option value='2'>1:00</option>
            <option value='3'>1:30</option>
            <option value='4'>2:00</option>
            <option value='5'>2:30</option>
            <option value='6'>3:00</option>
            <option value='7'>4:30</option>
            <option value='8'>5:00</option>
        </select>";
?>