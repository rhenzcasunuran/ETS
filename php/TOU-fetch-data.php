<?php 
    $sql = "SELECT team1_id, team2_id FROM tou_bracket";
    $result = $conn->query($sql);
    
    if($result->num_rows> 0){
      $options= mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
?>