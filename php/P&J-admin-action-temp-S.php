<?php
// Retrieve the form data
$server= "localhost";
$username = "root";
$password = "";
$dbname = "pupets";

$conn = mysqli_connect($server, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
print_r($_POST);

$groupname = $_POST['group_name_temp'];
$input1 = $_POST['criteria_1_temp'];
$input2 = $_POST['criteria_2_temp'];
$input3 = $_POST['criteria_3_temp'];
$input4 = $_POST['criteria_4_temp'];
$total = $_POST['sum'];

// Prepare and execute the database query
$sql = "INSERT INTO pjscorestemp (group_name_temp, criteria_1_temp, criteria_2_temp, criteria_3_temp, criteria_4_temp, total_score_temp)
        VALUES ('$groupname','$input1', '$input2', '$input3', '$input4', '$total')";

if ($conn->query($sql) === TRUE) {
  echo "Data inserted successfully!";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
header("Location: ../P&J-admin-scoretab.php");
exit();
?>