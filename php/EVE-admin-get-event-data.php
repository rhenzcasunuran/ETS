<?php
    require 'database_connect.php';

    $event_query = "SELECT * FROM ongoing_list_of_event WHERE is_archived = '0' ORDER BY event_date ASC";
    $event_result = mysqli_query($conn, $event_query);
    $event_data = mysqli_query($conn, $event_query);
    $event_result2 = mysqli_query($conn, $event_query);
    $event_data2 = mysqli_query($conn, $event_query);
?>