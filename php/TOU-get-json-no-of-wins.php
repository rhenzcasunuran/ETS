<?php
include 'database_connect.php';

// Get the selected event from the AJAX request
$selectedId = $_GET['selectedId'];

// Initialize variables to store the data
$number_of_wins = null;
$number_of_wins_number = null;

// Query to retrieve categories for the selected event
$query = "SELECT tou.tournament_id, now.number_of_wins, now.number_of_wins_number FROM tournament AS tou 
INNER JOIN ongoing_list_of_event AS olfe
ON tou.event_id = olfe.event_id
INNER JOIN event_type AS et
ON olfe.event_type_id = et.event_type_id
INNER JOIN ongoing_event_name AS oen
ON oen.ongoing_event_name_id = olfe.ongoing_event_name_id
INNER JOIN number_of_wins AS now
ON now.number_of_wins_id = tou.number_of_wins_id
WHERE olfe.event_type_id = 1 
AND oen.is_done = 0 
AND olfe.is_archived = 0 
AND olfe.is_deleted = 0
AND tou.has_set_tournament = 0
AND tou.bracket_form_id IS NULL
AND tou.tournament_id = '$selectedId';";

$result = mysqli_query($conn, $query);

// Fetch the first row from the result
if ($row = mysqli_fetch_assoc($result)) {

    // Create an associative array with the data
    $data = array(
        'tournament_id' => $row['tournament_id'],
        'number_of_wins' => $row['number_of_wins'],
        'number_of_wins_number' => $row['number_of_wins_number'],
    );
}

// Set the response header
header('Content-Type: application/json');


// Return the JSON response
echo json_encode($data);

// Close the database connection
mysqli_close($conn);
?>
