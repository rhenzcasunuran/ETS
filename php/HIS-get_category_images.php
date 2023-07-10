<?php
require('database_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if the required field is filled
  if (empty($_POST['categoryName'])) {
    echo "Please provide a category name!";
    exit();
  }

  $categoryName = $_POST['categoryName'];

  // Retrieve the images for the selected category
  $query = "SELECT h.filename
            FROM highlights h
            JOIN ongoing_list_of_event o ON h.event_id = o.event_id
            WHERE o.category_name = '$categoryName'";
  $result = mysqli_query($conn, $query);

  if ($result === false) {
    die('Query Error: ' . mysqli_error($conn));
  }

  $slides = '';
  $active = 'active';
  while ($row = mysqli_fetch_assoc($result)) {
    $imagePath = "../images/" . $row['filename'];
    $slides .= '<div class="carousel-item ' . $active . '"><img src="' . $imagePath . '"></div>';
    $active = '';
  }

  mysqli_close($conn);

  echo $slides;
}
?>
