<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept");

@include 'database_connect.php';
include 'CAL-logger.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $selectedEventName = isset($_GET['selectedEventName']) ? $_GET['selectedEventName'] : '';

    $sql = "SELECT * FROM `bar_graph`
    INNER JOIN organization ON bar_graph.organization_id = organization.organization_id 
    INNER JOIN ongoing_event_name ON bar_graph.ongoing_event_name_id = ongoing_event_name.ongoing_event_name_id
    WHERE bar_graph.ongoing_event_name_id = $selectedEventName
    ORDER BY bar_meter DESC;";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      $organizations = array();
      while ($row = $result->fetch_assoc()) {
          $organizations[] = $row['organization_name'];
      }
      // Return organization names as JSON
      echo json_encode($organizations);
    } else {
      echo "No organizations found in the database.";
    }
    mysqli_free_result($result);
}
mysqli_close($conn);
?>
