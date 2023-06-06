<?php
include 'database_connect.php';

$sortColumn = $_GET['sortColumn'];
$sortOrder = $_GET['sortOrder'];
$searchTerm = $_GET['searchTerm'];
$searchDate = $_GET['searchDate'];

$validColumns = ['log_id', 'log_date', 'log_time', 'admin', 'activity_description'];
$validOrders = ['ASC', 'DESC'];

// Validate and sanitize the sort column and sort order
if (!in_array($sortColumn, $validColumns)) {
  $sortColumn = 'log_id'; // Default sort column
}

if (!in_array($sortOrder, $validOrders)) {
  $sortOrder = 'ASC'; // Default sort order
}

// Construct the SQL query with sorting and filtering
$orderBy = $sortColumn . ' ' . $sortOrder;

$searchCondition = '';

if (!empty($searchTerm)) {
  // Sanitize the search term to prevent SQL injection
  $searchTerm = mysqli_real_escape_string($conn, $searchTerm);

  $searchCondition .= "(log_id LIKE '%$searchTerm%' OR admin LIKE '%$searchTerm%' OR activity_description LIKE '%$searchTerm%')";
}

$dateCondition = '';
if (!empty($searchDate)) {
  // Convert the search date to the appropriate format
  $searchDateFormatted = date('Y-m-d', strtotime($searchDate));

  $dateCondition = "DATE(log_date_time) = ?";
}

// Add appropriate conjunction between search conditions
if (!empty($searchTerm) && !empty($searchDate)) {
  $searchCondition .= " AND ";
}

// Use prepared statements to prevent SQL injection
$log_sql = "SELECT * FROM logs";

// Add search condition and date condition if applicable
if (!empty($searchCondition) || !empty($dateCondition)) {
  $log_sql .= " WHERE ";
  $log_sql .= $searchCondition;
  $log_sql .= $dateCondition;
}

$log_sql .= " ORDER BY $orderBy";
$log_stmt = mysqli_prepare($conn, $log_sql);

// Bind the search date parameter to the prepared statement if it exists
if (!empty($searchDate)) {
  mysqli_stmt_bind_param($log_stmt, 's', $searchDateFormatted);
}

mysqli_stmt_execute($log_stmt);
$log_result = mysqli_stmt_get_result($log_stmt);

$logs = array();
while ($row = mysqli_fetch_assoc($log_result)) {
  $logs[] = $row;
}

$response = array(
  'logs' => $logs
);

echo json_encode($response, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
mysqli_stmt_close($log_stmt);
mysqli_close($conn);
?>
