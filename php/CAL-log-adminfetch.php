<?php
include 'database_connect.php';

// Fetch admin data from the database
$query = "SELECT * FROM user";
$result = $conn->query($query);

if ($result) {
    $adminUsers = array();

    while ($row = $result->fetch_assoc()) {
        $adminUser = array(
            'id' => $row['id'],
            'username' => $row['user_username']
        );
        $adminUsers[] = $adminUser;
    }

    // Return the admin data as JSON
    header('Content-Type: application/json');
    echo json_encode(array('adminUsers' => $adminUsers));
} else {
    echo 'Error: ' . $conn->error;
}

// Close the database connection
$conn->close();
?>
