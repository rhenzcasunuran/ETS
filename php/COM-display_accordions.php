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
        $competitionNameQuery = "SELECT category_name FROM ongoing_list_of_event WHERE event_id =" . $row["event_id"];
        $competitionNameResult = $conn->query($competitionNameQuery);

        if ($competitionNameResult->num_rows > 0) {
            $competitionNameRow = $competitionNameResult->fetch_assoc();
            $competition_name = $competitionNameRow["category_name"];
        } else {
            $competition_name = "Unknown";
        }

        $event_id = $row["event_id"];
        // NEWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWWw
        // Query to retrieve participants' final scores for the given event_id
        $sql_scores = "SELECT p.participant_name, p.participants_id, p.final_score AS total_score, p.is_Grouped
        FROM participants AS p
        INNER JOIN competition AS c ON p.competition_id = c.competition_id
        WHERE c.event_id = $event_id
        ORDER BY total_score DESC";

$result_scores = $conn->query($sql_scores);

// Fetch the top 3 rows separately
$top1_row = $result_scores->fetch_assoc();
$top2_row = $result_scores->fetch_assoc();
$top3_row = $result_scores->fetch_assoc();

// Initialize participant IDs with default values
$participant_id1 = 'None';
$participant_id2 = 'None';
$participant_id3 = 'None';

// Check if the fetched rows are not null and set participant IDs accordingly
if ($top1_row !== null) {
    $participant_id1 = $top1_row["participants_id"];
}

if ($top2_row !== null) {
    $participant_id2 = $top2_row["participants_id"];
}

