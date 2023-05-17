<?php
    $dbname=mysqli_connect("localhost","root","","pupets");

    $event_query = "SELECT * FROM listofeventtb";
    $event_result = mysqli_query($dbname, $event_query);
    $event_data = mysqli_query($dbname, $event_query);
    $event_result2 = mysqli_query($dbname, $event_query);
    $event_data2 = mysqli_query($dbname, $event_query);
?>