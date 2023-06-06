<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept");

@include 'database_connect.php';

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT organization FROM bar_graph ORDER BY barMeter DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $organizations = array();
  while ($row = $result->fetch_assoc()) {
      $organizations[] = $row['organization'];
  }
  // Return organization names as JSON
  echo json_encode($organizations);
} else {
  echo "No organizations found in the database.";
}

// Close the connection
mysqli_close($conn);
?>
