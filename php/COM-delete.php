<?php
if (isset($_POST['competitionName'])) {
    $competitionName = $_POST['competitionName'];

    // Connect to the MySQL database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pupets";


    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

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
