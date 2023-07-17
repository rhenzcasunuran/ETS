<?php
include 'database_connect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted form data
    $event_name = $_POST['event_name'];
    $category_name = $_POST['category_name'];
    $teams = $_POST['dynamic_input'];
    $numTeams = count($teams);
    // Retrieve the game options
    $gameOptions = $_POST['game_options'];
    $gameType = $_POST['gameTypeSelect'];
    // Array to store team IDs
    $teamIds = array();

    // Prepare the SQL statement with parameter placeholders
    $query = "SELECT id FROM `bracket_forms` WHERE event_name = ? AND category_name = ? AND is_active = 1";
    $stmt = mysqli_prepare($conn, $query);

    // Bind the form data to the prepared statement parameters
    mysqli_stmt_bind_param($stmt, "ss", $event_name, $category_name);

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

    function reverseFibonacci($numTeams) {
        $fibonacci = array();
        $divisions = 0;
    
        while ($numTeams > 1) {
            $fibonacci[] = $numTeams;
            $numTeams = $numTeams / 2;
            $divisions++;
        }
    
        $fibonacci[] = 1; // Include 1 in the sequence
        $divisions++; // Increment divisions by 1
    
        return $divisions;
    }
    
    $max_column = reverseFibonacci($numTeams);

    // Prepare the SQL statement to insert data into the bracket_forms table
    $stmt = $conn->prepare("INSERT INTO bracket_forms (max_column, category_name, event_name) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $max_column, $category_name, $event_name);
    $stmt->execute();

    // Get the ID of the inserted row
    $bracket_form_id = $stmt->insert_id;
    $stmt->close();

    // Insert data into the ongoing_teams table
    $stmt = $conn->prepare("INSERT INTO ongoing_teams (team_name, bracket_form_id) VALUES (?, ?)");
    // Bind parameters and execute the statement for each team
    foreach ($teams as $team_name) {
        $stmt->bind_param("si", $team_name, $bracket_form_id);
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
    $query = "INSERT INTO bracket_teams (bracket_form_id, team_one_id, team_two_id) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    // Iterate through the teamIds array
    for ($i = 0; $i < count($teamIds); $i += 2) {
        $teamOneId = $teamIds[$i];

        // Check if a pair of team IDs exists for the current iteration
        if (isset($teamIds[$i + 1])) {
            $teamTwoId = $teamIds[$i + 1];

            // Bind the parameter values to the prepared statement
            mysqli_stmt_bind_param($stmt, "iii", $bracket_form_id, $teamOneId, $teamTwoId);
        } else {
            // If there is no second team ID, set it to null
            $teamTwoId = null;

            // Bind the parameter values (with a null value for team_two_id)
            mysqli_stmt_bind_param($stmt, "ii", $bracket_form_id, $teamOneId);
        }

        // Execute the prepared statement
        mysqli_stmt_execute($stmt);
    }

    $stmt->close();

    function generateSequence($numItems)
    {
        $sequence = [0];
        $currentNum = 1;

        for ($i = 1; $i < $numItems; $i++) {
            $sequence[] = $currentNum;
            $sequence[] = $currentNum;
            $currentNum++;
        }

        return $sequence;
    }

    $result = generateSequence($numTeams);

    // Prepare the SQL statement
    $query = "INSERT INTO bracket_teams_state (bracket_form_id, node_id, parent_id) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    for ($i = count($result) - 1; $i >= 0; $i--) {
        $node_id = $i + 1;
        $parent_id = $result[$i];

        mysqli_stmt_bind_param($stmt, "iii", $bracket_form_id, $node_id, $parent_id);
        mysqli_stmt_execute($stmt);
    }

    $reversedTeamIds = array_reverse($teamIds);

    foreach ($reversedTeamIds as $teamId) {
    
        // Prepare the SQL update query with LIMIT 1
        $sql = "UPDATE bracket_teams_state
                SET team_id = ?
                WHERE bracket_form_id = ?
                  AND team_id IS NULL
                LIMIT 1";
    
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $teamId, $bracket_form_id);
        mysqli_stmt_execute($stmt);
    }    
    
    // Close the statement and connection
    mysqli_stmt_close($stmt);    
    
    // Close the database connection
    $conn->close();

    // Redirect to a success page or perform any other desired actions
    header('Location: ../TOU-admin-manage-tournament.php');
    exit();
}
?>
