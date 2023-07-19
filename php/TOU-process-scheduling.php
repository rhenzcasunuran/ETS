<?php
include 'database_connect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted values
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $team_one_ids = $_POST['team_one_id'];
    $team_two_ids = $_POST['team_two_id'];
    $event_date_times = $_POST['event_date_time'];

    // Prepare the query
    $query = "UPDATE bracket_teams SET event_date_time = ? WHERE bracket_form_id = ? AND team_one_id = ? AND team_two_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        // Handle the case when the prepared statement couldn't be created
        die("Error: " . mysqli_error($conn));
    }

    // Iterate through the teams and event IDs
    for ($i = 0; $i < count($team_one_ids); $i++) {
        $team_one_id = mysqli_real_escape_string($conn, $team_one_ids[$i]);
        $team_two_id = mysqli_real_escape_string($conn, $team_two_ids[$i]);
        $event_date_time = $_POST['event_date_time'][$i];

        // Format the date and time as per your database datetime format
        // For example, if your database uses 'Y-m-d H:i:s' format, you can use:
        // $formatted_date_time = date('Y-m-d H:i:s', strtotime($event_date_time));

        // Check if the event_date_time is empty (null)
        if (empty($event_date_time)) {
            $event_date_time = null; // Set it as null
        }

        // Bind parameters and execute the statement
        mysqli_stmt_bind_param($stmt, "siii", $event_date_time, $id, $team_one_id, $team_two_id);
        mysqli_stmt_execute($stmt);
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);

    // Redirect to the specified URL
    header("Location: ../TOU-admin-edit-tournament.php?id=" . $id);
    exit(); // Terminate the current script to ensure the redirect takes effect
}
?>
