<?php
    include 'CAL-logger.php';

    $calendar =  mysqli_real_escape_string($conn,$_POST['post_calendar']);
    $tags =  mysqli_real_escape_string($conn,$_POST['organization_id']);
    $title =  mysqli_real_escape_string($conn,$_POST['post_title']);
    $description =  mysqli_real_escape_string($conn,$_POST['post_description']);
    $schedule =  mysqli_real_escape_string($conn,$_POST['post_schedule']);
    
    if(isset($_POST['save'])){
        date_default_timezone_set('Asia/Manila');
        $current_date = date("Y-m-d H:i:s");
        $sql = "INSERT INTO post (post_calendar, organization_id, post_title, post_description, post_schedule, post_draft) 
                VALUES ('$calendar', '$tags', '$title', '$description', '$current_date', '1');";
        mysqli_query($conn,$sql);
        to_log($conn, $sql);
        header('Location: ../HOM-drafts.php');
    }

    if(isset($_POST['post_now'])){
        date_default_timezone_set('Asia/Manila');
        $current_date = date("Y-m-d H:i:s");

        $sql = "INSERT INTO post (post_calendar, organization_id, post_title, post_description, post_schedule) 
        VALUES ('$calendar', '$tags', '$title', '$description', '$current_date');";
        mysqli_query($conn,$sql);

        $last_post_id = mysqli_insert_id($conn);

        if(isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK){
            $cover = $_FILES['cover'];

            $cover_name = $cover['name'];
            $cover_tmp_name = $cover['tmp_name'];
            $cover_size = $cover['size'];
            $cover_error = $cover['error'];
            $cover_type = $cover['type'];

            $cover_ext = explode('.', $cover_name);
            $cover_actual_ext = strtolower(end($cover_ext));
            $format = array('jpeg', 'jpg', 'png');

            if(in_array($cover_actual_ext, $format)){
                if($cover_error === 0){
                    if($cover_size <= 10  * 1024 * 1024){
                        $cover_rename = $last_post_id."_COVER_".uniqid('', false).".".$cover_actual_ext;
                        $cover_path = 'post/'.$cover_rename;
                        move_uploaded_file($cover_tmp_name, $cover_path);

                        $sql_cover = "UPDATE post
                        SET post_cover = '$cover_rename'
                        WHERE post_id = $last_post_id";
                        mysqli_query($conn,$sql_cover);
                    }
                    else{
                        echo "Invalid file size!";
                    }
                }
                else{
                    echo "Error uploading!";
                }
            }
            else{
                echo "Invalid file type!";
            }
        }
        else
        {
            $sql_tag = "SELECT organization_name 
            FROM post 
            INNER JOIN organization ON post.organization_id = organization.organization_id 
            WHERE post_id = $last_post_id";
            $get_tag = mysqli_query($conn, $sql_tag);
        
            $row_tag = mysqli_fetch_assoc($get_tag);
            $organization_name = $row_tag['organization_name'];
            $cover_default = "cover-".$organization_name.".png";
        
            $sql_cover = "UPDATE post
            SET post_cover = '$cover_default'
            WHERE post_id = $last_post_id";
            mysqli_query($conn, $sql_cover);
        }
        

        $photo = $_FILES['photo'];

        for($i = 0; $i < count($photo['name']); $i++){
            $photo_name = $photo['name'][$i];
            $photo_tmp_name = $photo['tmp_name'][$i];
            $photo_size = $photo['size'][$i];
            $photo_error = $photo['error'][$i];
            $photo_type = $photo['type'][$i];
        
            $photo_ext = explode('.', $photo_name);
            $photo_actual_ext = strtolower(end($photo_ext));
            $format = array('jpeg', 'jpg', 'png', 'gif');
        
            if(in_array($photo_actual_ext, $format)){
                if($photo_error === 0) {
                    if($photo_size <= 10 * 1024 * 1024){
                        $photo_rename = $last_post_id."_PHOTO_".uniqid('', false).".".$photo_actual_ext;
                        $photo_path = 'post/' . $photo_rename;
                        move_uploaded_file($photo_tmp_name, $photo_path);

                        $sql_photo = "INSERT INTO post_photo (post_id, file_name)
                        VALUES ('$last_post_id', '$photo_rename');";
                        mysqli_query($conn,$sql_photo);
                    }
                    else{
                        echo "Invalid file size!";
                    }
                }
                else{
                    echo "Error uploading file!";
                }
            }
            else{
                echo "Invalid file type for file!";
            }
        }
        to_log($conn, $sql);
        header('Location: ../HOM-posts.php');
    }

    if(isset($_POST['post_later'])){
        $sql = "INSERT INTO post (post_calendar, organization_id, post_title, post_description, post_schedule) 
                VALUES ('$calendar', '$tags', '$title', '$description', '$schedule');";
        mysqli_query($conn,$sql);

        $last_post_id = mysqli_insert_id($conn);

        if(isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK){
            $cover = $_FILES['cover'];

            $cover_name = $cover['name'];
            $cover_tmp_name = $cover['tmp_name'];
            $cover_size = $cover['size'];
            $cover_error = $cover['error'];
            $cover_type = $cover['type'];

            $cover_ext = explode('.', $cover_name);
            $cover_actual_ext = strtolower(end($cover_ext));
            $format = array('jpeg', 'jpg', 'png');

            if(in_array($cover_actual_ext, $format)){
                if($cover_error === 0){
                    if($cover_size <= 10  * 1024 * 1024){
                        $cover_rename = $last_post_id."_COVER_".uniqid('', false).".".$cover_actual_ext;
                        $cover_path = 'post/'.$cover_rename;
                        move_uploaded_file($cover_tmp_name, $cover_path);

                        $sql_cover = "UPDATE post
                        SET post_cover = '$cover_rename'
                        WHERE post_id = $last_post_id";
                        mysqli_query($conn,$sql_cover);
                    }
                    else{
                        echo "Invalid file size!";
                    }
                }
                else{
                    echo "Error uploading!";
                }
            }
            else{
                echo "Invalid file type!";
            }
        }
        else
        {
            $sql_tag = "SELECT organization_name 
            FROM post 
            INNER JOIN organization ON post.organization_id = organization.organization_id 
            WHERE post_id = $last_post_id";
            $get_tag = mysqli_query($conn, $sql_tag);
        
            $row_tag = mysqli_fetch_assoc($get_tag);
            $organization_name = $row_tag['organization_name'];
            $cover_default = "cover-".$organization_name.".png";
        
            $sql_cover = "UPDATE post
            SET post_cover = '$cover_default'
            WHERE post_id = $last_post_id";
            mysqli_query($conn, $sql_cover);
        }
        

        $photo = $_FILES['photo'];

        for($i = 0; $i < count($photo['name']); $i++){
            $photo_name = $photo['name'][$i];
            $photo_tmp_name = $photo['tmp_name'][$i];
            $photo_size = $photo['size'][$i];
            $photo_error = $photo['error'][$i];
            $photo_type = $photo['type'][$i];
        
            $photo_ext = explode('.', $photo_name);
            $photo_actual_ext = strtolower(end($photo_ext));
            $format = array('jpeg', 'jpg', 'png', 'gif');
        
            if(in_array($photo_actual_ext, $format)){
                if($photo_error === 0) {
                    if($photo_size <= 10 * 1024 * 1024){
                        $photo_rename = $last_post_id."_PHOTO_".uniqid('', false).".".$photo_actual_ext;
                        $photo_path = 'post/' . $photo_rename;
                        move_uploaded_file($photo_tmp_name, $photo_path);

                        $sql_photo = "INSERT INTO post_photo (post_id, file_name)
                        VALUES ('$last_post_id', '$photo_rename');";
                        mysqli_query($conn,$sql_photo);
                    }
                    else{
                        echo "Invalid file size!";
                    }
                }
                else{
                    echo "Error uploading file!";
                }
            }
            else{
                echo "Invalid file type for file!";
            }
        }
        to_log($conn, $sql);
        header('Location: ../HOM-posts.php');
    }
?>