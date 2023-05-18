<?php
    $dbname=mysqli_connect("localhost","root","","pupets");

    if(isset($_GET['eec'])){
        $id = $_GET['eec'];
        $get_post = mysqli_query($dbname,"SELECT * FROM post WHERE post_id = '$id';");
        $post_row = mysqli_fetch_array($get_post); 
    }
?>