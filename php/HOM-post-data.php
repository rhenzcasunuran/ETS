<?php
    include 'database_connect.php';
    include 'CAL-logger.php';

    if(isset($_GET['eec'])){
        $id = $_GET['eec'];
        $get_post = mysqli_query($conn,"SELECT * FROM post WHERE post_id = '$id';");
        $post_row = mysqli_fetch_array($get_post); 
    }
?>