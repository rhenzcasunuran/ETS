<?php
include 'database_connect.php';

// Get the values sent from the JavaScript code
$flexRadioDefaultValue = $_POST['flexRadioDefault']; // Contains "Date & Time"
$flexRadioDefault2Value = $_POST['flexRadioDefault2']; // Contains "Ascending" or "Descending"
$searchInputValue = $_POST['searchInputValue'];

// Assuming you have already established a database connection
$query = "SELECT
            bf.id,
            oen.event_name,
            olfe.category_name,
            CONCAT(DATE_FORMAT(olfe.event_date, '%M %e, %Y'), ' ', DATE_FORMAT(olfe.event_time, '%h:%i %p')) AS event_datetime
          FROM
            `tournament` AS tou
          INNER JOIN bracket_forms AS bf ON tou.bracket_form_id = bf.id
          INNER JOIN ongoing_list_of_event AS olfe ON olfe.event_id = tou.event_id
          INNER JOIN ongoing_event_name AS oen ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
          WHERE
            bf.is_active = 1
            AND tou.has_set_tournament = 1
            AND tou.bracket_form_id IS NOT NULL
            AND olfe.is_archived = 0
            AND oen.is_done = 0
            AND olfe.is_deleted = 0";

if (!empty($searchInputValue)){
    $query .= " AND (oen.event_name LIKE '%$searchInputValue%' OR olfe.category_name LIKE '%$searchInputValue%')";
}

// Append the ORDER BY clause based on the values
if ($flexRadioDefaultValue == "Date & Time" && $flexRadioDefault2Value == "Ascending") {
    $query .= ' ORDER BY event_date ASC, event_time ASC';
} else if ($flexRadioDefaultValue == "Date & Time" && $flexRadioDefault2Value == "Descending") {
    $query .= ' ORDER BY event_date DESC, event_time DESC';
} else if ($flexRadioDefaultValue == "Event Name" && $flexRadioDefault2Value == "Ascending") {
    $query .= ' ORDER BY oen.event_name ASC';
} else if ($flexRadioDefaultValue == "Event Name" && $flexRadioDefault2Value == "Descending") {
    $query .= ' ORDER BY oen.event_name DESC';
} else if ($flexRadioDefaultValue == "Category Name" && $flexRadioDefault2Value == "Ascending") {
    $query .= ' ORDER BY olfe.category_name ASC';
} else if ($flexRadioDefaultValue == "Category Name" && $flexRadioDefault2Value == "Descending") {
    $query .= ' ORDER BY olfe.category_name DESC';
}

$result = mysqli_query($conn, $query);

$tournamentData = array();
while ($row = mysqli_fetch_assoc($result)) {
    // Create a new JSON object for the tournament
    $tournament = array(
        'id' => $row['id'],
        'event_name' => $row['event_name'],
        'category_name' => $row['category_name'],
        'event_datetime' => $row['event_datetime'],
    );

    // Add the tournament object to the $tournamentData array
    $tournamentData[] = $tournament;
}


// Output the response JSON containing the separate tournament data
header('Content-Type: application/json');
echo json_encode($tournamentData);
?>
