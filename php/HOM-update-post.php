<?php
    include 'HOM-post-data.php';

    if(isset($_POST['save_post'])){
        $calendar =  mysqli_real_escape_string($conn,$_POST['post_calendar']);
        $tag =  mysqli_real_escape_string($conn,$_POST['organization_id']);
        $title =  mysqli_real_escape_string($conn,$_POST['post_title']);
        $description =  mysqli_real_escape_string($conn,$_POST['post_description']);

        $sql = "UPDATE post 
                SET post_calendar = '$calendar', organization_id = '$tag', post_title = '$title', post_description = '$description'
                WHERE post_id = $id";
        mysqli_query($conn,$sql);
        to_log($conn, $sql);
        header('Location: ./HOM-manage-post.php');
    }

    if(isset($_POST['save_draft'])){
        $calendar =  mysqli_real_escape_string($conn,$_POST['post_calendar']);
        $tag =  mysqli_real_escape_string($conn,$_POST['organization_id']);
        $title =  mysqli_real_escape_string($conn,$_POST['post_title']);
        $description =  mysqli_real_escape_string($conn,$_POST['post_description']);

        $sql = "UPDATE post 
                SET post_calendar = '$calendar', organization_id = '$tag', post_title = '$title', post_description = '$description'
                WHERE post_id = $id";
        mysqli_query($conn,$sql);
        to_log($conn, $sql);
        header('Location: ./HOM-draft-post.php');
    }

    if(isset($_POST['post_draft'])){
        $calendar =  mysqli_real_escape_string($conn,$_POST['post_calendar']);
        $tag =  mysqli_real_escape_string($conn,$_POST['organization_id']);
        $title =  mysqli_real_escape_string($conn,$_POST['post_title']);
        $description =  mysqli_real_escape_string($conn,$_POST['post_description']);
        date_default_timezone_set('Asia/Manila');
        $current_date = date("y-m-d h:i:s");

        $sql = "UPDATE post 
                SET post_calendar = '$calendar', organization_id = '$tag', post_title = '$title', post_description = '$description', post_schedule = '$current_date', post_draft = '0'
                WHERE post_id = $id";
        mysqli_query($conn,$sql);
        to_log($conn, $sql);
        header('Location: ./index.php');
    }
?>