<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studentdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name, student_num, class, major FROM Student_tbl";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	 echo "<table><tr><th>Name</th><th>Student Number</th><th>Class</th><th>Major</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["name"]."</td><td>".$row["student_num"]."</td><td>".$row["class"]."</td><td>".$row["major"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "failed on student table";
}

$sql = "SELECT course_name, course_num, hours, department FROM Course_tbl";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	 echo "<table><tr><th>Course Name</th><th>Course Number</th><th>Credits</th><th>Department</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["course_name"]."</td><td>".$row["course_num"]."</td><td>".$row["hours"]."</td><td>".$row["department"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "failed on course table";
}

$sql = "SELECT course_num, prerequisite_num FROM Prerequisite_tbl";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	 echo "<table><tr><th>Course Number</th><th>Prerequisite Number</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["course_num"]."</td><td>".$row["prerequisite_num"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "failed on Prerequisite table";
}

$sql = "SELECT section_id, course_num, semester, year, instructor FROM Section_tbl";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	 echo "<table><tr><th>Section ID</th><th>Course Number</th><th>Semester</th><th>Year</th><th>Instructor</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["section_id"]."</td><td>".$row["course_num"]."</td><td>".$row["semester"]."</td><td>".$row["year"]."</td><td>".$row["instructor"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "failed on section table";
}

$sql = "SELECT student_num, section_id, grade FROM Grade_Report_tbl";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	 echo "<table><tr><th>Student Number</th><th>Section ID</th><th>Grade</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["student_num"]."</td><td>".$row["section_id"]."</td><td>".$row["grade"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "failed on Grade Report table";
}

$conn->close();
?>