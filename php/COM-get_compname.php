<?php
// Get the competition name from the GET parameter
$competitionName = $_GET['competitionName'];

// Connect to the PHPMyAdmin database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pupets";

$conn = new mysqli($servername, $username, $password, $dbname);

$stmt = $conn->prepare("SELECT schedule, schedule_end FROM competitions_table WHERE competition_name = ?");
$stmt->bind_param("s", $competitionName);
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
