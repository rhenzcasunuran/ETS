<?php
include 'database_connect.php';

// Retrieve the form values
$bracketFormId = $_POST['bracketFormId'];
$scheduledTeamBrackets = $_POST['scheduledTeamBrackets'];
$teamOneName = $_POST['teamOneName'];
$teamTwoName = $_POST['teamTwoName'];

// Prepare the SQL statement
$query = "SELECT bf.id, bf.max_column, bf.current_column, bf.current_column_status,
            ot.id AS team_one_id,
            ot.team_name AS team_one_name,
            ot.current_set_no AS current_team_one_set_no,
            ot.current_overall_score AS current_team_one_overall_score,
            ot.current_score AS current_team_one_score,
            ot.current_team_status AS current_team_one_status,
            ot2.id AS team_two_id,
            ot2.team_name AS team_two_name,
            ot2.current_set_no AS current_team_two_set_no,
            ot2.current_overall_score AS current_team_two_overall_score,
            ot2.current_score AS current_team_two_score,
            ot2.current_team_status AS current_team_two_status,
            MAX(sr.set_no) AS max_set_no,            
            sr.max_value,
            sr.game_type
            FROM `bracket_forms` AS bf
            INNER JOIN bracket_teams AS bt 
            ON bf.id = bt.bracket_form_id
            INNER JOIN ongoing_teams AS ot
            ON ot.id = bt.team_one_id
            INNER JOIN ongoing_teams AS ot2
            ON ot2.id = bt.team_two_id
            INNER JOIN score_rule AS sr
            WHERE bt.id = ? 
                AND bf.id = ? 
                AND ot.team_name = ? 
                AND ot2.team_name = ?";

// Prepare the statement
$stmt = mysqli_prepare($conn, $query);

// Bind the form data to the prepared statement parameters
mysqli_stmt_bind_param($stmt, "iiss", $bracketFormId, $scheduledTeamBrackets, $teamOneName, $teamTwoName);

// Execute the statement
mysqli_stmt_execute($stmt);

// Get the result set
$result = mysqli_stmt_get_result($stmt);

// Check if the query was successful
if ($result) {
    // Fetch the rows from the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Store the values of the columns in variables
        $bfId = $row['id'];
        $bfMaxColumn = $row['max_column'];
        $bfCurrentColumn = $row['current_column'];
        $bfCurrentColumnStatus = $row['current_column_status'];
        $otTeamOneId = $row['team_one_id'];
        $otTeamOneName = $row['team_one_name'];
        $otCurrentSetNo = $row['current_team_one_set_no'];
        $otCurrentOverallScore = $row['current_team_one_overall_score'];
        $otCurrentScore = $row['current_team_one_score'];
        $otCurrentTeamStatus = $row['current_team_one_status'];
        $ot2TeamTwoId = $row['team_two_id'];
        $ot2TeamTwoName = $row['team_two_name'];
        $ot2CurrentSetNo = $row['current_team_two_set_no'];
        $ot2CurrentOverallScore = $row['current_team_two_overall_score'];
        $ot2CurrentScore = $row['current_team_two_score'];
        $ot2CurrentTeamStatus = $row['current_team_two_status'];
        $maxSetNo = $row['max_set_no']; // Retrieve the maximum set_no value
    }

    // Free the result set
    mysqli_free_result($result);
} else {
    // Handle the case when the query fails
    echo "Error executing the query: " . mysqli_error($conn);
}

