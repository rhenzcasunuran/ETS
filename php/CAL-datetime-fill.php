<?php
include 'database_connect.php';

if (!$conn) {
    die("Connection Failed:" . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ((isset($_POST['time']) || isset($_POST['time_mobile'])) && (isset($_POST['date']) || isset($_POST['date_mobile']))) {
        if (isset($_POST['time'])) {
            $time = sanitizeInput($_POST['time']);
        } else {
            $time = sanitizeInput($_POST['time_mobile']);
        }
    
        if (isset($_POST['date'])) {
            $date = sanitizeInput($_POST['date']);
        } else {
            $date = sanitizeInput($_POST['date_mobile']);
        }

        if (isValidTime($time) && isValidDate($date)) {
            // Time and date formats are valid, check if it's the current time or a future time
            date_default_timezone_set('Asia/Manila'); // Replace 'Your_Local_Timezone' with your desired timezone

            // Create DateTime objects for current date and time
            $currentDateTime = new DateTime('now');

            // Create DateTime object for the provided date and time
            $inputDateTime = DateTime::createFromFormat('Y-m-d H:i', $date . ' ' . $time);

            // Compare the DateTime objects
            if ($inputDateTime >= $currentDateTime) {
                // Time and date are either the current time or a future time
                // Proceed with further actions

                // Sanitize and use the validated time and date values as needed
                $sanitizedTime = sanitizeInput($time);
                $sanitizedDate = sanitizeInput($date);
            } else {
                // Time and date are in the past
                header("Location: ./CAL-admin-overall.php");
                exit(); // Terminate script execution
            }
        } else {
            // Invalid time or date format
            header("Location: ./CAL-admin-overall.php");
            exit(); // Terminate script execution
        }
    } else {
        // Time or date inputs are missing
        header("Location: ./CAL-admin-overall.php");
        exit(); // Terminate script execution
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
