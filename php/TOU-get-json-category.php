<?php
include 'database_connect.php';

// Get the selected event from the AJAX request
$selectedEvent = $_GET['event'];

// Query to retrieve categories for the selected event
$query = "SELECT DISTINCT olfe.category_name FROM tournament AS tou 
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
            AND oen.event_name = '$selectedEvent';";

$result = mysqli_query($conn, $query);

$categories = array();
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row['category_name'];
}

// Assemble the data
$data = array(
    'categories' => $categories
);

// Set the response header
header('Content-Type: application/json');

// Return the JSON response
echo json_encode($data);

// Close the database connection
mysqli_close($conn);
?>
