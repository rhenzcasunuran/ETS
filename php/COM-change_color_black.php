<?php
if (isset($_POST['competitionName'])) {
    $competitionName = $_POST['competitionName'];

    require 'database_connect.php';

    // Escape the competitionName to prevent SQL injection
    $competitionName = $conn->real_escape_string($competitionName);

    // Get the category ID
    $eventidQuery = $conn->prepare("SELECT category_name_id FROM ongoing_list_of_event WHERE category_name = ?");
    $eventidQuery->bind_param("s", $competitionName);
    $eventidQuery->execute();
    $eventidResult = $eventidQuery->get_result();

    if ($eventidResult->num_rows > 0) {
        $eventidRow = $eventidResult->fetch_assoc();
        $eventid = $eventidRow["category_name_id"];

        // Check if there are any rows in criterion_scoring with scores
        $query = "SELECT * FROM criterion_scoring cs
                  RIGHT JOIN participants p ON cs.participants_id = p.participants_id
                  INNER JOIN ongoing_criterion oc ON cs.ongoing_criterion_id = oc.ongoing_criterion_id
                  WHERE oc.category_name_id = ? AND cs.criterion_final_score IS NOT NULL";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $eventid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // There are rows with the category_name_id in criterion_scoring table and participants, do nothing
            echo "notempty";
        } else {
            // There are no rows with the category_name_id in criterion_scoring table or no participants with scores
            echo "grey";
        }
    } else {
        // The competition_name does not exist in the ongoing_list_of_event table
        echo "black";
    }

    $conn->close();
}
?>
