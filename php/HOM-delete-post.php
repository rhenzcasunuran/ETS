<?php
    include 'CAL-logger.php';

    if(isset($_GET['eed'])){
        $id = $_GET['eed'];
        $get_post = mysqli_query($conn,"DELETE FROM post WHERE post_id = '$id';");
        to_log($conn, "DELETE FROM post WHERE post_id = '$id';");
        header('Location: HOM-manage-post.php');
    }

    if (isset($_POST['deb'])) {
        $all_id = $_POST['deleteEvent'] ?? NULL;
        
        if ($all_id != NULL){
                $extract_id = implode(',', $all_id);

                $sql = "DELETE FROM post WHERE post_id IN($extract_id);";
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
?>