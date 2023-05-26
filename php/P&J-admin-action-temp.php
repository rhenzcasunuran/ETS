<?php

print_r($_POST);
$conn = new PDO('mysql:host=localhost;dbname=pupets', 'root', '');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


foreach($_POST['judge_name_temp'] as $key => $value){
    $sql = 'INSERT INTO pjjudgestemp(judge_name_temp,judge_nick_temp) VALUES (:name, :nick)';
    $stmt = $conn -> prepare($sql);
    $stmt -> execute([
        'name' => $value,
        'nick' => $_POST['judge_nick_temp'][$key]
    ]);
}

$stmt = $conn->prepare("INSERT INTO pjjudgeseventcode(event_code) VALUE (:eventc)");
$stmt->bindParam(':eventc', $_POST['event_code']);

$stmt->execute();

echo 'Judges inserted successfully!';

?>