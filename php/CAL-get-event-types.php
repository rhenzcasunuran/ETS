<?php
include 'database_connect.php';

// Fetch event type data from the database
$query = "SELECT * FROM event_type";
$result = $conn->query($query);

if ($result) {
    $eventTypes = array();

    while ($row = $result->fetch_assoc()) {
        $eventType = array(
            'id' => $row['event_type_id'],
            'event_type' => $row['event_type']
        );
        $eventTypes[] = $eventType;
    }

    // Return the event type data as JSON
    header('Content-Type: application/json');
    echo json_encode(array('eventTypes' => $eventTypes));
} else {
    echo 'Error: ' . $conn->error;
}

// Close the database connection
$conn->close();
?>
