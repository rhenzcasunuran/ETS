<?php
    include 'HOM-post-data.php';
    include 'database_connect.php';

    if(isset($_POST['post'])){
        $calendar =  mysqli_real_escape_string($conn,$_POST['post_calendar']);
        $tag =  mysqli_real_escape_string($conn,$_POST['post_tag']);
        $title =  mysqli_real_escape_string($conn,$_POST['post_title']);
        $description =  mysqli_real_escape_string($conn,$_POST['post_description']);
        $current_date = date("y-m-d h:i:s");

        $sql = "UPDATE post 
                SET post_calendar = '$calendar', post_tag = '$tag', post_title = '$title', post_description = '$description'
                WHERE post_id = $id";
        mysqli_query($conn,$sql);
        to_log($conn, $sql);

        $_SESSION['message']="Successfully added to the database."; 
    }
?>