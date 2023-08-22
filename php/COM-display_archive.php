<?php
require 'database_connect.php';

// Get the current date and time
$currentDate = date("Y-m-d");
$currentTime = date("H:i:s");

// Query schedule_end in competition
$sql = "SELECT * FROM competition WHERE schedule_end < CONCAT('$currentDate', ' ', '$currentTime')";
$result = $conn->query($sql);

// Set is_archived to 1 for the matching rows
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['competition_id'];

        // Update is_archived to 1
        $update_sql = "UPDATE competition SET is_archived = 1 WHERE id = $id";
        $conn->query($update_sql);
    }
} else {
    //nothing
}


// Query the competitions table
$sql = "SELECT * FROM competition WHERE is_archived='1'";
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
        // Display the name of the competition and a button with the competition ID as the ID
        echo "<h2 class='parent' id='" . $competitionName ."'>" . $competitionName . "<br><input type='text' name='datetimes' placeholder='No schedule yet...' id='".$competitionName."-input' class='sched_output' disabled/><button class='republished_btn' id='" . $competitionName . " btn'><i class='bx bx-repost' style='font-size:20px;'  ></i>Republish</button></h2>";

        // Generate HTML code for the result div and table
        echo "<div class='result'>";
        echo "<table>";
        echo "<tbody class='responsive-table'>";

        // Query the participants table for this competition
        $participants_sql = "SELECT * FROM participants WHERE competition_id = '$competition_id'";
        $participants_result = $conn->query($participants_sql);

        $processed_group_ids = []; // Keep track of processed group IDs

        while ($participant_row = $participants_result->fetch_assoc()) {
            $participant_id = $participant_row["participants_id"];
            $participant_name = $participant_row["participant_name"];
            $organization_id = $participant_row["organization_id"];
            $is_grouped = $participant_row["is_Grouped"];
            $group_id = $participant_row["organization_id"]; // Assuming you have a group_id column
            
            // Check if this group has already been processed
            if ($is_grouped && in_array($group_id, $processed_group_ids)) {
                continue; // Skip displaying scores for this group
            }
            
            // Mark this group as processed
            if ($is_grouped) {
                $processed_group_ids[] = $group_id;
            }
            
            // Query the organization table to get the organization name
            $org_sql = "SELECT organization_name FROM organization WHERE organization_id = '$organization_id'";
            $org_result = $conn->query($org_sql);
            $organization_name = $org_result->fetch_assoc()["organization_name"];
        
            // Display participant name(s) and organization
            echo "<table class='participant-table'><tbody class='responsive-table2'>";
            echo "<tr id='participant-header' class=" .$organization_name. "-header><th colspan='100%' class='participant-name'>";
        
            if ($is_grouped == 1) {
                // Grouped participants, get all participants' names in the group
                $grouped_participants_sql = "SELECT participant_name FROM participants WHERE organization_id = '$organization_id' AND is_Grouped = 1";
                $grouped_participants_result = $conn->query($grouped_participants_sql);
                $grouped_participant_names = [];
        
                while ($grouped_participant_row = $grouped_participants_result->fetch_assoc()) {
                    $grouped_participant_names[] = $grouped_participant_row["participant_name"];
                }
        
                echo "Names: " . implode(", ", $grouped_participant_names);
            } else {
                // Individual participant
                echo "Name: " . $participant_name;
            }
        
            echo "<br>Organization: " . $organization_name . "</th></tr>";
        
            // Display the header row for criteria
            echo "<tr class='scores-header'><th>Judges</th>";
            $criteria_result->data_seek(0); // Reset the criteria_result position
        
            while ($criterion_row = $criteria_result->fetch_assoc()) {
                echo "<th>" . $criterion_row["criterion_name"] . ": ". $criterion_row["criterion_percent"] ."%</th>";
            }
            echo "<th>Final Score</th></tr>";
        
            $judges_sql = "SELECT * FROM judges WHERE competition_id = '$competition_id'";
            $judges_result = $conn->query($judges_sql);
            $participant_total_score = 0;
        
            // Set default values for variables dependent on judge-related information
            $total_judges = 0;
        
            $participant_criterion_scores = [];
        
            // Check if judges_result is null
            if ($judges_result !== null && $judges_result->num_rows > 0) {
                // Get the total number of judges for this competition
                $total_judges = $judges_result->num_rows;
        
                // Loop through each judge
                while ($judge_row = $judges_result->fetch_assoc()) {
                    $judge_id = $judge_row["judge_id"];
                    $judge_name = $judge_row["judge_name"];
        
                    // Display judge's name
                    echo "<tr><th class='judge-header'>" . $judge_name . "</th>";

                // Initialize participant_total_score
                // Formula for scoring. ((criteria score[1]+criteria score[2]...[depending on number of judges])/number of judges) * weight 
                // Add all score for that criteria, divide it by the number of judges, then multiply it by its weight
                // For example, ((10+8)/2) * .50 = 4.5

                // Loop through each criterion to get the scores for this participant and judge
        $criteria_result->data_seek(0);
        $judge_total_score = 0;

        while ($criterion_row = $criteria_result->fetch_assoc()) {
                    $criterion_id = $criterion_row["ongoing_criterion_id"];

                    // Query the criterion_scoring table to get the final score for this participant, judge, and criterion
                    $score_sql = "SELECT criterion_final_score FROM criterion_scoring WHERE ongoing_criterion_id = '$criterion_id' AND participants_id = '$participant_id' AND judge_id = '$judge_id'";
                    $score_result = $conn->query($score_sql);

                    $criterion_score = 'No score'; // Default value

                    $score_row = $score_result->fetch_assoc();
                    if ($score_row !== null) {
                        $criterion_score = $score_row["criterion_final_score"];
                    }

                    $judge_total_score += ($criterion_score != 'No score') ? $criterion_score : 0;

                    echo "<td>" . (($criterion_score != 'no score') ? $criterion_score : 'No score') . "</td>";
                }

                // Display the judge's total score
                $participant_total_score += $judge_total_score;
                echo "<td id='judge-total-score'></td></tr>";
            }
        } else {
            // Create empty elements if there are no judges
            echo "<tr><th class='judge-header' style='color: red;'>NO JUDGE</th>";
            // Loop through each criterion and create empty <td> elements
            $criteria_result->data_seek(0);
            while ($criterion_row = $criteria_result->fetch_assoc()) {
                echo "<td></td>";
                // Initialize the criterion score for each criterion
                $criterion_id = $criterion_row["ongoing_criterion_id"];
                $participant_criterion_scores[$criterion_id] = 0;
            }
            echo "<td></td></tr>";
        }
    
        // Check if there are judges before calculating and displaying "Calculated Score"
        if ($judges_result !== null && $judges_result->num_rows > 0) {
            // Calculate and display the participant's overall score
            echo "<tr><th>Calculated Score</th>";

// Reset the internal pointer of $judges_result to the beginning
$judges_result->data_seek(0);

        $total_judges = $judges_result->num_rows; // Total number of judges for this competition

        // Create an array to store criterion scores for the participant
        $participant_criterion_scores = [];

        $criteria_result->data_seek(0);
        while ($criterion_row = $criteria_result->fetch_assoc()) {
            $criterion_id = $criterion_row["ongoing_criterion_id"];
            $criterion_percent = $criterion_row["criterion_percent"];

            // Calculate the total score for this criterion for the participant
            $criterion_total_score = 0;

                $judges_result->data_seek(0);
                while ($judge_row = $judges_result->fetch_assoc()) {
                    $judge_id = $judge_row["judge_id"];

                    $score_sql = "SELECT criterion_final_score FROM criterion_scoring WHERE ongoing_criterion_id = '$criterion_id' AND participants_id = '$participant_id' AND judge_id = '$judge_id'";
                    $score_result = $conn->query($score_sql);

                    $score_row = $score_result->fetch_assoc();
                    if ($score_row !== null && $score_row["criterion_final_score"] != 'No score') {
                        $criterion_total_score += $score_row["criterion_final_score"];
                    }
                }

                // Calculate the criterion score for this participant and judge
                $criterion_score = number_format(($criterion_total_score / $total_judges) * ($criterion_percent / 100), 2);
                $participant_criterion_scores[$criterion_id] = $criterion_score;

                // Display the criterion score for this participant and judge
               echo "<td>" . (($criterion_score != 0) ? $criterion_score : 'No score') . "</td>";
            }

            // Display the participant's overall score
            $participant_final_score = array_sum($participant_criterion_scores);

            // Update the final_score in the participants table
            $update_final_score_sql = "UPDATE participants SET final_score = '$participant_final_score' WHERE participants_id = '$participant_id'";
            $conn->query($update_final_score_sql);
            echo "<td id='participant-overall-score'>" . $participant_final_score . "</td></tr>";

            // Close the participant table
            echo "</tbody></table>";

        }
    }

        // Close the main table for this competition
        echo "</tbody></table></div>";
        echo "</div>";
    }
} else {
    // If there are no competitions, display a message
    ?>
    <script>
        var empty = document.getElementById('empty');
        var searchbar = document.querySelector('.inputAndDeleteDiv');
        var pagini = document.querySelector('.paginations');
        empty.style.display = 'flex';
        searchbar.style.display = 'none';
        pagini.style.display = 'none';
    </script>
    <?php
}

// Close connection
$conn->close();
?>
