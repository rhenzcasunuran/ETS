<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form values from the POST request
    $bracketFormId = $_POST['bracketFormId'];
    $selectedTeamOneAndTwo = $_POST['selectedTeamOneAndTwo'];

    // Execute the SQL query to fetch data from the database
    include 'database_connect.php';
    
    $query = "SELECT bt.*, 
              ot.id AS team_one_id,
              ot.team_name AS team_one_name,
              ot.current_team_status AS team_one_status,
              ot.current_set_no AS team_one_set_no,
              ot.current_overall_score AS team_one_overall_score,
              ot.current_score AS team_one_score,
              ot2.id AS team_two_id,
              ot2.team_name AS team_two_name,
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
                // If team won the best of put them as 'champion' instead
                if ($teamOneSetNo >= $maxSetNo) {
                    // Team One winning
                    // Copy to same table
                    $query = "INSERT INTO ongoing_teams (team_name, bracket_form_id, current_team_status, current_set_no, current_overall_score)
                    SELECT team_name,
                    bracket_form_id,
                    'champion' AS current_team_status,
                    current_set_no,
                    current_overall_score + 1
                    FROM ongoing_teams
                    WHERE id = ?";

                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamOneId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);

                    // Team One
                    $query = "UPDATE ongoing_teams
                    SET current_team_status = 'won'
                    WHERE id = ?";
            
                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamOneId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);
            
                    // Team Two
                    $query2 = "UPDATE ongoing_teams
                    SET current_team_status = 'lost'
                    WHERE id = ?";
            
                    // Prepare the statement
                    $stmt2 = mysqli_prepare($conn, $query2);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt2, "i", $teamTwoId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt2);
                } else {
                    // Team One winning
                    // Copy to same table
                    $query = "INSERT INTO ongoing_teams (team_name, bracket_form_id, current_team_status, current_set_no, current_overall_score)
                    SELECT team_name,
                    bracket_form_id,
                    'active' AS current_team_status,
                    current_set_no + 1,
                    current_overall_score + 1
                    FROM ongoing_teams
                    WHERE id = ?";

                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamOneId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);

                    // Team One
                    $query = "UPDATE ongoing_teams
                    SET current_team_status = 'won'
                    WHERE id = ?";
            
                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamOneId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);
            
                    // Team Two
                    $query2 = "UPDATE ongoing_teams
                    SET current_team_status = 'lost'
                    WHERE id = ?";
            
                    // Prepare the statement
                    $stmt2 = mysqli_prepare($conn, $query2);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt2, "i", $teamTwoId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt2);
                }
            } else {
                // If team won the best of put them as 'champion' instead
                if ($teamTwoSetNo >= $maxSetNo) {
                    // Team One winning
                    // Copy to same table
                    $query = "INSERT INTO ongoing_teams (team_name, bracket_form_id, current_team_status, current_set_no, current_overall_score)
                    SELECT team_name,
                    bracket_form_id,
                    'champion' AS current_team_status,
                    current_set_no,
                    current_overall_score + 1
                    FROM ongoing_teams
                    WHERE id = ?";

                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamTwoId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);

                    // Team One
                    $query = "UPDATE ongoing_teams
                    SET current_team_status = 'won'
                    WHERE id = ?";
            
                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamTwoId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);
            
                    // Team Two
                    $query2 = "UPDATE ongoing_teams
                    SET current_team_status = 'lost'
                    WHERE id = ?";
            
                    // Prepare the statement
                    $stmt2 = mysqli_prepare($conn, $query2);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt2, "i", $teamOneId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt2);
                } else {
                    // Team Two winning
                    // Copy to same table
                    $query = "INSERT INTO ongoing_teams (team_name, bracket_form_id, current_team_status, current_set_no, current_overall_score)
                    SELECT team_name,
                    bracket_form_id,
                    'active' AS current_team_status,
                    current_set_no + 1,
                    current_overall_score + 1
                    FROM ongoing_teams
                    WHERE id = ?";

                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamTwoId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);

                    $query = "UPDATE ongoing_teams
                    SET current_team_status = 'won'
                    WHERE id = ?";
            
                    // Prepare the statement
                    $stmt = mysqli_prepare($conn, $query);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt, "i", $teamTwoId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt);
            
                    // Team Two
                    $query2 = "UPDATE ongoing_teams
                    SET current_team_status = 'lost'
                    WHERE id = ?";
            
                    // Prepare the statement
                    $stmt2 = mysqli_prepare($conn, $query2);
                    // Bind the form data to the prepared statement parameters
                    mysqli_stmt_bind_param($stmt2, "i", $teamOneId);
                    // Execute the statement
                    mysqli_stmt_execute($stmt2);
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
