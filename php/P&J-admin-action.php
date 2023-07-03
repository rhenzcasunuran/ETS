<?php
include 'database_connect.php';
include 'CAL-logger.php';

$eventCode = $_POST['event_code'];

$eventCode = mysqli_real_escape_string($conn, $eventCode);

$query = "SELECT competition_id FROM ongoing_list_of_event 
          INNER JOIN competition ON ongoing_list_of_event.event_id = competition.event_id 
          WHERE ongoing_list_of_event.event_code = '$eventCode'";

$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$competitionID = $row['competition_id'];

// Process judges
if (isset($_POST['judge_name']) && isset($_POST['judge_nickname']) && !empty($_POST['judge_name']) && !empty($_POST['judge_nickname'])) {
    $judgeNames = $_POST['judge_name'];
    $judgeNicknames = $_POST['judge_nickname'];

    if (is_array($judgeNames) && is_array($judgeNicknames) && count($judgeNames) === count($judgeNicknames)) {
        for ($i = 0; $i < count($judgeNames); $i++) {
            $judgeName = mysqli_real_escape_string($conn, $judgeNames[$i]);
            $judgeNickname = mysqli_real_escape_string($conn, $judgeNicknames[$i]);

            $query = "INSERT INTO judges (competition_id, judge_name, judge_nickname) 
                      VALUES ('$competitionID', '$judgeName', '$judgeNickname')";
            mysqli_query($conn, $query);
        }
    } else {
        echo "Invalid judge names or nicknames.";
    }
}

// Process participants
if (isset($_POST['participant_name']) && isset($_POST['participant_section']) && isset($_POST['organization_id']) &&
    is_array($_POST['participant_name']) && is_array($_POST['participant_section']) && is_array($_POST['organization_id'])) {

    $participantNames = $_POST['participant_name'];
    $participantSections = $_POST['participant_section'];
    $organizationIDs = $_POST['organization_id'];

        for ($i = 0; $i < count($participantNames); $i++) {
            $participantName = mysqli_real_escape_string($conn, $participantNames[$i]);
            $participantSection = mysqli_real_escape_string($conn, $participantSections[$i]);
            $organizationID = mysqli_real_escape_string($conn, $organizationIDs[$i]);

            $query = "INSERT INTO participants (competition_id, organization_id, participant_name, participant_section) 
                      VALUES ('$competitionID', '$organizationID', '$participantName', '$participantSection')";
            mysqli_query($conn, $query);
        }
        
        echo "Participants inserted successfully.";
    
} else {
    echo "Missing participant names, sections, or organization IDs.";
}

header("Location: ../P&J-admin-formPJ.php");

mysqli_close($conn);
?>
