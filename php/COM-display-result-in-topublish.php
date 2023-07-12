<?php
require 'database_connect.php';

// Query the competitions table
$sql = "SELECT * FROM competition WHERE is_archived='0'";
$result = $conn->query($sql);

// If there are competitions, generate HTML code for each of them
if ($result->num_rows > 0) {
    ?>
    <script type="text/javascript">
        document.getElementById('empty').style.display = 'none';
        console.log("display result");
        console.log("Working");
    </script>
    <?php

    while ($row = $result->fetch_assoc()) {
      $competitionNameQuery = "SELECT category_name FROM category_name WHERE category_name_id =" . $row["category_name_id"];
      $competitionNameResult = $conn->query($competitionNameQuery);
      
      if ($competitionNameResult->num_rows > 0) {
          $competitionNameRow = $competitionNameResult->fetch_assoc();
          $competitionName = $competitionNameRow["category_name"];
      } else {
          $competitionName = "Unknown";
      }
        echo "<div class='result_container'>";
        // Display the name of the competition and a button with the competition ID as the ID
        echo "<h2 class='parent' id='" . $competitionName . "'>" . $competitionName . "<br><input type='text' name='datetimes' placeholder='No schedule yet...' id='" . $competitionName . "-input' class='sched_output' disabled/><button class='sched_btn primary-button' id='" . $competitionName . " btn'>Schedule</button></h2>";
        // Generate HTML code for the result div and table
        echo "<div class='result'>";
        echo "<table>";
        echo "<tbody class='responsive-table'>";
        echo "<tr><th>Name</th><th>Organization</th>";

        // Query the criteria table for this competition
        $sql_criterion = "SELECT * FROM criterion WHERE category_name_id = " . $row["category_name_id"];
        $result_criterion = $conn->query($sql_criterion);

        // Generate HTML code for the criteria columns
        while ($row_criterion = $result_criterion->fetch_assoc()) {
            echo "<th>" . $row_criterion["criterion_name"] . "</th>";
        }

        echo "<th>Overall Score</th></tr>";

        // Query the scores table for this competition and participant
        $sql_scores = "SELECT participants.participant_name, participants.organization_id, criterion_scoring.participants_id, criterion_scoring.ongoing_criterion_id, criterion_scoring.criterion_final_score
                       FROM criterion_scoring
                       INNER JOIN participants ON criterion_scoring.participants_id = participants.participants_id
                       WHERE criterion_scoring.category_name_id = " . $row["category_name_id"] . "
                       GROUP BY participants.participant_name, participants.organization_id, criterion_scoring.participants_id";

        $result_scores = $conn->query($sql_scores);

        // Generate HTML code for the scores rows
        while ($row_scores = $result_scores->fetch_assoc()) {
          $organization_nameQueary = "SELECT organization_name FROM organization WHERE organization_id = ". $row_scores["organization_id"];
          $orgnameResult = $conn->query($organization_nameQueary);
      
          if ($orgnameResult->num_rows > 0) {
              $orgnameRow = $orgnameResult->fetch_assoc();
              $organization_name = $orgnameRow["organization_name"];
          } else {
              $organization_name = "Unknown";
          }

          echo "<tr><td>" . $row_scores["participant_name"] . "</td><td>" . $organization_name . "</td>";

          $result_criterion->data_seek(0);

          $total_score = 0;

          while ($row_criterion = $result_criterion->fetch_assoc()) {
              $criterion_id = $row_criterion["criterion_id"];
              $participant_id = $row_scores["participants_id"];

              $sql_final_score = "SELECT criterion_final_score FROM criterion_scoring WHERE ongoing_criterion_id = $criterion_id AND participants_id = $participant_id";

              $result_final_score = $conn->query($sql_final_score);

              if ($result_final_score->num_rows > 0) {
                  $final_score = $result_final_score->fetch_assoc()["criterion_final_score"];
                  $total_score += $final_score;
                  echo "<td>" . $final_score . "</td>";
              } else {
                  echo "<td></td>";
              }
          }

          echo "<td>" . $total_score . "</td></tr>";
      }

      echo "</tbody></table></div>";
      echo "</div>";
  }
} else {
    ?>
    <script>
        var empty = document.getElementById('empty');
        var searchbar = document.querySelector('.inputAndDeleteDiv');
        var pagini = document.querySelector('.pagination');
        empty.style.display = 'flex';
        searchbar.style.display = 'none';
        pagini.style.display = 'none';
    </script>
    <?php
}

// Close connection
$conn->close();
?>
