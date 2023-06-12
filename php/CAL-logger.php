<?php

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

include 'database_connect.php';

// Log the activity in the logs table 
// Be sure to do include 'CAL-logger.php' on top of every .php file that has INSERT INTO, DELETE, or UPDATE in sql query
// Syntax is to_log($conn, $sql);
function to_log($conn, $sql) {
    $filename = basename($_SERVER['PHP_SELF'], '.php');
    $module_tag = substr($filename, 0, 3);

    if ($module_tag === 'BAR') {
        $module_name = 'Overall Results';
    } elseif ($module_tag === 'CAL') {
        $module_name = 'Calendar';
    } elseif ($module_tag === 'COM') {
        $module_name = 'Competition';
    } elseif ($module_tag === 'EVE') {
        $module_name = 'Events';
    } elseif ($module_tag === 'HIS') {
        $module_name = 'Event History';
    } elseif ($module_tag === 'HOM') {
        $module_name = 'Announcements';
    } elseif ($module_tag === 'P&J') {
        $module_name = 'Participants and Judges';
    } elseif ($module_tag === 'TOU') {
        $module_name = 'Tournaments';
    } else {
        $module_name = 'Undefined';
    }

    $admin = $_SESSION['user_username'];
    $log_sql = "INSERT INTO logs (log_date, log_time, admin, activity_description) VALUES (CURDATE(), CURTIME(), ?, ?)";
    $log_stmt = mysqli_prepare($conn, $log_sql);

    // Determine the action based on the SQL query
    if (stripos($sql, 'INSERT') !== false) {
        $action = 'Added';
        $formattedDesc = $action . ' in ' . $module_name;
        mysqli_stmt_bind_param($log_stmt, "ss", $admin, $formattedDesc);

    } elseif (stripos($sql, 'UPDATE') !== false) {
        $action = 'Edited';
        $formattedDesc = $action . ' in ' . $module_name;
        mysqli_stmt_bind_param($log_stmt, "ss", $admin, $formattedDesc);

    } elseif (stripos($sql, 'DELETE') !== false) {
        $action = 'Removed';
        $formattedDesc = $action . ' in ' . $module_name;
        mysqli_stmt_bind_param($log_stmt, "ss", $admin, $formattedDesc);
    }

    mysqli_stmt_execute($log_stmt);
}
?>
