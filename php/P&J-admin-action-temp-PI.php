<?php
include 'database_connect.php';
include 'CAL-logger.php';
print_r($_POST);
foreach ($_POST['participants_name_temp'] as $key => $value) {
    $sql = 'INSERT INTO participants(participant_name, participant_section) VALUES (?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $value, $_POST['participants_section_temp'][$key]);
    $stmt->execute();
    to_log($conn, $sql);
}

$stmt->close();
$conn->close();

echo 'Participants Individual inserted successfully!';

?>