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

    // Delete the row with the matching competition_name
    $deleteQuery = "DELETE FROM competition WHERE category_name_id = '$categoryid'";
    if ($conn->query($deleteQuery) === true) {
        to_log($conn, $sql);
        echo "Row deleted successfully";
    } else {
        echo "Error deleting row: " . $conn->error;
    }

    $conn->close();
}
?>
