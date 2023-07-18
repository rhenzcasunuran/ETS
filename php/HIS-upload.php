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

  $allowed_types = array('jpg', 'jpeg', 'png');

  // Process each uploaded file
  $file_count = count($_FILES['uploadfile']['name']);
  $filenames = array(); // Array to store filenames
  for ($i = 0; $i < $file_count; $i++) {
    $file_name = $_FILES['uploadfile']['name'][$i];
    $file_tmp = $_FILES['uploadfile']['tmp_name'][$i];
    $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

    // Generate unique filename
    $unique_name = uniqid() . '_' . $i . '.' . $file_extension;
    $file_destination = './images/' . $unique_name;

    $file_extension = strtolower($file_extension); // Convert extension to lowercase
    if (!in_array($file_extension, $allowed_types)) {
      echo "File must be an image (JPG, JPEG, PNG)!";
      continue; // Skip current file and move to the next one
    }

    $image_info = $_POST['image_Info'];
    $image_description = $_POST['image_Description'];

    // Move uploaded file to the desired location with the unique name
    move_uploaded_file($file_tmp, $file_destination);

    // Store the unique filename in the array
    $filenames[] = $unique_name;
  }

  // Concatenate the filenames with a delimiter
  $concatenated_filenames = implode(',', $filenames);

  // Check if there is existing data for the event_id
  $event_id = mysqli_real_escape_string($conn, $_POST['event_name']);
  $query = "SELECT * FROM highlights WHERE event_id = '$event_id'";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);

  if ($row) {
    // If there is existing data, update the row with the new filenames, image_info, and image_description
    $existing_filenames = $row['filename'];
    $updated_filenames = $existing_filenames . ',' . $concatenated_filenames;

    $sql = "UPDATE highlights SET filename = '$updated_filenames', image_info = '$image_info', image_description = '$image_description' WHERE event_id = '$event_id'";
  } else {
    // If there is no existing data, insert a new row with the filenames, event_id, image_info, and image_description
    $sql = "INSERT INTO highlights (event_id, filename, image_info, image_description)
            VALUES ('$event_id', '$concatenated_filenames', '$image_info', '$image_description')";
  }

  if (mysqli_query($conn, $sql)) {
    echo "Image(s) uploaded successfully!";
  } else {
    echo "Failed to upload image(s). Error: " . mysqli_error($conn);
  }

  mysqli_close($conn);
}
?>
