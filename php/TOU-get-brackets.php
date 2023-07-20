<?php
include 'database_connect.php';

// Get the selected event from the AJAX request
$selectedEvent = $_GET['eventValue'];
$selectedCategory = $_GET['categoryValue'];

// Initialize the arrays
$combined_data = array();

// Prepare the SQL statement
$sql = "SELECT *
FROM (
    SELECT ot.id AS team_one_id, ot.team_name AS team_one_name,
           'CHAMPION' AS team_one_overall_score,
           NULL AS team_two_id,
           NULL AS team_two_name,
           NULL AS team_two_overall_score
    FROM `tournament` AS tou
    INNER JOIN ongoing_list_of_event AS olfe ON tou.event_id = olfe.event_id
    INNER JOIN ongoing_event_name AS oen ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
    INNER JOIN bracket_teams AS bt ON bt.bracket_form_id = bt.id
    INNER JOIN bracket_forms AS bf ON bf.id = bt.bracket_form_id
    INNER JOIN ongoing_teams AS ot ON ot.bracket_form_id = bf.id
    WHERE tou.has_set_tournament = 1
        AND olfe.is_archived = 0
        AND olfe.is_deleted = 0
        AND oen.is_done = 0
        AND bf.event_name = ?
        AND bf.category_name = ?
        AND ot.current_team_status = 'champion'
    
    UNION
    
    SELECT 
        NULL AS team_one_id,
        NULL AS team_one_name,
        NULL AS team_one_overall_score,
        NULL AS team_two_id,
        NULL AS team_two_name,
        NULL AS team_two_overall_score
    FROM DUAL
    WHERE NOT EXISTS (
        SELECT 1
        FROM `tournament` AS tou
        INNER JOIN ongoing_list_of_event AS olfe ON tou.event_id = olfe.event_id
        INNER JOIN ongoing_event_name AS oen ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
        INNER JOIN bracket_teams AS bt ON bt.bracket_form_id = bt.id
        INNER JOIN bracket_forms AS bf ON bf.id = bt.bracket_form_id
        INNER JOIN ongoing_teams AS ot ON ot.bracket_form_id = bf.id
        WHERE tou.has_set_tournament = 1
            AND olfe.is_archived = 0
            AND olfe.is_deleted = 0
            AND oen.is_done = 0
            AND bf.event_name = ?
            AND bf.category_name = ?
            AND ot.current_team_status = 'champion'
    )
    
    UNION ALL
    
    SELECT ot.id AS team_one_id, ot.team_name AS team_one_name,
           ot.current_overall_score AS team_one_overall_score,
           ot2.id AS team_two_id,
           ot2.team_name AS team_two_name,
           ot2.current_overall_score AS team_two_overall_score
    FROM `tournament` AS tou
    INNER JOIN ongoing_list_of_event AS olfe ON tou.event_id = olfe.event_id
    INNER JOIN ongoing_event_name AS oen ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
    INNER JOIN bracket_forms AS bf ON bf.id = tou.bracket_form_id
    INNER JOIN bracket_teams AS bt ON bt.bracket_form_id = bf.id
    INNER JOIN ongoing_teams AS ot ON bt.team_one_id = ot.id
    INNER JOIN ongoing_teams AS ot2 ON bt.team_two_id = ot2.id
    WHERE tou.has_set_tournament = 1
        AND olfe.is_archived = 0
        AND olfe.is_deleted = 0
        AND oen.is_done = 0
        AND bf.event_name = ?
        AND bf.category_name = ?
) AS combined_results
ORDER BY team_one_id DESC;";

// Prepare the statement and bind the bracket_form_id parameter
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $selectedEvent, $selectedCategory, $selectedEvent, $selectedCategory, $selectedEvent, $selectedCategory);
// Execute the statement
$stmt->execute();
// Get the result set
$result = $stmt->get_result();

// Initialize the array to hold the organized data
$data = array();

// Loop through the result set and organize the data
while ($row = $result->fetch_assoc()) {
     // Check if team_one_name is not NULL
     if ($row['team_one_name']) {
        $data[] = array(
            'team_name' => $row['team_one_name'],
            'overall_score' => $row['team_one_overall_score']
        );
    }  

    // Check if team_two_name is not NULL
    if ($row['team_two_name']) {
        $data[] = array(
            'team_name' => $row['team_two_name'],
            'overall_score' => $row['team_two_overall_score']
        );
    } 
}

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
$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "ss", $selectedCategory, $selectedEvent);

// Execute the query
mysqli_stmt_execute($stmt);

// Get the result set
$result = mysqli_stmt_get_result($stmt);

// Fetch the data and store it in an array
$node_ids = array();
$parent_ids = array();

while ($row = mysqli_fetch_assoc($result)) {
    $node_id_start = $row['node_id_start'];
    $parent_id_start = $row['parent_id_start'];
}

for ($i = $node_id_start; $i >= 1; $i--) {
    $node_ids[] = $i; // Store the current count in the array
}

for ($j = $parent_id_start - 1; $j >= 0; $j--) {
    $parent_ids[] = $j; // Store the current ID in the array
    if ($j > 0) {
        $parent_ids[] = $j; // Store the same ID again (repeated)
    }
}

// Reversing the arrays
$reversed_node_ids = array_reverse($node_ids);
$reversed_parent_ids = array_reverse($parent_ids);

// Combine the three arrays into one array with the specified format
$combined_array = array();
$count = count($data);
for ($i = 0; $i < $count; $i++) {
    $combined_array[] = array(
        'id' => $reversed_node_ids[$i],
        'pid' => $reversed_parent_ids[$i],
        'team_name' => $data[$i]['team_name'],
        'overall_score' => $data[$i]['overall_score']
    );
}

// Convert the combined array to JSON format
$json_response = json_encode($combined_array);

// Set the appropriate headers to indicate that the response contains JSON data
header('Content-Type: application/json');

// Output the JSON response
echo $json_response;

// Close the statement
mysqli_stmt_close($stmt);

// Close the database connection
mysqli_close($conn);
?>
