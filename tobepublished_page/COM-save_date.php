<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pupets";
date_default_timezone_set('Asia/Manila');
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['competition_name']) && isset($_POST['schedule'])) {
  // Get the values from the POST request
  $competition_name = $_POST['competition_name'];
  $schedule = $_POST['schedule'];

  // Prepare the SQL statement
  $stmt = $conn->prepare("UPDATE competitions_table SET schedule = ? WHERE competition_name = ?");
  $stmt->bind_param("ss", $schedule, $competition_name);
  // Execute the SQL statement
  if ($stmt->execute()) {
    // The SQL statement was executed successfully
    ?> <script type="text/javascript">document.getElementById('<?php echo $competition_name;?> btn').style.backgroundColor = 'rgb(102, 232, 90)';</script><?php
    echo "Gumana sha holy shiiiii";
  } else {
    // An error occurred while executing the SQL statement
    echo "Error: " . $stmt->error;
  }
  
  // Close the statement
  $stmt->close();
}

// Close the connection
$conn->close();
?>