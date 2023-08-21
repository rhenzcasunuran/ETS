<?php
if (isset($_POST['competitionName'])) {
    $competitionName = $_POST['competitionName'];

    require 'database_connect.php';

    // Escape the competitionName to prevent SQL injection
    $competitionName = $conn->real_escape_string($competitionName);

    // Get the category ID
    $eventidQuery = $conn->prepare("SELECT event_id FROM ongoing_list_of_event WHERE category_name = ?");
    $eventidQuery->bind_param("s", $competitionName);
    $eventidQuery->execute();
    $eventidResult = $eventidQuery->get_result();

    if ($eventidResult->num_rows > 0) {
        $eventidRow = $eventidResult->fetch_assoc();
        $eventid = $eventidRow["event_id"];

        $compidQuery = $conn->prepare("SELECT competition_id FROM competition WHERE event_id = ?");
        $compidQuery->bind_param("s", $eventid);
        $compidQuery->execute();
        $compidResult = $compidQuery->get_result();
        $compidRow = $compidResult->fetch_assoc();
        $compid = $compidRow["competition_id"];

        // Check if there are participants for this competition
        $participants_query = "SELECT participants_id FROM participants WHERE competition_id = ?";
        $stmt = $conn->prepare($participants_query);
        $stmt->bind_param("i", $compid);
        $stmt->execute();
        $participants_result = $stmt->get_result();
        $participantRow = $participants_result->fetch_assoc();
        $participantid = $participantRow["participants_id"];

        // Check if there are participants
        if ($participants_result->num_rows === 0) {
            echo "grey";
        } else {
            //$judges_sql = "SELECT * FROM judges WHERE competition_id = '$compid'";
            //$judges_result = $conn->query($judges_sql);
            //$criteria_sql = "SELECT * FROM ongoing_criterion WHERE category_name_id = '$eventid'";
            //$criteria_result = $conn->query($criteria_sql);
            // Loop through participants
            while ($participant_row = $participants_result->fetch_assoc()) {
                $participant_id = $participant_row["participants_id"];
                $complete_scores = true; // Assume complete scores initially
        
                // Loop through judges for this participant
                $judges_sql = "SELECT * FROM judges WHERE competition_id = '$compid'";
                $judges_result = $conn->query($judges_sql);
                $judges_result->data_seek(0);
                while ($judge_row = $judges_result->fetch_assoc()) {
                    $judge_id = $judge_row["judge_id"];
            
                    // Loop through criteria for this judge and participant
                    $criteria_sql = "SELECT * FROM ongoing_criterion WHERE category_name_id = '$eventid'";
                    $criteria_result = $conn->query($criteria_sql);
                    $criteria_result->data_seek(0);
                    while ($criterion_row = $criteria_result->fetch_assoc()) {
                        $criterion_id = $criterion_row["ongoing_criterion_id"];
                
                        // Query the criterion_scoring table to get the final score for this participant, judge, and criterion
                        $score_sql = "SELECT criterion_final_score FROM criterion_scoring WHERE ongoing_criterion_id = ? AND participants_id = ? AND judge_id = ?";
                        $stmt = $conn->prepare($score_sql);
                        $stmt->bind_param("iii", $criterion_id, $participant_id, $judge_id);
                        $stmt->execute();
                        $score_result = $stmt->get_result();
                
                        $score_row = $score_result->fetch_assoc();
                        $criterion_score = ($score_row !== null) ? $score_row["criterion_final_score"] : 'No score';
                
                        // Check if score is incomplete (NULL or 0)
                        if ($criterion_score === null || $criterion_score === 0) {
                            $complete_scores = false;
                            break; // No need to check other criteria for this judge
                        }
                    }
            
                    if (!$complete_scores) {
                        break; // No need to check other judges for this participant
                    }
                }
        
        // If scores are complete for this participant, move to the next participant
        if ($complete_scores) {
            continue;
        } else {
            // If scores are incomplete for this participant, echo "grey" and exit loop
            echo "grey";
            break;
        }
    }
    
    // If scores are complete for all participants, echo "notempty"
    if ($complete_scores) {
        echo "notempty";
    }
}

    } else {
        // The competition_name does not exist in the ongoing_list_of_event table
        echo "black";
    }

    $conn->close();
}
?>
