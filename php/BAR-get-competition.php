<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept");

@include 'database_connect.php';

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Write and execute the query
$query = "SELECT * FROM `bar_graph` INNER JOIN organization on bar_graph.organization_id = organization.organization_id INNER JOIN ongoing_event_name on bar_graph.event_name_id = ongoing_event_name.event_name_id;";
$result = mysqli_query($conn, $query);

// Fetch the data
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Return the data as JSON
echo json_encode($data);

// Close the connection
mysqli_close($conn);
?>
