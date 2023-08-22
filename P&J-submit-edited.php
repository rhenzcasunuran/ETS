<?php
include 'database_connect.php';
include 'CAL-logger.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the data sent from the client
    $judgeId = $_POST["judgeId"];
    $field = $_POST["field"];
    $updatedValue = $_POST["updatedValue"];

    // Validate the received data, especially the judgeId to ensure it's not null
    if ($judgeId === null) {
        echo "Invalid judgeId";
        exit; // Terminate the script
    }

// Escape and sanitize the input to prevent SQL injection
$field = $conn->real_escape_string($field);
$updatedValue = $conn->real_escape_string($updatedValue);

// Update the database record based on the field
$sql = "UPDATE judges SET $field = '$updatedValue' WHERE judge_id = $judgeId";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
}

// Close the database connection
$conn->close();
} else {
echo "Invalid request method"; // Handle invalid requests
}
?>