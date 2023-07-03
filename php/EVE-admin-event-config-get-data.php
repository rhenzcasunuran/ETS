<?php
    require 'database_connect.php';

    $eventName_query = "SELECT * FROM `event_name`";
    $eventName = mysqli_query($conn, $eventName_query);
    $eventName2 = mysqli_query($conn, $eventName_query);
    $selectEventName = mysqli_query($conn, $eventName_query);

    $eventType_query = "SELECT * FROM `event_type`";
    $eventType = mysqli_query($conn, $eventType_query);

    $categoryName_query = "SELECT * FROM `category_name`";
    $categoryName = mysqli_query($conn, $categoryName_query);
    $categoryName2 = mysqli_query($conn, $categoryName_query);

    $sql = "SELECT * FROM number_of_wins;";
    $NoW = mysqli_query($conn, $sql);
?>