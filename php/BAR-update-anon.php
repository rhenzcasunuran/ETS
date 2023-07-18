<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept");

@include 'database_connect.php';
include 'CAL-logger.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $isAnon = isset($_POST["isAnon"]) ? $_POST["isAnon"] : 0;
  $selectedEventName = isset($_POST['selectedEventName']) ? $_POST['selectedEventName'] : '';

  $query = "UPDATE bar_graph 
            INNER JOIN organization ON bar_graph.organization_id = organization.organization_id 
            INNER JOIN ongoing_event_name ON bar_graph.ongoing_event_name_id = ongoing_event_name.ongoing_event_name_id
            SET bar_graph.isAnon = ?
            WHERE bar_graph.ongoing_event_name_id = ?";

  $stmt = $conn->prepare($query);
  $stmt->bind_param("is", $isAnon, $selectedEventName);

  if ($stmt->execute()) {
    echo json_encode(["success" => true]);
    to_log($conn, $query);
  } else {
    echo json_encode(["success" => false, "message" => "Failed to update isAnon column"]);
  }

  $stmt->close();
}

mysqli_close($conn);
?>
