<?php
// Establish your database connection
include 'database_connect.php';

// Check if the ID and score parameters exist in the request
if (isset($_POST['id']) && isset($_POST['score'])) {
  $selectedId = $_POST['id'];
  $selectedScore = $_POST['score'];

  // Prepare the statement
  $query = "UPDATE ongoing_teams AS ot
  INNER JOIN score_rule AS sr ON sr.set_no = ot.current_set_no AND ot.bracket_form_id = 1
  SET ot.current_score = 
    CASE 
      WHEN ot.current_score > sr.max_value AND ? < 0 THEN ot.current_score + ?
      WHEN ot.current_score > sr.max_value THEN sr.max_value
      ELSE ot.current_score + ?
    END
  WHERE ot.current_team_status = 'active' AND ot.id = ?;";

  $stmt = mysqli_prepare($conn, $query);

  // Bind the parameters
  mysqli_stmt_bind_param($stmt, "iiii", $selectedScore, $selectedScore, $selectedScore, $selectedId);

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
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Check if the current_score is 0 or less
    if ($currentScore <= 0) {
      // Update the current_score column to 0 for the specific row
      $query = "UPDATE ongoing_teams SET current_score = 0 WHERE id = ?";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "i", $selectedId);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);

      // Set the current score to 0
      $currentScore = 0;
    }
    
     // Return the updated score as JSON
     $response = ['current_score' => $currentScore];
     echo json_encode($response);
   } else {
     // Return an error message as JSON
     $response = ['error' => 'Failed to update the score.'];
     echo json_encode($response);
  }
}
?>