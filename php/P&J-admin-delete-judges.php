<?php
// Include your database connection code here
include 'database_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the array of judge IDs from the POST data
    $judgeIds = $_POST['judge_ids'];

    // Sanitize the input (use prepared statements to prevent SQL injection)
    $judgeIds = array_map('intval', $judgeIds); // Convert to integers

    // Create a comma-separated list of IDs for the SQL query
    $idList = implode(',', $judgeIds);

    // SQL query to delete the selected judges from the database
    $sql = "DELETE FROM judges WHERE judge_id IN ($idList)";

    if ($conn->query($sql) === true) {
        echo "Rows deleted successfully";
    }

    // Close the database connection
    $conn->close();
}
?>
