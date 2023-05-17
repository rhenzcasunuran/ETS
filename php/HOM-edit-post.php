<?php
    include 'HOM-post-data.php';

    $dbname=mysqli_connect("localhost","root","","pupets");

    if(isset($_POST['post'])){
        $calendar =  mysqli_real_escape_string($dbname,$_POST['post_calendar']);
        $tag =  mysqli_real_escape_string($dbname,$_POST['post_tag']);
        $title =  mysqli_real_escape_string($dbname,$_POST['post_title']);
        $description =  mysqli_real_escape_string($dbname,$_POST['post_description']);
        $cover =  mysqli_real_escape_string($dbname,$_POST['post_cover']);
        $photos =  mysqli_real_escape_string($dbname,$_POST['post_photos']);
        $current_date = date("y-m-d h:i:s");

        $sql = "UPDATE post 
                SET post_calendar = '$calendar', post_tag = '$tag', post_title = '$title', post_description = '$description', post_cover = '$cover', post_photos = '$photos'
                WHERE post_id = $id";
        mysqli_query($dbname,$sql);

        $_SESSION['message']="Successfully added to the database."; 
    }
?>