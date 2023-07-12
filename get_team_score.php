<?php
// Assuming you have a database connection established
// Replace DB_HOST, DB_USERNAME, DB_PASSWORD, and DB_NAME with your actual database credentials
$connection = mysqli_connect('localhost', 'root', '', 'ets');

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the teamScoreId parameter exists in the POST request
if (isset($_POST['teamScoreId'])) {
    $teamScoreId = $_POST['teamScoreId'];

    // Prepare the SQL query to fetch the team scores based on the teamScoreId
    $query = "SELECT score1.team_score AS team_a_score, score2.team_score AS team_b_score
              FROM tou_bracket
              INNER JOIN tou_team AS score1 ON tou_bracket.team1_id = score1.team_id
              INNER JOIN tou_team AS score2 ON tou_bracket.team2_id = score2.team_id
              WHERE tou_bracket.bracket_id = $teamScoreId";

    // Execute the query
    $result = mysqli_query($connection, $query);

    // Check if the query was successful
    if ($result) {
        // Fetch the team scores from the result
        $row = mysqli_fetch_assoc($result);
        $teamAScore = $row['team_a_score'];
        $teamBScore = $row['team_b_score'];

        // Create an array to store the team scores
        $teamScores = array(
            'teamAScore' => $teamAScore,
            'teamBScore' => $teamBScore
        );

        // Convert the array to JSON and return it as the response
        echo json_encode($teamScores);
    } else {
        // Return an error message if the query fails
        echo json_encode(array('error' => 'Error occurred while fetching team scores.'));
    }
} else {
    // Return an error message if the teamScoreId parameter is not provided
    echo json_encode(array('error' => 'teamScoreId parameter is missing.'));
}

// Close the database connection
mysqli_close($connection);
?>