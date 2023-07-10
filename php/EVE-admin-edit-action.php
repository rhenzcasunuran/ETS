<?php
    require 'database_connect.php';

    $event_id = $_POST['eventID'];
    $event_name_id = $_POST['s_eventNameID'];
    $event_type_id = $_POST['eventTypeID'];
    $category_name_id = $_POST['categoryName'];

    $output="";
    $sql = "SELECT category_name_id, category_name FROM category_name WHERE event_name_id = $event_name_id AND event_type_id = $event_type_id
            UNION
            SELECT category_name_id, category_name FROM ongoing_list_of_event WHERE event_id = $event_id AND category_name_id = $category_name_id AND event_name_id = $event_name_id AND event_type_id = $event_type_id ORDER BY category_name;";
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