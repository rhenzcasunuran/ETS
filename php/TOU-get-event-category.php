<?php
// Establish your database connection
include 'database_connect.php';

// Perform the query
$query = "SELECT bf.id, oen.event_name, olfe.category_name FROM `tournament` AS tou
INNER JOIN bracket_forms AS bf 
ON bf.id = tou.bracket_form_id
INNER JOIN ongoing_list_of_event AS olfe
ON olfe.event_id = tou.event_id
INNER JOIN ongoing_event_name AS oen 
ON oen.ongoing_event_name_id = olfe.ongoing_event_name_id
WHERE olfe.event_type_id = 1 
AND oen.is_done = 0 
AND olfe.is_archived = 0 
AND olfe.is_deleted = 0
AND tou.has_set_tournament = 1
AND tou.bracket_form_id IS NOT NULL
AND bf.is_active = 1";
$result = mysqli_query($conn, $query);

// Fetch the results and store them in an array
$matchups = [];
while ($row = mysqli_fetch_assoc($result)) {
  $matchups[] = $row;
}

// Return the results as JSON
echo json_encode($matchups);
?>
