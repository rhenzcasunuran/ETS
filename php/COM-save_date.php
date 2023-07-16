<?php
require 'database_connect.php';
include 'CAL-logger.php';
date_default_timezone_set('Asia/Manila');

if (isset($_POST['competition_name']) && isset($_POST['schedule']) && isset($_POST['schedule_end'])) {
  // Get the values from the POST request
  $competition_name = $_POST['competition_name'];
  $schedule = $_POST['schedule'];
  $schedule_end = $_POST['schedule_end'];


  $competitionName = $conn->real_escape_string($competition_name);

    // Get the evrnt ID
    $eventidQuery = $conn->prepare("SELECT event_id FROM ongoing_list_of_event WHERE category_name = ?");
    $eventidQuery->bind_param("s", $competitionName);
    $eventidQuery->execute();
    $eventidResult = $eventidQuery->get_result();

    if ($eventidResult->num_rows > 0) {
        $eventidRow = $eventidResult->fetch_assoc();
        $eventid = $eventidRow["event_id"];
    } else {
        $eventid = "Unknown";
    }

  // Prepare the SQL statement
  $stmt = $conn->prepare("UPDATE competition SET schedule = ?, schedule_end = ? WHERE event_id = ?");
  $stmt->bind_param("sss", $schedule, $schedule_end, $eventid);
  // Execute the SQL statement
  if ($stmt->execute()) {
    // The SQL statement was executed successfully
    ?> <script type="text/javascript">document.getElementById('<?php echo $competition_name;?> btn').style.backgroundColor = 'rgb(102, 232, 90)';</script><?php
    to_log($conn, $sql);
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