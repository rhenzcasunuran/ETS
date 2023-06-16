<?php
// Create a MySQL connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pupets";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve the existing value for Team A from the database
$sql = "SELECT scoring_team_a FROM scores";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$existingValueA = $row['scoring_team_a'];

// Process the form submission for Team A
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['updated_value_a'])) {
    $updatedValueA = $_POST['updated_value_a'];
    $newValueA = $existingValueA + $updatedValueA;

    // Ensure the value does not go below 0
    if ($newValueA < 0) {
      $newValueA = 0;
    }

    // Update the value in the database
    $sql = "UPDATE scores SET scoring_team_a = $newValueA";
    if ($conn->query($sql) === TRUE) {
      echo "Value updated successfully!";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Update the existing value for Team A
    $existingValueA = $newValueA;
  }
}

// Retrieve the existing value for Team B from the database
$sql = "SELECT scoring_team_b FROM scores";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$existingValueB = $row['scoring_team_b'];

// Process the form submission for Team B
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['updated_value_b'])) {
    $updatedValueB = $_POST['updated_value_b'];
    $newValueB = $existingValueB + $updatedValueB;

    // Ensure the value does not go below 0
    if ($newValueB < 0) {
      $newValueB = 0;
    }

    // Update the value in the database
    $sql = "UPDATE scores SET scoring_team_b = $newValueB";
    if ($conn->query($sql) === TRUE) {
      echo "Value updated successfully!";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Update the existing value for Team B
    $existingValueB = $newValueB;
  }
}
?>