<?php
    require 'database_connect.php'; 
    include 'CAL-logger.php';

    $code = "";

    if(isset($_GET['eec'])){
        $id = $_GET['eec'];
        $sql = "SELECT ole.*,
                oen.*,
                et.*
                FROM ongoing_event_name AS oen
                JOIN event_type AS et
                JOIN ongoing_list_of_event AS ole ON ole.ongoing_event_name_id = oen.ongoing_event_name_id AND ole.event_name_id = oen.event_name_id AND ole.event_type_id = et.event_type_id
                WHERE is_archived = 0 AND ole.event_id = $id;";
                
        $query = mysqli_query($conn, $sql);
        $edit_event_row = mysqli_fetch_array($query);
    }

    if(isset($_POST['save-btn'])){
        $event_code = $_POST['id'];
        $event_name_id =  mysqli_real_escape_string($conn,$_POST['select-event-name']);
        $event_type_id =  mysqli_real_escape_string($conn,$_POST['select-event-type']);
        $category_name_id =  mysqli_real_escape_string($conn,$_POST['select-category-name']);
        $event_description =  mysqli_real_escape_string($conn,$_POST['event-description']);
        $event_date =  mysqli_real_escape_string($conn,$_POST['date']);
        $event_time =  mysqli_real_escape_string($conn,$_POST['time']);

        $sql = "SELECT * FROM ongoing_list_of_event WHERE event_code = '$event_code';";
        $query = mysqli_query($conn,$sql);
        $result = mysqli_fetch_array($query);
        $event_id = $result['event_id'];
        $present_category_name_id = $result['category_name_id'];
        $present_event_name_id = $result['event_name_id'];
        $present_event_type_id = $result['event_type_id'];
        $present_category_name = $result['category_name'];
        $present_event_description = $result['event_description'];
        $present_event_date = $result['event_date'];
        $present_event_time = $result['event_time'];

        $event_description = preg_replace('/\s+/', ' ', $event_description);

         if ($event_type_id == 2) {

                // Edit Category
                if ($category_name_id != $present_category_name_id) {
                        //Transfer Category
                        $sql = "INSERT IGNORE INTO category_name (category_name_id, event_name_id, event_type_id, category_name)
                                SELECT category_name_id, event_name_id, event_type_id, category_name
                                FROM ongoing_list_of_event
                                WHERE event_id = '$event_id';";
                        mysqli_query($conn,$sql);

                        //Select Category Name
                        $sql = "SELECT * FROM category_name WHERE category_name_id = '$category_name_id';";
                        $query = mysqli_query($conn,$sql);
                        $result = mysqli_fetch_array($query);
                        $category_name = $result['category_name'];

                        //Transfer Current Criterion
                        $sql = "INSERT INTO criterion (criterion_id, category_name_id, criterion_name, criterion_percent)
                                SELECT criterion_id, category_name_id, criterion_name, criterion_percent
                                FROM ongoing_criterion
                                WHERE event_id = '$event_id';";
                        mysqli_query($conn,$sql);

                        //Delete Current Criterion
                        $sql = "DELETE FROM ongoing_criterion WHERE event_id = '$event_id';";
                        mysqli_query($conn,$sql);

                        //Update Category
                        $sql = "UPDATE ongoing_list_of_event SET category_name_id = '$category_name_id', event_name_id = '$event_name_id', event_type_id = '$event_type_id', category_name = '$category_name' WHERE event_id = '$event_id';";
                        mysqli_query($conn,$sql);
                        to_log($conn, $sql);

                        //Insert New Criterion
                        $sql = "INSERT INTO ongoing_criterion (criterion_id, category_name_id, event_id, criterion_name, criterion_percent)
                                SELECT criterion_id, category_name_id, $event_id, criterion_name, criterion_percent
                                FROM criterion
                                WHERE category_name_id = '$category_name_id';";
                        mysqli_query($conn,$sql);

                        //Delete from editable
                        $sql = "DELETE FROM criterion WHERE category_name_id = '$category_name_id';";
                        mysqli_query($conn,$sql);

                        $sql = "DELETE FROM category_name WHERE category_name_id = '$category_name_id';";
                        mysqli_query($conn,$sql);

                        if ($event_name_id != $present_event_name_id) {
                                $sql = "SELECT * FROM ongoing_event_name WHERE event_name_id = $event_name_id AND is_done = '0';";
                                $query = mysqli_query($conn,$sql);
                                $row = mysqli_num_rows($query);

                                if ($row > 0) {
                                        $row = mysqli_fetch_array($query);
                                        $ongoing_event_name_id = $row['ongoing_event_name_id'];

                                        $sql = "UPDATE ongoing_list_of_event SET ongoing_event_name_id = '$ongoing_event_name_id', event_name_id = '$event_name_id';";
                                        mysqli_query($conn,$sql);
                                        to_log($conn, $sql);
                                }
                                else {
                                        $sql = "INSERT INTO ongoing_event_name (event_name_id, event_name)
                                                SELECT event_name_id, event_name
                                                FROM event_name
                                                WHERE event_name_id = '$event_name_id';";
                                        mysqli_query($conn, $sql);

                                        $sql = "SELECT * FROM ongoing_event_name WHERE event_name_id = $event_name_id AND is_done = '0';";
                                        $query = mysqli_query($conn,$sql);
                                        $row = mysqli_fetch_array($query);
                                        $ongoing_event_name_id = $row['ongoing_event_name_id'];

                                        $sql = "UPDATE ongoing_list_of_event SET ongoing_event_name_id = '$ongoing_event_name_id', event_name_id = '$event_name_id' WHERE event_id = $event_id;";
                                        mysqli_query($conn,$sql);
                                        to_log($conn, $sql);
                                }
                        }

                        if ($event_type_id != $present_event_type_id && $event_type_id == 2) {
                                // Create a unique constraint on the event_id column
                                $sql = "ALTER TABLE competition ADD UNIQUE (event_id);";
                                mysqli_query($conn, $sql);
        
                                // Insert query
                                $sql = "INSERT IGNORE INTO competition (event_id) VALUES ('$event_id');";
                                mysqli_query($conn, $sql);

                                $sql = "SELECT tournament_id FROM tournament WHERE event_id = '$event_id';";
                                $query = mysqli_query($conn, $sql);
                                $result = mysqli_fetch_array($query);
                                $tournament_id = $result['tournament_id'];
        
                                $sql = "DELETE FROM tou_team_stat WHERE tournament_id = '$tournament_id';";
                                mysqli_query($conn,$sql);
                        
                                $sql = "DELETE FROM tournament WHERE event_id = '$event_id';";
                                mysqli_query($conn,$sql);
                        }
                }

                if ($event_description != $present_event_description) {
                        $sql = "UPDATE ongoing_list_of_event SET event_description = '$event_description' WHERE event_id = '$event_id';";
                        mysqli_query($conn,$sql);
                        to_log($conn, $sql);
                }

                if ($event_date != $present_event_date) {
                        $sql = "UPDATE ongoing_list_of_event SET event_date = '$event_date' WHERE event_id = '$event_id';";
                        mysqli_query($conn,$sql);
                        to_log($conn, $sql);
                }

                if ($event_time != $present_event_time) {
                        $sql = "UPDATE ongoing_list_of_event SET event_time = '$event_time' WHERE event_id = '$event_id';";
                        mysqli_query($conn,$sql);
                        to_log($conn, $sql);
                }
        
                $sql = "DELETE FROM ongoing_event_name
                        WHERE ongoing_event_name_id NOT IN (
                        SELECT ongoing_event_name_id
                        FROM ongoing_list_of_event
                        );";
                mysqli_query($conn,$sql);
         }
        header('Location: EVE-admin-list-of-events.php');
     }

     if(isset($_POST['save-btn-tournament'])){
        $event_code = $_POST['id'];
        $event_name_id =  mysqli_real_escape_string($conn,$_POST['select-event-name']);
        $event_type_id =  mysqli_real_escape_string($conn,$_POST['select-event-type']);
        $category_name_id =  mysqli_real_escape_string($conn,$_POST['select-category-name']);
        $event_description =  mysqli_real_escape_string($conn,$_POST['event-description']);
        $event_date =  mysqli_real_escape_string($conn,$_POST['date']);
        $event_time =  mysqli_real_escape_string($conn,$_POST['time']);
        $event_wins = mysqli_real_escape_string($conn,$_POST['event-match-style']);

        $sql = "SELECT * FROM ongoing_list_of_event WHERE event_code = '$event_code';";
        $query = mysqli_query($conn,$sql);
        $result = mysqli_fetch_array($query);
        $event_id = $result['event_id'];
        $present_category_name_id = $result['category_name_id'];
        $present_event_name_id = $result['event_name_id'];
        $present_event_type_id = $result['event_type_id'];
        $present_category_name = $result['category_name'];
        $present_event_description = $result['event_description'];
        $present_event_date = $result['event_date'];
        $present_event_time = $result['event_time'];

         $event_description = preg_replace('/\s+/', ' ', $event_description);

         if ($event_type_id == 1) {
                // Edit Category
                if ($category_name_id != $present_category_name_id) {
                        //Transfer Category
                        $sql = "INSERT INTO category_name (category_name_id, event_name_id, event_type_id, category_name)
                                SELECT category_name_id, event_name_id, event_type_id, category_name
                                FROM ongoing_list_of_event
                                WHERE event_id = '$event_id';";
                        mysqli_query($conn,$sql);

                        $sql = "SELECT * FROM category_name WHERE category_name_id = '$category_name_id';";
                        $query = mysqli_query($conn,$sql);
                        $result = mysqli_fetch_array($query);
                        $category_name = $result['category_name'];

                        //Update Category
                        $sql = "UPDATE ongoing_list_of_event SET category_name_id = '$category_name_id', event_name_id = '$event_name_id', event_type_id = '$event_type_id', category_name = '$category_name' WHERE event_id = '$event_id';";
                        mysqli_query($conn,$sql);
                        to_log($conn, $sql);

                        if ($event_name_id != $present_event_name_id) {
                                $sql = "SELECT * FROM ongoing_event_name WHERE event_name_id = $event_name_id AND is_done = '0';";
                                $query = mysqli_query($conn,$sql);
                                $row = mysqli_num_rows($query);

                                if ($row > 0) {
                                        $row = mysqli_fetch_array($query);
                                        $ongoing_event_name_id = $row['ongoing_event_name_id'];

                                        $sql = "UPDATE ongoing_list_of_event SET ongoing_event_name_id = '$ongoing_event_name_id', event_name_id = '$event_name_id';";
                                        mysqli_query($conn,$sql);
                                        to_log($conn, $sql);
                                }
                                else {
                                        $sql = "INSERT INTO ongoing_event_name (event_name_id, event_name)
                                                SELECT event_name_id, event_name
                                                FROM event_name
                                                WHERE event_name_id = '$event_name_id';";
                                        mysqli_query($conn, $sql);

                                        $sql = "SELECT * FROM ongoing_event_name WHERE event_name_id = $event_name_id AND is_done = '0';";
                                        $query = mysqli_query($conn,$sql);
                                        $row = mysqli_fetch_array($query);
                                        $ongoing_event_name_id = $row['ongoing_event_name_id'];

                                        $sql = "UPDATE ongoing_list_of_event SET ongoing_event_name_id = '$ongoing_event_name_id', event_name_id = '$event_name_id' WHERE event_id = $event_id;";
                                        mysqli_query($conn,$sql);
                                        to_log($conn, $sql);
                                }
                        }

                        if ($event_type_id != $present_event_type_id) {
                                // Ongoing Criterion to Criterion
                                $sql = "INSERT INTO criterion (criterion_id, category_name_id, criterion_name, criterion_percent)
                                        SELECT criterion_id, category_name_id, criterion_name, criterion_percent
                                        FROM ongoing_criterion
                                        WHERE event_id = '$event_id';";
                                mysqli_query($conn,$sql);

                                $sql = "DELETE FROM ongoing_criterion WHERE event_id = '$event_id';";
                                mysqli_query($conn,$sql);

                                // Criterion to Ongoing Criterion
                                $sql = "INSERT INTO ongoing_criterion (criterion_id, category_name_id, criterion_name, criterion_percent, event_id)
                                        SELECT criterion_id, category_name_id, criterion_name, criterion_percent, $event_id
                                        FROM criterion
                                        WHERE category_name_id = '$category_name_id';";
                                mysqli_query($conn,$sql);

                                $sql = "DELETE FROM competition WHERE event_id = '$event_id';";
                                mysqli_query($conn,$sql);


                                //Insert Number of Wins
                                $sql = "INSERT INTO tournament (event_id, number_of_wins_id) VALUES ('$event_id', '$event_match_style');";
                                mysqli_query($conn,$sql); 

                                $sql = "SELECT tournament_id FROM tournament WHERE event_id = '$event_id';";
                                $query = mysqli_query($conn, $sql);
                                $result = mysqli_fetch_array($query);
                                $tournament_id = $result['tournament_id'];

                                $sql = "SELECT * FROM organization WHERE organization_id != '0';";
                                $org = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($org)) {
                                        $sql = "INSERT INTO tou_team_stat (tournament_id, organization_id) VALUES ('$tournament_id', '$row[0]');";
                                        mysqli_query($conn, $sql);
                                }
                        }

                        $sql = "DELETE FROM category_name WHERE category_name_id = '$category_name_id';";
                        mysqli_query($conn,$sql);
                }


                if ($event_description != $present_event_description) {
                        //Update Category
                        $sql = "UPDATE ongoing_list_of_event SET event_description = '$event_description' WHERE event_id = '$event_id';";
                        mysqli_query($conn,$sql);
                        to_log($conn, $sql);
                }

                if ($event_date != $present_event_date) {
                        $sql = "UPDATE ongoing_list_of_event SET event_date = '$event_date' WHERE event_id = '$event_id';";
                        mysqli_query($conn,$sql);
                        to_log($conn, $sql);
                }

                if ($event_time != $present_event_time) {
                        $sql = "UPDATE ongoing_list_of_event SET event_time = '$event_time' WHERE event_id = '$event_id';";
                        mysqli_query($conn,$sql);
                        to_log($conn, $sql);
                }

                // Check if the current value of event_wins is different from the new value
                $sql = "SELECT number_of_wins_id FROM tournament WHERE event_id = '$event_id';";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $current_wins = $row['number_of_wins_id'];

                if ($current_wins != $event_wins) {
                        // Update query
                        $sql = "UPDATE tournament SET number_of_wins_id = '$event_wins' WHERE event_id = '$event_id';";
                        mysqli_query($conn, $sql);
                        to_log($conn, $sql);

                        // Check if any rows were affected by the update query
                        if (mysqli_affected_rows($conn) == 0) {
                                // No rows were updated, so perform the insert query
                                $sql = "INSERT INTO tournament (event_id, number_of_wins_id) VALUES ('$event_id', '$event_wins');";
                                mysqli_query($conn, $sql);
                                to_log($conn, $sql);
                        }
                }
        
                $sql = "DELETE FROM ongoing_event_name
                        WHERE ongoing_event_name_id NOT IN (
                        SELECT ongoing_event_name_id
                        FROM ongoing_list_of_event
                        );";
                mysqli_query($conn,$sql);
         }
        header('Location: EVE-admin-list-of-events.php');
     }

     $popupContent = '';
     
     if (isset($_POST['deb'])) {
        $all_id = $_POST['deleteEvent'] ?? NULL;
        
        if ($all_id != NULL){
                $extract_id = implode(',', $all_id);

                $sql = "INSERT IGNORE INTO category_name (category_name_id, event_name_id, event_type_id, category_name)
                        SELECT category_name_id, event_name_id, event_type_id, category_name
                        FROM ongoing_list_of_event
                        WHERE event_id IN($extract_id);";
                mysqli_query($conn,$sql);

                $sql = "INSERT IGNORE INTO criterion (criterion_id, category_name_id, criterion_name, criterion_percent)
                        SELECT criterion_id, category_name_id, criterion_name, criterion_percent
                        FROM ongoing_criterion
                        WHERE event_id IN($extract_id);";
                mysqli_query($conn,$sql);

                $sql = "UPDATE ongoing_list_of_event SET is_deleted = '1', event_code = NULL WHERE event_id IN($extract_id);";
                $deleteQuery = mysqli_query($conn, $sql);
        }
        else {
                $popUpID = "deleteEvent";
                $showPopUpButtonID = "";
                $icon = "<i class='bx bxs-calendar-exclamation warning-color'></i>";
                $title = "There are no selected events";
                $message = "Select an event if you want to delete an event";
                $your_link = "EVE-admin-list-of-events.php";
      
                // Make sure to include your php query to the your page
      
                ob_start();
                include './php/popup-1-btn.php';
                $popupContent = ob_get_clean();
        }

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
        $id = $_GET['mad'];
        $select_event = mysqli_query($conn,"SELECT * FROM ongoing_list_of_event WHERE event_id = '$id';");
        $row = mysqli_num_rows($select_event);
        $result = mysqli_fetch_array($select_event);
        $ongoing_event_name_id = $result['ongoing_event_name_id'];
        $category_name_id = $result['category_name_id'];
        if($row > 0) {
                $sql = "UPDATE ongoing_list_of_event SET is_archived = '1' WHERE event_id = '$id';";

                mysqli_query($conn, $sql);
                $sql = "INSERT IGNORE INTO category_name (category_name_id, event_name_id, event_type_id, category_name)
                        SELECT category_name_id, event_name_id, event_type_id, category_name
                        FROM ongoing_list_of_event
                        WHERE event_id = $id;";
                mysqli_query($conn,$sql); 

                $sql = "INSERT IGNORE INTO criterion (criterion_id, category_name_id, criterion_name, criterion_percent)
                        SELECT criterion_id, category_name_id, criterion_name, criterion_percent
                        FROM ongoing_criterion
                        WHERE event_id = '$id';";
                mysqli_query($conn,$sql); 

                $sql = "SELECT * FROM ongoing_list_of_event WHERE ongoing_event_name_id = '$ongoing_event_name_id';";
                $query = mysqli_query($conn, $sql);
                $totalList = 0;
                $totalArchived = 0;

                while ($row = mysqli_fetch_assoc($query)) {
                        $totalList += 1;
                        if ($row['is_archived'] == 1) {
                                $totalArchived += 1;
                        }
                }

                if ($totalList == $totalArchived) {
                        $sql = "UPDATE ongoing_event_name SET is_done = '1' WHERE ongoing_event_name_id = '$ongoing_event_name_id';";
                        mysqli_query($conn,$sql); 
                }

            header("Location: EVE-admin-list-of-events.php");
        }
    }
?>