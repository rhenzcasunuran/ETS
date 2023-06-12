<?php
    include 'database_connect.php';

    if(isset($_GET['epj'])){
        $id = $_GET['epj'];
        $get_score = mysqli_query($dbname,"SELECT * FROM pjscorestemp WHERE score_id_temp = '$id';");
        $score_row = mysqli_fetch_array($get_post); 
    }
?>