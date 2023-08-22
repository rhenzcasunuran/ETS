<?php
include 'database_connect.php';
include 'P&J-admin-authenticate.php';

// Get the event code and judge name from the request
$data = json_decode(file_get_contents('php://input'), true);
$eventCode = $data['event_code'];
$judgeName = $data['judge_name'];

// Query the ongoing_list_of_event table to get the event ID based on the event code
$eventQuery = "SELECT event_id FROM ongoing_list_of_event WHERE event_code = '$eventCode'";
$eventResult = $conn->query($eventQuery);

if ($eventResult->num_rows > 0) {
  $eventRow = $eventResult->fetch_assoc();
  $eventId = $eventRow['event_id'];

  // Fetch the criteria data using the event ID and judge name
  $criteriaQuery = "SELECT oc.ongoing_criterion_id, oc.criterion_name, oc.criterion_percent
                    FROM ongoing_criterion oc
                    INNER JOIN competition c ON oc.event_id = c.event_id
                    INNER JOIN judges j ON c.competition_id = j.competition_id
                    WHERE c.event_id = $eventId AND j.judge_name = '$judgeName'";

  $criteriaResult = $conn->query($criteriaQuery);

  if ($criteriaResult->num_rows > 0) {
    // Create and display the criteria table
    echo '<table>';
    echo '<tr><th>Criterion Name</th><th>Criterion Points</th></tr>';
    
   // Fetch eligible participants who don't have a criterion_final_score from the judge
$eligibleParticipants = [];

if (isset($_SESSION['participants']) && is_array($_SESSION['participants'])) {
    foreach ($_SESSION['participants'] as $participant) {
        $participantId = $participant['participants_id'];
        
        // Check if the participant has a criterion_final_score from the judge
        $finalScoreQuery = "SELECT criterion_final_score FROM criterion_scoring WHERE participants_id = '$participantId' AND judge_id = '$judgeId'";
        $finalScoreResult = $conn->query($finalScoreQuery);
        $finalScoreRow = $finalScoreResult->fetch_assoc();
        
        // Check if the participant has a criterion_temp_score (optional)
        $tempScoreQuery = "SELECT criterion_temp_score FROM criterion_scoring WHERE participants_id = '$participantId' AND judge_id = '$judgeId'";
        $tempScoreResult = $conn->query($tempScoreQuery);
        $tempScoreRow = $tempScoreResult->fetch_assoc();
        
        // Add the participant to the eligible list if no final score exists, but there's a temp score
        if (empty($finalScoreRow['criterion_final_score']) && !empty($tempScoreRow['criterion_temp_score'])) {
            $eligibleParticipants[] = $participant;
        }
        
        // Add the participant to the eligible list if no scores exist
        if (empty($finalScoreRow['criterion_final_score']) && empty($tempScoreRow['criterion_temp_score'])) {
            $eligibleParticipants[] = $participant;
        }
    }
}
    
    echo '<div class="form-group">
        <label for="participant_select" style="color: rgb(255,255,255);">Select Participant:</label>
        <div style="display: flex;justify-content: center; align-items: center;">
        <select class="form-control" id="participant_select">';
    
    foreach ($eligibleParticipants as $participant) {
        echo '<option value="' . $participant['participants_id'] . '">' . $participant['participant_name'] . '</option>';
    }
    
    echo '</select> 
        </div>
        <input type="hidden" name="selected_participant_id" id="selected_participant_id" value="">
    </div>';
    
    while ($row = $criteriaResult->fetch_assoc()) {
        echo '<tr>';
        echo '<td> <label class="col-form-label" style="color: rgb(255,255,255);">' . $row['criterion_name'] . '</label></td>';
        // Calculate the maximum score based on criterion_percent
        $maxScore = $row['criterion_percent']; // Assuming criterion_percent is a decimal between 0 and 1
    
        echo '<td> <input type="number" class="cforms scoreinp" name="criterion_temp_score[]" style="text-align: center;color: white !important;background: rgba(0,0,0,0.22) !important;" min="1" max="' . $maxScore . '" placeholder="' . $maxScore . '" oninput="checkInputs()" required>';
        echo '<input type="hidden" name="ongoing_criterion_ids[]" value="' . $row['ongoing_criterion_id'] . '"></td>';
        echo '</tr>';
    }

    echo '</table>';
  } else {
    echo 'No criteria found.';
  }
} else {
  echo 'Event not found.';
}

$conn->close();
?>

<script src="../js/P&J-admin-common.js"></script>