<?php
// Retrieve the competition name from the request body
$competitionName = $_GET['competitionName'];

// Connect to the database
require 'database_connect.php';



$competitionNameQuery = "SELECT event_id FROM ongoing_list_of_event WHERE event_id =" . $row["event_id"];
      $competitionNameResult = $conn->query($competitionNameQuery);
      
      if ($competitionNameResult->num_rows > 0) {
          $competitionNameRow = $competitionNameResult->fetch_assoc();
          $competitionName = $competitionNameRow["event_id"];
      } else {
          $competitionName = "Unknown";
      }
      
// Prepare and execute the query to retrieve the schedule
$sql = "SELECT schedule FROM competition WHERE event_id = '$competitionName'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // There's a schedule for the competition, so return the schedule value
  $row = $result->fetch_assoc();
  if ($row['schedule'] === null){
    echo 'no';
  } else {
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
  
} 

$conn->close();
?>
