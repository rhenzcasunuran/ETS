<?php
    session_start();
    session_destroy();
    unset($_SESSION['user_username']);
    $_SESSION['message']="You are now logged out";
    header("location:../index.php");
?>