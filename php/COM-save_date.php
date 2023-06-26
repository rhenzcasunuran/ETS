<?php
require 'database_connect.php';
include 'CAL-logger.php';
date_default_timezone_set('Asia/Manila');

if (isset($_POST['competition_name']) && isset($_POST['schedule']) && isset($_POST['schedule_end'])) {
  // Get the values from the POST request
  $competition_name = $_POST['competition_name'];
  $schedule = $_POST['schedule'];
  $schedule_end = $_POST['schedule_end'];

  // Prepare the SQL statement
  $stmt = $conn->prepare("UPDATE competitions_table SET schedule = ?, schedule_end = ? WHERE competition_name = ?");
  $stmt->bind_param("sss", $schedule, $schedule_end, $competition_name);
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