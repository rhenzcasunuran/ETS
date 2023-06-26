<?php
include('database_connect.php');
include 'CAL-logger.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the selected activities from the AJAX request
    $selectedActivities = json_decode($_POST["activities"], true);

    // Update the suggested_status column for all activities to 0
    $updateQuery = "UPDATE ongoing_list_of_event SET suggested_status = 0";
    if (!mysqli_query($conn, $updateQuery)) {
        // Error in update
        echo "Error updating activity status: " . mysqli_error($conn);
        exit;
    }

    // Update the suggested_status for the selected activities to 1
    foreach ($selectedActivities as $activity) {
        $updateQuery = "UPDATE ongoing_list_of_event 
                        SET suggested_status = 1 
                        WHERE event_id IN (
                            SELECT e.event_id 
                            FROM ongoing_list_of_event e
                            JOIN ongoing_category_name c ON e.category_name_id = c.category_name_id
                            WHERE c.category_name = '$activity'
                        )";
        if (!mysqli_query($conn, $updateQuery)) {
            // Error in update
            echo "Error updating activity status: " . mysqli_error($conn);
            exit;
        }
    }

    // All updates successful
    echo "Activity status updated.";
    to_log($conn, $updateQuery);

} else {
    // Invalid request method
    echo "Invalid request.";
}

?>
