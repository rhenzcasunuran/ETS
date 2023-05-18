<?php
    $dbname=mysqli_connect("localhost","root","","pupets");

    $post_query = "SELECT * FROM post ORDER BY post_id DESC";
    $get_posts = mysqli_query($dbname, $post_query);
?>