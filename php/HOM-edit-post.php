<?php
    include 'HOM-post-data.php';

    $dbname=mysqli_connect("localhost","root","","pupets");

    if(isset($_POST['post'])){
        $calendar =  mysqli_real_escape_string($dbname,$_POST['post_calendar']);
        $tag =  mysqli_real_escape_string($dbname,$_POST['post_tag']);
        $title =  mysqli_real_escape_string($dbname,$_POST['post_title']);
        $description =  mysqli_real_escape_string($dbname,$_POST['post_description']);
        $current_date = date("y-m-d h:i:s");

        $sql = "UPDATE post 
                SET post_calendar = '$calendar', post_tag = '$tag', post_title = '$title', post_description = '$description'
                WHERE post_id = $id";
        mysqli_query($dbname,$sql);

        $_SESSION['message']="Successfully added to the database."; 
    }
?>