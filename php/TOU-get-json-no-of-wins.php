<?php
include 'database_connect.php';

// Get the selected event from the AJAX request
$selectedEvent = $_GET['event'];
$selectedCategory = $_GET['category'];

// Query to retrieve categories for the selected event
$query = "SELECT now.number_of_wins, now.number_of_wins_number FROM number_of_wins AS now
            INNER JOIN tournament AS tou
            ON tou.number_of_wins_id = now.number_of_wins_id
            INNER JOIN ongoing_list_of_event AS olfe
            ON tou.event_id = olfe.event_id
            INNER JOIN ongoing_event_name AS oen
            ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
            WHERE oen.event_name = '$selectedEvent'
            AND olfe.category_name = '$selectedCategory'
            AND olfe.event_type_id = 1 
            AND oen.is_done = 0 
            AND olfe.is_archived = 0 
            AND olfe.is_deleted = 0
            AND tou.has_set_tournament = 0;";

$result = mysqli_query($conn, $query);

$number_of_wins = array();
$number_of_wins_number = array();

while ($row = mysqli_fetch_assoc($result)) {
    $number_of_wins[] = $row['number_of_wins'];
    $number_of_wins_number[] = $row['number_of_wins_number'];
}

// Assemble the data
$data = array(
    'number_of_wins' => $number_of_wins,
    'number_of_wins_number' => $number_of_wins_number
);

// Set the response header
header('Content-Type: application/json');

// Return the JSON response
echo json_encode($data);

// Close the database connection
mysqli_close($conn);
?>
