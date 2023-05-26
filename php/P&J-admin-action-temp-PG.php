<?php

print_r($_POST);
$conn = new PDO('mysql:host=localhost;dbname=pupets', 'root', '');

foreach($_POST['participants_name_group_temp'] as $key => $value){
    $sql = 'INSERT INTO pjparticipantsgrouptemp(participants_name_group_temp, participants_organization_group_temp) VALUES (:name, :org)';
    $stmt = $conn -> prepare($sql);
    $stmt -> execute([
        'name' => $value,
        'org' => $_POST['participants_organization_group_temp'][$key]
    ]);

    foreach($_POST['participants_name_g_temp'] as $key => $value){
        $sql = 'INSERT INTO pjparticipantsgroupmemberstemp(participants_name_g_temp,participants_course_group_temp,participants_section_group_temp) VALUES (:name, :course,:section)';
        $stmt = $conn -> prepare($sql);
        $stmt -> execute([
            'name' => $value,
            'course' => $_POST['participants_course_group_temp'][$key],
            'section' => $_POST['participants_section_group_temp'][$key]
        ]);
    }
}

echo 'Participants Grouped inserted successfully!';

?>