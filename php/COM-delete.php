<?php
if (isset($_POST['competitionName'])) {
    $competitionName = $_POST['competitionName'];

    

    require 'database_connect.php';
    include 'CAL-logger.php';


    // Escape the competitionName to prevent SQL injection
    $competitionName = $conn->real_escape_string($competitionName);

    // Delete the row with the matching competition_name
    $deleteQuery = "DELETE FROM competitions_table WHERE competition_name = '$competitionName'";
    if ($conn->query($deleteQuery) === true) {
        echo "Row deleted successfully";
    } else {
        echo "Error deleting row: " . $conn->error;
    }

    $conn->close();
}
?>
