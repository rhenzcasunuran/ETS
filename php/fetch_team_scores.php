<?php
// fetch_team_scores.php

// Assuming you have a database connection established
include './database_connect.php';
// ...

// Check if the teamScoreId is set in the POST data
if (isset($_POST['teamScoreId'])) {
    $teamScoreId = $_POST['teamScoreId'];
  
    // Retrieve the team scores from the database based on the teamScoreId
    // Modify this query to match your database schema and table names
    $sql = "SELECT score1.team_score AS score_a, score2.team_score AS score_b
            FROM tou_bracket
            INNER JOIN tou_team AS score1 ON tou_bracket.team1_id = score1.team_id
            INNER JOIN tou_team AS score2 ON tou_bracket.team2_id = score2.team_id
            WHERE tou_bracket.bracket_id = $teamScoreId";
    $result = $conn->query($sql);
  
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $scoreA = $row['score_a'];
      $scoreB = $row['score_b'];
  
      // Return the team scores as a response
      echo $scoreA . '-' . $scoreB;
    } else {
      // If no results found, return an empty response or an error message
      echo "No team scores found.";
    }
  } else {
    // If teamScoreId is not set, return an error message
    echo "Invalid request. Team score ID not provided.";
  }
  
  // Close the database connection
  $conn->close();
  ?>