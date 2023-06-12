<?php
include 'database_connect.php';
include 'CAL-logger.php';
print_r($_POST); 
foreach ($_POST['participants_name_group_temp'] as $key => $value) {
    $sql = 'INSERT INTO pjparticipantsgrouptemp(participants_name_group_temp, participants_organization_group_temp) VALUES (?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $value, $_POST['participants_organization_group_temp'][$key]);
    $stmt->execute();
    to_log($conn, $sql);

    foreach ($_POST['participants_name_g_temp'] as $key2 => $value2) {
        $sql = 'INSERT INTO pjparticipantsgroupmemberstemp(participants_name_g_temp, participants_course_group_temp, participants_section_group_temp) VALUES (?, ?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $value2, $_POST['participants_course_group_temp'][$key2], $_POST['participants_section_group_temp'][$key2]);
        $stmt->execute();
        to_log($conn, $sql);
    }
}

$stmt->close();
$conn->close();

echo 'Participants Grouped inserted successfully!';

?>