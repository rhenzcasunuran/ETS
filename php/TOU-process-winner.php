<?php
include 'database_connect.php';

// Retrieve the form values
$bracketFormId = $_POST['bracketFormId'];
$scheduledTeamBrackets = $_POST['scheduledTeamBrackets'];
$teamOneName = $_POST['teamOneName'];
$teamTwoName = $_POST['teamTwoName'];

// Prepare the SQL statement
$query = "SELECT bf.id, bf.max_column, bf.current_column, bf.current_column_status,
          ot.id AS team_one_id,
          ot.team_name AS team_one_name,
          ot.current_set_no AS current_team_one_set_no,
          ot.current_overall_score AS current_team_one_overall_score,
          ot.current_score AS current_team_one_score,
          ot.current_team_status AS current_team_one_status,
          ot2.id AS team_two_id,
          ot2.team_name AS team_two_name,
          ot2.current_set_no AS current_team_two_set_no,
          ot2.current_overall_score AS current_team_two_overall_score,
          ot2.current_score AS current_team_two_score,
          ot2.current_team_status AS current_team_two_status
          FROM `bracket_forms` AS bf
          INNER JOIN bracket_teams AS bt 
          ON bf.id = bt.bracket_form_id
          INNER JOIN ongoing_teams AS ot
          ON ot.id = bt.team_one_id
          INNER JOIN ongoing_teams AS ot2
          ON ot2.id = bt.team_two_id
          WHERE bt.id = ? AND bf.id = ? AND ot.team_name = ? AND ot2.team_name = ?;";

// Prepare the statement
$stmt = mysqli_prepare($conn, $query);

// Bind the form data to the prepared statement parameters
mysqli_stmt_bind_param($stmt, "iiss", $bracketFormId, $scheduledTeamBrackets, $teamOneName, $teamTwoName);

// Execute the statement
mysqli_stmt_execute($stmt);

// Get the result set
$result = mysqli_stmt_get_result($stmt);

// Check if the query was successful
if ($result) {
    // Fetch the rows from the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Store the values of the columns in variables
        $bfId = $row['id'];
        $bfMaxColumn = $row['max_column'];
        $bfCurrentColumn = $row['current_column'];
        $bfCurrentColumnStatus = $row['current_column_status'];
        $otTeamOneId = $row['team_one_id'];
        $otTeamOneName = $row['team_one_name'];
        $otCurrentSetNo = $row['current_team_one_set_no'];
        $otCurrentOverallScore = $row['current_team_one_overall_score'];
        $otCurrentScore = $row['current_team_one_score'];
        $otCurrentTeamStatus = $row['current_team_one_status'];
        $ot2TeamTwoId = $row['team_two_id'];
        $ot2TeamTwoName = $row['team_two_name'];
        $ot2CurrentSetNo = $row['current_team_two_set_no'];
        $ot2CurrentOverallScore = $row['current_team_two_overall_score'];
        $ot2CurrentScore = $row['current_team_two_score'];
        $ot2CurrentTeamStatus = $row['current_team_two_status'];
        
        // Now you can use the variables as needed
        echo "Bracket Form ID: " . $bfId . "<br>";
        echo "Max Column: " . $bfMaxColumn . "<br>";
        echo "Current Column: " . $bfCurrentColumn . "<br>";
        echo "Current Column Status: " . $bfCurrentColumnStatus . "<br>";
        echo "Team One ID: " . $otTeamOneId . "<br>";
        echo "Team One Name: " . $otTeamOneName . "<br>";
        echo "Current Team One Set No: " . $otCurrentSetNo . "<br>";
        echo "Current Team One Overall Score: " . $otCurrentOverallScore . "<br>";
        echo "Current Team One Score: " . $otCurrentScore . "<br>";
        echo "Current Team One Status: " . $otCurrentTeamStatus . "<br>";
        echo "Team Two ID: " . $ot2TeamTwoId . "<br>";
        echo "Team Two Name: " . $ot2TeamTwoName . "<br>";
        echo "Current Team Two Set No: " . $ot2CurrentSetNo . "<br>";
        echo "Current Team Two Overall Score: " . $ot2CurrentOverallScore . "<br>";
        echo "Current Team Two Score: " . $ot2CurrentScore . "<br>";
        echo "Current Team Two Status: " . $ot2CurrentTeamStatus . "<br>";
        echo "<br>";
    }

    // Free the result set
    mysqli_free_result($result);
} else {
    // Handle the case when the query fails
    echo "Error executing the query: " . mysqli_error($conn);
}

// If team one is winning
if ($ot2CurrentScore < $otCurrentScore) {
    //UPDATE ongoing_teams
    //SET current_set_no = current_set_no + 1, current_score = 0,
    //WHERE bracket_form_id = ? AND team_name = ?;
} else if ($otCurrentScore < $ot2CurrentScore) {

}

// Close the prepared statement
mysqli_stmt_close($stmt);

// Close the database connection
mysqli_close($conn);
?>