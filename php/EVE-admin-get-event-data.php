<?php
    require 'database_connect.php';

    $event_query = "SELECT * FROM ongoing_list_of_event WHERE is_archived = '0' ORDER BY event_date ASC";
    $event_result = mysqli_query($conn, $event_query);
    $event_data = mysqli_query($conn, $event_query);
    $event_result2 = mysqli_query($conn, $event_query);
    $event_data2 = mysqli_query($conn, $event_query);

    $sql = "SELECT ole.event_id, ole.category_name_id AS ole_category_name_id, ole.event_description, ole.event_code, ole.event_date, ole.event_time,
    oen.event_name_id, oen.event_name,
    ocn.category_name_id, ocn.event_name_id AS ocn_event_name_id, ocn.event_type_id, ocn.category_name,
    et.event_type_id AS et_event_type_id, et.event_type
    FROM ongoing_event_name AS oen
    JOIN ongoing_category_name AS ocn ON oen.event_name_id = ocn.event_name_id
    JOIN event_type AS et ON ocn.event_type_id = et.event_type_id
    JOIN ongoing_list_of_event AS ole ON ocn.category_name_id = ole.category_name_id
    WHERE is_archived = '0'
    ORDER BY event_date ASC;";
    $query = mysqli_query($conn, $sql);
?>