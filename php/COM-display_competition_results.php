<?php
require 'database_connect.php';




// Query the competitions table
$sql = "SELECT * FROM competitions_table";
$result = $conn->query($sql);

// If there are competitions, generate HTML code for each of them
if ($result->num_rows > 0) {
    ?> <script type="text/javascript">document.getElementById('empty').style.display = 'none';</script>
    <?php
  while($row = $result->fetch_assoc()) {
    echo "<div class='result_container'>";
    // Display the name of the competition and a button with the competition ID as the ID
    echo "<h2 class='parent' id='" . $row["competition_name"] ."'>" . $row["competition_name"] . "<button class='sched_btn primary-button' id='" . $row["competition_name"] . " btn'>Schedule</button></h2>";
    // Generate HTML code for the result div and table
    echo "<div class='result'>";
    echo "<table>";
    echo "<tbody class='responsive-table'>";
    echo "<tr><th>Name</th><th>Organization</th>";
    
    // Query the criteria table for this competition
    $sql_criteria = "SELECT * FROM criteria_table WHERE competition_id = " . $row["competition_id"];
    $result_criteria = $conn->query($sql_criteria);
    
    // Generate HTML code for the criteria columns
    while($row_criteria = $result_criteria->fetch_assoc()) {
      echo "<th>" . $row_criteria["criteria_name"] . "</th>";
    }
    
    echo "<th>Overall Score</th></tr>";
    
    // Query the scores table for this competition and participant
    $sql_scores = "SELECT participants_table.participant_name, participants_table.organization, scores_table.criteria_id, scores_table.score, overall_scores_table.overall_score
                   FROM scores_table
                   INNER JOIN participants_table ON scores_table.participant_id = participants_table.participant_id
                   INNER JOIN overall_scores_table ON scores_table.participant_id = overall_scores_table.participant_id AND scores_table.competition_id = overall_scores_table.competition_id
                   WHERE scores_table.competition_id = " . $row["competition_id"];
    $result_scores = $conn->query($sql_scores);
    
    // Generate HTML code for the scores rows
    $scores = array();
    while($row_scores = $result_scores->fetch_assoc()) {
      $participant_name = $row_scores["participant_name"];
      if (!isset($scores[$participant_name])) {
        $scores[$participant_name] = array(
          "organization" => $row_scores["organization"],
          "overall_score" => $row_scores["overall_score"],
          "criteria_scores" => array()
        );
      }
      $scores[$participant_name]["criteria_scores"][$row_scores["criteria_id"]] = $row_scores["score"];
    }
    foreach ($scores as $participant_name => $score_data) {
      echo "<tr><td>" . $participant_name . "</td><td>" . $score_data["organization"] . "</td>";
      $result_criteria->data_seek(0);
      while($row_criteria = $result_criteria->fetch_assoc()) {
        $score = isset($score_data["criteria_scores"][$row_criteria["criteria_id"]]) ? $score_data["criteria_scores"][$row_criteria["criteria_id"]] : "";
        echo "<td>" . $score . "</td>";
      }
      echo "<td>" . $score_data["overall_score"] . "</td></tr>";
    }
    
    echo "</tbody></table></div>";
    echo "</div>";
  }
} 

// Close connection
$conn->close();
?>
