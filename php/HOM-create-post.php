<?php
    include 'database_connect.php';
    include 'CAL-logger.php';

    if(isset($_POST['post'])){
        $calendar =  mysqli_real_escape_string($conn,$_POST['post_calendar']);
        $tag =  mysqli_real_escape_string($conn,$_POST['post_tag']);
        $title =  mysqli_real_escape_string($conn,$_POST['post_title']);
        $description =  mysqli_real_escape_string($conn,$_POST['post_description']);
        $current_date = date("y-m-d h:i:s");

        $sql = "INSERT INTO post (post_calendar, post_tag, post_title, post_description, post_schedule) 
                VALUES ('$calendar', '$tag', '$title', '$description', '$current_date');";
        mysqli_query($conn,$sql);
        to_log($conn, $sql);

        header('Location: ../index.php');
    }
?>