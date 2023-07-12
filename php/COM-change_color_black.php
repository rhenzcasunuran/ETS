<?php
if (isset($_POST['competitionName'])) {
    $competitionName = $_POST['competitionName'];


    require 'database_connect.php';


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
    $query = "SELECT category_name_id FROM competition WHERE category_name_id = '$categoryid'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // The competition_name exists in the competitions_table
        $row = $result->fetch_assoc();
        $competitionID = $row["category_name_id"];

        // Check if there are any rows in criterion_scoring with scores
        $query = "SELECT * FROM criterion_scoring WHERE category_name_id = '$competitionID'";
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
