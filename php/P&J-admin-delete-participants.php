<?php
include 'database_connect.php';
include 'CAL-logger.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the array of participant IDs from the POST data
    $participantIds = $_POST['participant_ids'];

    // Sanitize the input (use prepared statements to prevent SQL injection)
    $participantIds = array_map('intval', $participantIds); // Convert to integers

    // Create a comma-separated list of IDs for the SQL query
    $idListP = implode(',', $participantIds);

    // SQL query to delete the selected participants from the database
    $sqlP = "DELETE FROM participants WHERE participants_id IN ($idListP)";

    if ($conn->query($sqlP) === true) {
        echo "Participants deleted successfully";
    }

    // Close the database connection
    $conn->close();
}
?>