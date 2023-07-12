<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Manila');
require 'database_connect.php';

// Get the current date and time
$currentDateTime = date("Y-m-d H:i:s");

// Query the competitions table with the condition for schedule
$sql = "SELECT * FROM competition WHERE schedule <= '$currentDateTime' AND is_archived ='0'";
$result = $conn->query($sql);

// If there are competitions, generate HTML code for each of them
if ($result->num_rows > 0) {
    ?> <script type="text/javascript">document.getElementById('empty').remove();
    document.getElementById('search').style.display = 'block';</script>
    <?php
    while ($row = $result->fetch_assoc()) {
        $competitionNameQuery = "SELECT category_name FROM category_name WHERE category_name_id =" . $row["category_name_id"];
        $competitionNameResult = $conn->query($competitionNameQuery);

        if ($competitionNameResult->num_rows > 0) {
            $competitionNameRow = $competitionNameResult->fetch_assoc();
            $competition_name = $competitionNameRow["category_name"];
        } else {
            $competition_name = "Unknown";
        }

        $category_name_id = $row["category_name_id"];

        // Calculate total scores for each participant with category_name_id = 2
        $sql_scores = "SELECT participants.participant_name, criterion_scoring.participants_id, SUM(criterion_scoring.criterion_final_score) AS total_score
                       FROM criterion_scoring
                       INNER JOIN participants ON criterion_scoring.participants_id = participants.participants_id
                       WHERE criterion_scoring.category_name_id = $category_name_id
                       GROUP BY criterion_scoring.participants_id
                       ORDER BY total_score DESC";

        $result_scores = $conn->query($sql_scores);

        $top1_row = $result_scores->fetch_assoc();
        $top2_row = $result_scores->fetch_assoc();
        $top3_row = $result_scores->fetch_assoc();

        $participant_id1 = $top1_row["participants_id"];
        $participant_id2 = $top2_row["participants_id"];
        $participant_id3 = $top3_row["participants_id"];

        $logo1 = '';
        $logo2 = '';
        $logo3 = '';

        // Query the organization table for the organization name (top 1)
        $organizationQuery1 = "SELECT organization_name FROM organization WHERE organization_id IN (SELECT organization_id FROM participants WHERE participants_id = $participant_id1)";
        $organizationResult1 = $conn->query($organizationQuery1);

        if ($organizationResult1->num_rows > 0) {
            $organizationRow1 = $organizationResult1->fetch_assoc();
            $org1 = $organizationRow1["organization_name"];
        } else {
            $org1 = "Unknown";
        }

        // Query the organization table for the organization name (top 2)
        $organizationQuery2 = "SELECT organization_name FROM organization WHERE organization_id IN (SELECT organization_id FROM participants WHERE participants_id = $participant_id2)";
        $organizationResult2 = $conn->query($organizationQuery2);

        if ($organizationResult2->num_rows > 0) {
            $organizationRow2 = $organizationResult2->fetch_assoc();
            $org2 = $organizationRow2["organization_name"];
        } else {
            $org2 = "Unknown";
        }

        // Query the organization table for the organization name (top 3)
        $organizationQuery3 = "SELECT organization_name FROM organization WHERE organization_id IN (SELECT organization_id FROM participants WHERE participants_id = $participant_id3)";
        $organizationResult3 = $conn->query($organizationQuery3);

        if ($organizationResult3->num_rows > 0) {
            $organizationRow3 = $organizationResult3->fetch_assoc();
            $org3 = $organizationRow3["organization_name"];
        } else {
            $org3 = "Unknown";
        }

        // Set the logo path based on organization
        if ($org1 === 'ACAP') {
            $logo1 = './photos/ACAP.png';
        } elseif ($org1 === 'AECES') {
            $logo1 = './photos/AECES.png';
        } elseif ($org1 === 'ELITE') {
            $logo1 = './photos/ELITE.png';
        } elseif ($org1 === 'GIVE') {
            $logo1 = './photos/GIVE.png';
        } elseif ($org1 === 'JEHRA') {
            $logo1 = './photos/JEHRA.png';
        } elseif ($org1 === 'JMAP') {
            $logo1 = './photos/JMAP.png';
        } elseif ($org1 === 'JPIA') {
            $logo1 = './photos/JPIA.png';
        } elseif ($org1 === 'PIIE') {
            $logo1 = './photos/PIIE.png';
        } else {
            $logo1 = './pictures/org_logos.png';
        }

        if ($org2 === 'ACAP') {
            $logo2 = './photos/ACAP.png';
        } elseif ($org2 === 'AECES') {
            $logo2 = './photos/AECES.png';
        } elseif ($org2 === 'ELITE') {
            $logo2 = './photos/ELITE.png';
        } elseif ($org2 === 'GIVE') {
            $logo2 = './photos/GIVE.png';
        } elseif ($org2 === 'JEHRA') {
            $logo2 = './photos/JEHRA.png';
        } elseif ($org2 === 'JMAP') {
            $logo2 = './photos/JMAP.png';
        } elseif ($org2 === 'JPIA') {
            $logo2 = './photos/JPIA.png';
        } elseif ($org2 === 'PIIE') {
            $logo2 = './photos/PIIE.png';
        } else {
            $logo2 = './pictures/org_logos.png';
        }

        if ($org3 === 'ACAP') {
            $logo3 = './photos/ACAP.png';
        } elseif ($org3 === 'AECES') {
            $logo3 = './photos/AECES.png';
        } elseif ($org3 === 'ELITE') {
            $logo3 = './photos/ELITE.png';
        } elseif ($org3 === 'GIVE') {
            $logo3 = './photos/GIVE.png';
        } elseif ($org3 === 'JEHRA') {
            $logo3 = './photos/JEHRA.png';
        } elseif ($org3 === 'JMAP') {
            $logo3 = './photos/JMAP.png';
        } elseif ($org3 === 'JPIA') {
            $logo3 = './photos/JPIA.png';
        } elseif ($org3 === 'PIIE') {
            $logo3 = './photos/PIIE.png';
        } else {
            $logo3 = './pictures/org_logos.png';
        }

        echo "<div class='draggableDiv' draggable='true'>";
        echo "<button id='" . $competition_name . "' class='accordion'>";
        echo $competition_name . "<br>";

        // Top 2
        echo "<div id='top3Container' class='top3Container'>";
        echo "<div class='leftContainer'>";
        echo "<div style='aspect-ratio: 1/1;'>";
        echo "<div class='logoContainer silver'><img src='" . $logo2 . "' class='topLogo'></div>";
        echo "</div>";
        echo "<div class='diamondContainer second'>";
        echo "<h4 class='diamondText'>2nd</h4>";
        echo "</div>";
        echo "<p class='winnerDetails'>" . $top2_row["participant_name"] . "<br>" . $top2_row["total_score"] . "</p>";
        echo "</div>";

        // Top 1
        echo "<div class='middleContainer'>";
        echo "<div style='aspect-ratio: 1/1;'>";
        echo "<div class='logoContainer gold'><img src='" . $logo1 . "' class='topLogo'></div>";
        echo "</div>";
        echo "<div class='diamondContainer first'>";
        echo "<h4 class='diamondText'>1st</h4>";
        echo "</div>";
        echo "<p class='winnerDetails'>" . $top1_row["participant_name"] . "<br>" . $top1_row["total_score"] . "</p>";
        echo "</div>";

        // Top 3
        echo "<div class='rightContainer'>";
        echo "<div style='aspect-ratio: 1/1;'>";
        echo "<div class='logoContainer bronze'><img src='" . $logo3 . "' class='topLogo'></div>";
        echo "</div>";
        echo "<div class='diamondContainer third'>";
        echo "<h4 class='diamondText'>3rd</h4>";
        echo "</div>";
        echo "<p class='winnerDetails'>" . $top3_row["participant_name"] . "<br>" . $top3_row["total_score"] . "</p>";
        echo "</div>";
        echo "</div>";
        echo "</button>";
        echo "<div class='content'>";

        // Fetch the remaining rows starting from the 4th row in descending order
        $counter = 4;
        while ($row_scores = $result_scores->fetch_assoc()) {
            $participant_id = $row_scores["participants_id"];
            $rowStyle = '';

            // Query the organization table for the organization name
            $organizationQuery = "SELECT organization_name FROM organization WHERE organization_id IN (SELECT organization_id FROM participants WHERE participants_id = $participant_id)";
            $organizationResult = $conn->query($organizationQuery);

            if ($organizationResult->num_rows > 0) {
                $organizationRow = $organizationResult->fetch_assoc();
                $organization_name = $organizationRow["organization_name"];
            } else {
                $organization_name = "Unknown";
            }

            $rowStyle = '';

            if ($organization_name === 'ACAP') {
                $rowStyle = 'background-color: var(--color-acap);';
            } elseif ($organization_name === 'AECES') {
                $rowStyle = 'background-color: var(--color-aeces);';
            } elseif ($organization_name === 'ELITE') {
                $rowStyle = 'background-color: var(--color-elite);';
            } elseif ($organization_name === 'GIVE') {
                $rowStyle = 'background-color: var(--color-give);';
            } elseif ($organization_name === 'JEHRA') {
                $rowStyle = 'background-color: var(--color-jehra);';
            } elseif ($organization_name === 'JMAP') {
                $rowStyle = 'background-color: var(--color-jmap);';
            } elseif ($organization_name === 'JPIA') {
                $rowStyle = 'background-color: var(--color-jpia);';
            } elseif ($organization_name === 'PIIE') {
                $rowStyle = 'background-color: var(--color-piie);';
            }

            echo "<div>";
            echo "<table>";
            echo "<tr>";
            echo "<td class='diamond'><div class='diamondContainer smallDiamond'><div class='place'>" . $counter . "th</div></div></td>";
            echo "<td class='name' style='$rowStyle'>" . $row_scores["participant_name"] . "</td>";
            echo "<td class='org' style='$rowStyle'>" . $organization_name . "</td>";
            echo "<td class='percent' style='$rowStyle'>" . $row_scores["total_score"] . "</td>";
            echo "</tr>";
            echo "</table>";
            echo "</div>";
            $counter++;
        }
        echo "<button class='resultsBtn'>See overall results details</button>";
        echo "</div>";
        echo "</div>";
    }
} else {
    ?><script>
      var empty = document.getElementById('empty');
      var searchbar = document.querySelector('.inputAndDeleteDiv');
      empty.style.display = 'flex';
      searchbar.style.display = 'none';
    </script><?php
}
// Close connection
$conn->close();
?>
