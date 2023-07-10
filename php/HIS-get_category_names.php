<?php
include('./database_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['eventID'])) {
    $eventID = $_POST['eventID'];
    
    // Query to fetch category names based on the event ID
    $query = "SELECT DISTINCT `category_name` FROM `ongoing_list_of_event` WHERE `event_name_id` = '$eventID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
      if (mysqli_num_rows($result) > 0) {
        // Build the HTML options for category name dropdown
        $options = '<option value="" selected disabled>Select Category</option>';
        while ($row = mysqli_fetch_assoc($result)) {
          $categoryName = $row['category_name'];
          $options .= '<option value="' . $categoryName . '">' . $categoryName . '</option>';
        }
        echo $options;
      } else {
        echo '<option value="" selected disabled>No categories found</option>';
      }
    } else {
      echo '<option value="" selected disabled>Error retrieving categories</option>';
    }
  } else {
    echo '<option value="" selected disabled>Invalid event ID</option>';
  }
} else {
  echo '<option value="" selected disabled>Invalid request</option>';
}

mysqli_close($conn);
?>
