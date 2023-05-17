<?php
    require 'database_connect.php';
    $output='';
    $sql = "SELECT * FROM categorynametb WHERE event_name_id='".$_POST['s_eventNameID']."' AND event_type_id='".$_POST['eventTypeID']."' ORDER BY category_name;";
    $result=mysqli_query($conn, $sql);
    $output = '<option value="">Select Category</option>';
    while($row=mysqli_fetch_array($result)){
        if($_POST['categoryName'] !== $row["category_name"]){
            $output .='<option value="'.$row["category_name"].'">'.$row["category_name"].'</option>';
        }
        else{
            $output .='<option selected value="'.$row["category_name"].'">'.$row["category_name"].'</option>';
        }
    }   
    echo $output;
?>