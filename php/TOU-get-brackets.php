<?php
include 'database_connect.php';

// Get the selected event from the AJAX request
$selectedEvent = $_GET['eventValue'];
$selectedCategory = $_GET['categoryValue'];

// Initialize the response array
$responseData = array();

// Prepare the SQL statement with placeholders
$query = "SELECT bf.node_id_start, bf.parent_id_start
          FROM `tournament` AS tou
          INNER JOIN ongoing_list_of_event AS olfe ON tou.event_id = olfe.event_id
          INNER JOIN ongoing_event_name AS oen ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
          INNER JOIN bracket_forms AS bf ON bf.id = tou.bracket_form_id
          WHERE has_set_tournament = 1
          AND olfe.is_archived = 0
          AND olfe.is_deleted = 0
          AND oen.is_done = 0
          AND olfe.category_name = ?
          AND oen.event_name = ?";

// Prepare the statement
$stmt = $conn->prepare($query);

// Check if the statement preparation was successful
if (!$stmt) {
    die('Error in preparing the statement: ' . $conn->error);
}

// Bind the values to the statement placeholders
$stmt->bind_param('ss', $selectedCategory, $selectedEvent);

// Execute the statement
$stmt->execute();

// Bind the results to variables
$stmt->bind_result($nodeIdStart, $parentIdStart);

// Fetch the results (assuming there's only one row returned)
$stmt->fetch();

// Close the statement
$stmt->close();

// Create an empty array to store the values for nodeIdStart and parentIdStart
$nodeValueArray = array();
$parentIdValueArray = array(); // Initialize the parentIdValueArray as an empty array

// Use a for loop to iterate from $nodeIdStart to 1
for ($i = $nodeIdStart; $i >= 1; $i--) {
    // Add the value to the array
    $nodeValueArray[] = $i;
}

// Check if parentIdStart has a valid value
if ($parentIdStart !== null) {
    // Use a separate for loop to generate the parentIdStart pattern
    for ($j = $parentIdStart - 1; $j > 0; $j--) {
        // Add the value to the array (pattern: 7, 7, 6, 6, ..., 0)
        $parentIdValueArray[] = $j;
        $parentIdValueArray[] = $j;
    }

    $parentIdValueArray[] = 0;
}

// Prepare the SQL statement
$sql = "SELECT
        ot.team_name AS team_one_name,
        ot.current_overall_score AS team_one_overall_score
        FROM `tournament` AS tou
        INNER JOIN ongoing_list_of_event AS olfe
        ON tou.event_id = olfe.event_id
        INNER JOIN ongoing_event_name AS oen
        ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
        INNER JOIN bracket_forms AS bf
        ON bf.id = tou.bracket_form_id
        INNER JOIN bracket_teams AS bt 
        ON bt.bracket_form_id = bf.id
        INNER JOIN ongoing_teams AS ot
        ON bt.team_one_id = ot.id
        WHERE tou.has_set_tournament = 1
        AND olfe.is_archived = 0
        AND olfe.is_deleted = 0
        AND oen.is_done = 0
        AND bf.category_name = ?
        AND bf.event_name = ?;";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind the parameters
$stmt->bind_param("ss", $selectedCategory, $selectedEvent);

// Execute the query
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

// Fetch the data into an array
$data1 = [];
while ($row = $result->fetch_assoc()) {
    $data1[] = $row;
}

// Close the statement
$stmt->close();

// Prepare the SQL statement
$sql = "SELECT
            ot.team_name AS team_two_name,
            ot.current_overall_score AS team_two_overall_score
            FROM `tournament` AS tou
            INNER JOIN ongoing_list_of_event AS olfe ON tou.event_id = olfe.event_id
            INNER JOIN ongoing_event_name AS oen ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
            INNER JOIN bracket_forms AS bf ON bf.id = tou.bracket_form_id
            INNER JOIN bracket_teams AS bt ON bt.bracket_form_id = bf.id
            INNER JOIN ongoing_teams AS ot ON bt.team_two_id = ot.id
            WHERE tou.has_set_tournament = 1
            AND olfe.is_archived = 0
            AND olfe.is_deleted = 0
            AND oen.is_done = 0
            AND bf.category_name = ?
            AND bf.event_name = ?

            UNION

            SELECT
            ot.team_name,
            'CHAMPION' AS overall_score
            FROM `ongoing_teams` AS ot
            INNER JOIN bracket_forms AS bf ON ot.bracket_form_id = bf.id
            WHERE ot.current_team_status = 'champion'
            AND bf.category_name = ?
            AND bf.event_name = ?
            AND EXISTS (
                SELECT 1
                FROM `ongoing_teams` AS ot
                INNER JOIN bracket_forms AS bf ON ot.bracket_form_id = bf.id
                WHERE ot.current_team_status = 'champion'
                AND bf.category_name = ?
                AND bf.event_name = ?
            );";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind the parameters
$stmt->bind_param("ssssss", $selectedCategory, $selectedEvent, $selectedCategory, $selectedEvent, $selectedCategory, $selectedEvent);

// Execute the query
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

// Fetch the data into an array
$data2 = [];
while ($row = $result->fetch_assoc()) {
    $data2[] = $row;
}

// Close the statement
$stmt->close();

$combined_data = [];

// Get the lengths of both arrays
$count1 = count($data1);
$count2 = count($data2);

// Determine the maximum length of the combined array
$max_length = max($count1, $count2);

for ($i = 0; $i < $max_length; $i++) {
    // Combine the elements into an associative array
    $combined_element = [
        'team_name' => '',
        'overall_score' => '',
        'img' => '',
    ];

    // Alternate between data2 (team_two) and data1 (team_one)
    if ($i < $count2) {
        $combined_element['team_name'] = $data2[$i]['team_two_name'];
        $combined_element['overall_score'] = $data2[$i]['team_two_overall_score'];
        $combined_element['img'] = '/ETS/logos/' . $data2[$i]['team_two_name'] . '.png'; // Add .png here
        $combined_data[] = $combined_element;
    }

    if ($i < $count1) {
        $combined_element['team_name'] = $data1[$i]['team_one_name'];
        $combined_element['overall_score'] = $data1[$i]['team_one_overall_score'];
        $combined_element['img'] = '/ETS/logos/' . $data1[$i]['team_one_name'] . '.png'; // Add .png here
        $combined_data[] = $combined_element;
    }
}

// Loop through the arrays and combine the elements
for ($i = 0; $i < $nodeIdStart; $i++) {
    // Combine the elements into an associative array from $combined_data
    $combined_element = [
        'id' => isset($nodeValueArray[$i]) ? $nodeValueArray[$i] : null,
        'pid' => isset($parentIdValueArray[$i]) ? $parentIdValueArray[$i] : null,
        'team_name' => $combined_data[$i]['team_name'] ?? null,
        'overall_score' => $combined_data[$i]['overall_score'] ?? null,
        'img' => $combined_data[$i]['img'] ?? null
    ];

    // Add the combined element to the new array
    $responseData[] = $combined_element;
}

// Send the response back as JSON
header('Content-Type: application/json');
echo json_encode($responseData);
?>
