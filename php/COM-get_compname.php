<?php
// Get the competition name from the GET parameter
$competitionName = $_GET['competitionName'];

// Connect to the PHPMyAdmin database
require 'database_connect.php';

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

// Get the schedule using the category ID
$stmt = $conn->prepare("SELECT schedule, schedule_end FROM competition WHERE category_name_id = ?");
$stmt->bind_param("s", $categoryid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // There's a schedule for the competition, so return the schedule value
    $row = $result->fetch_assoc();

    $formattedStartDate = null;
    if ($row['schedule'] && strtotime($row['schedule']) !== false) {
        $formattedStartDate = date("F d, Y h:i A", strtotime($row['schedule']));
    }

    $formattedEndDate = null;
    if ($row['schedule_end'] && strtotime($row['schedule_end']) !== false) {
        $formattedEndDate = date("F d, Y h:i A", strtotime($row['schedule_end']));
    }

    if ($formattedStartDate && $formattedEndDate) {
        $formattedSchedule = $formattedStartDate . " - " . $formattedEndDate;
        $response["schedule"] = $formattedSchedule;
    } else {
        $response["schedule"] = null;
    }
} else {
    // There's no schedule for the competition, so return null
    $response['schedule'] = null;
}

// Return the response as JSON
echo json_encode($response);
?>
