<?php
// Execute the SQL query to fetch data from the database
include 'database_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form values from the POST request
    $bracketFormId = $_POST['bracketFormId'];
    $selectedTeamOneAndTwo = $_POST['selectedTeamOneAndTwo'];

    // The SQL query
    $sql = "SELECT ot.id AS team_one_id,
    org.organization_name AS team_one_name,
    ot.current_team_status AS team_one_status,
    ot.current_overall_score AS team_one_overall_score,
    ot.current_score AS team_one_score,
    ot2.id AS team_two_id,
    org2.organization_name AS team_two_name,
    ot2.current_team_status AS team_two_status,
    ot2.current_overall_score AS team_two_overall_score,
    ot2.current_score AS team_two_score,
    MAX(sr.set_no) AS max_set_no,
    sr.max_value,
    sr.game_type
    FROM `bracket_forms` AS bf
    LEFT JOIN bracket_teams AS bt ON bf.id = bt.bracket_form_id
    LEFT JOIN score_rule AS sr ON sr.bracket_form_id = bf.id
    LEFT JOIN ongoing_teams AS ot ON bt.team_one_id = ot.id
    LEFT JOIN ongoing_teams AS ot2 ON bt.team_two_id = ot2.id 
    LEFT JOIN organization AS org ON ot.team_id = org.organization_id
    LEFT JOIN organization AS org2 ON ot2.team_id = org2.organization_id
    WHERE bf.id = ?
    AND bf.is_active = 1
    AND bt.id = ?
    AND bt.current_column = bf.current_column
    AND sr.set_no = ot.current_set_no";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ii", $bracketFormId, $selectedTeamOneAndTwo);

    // Execute the query
    mysqli_stmt_execute($stmt);

    // Fetch the results
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the rows as an associative array
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Now let's put each row in a separate variable
    if (!empty($rows)) {
        $firstRow = $rows[0]; // Assuming you want to access the first row
        $teamOneId = $firstRow['team_one_id'];
        $teamOneName = $firstRow['team_one_name'];
        $teamOneStatus = $firstRow['team_one_status'];
        $teamOneOverallScore = $firstRow['team_one_overall_score'];
        $teamOneScore = $firstRow['team_one_score'];
        $teamTwoId = $firstRow['team_two_id'];
        $teamTwoName = $firstRow['team_two_name'];
        $teamTwoStatus = $firstRow['team_two_status'];
        $teamTwoOverallScore = $firstRow['team_two_overall_score'];
        $teamTwoScore = $firstRow['team_two_score'];
        $maxSetNo = $firstRow['max_set_no'];
        $maxValue = $firstRow['max_value'];
        $gameType = $firstRow['game_type'];
    }
}
    /*
    
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
              LEFT JOIN ongoing_teams AS ot ON ot.id = bt.team_one_id
              LEFT JOIN ongoing_teams AS ot2 ON ot2.id = bt.team_two_id
              LEFT JOIN organization AS org ON org.organization_id = ot.team_id
              LEFT JOIN organization AS org2 ON org2.organization_id = ot2.team_id
              LEFT JOIN score_rule AS sr ON sr.bracket_form_id = bf.id
              LEFT JOIN bracket_forms AS bf ON bf.id = bt.bracket_form_id
              WHERE bt.id = ? 
              AND bf.id = ?
              AND bt.current_column = bf.current_column
              AND sr.set_no = ot.current_set_no";

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
*/
?>
