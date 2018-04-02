<?php
$keydo = "none";
if (isset($_GET["keynsMovedUpper"])){
	$lockns = $_SESSION["ns"] + 1;
	$lockew = $_SESSION["ew"];
	$keyns = $_GET["keynsMovedUpper"];
	$keyew = $_GET["keyewMovedUpper"];
	$keydo = "update";
}
if (isset($_GET["keynsPlacedUpper"])){
	$lockns = $_SESSION["ns"] + 1;
	$lockew = $_SESSION["ew"];
	$keyns = $_GET["keynsPlacedUpper"];
	$keyew = $_GET["keyewPlacedUpper"];
	$keydo = "insert";
}
if (isset($_GET["keynsMovedLeft"])){
	$lockns = $_SESSION["ns"];
	$lockew = $_SESSION["ew"] - 1;
	$keyns = $_GET["keynsMovedLeft"];
	$keyew = $_GET["keyewMovedLeft"];
	$keydo = "update";
}
if (isset($_GET["keynsPlacedLeft"])){
	$lockns = $_SESSION["ns"];
	$lockew = $_SESSION["ew"] - 1;
	$keyns = $_GET["keynsPlacedLeft"];
	$keyew = $_GET["keyewPlacedLeft"];
	$keydo = "insert";
}
if (isset($_GET["keynsMovedRight"])){
	$lockns = $_SESSION["ns"];
	$lockew = $_SESSION["ew"] + 1;
	$keyns = $_GET["keynsMovedRight"];
	$keyew = $_GET["keyewMovedRight"];
	$keydo = "update";
}
if (isset($_GET["keynsPlacedRight"])){
	$lockns = $_SESSION["ns"];
	$lockew = $_SESSION["ew"] + 1;
	$keyns = $_GET["keynsPlacedRight"];
	$keyew = $_GET["keyewPlacedRight"];
	$keydo = "insert";
}
if (isset($_GET["keynsMovedLower"])){
	$lockns = $_SESSION["ns"] - 1;
	$lockew = $_SESSION["ew"];
	$keyns = $_GET["keynsMovedLower"];
	$keyew = $_GET["keyewMovedLower"];
	$keydo = "update";
}
if (isset($_GET["keynsPlacedLower"])){
	$lockns = $_SESSION["ns"] - 1;
	$lockew = $_SESSION["ew"];
	$keyns = $_GET["keynsPlacedLower"];
	$keyew = $_GET["keyewPlacedLower"];
	$keydo = "insert";
}
if (isset($_GET["keynsMovedCurrent"])){
	$lockns = $_SESSION["ns"];
	$lockew = $_SESSION["ew"];
	$keyns = $_GET["keynsMovedCurrent"];
	$keyew = $_GET["keyewMovedCurrent"];
	$keydo = "update";
}
if (isset($_GET["keynsPlacedCurrent"])){
	$lockns = $_SESSION["ns"];
	$lockew = $_SESSION["ew"];
	$keyns = $_GET["keynsPlacedCurrent"];
	$keyew = $_GET["keyewPlacedCurrent"];
	$keydo = "insert";
}
if ($keydo == "update"){
	//changes the old location of the lock to the new location
	$sql = "UPDATE Key_Lock_tbl
	SET key_coor_ns = $keyns, key_coor_ew = $keyew
	WHERE map_id = '$_SESSION[editmap]' and key_coor_ns = '$lockns' and key_coor_ew = '$lockew';";
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
		SET room_id = 3
		WHERE map_id = '$_SESSION[editmap]' and ns = '$keyns' and ew = '$keyew';";
		if ($conn->query($sql2) === TRUE) {
			echo "<script language='javascript'> alert('Lock and Key Room updated'); </script>";
		} else {
			echo "Error: " . $sql2 . "<br>" . $conn->error;
		}
	}else{
		$sql2 = "INSERT INTO Available_Rooms_tbl (map_id, ns, ew, room_id) VALUES ('$_SESSION[editmap]', $keyns, $keyew, 3);";
		if ($conn->query($sql2) === TRUE) {
			echo "<script language='javascript'> alert('Lock and Key Room updated'); </script>";
		}else{
			echo "Error: " . $sql2 . "<br>" . $conn->error;
		}
	}
}
if ($keydo == "insert"){
	//inserts a new key
	$sql = "INSERT INTO key_lock_tbl (map_id, key_coor_ns, key_coor_ew, lock_coor_ns, lock_coor_ew)
	VALUES ('$_SESSION[editmap]', '$keyns', $keyew, $lockns, $lockew);";
	if ($conn->query($sql) === TRUE) {
		echo "<script language='javascript'> alert('Lock and Key Room Inserted'); </script>";
	} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
	}
	//updates the available rooms table with the key that was added
	$sql = "SELECT room_id FROM Available_Rooms_tbl WHERE map_id = '$_SESSION[editmap]' and ns = '$keyns' and ew = '$keyew';";
	$result = $conn->query($sql);
	if ($result ->num_rows > 0){
		$sql2 = "UPDATE Available_Rooms_tbl
		SET room_id = 3
		WHERE map_id = '$_SESSION[editmap]' and ns = '$keyns' and ew = '$keyew';";
		if ($conn->query($sql2) === TRUE) {
			echo "<script language='javascript'> alert('Key Room updated'); </script>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}else $sql2 = "INSERT INTO Available_Rooms_tbl (map_id, ns, ew, room_id) VALUES ('$_SESSION[editmap]', $keyns, $keyew, 3);";
	if ($conn->query($sql) === TRUE) {
		echo "<script language='javascript'> alert('Key Room updated'); </script>";
	} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
?>