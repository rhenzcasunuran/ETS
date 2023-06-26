<?php
include 'database_connect.php';

// Assuming you have a database connection already established
$query = "SELECT organization_name FROM organization";
$result = mysqli_query($connection, $query);

$options = array();
while ($row = mysqli_fetch_assoc($result)) {
    $options[] = $row['organization_name'];
}

echo json_encode($options);
?>