<?php
    $dbname=mysqli_connect("localhost","root","","pupets");

    if(isset($_GET['eed'])){
        $id = $_GET['eed'];
        $get_post = mysqli_query($dbname,"DELETE FROM post WHERE post_id = '$id';");
        header('Location: HOM-manage-post.php');
    }
?>