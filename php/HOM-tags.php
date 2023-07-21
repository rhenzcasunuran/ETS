<?php
    $organization_query = "SELECT * FROM organization";
    $get_tags = mysqli_query($conn, $organization_query);

    $options = '';

    while ($row = mysqli_fetch_assoc($get_tags)) {
        $organization_id = $row['organization_id'];
        $organization_name = $row['organization_name'];
        $options .= "<option value='$organization_id'>$organization_name</option>";
    }
?>