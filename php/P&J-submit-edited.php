<?php
include 'database_connect.php';
include 'CAL-logger.php';

// Retrieve the submitted data and ID
$judge_name = $_POST['judge_name'];
$judge_nick = $_POST['judge_nickname'];
$jude_id = $_POST['judge_id'];

// Update the corresponding row in the database
$sql = "UPDATE judges SET judge_name='$judge_name', judge_nickname='$judge_nick' WHERE judge_id='$jude_id'";

if ($conn->query($sql) === TRUE) {
    echo "Data updated successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>