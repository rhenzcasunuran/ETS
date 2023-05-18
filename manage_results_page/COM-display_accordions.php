<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pupets";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get the current date and time
$currentDateTime = date("Y-m-d H:i:s");

// Query the competitions table with the condition for schedule
$sql = "SELECT * FROM competitions_table WHERE schedule <= '$currentDateTime'";
$result = $conn->query($sql);

// If there are competitions, generate HTML code for each of them
if ($result->num_rows > 0) {
    ?> <script type="text/javascript">document.getElementById('empty').remove();</script>
    <?php
    while($row = $result->fetch_assoc()) {
        $competition_id = $row["competition_id"];
        $competition_name = $row["competition_name"];

        // Query the scores table for this competition and participant with descending order by overall_score
        $sql_scores = "SELECT participants_table.participant_name, participants_table.organization, overall_scores_table.overall_score
                       FROM scores_table
                       INNER JOIN participants_table ON scores_table.participant_id = participants_table.participant_id
                       INNER JOIN overall_scores_table ON scores_table.participant_id = overall_scores_table.participant_id AND scores_table.competition_id = overall_scores_table.competition_id
                       WHERE scores_table.competition_id = " . $competition_id . "
                       GROUP BY participants_table.participant_name
                       ORDER BY overall_scores_table.overall_score DESC";
        $result_scores = $conn->query($sql_scores);

        $top1_row = $result_scores->fetch_assoc();
        $top2_row = $result_scores->fetch_assoc();
        $top3_row = $result_scores->fetch_assoc();

        echo "<div class='draggableDiv' draggable='true'>";
        echo "<button id='" . $competition_name . "' class='accordion'>";
        echo $competition_name . "<br>";

        // Top 2
        echo "<div id='top3Container' class='top3Container'>";
        echo "<div class='leftContainer'>";
        echo "<div style='aspect-ratio: 1/1;'>";
        echo "<div class='logoContainer silver'></div>";
        echo "</div>";
        echo "<div class='diamondContainer second'>";
        echo "<h4 class='diamondText'>2nd</h4>";
        echo "</div>";
        echo "<p class='winnerDetails'>" . $top2_row["participant_name"] . " " . $top2_row["overall_score"] . "</p>";
        echo "</div>";

        // Top 1
        echo "<div class='middleContainer'>";
        echo "<div style='aspect-ratio: 1/1;'>";
        echo "<div class='logoContainer gold'></div>";
        echo "</div>";
        echo "<div class='diamondContainer first'>";
        echo "<h4 class='diamondText'>1st</h4>";
        echo "</div>";
        echo "<p class='winnerDetails'>" . $top1_row["participant_name"] . "<br>" . $top1_row["overall_score"] . "</p>";
        echo "</div>";

        // Top 3
        echo "<div class='rightContainer'>";
        echo "<div style='aspect-ratio: 1/1;'>";
        echo "<div class='logoContainer bronze'></div>";
        echo "</div>";
        echo "<div class='diamondContainer third'>";
        echo "<h4 class='diamondText'>3rd</h4>";
        echo "</div>";
        echo "<p class='winnerDetails'>" . $top3_row["participant_name"] . " " . $top3_row["overall_score"] . "</p>";
        echo "</div>";
        echo "</div>";
        echo "</button>";
        echo "<div class='content'>";
        // Fetch the remaining rows starting from the 4th row in descending order
        $counter = 4;
        while($row_scores = $result_scores->fetch_assoc()) {
            $organization = $row_scores["organization"];
            $rowStyle = '';
        
            if ($organization === 'ACAP') {
                $rowStyle = 'background-color: var(--color-acap);';
            } elseif ($organization === 'AECES') {
                $rowStyle = 'background-color: var(--color-aeces);';
            } elseif ($organization === 'ELITE') {
                $rowStyle = 'background-color: var(--color-elite);';
            } elseif ($organization === 'GIVE') {
                $rowStyle = 'background-color: var(--color-give);';
            } elseif ($organization === 'JEHRA') {
                $rowStyle = 'background-color: var(--color-jehra);';
            } elseif ($organization === 'JMAP') {
                $rowStyle = 'background-color: var(--color-jmap);';
            } elseif ($organization === 'JPIA') {
                $rowStyle = 'background-color: var(--color-jpia);';
            } elseif ($organization === 'PIIE') {
                $rowStyle = 'background-color: var(--color-piie);';
            }
        echo "<div>";
        echo "<table>";
        echo "<tr>";
        echo "<td class='diamond'><div class='diamondContainer smallDiamond'><div class='place'>" . $counter . "th</div></div></td>";
        echo "<td class='name' style='$rowStyle'>" . $row_scores["participant_name"] . "</td>";
        echo "<td class='org' style='$rowStyle'>" . $row_scores["organization"] . "</td>";
        echo "<td class='percent' style='$rowStyle'>" . $row_scores["overall_score"] . "</td>";
        echo "</tr>";
        echo "</table>";
        echo "</div>";
        $counter++;
        }
        echo "<button class='resultsBtn'>See overall results details</button>";
        echo "</div>";
        echo "</div>";
    }
}
// Close connection
$conn->close();
?>    
