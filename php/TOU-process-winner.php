<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form values from the POST request
    $bracketFormId = $_POST['bracketFormId'];
    $selectedTeamOneAndTwo = $_POST['selectedTeamOneAndTwo'];

    // Execute the SQL query to fetch data from the database
    include 'database_connect.php';
    
    $query = "SELECT bt.*, 
              ot.id AS team_one_id,
              org.organization_name AS team_one_name,
              ot.current_team_status AS team_one_status,
              ot.current_set_no AS team_one_set_no,
              ot.current_overall_score AS team_one_overall_score,
              ot.current_score AS team_one_score,
              ot2.id AS team_two_id,
              org2.organization_name AS team_two_name,
              ot2.current_team_status AS team_two_status,
              ot2.current_set_no AS team_two_set_no,
              ot2.current_overall_score AS team_two_overall_score,
              ot2.current_score AS team_two_score,
              MAX(sr.set_no) AS max_set_no,            
              sr.max_value,
              sr.game_type,
              sr.set_no
              FROM `bracket_teams` AS bt
              INNER JOIN ongoing_teams AS ot ON ot.id = bt.team_one_id
              INNER JOIN ongoing_teams AS ot2 ON ot2.id = bt.team_two_id
              INNER JOIN organization AS org ON org.organization_id = ot.team_id
              INNER JOIN organization AS org2 ON org2.organization_id = ot2.team_id
              INNER JOIN score_rule AS sr ON sr.bracket_form_id = bt.bracket_form_id
              WHERE bt.id = ? AND bt.bracket_form_id = ?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $selectedTeamOneAndTwo, $bracketFormId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Fetch and store each column into variables
    if ($result && $row = mysqli_fetch_assoc($result)) {
        $teamOneId = $row['team_one_id'];
        $teamOneName = $row['team_one_name'];
        $teamOneStatus = $row['team_one_status'];
        $teamOneSetNo = $row['team_one_set_no'];
        $teamOneOverallScore = $row['team_one_overall_score'];
        $teamOneScore = $row['team_one_score'];
        
        $teamTwoId = $row['team_two_id'];
        $teamTwoName = $row['team_two_name'];
        $teamTwoStatus = $row['team_two_status'];
        $teamTwoSetNo = $row['team_two_set_no'];
        $teamTwoOverallScore = $row['team_two_overall_score'];
        $teamTwoScore = $row['team_two_score'];
        
        $maxSetNo = $row['max_set_no'];
        $maxValue = $row['max_value'];
        $gameType = $row['game_type'];
        $setNo = $row['set_no'];
    }

    if ($gameType == 'score-based') {
        if ($teamTwoScore >= $maxValue || $teamOneScore >= $maxValue) {
            if ($teamTwoScore < $teamOneScore) {
                // If Max Set has been reached
                if (($teamOneOverallScore + $teamTwoOverallScore) === ($maxSetNo - 1)) {
                    // Team One wins the set
                    // Archive scores (Team One)
                    $query = "INSERT INTO tournament_score_archive 
                                (team_id, bracket_form_id, current_team_status,
                                current_overall_score, current_set_no, current_score)
                                SELECT team_id, bracket_form_id, 'won', current_overall_score + 1, current_set_no - 1, current_score
                                FROM ongoing_teams
                                WHERE id = ?";

                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamOneId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);

                    // Archive scores (Team Two)
                    $query = "INSERT INTO tournament_score_archive 
                                (team_id, bracket_form_id, current_team_status,
                                current_overall_score, current_set_no, current_score)
                                SELECT team_id, bracket_form_id, 'lost', current_overall_score, current_set_no - 1, current_score
                                FROM ongoing_teams
                                WHERE id = ?";

                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamTwoId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);

                    // Update team status team 1
                    $query = "UPDATE ongoing_teams
                    SET current_team_status = 'won', 
                    current_overall_score = current_overall_score + 1 
                    WHERE id = ?";
            
                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamOneId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);

                    // Update team status team 2
                    $query = "UPDATE ongoing_teams
                    SET current_team_status = 'lost'
                    WHERE id = ?";
            
                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamTwoId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);
                } else {
                    // Team One wins the set
                    // Archive scores (Team One)
                    $query = "INSERT INTO tournament_score_archive 
                                (team_id, bracket_form_id, current_team_status,
                                current_overall_score, current_set_no, current_score)
                                SELECT team_id, bracket_form_id, 'won', current_overall_score + 1, current_set_no, current_score
                                FROM ongoing_teams
                                WHERE id = ?";

                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamOneId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);

                    // Archive scores (Team Two)
                    $query = "INSERT INTO tournament_score_archive 
                                (team_id, bracket_form_id, current_team_status,
                                current_overall_score, current_set_no, current_score)
                                SELECT team_id, bracket_form_id, 'lost', current_overall_score, current_set_no, current_score
                                FROM ongoing_teams
                                WHERE id = ?";

                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamTwoId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);

                    // Reset and update scores
                    $query = "UPDATE ongoing_teams
                    SET current_overall_score = current_overall_score + 1,
                    current_set_no = current_set_no + 1,
                    current_score = 0
                    WHERE id = ?";
            
                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamOneId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);

                    // Reset score Team Two
                    $query = "UPDATE ongoing_teams
                    SET current_score = 0,
                    current_set_no = current_set_no + 1
                    WHERE id = ?";
            
                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamTwoId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);
                }
               
            } else {
                if (($teamOneOverallScore + $teamTwoOverallScore) === ($maxSetNo - 1)) {
                    // Team Two wins the set
                    // Archive scores (Team One)
                    $query = "INSERT INTO tournament_score_archive 
                                (team_id, bracket_form_id, current_team_status,
                                current_overall_score, current_set_no, current_score)
                                SELECT team_id, bracket_form_id, 'won', current_overall_score + 1, current_set_no - 1, current_score
                                FROM ongoing_teams
                                WHERE id = ?";

                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamOneId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);

                    // Archive scores (Team Two)
                    $query = "INSERT INTO tournament_score_archive 
                                (team_id, bracket_form_id, current_team_status,
                                current_overall_score, current_set_no, current_score)
                                SELECT team_id, bracket_form_id, 'lost', current_overall_score, current_set_no - 1, current_score
                                FROM ongoing_teams
                                WHERE id = ?";

                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamTwoId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);

                    // Update team status team 2
                    $query = "UPDATE ongoing_teams
                    SET current_team_status = 'won', 
                    current_overall_score = current_overall_score + 1 
                    WHERE id = ?";
            
                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamTwoId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);

                    // Update team status team 1
                    $query = "UPDATE ongoing_teams
                    SET current_team_status = 'lost'
                    WHERE id = ?";
            
                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamOneId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);
                } else {
                    // Team Two wins the set
                    // Archive scores (Team Two)
                    $query = "INSERT INTO tournament_score_archive 
                                (team_id, bracket_form_id, current_team_status,
                                current_overall_score, current_set_no, current_score)
                                SELECT team_id, bracket_form_id, 'won', current_overall_score + 1, current_set_no, current_score
                                FROM ongoing_teams
                                WHERE id = ?";

                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamTwoId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);

                    // Archive scores (Team One)
                    $query = "INSERT INTO tournament_score_archive 
                                (team_id, bracket_form_id, current_team_status,
                                current_overall_score, current_set_no, current_score)
                                SELECT team_id, bracket_form_id, 'lost', current_overall_score, current_set_no, current_score
                                FROM ongoing_teams
                                WHERE id = ?";

                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamOneId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);

                    // Reset and update scores
                    $query = "UPDATE ongoing_teams
                    SET current_overall_score = current_overall_score + 1,
                    current_set_no = current_set_no + 1,
                    current_score = 0
                    WHERE id = ?";
            
                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamTwoId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);

                    // Reset score Team One
                    $query = "UPDATE ongoing_teams
                    SET current_score = 0,
                    current_set_no = current_set_no + 1
                    WHERE id = ?";
            
                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamOneId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);
                }
            }
        }
    }
    
    // Close the statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Prepare the response indicating success
    $response = array(
        'success' => true,
        'message' => 'Request completed successfully'
    );

    // Send the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
