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
$query = "SELECT competition_name FROM competitions_table";
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
