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

// If no filters are selected, use a simpler query
if (empty($filters)) {
    $sql = "SELECT * FROM listofeventtb WHERE YEAR(event_date) = ? AND MONTH(event_date) = ?
    UNION
    SELECT * FROM eventhistorytb WHERE YEAR(event_date) = ? AND MONTH(event_date) = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $year, $month);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    // Build the parameter placeholders for the filters
    $placeholders = implode(',', array_fill(0, count($filters), '?'));
    $sql = "SELECT * FROM (
                SELECT * FROM listofeventtb 
                UNION ALL
                SELECT * FROM eventhistorytb
            ) AS combined_tables
            WHERE YEAR(event_date) = ? AND MONTH(event_date) = ? AND event_type IN ($placeholders)";
    $stmt = mysqli_prepare($conn, $sql);
    $params = array_merge([$year, $month], $filters);
    $types = str_repeat('s', count($params));
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

}

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
