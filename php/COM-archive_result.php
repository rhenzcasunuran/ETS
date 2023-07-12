<?php
if (isset($_POST['competitionName'])) {
    $competitionName = $_POST['competitionName'];

    require 'database_connect.php';
    include 'CAL-logger.php';

    // Escape the competitionName to prevent SQL injection
    $competitionName = $conn->real_escape_string($competitionName);

    // Get the category ID
    $categoryidQuery = $conn->prepare("SELECT category_name_id FROM category_name WHERE category_name = ?");
    $categoryidQuery->bind_param("s", $competitionName);
    $categoryidQuery->execute();
    $categoryidResult = $categoryidQuery->get_result();

    if ($categoryidResult->num_rows > 0) {
        $categoryidRow = $categoryidResult->fetch_assoc();
        $categoryid = $categoryidRow["category_name_id"];
    } else {
        $categoryid = "Unknown";
    }

    // Search for the competition_id with the given competition_name
    $query = "SELECT is_archived FROM competition WHERE category_name_id = '$categoryid'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        // Update the value inside the archived column to "1"
        $updateQuery = "UPDATE competition SET is_archived = '1', schedule = NULL, schedule_end = NULL WHERE category_name_id = '$categoryid'";
        if ($conn->query($updateQuery) === true) {
            to_log($conn, $sql);
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
