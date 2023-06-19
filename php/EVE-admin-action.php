<?php
    require 'database_connect.php';
    $output='';
    $sql = "SELECT * FROM category_name WHERE event_name_id='".$_POST['s_eventNameID']."' AND event_type_id='".$_POST['eventTypeID']."' ORDER BY category_name;";
    $result=mysqli_query($conn, $sql);
    $output = '<option value="" selected>Select Category</option>';
    while($row=mysqli_fetch_array($result)){
        $output .='<option value="'.$row["category_name_id"].'">'.$row["category_name"].'</option>';
    }   
    echo $output;
?>