<?php
    require 'database_connect.php'; 
    include 'CAL-logger.php';

    $code = "";

    if(isset($_GET['eec'])){
        $code = $_GET['eec'];
        $sql = "SELECT ole.event_id, ole.category_name_id AS ole_category_name_id, ole.event_description, ole.event_code, ole.event_date, ole.event_time,
                oen.event_name_id, oen.event_name,
                ocn.category_name_id, ocn.event_name_id AS ocn_event_name_id, ocn.event_type_id, ocn.category_name,
                et.event_type_id AS et_event_type_id, et.event_type
                FROM ongoing_event_name AS oen
                JOIN ongoing_category_name AS ocn ON oen.event_name_id = ocn.event_name_id
                JOIN event_type AS et ON ocn.event_type_id = et.event_type_id
                JOIN ongoing_list_of_event AS ole ON ocn.category_name_id = ole.category_name_id
                WHERE ole.event_id = $code;";
        $query = mysqli_query($conn, $sql);
        $edit_event_row = mysqli_fetch_array($query);
    }

    if(isset($_POST['save-btn'])){
        $code = $_POST['id'];
        $event_name_id =  mysqli_real_escape_string($conn,$_POST['select-event-name']);
        $event_type_id =  mysqli_real_escape_string($conn,$_POST['select-event-type']);
        $category_name_id =  mysqli_real_escape_string($conn,$_POST['select-category-name']);
        $event_description =  mysqli_real_escape_string($conn,$_POST['event-description']);
        $event_date =  mysqli_real_escape_string($conn,$_POST['date']);
        $event_time =  mysqli_real_escape_string($conn,$_POST['time']);

        $sql = "SELECT category_name_id FROM ongoing_list_of_event WHERE event_id = $code;";
        $query = mysqli_query($conn,$sql);
        $result = mysqli_fetch_array($query);
        $currentCategoryID = $result[0];

         /* $event_name = "";
 
         $sql_event_name = "SELECT * FROM event_name WHERE event_name_id = $event_name_id";
         $result_event_name = mysqli_query($conn,$sql_event_name);
         if(mysqli_num_rows($result_event_name) > 0){
             $get_event_name = mysqli_fetch_assoc($result_event_name);
             $event_name = $get_event_name['event_name'];
         }
 
         $sql_event_type = "SELECT * FROM eventtypetb WHERE event_type_id = $event_type_id";
         $result_event_type = mysqli_query($conn,$sql_event_type);
         $get_event_type = mysqli_fetch_assoc($result_event_type);
         $event_type = $get_event_type['event_type']; */

         $event_description = preg_replace('/\s+/', ' ', $event_description);

         if ($category_name_id !== $currentCategoryID) {
            $sql = "INSERT IGNORE INTO ongoing_event_name (event_name_id, event_name)
                    SELECT event_name_id, event_name
                    FROM event_name
                    WHERE event_name_id = '$event_name_id';";
            mysqli_query($conn,$sql);

            $sql = "INSERT IGNORE INTO category_name (category_name_id, event_name_id, event_type_id, category_name)
                    SELECT category_name_id, event_name_id, event_type_id, category_name
                    FROM ongoing_category_name
                    WHERE category_name_id = '$currentCategoryID';";
            mysqli_query($conn,$sql);

            $sql = "INSERT IGNORE INTO criterion (criterion_id, category_name_id, criterion_name, criterion_percent)
                    SELECT criterion_id, category_name_id, criterion_name, criterion_percent
                    FROM ongoing_criterion
                    WHERE category_name_id = '$currentCategoryID';";
             mysqli_query($conn,$sql); 

            $sql = "INSERT IGNORE INTO ongoing_category_name (category_name_id, event_name_id, event_type_id, category_name)
                    SELECT category_name_id, event_name_id, event_type_id, category_name
                    FROM category_name
                    WHERE category_name_id = '$category_name_id';";
            mysqli_query($conn,$sql);

            $sql = "INSERT IGNORE INTO ongoing_criterion (criterion_id, category_name_id, criterion_name, criterion_percent)
                    SELECT criterion_id, category_name_id, criterion_name, criterion_percent
                    FROM criterion
                    WHERE category_name_id = '$category_name_id';";
                    mysqli_query($conn,$sql); 
         }


             $sql = "UPDATE ongoing_list_of_event SET category_name_id = '$category_name_id', event_description = '$event_description', event_date =' $event_date', event_time = '$event_time' WHERE event_id = '$code';";
             mysqli_query($conn,$sql);

             to_log($conn, $sql);

             if ($category_name_id !== $currentCategoryID) {

            $sql = "DELETE FROM ongoing_criterion WHERE category_name_id = '$currentCategoryID';";
            mysqli_query($conn,$sql);

            $sql = "DELETE FROM ongoing_category_name WHERE category_name_id = '$currentCategoryID';";
            mysqli_query($conn,$sql);

            $sql = "DELETE FROM ongoing_category_name
                    WHERE event_name_id NOT IN (
                        SELECT event_name_id
                        FROM event_name
                    )";
            mysqli_query($conn, $sql);

            $sql = "DELETE FROM ongoing_event_name
                    WHERE event_name_id NOT IN (
                        SELECT event_name_id
                        FROM ongoing_category_name
                    );";
            $query = mysqli_query($conn,$sql);

            $sql = "DELETE FROM criterion WHERE category_name_id = '$category_name_id';";
            mysqli_query($conn,$sql);

            $sql = "DELETE FROM category_name WHERE category_name_id = '$category_name_id';";
            mysqli_query($conn,$sql);

                }

            header('Location: EVE-admin-list-of-events.php?event successfully updated');
     }

        
   /* if(isset($_GET['eed'])){
        $code = $_GET['eed'];

        $sql = "SELECT category_name_id FROM ongoing_list_of_event WHERE event_code = '$code';";
        $query = mysqli_query($conn,$sql);
        $result = mysqli_fetch_array($query);
        $category_name_id = $result[0];
       
        $sql = "INSERT IGNORE INTO category_name (category_name_id, event_name_id, event_type_id, category_name)
                SELECT category_name_id, event_name_id, event_type_id, category_name
                FROM ongoing_category_name
                WHERE category_name_id = $category_name_id;";
        mysqli_query($conn,$sql); 

        $sql = "INSERT IGNORE INTO criterion (criterion_id, category_name_id, criterion_name, criterion_percent)
                SELECT criterion_id, category_name_id, criterion_name, criterion_percent
                FROM ongoing_criterion
                WHERE category_name_id = '$category_name_id';";
        mysqli_query($conn,$sql); 

        $sql = "SELECT event_id FROM ongoing_list_of_event WHERE category_name_id = '$category_name_id' AND event_code = '$code';";
        $query = mysqli_query($conn,$sql); 
        $result = mysqli_fetch_array($query);
        $eventID = $result['event_id'];

        $sql = "DELETE t5, t4, t3, t2, t1
        FROM ongoing_list_of_event AS t1
        LEFT JOIN ongoing_criterion AS t2 ON t1.event_id = t2.event_id
        LEFT JOIN highlights AS t3 ON t1.event_id = t3.event_id
        LEFT JOIN tournament AS t4 ON t1.event_id = t4.event_id
        LEFT JOIN competition AS t5 ON t1.event_id = t5.event_id
        WHERE t1.event_id = $eventID;";
        mysqli_query($conn,$sql); 

        to_log($conn, $sql);

        $sql = "DELETE FROM ongoing_event_name
                WHERE event_name_id NOT IN (
                    SELECT event_name_id
                    FROM ongoing_category_name
                );";
        $query = mysqli_query($conn,$sql);

        header('Location: EVE-admin-list-of-events.php');
    } */

    if(isset($_GET['mad'])){
        $code = $_GET['mad'];
        $select_event = mysqli_query($conn,"SELECT * FROM ongoing_list_of_event WHERE event_code = '$code';");
        $row = mysqli_num_rows($select_event);
        $result = mysqli_fetch_array($select_event);
        $category_name_id = $result['category_name_id'];
        if($row > 0) {
            $sql = "UPDATE ongoing_list_of_event SET is_archived = '1';";

            mysqli_query($conn, $sql);
            $sql = "INSERT IGNORE INTO category_name (category_name_id, event_name_id, event_type_id, category_name)
                    SELECT category_name_id, event_name_id, event_type_id, category_name
                    FROM ongoing_category_name
                    WHERE category_name_id = $category_name_id;";
            mysqli_query($conn,$sql); 

            $sql = "INSERT IGNORE INTO criterion (criterion_id, category_name_id, criterion_name, criterion_percent)
                    SELECT criterion_id, category_name_id, criterion_name, criterion_percent
                    FROM ongoing_criterion
                    WHERE category_name_id = '$category_name_id';";
            mysqli_query($conn,$sql); 
        }
    }
?>