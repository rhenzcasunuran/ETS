<?php

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

include 'database_connect.php';

// Log the activity in the logs table 
// Be sure to do include 'CAL-logger.php' on top of every .php file that has INSERT INTO, DELETE, or UPDATE in sql query
// Syntax is to_log($conn, $sql);
if (!function_exists('to_log')) {
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
        
        $admin_id = $_SESSION['admin_id'];
        $log_sql = "INSERT INTO logs (log_date, log_time, admin_id, activity_description) VALUES (CURDATE(), CURTIME(), ?, ?)";
        $log_stmt = mysqli_prepare($conn, $log_sql);
        
        // Determine the action based on the SQL query
        if (stripos($sql, 'INSERT') !== false) {
            $action = 'Added';
            $table = getTableNameFromInsertQuery($sql); // Function to extract table name from the INSERT query
            $recordId = getRecordIdFromInsertQuery($sql); // Function to extract the inserted record ID
            $formattedDesc = $action . ' ' . $recordId . ' in ' . $table . ' (' . $module_name . ')';
            mysqli_stmt_bind_param($log_stmt, "ss", $admin_id, $formattedDesc);
        } elseif (stripos($sql, 'UPDATE') !== false) {
            $action = 'Updated';
            $table = getTableNameFromUpdateQuery($sql); // Function to extract table name from the UPDATE query
            $recordId = getRecordIdFromUpdateQuery($sql); // Function to extract the updated record ID
            $formattedDesc = $action . ' ' . $recordId . ' in ' . $table . ' (' . $module_name . ')';
            mysqli_stmt_bind_param($log_stmt, "ss", $admin_id, $formattedDesc);
        } elseif (stripos($sql, 'DELETE') !== false) {
            $action = 'Removed';
            $table = getTableNameFromDeleteQuery($sql); // Function to extract table name from the DELETE query
            $condition = getConditionFromDeleteQuery($sql); // Function to extract the condition from the DELETE query
            $formattedDesc = $action . ' ' . $table . ' where ' . $condition . ' (' . $module_name . ')';
            mysqli_stmt_bind_param($log_stmt, "ss", $admin_id, $formattedDesc);
        }
        
        mysqli_stmt_execute($log_stmt);
    }        

    function getTableNameFromInsertQuery($sql) {
        preg_match('/INSERT INTO\s+([^\s]+)/i', $sql, $matches);
        if (isset($matches[1])) {
            return $matches[1];
        } else {
            return 'Unknown Table';
        }
    }

    function getRecordIdFromInsertQuery($sql) {
        preg_match('/\)\s+VALUES\s*\(\s*([^\)]+)/i', $sql, $matches);
        if (isset($matches[1])) {
            return $matches[1];
        } else {
            return 'Unknown Record ID';
        }
    }

    function getTableNameFromUpdateQuery($sql) {
        preg_match('/UPDATE\s+([^\s]+)/i', $sql, $matches);
        if (isset($matches[1])) {
            return $matches[1];
        } else {
            return 'Unknown Table';
        }
    }

    function getRecordIdFromUpdateQuery($sql) {
        // Assuming you have a primary key in the table, you can extract the updated record ID using the WHERE clause in the UPDATE query
        preg_match('/WHERE\s+(.*)/i', $sql, $matches);
        if (isset($matches[1])) {
            return $matches[1];
        } else {
            return 'Unknown Record ID';
        }
    }

    function getTableNameFromDeleteQuery($sql) {
        preg_match("/FROM\s+(\w+)/i", $sql, $matches);
        if (isset($matches[1])) {
            return $matches[1];
        } else {
            return 'Unknown Table';
        }
    }

    function getConditionFromDeleteQuery($sql) {
        preg_match("/WHERE\s+(.*)/i", $sql, $matches);
        if (isset($matches[1])) {
            return $matches[1];
        } else {
            return 'Unknown Condition';
        }
    }
}
?>