<?php
include 'database_connect.php';

if (!$conn) {
    die("Connection Failed:" . mysqli_connect_error());
}

// Retrieve data from events table based on date and filters
$year = isset($_GET['year']) ? $_GET['year'] : null;
$month = isset($_GET['month']) ? $_GET['month'] : null;
$filters = isset($_GET['filters']) ? $_GET['filters'] : null;
$filtersOrg = isset($_GET['filtersOrg']) ? $_GET['filtersOrg'] : null;
$selectedDate = isset($_GET['selectedDate']) ? $_GET['selectedDate'] : null;

// Validate and sanitize input
$year = filter_var($year, FILTER_VALIDATE_INT);
$month = filter_var($month, FILTER_VALIDATE_INT);

// Validate and sanitize filters array
$allowedEventTypes = array('Tournament', 'Competition', 'Standard');
$filteredFilters = array();

$allowedOrgTypes = array('SC', 'ACAP', 'AECES', 'ELITE', 'GIVE', 'JEHRA', 'JMAP', 'JPIA', 'PIIE');
$filteredOrgFilters = array();

foreach ($filters as $filter) {
    $filter = htmlspecialchars($filter);
    if (in_array($filter, $allowedEventTypes)) {
        $filteredFilters[] = $filter;
    }
}

foreach ($filtersOrg as $filter) {
    $filter = htmlspecialchars($filter);
    if (in_array($filter, $allowedOrgTypes)) {
        $filteredOrgFilters[] = $filter;
    }
}

// Check if filters array is empty after filtering
if (empty($filteredFilters) && empty($filteredOrgFilters)) {
    echo json_encode(array());
    exit;
}

// Build the parameter placeholders for the filters
$event_type_filters = implode(',', array_fill(0, count($filteredFilters), '?'));
$event_org_filters = implode(',', array_fill(0, count($filteredOrgFilters), '?'));

// Prepare the SQL statement
$sql = "SELECT
            CASE
                WHEN combined_table.event_id LIKE 'P%' THEN CONCAT('Post_', SUBSTRING(combined_table.event_id, 2))
                ELSE combined_table.event_id
            END AS event_id,
            combined_table.category_name_id,
            combined_table.event_description,
            combined_table.category_name,
            combined_table.event_date,
            combined_table.event_name,
            TIME_FORMAT(combined_table.event_time, '%h:%i %p') AS event_time,
            combined_table.event_type,
            combined_table.event_org
        FROM (
            SELECT
                olfe.event_id,
                olfe.category_name_id,
                olfe.event_description,
                ocn.category_name,
                olfe.event_date,
                olfe.event_time,
                en.event_name,
                et.event_type,
                NULL AS event_org
            FROM ongoing_list_of_event AS olfe
            INNER JOIN ongoing_category_name AS ocn ON olfe.event_id = ocn.event_id
            INNER JOIN event_name AS en ON en.event_name_id = ocn.event_name_id
            INNER JOIN event_type AS et ON et.event_type_id = ocn.event_type_id

            UNION ALL

            SELECT
                CONCAT('P', post.post_id) AS event_id,
                NULL AS category_name_id,
                post.post_description AS event_description,
                post.post_title AS category_name,
                post.post_calendar AS event_date,
                NULL AS event_name,
                NULL AS event_time,
                post.post_calendar_type AS event_type,
                organization.organization_name AS event_org
            FROM post
            INNER JOIN organization ON post.organization_id = organization.organization_id
        ) AS combined_table
        WHERE YEAR(combined_table.event_date) = ?
        AND MONTH(combined_table.event_date) = ?
        AND DAY(combined_table.event_date) = ?
        AND (combined_table.event_type IN ($event_type_filters) 
        AND combined_table.event_org IN ($event_org_filters)
        OR combined_table.event_org IS NULL)
        ORDER BY combined_table.event_time ASC;";

$stmt = mysqli_prepare($conn, $sql);

$params = array_merge([$year, $month, $selectedDate], $filteredFilters, $filteredOrgFilters);
$types = str_repeat('s', count($params));

mysqli_stmt_bind_param($stmt, $types, ...$params);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    // Fetch results and store them in an array
    $events = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = $row;
    }
    // Return the array as JSON
    echo json_encode($events, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
} else {
    // Return an empty array as JSON
    echo json_encode(array());
}

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
