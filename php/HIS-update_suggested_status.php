<?php
include('database_connect.php');
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the selected activity value from the AJAX request
    $selectedActivity = $_POST["activity"];

    // Update the suggested_status column in the database
    $updateQuery = "UPDATE eventhistorytb SET suggested_status = 1 WHERE category_name = '$selectedActivity'";

    if (mysqli_query($conn, $updateQuery)) {
        // Successful update
        echo "Activity status updated to suggested.";
    } else {
        // Error in update
        echo "Error updating activity status: " . mysqli_error($conn);
    }
} else {
    // Invalid request method
    echo "Invalid request.";
}
?>
