<?php
include 'database_connect.php';

if (!$conn) {
    die("Connection Failed:" . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['time']) && isset($_POST['date'])) {
        $time = sanitizeInput($_POST['time']);
        $date = sanitizeInput($_POST['date']);

        if (isValidTime($time) && isValidDate($date)) {
            // Time and date inputs are valid, proceed with further actions

            // Sanitize and use the validated time and date values as needed
            $sanitizedTime = sanitizeInput($time);
            $sanitizedDate = sanitizeInput($date);
            
        } else {
            // Invalid time or date format
            header("Location: ./CAL-admin-overall.php");
        }
    } else {
        // Time or date inputs are missing
        header("Location: ./CAL-admin-overall.php");
    }
}

// Function to validate the time format
function isValidTime($time) {
    // Check if the time is in the format HH:MM and falls within the range of 00:00 to 24:00
    if (preg_match('/^([01][0-9]|2[0-3]):[0-5][0-9]$/', $time)) {
        return true;
    }
    return false;
}

// Function to validate the date format
function isValidDate($date) {
    // Check if the date is in the format YYYY-MM-DD
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        return true;
    }
    return false;
}

// Function to sanitize user input
function sanitizeInput($input) {
    // Implement your sanitization logic here, such as using filter_var or escaping special characters
    $sanitizedInput = trim($input);
    $sanitizedInput = htmlspecialchars($sanitizedInput, ENT_QUOTES, 'UTF-8');
    return $sanitizedInput;
}

// Close the connection
mysqli_close($conn);
?>


