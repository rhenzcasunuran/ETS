<?php
include 'database_connect.php';

// Assuming you have already established a database connection
$query = 'SELECT bf.id, oen.event_name, olfe.category_name FROM `tournament` AS tou 
INNER JOIN bracket_forms AS bf
ON tou.tournament_id = bf.id
INNER JOIN ongoing_list_of_event AS olfe
ON olfe.event_id = tou.event_id
INNER JOIN ongoing_event_name AS oen
ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
WHERE bf.is_active = 1
AND tou.has_set_tournament = 1
AND tou.bracket_form_id IS NOT NULL
AND olfe.is_archived = 0
AND oen.is_done = 0
AND olfe.is_deleted = 0;';
$result = mysqli_query($conn, $query);

$tournamentData = array();
while ($row = mysqli_fetch_assoc($result)) {
    // Create a new JSON object for the tournament
    $tournament = array(
        'id' => $row['id'],
        'event_name' => $row['event_name'],
        'category_name' => $row['category_name'],
    );

    // Add the tournament object to the $tournamentData array
    $tournamentData[] = $tournament;
}


// Output the response JSON containing the separate tournament data
header('Content-Type: application/json');
echo json_encode($tournamentData);
?>
