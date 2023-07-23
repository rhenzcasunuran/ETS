<?php
include 'database_connect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted values
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // Check if a champion is about to be declared
    // Prepare the query
    $query = "SELECT COUNT(*) AS active_teams_count FROM ongoing_teams WHERE bracket_form_id = ? AND current_team_status = 'active'";

    $stmt = mysqli_prepare($conn, $query);

    // Bind the bracket_form_id parameter to the prepared statement
    mysqli_stmt_bind_param($stmt, "i", $id); // Use the correct variable $id here

    // Execute the prepared statement
    mysqli_stmt_execute($stmt);

    // Get the result of the query
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the row as an associative array
    $row = mysqli_fetch_assoc($result);

    // Get the count of active teams from the result
    $active_teams_count = $row['active_teams_count'];

    if ($active_teams_count === 1) {
        // Prepare the query
        $query = "UPDATE ongoing_teams SET current_team_status = 'champion' WHERE current_team_status = 'active' AND bracket_form_id = ?";

        $stmt = mysqli_prepare($conn, $query);

        // Bind the bracket_form_id parameter to the prepared statement
        mysqli_stmt_bind_param($stmt, "i", $id); // Use the correct variable $id here

        // Execute the prepared statement
        mysqli_stmt_execute($stmt);

        // Prepare the query
        $query = "UPDATE bracket_forms SET is_active = 0 WHERE id = ?";

        $stmt = mysqli_prepare($conn, $query);

        // Bind the bracket_form_id parameter to the prepared statement
        mysqli_stmt_bind_param($stmt, "i", $id);

        // Execute the prepared statement
        mysqli_stmt_execute($stmt);
    }
}
?>
