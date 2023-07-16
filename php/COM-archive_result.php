<?php
if (isset($_POST['competitionName'])) {
    $competitionName = $_POST['competitionName'];

    require 'database_connect.php';
    include 'CAL-logger.php';

    // Escape the competitionName to prevent SQL injection
    $competitionName = $conn->real_escape_string($competitionName);

    // Get the category ID
    // Get the evrnt ID
    $eventidQuery = $conn->prepare("SELECT event_id FROM ongoing_list_of_event WHERE category_name = ?");
    $eventidQuery->bind_param("s", $competitionName);
    $eventidQuery->execute();
    $eventidResult = $eventidQuery->get_result();

    if ($eventidResult->num_rows > 0) {
        $eventidRow = $eventidResult->fetch_assoc();
        $eventid = $eventidRow["event_id"];
    } else {
        $eventid = "Unknown";
    }

    // Search for the competition_id with the given competition_name
    $query = "SELECT is_archived FROM competition WHERE event_id = '$eventid'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        // Update the value inside the archived column to "1"
        $updateQuery = "UPDATE competition SET is_archived = '1', schedule = NULL, schedule_end = NULL WHERE event_id = '$eventid'";
        if ($conn->query($updateQuery) === true) {
            to_log($conn, $updateQuery);
            echo "Update successful";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "No matching records found";
    }

    $conn->close();
}
?>
