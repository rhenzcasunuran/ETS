<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept");

@include 'database_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $isAnon = $_POST["isAnon"];
  $query = "UPDATE bar_graph SET isAnon = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $isAnon);

  if ($stmt->execute()) {
    echo json_encode(["success" => true]);
  } else {
    echo json_encode(["success" => false, "message" => "Failed to update isAnon column"]);
  }

  $stmt->close();
}

mysqli_close($conn);
?>
