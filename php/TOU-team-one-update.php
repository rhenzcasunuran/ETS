<?php
// Establish your database connection
include 'database_connect.php';

// Check if the ID and score parameters exist in the request
if (isset($_POST['id']) && isset($_POST['score']) && isset($_POST['bracketFormId']) && isset($_POST['teamOneTwoId'])) {
  $selectedId = $_POST['id'];
  $selectedScore = $_POST['score'];
  $selectedBracketFormId = $_POST['bracketFormId'];
  $selectedTeamOneTwoId = $_POST['teamOneTwoId'];
  
  // Prepare the statement
  $query = "SELECT ot.id AS team_one_id, 
              org.organization_name AS team_one_name,
              ot.current_team_status AS team_one_current_status,
              ot.current_set_no AS team_one_current_set,
              ot.current_score AS team_one_current_score,
              ot2.id AS team_two_id, 
              org2.organization_name AS team_two_name,
              ot2.current_team_status AS team_two_current_status,
              ot2.current_set_no AS team_two_current_set,
              ot2.current_score AS team_two_current_score,
              sr.max_value,
              sr.game_type
            FROM `bracket_teams` AS bt 
            INNER JOIN ongoing_teams AS ot 
            ON ot.id = bt.team_one_id
            INNER JOIN ongoing_teams AS ot2 
            ON ot2.id = bt.team_two_id
            INNER JOIN organization AS org 
            ON org.organization_id = bt.team_one_id
            INNER JOIN organization AS org2 
            ON org2.organization_id = bt.team_two_id
            INNER JOIN score_rule AS sr
            ON bt.bracket_form_id = sr.bracket_form_id
            WHERE bt.id = ? AND bt.event_date_time IS NOT NULL AND ot.bracket_form_id = ? AND sr.set_no = ot.current_set_no";
  
  // Prepare the statement
  $stmt = mysqli_prepare($conn, $query);
  
  // Bind the parameters
  mysqli_stmt_bind_param($stmt, "ii", $selectedTeamOneTwoId, $selectedBracketFormId);
  
  // Execute the statement
  mysqli_stmt_execute($stmt);

  // Store the result
  $result = mysqli_stmt_get_result($stmt);

  // Fetch the row
  $row = mysqli_fetch_assoc($result);

  // Close the statement
  mysqli_stmt_close($stmt);

  // Assign the values to variables
  $teamOneId = $row['team_one_id'];
  $teamOneName = $row['team_one_name'];
  $teamOneCurrentStatus = $row['team_one_current_status'];
  $teamOneCurrentSet = $row['team_one_current_set'];
  $teamOneCurrentScore = $row['team_one_current_score'];
  $teamTwoId = $row['team_two_id'];
  $teamTwoName = $row['team_two_name'];
  $teamTwoCurrentStatus = $row['team_two_current_status'];
  $teamTwoCurrentSet = $row['team_two_current_set'];
  $teamTwoCurrentScore = $row['team_two_current_score'];
  $maxValue = $row['max_value'];
  $gameType = $row['game_type'];

  if ($gameType == 'score-based') {
    if (($teamOneCurrentScore == $maxValue || $teamTwoCurrentScore == $maxValue) && ($selectedScore > 0)) {
      if ($teamOneCurrentScore == $maxValue) {
        // Return an error message as JSON
        $response = ['error' => 'Team 1 disable buttons.'];
        echo json_encode($response);
        exit();
      } else {
        // Return an error message as JSON
        $response = ['error' => 'Team 2 disable buttons.'];
        echo json_encode($response);
        exit();
      }
    } else {
      
    }
    // Prepare the statement
    $query = "UPDATE ongoing_teams AS ot
    INNER JOIN score_rule AS sr ON sr.set_no = ot.current_set_no AND ot.bracket_form_id = ?
    SET ot.current_score = 
        CASE
            WHEN ot.current_score + ? <= sr.max_value AND ot.current_score + ? > 0 THEN ot.current_score + ?
            WHEN ot.current_score + ? > sr.max_value THEN sr.max_value
            ELSE 0
        END
    WHERE ot.current_team_status = 'active' AND ot.id = ?";

    $stmt = mysqli_prepare($conn, $query);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "iiiiii", $selectedBracketFormId, $selectedScore, $selectedScore, $selectedScore, $selectedScore, $selectedId);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the number of affected rows
    $affectedRows = mysqli_stmt_affected_rows($stmt);

    // Close the statement
    mysqli_stmt_close($stmt);

    // Check if the updated row's current_score is now 0 or less
    if ($affectedRows > 0) {
      // Perform a SELECT query to retrieve the updated row's current_score
      $query = "SELECT current_score FROM ongoing_teams WHERE id = ?";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "i", $selectedId);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_bind_result($stmt, $currentScore);

      // Fetch the result
      if (mysqli_stmt_fetch($stmt)) {
        // Return the updated score as JSON
        $response = ['current_score' => $currentScore];
        echo json_encode($response);
      } else {
        // Return an error message as JSON
        $response = ['error' => 'Failed to fetch the updated score.'];
        echo json_encode($response);
      }

      // Close the statement
      mysqli_stmt_close($stmt);
    } else {
      // Return an error message as JSON
      $response = ['error' => 'Failed to update the score.'];
      echo json_encode($response);
    }
  }

} else {
  // Return an error message as JSON if the required parameters are missing
  $response = ['error' => 'Missing required parameters.'];
  echo json_encode($response);
}

// Check for any database errors
if (mysqli_error($conn)) {
  $response = ['error' => 'Database error: ' . mysqli_error($conn)];
  echo json_encode($response);
}

// Close the database connection
mysqli_close($conn);
?>
