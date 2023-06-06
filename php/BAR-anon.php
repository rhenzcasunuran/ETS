<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept");

@include 'database_connect.php';

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT isAnon FROM bar_graph";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $isAnon = $row["isAnon"];

    // Return the value as a JSON response
    echo json_encode(array("isAnon" => $isAnon));
} else {
    // Handle the case when no rows are found
    echo json_encode(array("isAnon" => null));
}

// Close the connection
mysqli_close($conn);
?>
