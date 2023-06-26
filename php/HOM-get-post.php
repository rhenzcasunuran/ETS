<?php
    $post_query = "SELECT * FROM post INNER JOIN organization ON post.organization_id = organization.organization_id WHERE post.post_draft = 0 ORDER BY post.post_schedule DESC";
    $get_posts = mysqli_query($conn, $post_query);
?>