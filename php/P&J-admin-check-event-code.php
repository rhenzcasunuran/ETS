<?php
include 'database_connect.php';
include 'CAL-logger.php';

// Start a session
session_start();

// Retrieve the event code from the AJAX request
$eventCode = $_POST['event_code'];

// Query to retrieve judges whose event_code matches the entered value
$sql = "SELECT * FROM judges 
        INNER JOIN competition ON judges.competition_id = competition.event_id
        WHERE competition.event_code = '$eventCode'";

$result = mysqli_query($conn, $sql);

if (!$result) {
  die("Query failed: " . mysqli_error($conn));
}

// Check if there are matching judges
if (mysqli_num_rows($result) > 0) {
  $matchingJudges = array();
  while ($row = $result->fetch_assoc()) {
    $matchingJudges[] = $row;
  }

  // Store the matching judges data in a session variable
  $_SESSION['matching_judges'] = $matchingJudges;
} else {
  // No matching judges found
  $_SESSION['matching_judges'] = array(); // Empty array
}

// Close the database connection if needed
mysqli_close($conn);
?>