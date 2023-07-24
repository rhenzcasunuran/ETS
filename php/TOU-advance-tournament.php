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

    // Bind the result to a variable
    mysqli_stmt_bind_result($stmt, $null_teams_count);

    // Fetch the result
    mysqli_stmt_fetch($stmt);

    // Close the statement
    mysqli_stmt_close($stmt);

    // If there are a pair of null 
    if ($null_teams_count === 2) {

    } else if ($null_teams_count === 1) {
      // If there is one null value

    } else {
      // If there are no more null values
    }
}
?>
