<?php
include 'database_connect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the submitted values
  $id = mysqli_real_escape_string($conn, $_POST['id']);

  // Prepare the SQL statement
  $query = "SELECT 
              SUM(CASE WHEN ot.team_id IS NULL THEN 1 ELSE 0 END) + 
              SUM(CASE WHEN ot2.team_id IS NULL THEN 1 ELSE 0 END) AS null_teams_count
            FROM bracket_teams bt
            LEFT JOIN ongoing_teams ot ON bt.team_one_id = ot.id
            LEFT JOIN ongoing_teams ot2 ON bt.team_two_id = ot2.id
            LEFT JOIN bracket_forms bf ON bt.bracket_form_id = bf.id
            WHERE bt.current_column = bf.current_column
            AND bf.id = ?;";
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
  if ($null_teams_count == 2) {

    // If there is one null value
    $query = "SELECT ot.team_id AS team_one_id, ot2.team_id AS team_two_id,
                ot.current_team_status AS team_one_status, ot2.current_team_status AS team_two_status
            FROM `ongoing_teams` AS ot
            LEFT JOIN bracket_teams AS bt ON bt.team_one_id = ot.id
            LEFT JOIN ongoing_teams AS ot2 ON ot2.id = bt.team_two_id
            LEFT JOIN bracket_forms AS bf ON bt.bracket_form_id = bf.id
            WHERE bt.bracket_form_id = ?
            AND bt.current_column = bf.current_column
            AND (ot.current_team_status = 'won' AND (ot.team_id IS NULL OR ot.team_id IS NOT NULL))
            OR (ot2.current_team_status = 'won' AND (ot2.team_id IS NULL OR ot2.team_id IS NOT NULL));";

    // Create a prepared statement
    $stmt = $conn->prepare($query);

    // Bind the parameter to the prepared statement
    $stmt->bind_param("i", $id);

    // Execute the query
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    $wonTeamsArray = array();

    // Fetch the team names that have 'won' and store them in the array
    while ($row = $result->fetch_assoc()) {
      if ($row['team_one_status'] === 'won') {
          // Check if team_one_id is NULL
          if ($row['team_one_id'] === null) {
              $wonTeamsArray[] = null;
          } else {
              $wonTeamsArray[] = $row['team_one_id'];
          }
      }

      if ($row['team_two_status'] === 'won') {
          // Check if team_two_id is NULL
          if ($row['team_two_id'] === null) {
              $wonTeamsArray[] = null;
          } else {
              $wonTeamsArray[] = $row['team_two_id'];
          }
      }
    } 

    $stmt->close();

    // Prepare the SQL query
    $query = "SELECT current_column FROM bracket_forms WHERE id = ? AND is_active = 1";

    // Create a prepared statement
    $stmt = $conn->prepare($query);

    // Bind the parameter to the prepared statement as a parameter
    $stmt->bind_param("i", $id);

    // Execute the prepared statement
    $stmt->execute();

    // Bind the result to a variable
    $stmt->bind_result($currentColumn);

    // Fetch the result (there should be only one row returned)
    $stmt->fetch();

    // Close the statement
    $stmt->close();

    $currentColumn++;

    // Prepare the SQL query for inserting data into the desired table
    $insertQuery = "INSERT INTO ongoing_teams (team_id, bracket_form_id, current_team_status) VALUES (?, ?, ?)";

    // Create a prepared statement
    $insertStmt = $conn->prepare($insertQuery);

    // Array to store the inserted IDs
    $insertedIds = array();

    $current_team_status = ['lost', 'active'];

    // Loop through the $wonTeamsArray and insert the data
    for ($i = 0; $i < count($wonTeamsArray); $i++) {
      // Get the team ID for this iteration
      $team_id = $wonTeamsArray[$i];

      // Check if $team_id is NULL and use NULL for the parameter if it is
      if ($team_id === null) {
          // Use NULL for the team_id column
          $insertStmt->bind_param("sis", $team_id, $id, $current_team_status[0]);
      } else {
          // Use the actual value for the team_id column
          $insertStmt->bind_param("iis", $team_id, $id, $current_team_status[1]);
      }

      // Execute the prepared statement to insert the data
      $insertStmt->execute();

      // Store the inserted ID in the array
      $insertedIds[] = $insertStmt->insert_id;
    }

    // Close the insert statement
    $insertStmt->close();

    // Prepare the SQL query for inserting data into the new table
    $insertQuery = "INSERT INTO bracket_teams (bracket_form_id, bracket_position, team_one_id, team_two_id, current_column) VALUES (?,?,?,?,?)";

    // Create a prepared statement
    $insertStmt = $conn->prepare($insertQuery);

    // Reset the bracket_position to 1
    $bracket_position = 1;

    // Loop through the $insertedIds and insert the data
    for ($i = 0; $i < count($insertedIds); $i += 2) {
      // Get the inserted IDs for this iteration
      $team_one_id = $insertedIds[$i];
      $team_two_id = $insertedIds[$i + 1];

      // Bind the values to the prepared statement as parameters
      $insertStmt->bind_param("iiiii", $id, $bracket_position, $team_one_id, $team_two_id, $currentColumn);

      // Execute the prepared statement to insert the data
      $insertStmt->execute();

      // Increment the bracket_position
      $bracket_position++;
    }

    // Close the insert statement
    $insertStmt->close();

    // Prepare the SQL query for updating the current_column
    $updateQuery = "UPDATE bracket_forms SET current_column = current_column + 1 WHERE id = ? AND is_active = 1";

    // Create a prepared statement
    $updateStmt = $conn->prepare($updateQuery);

    // Bind the parameter to the prepared statement as a parameter
    $updateStmt->bind_param("i", $id);

    // Execute the prepared statement to update the current_column
    $updateStmt->execute();

    // Close the update statement
    $updateStmt->close();

    // Prepare the SQL query for the UPDATE statement
    $query = "UPDATE ongoing_teams AS ot 
              LEFT JOIN bracket_teams AS bt ON ot.id = bt.team_one_id
              LEFT JOIN ongoing_teams AS ot2 ON ot2.id = bt.team_two_id
              SET ot.current_team_status = CASE
                  WHEN ot.current_team_status = 'active' AND ot.team_id IS NOT NULL THEN 'won'
                  ELSE ot.current_team_status
              END,
              ot2.current_team_status = CASE
                  WHEN ot2.current_team_status = 'active' AND ot2.team_id IS NOT NULL THEN 'won'
                  ELSE ot2.current_team_status
              END
              WHERE bt.current_column = ?
              AND bt.bracket_form_id = ?
              AND (ot.team_id IS NULL OR ot2.team_id IS NULL)";

    // Create a prepared statement
    $stmt = $conn->prepare($query);

    // Bind the parameters to the prepared statement
    $stmt->bind_param("ii", $currentColumn, $id);

    // Execute the UPDATE query
    $stmt->execute();

    // Close the statement
    $stmt->close();

  } else if ($null_teams_count == 1) {
    // SQL query with a prepared statement
    $sql = "SELECT ot.team_id AS team_one_id, 
              ot.current_team_status AS team_one_status, 
              ot2.team_id AS team_two_id, 
              ot2.current_team_status AS team_two_status
            FROM bracket_teams bt
            LEFT JOIN bracket_forms bf ON bf.id = bt.bracket_form_id
            LEFT JOIN ongoing_teams ot ON ot.id = bt.team_one_id
            LEFT JOIN ongoing_teams ot2 ON ot2.id = bt.team_two_id
            WHERE bt.current_column = bf.current_column
            AND bt.bracket_form_id = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the parameter to the prepared statement
    $stmt->bind_param("i", $id);

    // Execute the query
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    $wonTeamsArray = array();

    // Fetch the team names that have 'won' and store them in the array
    while ($row = $result->fetch_assoc()) {
      if ($row['team_one_status'] === 'won') {
          // Check if team_one_id is NULL
          if ($row['team_one_id'] === null) {
              $wonTeamsArray[] = null;
          } else {
              $wonTeamsArray[] = $row['team_one_id'];
          }
      }

      if ($row['team_two_status'] === 'won') {
          // Check if team_two_id is NULL
          if ($row['team_two_id'] === null) {
              $wonTeamsArray[] = null;
          } else {
              $wonTeamsArray[] = $row['team_two_id'];
          }
      }
    } 

    $stmt->close();

    // Prepare the SQL query
    $query = "SELECT current_column FROM bracket_forms WHERE id = ? AND is_active = 1";

    // Create a prepared statement
    $stmt = $conn->prepare($query);

    // Bind the parameter to the prepared statement as a parameter
    $stmt->bind_param("i", $id);

    // Execute the prepared statement
    $stmt->execute();

    // Bind the result to a variable
    $stmt->bind_result($currentColumn);

    // Fetch the result (there should be only one row returned)
    $stmt->fetch();

    // Close the statement
    $stmt->close();

    $currentColumn++;

    // Prepare the SQL query for inserting data into the desired table
    $insertQuery = "INSERT INTO ongoing_teams (team_id, bracket_form_id, current_team_status) VALUES (?, ?, ?)";

    // Create a prepared statement
    $insertStmt = $conn->prepare($insertQuery);

    // Array to store the inserted IDs
    $insertedIds = array();

    $current_team_status = ['lost', 'active'];

    // Loop through the $wonTeamsArray and insert the data
    for ($i = 0; $i < count($wonTeamsArray); $i++) {
     // Get the team ID for this iteration
     $team_id = $wonTeamsArray[$i];

     // Check if $team_id is NULL and use NULL for the parameter if it is
     if ($team_id === null) {
         // Use NULL for the team_id column
         $insertStmt->bind_param("sis", $team_id, $id, $current_team_status[0]);
     } else {
         // Use the actual value for the team_id column
         $insertStmt->bind_param("iis", $team_id, $id, $current_team_status[1]);
     }

     // Execute the prepared statement to insert the data
     $insertStmt->execute();

     // Store the inserted ID in the array
     $insertedIds[] = $insertStmt->insert_id;
    }

    // Close the insert statement
    $insertStmt->close();

    // Prepare the SQL query for inserting data into the new table
    $insertQuery = "INSERT INTO bracket_teams (bracket_form_id, bracket_position, team_one_id, team_two_id, current_column) VALUES (?,?,?,?,?)";

    // Create a prepared statement
    $insertStmt = $conn->prepare($insertQuery);

    // Reset the bracket_position to 1
    $bracket_position = 1;

    // Loop through the $insertedIds and insert the data
    for ($i = 0; $i < count($insertedIds); $i += 2) {
      // Get the inserted IDs for this iteration
      $team_one_id = $insertedIds[$i];
      $team_two_id = $insertedIds[$i + 1];

      // Bind the values to the prepared statement as parameters
      $insertStmt->bind_param("iiiii", $id, $bracket_position, $team_one_id, $team_two_id, $currentColumn);

      // Execute the prepared statement to insert the data
      $insertStmt->execute();

      // Increment the bracket_position
      $bracket_position++;
    }

    // Close the insert statement
    $insertStmt->close();

    // Prepare the SQL query for updating the current_column
    $updateQuery = "UPDATE bracket_forms SET current_column = current_column + 1 WHERE id = ? AND is_active = 1";

    // Create a prepared statement
    $updateStmt = $conn->prepare($updateQuery);

    // Bind the parameter to the prepared statement as a parameter
    $updateStmt->bind_param("i", $id);

    // Execute the prepared statement to update the current_column
    $updateStmt->execute();

    // Close the update statement
    $updateStmt->close();
  } else {
    // If there are no more null values
    // SQL query with a prepared statement
    $sql = "SELECT ot.team_id AS team_one_id, 
    ot.current_team_status AS team_one_status, 
    ot2.team_id AS team_two_id, 
    ot2.current_team_status AS team_two_status
    FROM bracket_teams bt
    LEFT JOIN bracket_forms bf ON bf.id = bt.bracket_form_id
    LEFT JOIN ongoing_teams ot ON ot.id = bt.team_one_id
    LEFT JOIN ongoing_teams ot2 ON ot2.id = bt.team_two_id
    WHERE bt.current_column = bf.current_column
    AND bt.bracket_form_id = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the parameter to the prepared statement
    $stmt->bind_param("i", $id);

    // Execute the query
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

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

    $stmt->close();

    // Prepare the SQL query
    $query = "SELECT current_column FROM bracket_forms WHERE id = ? AND is_active = 1";

    // Create a prepared statement
    $stmt = $conn->prepare($query);

    // Bind the parameter to the prepared statement as a parameter
    $stmt->bind_param("i", $id);

    // Execute the prepared statement
    $stmt->execute();

    // Bind the result to a variable
    $stmt->bind_result($currentColumn);

    // Fetch the result (there should be only one row returned)
    $stmt->fetch();

    // Close the statement
    $stmt->close();

    $currentColumn++;

    // Prepare the SQL query for inserting data into the desired table
    $insertQuery = "INSERT INTO ongoing_teams (team_id, bracket_form_id) VALUES (?, ?)";

    // Create a prepared statement
    $insertStmt = $conn->prepare($insertQuery);

    // Array to store the inserted IDs
    $insertedIds = array();

    // Loop through the $wonTeamsArray and insert the data
    for ($i = 0; $i < count($wonTeamsArray); $i++) {
      // Get the team ID for this iteration
      $team_id = $wonTeamsArray[$i];
          
      // Use the actual value for the team_id column
      $insertStmt->bind_param("ii", $team_id, $id);

      // Execute the prepared statement to insert the data
      $insertStmt->execute();

      // Store the inserted ID in the array
      $insertedIds[] = $insertStmt->insert_id;
    }

    // Close the insert statement
    $insertStmt->close();

    // Prepare the SQL query for inserting data into the new table
    $insertQuery = "INSERT INTO bracket_teams (bracket_form_id, bracket_position, team_one_id, team_two_id, current_column) VALUES (?,?,?,?,?)";

    // Create a prepared statement
    $insertStmt = $conn->prepare($insertQuery);

    // Reset the bracket_position to 1
    $bracket_position = 1;

    // Loop through the $insertedIds and insert the data
    for ($i = 0; $i < count($insertedIds); $i += 2) {
      // Get the inserted IDs for this iteration
      $team_one_id = $insertedIds[$i];
      $team_two_id = $insertedIds[$i + 1];

      // Bind the values to the prepared statement as parameters
      $insertStmt->bind_param("iiiii", $id, $bracket_position, $team_one_id, $team_two_id, $currentColumn);

      // Execute the prepared statement to insert the data
      $insertStmt->execute();

      // Increment the bracket_position
      $bracket_position++;
    }

    // Close the insert statement
    $insertStmt->close();

    // Prepare the SQL query for updating the current_column
    $updateQuery = "UPDATE bracket_forms SET current_column = current_column + 1 WHERE id = ? AND is_active = 1";

    // Create a prepared statement
    $updateStmt = $conn->prepare($updateQuery);

    // Bind the parameter to the prepared statement as a parameter
    $updateStmt->bind_param("i", $id);

    // Execute the prepared statement to update the current_column
    $updateStmt->execute();

    // Close the update statement
    $updateStmt->close();
  }

  // Close the database connection
  $conn->close();
  exit();
}
?>
