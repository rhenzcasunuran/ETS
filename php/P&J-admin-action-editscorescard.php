<?php

$server= "localhost";
$username = "root";
$password = "";
$dbname = "pupets";

$conn = mysqli_connect($server, $username, $password, $dbname);

if(!$conn) {
    die("Connection Failed:".mysqli_connect_error());
}


// Get the ID from the URL parameter
$id = $_GET['score_id_temp'];

// Fetch the specific entry from the database
$query = "SELECT * FROM pjscorestemp WHERE id = " . $id;
$result = mysqli_query($connection, $query);

// Check if the entry exists
if (mysqli_num_rows($result) > 0) {
    // Retrieve the entry data
    $entry = mysqli_fetch_assoc($result);

    // Close the database connection
    mysqli_close($connection);

    // Return the entry data as a JSON response
    header('Content-Type: application/json');
    echo json_encode($entry);
} else {
    // Entry not found
    // Close the database connection
    mysqli_close($connection);

    // Return an error message as a JSON response
    header('HTTP/1.1 404 Not Found');
    echo json_encode(array('error' => 'Entry not found.'));
}
?>
?>