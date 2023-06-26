<?php
include 'database_connect.php';
include 'CAL-logger.php';
print_r($_POST); 
foreach ($_POST['participant_name'] as $key => $value) {
    $sql = 'INSERT INTO participants(participant_name) VALUES (?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $value);
    $stmt->execute();
    to_log($conn, $sql);

    foreach ($_POST['participant_name'] as $key2 => $value2) {
        $sql = 'INSERT INTO participants(participant_name, participant_section) VALUES (?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $value2, $_POST['participant_section'][$key2]);
        $stmt->execute();
        to_log($conn, $sql);
    }
}

$stmt->close();
$conn->close();

echo 'Participants Grouped inserted successfully!';

?>