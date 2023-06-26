<?php
    include 'CAL-logger.php';

    $calendar =  mysqli_real_escape_string($conn,$_POST['post_calendar']);
    $tags =  mysqli_real_escape_string($conn,$_POST['organization_id']);
    $title =  mysqli_real_escape_string($conn,$_POST['post_title']);
    $description =  mysqli_real_escape_string($conn,$_POST['post_description']);
    date_default_timezone_set('Asia/Manila');
    $current_date = date("y-m-d h:i:s");

    if(isset($_POST['post'])){
        $sql = "INSERT INTO post (post_calendar, organization_id, post_title, post_description, post_schedule) 
                VALUES ('$calendar', '$tags', '$title', '$description', '$current_date');";
        mysqli_query($conn,$sql);
        to_log($conn, $sql);
        header('Location: ../index.php');
    }
    
    if(isset($_POST['save'])){
        $sql = "INSERT INTO post (post_calendar, organization_id, post_title, post_description, post_schedule, post_draft) 
                VALUES ('$calendar', '$tags', '$title', '$description', '$current_date', '1');";
        mysqli_query($conn,$sql);
        to_log($conn, $sql);
        header('Location: ../HOM-draft-post.php');
    }
?>