<?php
require_once 'database_connect.php';

$sortColumn = $_GET['sortColumn'];
$sortOrder = $_GET['sortOrder'];
$searchTerm = $_GET['searchTerm'];
$searchDate = $_GET['searchDate'];
$adminFilters = isset($_GET['searchAdmin']) ? $_GET['searchAdmin'] : array();

// Check if filters array is empty
if (empty($adminFilters)) {
  echo json_encode(array('logs' => array())); // Return an empty logs array
  exit;
}

$validColumns = ['log_id', 'log_date', 'log_time', 'admin_id', 'activity_description'];
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
$parameters = array();

if (!empty($searchTerm)) {
  // Sanitize the search term to prevent SQL injection
  $searchTerm = mysqli_real_escape_string($conn, $searchTerm);

  $searchCondition .= "(logs.log_id LIKE ? OR user.user_username LIKE ? OR logs.activity_description LIKE ?)";
  $parameters[] = "%$searchTerm%";
  $parameters[] = "%$searchTerm%";
  $parameters[] = "%$searchTerm%";
}

$adminPlaceholders = implode(',', array_fill(0, count($adminFilters), '?'));

$adminCondition = "logs.admin_id IN ($adminPlaceholders)";
$parameters = array_merge($parameters, $adminFilters);

// Use prepared statements to prevent SQL injection
$log_sql = "SELECT logs.*, user.user_username 
            FROM logs
            INNER JOIN user ON logs.admin_id = user.admin_id";

// Add search condition and admin condition if applicable
if (!empty($searchCondition) || !empty($adminCondition)) {
  $log_sql .= " WHERE ";
  
  if (!empty($searchCondition)) {
    $log_sql .= $searchCondition;
  }
  
  if (!empty($searchCondition) && !empty($adminCondition)) {
    $log_sql .= " AND ";
  }
  
  if (!empty($adminCondition)) {
    $log_sql .= $adminCondition;
  }
}

// Add date condition if searchDate is not empty
if (!empty($searchDate)) {
  // Convert the search date to the appropriate format
  $searchDateFormatted = date('Y-m-d', strtotime($searchDate));

  $log_sql .= " AND DATE(logs.log_date) = ?";
  $parameters[] = $searchDateFormatted;
}

$log_sql .= " ORDER BY $orderBy, logs.log_time DESC";
$log_stmt = mysqli_prepare($conn, $log_sql);

// Bind the parameters to the prepared statement
if (!empty($parameters)) {
  $types = str_repeat('s', count($parameters)); // Assuming all parameters are strings
  mysqli_stmt_bind_param($log_stmt, $types, ...$parameters);
}

mysqli_stmt_execute($log_stmt);
$log_result = mysqli_stmt_get_result($log_stmt);

$logs = array();
while ($row = mysqli_fetch_assoc($log_result)) {
  // Convert log_date and log_time to appropriate formats
  $row['log_date'] = date('Y-m-d', strtotime($row['log_date']));
  $row['log_time'] = date('H:i:s', strtotime($row['log_time']));
  $logs[] = $row;
}

$response = array(
  'logs' => $logs
);

echo json_encode($response, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
mysqli_stmt_close($log_stmt);
mysqli_close($conn);
?>
