<?php
include('database_connect.php');

// Retrieve the event name from the URL parameters
$eventName = $_GET['eventName'] ?? '';

// Modify the query to include the event name filter
$query = "SELECT event_name, category_name, YEAR(event_date) AS event_year, suggested_status 
          FROM eventhistorytb 
          WHERE event_name LIKE '%$eventName%' 
          ORDER BY suggested_status";

// Execute the query and fetch the results
$result = mysqli_query($conn, $query);

// Format the results as HTML code for event cards
$html = '';
while ($row = mysqli_fetch_assoc($result)) {
    // Generate HTML code for each event card based on the filtered results
    $eventName = $row['event_name'];
    $categoryName = $row['category_name'];
    $eventYear = $row['event_year'];

    // Customize the HTML structure to match your event card layout
    $html .= '<div class="event-card">';
    $html .= '  <h3 class="event-name">' . $eventName . '</h3>';
    $html .= '  <p class="category">' . $categoryName . '</p>';
    $html .= '  <p class="year">' . $eventYear . '</p>';
    $html .= '</div>';
}

// If no results found, display a message
if (empty($html)) {
    $html = '<p>No events found.</p>';
}

// CSS styles for the event cards and card container
$css = '
<style>
#card-container {
  display: flex;
  justify-content: flex-start;
  overflow-x: auto;
  width: 100%; /* Adjust the width to fit the parent container */
  border-radius: 10px;
  white-space: nowrap;
  justify-content: flex-start; /* Adjust the alignment based on your preference */
  overflow-y: hidden; /* Hide vertical scrollbar */
  padding: 2px;
}

.event-card {
  flex: 0 0 auto;
  background-color: var(--color-content-card);
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  margin-right: 10px;
  margin-bottom: 10px;
  margin-top : 25px;
  min-width: 150px;
  text-align: center;
  color: var(--color-content-text);
}

.event-name {
  font-size: 18px;
  font-weight: bold;
  margin: 0;
}

.category {
  font-size: 14px;
  margin: 0;
}

.year {
  font-size: 12px;
  margin: 0;
}

</style>
';

// Echo the CSS styles, HTML code, and card container div as the response
echo $css;
echo '<div id="card-container">' . $html . '</div>';

// Close the database connection and any other necessary cleanup
mysqli_close($conn);
?>
