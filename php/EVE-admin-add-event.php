<?php
    require 'database_connect.php';
    include 'CAL-logger.php';

    if(isset($_POST['save-btn'])){
        $event_name_id =  mysqli_real_escape_string($conn,$_POST['select-event-name']);
        $event_type_id =  mysqli_real_escape_string($conn,$_POST['select-event-type']);
        $category_name_id =  mysqli_real_escape_string($conn,$_POST['select-category-name']);
        $event_description =  mysqli_real_escape_string($conn,$_POST['event-description']);
        $event_date =  mysqli_real_escape_string($conn,$_POST['date']);
        $event_time =  mysqli_real_escape_string($conn,$_POST['time']);
        $event_code_get =  mysqli_real_escape_string($conn,$_POST['code']);

        $event_name = "";

        /*    $sql_event_name = "SELECT * FROM event_name WHERE event_name_id = $event_name_id";
            $result_event_name = mysqli_query($conn,$sql_event_name);
            if(mysqli_num_rows($result_event_name) > 0){
                $get_event_name = mysqli_fetch_assoc($result_event_name);
                $event_name = $get_event_name['event_name'];
            }
            
            $sql_event_type = "SELECT * FROM event_type WHERE event_type_id = $event_type_id";
            $result_event_type = mysqli_query($conn,$sql_event_type);
            $get_event_type = mysqli_fetch_assoc($result_event_type);
            $event_type = $get_event_type['event_type']; */

            $event_description = preg_replace('/\s+/', ' ', $event_description);

        if($event_name_id != ""){
            $sql = "INSERT IGNORE INTO ongoing_event_name (event_name_id, event_name)
                    SELECT event_name_id, event_name
                    FROM event_name
                    WHERE event_name_id = '$event_name_id';";
            mysqli_query($conn,$sql);

            $sql = "INSERT IGNORE INTO ongoing_category_name (category_name_id, event_name_id, event_type_id, category_name)
                    SELECT category_name_id, event_name_id, event_type_id, category_name
                    FROM category_name
                    WHERE category_name_id = '$category_name_id';";
            mysqli_query($conn,$sql);

            $sql = "INSERT INTO ongoing_criterion (criterion_id, category_name_id, criterion_name, criterion_percent)
                    SELECT criterion_id, category_name_id, criterion_name, criterion_percent
                    FROM criterion
                    WHERE category_name_id = '$category_name_id';";
            mysqli_query($conn,$sql);                    

            $sql = "DELETE FROM criterion WHERE category_name_id = '$category_name_id';";
            mysqli_query($conn,$sql);
                    
            $sql = "DELETE FROM category_name WHERE category_name_id = '$category_name_id';";
            mysqli_query($conn,$sql);

            $sql = "SELECT * FROM ongoing_category_name WHERE category_name_id = '$category_name_id';";
            $query = mysqli_query($conn,$sql);
            $column = mysqli_fetch_array($query);

            $sql = "INSERT INTO ongoing_list_of_event (category_name_id, event_description, event_date, event_time) VALUES ('$column[0]', '$event_description', '$event_date', '$event_time');";
            $result = mysqli_query($conn,$sql);  

            to_log($conn, $sql);

                $code = "$event_code_get";

                $sql = "SELECT * FROM ongoing_list_of_event WHERE event_code='$code';";
                $result_code = mysqli_query($conn,$sql);  
                
                while(mysqli_num_rows($result_code) > 0){
                    $code = str_shuffle($code);
                    $sql = "SELECT * FROM ongoing_list_of_event WHERE event_code='$code';";
                    $result_code = mysqli_query($conn,$sql);  
                }

                $event_code = $code;

                $sql = "SELECT event_id FROM ongoing_list_of_event WHERE category_name_id='$category_name_id' AND event_description='$event_description' AND event_date='$event_date' AND event_time='$event_time';";
                $result = mysqli_query($conn,$sql);  
                $row = mysqli_fetch_array($result);
                $event_id = $row[0];

                $sql = "UPDATE ongoing_list_of_event SET event_code='$event_code' WHERE event_id='$event_id';";
                mysqli_query($conn,$sql); 

                header('Location: EVE-admin-list-of-events.php?event successfully added');
            
        }
        else{
            echo "<script>alert('Something went wrong');</script>";
            header('Refresh:0; url=EVE-admin-create-event.php?something went wrong');
        }
    }
?>