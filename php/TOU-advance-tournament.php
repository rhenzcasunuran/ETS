<?php
include 'database_connect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted values
    $id = mysqli_real_escape_string($conn, $_POST['id']);
}
?>
