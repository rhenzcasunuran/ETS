<?php
// Assuming you have already established a database connection
$eventCode = $_POST['eventCode'];

// Query the database to fetch criteria data based on the event code
// ...

// Simulating fetched criteria data
$criteriaData = [
  ['id' => 1, 'name' => 'Criteria 1', 'score' => 8],
  ['id' => 2, 'name' => 'Criteria 2', 'score' => 9],
  ['id' => 3, 'name' => 'Criteria 3', 'score' => 7],
];

echo json_encode($criteriaData);
?>
