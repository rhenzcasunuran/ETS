<?php
if (isset($_POST['competitionName'])) {
    $competitionName = $_POST['competitionName'];

    

    require 'database_connect.php';


    // Escape the competitionName to prevent SQL injection
    $competitionName = $conn->real_escape_string($competitionName);

    // Search for the competition_id with the given competition_name
    $query = "SELECT competition_id FROM competitions_table WHERE competition_name = '$competitionName'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // The competition_name exists in the competitions_table
        $row = $result->fetch_assoc();
        $competitionID = $row["competition_id"];

        // Check if there are any rows in scores_table with the competition_id
        $query = "SELECT * FROM scores_table WHERE competition_id = '$competitionID'";
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
