<?php
require('database_connect.php');

$selectedEventID = $_POST['event_name'] ?? '';

$query = "SELECT `category_name_id`, `category_name` FROM `ongoing_category_name` WHERE `event_name_id` = '$selectedEventID'";
$result = mysqli_query($conn, $query);

if ($result === false) {
  die('Query Error: ' . mysqli_error($conn));
}

$categories = array();

while ($row = mysqli_fetch_assoc($result)) {
  $categoryID = $row['category_name_id'];
  $categoryName = $row['category_name'];
  $categories[] = array(  
    'categoryID' => $categoryID,
    'categoryName' => $categoryName
  );
}

mysqli_close($conn);

header('Content-type: application/json');
echo json_encode($categories);
?>
