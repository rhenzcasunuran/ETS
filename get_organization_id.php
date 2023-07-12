<?php
// Retrieve the organization name from the GET parameters
$organizationName = $_GET['organizationName'];

// Establish a connection to your MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ets";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the SQL statement to retrieve the organization ID
$stmt = $conn->prepare("SELECT team_id FROM tou_team_stat WHERE name = ?");
$stmt->bind_param("s", $organizationName);
$stmt->execute();
$stmt->bind_result($organizationId);
$stmt->fetch();
$stmt->close();

// Close the database connection
$conn->close();

// Return the organization ID as the response
echo $organizationId;
?>