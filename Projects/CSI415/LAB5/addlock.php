<?php
$do = "none";
if (isset($_GET["locknsMovedUpper"])){
	$keyns = $_SESSION["ns"] + 1;
	$keyew = $_SESSION["ew"];
	$lockns = $_GET["locknsMovedUpper"];
	$lockew = $_GET["lockewMovedUpper"];
	$do = "update";
}
if (isset($_GET["locknsPlacedUpper"])){
	$keyns = $_SESSION["ns"] + 1;
	$keyew = $_SESSION["ew"];
	$lockns = $_GET["locknsPlacedUpper"];
	$lockew = $_GET["lockewPlacedUpper"];
	$do = "insert";
}
if (isset($_GET["locknsMovedLeft"])){
	$keyns = $_SESSION["ns"];
	$keyew = $_SESSION["ew"] - 1;
	$lockns = $_GET["locknsMovedLeft"];
	$lockew = $_GET["lockewMovedLeft"];
	$do = "update";
}
if (isset($_GET["locknsPlacedLeft"])){
	$keyns = $_SESSION["ns"];
	$keyew = $_SESSION["ew"] - 1;
	$lockns = $_GET["locknsPlacedLeft"];
	$lockew = $_GET["lockewPlacedLeft"];
	$do = "insert";
}
if (isset($_GET["locknsMovedRight"])){
	$keyns = $_SESSION["ns"];
	$keyew = $_SESSION["ew"] + 1;
	$lockns = $_GET["locknsMovedRight"];
	$lockew = $_GET["lockewMovedRight"];
	$do = "update";
}
if (isset($_GET["locknsPlacedRight"])){
	$keyns = $_SESSION["ns"];
	$keyew = $_SESSION["ew"] + 1;
	$lockns = $_GET["locknsPlacedRight"];
	$lockew = $_GET["lockewPlacedRight"];
	$do = "insert";
}
if (isset($_GET["locknsMovedLower"])){
	$keyns = $_SESSION["ns"] - 1;
	$keyew = $_SESSION["ew"];
	$lockns = $_GET["locknsMovedLower"];
	$lockew = $_GET["lockewMovedLower"];
	$do = "update";
}
if (isset($_GET["locknsPlacedLower"])){
	$keyns = $_SESSION["ns"] - 1;
	$keyew = $_SESSION["ew"];
	$lockns = $_GET["locknsPlacedLower"];
	$lockew = $_GET["lockewPlacedLower"];
	$do = "insert";
}
if (isset($_GET["locknsMovedCurrent"])){
	$keyns = $_SESSION["ns"];
	$keyew = $_SESSION["ew"];
	$lockns = $_GET["locknsMovedCurrent"];
	$lockew = $_GET["lockewMovedCurrent"];
	$do = "update";
}
if (isset($_GET["locknsPlacedCurrent"])){
	$keyns = $_SESSION["ns"];
	$keyew = $_SESSION["ew"];
	$lockns = $_GET["locknsPlacedCurrent"];
	$lockew = $_GET["lockewPlacedCurrent"];
	$do = "insert";
}
if ($do == "update"){
	//changes the old location of the lock to the new location
	$sql = "UPDATE Key_Lock_tbl
	SET lock_coor_ns = $lockns, lock_coor_ew = $lockew
	WHERE map_id = '$_SESSION[editmap]' and lock_coor_ns = '$keyns' and lock_coor_ew = '$keyew';";
	if ($conn->query($sql) === TRUE) {
		echo "<script language='javascript'> alert('Lock and Key Room updated'); </script>";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	//updates the available rooms table with the lock that was added
	$sql = "SELECT room_id FROM Available_Rooms_tbl WHERE map_id = '$_SESSION[editmap]' and ns = '$lockns' and ew = '$lockew';";
	$result = $conn->query($sql);
	if ($result ->num_rows > 0){
		$sql2 = "UPDATE Available_Rooms_tbl
		SET room_id = 4
		WHERE map_id = '$_SESSION[editmap]' and ns = '$lockns' and ew = '$lockew';";
		if ($conn->query($sql2) === TRUE) {
			echo "<script language='javascript'> alert('Lock and Key Room updated'); </script>";
		} else {
			echo "Error: " . $sql2 . "<br>" . $conn->error;
		}
	}else{
		$sql2 = "INSERT INTO Available_Rooms_tbl (map_id, ns, ew, room_id) VALUES ('$_SESSION[editmap]', $lockns, $lockew, 4);";
		if ($conn->query($sql2) === TRUE) {
			echo "<script language='javascript'> alert('Lock and Key Room updated'); </script>";
		}else{
			echo "Error: " . $sql2 . "<br>" . $conn->error;
		}
	}
}
if ($do == "insert"){
	$sql = "INSERT INTO key_lock_tbl (map_id, key_coor_ns, key_coor_ew, lock_coor_ns, lock_coor_ew)
	VALUES ('$_SESSION[editmap]', '$keyns', $keyew, $lockns, $lockew);";
	if ($conn->query($sql) === TRUE) {
		echo "<script language='javascript'> alert('Lock and Key Room updated'); </script>";
	} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
	}
	//updates the available rooms table with the lock that was added
	$sql = "SELECT room_id FROM Available_Rooms_tbl WHERE map_id = '$_SESSION[editmap]' and ns = '$lockns' and ew = '$lockew';";
	$result = $conn->query($sql);
	if ($result ->num_rows > 0){
		$sql2 = "UPDATE Available_Rooms_tbl
		SET room_id = 4
		WHERE map_id = '$_SESSION[editmap]' and ns = '$lockns' and ew = '$lockew';";
		if ($conn->query($sql2) === TRUE) {
			echo "<script language='javascript'> alert('Lock and Key Room updated'); </script>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}else{
		$sql2 = "INSERT INTO Available_Rooms_tbl (map_id, ns, ew, room_id) VALUES ('$_SESSION[editmap]', $lockns, $lockew, 4);";
		if ($conn->query($sql2) === TRUE) {
			echo "<script language='javascript'> alert('Lock and Key Room updated'); </script>";
		}else{
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
}
?>