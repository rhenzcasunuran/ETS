<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept");

@include 'database_connect.php';

if (!$conn) {
    die("Connection Failed:" . mysqli_connect_error());
}

// Retrieve data from events table based on date and filters
$year = $_GET['year'];
$month = $_GET['month'];
$filters = $_GET['filters'];

// Build the parameter placeholders for the filters
$placeholders = implode(',', array_fill(0, count($filters), '?'));
$sql = "SELECT combined_table.event_id, combined_table.event_name, combined_table.event_type,
        combined_table.category_name, combined_table.event_description, combined_table.event_date,
        TIME_FORMAT(combined_table.event_time, '%h:%i %p') 
        AS event_time
        FROM (
            SELECT event_id, event_name, event_type, category_name, event_description, event_date, event_time
                FROM listofeventtb
                    UNION ALL
                    SELECT event_history_id, event_name, event_type, category_name, event_description, event_date, event_time
                FROM eventhistorytb
        ) AS combined_table
        WHERE YEAR(combined_table.event_date) = ? AND MONTH(combined_table.event_date) = ? AND combined_table.event_type IN ($placeholders);";
$stmt = mysqli_prepare($conn, $sql);
$params = array_merge([$year, $month], $filters);
$types = str_repeat('s', count($params));
mysqli_stmt_bind_param($stmt, $types, ...$params);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    // Fetch results and store them in an array
    $events = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = $row;
    }
    // Return the array as JSON
    echo json_encode($events);
} else {
    // Return an empty array as JSON
    echo json_encode(array());
}

// Close connection
mysqli_close($conn);
?>
