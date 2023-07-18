<?php
include 'database_connect.php';

// Retrieve the values from the AJAX request
$event_name = isset($_POST['event_name']) ? $_POST['event_name'] : '';
$category_name = isset($_POST['category_name']) ? $_POST['category_name'] : '';

// Prepare the SQL statement
$query = "SELECT olfe.event_id, oen.event_name FROM ongoing_list_of_event AS olfe 
INNER JOIN ongoing_event_name AS oen 
  ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
INNER JOIN tournament AS tou
  ON tou.event_id = olfe.event_id
WHERE oen.event_name = 'Buwan ng Wika'
AND olfe.category_name = 'Chess' 
AND olfe.event_type_id = 1 
AND oen.is_done = 0 
AND olfe.is_archived = 0 
AND tou.has_set_tournament = 0
AND olfe.is_deleted = 0;";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ss", $event_name, $category_name);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Fetch the event IDs from the result
$eventIds = [];
while ($row = mysqli_fetch_assoc($result)) {
    $eventIds[] = $row['event_id'];
}

// Close the statement and database connection
mysqli_stmt_close($stmt);
mysqli_close($conn);

// Return the event IDs as a JSON response
echo json_encode($eventIds);
?>