if ($top3_row !== null) {
    $participant_id3 = $top3_row["participants_id"];
}

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

        // Dito maglagay ng error handling
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
        } elseif ($org1 === 'SC') {
            $logo1 = './photos/SC.png';
        } elseif ($org1 === 'Unknown'){
            $logo1 = 'None';
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
        } elseif ($org2 === 'SC') {
            $logo2 = './photos/SC.png';
        } elseif ($org2 === 'Unknown'){
            $logo2 = 'None';
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
        } elseif ($org3 === 'SC') {
            $logo3 = './photos/SC.png';
        } elseif ($org3 === 'Unknown'){
            $logo3 = 'None';
        } else {
            $logo3 = './pictures/org_logos.png';
        }

        echo "<div class='draggableDiv' draggable='true'>";
        echo "<button id='" . $competition_name . "' class='accordion'>";
        echo $competition_name . "<br>";
        echo "<div id='top3Container' class='top3Container'>";

        // Top 2
        echo "<div class='leftContainer'>";
        echo "<div style='aspect-ratio: 1/1;'>";
        if ($logo2 === 'Unknown') {
            echo "<div class='logoContainer silver'></div>";
            echo "</div>";
            echo "<div class='diamondContainer second'>";
            echo "<h4 class='diamondText'></h4>";
            echo "</div>";
            echo "<p class='winnerDetails'></p>";
        } else {
            echo "<div class='logoContainer silver'><img src='" . $logo2 . "' class='topLogo'></div>";
            echo "</div>";
            echo "<div class='diamondContainer second'>";
            echo "<h4 class='diamondText'>2nd</h4>";
            echo "</div>";

            // Display organization name or participant name based on grouping (Top 2)
            if ($top2_row["is_Grouped"] == 1) {
                echo "<p class='winnerDetails'>".$org2."<br>" . $top2_row["total_score"] . "%</p>";
            } else {
                echo "<p class='winnerDetails'>" . $top2_row["participant_name"] . "<br>" . $top2_row["total_score"] . "%</p>";
            }
        }
        
        echo "</div>";

        // Top 1
        echo "<div class='middleContainer'>";
        echo "<div style='aspect-ratio: 1/1;'>";
        echo "<div class='logoContainer gold'><img src='" . $logo1 . "' class='topLogo'></div>";
        echo "</div>";
        echo "<div class='diamondContainer first'>";
        echo "<h4 class='diamondText'>1st</h4>";
        echo "</div>";

        // Display organization name or participant name based on grouping (Top 1)
        if ($top1_row["is_Grouped"] == 1) {
            echo "<p class='winnerDetails'>".$org1."<br>" . $top1_row["total_score"] . "%</p>";
        } else {
            echo "<p class='winnerDetails'>" . $top1_row["participant_name"] . "<br>" . $top1_row["total_score"] . "%</p>";
        }

        echo "</div>";

        // Top 3
        echo "<div class='rightContainer'>";
        echo "<div style='aspect-ratio: 1/1;'>";
        if ($logo3 === 'Unknown') {
            echo "<div class='logoContainer bronze'></div>";
            echo "</div>";
            echo "<div class='diamondContainer third'>";
            echo "<h4 class='diamondText'></h4>";
            echo "</div>";
            echo "<p class='winnerDetails'></p>";
        } else {
            echo "<div class='logoContainer bronze'><img src='" . $logo3 . "' class='topLogo'></div>";
            echo "</div>";
            echo "<div class='diamondContainer third'>";
            echo "<h4 class='diamondText'>3rd</h4>";
            echo "</div>";

            // Display organization name or participant name based on grouping (Top 3)
            if ($top3_row["is_Grouped"] == 1) {
                echo "<p class='winnerDetails'>". $org3."<br>" . $top3_row["total_score"] . "%</p>";
            } else {
               echo "<p class='winnerDetails'>" . $top3_row["participant_name"] . "<br>" . $top3_row["total_score"] . "%</p>";
            }
        }
        
        echo "</div>";
        echo "</div>";
        echo "</button>";
        echo "<div id='".$competition_name."-content' class='content'>";

        // Fetch the organization names for all participants before the loop
        $organizationNames = array();
        $result_scores->data_seek(0); // Reset the result set pointer to the beginning
        while ($row_scores = $result_scores->fetch_assoc()) {
            $participant_id = $row_scores["participants_id"];
            $organizationQuery = "SELECT organization_name FROM organization WHERE organization_id IN (SELECT organization_id FROM participants WHERE participants_id = $participant_id)";
            $organizationResult = $conn->query($organizationQuery);

            if ($organizationResult->num_rows > 0) {
                $organizationRow = $organizationResult->fetch_assoc();
                $organization_name = $organizationRow["organization_name"];
            } else {
               $organization_name = "Unknown";
            }

            // Store the organization name in the array
            $organizationNames[$participant_id] = $organization_name;
        }

        // Fetch the remaining rows starting from the 4th row in descending order
        $counter = 1; // Initialize the counter
        $result_scores->data_seek(0); // Reset the result set pointer to the beginning
        $displayed_organizations = array(); // Array to store displayed organizations

        while ($row_scores = $result_scores->fetch_assoc()) {
            $participant_id = $row_scores["participants_id"];
            $organization_name = $organizationNames[$participant_id];
            $is_grouped = $row_scores["is_Grouped"]; // Check if participant is grouped
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

            // Set row style based on organization name
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

            if ($counter >= 4 && $is_grouped == 1 && !in_array($organization_name, $displayed_organizations)) {
                // Display only scores starting from the 4th in the ranking for grouped participants
                echo "<div class='rankRow'>";
                echo "<table class='rankTable'>";
                echo "<tr>";
                echo "<td class='diamond'><div class='diamondContainer smallDiamond'><div class='place'>" . $counter . "th</div></div></td>";
                echo "<td class='name' style='$rowStyle'></td>";
                echo "<td class='org' style='$rowStyle'>$organization_name</td>";
                echo "<td class='percent' style='$rowStyle'>" . $row_scores["total_score"] . "%</td>";
                echo "</tr>";
                echo "</table>";
                echo "</div>";

                // Add the displayed organization to the array
                $displayed_organizations[] = $organization_name;
            } elseif ($counter >= 4 && $is_grouped == 0) {
                // Display scores normally for non-grouped participants
                echo "<div class='rankRow'>";
                echo "<table class='rankTable'>";
                echo "<tr>";
                echo "<td class='diamond'><div class='diamondContainer smallDiamond'><div class='place'>" . $counter . "th</div></div></td>";
                echo "<td class='name' style='$rowStyle'>" . $row_scores["participant_name"] . "</td>";
                echo "<td class='org' style='$rowStyle'>$organization_name</td>";
                echo "<td class='percent' style='$rowStyle'>" . $row_scores["total_score"] . "%</td>";
                echo "</tr>";
                echo "</table>";
                echo "</div>";
            } elseif ($counter <= 3) {
                // Add the organization to the displayed organizations array even for top 3 participants
                $displayed_organizations[] = $organization_name;
            }

            $counter++;
        }
        echo "<button id='".$competition_name."-results-details' class='resultsBtn'>See overall results details</button>";
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