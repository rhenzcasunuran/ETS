<?php
    include 'P&J-score-data.php';
    include 'database_connect.php';
    include 'CAL-logger.php';

    if(isset($_POST['pjscorestemp'])){
        $criteria1 =  mysqli_real_escape_string($conn,$_POST['criteria_1_temp']);
        $criteria2 =  mysqli_real_escape_string($conn,$_POST['criteria_2_temp']);
        $criteria3 =  mysqli_real_escape_string($conn,$_POST['criteria_3_temp']);
        $criteria4 =  mysqli_real_escape_string($conn,$_POST['criteria_4_temp']);
        $totalscore =  mysqli_real_escape_string($conn,$_POST['total_score_temp']);

        $sql = "UPDATE pjscorestemp 
                SET criteria_1_temp = '$criteria1', criteria_2_temp = '$criteria2', criteria_3_temp = '$criteria3', criteria_4_temp = '$criteria4',  total_score_temp = '$totalscore'
                WHERE score_id_temp = $id";
        mysqli_query($conn,$sql);
        to_log($conn, $sql);

        $_SESSION['message']="Successfully added to the database."; 
    }
?>