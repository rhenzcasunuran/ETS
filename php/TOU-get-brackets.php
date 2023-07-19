<?php
include 'database_connect.php';

// Get the selected event from the AJAX request
$selectedEvent = $_GET['eventValue'];
$selectedCategory = $_GET['categoryValue'];

// Initialize the arrays
$combined_data = array();

// Prepare the SQL statement
$sql = "SELECT 
ot.team_name AS team_one_name,
ot.current_overall_score AS team_one_overall_score,
ot2.team_name AS team_two_name,
ot2.current_overall_score AS team_two_overall_score
FROM
`bracket_teams` AS bt
INNER JOIN ongoing_teams AS ot ON bt.team_one_id = ot.id
INNER JOIN ongoing_teams AS ot2 ON bt.team_two_id = ot2.id
INNER JOIN bracket_forms AS bf ON bf.id = bt.bracket_form_id
WHERE
bf.event_name = ? AND bf.category_name = ?

UNION

SELECT
 team_name AS team_one_name,
current_overall_score AS team_one_overall_score,
NULL AS team_two_name,
NULL AS team_two_overall_score
FROM
`ongoing_teams` AS ot
INNER JOIN bracket_teams AS bt ON ot.bracket_form_id = bt.id
INNER JOIN bracket_forms AS bf ON bf.id = bt.bracket_form_id
WHERE
current_team_status = 'champion' AND bf.event_name = ? AND bf.category_name = ?;";

// Prepare the statement and bind the bracket_form_id parameter
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $selectedEvent, $selectedCategory, $selectedEvent, $selectedCategory);
// Execute the statement
$stmt->execute();
// Get the result set
$result = $stmt->get_result();

// Loop through the result set and organize the data
while ($row = $result->fetch_assoc()) {
    $combined_data[] = array(
        'team_one_name' => $row['team_one_name'],
        'team_one_overall_score' => $row['team_one_overall_score'],
        'team_two_name' => $row['team_two_name'],
        'team_two_overall_score' => $row['team_two_overall_score']
    );
}

// Reverse the combined_data array
$combined_data = array_reverse($combined_data);

// Loop through the result set and organize the data
$idCounter = 1;
$combined_json_data = array();

for ($i = 0; $i < count($combined_data); $i++) {
    $team_one = array(
        'id' => $idCounter,
        'pid' => $i,
        'team_name' => $combined_data[$i]['team_one_name'],
        'overall_score' => $combined_data[$i]['team_one_overall_score']
    );

    if ($team_one['team_name'] !== null && $team_one['overall_score'] !== null) {
        $combined_json_data[] = $team_one;
    }

    $team_two = array(
        'id' => $idCounter + 1,
        'pid' => $i,
        'team_name' => $combined_data[$i]['team_two_name'],
        'overall_score' => $combined_data[$i]['team_two_overall_score']
    );

    if ($team_two['team_name'] !== null && $team_two['overall_score'] !== null) {
        $combined_json_data[] = $team_two;
    }

    $idCounter += 2; // Increment idCounter by 2 for each iteration
}

// Encode the combined array to JSON format
$combined_json = json_encode($combined_json_data);

// Set the response header
header('Content-Type: application/json');

// Return the JSON response
echo $combined_json;

// Close the database connection
mysqli_close($conn);
?>