// If team one is winning
if ($ot2CurrentScore < $otCurrentScore) {
    // Copy team to proceed, if current_set is bigger than the max_set then just put 'champion' in status
    if ($otCurrentSetNo > $maxSetNo) {
        // Team One
        $query = "INSERT INTO `ongoing_teams` (bracket_form_id, team_name, current_overall_score, current_set_no, current_team_status)
          SELECT
              bracket_form_id,
              team_name,
              current_overall_score,
              current_set_no,
              'champion' AS current_team_status
          FROM
              `ongoing_teams`
          WHERE
              bracket_form_id = ? AND id = ?";

        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ii", $bracketFormId, $otTeamOneId);
        $stmt->execute();
        $stmt->close();

        // Team Two
        $query = "UPDATE ongoing_teams
        SET current_team_status = 'lost'
        WHERE bracket_form_id = ? AND id = ?";

        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ii", $bracketFormId, $otTeamTwoId);
        $stmt->execute();
        $stmt->close();

    } else {
        // Prepare the insert statement for updating the ongoing_teams table
        $insertStatement = $conn->prepare("INSERT INTO `ongoing_teams` (bracket_form_id, team_name, current_overall_score, current_set_no, current_team_status)
        SELECT
            bracket_form_id,
            team_name,
            current_overall_score + 1,
            current_set_no + 1,
            'active' AS current_team_status
        FROM
            `ongoing_teams`
        WHERE
            bracket_form_id = ?
            AND id = ?");
        // Bind the parameters
        $insertStatement->bind_param("ii", $bracketFormId, $otTeamOneId);
        // Execute the insert statement
        $insertStatement->execute();

        // Prepare the update statement for team one
        $updateStatementOne = $conn->prepare("UPDATE ongoing_teams
        SET current_team_status = 'win'
        WHERE
            bracket_form_id = ?
            AND id = ?");
        // Bind the parameters
        $updateStatementOne->bind_param("ii", $bracketFormId, $otTeamOneId);
        // Execute the update statement for team one
        $updateStatementOne->execute();

        // Prepare the update statement for team two
        $updateStatementTwo = $conn->prepare("UPDATE ongoing_teams
        SET current_team_status = 'lost'
        WHERE
            bracket_form_id = ?
            AND id = ?");
        // Bind the parameters
        $updateStatementTwo->bind_param("ii", $bracketFormId, $otTeamTwoId);
        // Execute the update statement for team two
        $updateStatementTwo->execute();
    }
} else if ($otCurrentScore < $ot2CurrentScore) {
     // Copy team to proceed, if current_set is bigger than the max_set then just put 'champion' in status
     if ($ot2CurrentSetNo > $maxSetNo) {
        // Team One
        $query = "INSERT INTO `ongoing_teams` (bracket_form_id, team_name, current_overall_score, current_set_no, current_team_status)
        SELECT
            bracket_form_id,
            team_name,
            current_overall_score,
            current_set_no,
            'champion' AS current_team_status
        FROM
            `ongoing_teams`
        WHERE
            bracket_form_id = ? AND id = ?";

        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ii", $bracketFormId, $otTeamTwoId);
        $stmt->execute();
        $stmt->close();

        // Team Two
        $query = "UPDATE ongoing_teams
        SET current_team_status = 'lost'
        WHERE bracket_form_id = ? AND id = ?";

        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ii", $bracketFormId, $otTeamOneId);
        $stmt->execute();
        $stmt->close();
    } else {
        // Prepare the insert statement for updating the ongoing_teams table
        $insertStatement = $conn->prepare("INSERT INTO `ongoing_teams` (bracket_form_id, team_name, current_overall_score, current_set_no, current_team_status)
        SELECT
            bracket_form_id,
            team_name,
            current_overall_score + 1,
            current_set_no + 1,
            'active' AS current_team_status
        FROM
            `ongoing_teams`
        WHERE
            bracket_form_id = ?
            AND id = ?");
        // Bind the parameters
        $insertStatement->bind_param("ii", $bracketFormId, $otTeamTwoId);
        // Execute the insert statement
        $insertStatement->execute();

        // Prepare the update statement for team one
        $updateStatementOne = $conn->prepare("UPDATE ongoing_teams
        SET current_team_status = 'win'
        WHERE
            bracket_form_id = ?
            AND id = ?");
        // Bind the parameters
        $updateStatementOne->bind_param("ii", $bracketFormId, $otTeamTwoId);
        // Execute the update statement for team one
        $updateStatementOne->execute();

        // Prepare the update statement for team two
        $updateStatementTwo = $conn->prepare("UPDATE ongoing_teams
        SET current_team_status = 'lost'
        WHERE
            bracket_form_id = ?
            AND id = ?");
        // Bind the parameters
        $updateStatementTwo->bind_param("ii", $bracketFormId, $otTeamOneId);
        // Execute the update statement for team two
        $updateStatementTwo->execute();
    }
}

// Close the prepared statement
mysqli_stmt_close($stmt);

// Close the database connection
mysqli_close($conn);
?>