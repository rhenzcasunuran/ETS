<?php
// Get the competition name from the GET parameter
$competitionName = $_GET['competitionName'];

// Connect to the PHPMyAdmin database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pupets";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check if there's a schedule for the competition in the competitions_table table
$sql = "SELECT schedule FROM competitions_table WHERE competition_name = '$competitionName'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // There's a schedule for the competition, so return the schedule value
  $row = $result->fetch_assoc();
  $response["schedule"] = $row['schedule'];
} else {
  // There's no schedule for the competition, so return null
  $response['schedule'] = null;
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
