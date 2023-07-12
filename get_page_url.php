<?php
if (isset($_POST['selectedValue'])) {
  $selectedValue = $_POST['selectedValue'];

  // Connect to MySQL and retrieve the page URL based on the selected option
  $connection = mysqli_connect('localhost', 'root', '', 'ets');
  $query = "SELECT page_url FROM dropdown_options WHERE category_name = '$selectedValue'";
  $result = mysqli_query($connection, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $pageURL = $row['page_url'];
    echo $pageURL;
  } else {
    echo ''; // Return an empty string if the page URL is not found
  }

  mysqli_close($connection);
}
?>