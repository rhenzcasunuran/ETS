<?php
    $dbname=mysqli_connect("localhost","root","","pupets");

    if(isset($_GET['eec'])){
        $code = $_GET['eec'];
        $get_event = mysqli_query($dbname,"SELECT * FROM listofeventtb WHERE event_code = '$code';");
        $edit_event_row = mysqli_fetch_array($get_event);

        if(isset($_POST['save-btn'])){
            $event_name_id =  mysqli_real_escape_string($dbname,$_POST['select-event-name']);
            $event_type_id =  mysqli_real_escape_string($dbname,$_POST['select-event-type']);
            $category_name =  mysqli_real_escape_string($dbname,$_POST['select-category-name']);
            $event_description =  mysqli_real_escape_string($dbname,$_POST['event-description']);
            $event_date =  mysqli_real_escape_string($dbname,$_POST['date']);
            $event_time =  mysqli_real_escape_string($dbname,$_POST['time']);

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
                $sql = "UPDATE listofeventtb SET event_name = '$event_name', event_type = '$event_type', category_name = '$category_name', event_description = '$event_description', event_date =' $event_date', event_time = '$event_time' WHERE event_code = '$code';";
                mysqli_query($dbname,$sql);  

                header('Location: EVE-admin-list-of-events.php?event successfully updated');
            }
            else{
                echo "<script>alert('Something went wrong');</script>";
                header('Refresh:0; url=EVE-admin-edit-event.php?eec='.$code);
            }
        }
    }

        
    if(isset($_GET['eed'])){
        $code = $_GET['eed'];
        $delete_event = mysqli_query($dbname,"DELETE FROM listofeventtb WHERE event_code = '$code';");
        header('Location: EVE-admin-list-of-events.php');
    }
?>