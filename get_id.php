<?php
// Establish a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ets";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get the selected value from the AJAX request
$selectedValue = $_POST['selectedValue'];

// Query the database to fetch the ID
$sql = "SELECT team_id FROM tou_team_stat WHERE organization_name = '$selectedValue'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $organizationID = $row['team_id'];

  // Return the fetched ID as the response
  echo $organizationID;
}

// Close the database connection
$conn->close();
?>