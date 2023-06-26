<?php
include('database_connect.php');
include 'CAL-logger.php';

if (isset($_POST['id'])) {
  $id = $_POST['id'];

  $query = "SELECT filename FROM highlights WHERE highlight_id='$id'";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);
  $filename = $row['filename'];

  $filepath = "images/$filename";
  if (file_exists($filepath)) {
    unlink($filepath);
  }

  $query = "DELETE FROM highlights WHERE highlight_id='$id'";
  if (mysqli_query($conn, $query)) {
    echo "success";
    to_log($conn, $query);
  } else {
    echo "error";
  }
}

mysqli_close($conn);
?>
