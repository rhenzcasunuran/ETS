<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept");

@include 'database_connect.php';
include 'CAL-logger.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $selectedEventName = isset($_GET['selectedEventName']) ? $_GET['selectedEventName'] : '';

  $query = "SELECT * FROM bar_graph 
            INNER JOIN organization ON bar_graph.organization_id = organization.organization_id 
            INNER JOIN ongoing_event_name ON bar_graph.ongoing_event_name_id = ongoing_event_name.ongoing_event_name_id
            WHERE bar_graph.ongoing_event_name_id = '$selectedEventName'";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $isAnon = $row['isAnon'];
    echo json_encode(["isAnon" => $isAnon]);
  } else {
    echo json_encode(["isAnon" => null]);
  }

  mysqli_free_result($result);
}

mysqli_close($conn);
?>
