<?php
// Include your database connection or any other required files here
include 'database_connect.php';

session_start();

if (isset($_POST['id']) && isset($_SESSION['user_username'])) {
    $id = $_POST['id'];

    // Perform the UPDATE operation in your database table
    $sql = "UPDATE tournament SET has_set_tournament = 0 WHERE bracket_form_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // Perform the DELETE operation in your database table
    $sql = "DELETE FROM bracket_forms WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // Close the statement and connection  
    $conn->close();
} else {
    header("Location: ../index.php");
    exit();
}
?>
