<?php
// Assuming you have a database connection established

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted data
    $bracketId = $_POST['teamScoreId'];
    $teamAScore = $_POST['teamAScore'];

    // Output the received data for debugging
    echo "Team Score ID: " . $teamScoreId . "<br>";
    echo "Team A Score: " . $teamAScore . "<br>";
    // Update the database with the new score
    // You should replace the placeholders with your actual database table and column names
    $query = "UPDATE tou_team
    SET team_score = team_score + 3
    WHERE team_id IN (
      SELECT team1_id
      FROM tou_bracket
    ) WHERE tou_bracket = $bracketId";

    // Execute the query
    if (!mysqli_query($connection, $query)) {
        // Handle the error
        die('Error updating score: ' . mysqli_error($connection));
    }

    // Optionally, you can retrieve the updated total score or any other relevant data
    // For example, you can retrieve the total score for display purposes
    $totalScore = 0; // Assuming the total score is initially zero
    // Execute a query to calculate the total score or retrieve it from the database

    // Prepare the response data
    $response = array(
        'totalScore' => $totalScore,
    );

    // Send the response back to the JavaScript code
    echo json_encode($response);
}
?>