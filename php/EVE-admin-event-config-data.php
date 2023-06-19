<?php
    require 'database_connect.php';
    include 'CAL-logger.php';

    if(isset($_POST['eventSaveBtn'])){
        $event_name =  mysqli_real_escape_string($conn,$_POST['inputEventName']);
        $sql_event_name = "SELECT * FROM event_name WHERE event_name = '$event_name'";
        $result_event_name = mysqli_query($conn,$sql_event_name);  
        
        // Trim leading and trailing spaces
        $event_name = trim($event_name);

        $event_name = preg_replace('/\s+/', ' ', $event_name);

        if (mysqli_num_rows($result_event_name) > 0){
            $error['eventName'] = "$event_name already exists!";
        }
        else{
            $sql = "INSERT INTO event_name(event_name) VALUES ('$event_name')";
            mysqli_query($conn,$sql);  

            to_log($conn, $sql);

            header('Refresh: 3; url:EVE-admin-list-of-events.php');
            header('Location: EVE-admin-event-configuration.php?event name saved');
        }
    }  

    if(isset($_POST['categorySaveBtn'])){
        $event_name_id =  mysqli_real_escape_string($conn,$_POST['selectEventName']);
        $event_type_id =  mysqli_real_escape_string($conn,$_POST['selectEventType']);
        $category_name =  mysqli_real_escape_string($conn,$_POST['inputCategoryName']);

        $event_name = "";

        $sql_event_name = "SELECT * FROM event_name WHERE event_name_id = $event_name_id";
        $result_event_name = mysqli_query($conn,$sql_event_name);
        if(mysqli_num_rows($result_event_name) > 0){
            $get_event_name = mysqli_fetch_assoc($result_event_name);
            $event_name = $get_event_name['event_name'];
        }

        $sql_event_type = "SELECT * FROM event_type WHERE event_type_id = $event_type_id";
        $result_event_type = mysqli_query($conn,$sql_event_type);
        $get_event_type = mysqli_fetch_assoc($result_event_type);
        $event_type = $get_event_type['event_type'];

        if($event_name != ""){
            $sql_category_name = "SELECT * FROM category_name WHERE event_name_id = $event_name_id AND event_type_id = $event_type_id AND category_name = '$category_name'";
            $result_category_name = mysqli_query($conn,$sql_category_name);  

            $category_name = trim($category_name);
            $category_name = preg_replace('/\s+/', ' ', $category_name);

            if (mysqli_num_rows($result_category_name) > 0){
                $error['categoryName'] = "$category_name already exists! [$event_name][$event_type]";
            }
            else{
                $sql = "INSERT INTO category_name(event_name_id, event_type_id, category_name) VALUES ('$event_name_id', '$event_type_id', '$category_name')";
                mysqli_query($conn,$sql);  

                to_log($conn, $sql);

                header('Location: EVE-admin-event-configuration.php?Category Name Saved');
            }
        }
        else{
            echo "<script>alert('Something went wrong');</script>";
            header('Refresh:0; url=EVE-admin-event-configuration.php?something went wrong');
        }
    }

    if(isset($_GET['eventNameId'])){
        $id = $_GET['eventNameId'];
        
        $sql = "SELECT category_name_id FROM category_name WHERE event_name_id = $id;";
        $query = mysqli_query($conn, $sql);
        $result = mysqli_fetch_array($query);
        $cid = $result['category_name_id'];

        $delete_criterion = mysqli_query($conn,"DELETE FROM criterion WHERE category_name_id = $cid");
        $delete_category_name = mysqli_query($conn,"DELETE FROM category_name WHERE event_name_id = $id");
        $delete_event_name = mysqli_query($conn,"DELETE FROM event_name WHERE event_name_id = $id");

        header('Location: EVE-admin-event-configuration.php');
    }

    if(isset($_GET['categoryNameId'])){
        $id = $_GET['categoryNameId'];
        $delete_criterion = mysqli_query($conn,"DELETE FROM criterion WHERE category_name_id = $id");
        $delete_category_name = mysqli_query($conn,"DELETE FROM category_name WHERE category_name_id = $id");
        header('Location: EVE-admin-event-configuration.php');
    }
?>