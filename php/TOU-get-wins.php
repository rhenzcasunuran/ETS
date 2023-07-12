<?php
  // Connect to MySQL and retrieve content based on the selected option
  $conn = mysqli_connect("localhost", "root", "", "ets");
  $selectedOption = $_GET['option'];
  $query = "SELECT number_of_wins_id FROM tournament WHERE tournament_id = '$selectedOption'";
  $result = mysqli_query($conn, $query);
  
  // Return the content as a response
  if ($row = mysqli_fetch_assoc($result)) {
    echo $row['number_of_wins_id'];
  }
  
  // Close the database connection
  mysqli_close($conn);
?>