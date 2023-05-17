<?php
    $dbname=mysqli_connect("localhost","root","","pupets");

    $eventName_query = "SELECT * FROM `eventnametb`";
    $eventName = mysqli_query($dbname, $eventName_query);
    $eventName2 = mysqli_query($dbname, $eventName_query);
    $selectEventName = mysqli_query($dbname, $eventName_query);

    $eventType_query = "SELECT * FROM `eventtypetb`";
    $eventType = mysqli_query($dbname, $eventType_query);

    $categoryName_query = "SELECT * FROM `categorynametb`";
    $categoryName = mysqli_query($dbname, $categoryName_query);
    $categoryName2 = mysqli_query($dbname, $categoryName_query);
?>