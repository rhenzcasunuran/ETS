<?php
include('database_connect.php');

$msg = "";
$folder = "./images/";
$filename = "";
$tempname = "";
$image_info = "";
$image_description = "";

if (isset($_FILES['file'])) {

  // Check if the required fields are filled
  

  $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
  $file_extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
  if (!in_array($file_extension, $allowed_types)) {
    echo "File must be an image (JPG, JPEG, PNG, GIF)!";
    exit();
  }

  $filename = $_FILES["file"]["name"];
  $tempname = $_FILES["file"]["tmp_name"];
  $folder = "./images/";
  $image_info = $_POST['image_Info'];
  $image_description = $_POST['image_Description'];

  $db = mysqli_connect("localhost", "root", "", "pupets");

  $unique_id = uniqid();

  $new_filename = $unique_id . '.' . $file_extension;

  $sql = "INSERT INTO image (filename, image_Info, image_Description) 
      VALUES ('$new_filename', '$image_info', '$image_description')";

  mysqli_query($db, $sql);

  if (move_uploaded_file($tempname, $folder . $new_filename)) {
    echo "Image uploaded successfully!";
  } else {
    echo "Failed to upload image!";
  }
}
?>