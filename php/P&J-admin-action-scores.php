<?php
    // Connect to your database

    $server= "localhost";
    $username = "root";
    $password = "";
    $dbname = "pupets";
    
    $connection = mysqli_connect($server, $username, $password, $dbname);

    if (isset($_POST['add_btnScore'])) {

    // Select the data from pjscorestemp
    $query = "SELECT * FROM pjscorestemp";
    $result = mysqli_query($connection, $query);

    // Transfer the data to judges
    while ($row = mysqli_fetch_assoc($result)) {
        $groupname = $row['group_name_temp'];
        $column1Value = $row['criteria_1_temp'];
        $column2Value = $row['criteria_2_temp'];
        $column3Value = $row['criteria_3_temp'];
        $column4Value = $row['criteria_4_temp'];
        $totalscore = $row['total_score_temp'];

        $insertQuery = "INSERT INTO pjscores (group_name, criteria_1, criteria_2, criteria_3, criteria_4, total_score) VALUES ('$groupname', '$column1Value', '$column2Value', '$column3Value', '$column4Value', '$totalscore')";
        mysqli_query($connection, $insertQuery);
    }

    // Delete the transferred data from pjscorestemp
    $deleteQuery = "DELETE FROM pjscorestemp";
    mysqli_query($connection, $deleteQuery);

    // Close the database connection
    header("Location: ../P&J-admin-scoretab.php");
    exit();
}
?>