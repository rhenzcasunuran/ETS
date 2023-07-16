<?php
include 'database_connect.php';

// Query to retrieve categories and events
$query = "SELECT DISTINCT oen.event_name
          FROM ongoing_list_of_event AS olfe
          INNER JOIN ongoing_event_name AS oen ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
          INNER JOIN event_type AS et ON olfe.event_type_id = et.event_type_id
          WHERE olfe.event_type_id = 1 AND oen.is_done = 0 AND olfe.is_archived = 0";

$result = mysqli_query($conn, $query);

$categories = array();
$events = array();
while ($row = mysqli_fetch_assoc($result)) {
    $events[] = $row['event_name'];
}

// Assemble the data
$data = array(
    'events' => $events
);

// Set the response header
header('Content-Type: application/json');

// Return the JSON response
echo json_encode($data);

// Close the database connection
mysqli_close($conn);
?>
