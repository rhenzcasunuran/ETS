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
        $ongoing_event_name_id = '';

        $event_description = preg_replace('/\s+/', ' ', $event_description);

        $sql = "SELECT category_name FROM category_name WHERE category_name_id = '$category_name_id';";
        $query = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($query);
        $category_name = $row['category_name'];

        if($event_name_id != ""){

            $sql = "SELECT * FROM ongoing_event_name WHERE event_name_id = $event_name_id AND is_done = '0';";
            $query = mysqli_query($conn,$sql);
            $row = mysqli_num_rows($query);

            if ($row > 0) {
                $row = mysqli_fetch_array($query);
                $ongoing_event_name_id = $row['ongoing_event_name_id'];
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
            }
        
            //Insert on List of Events
            $sql = "INSERT INTO ongoing_list_of_event (category_name_id, ongoing_event_name_id, event_name_id, event_type_id, category_name, event_description, event_date, event_time) VALUES ('$category_name_id', '$ongoing_event_name_id', '$event_name_id', '$event_type_id', '$category_name', '$event_description', '$event_date', '$event_time');";
            mysqli_query($conn,$sql);  

            //Insert to Logs
            to_log($conn, $sql);

            //Set up Event Code
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

            //Insert Criteria
            $sql = "INSERT INTO ongoing_criterion (criterion_id, category_name_id, event_id, criterion_name, criterion_percent)
                SELECT criterion_id, category_name_id, $event_id, criterion_name, criterion_percent
                FROM criterion
                WHERE category_name_id = '$category_name_id';";
            mysqli_query($conn,$sql);  

            //Insert Competition
            $sql = "INSERT INTO competition (event_id) VALUES ('$event_id');";
            mysqli_query($conn,$sql);

            $sql = "DELETE FROM criterion WHERE category_name_id = '$category_name_id';";
            mysqli_query($conn,$sql);
                        
            $sql = "DELETE FROM category_name WHERE category_name_id = '$category_name_id';";
            mysqli_query($conn,$sql);

            header('Location: EVE-admin-list-of-events.php');
        }
        else{
            echo "<script>alert('Something went wrong');</script>";
            header('Refresh:0; url=EVE-admin-create-event.php?something went wrong');
        }
    }

    else if (isset($_POST['save-btn-tournament'])) {
        $event_name_id =  mysqli_real_escape_string($conn,$_POST['select-event-name']);
        $event_type_id =  mysqli_real_escape_string($conn,$_POST['select-event-type']);
        $category_name_id =  mysqli_real_escape_string($conn,$_POST['select-category-name']);
        $event_description =  mysqli_real_escape_string($conn,$_POST['event-description']);
        $event_date =  mysqli_real_escape_string($conn,$_POST['date']);
        $event_time =  mysqli_real_escape_string($conn,$_POST['time']);
        $event_match_style = mysqli_real_escape_string($conn,$_POST['event-match-style']);
        $event_code_get =  mysqli_real_escape_string($conn,$_POST['code']);

        $event_description = preg_replace('/\s+/', ' ', $event_description);

        $sql = "SELECT category_name FROM category_name WHERE category_name_id = '$category_name_id';";
        $query = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($query);
        $category_name = $row['category_name'];

        if($event_name_id != ""){

            $sql = "SELECT * FROM ongoing_event_name WHERE event_name_id = $event_name_id AND is_done = '0';";
            $query = mysqli_query($conn,$sql);
            $row = mysqli_num_rows($query);

            if ($row > 0) {
                $row = mysqli_fetch_array($query);
                $ongoing_event_name_id = $row['ongoing_event_name_id'];
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
            }

            //Insert on List of Events
            $sql = "INSERT INTO ongoing_list_of_event (category_name_id, ongoing_event_name_id, event_name_id, event_type_id, category_name, event_description, event_date, event_time) VALUES ('$category_name_id', '$ongoing_event_name_id', '$event_name_id', '$event_type_id', '$category_name', '$event_description', '$event_date', '$event_time');";
            mysqli_query($conn,$sql);  

            //Insert to Logs
            to_log($conn, $sql);

            //Set up Event Code
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

            //Delete Data
            $sql = "DELETE FROM category_name WHERE category_name_id = '$category_name_id';";
            mysqli_query($conn,$sql);

            header('Location: EVE-admin-list-of-events.php');
            
        }
        else{
            echo "<script>alert('Something went wrong');</script>";
            header('Refresh:0; url=EVE-admin-create-event.php');
        }
    }

    else if (isset($_POST['save-btn-standard'])) {
        $event_name_id =  mysqli_real_escape_string($conn,$_POST['select-event-name']);
        $event_type_id =  mysqli_real_escape_string($conn,$_POST['select-event-type']);
        $event_description =  mysqli_real_escape_string($conn,$_POST['event-description']);
        $event_date =  mysqli_real_escape_string($conn,$_POST['date']);
        $event_time =  mysqli_real_escape_string($conn,$_POST['time']);

        $event_description = preg_replace('/\s+/', ' ', $event_description);

        if($event_name_id != ""){
            $sql = "INSERT IGNORE INTO ongoing_event_name (event_name_id, event_name)
                    SELECT event_name_id, event_name
                    FROM event_name
                    WHERE event_name_id = '$event_name_id';";
            mysqli_query($conn,$sql);

            //Insert on List of Events
            $sql = "INSERT INTO ongoing_list_of_event (event_name_id, event_type_id, event_description, event_date, event_time) VALUES ('$event_name_id', '$event_type_id', '$event_description', '$event_date', '$event_time');";
            mysqli_query($conn,$sql);  

            //Insert to Logs
            to_log($conn, $sql);

            header('Location: EVE-admin-list-of-events.php');
            
        }
        else{
            echo "<script>alert('Something went wrong');</script>";
            header('Refresh:0; url=EVE-admin-create-event.php');
        }
    }
?>