<?php
// fetch_image_info_description.php

// Perform database query to fetch image_info and image_description based on event_id
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['event_id'])) {
    $eventID = mysqli_real_escape_string($conn, $_POST['event_id']);

    // Query to fetch image_info and image_description based on event_id
    $query = "SELECT image_info, image_description FROM highlights WHERE event_id = '$eventID'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $imageInfo = $row['image_info'];
      $imageDescription = $row['image_description'];

      // Create response data
      $response = array(
        'image_info' => $imageInfo,
        'image_description' => $imageDescription
      );

      header('Content-Type: application/json');
      echo json_encode($response);
      exit();
    }
  }
}

// Default response if event_id is not provided or no data found
$response = array(
  'image_info' => '',
  'image_description' => ''
);

header('Content-Type: application/json');
echo json_encode($response);
?>
