<?php
include 'database_connect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the submitted values
  $id = mysqli_real_escape_string($conn, $_POST['id']);

  // Prepare the SQL statement
  $query = "SELECT COUNT(*) AS null_teams_count FROM ongoing_teams WHERE team_id IS NULL AND bracket_form_id = ?";
  $stmt = mysqli_prepare($conn, $query);

  // Bind the $id variable to the prepared statement as a parameter
  mysqli_stmt_bind_param($stmt, "i", $id);

  // Execute the prepared statement
  mysqli_stmt_execute($stmt);

  // Get the result set
  $result = mysqli_stmt_get_result($stmt);

  // Fetch the result into an associative array
  $row = mysqli_fetch_assoc($result);

  // Get the value of null_teams_count
  $null_teams_count = $row['null_teams_count'];

  // Close the statement
  mysqli_stmt_close($stmt);

  // If there are a pair of null 
  if ($null_teams_count === 2) {

    $query = "SELECT bt.bracket_position, 
                  org.organization_id AS team_one_id, 
                  ot.current_team_status AS team_one_status, 
                  org2.organization_id AS team_two_id, 
                  ot2.current_team_status AS team_two_status
              FROM `bracket_teams` AS bt 
              LEFT JOIN ongoing_teams AS ot ON bt.team_one_id = ot.id
              LEFT JOIN ongoing_teams AS ot2 ON bt.team_two_id = ot2.id
              LEFT JOIN organization AS org ON ot.team_id = org.organization_id
              LEFT JOIN organization AS org2 ON ot2.team_id = org2.organization_id
              WHERE (ot.current_team_status = 'won' OR ot2.current_team_status = 'won' OR ot.team_id IS NULL OR ot2.team_id IS NULL)
              AND bt.bracket_form_id = ?;";

    // Create a prepared statement
    $stmt = $conn->prepare($query);

    // Bind the parameter to the prepared statement
    $stmt->bind_param("i", $id);

    // Execute the query
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Create an array to store the team names
    $wonTeamsArray = array();

    // Fetch the team names that have 'won' and store them in the array
    while ($row = $result->fetch_assoc()) {
      if ($row['team_one_status'] === 'won') {
        $wonTeamsArray[] = $row['team_one_id'];
      }
      if ($row['team_two_status'] === 'won') {
        $wonTeamsArray[] = $row['team_two_id'];
      }
    }

    print_r($wonTeamsArray);
    exit();
  } else if ($null_teams_count === 1) {
    // If there is one null value

  } else {
    // If there are no more null values
  }
}
?>
