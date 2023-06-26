<?php
require_once 'database_connect.php';

$sortColumn = $_GET['sortColumn'];
$sortOrder = $_GET['sortOrder'];
$searchTerm = $_GET['searchTerm'];
$searchDate = $_GET['searchDate'];
$adminFilters = isset($_GET['searchAdmin']) ? $_GET['searchAdmin'] : array();
$currentPage = isset($_GET['currentPage']) ? $_GET['currentPage'] : 1;
$startIndex = isset($_GET['startIndex']) ? $_GET['startIndex'] : 0;

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

if ($sortColumn === 'log_date') {
  $orderBy = "CONCAT(logs.log_date, ' ', logs.log_time) $sortOrder";
} else {
  $orderBy = $sortColumn . ' ' . $sortOrder;
}

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

// Execute the SQL query without the limit clause to get the total number of entries
$log_count_sql = "SELECT COUNT(*) as count FROM ($log_sql) AS countQuery";
$log_count_stmt = mysqli_prepare($conn, $log_count_sql);

// Bind the parameters to the prepared statement
if (!empty($parameters)) {
  $types = str_repeat('s', count($parameters)); // Assuming all parameters are strings
  mysqli_stmt_bind_param($log_count_stmt, $types, ...$parameters);
}

// Execute the prepared statement
mysqli_stmt_execute($log_count_stmt);

// Fetch the result
$countResult = mysqli_stmt_get_result($log_count_stmt);
$totalEntries = mysqli_fetch_assoc($countResult)['count'];

// Calculate pagination values
$pageSize = 10; // Number of logs per page
$totalPages = ceil($totalEntries / $pageSize);
$startIndex = ($currentPage - 1) * $pageSize;
$endIndex = min($startIndex + $pageSize, $totalEntries);

// Modify the original SQL query to include the limit and offset
$log_sql .= " LIMIT $startIndex, $pageSize";

// Execute the modified SQL query with the limit and offset
$log_stmt = mysqli_prepare($conn, $log_sql);

// Bind the parameters to the prepared statement
if (!empty($parameters)) {
  $types = str_repeat('s', count($parameters)); // Assuming all parameters are strings
  mysqli_stmt_bind_param($log_stmt, $types, ...$parameters);
}

// Execute the prepared statement
mysqli_stmt_execute($log_stmt);

// Fetch the result
$result = mysqli_stmt_get_result($log_stmt);

// Format the log data
$logs = array();
while ($row = mysqli_fetch_assoc($result)) {
  $logs[] = array(
    'log_id' => $row['log_id'],
    'log_date' => $row['log_date'],
    'log_time' => $row['log_time'],
    'admin_id' => $row['admin_id'],
    'user_username' => $row['user_username'],
    'activity_description' => $row['activity_description']
  );
}

// Construct the response array
$response = array(
  'logs' => $logs,
  'totalEntries' => $totalEntries,
  'totalPages' => $totalPages,
  'currentPage' => $currentPage,
  'pageSize' => $pageSize,
  'startIndex' => $startIndex,
  'endIndex' => $endIndex
);

// Encode the response array as JSON and echo it
echo json_encode($response);
mysqli_stmt_close($log_stmt);
mysqli_close($conn);
?>
