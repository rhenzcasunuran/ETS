<?php
include 'database_connect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tournament_id = $_POST['tournament_id'];
    $teams = $_POST['dynamic_input'];
    $numTeams = count($teams);
    // Retrieve the game options
    $gameOptions = $_POST['dynamic-inputs-match-max'];
    $gameType = $_POST['gameTypeSelect'];
    // Array to store team IDs
    $teamIds = array();

    // Generate the parent_ids and node_ids arrays
    $parent_ids = [];
    $node_ids = [];

    for ($i = $numTeams - 1; $i >= 0; $i--) {
        $parent_ids[] = $i;
        if ($i > 0) {
            $parent_ids[] = $i;
        }
    }

    $node_id_start = count($parent_ids);

    // Prepare the SQL statement with parameter placeholders
    $query = "SELECT bf.id FROM tournament AS tou 
                INNER JOIN ongoing_list_of_event AS olfe
                ON tou.event_id = olfe.event_id
                INNER JOIN event_type AS et
                ON olfe.event_type_id = et.event_type_id
                INNER JOIN ongoing_event_name AS oen
                ON oen.ongoing_event_name_id = olfe.ongoing_event_name_id
                INNER JOIN bracket_forms AS bf
                ON bf.id = tou.bracket_form_id
                WHERE olfe.event_type_id = 1 
                AND oen.is_done = 0 
                AND olfe.is_archived = 0 
                AND olfe.is_deleted = 0
                AND tou.has_set_tournament = 0
                AND tou.bracket_form_id IS NULL
                AND tou.tournament_id = ?;";
                $stmt = mysqli_prepare($conn, $query);

    // Bind the form data to the prepared statement parameters
    mysqli_stmt_bind_param($stmt, "i", $tournament_id);

    // Execute the prepared statement
    mysqli_stmt_execute($stmt);

    // Get the result of the query
    $result = mysqli_stmt_get_result($stmt);

    // Check if a record already exists
    if (mysqli_num_rows($result) > 0) {
        // Fetch the ID from the result
        $row = mysqli_fetch_assoc($result);
        $existingRecordId = $row['id'];

        // Redirect to another page with the ID as a query string
        header("Location: ../TOU-admin-edit-tournament.php?id=" . $existingRecordId);
        exit();
    }

    // Prepare the SQL statement to insert data into the bracket_forms table
    $stmt = $conn->prepare("INSERT INTO bracket_forms (node_id_start, parent_id_start) VALUES  (?, ?)");
    $stmt->bind_param("ii", $node_id_start, $numTeams);
    $stmt->execute();

    // Get the ID of the inserted row
    $bracket_form_id = $stmt->insert_id;
    $stmt->close();

    // Insert data into the ongoing_teams table
    $stmt = $conn->prepare("INSERT INTO ongoing_teams (team_id, bracket_form_id) VALUES (?, ?)");
    // Bind parameters and execute the statement for each team
    foreach ($teams as $team_id) {
        $stmt->bind_param("ii", $team_id, $bracket_form_id);
        $stmt->execute();
        // Retrieve the ID of the last inserted row (team)
        $team_id = $stmt->insert_id;
        $teamIds[] = $team_id;
        shuffle($teamIds);
    }
    $stmt->close();

    // Insert data into the score_rule table
    foreach ($gameOptions as $set_no => $max_value) {
        $stmt = $conn->prepare("INSERT INTO score_rule (bracket_form_id, set_no, max_value, game_type) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $bracket_form_id, $set_no, $max_value, $gameType);
        $stmt->execute();
    }
    $stmt->close();

    // Prepare the SQL statement
    $query = "INSERT INTO bracket_teams (bracket_form_id, bracket_position, team_one_id, team_two_id) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    // Initialize bracket_position to 1 before the loop
    $bracket_position = 1;

    // Iterate through the teamIds array
    for ($i = 0; $i < count($teamIds); $i += 2) {
        $teamOneId = $teamIds[$i];

        // Check if a pair of team IDs exists for the current iteration
        if (isset($teamIds[$i + 1])) {
            $teamTwoId = $teamIds[$i + 1];

            // Bind the parameter values to the prepared statement
            mysqli_stmt_bind_param($stmt, "iiii", $bracket_form_id, $bracket_position, $teamOneId, $teamTwoId);
        } else {
            // If there is no second team ID, set it to null
            $teamTwoId = null;

            // Bind the parameter values (with a null value for team_two_id)
            mysqli_stmt_bind_param($stmt, "iii", $bracket_form_id, $bracket_position, $teamOneId);
        }

        // Execute the prepared statement
        mysqli_stmt_execute($stmt);

        // Increment bracket_position for the next iteration
        $bracket_position++;
    }

    $stmt->close();   

    // UPDATE query
    $updateQuery = "UPDATE tournament AS tou
    INNER JOIN ongoing_list_of_event AS olfe 
        ON tou.event_id = olfe.event_id
    INNER JOIN ongoing_event_name AS oen 
        ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
    SET tou.has_set_tournament = 1, tou.bracket_form_id = ?
    WHERE tou.has_set_tournament = 0
    AND olfe.is_archived = 0
    AND olfe.is_deleted = 0
    AND oen.is_done = 0
    AND tou.tournament_id = ?;";

    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ii", $bracket_form_id, $tournament_id);
    $updateStmt->execute();
    // Close the UPDATE statement
    $updateStmt->close();

    // Close the database connection
    $conn->close();

    // Redirect to a success page or perform any other desired actions
    header('Location: ../TOU-admin-manage-tournament.php');
    exit();
}
?>
