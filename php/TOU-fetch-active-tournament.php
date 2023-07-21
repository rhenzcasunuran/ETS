<?php
include 'database_connect.php';

// Assuming you have already established a database connection
$query = 'SELECT id, event_name, category_name FROM bracket_forms WHERE is_active = 1';
$result = mysqli_query($conn, $query);

$tournamentData = array();
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id']; // Store the 'id' value in the $id variable

    // Assuming you have already established a database connection
    $query2 = "SELECT COUNT(*) AS active_teams_count FROM ongoing_teams WHERE bracket_form_id = ? AND current_team_status = 'active'";

    // Create a prepared statement
    $stmt = $conn->prepare($query2);

    // Bind the parameter to the prepared statement
    $stmt->bind_param("i", $id);

    // Execute the query
    $stmt->execute();

    // Bind the result to a variable
    $stmt->bind_result($activeTeamsCount);

    // Fetch the result
    $stmt->fetch();

    // Close the statement
    $stmt->close();

    // Check if there is only one active team left and declare the champion if needed
    if ($activeTeamsCount === 1) {
        // If true, retrieve the id and add it to the variable
        $concluding_tournament_id = $id;
    } else {
        // If false, set the variable to NULL
        $concluding_tournament_id = NULL;
    }

    // Create a new JSON object for the tournament
    $tournament = array(
        'id' => $row['id'],
        'event_name' => $row['event_name'],
        'category_name' => $row['category_name'],
        'concluding_tournament_id' => $concluding_tournament_id
    );

    // Add the tournament object to the $tournamentData array
    $tournamentData[] = $tournament;
}


// Output the response JSON containing the separate tournament data
header('Content-Type: application/json');
echo json_encode($tournamentData);
?>
