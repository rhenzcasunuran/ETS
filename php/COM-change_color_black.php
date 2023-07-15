<?php
if (isset($_POST['competitionName'])) {
    $competitionName = $_POST['competitionName'];


    require 'database_connect.php';


    // Escape the competitionName to prevent SQL injection
    $competitionName = $conn->real_escape_string($competitionName);

    // Get the category ID
    $eventidQuery = $conn->prepare("SELECT category_name FROM ongoing_list_of_event WHERE category_name = ?");
    $eventidQuery->bind_param("s", $competitionName);
    $eventidQuery->execute();
    $eventidResult = $eventidQuery->get_result();

    if ($eventidResult->num_rows > 0) {
        $eventidRow = $eventidResult->fetch_assoc();
        $eventid = $eventidRow["category_name"];
    } else {
        $eventid = "Unknown";
    }
    // Search for the competition_id with the given competition_name
    $query = "SELECT event_id FROM ongoing_list_of_event WHERE category_name = '$eventid'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // The competition_name exists in the competitions_table
        $row = $result->fetch_assoc();
        $competitionID = $row["event_id"];

        // Check if there are any rows in criterion_scoring with scores
        $query = "SELECT * FROM criterion_scoring WHERE event_id = '$competitionID'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // There are rows with the competition_id in scores_table, do nothing
            echo "notempty";
        } else {
            // There are no rows with the competition_id in scores_table
            echo "grey";
        }
    } else {
        // The competition_name does not exist in the competitions_table
        echo "black";
    }

    $conn->close();
}
?>
