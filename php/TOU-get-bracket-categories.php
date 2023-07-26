<?php
include 'database_connect.php';

// Get the selected event from the AJAX request
$selectedEvent = $_GET['eventValue']; // Make sure this matches the data parameter in the second AJAX request

// Query to retrieve categories for the selected event
$query = "SELECT tou.tournament_id, olfe.category_name FROM `tournament` AS tou
            INNER JOIN ongoing_list_of_event AS olfe
            ON tou.event_id = olfe.event_id
            INNER JOIN ongoing_event_name AS oen
            ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
            WHERE olfe.event_type_id = 1 
            AND olfe.is_archived = 0 
            AND olfe.is_deleted = 0
            AND tou.has_set_tournament = 1
            AND oen.ongoing_event_name_id = ?";

// Prepare the statement
$stmt = mysqli_prepare($conn, $query);

// Bind the selected event value to the query parameter
mysqli_stmt_bind_param($stmt, "s", $selectedEvent);

// Execute the query
mysqli_stmt_execute($stmt);

// Get the result set
$result = mysqli_stmt_get_result($stmt);

$categories = array();
while ($row = mysqli_fetch_assoc($result)) {
    $category = array(
        'tournament_id' => $row['tournament_id'],
        'category_name' => $row['category_name']
    );
    $categories[] = $category;
}

// Assemble the data as an associative array
$data = array(
    'categories' => $categories
);

// Set the response header
header('Content-Type: application/json');

// Return the JSON response
echo json_encode($data);

// Close the statement
mysqli_stmt_close($stmt);

// Close the database connection
mysqli_close($conn);
?>
