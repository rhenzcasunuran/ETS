<?php
// Retrieve the competition name from the request body
$competitionName = $_GET['competitionName'];

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pupets";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the query to retrieve the schedule
$sql = "SELECT schedule FROM competitions_table WHERE competition_name = '$competitionName'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // There's a schedule for the competition, so return the schedule value
  $row = $result->fetch_assoc();
  $response["schedule"] = $row['schedule'];
  $datetime = new DateTime($response['schedule']);
  $time = $datetime->format('H:i a');
  $day = $datetime->format('d');
  $month = $datetime->format('m');
  $year = $datetime->format('Y');
  echo json_encode(array(
    'time' => $time,
    'day' => $day,
    'month' => $month,
    'year' => $year
  ));
}

$conn->close();
?>
