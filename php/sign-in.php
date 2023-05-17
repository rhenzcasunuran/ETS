<?php
    session_start();
    
    if(!isset($_SESSION['user_username'])) {
        header("Location: index.php");
        exit();
    }
?>