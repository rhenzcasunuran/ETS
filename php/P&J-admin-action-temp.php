<?php

print_r($_POST);
$conn = new PDO('mysql:host=localhost;dbname=pupets', 'root', '');

foreach($_POST['judge_name_temp'] as $key => $value){
    $sql = 'INSERT INTO pjjudgestemp(judge_name_temp,judge_nick_temp,event_code_temp) VALUES (:name, :nick,:event)';
    $stmt = $conn -> prepare($sql);
    $stmt -> execute([
        'name' => $value,
        'nick' => $_POST['judge_nick_temp'][$key],
        'event'=> $value
    ]);
}

echo 'Judges inserted successfully!';

?>