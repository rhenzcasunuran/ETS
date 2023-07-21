<?php
include 'database_connect.php';

// Assuming you have already established a database connection
$query = 'SELECT id, event_name, category_name FROM bracket_forms WHERE is_active = 1';
$result = mysqli_query($conn, $query);

$tournamentData = array();
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id']; // Store the 'id' value in the $id variable

    // Assuming you have already established a database connection
    $query2 = "SELECT bf.id, ot.current_set_no, MAX(sr.set_no) AS highest_set_no
        FROM ongoing_teams AS ot
        INNER JOIN score_rule AS sr ON sr.id = ot.current_set_no
        INNER JOIN bracket_forms AS bf ON bf.id = sr.bracket_form_id
        WHERE ot.bracket_form_id = ? AND ot.current_team_status = 'active'
        GROUP BY bf.id";

        // Create a prepared statement
        $stmt = $conn->prepare($query2);

        // Bind the parameter to the prepared statement
        $stmt->bind_param("i", $id);

        // Execute the query
        $stmt->execute();

        // Bind the result to variables
        $stmt->bind_result($id, $currentSetNo, $highestSetNo);

        while ($stmt->fetch()) {
            // Check if current_set_no is greater than highest_set_no
            if (intval($currentSetNo) > intval($highestSetNo)) {
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
}


// Output the response JSON containing the separate tournament data
header('Content-Type: application/json');
echo json_encode($tournamentData);
?>
