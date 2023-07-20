<?php
include 'database_connect.php';


// Start the session
session_start();

// Get the event code and judge name from the request
$data = json_decode(file_get_contents('php://input'), true);

// Check if the user is authenticated
if ($_SESSION['authenticated'] === true) {
    if (isset($_POST['save_scores'])) { 
        // Get the submitted scores from the form
        $tempScores = $_POST['criterion_temp_score'];

        // Get the selected participant ID from the form
        $selectedParticipantId = $_POST['selected_participant_id'];

        // Fetch the ongoing_criterion_ids from the session
        $ongoingCriterionIds = $_SESSION['ongoing_criterion_ids'];
        $participantIds = $_SESSION['participant_ids'];

        $participantScores = array();
        foreach ($participantIds as $index => $participantId) {
            $participantScores[$participantId] = $tempScores[$index];
        }

        // Set the session variable for criterion_temp_score
        $_SESSION['criterion_temp_score'] = $participantScores;

        // Get the judge ID from the session
        $judgeId = $_SESSION['judge_id'];

        // Check if there are existing entries for the given participant, judge, and ongoing criteria
        $existingEntriesQuery = "SELECT * FROM criterion_scoring WHERE participants_id = ? AND judge_id = ?";
        $stmt = $conn->prepare($existingEntriesQuery);
        $stmt->bind_param("ii", $selectedParticipantId, $judgeId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // If there are existing entries, update the scores instead of inserting new ones
            $updateQuery = "UPDATE criterion_scoring SET criterion_temp_score = ? WHERE ongoing_criterion_id = ? AND participants_id = ? AND judge_id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            foreach ($tempScores as $index => $score) {
                // Get the ongoing_criterion_id for the current score
                $ongoingCriterionId = $ongoingCriterionIds[$index];
                // Bind parameters and execute the update statement
                $updateStmt->bind_param("diii", $score, $ongoingCriterionId, $selectedParticipantId, $judgeId);
                $updateStmt->execute();
            }
        } else {
            // If there are no existing entries, insert the scores into the criterion_scoring table for the selected participant
            $insertQuery = "INSERT INTO criterion_scoring (ongoing_criterion_id, participants_id, criterion_temp_score, judge_id)
                            VALUES (?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            foreach ($tempScores as $index => $score) {
                // Get the ongoing_criterion_id for the current score
                $ongoingCriterionId = $ongoingCriterionIds[$index];
                // Bind parameters and execute the insert statement
                $insertStmt->bind_param("iiii", $ongoingCriterionId, $selectedParticipantId, $score, $judgeId);
                $insertStmt->execute();
            }
        }
    } else if (isset($_POST['submit_scores'])) {
         // Get the submitted scores from the form
         $finalScores = $_POST['criterion_temp_score'];

         // Get the selected participant ID from the form
         $selectedParticipantId = $_POST['selected_participant_id'];
 
         // Fetch the ongoing_criterion_ids from the session
         $ongoingCriterionIds = $_SESSION['ongoing_criterion_ids'];
         $participantIds = $_SESSION['participant_ids'];
 
         $participantScores = array();
         foreach ($participantIds as $index => $participantId) {
             $participantScores[$participantId] = $finalScores[$index];
         }
 
         // Set the session variable for criterion_temp_score
         $_SESSION['criterion_temp_score'] = $participantScores;
 
         // Get the judge ID from the session
         $judgeId = $_SESSION['judge_id'];
 
         // Check if there are existing entries for the given participant, judge, and ongoing criteria
         $existingEntriesQuery = "SELECT * FROM criterion_scoring WHERE participants_id = ? AND judge_id = ?";
         $stmt = $conn->prepare($existingEntriesQuery);
         $stmt->bind_param("ii", $selectedParticipantId, $judgeId);
         $stmt->execute();
         $result = $stmt->get_result();
 
         if ($result->num_rows > 0) {
             // If there are existing entries, update the scores instead of inserting new ones
            $updateQuery = "UPDATE criterion_scoring 
            SET criterion_final_score = ?, criterion_temp_score = NULL
            WHERE participants_id = ? AND judge_id = ? AND ongoing_criterion_id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            foreach ($finalScores as $index => $score) {
            // Get the ongoing_criterion_id for the current score
            $ongoingCriterionId = $ongoingCriterionIds[$index];
            // Bind parameters and execute the update statement
            $updateStmt->bind_param("diii", $score, $selectedParticipantId, $judgeId, $ongoingCriterionId);
            $updateStmt->execute();
            }
         } else {
             // If there are no existing entries, insert the scores into the criterion_scoring table for the selected participant
             $insertQuery = "INSERT INTO criterion_scoring (ongoing_criterion_id, participants_id, criterion_final_score, judge_id)
                             VALUES (?, ?, ?, ?)";
             $insertStmt = $conn->prepare($insertQuery);
             foreach ($finalScores as $index => $score) {
                 // Get the ongoing_criterion_id for the current score
                 $ongoingCriterionId = $ongoingCriterionIds[$index];
                 // Bind parameters and execute the insert statement
                 $insertStmt->bind_param("iiii", $ongoingCriterionId, $selectedParticipantId, $score, $judgeId);
                 $insertStmt->execute();
             }
         }
    }
    
    
    
    // Redirect back to the form page or display a success message
    header("Location: ../P&J-admin-scoretab.php");
    exit();
}

$conn->close();
?>
