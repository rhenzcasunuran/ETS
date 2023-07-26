<?php
include 'database_connect.php'; // Replace with your database connection file

// Prepare the SQL statement
$sql = "SELECT DISTINCT oen.ongoing_event_name_id, oen.event_name FROM `tournament` AS tou
            INNER JOIN ongoing_list_of_event AS olfe
            ON tou.event_id = olfe.event_id
            INNER JOIN ongoing_event_name AS oen
            ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
            WHERE olfe.event_type_id = 1 
            AND olfe.is_archived = 0 
            AND olfe.is_deleted = 0
            AND tou.has_set_tournament = 1;";

// Execute the SQL query
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    $eventNames = array();

    // Fetch the event names and add them to the $eventNames array
    while ($row = mysqli_fetch_assoc($result)) {
        $event = array(
            'id' => $row['ongoing_event_name_id'],
            'event_name' => $row['event_name']
        );
        $eventNames[] = $event;
    }

    // Convert the array to JSON and echo it as the response
    echo json_encode($eventNames);
} else {
    // Query failed, return an error message
    echo json_encode(array('error' => 'Failed to fetch event names'));
}

// Close the database connection
mysqli_close($conn);
?>
