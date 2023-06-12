<?php
    require 'database_connect.php';

    if (isset($_POST['criterionId'])) {
        $criterionId = $_POST['criterionId'];
    
        // Prepare the SQL statement to delete the criterion from the database
        $sql = "DELETE FROM criterion WHERE criterion_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $criterionId);
        $stmt->execute();
    }
?>