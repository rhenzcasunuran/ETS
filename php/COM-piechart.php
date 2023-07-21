<?php
if (isset($_POST['competitionName'])) {
    $competitionName = $_POST['competitionName'];

    require 'database_connect.php';

    $competitionName = $conn->real_escape_string($competitionName);

    $sql = "SELECT event_id FROM ongoing_list_of_event WHERE category_name = '$competitionName'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Create a container for all competition data
        echo "<div class='piemodals'>";

        while ($row = $result->fetch_assoc()) {
            //Sheeesh

            $event_id = $row['event_id'];

            // Query the competitions table to get the competition_id
            $compIdSql = "SELECT competition_id FROM competition WHERE event_id = '$event_id'";
            $compIdResult = $conn->query($compIdSql);

            if ($compIdResult->num_rows > 0) {
                $compIdRow = $compIdResult->fetch_assoc();
                $competition_id = $compIdRow['competition_id'];

            // Query the ongoing_criterion table to get the criteria for this competition
            $criteria_sql = "SELECT * FROM ongoing_criterion WHERE event_id = '$event_id'";
            $criteria_result = $conn->query($criteria_sql);

            // Create a sub-array for each competition's data
            $competitionData = array(
                "header" => array(
                "competition_name" => $competitionName,
                "criterias" => array(),
                ),
                "participants" => array(),
            );

            // Store criteria names in the "header" sub-array
            while ($criterion_row = $criteria_result->fetch_assoc()) {
                $competitionData["header"]["criterias"][] = $criterion_row["criterion_name"];
            }

            // Query the participants table for this competition
            $participants_sql = "SELECT * FROM participants WHERE competition_id = '$competition_id'";
            $participants_result = $conn->query($participants_sql);

            // Store participant data in the "participants" sub-array
            while ($participant_row = $participants_result->fetch_assoc()) {
                $participant_name = $participant_row["participant_name"];
                $organization_id = $participant_row["organization_id"];
                $participant_id = $participant_row["participants_id"];

                // Query the organization table to get the organization name
                $org_sql = "SELECT organization_name FROM organization WHERE organization_id = '$organization_id'";
                $org_result = $conn->query($org_sql);
                $organization_name = $org_result->fetch_assoc()["organization_name"];

                $participantData = array(
                "participant_name" => $participant_name,
                    "organization" => $organization_name,
                    "scores" => array(),
                    "overall_score" => 0,
                );

                // Loop through each criterion to get the scores for this participant
                $criteria_result->data_seek(0);
                $total_score = 0;

                while ($criterion_row = $criteria_result->fetch_assoc()) {
                    $criterion_id = $criterion_row["ongoing_criterion_id"];

                    // Query the criterion_scoring table to get the final score for this participant and criterion
                    $score_sql = "SELECT criterion_final_score FROM criterion_scoring WHERE ongoing_criterion_id = '$criterion_id' AND participants_id = '$participant_id'";
                    echo "Score Query: $score_sql\n";
                    $score_result = $conn->query($score_sql);

                    if ($score_result) {
                        $final_score = $score_result->fetch_assoc()["criterion_final_score"];
                        // Convert the score to a float (number)
                        $final_score = floatval($final_score); // or $final_score = doubleval($final_score);
                        
                        echo "Final Score: $final_score\n";
                        echo "console.log('final score:'+ $final_score);";
                    } else {
                        echo "Error fetching scores: " . $conn->error . "\n";
                    }

                    if ($final_score !== null) {
                        $total_score += $final_score;
                        $participantData["scores"][] = $final_score;
                    } else {
                        $participantData["scores"][] = null;
                    }
                }

                $participantData["overall_score"] = $total_score;
                $competitionData["participants"][] = $participantData;
            }

        }
    }

    // Store the competition data in the main array
$dataArray[] = $competitionData;

// Extract the scores only into a separate array
$scoresArray = array_map(function ($participant) {
    return $participant['scores'];
}, $competitionData['participants']);

// Convert the PHP arrays into JSON strings
$dataArrayJson = json_encode($dataArray);
$scoresArrayJson = json_encode($scoresArray);

// Use JavaScript to log the contents of the arrays in the console
echo "<script type='text/javascript'>\n";
echo "    var dataArray = $dataArrayJson;\n";
echo "    var scoresArray = $scoresArrayJson;\n";
echo "    console.log('This is the inside of the dataArray:');\n";
echo "    console.log(dataArray);\n";
echo "    console.log('This is the scoresArray:');\n";
echo "    console.log(scoresArray);\n";
echo "</script>";

} 
if (empty($dataArray)) {
    // No results found for the given competitionName
    echo "<div class='piemodal'>No results found for the competition: $competitionName</div>";
} else {
    // Display the pie chart and buttons
    // For some reason, this query manages to cause an error in the code. So it is not included for the time being.
    //$eventNameQuery = "SELECT event_name FROM ongoing_event_name WHERE ongoing_event_id = (SELECT ongoing_event_id FROM ongoing_list_of_event WHERE category_name = $competitionName)";
    //$eventName = $conn->query($eventNameQuery);
    echo <<<HTML
<div id="pieChartModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">$eventName $competitionName</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="criteria-organization-container">
                    <div class="criteria-buttons">
                        <!-- Criteria buttons will be placed here on the left side -->
                    </div>
                </div>
                <div class="pie-chart-container">
                    <canvas id="pieChartCanvas" width="400" height="400"></canvas>
                </div>
                <div class="organization-list">
                        <!-- Organization names and colored circles will be placed here on the bottom right -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
HTML;

}
}
?>