<?php
include 'database_connect.php';

// Query to retrieve categories and events
$query = "SELECT tou.tournament_id, oen.event_name, DATE_FORMAT(olfe.event_date, '%Y') AS event_year FROM tournament AS tou 
INNER JOIN ongoing_list_of_event AS olfe
ON tou.event_id = olfe.event_id
INNER JOIN event_type AS et
ON olfe.event_type_id = et.event_type_id
INNER JOIN ongoing_event_name AS oen
ON oen.ongoing_event_name_id = olfe.ongoing_event_name_id
WHERE olfe.event_type_id = 1 
AND oen.is_done = 0 
AND olfe.is_archived = 0 
AND olfe.is_deleted = 0
AND tou.has_set_tournament = 0
AND tou.bracket_form_id IS NULL";

$result = mysqli_query($conn, $query);

// Create an array to store all the event data
$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    // Assemble the data and add it to the $data array
    $data[] = array(
        'tournament_id' => $row['tournament_id'],
        'event_name' => $row['event_name'],
        'event_year' => $row['event_year']
    );
}

// Set the response header
header('Content-Type: application/json');

// Return the JSON response
echo json_encode($data);

// Close the database connection
mysqli_close($conn);
?>
