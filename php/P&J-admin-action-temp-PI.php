<?php

print_r($_POST);
$conn = new PDO('mysql:host=localhost;dbname=pupets', 'root', '');

foreach($_POST['participants_name_temp'] as $key => $value){
    $sql = 'INSERT INTO pjparticipantstemp(participants_name_temp,participants_course_temp,participants_section_temp, participants_organization_temp) VALUES (:name, :course, :section, :org)';
    $stmt = $conn -> prepare($sql);
    $stmt -> execute([
        'name' => $value,
        'course' => $_POST['participants_course_temp'][$key],
        'section'=> $_POST['participants_section_temp'][$key],
        'org' => $_POST['participants_organization_temp'][$key]
    ]);
}

echo 'Participants Individual inserted successfully!';

?>