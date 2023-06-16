<?php
include('database_connect.php');
include 'CAL-logger.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the selected activities from the AJAX request
    $selectedActivities = json_decode($_POST["activities"], true);

    // Update the suggested_status column in the database for each selected activity
    $updateQuery = "UPDATE eventhistorytb SET suggested_status = 0 WHERE suggested_status = 1";
    if (!mysqli_query($conn, $updateQuery)) {
        // Error in update
        echo "Error updating activity status: " . mysqli_error($conn);
        exit;
    }

    foreach ($selectedActivities as $activity) {
        // Get the event_history_id for the selected activity
        $query = "SELECT event_history_id FROM eventhistorytb WHERE category_name = '$activity'";
        $result = mysqli_query($conn, $query);
        if ($result === false) {
            // Error in query
            echo "Error fetching event history ID: " . mysqli_error($conn);
            exit;
        }

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $eventHistoryId = $row['event_history_id'];

            // Update the suggested_status for the specific event_history_id
            $updateQuery = "UPDATE eventhistorytb SET suggested_status = 1 WHERE event_history_id = $eventHistoryId";
            if (!mysqli_query($conn, $updateQuery)) {
                // Error in update
                echo "Error updating activity status: " . mysqli_error($conn);
                exit;
            }
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
