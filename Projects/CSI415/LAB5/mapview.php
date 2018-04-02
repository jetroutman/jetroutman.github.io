<?php
	$sql = "SELECT MAX(ns) FROM Available_Rooms_tbl WHERE map_id = '$_SESSION[editmap]';";
	if ($stmt = $conn->prepare($sql)){
		/*execute query*/
		$stmt->execute();

		/*bind result to temp variable*/
		$stmt->bind_result($temp);
		// Debug Statment
		// echo "Set Variable new next\n";

		/*rebinds variable to another variable thats available outside of function*/
		while ($stmt->fetch()) {
			$maxns = $temp;
		}

		/*Closes Statment*/
		$stmt->close();
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$sql = "SELECT MIN(ns) FROM Available_Rooms_tbl WHERE map_id = '$_SESSION[editmap]';";
	if ($stmt = $conn->prepare($sql)){
		/*execute query*/
		$stmt->execute();

		/*bind result to temp variable*/
		$stmt->bind_result($temp);
		// Debug Statment
		// echo "Set Variable new next\n";

		/*rebinds variable to another variable thats available outside of function*/
		while ($stmt->fetch()) {
			$minns = $temp;
		}

		/*Closes Statment*/
		$stmt->close();
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$sql = "SELECT MAX(ew) FROM Available_Rooms_tbl WHERE map_id = '$_SESSION[editmap]';";
	if ($stmt = $conn->prepare($sql)){
		/*execute query*/
		$stmt->execute();

		/*bind result to temp variable*/
		$stmt->bind_result($temp);
		// Debug Statment
		// echo "Set Variable new next\n";

		/*rebinds variable to another variable thats available outside of function*/
		while ($stmt->fetch()) {
			$maxew = $temp;
		}

		/*Closes Statment*/
		$stmt->close();
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$sql = "SELECT MIN(ew) FROM Available_Rooms_tbl WHERE map_id = '$_SESSION[editmap]';";
	if ($stmt = $conn->prepare($sql)){
		/*execute query*/
		$stmt->execute();

		/*bind result to temp variable*/
		$stmt->bind_result($temp);
		// Debug Statment
		// echo "Set Variable new next\n";

		/*rebinds variable to another variable thats available outside of function*/
		while ($stmt->fetch()) {
			$minew = $temp;
		}

		/*Closes Statment*/
		$stmt->close();
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}


	$nslength = $maxns - $minns + 1;
	$ewlength = $maxew - $minew + 1;
	echo "<div class='roomdisplay'>";
	for($i = $maxns; $i >= $minns; $i--){
		for($j = $minew; $j <= $maxew; $j++){
			$sql = "SELECT room_id, available_room_id FROM Available_Rooms_tbl WHERE ns = '$i' and ew = '$j' and map_id = '$_SESSION[editmap]';";
			$result = $conn->query($sql);
			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					$sql2 = "SELECT room_type FROM Room_tbl WHERE room_id = '$row[room_id]';";
					$result2 = $conn->query($sql2);
					while($row2 = $result2->fetch_assoc()) {
						echo "<div class='".$row2["room_type"]." room' style='width:calc(100% / $ewlength); height:calc(100% / $nslength);'><span class='room-text'>$i, $j</span></div>";
					}
				}
			}else{
				echo "<div class='blank room' style='width:calc(100% / $ewlength); height:calc(100% / $nslength);'></div>";
			}
		}
	}
	echo "</div>";
?>