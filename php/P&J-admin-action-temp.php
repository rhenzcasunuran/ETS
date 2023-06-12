<?php
include 'database_connect.php';
include 'CAL-logger.php';
print_r($_POST); 
foreach ($_POST['judge_name_temp'] as $key => $value) {
    $sql = 'INSERT INTO pjjudgestemp(judge_name_temp, judge_nick_temp) VALUES (?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $value, $_POST['judge_nick_temp'][$key]);
    $stmt->execute();
    to_log($conn,$sql);
}

$stmt = $conn->prepare("INSERT INTO pjjudgeseventcode(event_code) VALUE (?)");
$stmt->bind_param('s', $_POST['event_code']);
$stmt->execute();

$stmt->close();
$conn->close();

echo 'Judges inserted successfully!';

?>