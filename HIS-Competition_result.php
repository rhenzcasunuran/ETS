<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />

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

  /* Styles for the empty message */
  #empty {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 200px;
    font-size: 20px;
    color: #888;
  }

  /* Styles for the winner podium */
  .winner-podium {
    display: flex;
    justify-content: center;
    align-items: flex-end; /* Align items to the bottom */
    margin-bottom: 20px;
    height: 250px; /* Adjust the height as needed */
  }

  .winner-podium__place {
    width: 100px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
    margin: 0 10px;
    height: 60%; /* Set the height to a percentage of the podium container */
  }
  
  .winner-podium__place--gold {
    background-color: gold;
    width: 150px;
    height: 100%; /* Adjust the height to be higher than the other podiums */
  }

  .winner-podium__place--silver {
    width: 150px;
    background-color: silver;
    height: 80%;
  }

  .winner-podium__place--bronze {
    background-color: #cd7f32;
    width: 150px;
    height: 60%;
  }

  .winner-podium__place-number {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 10px;
  }

  .winner-podium__place-name {
    font-size: 18px;
    text-align: center;
  }
  
</style>
</head>
<body>

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
  echo "<div id='empty' style='display: none;'></div>";

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
   
    // Query the participants table for this competition
    $participants_sql = "SELECT * FROM participants WHERE competition_id = '$competition_id'";
    $participants_result = $conn->query($participants_sql);

    // Generate HTML code for the scores rows
    $participants = array();
    while ($participant_row = $participants_result->fetch_assoc()) {
      $participant_name = $participant_row["participant_name"];
      $organization_id = $participant_row["organization_id"];
      $participant_id = $participant_row["participants_id"];

      // Query the organization table to get the organization name
      $org_sql = "SELECT organization_name FROM organization WHERE organization_id = '$organization_id'";
      $org_result = $conn->query($org_sql);
      $organization_name = $org_result->fetch_assoc()["organization_name"];

      $total_score = 0;

      // Loop through each criterion to get the scores for this participant
      $criteria_result->data_seek(0);
      while ($criterion_row = $criteria_result->fetch_assoc()) {
        $criterion_id = $criterion_row["criterion_id"];

        // Query the criterion_scoring table to get the final score for this participant and criterion
        $score_sql = "SELECT criterion_final_score FROM criterion_scoring WHERE ongoing_criterion_id = '$criterion_id' AND participants_id = '$participant_id'";
        $score_result = $conn->query($score_sql);
        $final_score = $score_result->fetch_assoc()["criterion_final_score"];

        if ($final_score !== null) {
          $total_score += $final_score;
        }
      }

      $participants[] = array(
        'name' => $participant_name,
        'organization' => $organization_name,
        'score' => $total_score
      );
    }

    // Sort participants based on their scores in descending order
    usort($participants, function ($a, $b) {
      return $b['score'] - $a['score'];
    });

    // Generate HTML code for the winner podium
    
    echo "<div class='winner-podium'>";

    echo "<div class='winner-podium__place winner-podium__place--silver'>";
    if (isset($participants[1])) {
      $secondPlace = $participants[1];
      echo "<span class='winner-podium__place-number'>2</span>";
      echo "<span class='winner-podium__place-name'>" . $secondPlace['name'] . "</span>";
      echo "<span class='winner-podium__place-name'>" . $secondPlace['organization'] . "</span>";
    }
    echo "</div>";
    
    echo "<div class='winner-podium__place winner-podium__place--gold'>";
    if (isset($participants[0])) {
      $firstPlace = $participants[0];
      echo "<span class='winner-podium__place-number'>1</span>";
      echo "<span class='winner-podium__place-name'>" . $firstPlace['name'] . "</span>";
      echo "<span class='winner-podium__place-name'>" . $firstPlace['organization'] . "</span>";
    }
    echo "</div>";
    
    echo "<div class='winner-podium__place winner-podium__place--bronze'>";
    if (isset($participants[2])) {
      $thirdPlace = $participants[2];
      echo "<span class='winner-podium__place-number'>3</span>";
      echo "<span class='winner-podium__place-name'>" . $thirdPlace['name'] . "</span>";
      echo "<span class='winner-podium__place-name'>" . $thirdPlace['organization'] . "</span>";
    }
    echo "</div>";
    
    // Add the human figures on top of each podium
   
    

    echo "</div>";
  }
} else {
  // If there are no competitions, display a message
  echo "<div id='empty'>Event Result not found. </div>";
}

// Close connection
$conn->close();
?>
</body>
</html>