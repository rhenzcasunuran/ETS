<?php
require 'database_connect.php';
include 'CAL-logger.php';

$rawData = file_get_contents("php://input");
file_put_contents('debug_raw.txt', $rawData);

$participantData = json_decode($rawData, true);

if ($participantData !== null) {
    // Process the $participantData array
    foreach ($participantData as $participant) {
        $deduction = $participant['deduction'];
        $id = $participant['id'];

        $stmt = $conn->prepare("UPDATE participants SET deduction = ? WHERE participants_id = ?");
        $stmt->bind_param("si", $deduction, $id);
        $stmt->execute();
        $stmt->close();
    }
    echo 'Data successfully processed.';
} else {
    echo 'Invalid JSON data.';
}
?>
