<?php
// Establish your database connection
include 'database_connect.php';

// Check if the ID parameter exists in the request
if (isset($_GET['id'])) {
  $selectedId = $_GET['id'];

  // Perform the query with the provided ID
  $query = "SELECT bt.id, ot.id AS team_one_id, ot.team_name AS team_one_name, ot.current_score AS team_one_current_score, ot.current_team_status AS team_one_current_team_status,
    ot2.id AS team_two_id, ot2.team_name AS team_two_name, ot2.current_score AS team_two_current_score, ot2.current_team_status AS team_two_current_team_status
    FROM bracket_teams AS bt
    INNER JOIN bracket_forms AS bf ON bt.bracket_form_id = bf.id
    INNER JOIN ongoing_teams AS ot ON ot.id = bt.team_one_id
    INNER JOIN ongoing_teams AS ot2 ON ot2.id = bt.team_two_id
    WHERE ot.current_team_status = 'active' AND ot2.current_team_status = 'active' AND bt.event_date_time IS NOT NULL AND bt.id = ?";
  
  // Prepare the statement
  $stmt = mysqli_prepare($conn, $query);
  
  // Bind the parameter
  mysqli_stmt_bind_param($stmt, "i", $selectedId);
  
  // Execute the statement
  mysqli_stmt_execute($stmt);
  
  // Get the result
  $result = mysqli_stmt_get_result($stmt);
  
  // Fetch the results and store them in an array
  $matchups = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $matchups[] = $row;
  }

  // Return the results as JSON
  echo json_encode($matchups);
}
?>
