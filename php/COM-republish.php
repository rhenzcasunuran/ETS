<?php
if (isset($_POST['competitionName'])) {
    $competitionName = $_POST['competitionName'];



    require 'database_connect.php';
    include 'CAL-logger.php';


    // Escape the competitionName to prevent SQL injection
    $competitionName = $conn->real_escape_string($competitionName);

    // Search for the competition_id with the given competition_name
    $query = "SELECT archived FROM competitions_table WHERE competition_name = '$competitionName'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        // Update the value inside the archived column to "0"
        $updateQuery = "UPDATE competitions_table SET archived = '0', schedule = NULL, schedule_end = NULL WHERE competition_name = '$competitionName'";
        if ($conn->query($updateQuery) === true) {
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
