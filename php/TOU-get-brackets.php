<?php
include 'database_connect.php';

// Get the selected event from the AJAX request
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
          AND tou.tournament_id = ?";

// Prepare the statement
$stmt = $conn->prepare($query);

// Check if the statement preparation was successful
if (!$stmt) {
    die('Error in preparing the statement: ' . $conn->error);
}

// Bind the values to the statement placeholders
$stmt->bind_param('i', $selectedCategory);

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
        org.organization_name AS team_one_name,
        ot.current_overall_score AS team_one_overall_score
        FROM `tournament` AS tou
        LEFT JOIN ongoing_list_of_event AS olfe
        ON tou.event_id = olfe.event_id
        LEFT JOIN ongoing_event_name AS oen
        ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
        LEFT JOIN bracket_forms AS bf
        ON bf.id = tou.bracket_form_id
        LEFT JOIN bracket_teams AS bt 
        ON bt.bracket_form_id = bf.id
        LEFT JOIN ongoing_teams AS ot
        ON bt.team_one_id = ot.id
        LEFT JOIN organization AS org
        ON org.organization_id = ot.team_id
        WHERE tou.has_set_tournament = 1
        AND olfe.is_archived = 0
        AND olfe.is_deleted = 0
        AND oen.is_done = 0
        AND tou.tournament_id = ?;";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind the parameters
$stmt->bind_param("i", $selectedCategory);

// Execute the query
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

// Fetch the data into an array
$data1 = [];
while ($row = $result->fetch_assoc()) {
    // Check if team_one_name is NULL, replace it with "BYE"
    if ($row['team_one_name'] === null) {
        $row['team_one_name'] = 'BYE';
    }
    
    // Check if team_one_overall_score is NULL, replace it with "BYE"
    if ($row['team_one_overall_score'] === null) {
        $row['team_one_overall_score'] = 'BYE';
    }

    $data1[] = $row;
}

// Close the statement
$stmt->close();

// Prepare the SQL statement
$sql = "SELECT
            org.organization_name AS team_two_name,
            ot.current_overall_score AS team_two_overall_score
            FROM `tournament` AS tou
            LEFT JOIN ongoing_list_of_event AS olfe ON tou.event_id = olfe.event_id
            LEFT JOIN ongoing_event_name AS oen ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
            LEFT JOIN bracket_forms AS bf ON bf.id = tou.bracket_form_id
            LEFT JOIN bracket_teams AS bt ON bt.bracket_form_id = bf.id
            LEFT JOIN ongoing_teams AS ot ON bt.team_two_id = ot.id
            LEFT JOIN organization AS org ON org.organization_id = ot.team_id
            WHERE tou.has_set_tournament = 1
            AND olfe.is_archived = 0
            AND olfe.is_deleted = 0
            AND oen.is_done = 0
            AND tou.tournament_id = ?

            UNION

            SELECT
            org.organization_name,
            'CHAMPION' AS overall_score
            FROM `ongoing_teams` AS ot
            LEFT JOIN bracket_forms AS bf ON ot.bracket_form_id = bf.id
            LEFT JOIN organization AS org ON org.organization_id = ot.team_id
            LEFT JOIN tournament AS tou ON tou.bracket_form_id = bf.id
            WHERE ot.current_team_status = 'champion'
            AND tou.tournament_id = ?

            AND EXISTS (
                SELECT 1
                FROM `ongoing_teams` AS ot
                LEFT JOIN bracket_forms AS bf ON ot.bracket_form_id = bf.id
                LEFT JOIN tournament AS tou ON tou.bracket_form_id = bf.id
                WHERE ot.current_team_status = 'champion'
                AND tou.tournament_id = ?

            );";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind the parameters
$stmt->bind_param("iii", $selectedCategory, $selectedCategory, $selectedCategory);

// Execute the query
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

// Fetch the data into an array for $data2
$data2 = [];
while ($row = $result->fetch_assoc()) {
    // Check if team_two_name is NULL, replace it with "BYE"
    if ($row['team_two_name'] === null) {
        $row['team_two_name'] = 'BYE';
    }

    // Check if team_two_overall_score is NULL, replace it with "BYE"
    if ($row['team_two_overall_score'] === null) {
        $row['team_two_overall_score'] = 'BYE';
    }

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

$combined_data = array(); // Initialize the combined data array outside the loop

$baseUrl = '/ETS'; // Change this to your base URL if it's different
$imagePath = $baseUrl . '/logos/';

// Alternate between data2 (team_two) and data1 (team_one)
for ($i = 0; $i < max($count1, $count2); $i++) {
    if ($i < $count1) {
        $team_name = $data1[$i]['team_one_name'];
        $overall_score = $data1[$i]['team_one_overall_score'];

        $combined_element = array(
            'team_name' => $team_name,
            'overall_score' => $overall_score,
        );

        if ($team_name !== 'BYE') {
            $combined_element['img'] = $imagePath . $team_name . '.png';
        }

        $combined_data[] = $combined_element;
    }

    if ($i < $count2) {
        $team_name = $data2[$i]['team_two_name'];
        $overall_score = $data2[$i]['team_two_overall_score'];

        $combined_element = array(
            'team_name' => $team_name,
            'overall_score' => $overall_score,
        );

        if ($team_name !== 'BYE') {
            $combined_element['img'] = $imagePath . $team_name . '.png';
        }

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
