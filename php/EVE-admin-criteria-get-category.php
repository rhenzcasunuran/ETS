<?php
    require 'database_connect.php'; 

    $sql = "SELECT * FROM `category_name` WHERE event_type_id = '2'";
    $categoryName = mysqli_query($conn, $sql);
?>