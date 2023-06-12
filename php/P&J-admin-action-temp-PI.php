<?php
include 'database_connect.php';
print_r($_POST);
foreach ($_POST['participants_name_temp'] as $key => $value) {
    $sql = 'INSERT INTO pjparticipantstemp(participants_name_temp, participants_course_temp, participants_section_temp, participants_organization_temp) VALUES (?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $value, $_POST['participants_course_temp'][$key], $_POST['participants_section_temp'][$key], $_POST['participants_organization_temp'][$key]);
    $stmt->execute();
}

$stmt->close();
$conn->close();

echo 'Participants Individual inserted successfully!';

?>