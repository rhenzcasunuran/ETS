<?php
include 'database_connect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted values
    $id = $_POST['id'];
    $event_name = $_POST['event_name'];
    $category_name = $_POST['category_name'];
    $team_one_ids = $_POST['team_one_id'];
    $team_two_ids = $_POST['team_two_id'];
    $event_ids = $_POST['event_id'];

    // Iterate through the teams and event IDs
    for ($i = 0; $i < count($team_one_ids); $i++) {
        $team_one_id = $team_one_ids[$i];
        $team_two_id = $team_two_ids[$i];
        $event_id = $event_ids[$i];

        // Check if the event_id is empty (null)
        if (empty($event_id)) {
            $event_id = null; // Set it as null
        }

        $query = "UPDATE bracket_teams SET event_id = ? WHERE bracket_form_id = ? AND team_one_id = ? AND team_two_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "iiii", $event_id, $id, $team_one_id, $team_two_id);
        mysqli_stmt_execute($stmt);
    }

    // Redirect to the specified URL
    header("Location: ../TOU-admin-edit-tournament.php?id=" . $id);
    exit(); // Terminate the current script to ensure the redirect takes effect
}
?>
