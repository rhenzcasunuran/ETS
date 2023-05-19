<?php 
    $sql = "SELECT team_id, team_name FROM teams";
    $result = $conn->query($sql);
    
    if($result->num_rows> 0){
      $options= mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
?>