<?php
    $dbname=mysqli_connect("localhost","root","","pupets");

    if(isset($_POST['save-btn'])){
        $event_name_id =  mysqli_real_escape_string($dbname,$_POST['select-event-name']);
        $event_type_id =  mysqli_real_escape_string($dbname,$_POST['select-event-type']);
        $category_name =  mysqli_real_escape_string($dbname,$_POST['select-category-name']);
        $event_description =  mysqli_real_escape_string($dbname,$_POST['event-description']);
        $event_date =  mysqli_real_escape_string($dbname,$_POST['date']);
        $event_time =  mysqli_real_escape_string($dbname,$_POST['time']);
        $event_code_get =  mysqli_real_escape_string($dbname,$_POST['code']);

        $event_name = "";

            $sql_event_name = "SELECT * FROM eventnametb WHERE event_name_id = $event_name_id";
            $result_event_name = mysqli_query($dbname,$sql_event_name);
            if(mysqli_num_rows($result_event_name) > 0){
                $get_event_name = mysqli_fetch_assoc($result_event_name);
                $event_name = $get_event_name['event_name'];
            }
            
            $sql_event_type = "SELECT * FROM eventtypetb WHERE event_type_id = $event_type_id";
            $result_event_type = mysqli_query($dbname,$sql_event_type);
            $get_event_type = mysqli_fetch_assoc($result_event_type);
            $event_type = $get_event_type['event_type'];

            $event_description = trim($event_description," ");

        if($event_name != ""){
            $sql = "INSERT INTO listofeventtb (event_name, event_type, category_name, event_description, event_date, event_time) VALUES ('$event_name', '$event_type', '$category_name', '$event_description', '$event_date', '$event_time');";
            $result = mysqli_query($dbname,$sql);  

                $code = "$event_code_get";

                $sql = "SELECT * FROM listofeventtb WHERE event_code='$code';";
                $result_code = mysqli_query($dbname,$sql);  
                
                while(mysqli_num_rows($result_code) > 0){
                    $code = str_shuffle($code);
                    $sql = "SELECT * FROM listofeventtb WHERE event_code='$code';";
                    $result_code = mysqli_query($dbname,$sql);  
                }

                $event_code = $code;

                $sql = "SELECT event_id FROM listofeventtb WHERE event_name='$event_name' AND event_type='$event_type' AND category_name='$category_name' AND event_description='$event_description' AND event_date='$event_date' AND event_time='$event_time';";
                $result = mysqli_query($dbname,$sql);  
                $row = mysqli_fetch_array($result);
                $event_id = $row[0];

                $sql = "UPDATE listofeventtb SET event_code='$event_code' WHERE event_id='$event_id';";
                mysqli_query($dbname,$sql); 

                header('Location: EVE-admin-list-of-events.php?event successfully added');
            
        }
        else{
            echo "<script>alert('Something went wrong');</script>";
            header('Refresh:0; url=EVE-admin-create-event.php?something went wrong');
        }
    }
?>