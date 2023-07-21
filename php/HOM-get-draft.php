<?php
    $post_query = "SELECT * FROM post INNER JOIN organization 
    ON post.organization_id = organization.organization_id 
    WHERE post.post_draft = 1 
    ORDER BY post.post_schedule DESC";
    $get_posts = mysqli_query($conn, $post_query);
?>

<?php
    date_default_timezone_set('Asia/Manila');
    $current_date = date("Y-m-d H:i:s");
    $post_query = "SELECT * FROM post INNER JOIN organization 
    ON post.organization_id = organization.organization_id 
    WHERE post.post_draft = 1
    ORDER BY post.post_id DESC";
    $event_result = mysqli_query($conn, $post_query);
    $event_data = mysqli_query($conn, $post_query);
    $event_result2 = mysqli_query($conn, $post_query);
    $event_data2 = mysqli_query($conn, $post_query);
?>