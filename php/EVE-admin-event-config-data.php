<?php
    $dbname=mysqli_connect("localhost","root","","pupets");

    if(isset($_POST['eventSaveBtn'])){
        $event_name =  mysqli_real_escape_string($dbname,$_POST['inputEventName']);
        $sql_event_name = "SELECT * FROM eventnametb WHERE event_name = '$event_name'";
        $result_event_name = mysqli_query($dbname,$sql_event_name);  

        $event_name = trim($event_name," ");

        if (mysqli_num_rows($result_event_name) > 0){
            $error['eventName'] = "$event_name already exists!";
        }
        else{
            $sql = "INSERT INTO eventnametb(event_name) VALUES ('$event_name')";
            mysqli_query($dbname,$sql);  

            header('Refresh: 3; url:EVE-admin-list-of-events.php');
            header('Location: EVE-admin-event-configuration.php?event name saved');
        }
    }  

    if(isset($_POST['categorySaveBtn'])){
        $event_name_id =  mysqli_real_escape_string($dbname,$_POST['selectEventName']);
        $event_type_id =  mysqli_real_escape_string($dbname,$_POST['selectEventType']);
        $category_name =  mysqli_real_escape_string($dbname,$_POST['inputCategoryName']);

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

        if($event_name != ""){
            $sql_category_name = "SELECT * FROM categorynametb WHERE event_name_id = $event_name_id AND event_type_id = $event_type_id AND category_name = '$category_name'";
            $result_category_name = mysqli_query($dbname,$sql_category_name);  

            $category_name = trim($category_name," ");

            if (mysqli_num_rows($result_category_name) > 0){
                $error['categoryName'] = "$category_name already exists! [$event_name][$event_type]";
            }
            else{
                $sql = "INSERT INTO categorynametb(event_name_id, event_type_id, category_name) VALUES ('$event_name_id', '$event_type_id', '$category_name')";
                mysqli_query($dbname,$sql);  

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
        $delete_event_name = mysqli_query($dbname,"DELETE FROM eventnametb WHERE event_name_id = $id");
        $delete_category_name = mysqli_query($dbname,"DELETE FROM categorynametb WHERE event_name_id = $id");
        header('Location: EVE-admin-event-configuration.php');
    }

    if(isset($_GET['categoryNameId'])){
        $id = $_GET['categoryNameId'];
        $delete_event_name = mysqli_query($dbname,"DELETE FROM categorynametb WHERE category_name_id = $id");
        header('Location: EVE-admin-event-configuration.php');
    }
?>