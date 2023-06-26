<?php
require('database_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if the required fields are filled
  if (empty($_POST['event_name'])) {
    echo "Please select an event!";
    exit();
  }

  if (!isset($_FILES['uploadfile'])) {
    echo "Please select an image to upload!";
    exit();
  }

  $allowed_types = array('jpg', 'jpeg', 'png', 'gif');

  // Process each uploaded file
  $file_count = count($_FILES['uploadfile']['name']);
  for ($i = 0; $i < $file_count; $i++) {
    $file_name = $_FILES['uploadfile']['name'][$i];
    $file_tmp = $_FILES['uploadfile']['tmp_name'][$i];
    $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

    // Validate file type
    if (!in_array($file_extension, $allowed_types)) {
      echo "File must be an image (JPG, JPEG, PNG, GIF)!";
      continue; // Skip current file and move to the next one
    }

    $image_info = $_POST['image_Info'];
    $image_description = $_POST['image_Description'];

    // Move uploaded file to the desired location
    $file_destination = './images/' . $file_name;
    move_uploaded_file($file_tmp, $file_destination);

    // Insert the uploaded image details into the database
    $event_id = mysqli_real_escape_string($conn, $_POST['event_name']);
    $sql = "INSERT INTO highlights (event_id, filename, image_info, image_description)
            VALUES ('$event_id', '$file_name', '$image_info', '$image_description')";

    if (mysqli_query($conn, $sql)) {
      echo "Image uploaded successfully!";
    } else {
      echo "Failed to upload image. Error: " . mysqli_error($conn);
    }
  }

  mysqli_close($conn);
}
?>
