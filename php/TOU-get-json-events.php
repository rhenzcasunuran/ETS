<?php
include 'database_connect.php';

// Query to retrieve categories and events
$query = "SELECT ongoing_event_name_id, event_name, year_created 
FROM `ongoing_event_name`
WHERE is_done = 0;";

$result = mysqli_query($conn, $query);

// Create an array to store all the event data
$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    // Assemble the data and add it to the $data array
    $data[] = array(
        'ongoing_event_name_id' => $row['ongoing_event_name_id'],
        'event_name' => $row['event_name'],
        'year_created' => $row['year_created']
    );
}

// Set the response header
header('Content-Type: application/json');

// Return the JSON response
echo json_encode($data);

// Close the database connection
mysqli_close($conn);
?>
