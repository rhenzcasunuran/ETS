<?php
include 'database_connect.php';

// Start the session
session_start();

// Check if the user is authenticated
if ($_SESSION['authenticated'] === true) {
    if (isset($_POST['save_scores'])) { 
        // Get the submitted scores from the form
        $tempScores = $_POST['criterion_temp_score'];

        // Fetch the ongoing_criterion_ids and participant_ids from the session
        $ongoingCriterionIds = $_SESSION['ongoing_criterion_ids'];
        $participantIds = $_SESSION['participant_ids'];

        // Get the judge ID from the session
        $judgeId = $_SESSION['judge_id'];

        // Insert the scores into the criterion_scoring table
        $insertQuery = "INSERT INTO criterion_scoring (ongoing_criterion_id, participants_ids, criterion_temp_score, judge_id)
                        VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($insertQuery);

        // Iterate over the scores and execute the insert statement
        foreach ($tempScores as $index => $score) {
            // Get the ongoing_criterion_id and participants_id for the current score
            $ongoingCriterionId = $ongoingCriterionIds[$index];
            $participantsId = $participantIds[$index];

            // Bind parameters and execute the statement
            $stmt->bind_param("iiii", $ongoingCriterionId, $participantsId, $score, $judgeId);
            $stmt->execute();
        }
    } elseif (isset($_POST['submit_scores'])) {
        // Transfer scores from criterion_temp_score to criterion_final_score
        $transferQuery = "UPDATE criterion_scoring SET criterion_final_score = criterion_temp_score, criterion_temp_score = NULL";
        $conn->query($transferQuery);
    }
    // Redirect back to the form page or display a success message
    header("Location: ../P&J-admin-scoretab.php");
    exit();
}

$conn->close();
?>
