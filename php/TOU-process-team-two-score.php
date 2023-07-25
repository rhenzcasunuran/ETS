<?php
include 'database_connect.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the data from the POST request
    $idNumber = $_POST['id']; // Team ID number
    $score = $_POST['score']; // Score value (e.g., 1, 2, 3, -1, -2, -3)
    $bracketFormId = $_POST['bracketFormId']; // Bracket Form ID


    // Fetch the score rules for the corresponding bracket form and team ID
    $scoreRuleQuery = "SELECT sr.max_value, ot.current_score FROM ongoing_teams AS ot 
                        INNER JOIN bracket_forms AS bf ON ot.bracket_form_id = bf.id
                        INNER JOIN score_rule AS sr ON sr.bracket_form_id = bf.id
                        WHERE bf.id = ? AND ot.id = ? AND sr.set_no = ot.current_set_no";

    $scoreRuleStmt = $conn->prepare($scoreRuleQuery);
    $scoreRuleStmt->bind_param("ii", $bracketFormId, $idNumber);
    $scoreRuleStmt->execute();
    $scoreRuleResult = $scoreRuleStmt->get_result();

    // Check if there is a matching score rule
    if ($scoreRuleResult->num_rows > 0) {
        // Fetch the score rule data and store them into variables
        $scoreRuleData = $scoreRuleResult->fetch_assoc();
        $maxValue = $scoreRuleData['max_value'];
        $currentScore = $scoreRuleData['current_score'];

        // Close the statement
        $scoreRuleStmt->close();

        if (($maxValue <= $currentScore) && ($score > 0)) {
            // If the update fails, prepare an error response
            $errorResponse = array('error' => 'Team 2 disable buttons.');
            header('Content-Type: application/json');
            echo json_encode($errorResponse);
        } else {
            // Update the team's score in the ongoing_teams table
            // Assuming you have a column named "current_score" to store the score for each team
            $updateQuery = "UPDATE ongoing_teams SET current_score = current_score + ? WHERE id = ? AND bracket_form_id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("iii", $score, $idNumber, $bracketFormId);

            if ($updateStmt->execute()) {
                // Retrieve the updated score for the team
                $selectQuery = "SELECT current_score FROM ongoing_teams WHERE id = ?";
                $selectStmt = $conn->prepare($selectQuery);
                $selectStmt->bind_param("i", $idNumber);
                $selectStmt->execute();
                $result = $selectStmt->get_result();
                $teamData = $result->fetch_assoc();
                $currentScore = $teamData['current_score'];

                // If the current_score is negative, reset it to 0
                if ($currentScore < 0) {
                    $resetQuery = "UPDATE ongoing_teams SET current_score = 0 WHERE id = ? AND bracket_form_id = ?";
                    $resetStmt = $conn->prepare($resetQuery);
                    $resetStmt->bind_param("ii", $idNumber, $bracketFormId);
                    $resetStmt->execute();
                    $currentScore = 0; // Set the current_score to 0
                    $resetStmt->close();
                }

                // If the current_score is max, reset it to max score
                if ($maxValue <= $currentScore) {
                    $resetQuery = "UPDATE ongoing_teams SET current_score = ? WHERE id = ? AND bracket_form_id = ?";
                    $resetStmt = $conn->prepare($resetQuery);
                    $resetStmt->bind_param("iii", $maxValue, $idNumber, $bracketFormId);
                    $resetStmt->execute();
                    $currentScore = $maxValue;
                    $resetStmt->close();
                }

                // Prepare the response data
                $responseData = array(
                    'current_score' => $currentScore,
                );

                // Close the statements
                $updateStmt->close();
                $selectStmt->close();

                // Send the response data as JSON
                header('Content-Type: application/json');
                echo json_encode($responseData);
            } else {
                // If the update fails, prepare an error response
                $errorResponse = array('error' => 'Failed to update the team score.');
                header('Content-Type: application/json');
                echo json_encode($errorResponse);
            }
        }
    } else {
        // If the request method is not POST, handle the error
        http_response_code(405); // Method Not Allowed
        echo 'Error: Only POST requests are allowed for this endpoint.';
    }
}
?>