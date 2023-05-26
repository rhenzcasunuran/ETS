<?php
    // Connect to your database

    $server= "localhost";
    $username = "root";
    $password = "";
    $dbname = "pupets";
    
    $connection = mysqli_connect($server, $username, $password, $dbname);

    if (isset($_POST['add_btnS'])) {

    // Select the data from judgestemp
    $query = "SELECT * FROM pjjudgestemp";
    $result = mysqli_query($connection, $query);

    // Transfer the data to judges
    while ($row = mysqli_fetch_assoc($result)) {
        $column1Value = $row['judge_name_temp'];
        $column2Value = $row['judge_nick_temp'];

        $insertQuery = "INSERT INTO pjjudges (judge_name, judge_nick) VALUES ('$column1Value', '$column2Value')";
        mysqli_query($connection, $insertQuery);
    }

    // Delete the transferred data from judgestemp
    $deleteQuery = "DELETE FROM pjjudgestemp";
    mysqli_query($connection, $deleteQuery);

    // Close the database connection

    // Select the data from participantstemp
    $query = "SELECT * FROM pjparticipantstemp";
    $result = mysqli_query($connection, $query);

    // Transfer the data to participants
    while ($row = mysqli_fetch_assoc($result)) {
        $column1Value = $row['participants_name_temp'];
        $column2Value = $row['participants_course_temp'];
        $column3Value = $row['participants_section_temp'];
        $column4Value = $row['participants_organization_temp'];

        $insertQuery = "INSERT INTO pjparticipants (participants_name, participants_course, participants_section,participants_organization) VALUES ('$column1Value', '$column2Value', '$column3Value', '$column4Value')";
        mysqli_query($connection, $insertQuery);
    }

    // Delete the transferred data from participantstemp
    $deleteQuery = "DELETE FROM pjparticipantstemp";
    mysqli_query($connection, $deleteQuery);

    // Close the database connection

    // Select the data from participantsgrouptemp
    $query = "SELECT * FROM pjparticipantsgrouptemp";
    $result = mysqli_query($connection, $query);

    // Transfer the data to participantgroup
    while ($row = mysqli_fetch_assoc($result)) {
        $column1Value = $row['participants_name_group_temp'];
        $column2Value = $row['participants_organization_group_temp'];

        $insertQuery = "INSERT INTO pjparticipantsgroup (participants_name_group, participants_organization_group) VALUES ('$column1Value', '$column2Value')";
        mysqli_query($connection, $insertQuery);
    }

    // Delete the transferred data from participantgrouptemp
    $deleteQuery = "DELETE FROM pjparticipantsgrouptemp";
    mysqli_query($connection, $deleteQuery);

    // Close the database connection

    // Select the data from participantsgroupmemberstemp
    $query = "SELECT * FROM pjparticipantsgroupmemberstemp";
    $result = mysqli_query($connection, $query);

    // Transfer the data to participantgroupmember
    while ($row = mysqli_fetch_assoc($result)) {
        $column1Value = $row['participants_name_g_temp'];
        $column2Value = $row['participants_course_group_temp'];
        $column3Value = $row['participants_section_group_temp'];

        $insertQuery = "INSERT INTO pjparticipantsgroupmembers (participants_name_g, participants_course_group, participants_section_group) VALUES ('$column1Value', '$column2Value', '$column3Value')";
        mysqli_query($connection, $insertQuery);
    }

    // Delete the transferred data from participantgroupmembertemp
    $deleteQuery = "DELETE FROM pjparticipantsgroupmemberstemp";
    mysqli_query($connection, $deleteQuery);

    // Close the database connection
    header("Location: ../P&J-admin-formPJ.php");
    exit();
}
?>