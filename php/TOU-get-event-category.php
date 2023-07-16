<?php
// Establish your database connection
include 'database_connect.php';

// Perform the query
$query = "SELECT * FROM `bracket_forms` WHERE is_active = 1";
$result = mysqli_query($conn, $query);

// Fetch the results and store them in an array
$matchups = [];
while ($row = mysqli_fetch_assoc($result)) {
  $matchups[] = $row;
}

// Return the results as JSON
echo json_encode($matchups);
?>
