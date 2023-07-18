<style>
  /* Styles for the competition result container */
  .result_container {
    margin-bottom: 20px;
  }

  /* Styles for the competition name heading */
  .parent {
    font-size: 20px;
    font-weight: bold;
    color: var(--color-content-text);
  }

  /* Styles for the schedule input */
  .sched_output {
    margin-top: 10px;
    width: 200px;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 3px;
  }

  /* Styles for the table */
  table {
    width: 100%;
    border-collapse: collapse;
  }

  /* Styles for the table header row */
  th {
    padding: 10px;
    text-align: left;
    font-size: 20px;
    color: var(--color-content-text);
  }

  /* Styles for the table data rows */
  td {
    padding: 10px;
    font-size: 20px;
    color: var(--color-content-text)
  }

  /* Styles for the empty message */
  #empty {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 200px;
    font-size: 20px;
    color: #888;
  }
</style>

<?php
require './php/database_connect.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Get the current date and time
$currentDateTime = date("Y-m-d H:i:s");

// Check if an event_id is provided via GET parameters
if (isset($_GET['event_id'])) {
  $clickedEventId = $_GET['event_id'];

  // Query the competitions table with the condition for schedule and the clicked event_id
  $sql = "SELECT * FROM competition WHERE schedule IS NOT NULL AND schedule_end IS NOT NULL AND is_archived='1' AND event_id='$clickedEventId'";
} else {
  // Query the competitions table with the condition for schedule
  $sql = "SELECT * FROM competition WHERE schedule IS NOT NULL AND schedule_end IS NOT NULL AND is_archived='1'";
}

$result = $conn->query($sql);

// If there are competitions, generate HTML code for each of them
if ($result->num_rows > 0) {
  echo "<script type='text/javascript'>";
  echo "document.getElementById('empty').style.display = 'none';";
  echo "console.log('display result');";
  echo "console.log('Working');";
  echo "</script>";

  while ($row = $result->fetch_assoc()) {
    $competitionNameQuery = "SELECT category_name FROM ongoing_list_of_event WHERE event_id =" . $row["event_id"];
    $competitionNameResult = $conn->query($competitionNameQuery);

    if ($competitionNameResult->num_rows > 0) {
      $competitionNameRow = $competitionNameResult->fetch_assoc();
      $competitionName = $competitionNameRow["category_name"];
    } else {
      $competitionName = "Unknown";
    }
    $competition_id = $row['competition_id'];
    $event_id = $row['event_id'];

    // Query the ongoing_criterion table to get the criteria for this competition
    $criteria_sql = "SELECT * FROM ongoing_criterion WHERE event_id = '$event_id'";
    $criteria_result = $conn->query($criteria_sql);

    // Generate HTML code for each competition
    echo "<div class='result_container'>";
    // Display the name of the competition
    echo "<h2 class='parent' id='" . $competitionName ."'>" . $competitionName . "<br> </h2>";
    // Generate HTML code for the result div and table
    echo "<div class='result'>";
    echo "<table>";
    echo "<tbody class='responsive-table'>";
    echo "<tr><th>Name</th><th>Organization</th>";

    // Generate HTML code for the criteria columns
    while ($criterion_row = $criteria_result->fetch_assoc()) {
      echo "<th>" . $criterion_row["criterion_name"] . "</th>";
    }

    echo "<th>Overall Score</th></tr>";

    // Query the participants table for this competition
    $participants_sql = "SELECT * FROM participants WHERE competition_id = '$competition_id'";
    $participants_result = $conn->query($participants_sql);

    // Generate HTML code for the scores rows
    while ($participant_row = $participants_result->fetch_assoc()) {
      $participant_name = $participant_row["participant_name"];
      $organization_id = $participant_row["organization_id"];
      $participant_id = $participant_row["participants_id"];

      // Query the organization table to get the organization name
      $org_sql = "SELECT organization_name FROM organization WHERE organization_id = '$organization_id'";
      $org_result = $conn->query($org_sql);
      $organization_name = $org_result->fetch_assoc()["organization_name"];

      echo "<tr><td>" . $participant_name . "</td><td>" . $organization_name . "</td>";

      // Loop through each criterion to get the scores for this participant
      $criteria_result->data_seek(0);
      $total_score = 0;

      while ($criterion_row = $criteria_result->fetch_assoc()) {
        $criterion_id = $criterion_row["criterion_id"];

        // Query the criterion_scoring table to get the final score for this participant and criterion
        $score_sql = "SELECT criterion_final_score FROM criterion_scoring WHERE ongoing_criterion_id = '$criterion_id' AND participants_id = '$participant_id'";
        $score_result = $conn->query($score_sql);
        $final_score = $score_result->fetch_assoc()["criterion_final_score"];

        if ($final_score !== null) {
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
  // If there are no competitions, display a message
  echo "<script>";
  echo "var empty = document.getElementById('empty');";
  echo "var searchbar = document.querySelector('.inputAndDeleteDiv');";
  echo "var pagini = document.querySelector('.pagination');";
  echo "empty.style.display = 'flex';";
  echo "searchbar.style.display = 'none';";
  echo "pagini.style.display = 'none';";
  echo "</script>";
}

// Close connection
$conn->close();
?>
