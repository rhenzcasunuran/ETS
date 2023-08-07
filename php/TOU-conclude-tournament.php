<?php
include 'database_connect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted values
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // Prepare the SQL statement
    $query = "SELECT ot.team_id AS team_one_id, 
        ot.current_team_status AS team_one_status, 
        ot2.team_id AS team_two_id, 
        ot2.current_team_status AS team_two_status 
        FROM `bracket_teams` AS bt 
        LEFT JOIN bracket_forms AS bf
        ON bf.id = bt.bracket_form_id
        LEFT JOIN ongoing_teams AS ot
        ON ot.id = bt.team_one_id
        LEFT JOIN ongoing_teams AS ot2
        ON ot2.id = bt.team_two_id
        WHERE bt.current_column = bf.current_column
        AND bf.id = ?
        AND (ot.current_team_status = 'won' OR ot2.current_team_status = 'won');";
    $stmt = mysqli_prepare($conn, $query);

    // Bind the $id variable to the prepared statement as a parameter
    mysqli_stmt_bind_param($stmt, "i", $id);

    // Execute the prepared statement
    mysqli_stmt_execute($stmt);

    // Get the result set
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the result and store only the 'won' team IDs and status
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['team_one_status'] === 'won') {
            // Store team one's ID and status
            $teamIdWon = $row['team_one_id'];
            $teamStatus = 'champion';
        }

        if ($row['team_two_status'] === 'won') {
            // Store team two's ID and status
            $teamIdWon = $row['team_two_id'];
            $teamStatus = 'champion';
        }
    }

    // Close the statement
    mysqli_stmt_close($stmt);

    // Perform the insertion into the ongoing_teams table
    $insertQuery = "INSERT INTO ongoing_teams (team_id, bracket_form_id, current_team_status) VALUES (?, ?, ?)";
    $stmtInsert = mysqli_prepare($conn, $insertQuery);

    // Bind the variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmtInsert, "iis", $teamIdWon, $id, $teamStatus);
    mysqli_stmt_execute($stmtInsert);
    // Close the statement and connection
    mysqli_stmt_close($stmtInsert);

    // Prepare the SQL statement
    $updateQuery = "UPDATE bracket_forms SET is_active = 0 WHERE id = ? AND is_active = 1";
    $stmt = mysqli_prepare($conn, $updateQuery);
    // Bind the $id variable to the prepared statement as a parameter
    mysqli_stmt_bind_param($stmt, "i", $id);
    // Execute the prepared statement
    mysqli_stmt_execute($stmt);
    // Close the statement
    mysqli_stmt_close($stmt);
    // Close the connection
    mysqli_close($conn);
}
?>