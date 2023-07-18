<?php
include 'database_connect.php';

// Start the session
session_start();

// Get the authentication data from the request
$data = json_decode(file_get_contents('php://input'), true);
$eventCode = $data['event_code'];
$judgeName = $data['judge_name'];

// Query the ongoing_list_of_event table to get the event ID based on the event code
$eventQuery = "SELECT event_id FROM ongoing_list_of_event WHERE event_code = '$eventCode'";
$eventResult = $conn->query($eventQuery);

if ($eventResult->num_rows > 0) {
  $eventRow = $eventResult->fetch_assoc();
  $eventId = $eventRow['event_id'];

  // Query the competition table to get the competition ID based on the event ID
  $competitionQuery = "SELECT competition_id FROM competition WHERE event_id = '$eventId'";
  $competitionResult = $conn->query($competitionQuery);

  if ($competitionResult->num_rows > 0) {
    $competitionRow = $competitionResult->fetch_assoc();
    $competitionId = $competitionRow['competition_id'];

    // Query the judges table to check if the judge name and competition ID match
    $judgeQuery = "SELECT * FROM judges WHERE competition_id = '$competitionId' AND judge_name = '$judgeName'";
    $judgeResult = $conn->query($judgeQuery);

    if ($judgeResult->num_rows > 0) {
      // Authentication successful
      $_SESSION['authenticated'] = true;

      // Fetch the ongoing_criterion_ids and participant_ids based on the event_id
      $ongoingCriterionQuery = "SELECT oc.ongoing_criterion_id
                                FROM ongoing_criterion oc
                                INNER JOIN competition c ON oc.event_id = c.event_id
                                WHERE c.event_id = '$eventId'";
      $ongoingCriterionResult = $conn->query($ongoingCriterionQuery);

      // Fetch the judge_id from the judge table
    $judgeRow = $judgeResult->fetch_assoc();
    $judgeId = $judgeRow['judge_id'];
    $_SESSION['judge_id'] = $judgeId; // Store the judge ID in the session

      if ($ongoingCriterionResult->num_rows > 0) {
        $ongoingCriterionIds = array();
        while ($row = $ongoingCriterionResult->fetch_assoc()) {
          $ongoingCriterionIds[] = $row['ongoing_criterion_id'];
        }
        $_SESSION['ongoing_criterion_ids'] = $ongoingCriterionIds;
      }

      $participantsQuery = "SELECT participants_id
                            FROM participants
                            WHERE competition_id = '$competitionId'";
      $participantsResult = $conn->query($participantsQuery);

      if ($participantsResult->num_rows > 0) {
        $participantIds = array();
        while ($row = $participantsResult->fetch_assoc()) {
          $participantIds[] = $row['participants_id'];
        }
        $_SESSION['participant_ids'] = $participantIds;
      }

      echo json_encode(array('authenticated' => true));
    } else {
      // Authentication failed
      $_SESSION['authenticated'] = false;
      echo json_encode(array('authenticated' => false));
    }
  } else {
    // Authentication failed
    $_SESSION['authenticated'] = false;
    echo json_encode(array('authenticated' => false));
  }
} else {
  // Authentication failed
  $_SESSION['authenticated'] = false;
  echo json_encode(array('authenticated' => false));
}

?>
