<?php

print_r($_POST);
$conn = new PDO('mysql:host=localhost;dbname=pupets', 'root', '');

foreach($_POST['judge_name'] as $key => $value){
    $sql = 'INSERT INTO pjjudges(judge_name,judge_nick) VALUES (:name, :nick)';
    $stmt = $conn -> prepare($sql);
    $stmt -> execute([
        'name' => $value,
        'nick' => $_POST['judge_nick'][$key]
    ]);
}
echo 'Judges inserted successfully!';

?>