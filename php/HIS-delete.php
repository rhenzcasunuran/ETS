<?php
include('database_connect.php');
include 'CAL-logger.php';

if (isset($_POST['filename'])) {
  $filename = $_POST['filename'];

  $query = "SELECT highlight_id, filename FROM highlights WHERE FIND_IN_SET('$filename', filename)";
  $result = mysqli_query($conn, $query);

  while ($row = mysqli_fetch_assoc($result)) {
    $highlight_id = $row['highlight_id'];
    $filenames = $row['filename'];

    // Remove the specific filename from the list
    $updatedFilenames = str_replace($filename, '', $filenames);
    $updatedFilenames = trim($updatedFilenames, ',');

    $updateQuery = "UPDATE highlights SET filename='$updatedFilenames' WHERE highlight_id='$highlight_id'";
    if (mysqli_query($conn, $updateQuery)) {
      echo "success";
      to_log($conn, $updateQuery);
    } else {
      echo "error";
    }
  }
}

mysqli_close($conn);
?>
