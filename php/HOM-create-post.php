<?php
    $dbname=mysqli_connect("localhost","root","","pupets");

    if(isset($_POST['post'])){
        $calendar =  mysqli_real_escape_string($dbname,$_POST['post_calendar']);
        $tag =  mysqli_real_escape_string($dbname,$_POST['post_tag']);
        $title =  mysqli_real_escape_string($dbname,$_POST['post_title']);
        $description =  mysqli_real_escape_string($dbname,$_POST['post_description']);
        $current_date = date("y-m-d h:i:s");

        $sql = "INSERT INTO post (post_calendar, post_tag, post_title, post_description, post_schedule) 
                VALUES ('$calendar', '$tag', '$title', '$description', '$current_date');";
        mysqli_query($dbname,$sql);

        $_SESSION['message']="Successfully added to the database."; 
    }
?>