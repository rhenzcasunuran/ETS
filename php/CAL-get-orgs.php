<?php
include 'database_connect.php';

// Fetch organization data from the database
$query = "SELECT * FROM organization";
$result = $conn->query($query);

if ($result) {
    $orgNames = array();

    while ($row = $result->fetch_assoc()) {
        $orgName = array(
            'id' => $row['organization_id'],
            'organization_name' => $row['organization_name']
        );
        $orgNames[] = $orgName;
    }

    // Return the organization data as JSON
    header('Content-Type: application/json');
    echo json_encode(array('orgNames' => $orgNames));
} else {
    echo 'Error: ' . $conn->error;
}

// Close the database connection
$conn->close();
?>
