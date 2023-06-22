<?php
    include 'database_connect.php';

    $post_query = "SELECT * FROM post WHERE post_draft = 1 ORDER BY post_schedule DESC";
    $get_posts = mysqli_query($conn, $post_query);
?>