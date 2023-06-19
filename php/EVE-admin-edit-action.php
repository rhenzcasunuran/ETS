<?php
    require 'database_connect.php';

    $id = $_POST['categoryName'];
    

    $output='';
    $sql = "SELECT category_name_id, category_name FROM category_name WHERE event_name_id='".$_POST['s_eventNameID']."' AND event_type_id='".$_POST['eventTypeID']."'
            UNION
            SELECT category_name_id, category_name FROM ongoing_category_name WHERE category_name_id = $id AND event_name_id='".$_POST['s_eventNameID']."' AND event_type_id='".$_POST['eventTypeID']."' ORDER BY category_name;";
    $result = mysqli_query($conn, $sql);

    $output = '<option value="">Select Category</option>';
    while($row=mysqli_fetch_array($result)){
        if($_POST['categoryName'] !== $row["category_name_id"]){
            $output .='<option value="'.$row["category_name_id"].'">'.$row["category_name"].'</option>';
        }
        else{
            $output .='<option selected value="'.$row["category_name_id"].'">'.$row["category_name"].'</option>';
        }
    }   
    echo $output;
?>