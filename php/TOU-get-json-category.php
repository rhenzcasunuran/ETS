<?php
include 'database_connect.php';

// Get the selected event from the AJAX request
$selectedId = $_GET['selectedId'];

// Query to retrieve categories for the selected event
$query = "SELECT tou.tournament_id, olfe.category_name FROM `tournament` AS tou 
INNER JOIN ongoing_list_of_event AS olfe
ON tou.event_id = olfe.event_id
INNER JOIN ongoing_event_name AS oen 
ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
WHERE olfe.event_type_id = 1 
AND oen.is_done = 0 
AND olfe.is_archived = 0 
AND olfe.is_deleted = 0
AND tou.has_set_tournament = 0
AND tou.bracket_form_id IS NULL
AND olfe.ongoing_event_name_id = '$selectedId';";

$result = mysqli_query($conn, $query);

// Create an array to store all the event data
$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    // Assemble the data and add it to the $data array
    $data[] = array(
        'tournament_id' => $row['tournament_id'],
        'category_name' => $row['category_name'],
    );
}

// Set the response header
header('Content-Type: application/json');

// Return the JSON response
echo json_encode($data);

// Close the database connection
mysqli_close($conn);
?>
