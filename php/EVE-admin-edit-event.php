<?php
    require 'database_connect.php'; 
    include 'CAL-logger.php';

    $code = "";
    $popupContentSuccess = "";
    $popupContentNotSuccess = "";

    if(isset($_GET['eec'])){
        $id = $_GET['eec'];
        $sql = "SELECT ole.*,
                oen.*,
                et.*
                FROM ongoing_event_name AS oen
                JOIN event_type AS et
                JOIN ongoing_list_of_event AS ole ON ole.ongoing_event_name_id = oen.ongoing_event_name_id AND ole.event_name_id = oen.event_name_id AND ole.event_type_id = et.event_type_id
                WHERE is_archived = 0 AND is_deleted = 0 AND ole.event_id = $id;";
                
        $query = mysqli_query($conn, $sql);
        $edit_event_row = mysqli_fetch_array($query);
    }

    if(isset($_POST['save-btn'])){
        $event_id = mysqli_real_escape_string($conn,$_POST['eventId']);
        $event_description =  mysqli_real_escape_string($conn,$_POST['event-description']);
        $event_date =  mysqli_real_escape_string($conn,$_POST['date']);
        $event_time =  mysqli_real_escape_string($conn,$_POST['time']);
        $include_event = isset($_POST['overall']) ? $_POST['overall'] : 1;

        $sql = "SELECT * FROM ongoing_list_of_event WHERE event_id = '$event_id';";
        $query = mysqli_query($conn,$sql);
        $result = mysqli_fetch_array($query);
        $present_event_id = $result['event_id'];
        $present_event_description = $result['event_description'];
        $present_event_date = $result['event_date'];
        $present_event_time = $result['event_time'];
        $present_include_event = $result['overall_include'];
        $affectedRows = 0;

        $event_description = preg_replace('/\s+/', ' ', $event_description);

                if ($event_description !== $present_event_description) {
                        $sql = "UPDATE ongoing_list_of_event SET event_description = '$event_description' WHERE event_id = '$event_id';";
                        mysqli_query($conn,$sql);
                        $affectedRows += mysqli_affected_rows($conn);
                        to_log($conn, $sql);
                }

                if ($event_date !== $present_event_date) {
                        $sql = "UPDATE ongoing_list_of_event SET event_date = '$event_date' WHERE event_id = '$event_id';";
                        mysqli_query($conn,$sql);
                        $affectedRows += mysqli_affected_rows($conn);
                        to_log($conn, $sql);
                }

                if ($event_time !== $present_event_time) {
                        $sql = "UPDATE ongoing_list_of_event SET event_time = '$event_time' WHERE event_id = '$event_id';";
                        mysqli_query($conn,$sql);
                        $affectedRows += mysqli_affected_rows($conn);
                        to_log($conn, $sql);
                }       

                if ($include_event !== $present_include_event) {
                        $sql = "UPDATE ongoing_list_of_event SET overall_include = '$include_event' WHERE event_id = '$event_id';";
                        mysqli_query($conn,$sql);
                        $affectedRows += mysqli_affected_rows($conn);
                        to_log($conn, $sql);
                }
        
                $sql = "DELETE FROM ongoing_event_name
                        WHERE ongoing_event_name_id NOT IN (
                        SELECT ongoing_event_name_id
                        FROM ongoing_list_of_event
                        );";
                mysqli_query($conn,$sql);

                if ($affectedRows > 0) {
                        $popUpID = "sucessEdit";
                        $showPopUpButtonID = "";
                        $icon = "<i class='bx bxs-check-circle success-color'></i>";
                        $title = "Saved Successfully";
                        $message = "Changes are successfully saved.";
                
                        ob_start();
                        include './php/popup-2-btn.php';
                        $popupContentSuccess = ob_get_clean();
                        $_SESSION['popupContentSuccess'] = $popupContentSuccess;

                        header("Location: EVE-admin-list-of-events.php");
                }
                else {
                        $popUpID = "noChanges";
                        $showPopUpButtonID = "";
                        $icon = "<i class='bx bxs-error-circle warning-color'></i>";
                        $title = "No Changes";
                        $message = "There we're no changes happened.";
                
                        ob_start();
                        include './php/popup-2-btn.php';
                        $popupContentNotSuccess = ob_get_clean();
                }
     }

     if(isset($_POST['save-btn-tournament'])){
        $event_id = $_POST['id'];
        $event_description =  mysqli_real_escape_string($conn,$_POST['event-description']);
        $event_date =  mysqli_real_escape_string($conn,$_POST['date']);
        $event_time =  mysqli_real_escape_string($conn,$_POST['time']);
        $event_wins = mysqli_real_escape_string($conn,$_POST['event-match-style']);
        $include_event = isset($_POST['overall']) ? $_POST['overall'] : 1;

        $sql = "SELECT * FROM ongoing_list_of_event WHERE event_id = '$event_id';";
        $query = mysqli_query($conn,$sql);
        $result = mysqli_fetch_array($query);
        $event_id = $result['event_id'];
        $present_event_description = $result['event_description'];
        $present_event_date = $result['event_date'];
        $present_event_time = $result['event_time'];
        $present_include_event = $result['overall_include'];
        $affectedRows = 0;

         $event_description = preg_replace('/\s+/', ' ', $event_description);

                if ($event_description != $present_event_description) {
                        //Update Category
                        $sql = "UPDATE ongoing_list_of_event SET event_description = '$event_description' WHERE event_id = '$event_id';";
                        mysqli_query($conn,$sql);
                        $affectedRows += mysqli_affected_rows($conn);
                        to_log($conn, $sql);
                }

                if ($event_date != $present_event_date) {
                        $sql = "UPDATE ongoing_list_of_event SET event_date = '$event_date' WHERE event_id = '$event_id';";
                        mysqli_query($conn,$sql);
                        $affectedRows += mysqli_affected_rows($conn);
                        to_log($conn, $sql);
                }

                if ($event_time != $present_event_time) {
                        $sql = "UPDATE ongoing_list_of_event SET event_time = '$event_time' WHERE event_id = '$event_id';";
                        mysqli_query($conn,$sql);
                        $affectedRows += mysqli_affected_rows($conn);
                        to_log($conn, $sql);
                }

                if ($include_event != $present_include_event) {
                        $sql = "UPDATE ongoing_list_of_event SET overall_include = '$include_event' WHERE event_id = '$event_id';";
                        mysqli_query($conn,$sql);
                        $affectedRows += mysqli_affected_rows($conn);
                        to_log($conn, $sql);
                }

                if ($event_wins !== ""){
                        // Check if the current value of event_wins is different from the new value
                        $sql = "SELECT number_of_wins_id FROM tournament WHERE event_id = '$event_id';";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $current_wins = $row['number_of_wins_id'];

                        if ($current_wins != $event_wins) {
                                // Update query
                                $sql = "UPDATE tournament SET number_of_wins_id = '$event_wins' WHERE event_id = '$event_id';";
                                mysqli_query($conn, $sql);
                                $affectedRows += mysqli_affected_rows($conn);
                                to_log($conn, $sql);
                        }
                }
        
                $sql = "DELETE FROM ongoing_event_name
                        WHERE ongoing_event_name_id NOT IN (
                        SELECT ongoing_event_name_id
                        FROM ongoing_list_of_event
                        );";
                mysqli_query($conn,$sql);

                    // Code before the popup content

                if ($affectedRows > 0) {
                        $popUpID = "sucessEdit";
                        $showPopUpButtonID = "";
                        $icon = "<i class='bx bxs-check-circle success-color'></i>";
                        $title = "Saved Successfully";
                        $message = "Changes are successfully saved.";
                
                        ob_start();
                        include './php/popup-2-btn.php';
                        $popupContentSuccess = ob_get_clean();
                        $_SESSION['popupContentSuccess'] = $popupContentSuccess;

                        header("Location: EVE-admin-list-of-events.php");
                }
                else {
                        $popUpID = "noChanges";
                        $showPopUpButtonID = "";
                        $icon = "<i class='bx bxs-error-circle warning-color'></i>";
                        $title = "No Changes";
                        $message = "There we're no changes are made.";
                
                        ob_start();
                        include './php/popup-2-btn.php';
                        $popupContentNotSuccess = ob_get_clean();
                }
     }

     if(isset($_POST['save-btn-standard'])){
        $event_id = $_POST['id'];
        $event_description =  mysqli_real_escape_string($conn,$_POST['event-description']);
        $event_date =  mysqli_real_escape_string($conn,$_POST['date']);
        $event_time =  mysqli_real_escape_string($conn,$_POST['time']);

        $sql = "SELECT * FROM ongoing_list_of_event WHERE event_id = '$event_id';";
        $query = mysqli_query($conn,$sql);
        $result = mysqli_fetch_array($query);
        $event_id = $result['event_id'];
        $present_event_description = $result['event_description'];
        $present_event_date = $result['event_date'];
        $present_event_time = $result['event_time'];
        $affectedRows = 0;

         $event_description = preg_replace('/\s+/', ' ', $event_description);

                if ($event_description != $present_event_description) {
                        //Update Category
                        $sql = "UPDATE ongoing_list_of_event SET event_description = '$event_description' WHERE event_id = '$event_id';";
                        mysqli_query($conn,$sql);
                        $affectedRows += mysqli_affected_rows($conn);
                        to_log($conn, $sql);
                }

                if ($event_date != $present_event_date) {
                        $sql = "UPDATE ongoing_list_of_event SET event_date = '$event_date' WHERE event_id = '$event_id';";
                        mysqli_query($conn,$sql);
                        $affectedRows += mysqli_affected_rows($conn);
                        to_log($conn, $sql);
                }

                if ($event_time != $present_event_time) {
                        $sql = "UPDATE ongoing_list_of_event SET event_time = '$event_time' WHERE event_id = '$event_id';";
                        mysqli_query($conn,$sql);
                        $affectedRows += mysqli_affected_rows($conn);
                        to_log($conn, $sql);
                }
        
                $sql = "DELETE FROM ongoing_event_name
                        WHERE ongoing_event_name_id NOT IN (
                        SELECT ongoing_event_name_id
                        FROM ongoing_list_of_event
                        );";
                mysqli_query($conn,$sql);
         
                if ($affectedRows > 0) {
                        $popUpID = "sucessEdit";
                        $showPopUpButtonID = "";
                        $icon = "<i class='bx bxs-check-circle success-color'></i>";
                        $title = "Saved Successfully";
                        $message = "Changes are successfully saved.";
                
                        ob_start();
                        include './php/popup-2-btn.php';
                        $popupContentSuccess = ob_get_clean();
                        $_SESSION['popupContentSuccess'] = $popupContentSuccess;

                        header("Location: EVE-admin-list-of-events.php");
                }
                else {
                        $popUpID = "noChanges";
                        $showPopUpButtonID = "";
                        $icon = "<i class='bx bxs-error-circle warning-color'></i>";
                        $title = "No Changes";
                        $message = "There we're no changes happened.";
                
                        ob_start();
                        include './php/popup-2-btn.php';
                        $popupContentNotSuccess = ob_get_clean();
                }
     }

     $popupContent = '';
     
     if (isset($_POST['selectedEvents'])) {
        $previousURL = $_SERVER['HTTP_REFERER'];
        $all_id = $_POST['selectedEvents'] ?? NULL;
        
        if ($all_id != NULL){
                $extract_id = implode(',', $all_id);

                $sql = "INSERT IGNORE INTO category_name (category_name_id, event_name_id, event_type_id, category_name)
                        SELECT category_name_id, event_name_id, event_type_id, category_name
                        FROM ongoing_list_of_event
                        WHERE event_id IN($extract_id) AND event_type_id != '3';";
                mysqli_query($conn,$sql);

                $sql = "INSERT IGNORE INTO criterion (criterion_id, category_name_id, criterion_name, criterion_percent)
                        SELECT criterion_id, category_name_id, criterion_name, criterion_percent
                        FROM ongoing_criterion
                        WHERE event_id IN($extract_id);";
                mysqli_query($conn,$sql);

                $sql = "UPDATE ongoing_list_of_event SET overall_include = '0', is_deleted = '1' WHERE event_id IN($extract_id);";
                $deleteQuery = mysqli_query($conn, $sql);

                echo "<script>var previousURL = '$previousURL';</script>";
        }
        else {
                $popUpID = "deleteEvent";
                $showPopUpButtonID = "";
                $icon = "<i class='bx bxs-calendar-exclamation warning-color'></i>";
                $title = "Oops! Something went wrong!";
                $message = "";
                $your_link = "EVE-admin-list-of-events.php";
      
                // Make sure to include your php query to the your page
      
                ob_start();
                include './php/popup-1-btn.php';
                $popupContent = ob_get_clean();
        }

     }

    if(isset($_GET['mad'])){
        $previousURL = $_SERVER['HTTP_REFERER'];
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
                        WHERE event_id = $id AND event_type_id != '3';";
                mysqli_query($conn,$sql); 

                $sql = "INSERT IGNORE INTO criterion (criterion_id, category_name_id, criterion_name, criterion_percent)
                        SELECT criterion_id, category_name_id, criterion_name, criterion_percent
                        FROM ongoing_criterion
                        WHERE event_id = '$id';";
                mysqli_query($conn,$sql); 

                $sql = "SELECT * FROM ongoing_list_of_event WHERE ongoing_event_name_id = '$ongoing_event_name_id' AND is_deleted = '0';";
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

            header("Location: $previousURL");
        }
    }
?>