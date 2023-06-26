<?php
    include 'CAL-logger.php';

    if(isset($_GET['eed'])){
        $id = $_GET['eed'];
        $get_post = mysqli_query($conn,"DELETE FROM post WHERE post_id = '$id';");
        to_log($conn, "DELETE FROM post WHERE post_id = '$id';");
        header('Location: HOM-manage-post.php');
    }
?>