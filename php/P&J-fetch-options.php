<?php
include 'database_connect.php';

// Query the database to get the options
$sql = "SELECT organization_id, organization_name FROM organization WHERE organization_id >= 1 AND organization_id <= 8"; // Modify 'your_table' with your actual table name
$result = $conn->query($sql);

$options = array();

// Fetch the options and store them in an array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options[] = $row;
    }
}

$conn->close();

// Return the options as JSON
header('Content-Type: application/json');
echo json_encode($options);

?>