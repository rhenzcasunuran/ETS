<?php
// Create a MySQL connection
session_start();
  @include './database_connect.php';
  @include './TOU-scoring.php';
  @include './TOU-fetch-data.php';

// Unique identifier for the row
$rowId = 2; // Update this with the actual row identifier column name

// Retrieve the existing value for Team A from the database
$sql = "SELECT score1.team_score AS score_a, score2.team_score AS score_b FROM tou_bracket INNER JOIN tou_team_stat AS ts1 ON tou_bracket.team1_id = ts1.team_id INNER JOIN organization AS org1 ON ts1.organization_id = org1.organization_id INNER JOIN tou_team_stat AS ts2 ON tou_bracket.team2_id = ts2.team_id INNER JOIN organization AS org2 ON ts2.organization_id = org2.organization_id INNER JOIN tou_team AS score1 ON tou_bracket.team1_id = score1.team_id INNER JOIN tou_team AS score2 ON tou_bracket.team2_id = score2.team_id"; // Replace "id_column_name" with the actual column name for row identifiers
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$existingValueA = $row['score_a'];

$sql = "SELECT tou_bracket.team1_id, CONCAT(org1.organization_name, ' vs ', org2.organization_name) AS concatenated_organizations, tou_bracket.team2_id, tou_bracket.bracket_id, CONCAT( score1.team_score, ' - ', score2.team_score ) AS concatenated_scores, score1.team_score AS score_a, score2.team_score AS score_b FROM tou_bracket INNER JOIN tou_team_stat AS ts1 ON tou_bracket.team1_id = ts1.team_id INNER JOIN organization AS org1 ON ts1.organization_id = org1.organization_id INNER JOIN tou_team_stat AS ts2 ON tou_bracket.team2_id = ts2.team_id INNER JOIN organization AS org2 ON ts2.organization_id = org2.organization_id INNER JOIN tou_team AS score1 ON tou_bracket.team1_id = score1.team_id INNER JOIN tou_team AS score2 ON tou_bracket.team2_id = score2.team_id";



$result = $conn->query($sql);
// Array to store the concatenated results
$concatenatedResults = array();

if ($result->num_rows > 0) {
    // Fetch each row and store the concatenated result in the array
    while ($row = $result->fetch_assoc()) {
        $concatenatedResults[] = $row["concatenated_organizations"];
    }
}

// Process the form submission for Team A
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['updated_value_a'])) {
    $updatedValueA = $_POST['updated_value_a'];
    $newValueA = $existingValueA + $updatedValueA;

    // Ensure the value does not go below 0
    if ($newValueA < 0) {
      $newValueA = 0;
    }

    // Update the value in the database
    $sql = "UPDATE tou_team SET team_score = $newValueA WHERE team_score_id = $rowId";
    if ($conn->query($sql) === TRUE) {
      // Update the existing value for Team A
      $existingValueA = $newValueA;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}

// Retrieve the existing value for Team B from the database
$sql = "SELECT tou_bracket.team1_id, CONCAT(org1.organization_name, ' vs ', org2.organization_name) AS concatenated_organizations, tou_bracket.team2_id, tou_bracket.bracket_id, CONCAT( score1.team_score, ' - ', score2.team_score ) AS concatenated_scores, score1.team_score AS score_a, score2.team_score AS score_b FROM tou_bracket INNER JOIN tou_team_stat AS ts1 ON tou_bracket.team1_id = ts1.team_id INNER JOIN organization AS org1 ON ts1.organization_id = org1.organization_id INNER JOIN tou_team_stat AS ts2 ON tou_bracket.team2_id = ts2.team_id INNER JOIN organization AS org2 ON ts2.organization_id = org2.organization_id INNER JOIN tou_team AS score1 ON tou_bracket.team1_id = score1.team_id INNER JOIN tou_team AS score2 ON tou_bracket.team2_id = score2.team_id;";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$existingValueB = $row['score_b'];

// Process the form submission for Team B
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['updated_value_b'])) {
    $updatedValueB = $_POST['updated_value_b'];
    $newValueB = $existingValueB + $updatedValueB;

    // Ensure the value does not go below 0
    if ($newValueB < 0) {
      $newValueB = 0;
    }

    // Update the value in the database
    $sql = "UPDATE team_score SET team_id = $newValueA WHERE team_score_id = $rowId";
    if ($conn->query($sql) === TRUE) {
      // Update the existing value for Team B
      $existingValueB = $newValueB;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}
  // Query to retrieve data from the database
  $sql = "SELECT category_name FROM dropdown_options";
  $result = $conn->query($sql);


  $sql = "SELECT 
            tou_bracket.team1_id, 
            CONCAT(org1.organization_name, ' vs ', org2.organization_name) AS concatenated_organizations,
            tou_bracket.team2_id,
            tou_bracket.bracket_id,
            tou_team.team_score_id
        FROM 
            tou_bracket
        INNER JOIN 
            tou_team_stat AS ts1 ON tou_bracket.team1_id = ts1.team_id
        INNER JOIN 
            organization AS org1 ON ts1.organization_id = org1.organization_id
        INNER JOIN 
            tou_team_stat AS ts2 ON tou_bracket.team2_id = ts2.team_id
        INNER JOIN 
            organization AS org2 ON ts2.organization_id = org2.organization_id
        INNER JOIN 
            tou_team ON tou_team.team_id = ts1.team_id";

$result = $conn->query($sql);
$concatenatedResults = array();




if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
      $concatenatedResults[] = array(
          'concatenated_organizations' => $row["concatenated_organizations"],
          'bracket_id' => $row["bracket_id"],
          'team_score_id' => $row["team_score_id"]
      );
  }

  // Log the information to the error log
  foreach ($concatenatedResults as $result) {
      error_log("Concatenated Organizations: " . $result['concatenated_organizations']);
      error_log("Bracket ID: " . $result['bracket_id']);
      error_log("Team Score ID: " . $result['team_score_id']);
  }
}
if (isset($_POST['teamScoreId'])) {
  $bracketId = $_POST['teamScoreId'];

  // Prepare the SQL query to fetch the team scores based on the teamScoreId
  $query = "SELECT score1.team_score AS team_a_score, score2.team_score AS team_b_score
            FROM tou_bracket
            INNER JOIN tou_team AS score1 ON tou_bracket.team1_id = score1.team_id
            INNER JOIN tou_team AS score2 ON tou_bracket.team2_id = score2.team_id
            WHERE tou_bracket.bracket_id = $bracketId";

  // Execute the query
  $result = mysqli_query($connection, $query);

  // Check if the query was successful
  if ($result) {
      // Fetch the team scores from the result
      $row = mysqli_fetch_assoc($result);
      $teamAScore = $row['team_a_score'];
      $teamBScore = $row['team_b_score'];

      // Create an array to store the team scores
      $teamScores = array(
          'teamAScore' => $teamAScore,
          'teamBScore' => $teamBScore
      );

      // Convert the array to JSON and return it as the response
      echo json_encode($teamScores);
  } else {
      // Return an error message if the query fails
      echo 'Error occurred while fetching team scores.';
  }
} else {
  // Return an error message if the teamScoreId parameter is not provided
  echo 'teamScoreId parameter is missing.';
}

  
  // Close the database connection
  $conn->close();
  @include '/php/TOU-fetch-data.php';

  $teamAScore = 0; 
?>


<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuration</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="../css/theme-mode.css">
    <script src="../js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="../css/boxicons.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/sidebar-style.css">
    <link rel="stylesheet" href="../css/home-sidebar-style.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/TOU-live-score.css">
    <link rel="stylesheet" href="../css/system-wide.css">
  </head>

  <body>
    <div class="popup-background" id="EndMatchWrapper">
      <div class="row popup-container">
        <div class = "col-4">
          <i class="bx bxs-check-circle prompt-icon success-color"></i>
        </div>
        <div class="col-8 text-start text-container">
          <h3 class="text-header">End Match?</h3>
          <p>Ending Match will be irreversible</p>
        </div>
        <div class="div">
          <button class="outline-button" onclick="hideEndMatch()"><i class='bx bx-x'></i>Cancel</button>
          <button class="btn btn-danger btn-confirm content-box-shadow"><i class='bx bx-check'></i>Confirm</button>
        </div>
      </div>
    </div>

    <div class="popup-background" id="SaveScoreWrapper">
      <div class="row popup-container">
        <div class = "col-4">
          <i class="bx bxs-check-circle prompt-icon success-color"></i>
        </div>
        <div class="col-8 text-start text-container">
          <h3 class="text-header">Save Score?</h3>
          <p>Do you want to save the Score?</p>
        </div>
        <div class="div">
          <button class="outline-button" onclick="hideSaveScore()"><i class='bx bx-x'></i>Cancel</button>
          <button class="btn btn-danger btn-confirm content-box-shadow" type="submit" onclick="saveClick()"><i class='bx bx-check'></i>Confirm</button>
        </div>
      </div>
    </div>

  <div class="container-fluid" id="popup">
      <div class="row popup-card">
        <form method="post">
          <div class="row">
            <div class="col-11 admin-text">
              <p>
                Administrator
              </p>
            </div>
            <div class="col-1 close ">
              <i class='bx bx-x' onclick="hide()"></i>
            </div>
          </div>
          <div class="row">
            <input type="text" name="user_username" placeholder="Username" maxlength="20" required/>
          </div>
          <div class="row">
            <input type="password" name="user_password" placeholder="Password" maxlength="128" required/>
          </div>
          <div class="row justify-content-center">
            <button input type="submit" name="sign-in-button" class="sign-in-button">Sign In</button>
          </div>
        </form>
      </div>
    </div>
     
    <!--Sidebar-->
    <div class="sidebar open box-shadow">
      <div class="bottom-design">
        <div class="design1"></div>
        <div class="design2"></div>
      </div>
      <div class="logo_details">
        <img src="../pictures/logo.png" alt="student council logo" class="icon logo">
        <div class="logo_name">Events Tabulation System</div>
        <i class="bx bx-arrow-to-right" id="btn"></i>
        <script src="../js/sidebar-state.js"></script>
      </div>
      <div class="wrapper">
        <li class="nav-item top">
          <a href="../index.php">
            <i class="bx bx-home-alt"></i>
            <span class="link_name">Go Back</span>
          </a>
        </li>
        <div class="sidebar-content-container">
          <ul class="nav-list">
            <li class="nav-item">
              <a href="#posts">
                <i class="bx bx-news"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Posts
                  <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
              </a>
              <ul class="sub_list">
                <li class="sub-item">
                  <a href="../HOM-create-post.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Create Post</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="../HOM-draft-scheduled-post.php">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Draft & Scheduled Post</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="../HOM-manage-post.php">
                    <i class="bx bxs-circle sub-icon color-yellow"></i>
                    <span class="sub_link_name">Manage Post</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#event_menu" class="menu_btn">
                <i class="bx bx-calendar-edit"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Events
                  <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
              </a>
              <ul class="sub_list">
                <li class="sub-item">
                  <a href="../EVE-admin-list-of-events.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">List of Events</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="../EVE-admin-event-configuration.php">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Event Configuration</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="#criteria_config">
                    <i class="bx bxs-circle sub-icon color-yellow"></i>
                    <span class="sub_link_name">Criteria Configuration</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="menu_btn">
                <i class="bx bx-calendar"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Calendar
                  <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
              </a>
              <ul class="sub_list">
                <li class="sub-item">
                  <a href="../CAL-admin-overall.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Overview</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="../CAL-admin-logs.php">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Logs</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="../BAR-admin.php">
                <i class='bx bx-bar-chart-alt-2'></i>
                <span class="link_name">Overall Results</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#tournaments"  class="menu_btn active">
                <i class="bx bx-trophy"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Tournaments
                  <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
              </a>
              <ul class="sub_list">
              <li class="sub-item">
                <a href="../TOU-Create-Tournament.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Create Tournament</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="../TOU-Live-Scoring-Admin.php"   class="sub-active">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Live Scoring</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="../TOU-bracket-admin.php">
                    <i class="bx bxs-circle sub-icon color-yellow"></i>
                    <span class="sub_link_name">Manage Brackets</span>
                  </a>
                </li>
                
              </ul>
            </li>
            <li class="nav-item">
              <a href="#competition" class="menu_btn">
                <i class="bx bx-medal"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Competition
                  <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
              </a>
              <ul class="sub_list">
                <li class="sub-item">
                  <a href="../COM-manage_results_page.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Manage Results</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="../COM-tobepublished_page.php">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">To Publish</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="../COM-published_page.php">
                    <i class="bx bxs-circle sub-icon color-yellow"></i>
                    <span class="sub_link_name">Published Results</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="#archive">
                    <i class="bx bxs-circle sub-icon color-purple"></i>
                    <span class="sub_link_name">Archive</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#event_history" class="menu_btn">
                <i class="bx bx-history"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Event History
                  <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
              </a>
              <ul class="sub_list">
                <li class="sub-item">
                  <a href="../HIS-admin-ManageEvent.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Event Page</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="../HIS-admin-highlights.php">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Highlights Page</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="../P&J-admin-formPJ.php">
                <i class="bx bx-group"></i>
                <span class="link_name">Judges & <br> Participants</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!--Page Content-->
    <section class="home-section">
      <header class="header">Badminton Live Scoring</header>
      <div class="container">
        <div class="home">
            <h1 id="teamAName">TEAM A</h1>
            <button name="score_a" id="teamAScore" class="teamA"></button>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    
    <div class="operate">
      
      <button type="button" id="subScoreButtonThree">-3</button>
      <button type="button" id="subScoreButtonTwo">-2</button>
      <button type="button" id="subScoreButtonOne">-1</button>
      <button type="button" id="addScoreButtonOne">+1</button>
      <button type="button" id="addScoreButtonTwo">+2</button>
      <button type="button" id="addScoreButtonThree">+3</button>
    </div>
  </form>
        </div>
        <div class="dropdown-tournament">

        <form action="/action_page.php">
    <select id="sport" class="button-tournament">
      
    <option value="BADMINTON">BADMINTON</option>
    <option value="VOLLEYBALL">VOLLEYBALL</option>
        <option value="BASKETBALL">BASKETBALL</option>
        <option value="CHESS">CHESS</option>
        <option value="TOURNAMENT">TOURNAMENT</option>
    </select>
</form>
<p id="team-scores"></p>

<select id="tournament-select" class="button-tournament">
    <?php foreach ($concatenatedResults as $result): ?>
        <option value="<?php echo $result['bracket_id']; ?>" data-bracket-id="<?php echo $result['bracket_id']; ?>">
            <?php echo $result['concatenated_organizations']; ?>
        </option>
    <?php endforeach; ?>
    <option selected disabled>Select Match</option>
</select>

<script>
        // Get the dropdown element
        var dropdown = document.getElementById("sport");

        // Add an event listener to handle the selection change
        dropdown.addEventListener("change", function() {
            // Get the selected value
            var selectedValue = dropdown.value;

            // Redirect to a new page based on the selected value
            switch (selectedValue) {
                case "TOURNAMENT":
                    window.location.href = "../TOU-Live-Scoring-Admin.php";
                    break;
                case "BASKETBALL":
                    window.location.href = "./TOU-basketball.php";
                    break;
                case "CHESS":
                    window.location.href = "./TOU-chess.php";
                    break;
                case "VOLLEYBALL":
                    window.location.href = "./TOU-volleyball.php";
                    break;
                default:
                    // Do nothing or handle the default case
                    break;
            }
        });
    </script>
            <div class="quarter" >
                <h2>NO ONGOING<br> MATCH</h2>
            </div>
            <div>
            <button class="button-end-match" onclick="showEndMatch()">End Match</button>
      </div>
        </div>
        <div class="guest">
            <h1  id="teamBName">TEAM B</h1>
            <button name="score_b" id="teamBScore" class = "teamB"></button>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    
    <div class="operate">
    <button type="button" id="subScoreButtonThreeB">-3</button>
      <button type="button" id="subScoreButtonTwoB">-2</button>
      <button type="button" id="subScoreButtonOneB">-1</button>
      <button type="button" id="addScoreButtonOneB">+1</button>
      <button type="button" id="addScoreButtonTwoB">+2</button>
      <button type="button" id="addScoreButtonThreeB">+3</button>
    </div>
  </form>
        </div>
    </div>
    <div class="container-two">

        
        <p id="home--count" onclick="homeCount">TEAM A : </p>
        <p id="guest--count" onclick="guestCount">TEAM B : </p>
        <button type="submit" id="save--counter" class="save--btn" onclick="showSaveScore()" name="update_score_data">SAVE</button>
    </div>

    <script src="../js/index.js"></script>
    <script src="../js/tournament_type.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </section>
    <!-- Scripts -->
    <script src="../js/script.js"></script>
    <script src="../js/TOU-index.js"></script>
    <script src="../js/theme.js"></script>
    <script src="../js/jquery-3.6.4.js"></script>
    <script type="text/javascript" src="../js/TOU-popup.js"></script>
    <script type="text/javascript" src="../js/TOU-AJAX.js"></script>

    <script>
        function showAlert() {
            alert("Match Ended"); // Display the alert box with a message
        }
    </script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.button-tournament').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var teamAName = selectedOption.text().split(' vs ')[0]; // Get the name for Team A
        var teamBName = selectedOption.text().split(' vs ')[1]; // Get the name for Team B

        $('#teamAName').text(teamAName);
        $('#teamBName').text(teamBName);

        var bracketId = selectedOption.data('bracket-id');

        // Make an AJAX request to fetch the scores
        $.ajax({
            url: '../get_team_score.php', // Replace with the correct path to get_team_score.php
            method: 'POST',
            data: { teamScoreId: bracketId },
            success: function(response) {
                try {
                    var scores = JSON.parse(response);
                    var scoreA = scores.teamAScore;
                    var scoreB = scores.teamBScore;

                    $('#teamAScore').text(scoreA);
                    $('#teamBScore').text(scoreB);
                } catch (error) {
                    console.error(error);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

   
});
</script>
<script>
  
$('#addScoreButtonThree').on('click', function() {
    var scoreA = parseInt($('#teamAScore').text());
    var fixedValue = 3; // Change this to the desired fixed value

    // Add the fixed value to the scores
    scoreA += fixedValue;

    // Update the displayed scores
    $('#teamAScore').text(scoreA);

    var bracketId = parseInt($('#tournament-select option:selected').val());

    // Make an AJAX request to update the scores in the database
    $.ajax({
        url: '../update_team_score.php',
        method: 'POST',
        data: { teamScoreId: bracketId, teamAScore: scoreA},
        success: function(response) {
            console.log('Scores updated in the database.');
            console.log(bracketId);
            console.log('Team A Score:', scoreA);

            // Optionally, you can update other elements on the page based on the database response
            // For example, you can update the total score or display a success message

            // Assuming the response contains the updated total score
            var totalScore = parseInt(response.totalScore);
            $('#totalScore').text(totalScore);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });

    $('#addScoreButtonTwo').on('click', function() {
    var scoreA = parseInt($('#teamAScore').text());
    var fixedValue = 2; // Change this to the desired fixed value

    // Add the fixed value to the scores
    scoreA += fixedValue;

    // Update the displayed scores
    $('#teamAScore').text(scoreA);

    var bracketId = parseInt($('#tournament-select option:selected').val());

    // Make an AJAX request to update the scores in the database
    $.ajax({
        url: '../update_team_score.php',
        method: 'POST',
        data: { teamScoreId: bracketId, teamBScore: scoreB},
        success: function(response) {
            console.log('Scores updated in the database.');
            console.log(bracketId);
            console.log('Team A Score:', scoreA);

            // Optionally, you can update other elements on the page based on the database response
            // For example, you can update the total score or display a success message

            // Assuming the response contains the updated total score
            var totalScore = parseInt(response.totalScore);
            $('#totalScore').text(totalScore);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});

// Replicating for addScoreButtonOne
$(document).ready(function() {
    // Function to update the score in the database
    function updateScore(bracketId, teamScore, score) {
        $.ajax({
            url: '../update_team_score.php',
            method: 'POST',
            data: { teamScoreId: bracketId, [teamScore]: score },
            success: function(response) {
                console.log('Scores updated in the database.');
                console.log(bracketId);
                console.log(teamScore, 'Score:', score);

                // Optionally, you can update other elements on the page based on the database response
                // For example, you can update the total score or display a success message

                // Assuming the response contains the updated total score
                var totalScore = parseInt(response.totalScore);
                $('#totalScore').text(totalScore);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Event handler for +3 button for scoreA
    $('#addScoreButtonThree').on('click', function() {
        var scoreA = parseInt($('#teamAScore').text());
        var fixedValue = 3; // Change this to the desired fixed value

        // Add the fixed value to the scores
        scoreA += fixedValue;

        // Update the displayed scores
        $('#teamAScore').text(scoreA);

        var bracketId = parseInt($('#tournament-select option:selected').val());

        // Make an AJAX request to update the scores in the database
        updateScore(bracketId, 'teamAScore', scoreA);
    });

    // Event handler for +2 button for scoreA
    $('#addScoreButtonTwo').on('click', function() {
        var scoreA = parseInt($('#teamAScore').text());
        var fixedValue = 2; // Change this to the desired fixed value

        // Add the fixed value to the scores
        scoreA += fixedValue;

        // Update the displayed scores
        $('#teamAScore').text(scoreA);

        var bracketId = parseInt($('#tournament-select option:selected').val());

        // Make an AJAX request to update the scores in the database
        updateScore(bracketId, 'teamAScore', scoreA);
    });

    // Event handler for +1 button for scoreA
    $('#addScoreButtonOne').on('click', function() {
        var scoreA = parseInt($('#teamAScore').text());
        var fixedValue = 1; // Change this to the desired fixed value

        // Add the fixed value to the scores
        scoreA += fixedValue;

        // Update the displayed scores
        $('#teamAScore').text(scoreA);

        var bracketId = parseInt($('#tournament-select option:selected').val());

        // Make an AJAX request to update the scores in the database
        updateScore(bracketId, 'teamAScore', scoreA);
    });

    // Event handler for -3 button for scoreA
    $('#subScoreButtonThree').on('click', function() {
        var scoreA = parseInt($('#teamAScore').text());
        var fixedValue = 3; // Change this to the desired fixed value

        // Subtract the fixed value from the scores, but ensure it doesn't go below 0
        scoreA = Math.max(0, scoreA - fixedValue);

        // Update the displayed scores
        $('#teamAScore').text(scoreA);

        var bracketId = parseInt($('#tournament-select option:selected').val());

        // Make an AJAX request to update the scores in the database
        updateScore(bracketId, 'teamAScore', scoreA);
    });

    // Event handler for -2 button for scoreA
    $('#subScoreButtonTwo').on('click', function() {
        var scoreA = parseInt($('#teamAScore').text());
        var fixedValue = 2; // Change this to the desired fixed value

        // Subtract the fixed value from the scores, but ensure it doesn't go below 0
        scoreA = Math.max(0, scoreA - fixedValue);

        // Update the displayed scores
        $('#teamAScore').text(scoreA);

        var bracketId = parseInt($('#tournament-select option:selected').val());

        // Make an AJAX request to update the scores in the database
        updateScore(bracketId, 'teamAScore', scoreA);
    });

    // Event handler for -1 button for scoreA
    $('#subScoreButtonOne').on('click', function() {
        var scoreA = parseInt($('#teamAScore').text());
        var fixedValue = 1; // Change this to the desired fixed value

        // Subtract the fixed value from the scores, but ensure it doesn't go below 0
        scoreA = Math.max(0, scoreA - fixedValue);

        // Update the displayed scores
        $('#teamAScore').text(scoreA);

        var bracketId = parseInt($('#tournament-select option:selected').val());

        // Make an AJAX request to update the scores in the database
        updateScore(bracketId, 'teamAScore', scoreA);
    });
});


$('#addScoreButtonThreeB').on('click', function() {
    var scoreB = parseInt($('#teamBScore').text());
    var fixedValue = 3; // Change this to the desired fixed value

    // Add the fixed value to the scores
    scoreB += fixedValue;

    // Update the displayed scores
    $('#teamBScore').text(scoreB);

    var bracketId = parseInt($('#tournament-select option:selected').val());

    // Make an AJAX request to update the scores in the database
    $.ajax({
        url: '../update_team_score.php',
        method: 'POST',
        data: { teamScoreId: bracketId, teamBScore: scoreB },
        success: function(response) {
            console.log('Scores updated in the database.');
            console.log(bracketId);
            console.log('Team B Score:', scoreB);

            // Optionally, you can update other elements on the page based on the database response
            // For example, you can update the total score or display a success message

            // Assuming the response contains the updated total score
            var totalScore = parseInt(response.totalScore);
            $('#totalScore').text(totalScore);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});

$('#addScoreButtonTwoB').on('click', function() {
    var scoreB = parseInt($('#teamBScore').text());
    var fixedValue = 2; // Change this to the desired fixed value

    // Add the fixed value to the scores
    scoreB += fixedValue;

    // Update the displayed scores
    $('#teamBScore').text(scoreB);

    var bracketId = parseInt($('#tournament-select option:selected').val());

    // Make an AJAX request to update the scores in the database
    $.ajax({
        url: '../update_team_score.php',
        method: 'POST',
        data: { teamScoreId: bracketId, teamBScore: scoreB },
        success: function(response) {
            console.log('Scores updated in the database.');
            console.log(bracketId);
            console.log('Team B Score:', scoreB);

            // Optionally, you can update other elements on the page based on the database response
            // For example, you can update the total score or display a success message

            // Assuming the response contains the updated total score
            var totalScore = parseInt(response.totalScore);
            $('#totalScore').text(totalScore);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});

$('#addScoreButtonOneB').on('click', function() {
    var scoreB = parseInt($('#teamBScore').text());
    var fixedValue = 1; // Change this to the desired fixed value

    // Add the fixed value to the scores
    scoreB += fixedValue;

    // Update the displayed scores
    $('#teamBScore').text(scoreB);

    var bracketId = parseInt($('#tournament-select option:selected').val());

    // Make an AJAX request to update the scores in the database
    $.ajax({
        url: '../update_team_score.php',
        method: 'POST',
        data: { teamScoreId: bracketId, teamBScore: scoreB },
        success: function(response) {
            console.log('Scores updated in the database.');
            console.log(bracketId);
            console.log('Team B Score:', scoreB);

            // Optionally, you can update other elements on the page based on the database response
            // For example, you can update the total score or display a success message

            // Assuming the response contains the updated total score
            var totalScore = parseInt(response.totalScore);
            $('#totalScore').text(totalScore);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});

$('#subScoreButtonThreeB').on('click', function() {
    var scoreB = parseInt($('#teamBScore').text());
    var fixedValue = 3; // Change this to the desired fixed value

    // Subtract the fixed value from the scores
    scoreB = Math.max(0, scoreB - fixedValue);

    // Update the displayed scores
    $('#teamBScore').text(scoreB);

    var bracketId = parseInt($('#tournament-select option:selected').val());

    // Make an AJAX request to update the scores in the database
    $.ajax({
        url: '../update_team_score.php',
        method: 'POST',
        data: { teamScoreId: bracketId, teamBScore: scoreB },
        success: function(response) {
            console.log('Scores updated in the database.');
            console.log(bracketId);
            console.log('Team B Score:', scoreB);

            // Optionally, you can update other elements on the page based on the database response
            // For example, you can update the total score or display a success message

            // Assuming the response contains the updated total score
            var totalScore = parseInt(response.totalScore);
            $('#totalScore').text(totalScore);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});

$('#subScoreButtonTwoB').on('click', function() {
    var scoreB = parseInt($('#teamBScore').text());
    var fixedValue = 2; // Change this to the desired fixed value

    // Subtract the fixed value from the scores
    scoreB = Math.max(0, scoreB - fixedValue);

    // Update the displayed scores
    $('#teamBScore').text(scoreB);

    var bracketId = parseInt($('#tournament-select option:selected').val());

    // Make an AJAX request to update the scores in the database
    $.ajax({
        url: '../update_team_score.php',
        method: 'POST',
        data: { teamScoreId: bracketId, teamBScore: scoreB },
        success: function(response) {
            console.log('Scores updated in the database.');
            console.log(bracketId);
            console.log('Team B Score:', scoreB);

            // Optionally, you can update other elements on the page based on the database response
            // For example, you can update the total score or display a success message

            // Assuming the response contains the updated total score
            var totalScore = parseInt(response.totalScore);
            $('#totalScore').text(totalScore);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});

$('#subScoreButtonOneB').on('click', function() {
    var scoreB = parseInt($('#teamBScore').text());
    var fixedValue = 1; // Change this to the desired fixed value

    // Subtract the fixed value from the scores
    scoreB = Math.max(0, scoreB - fixedValue);

    // Update the displayed scores
    $('#teamBScore').text(scoreB);

    var bracketId = parseInt($('#tournament-select option:selected').val());

    // Make an AJAX request to update the scores in the database
    $.ajax({
        url: '../update_team_score.php',
        method: 'POST',
        data: { teamScoreId: bracketId, teamBScore: scoreB },
        success: function(response) {
            console.log('Scores updated in the database.');
            console.log(bracketId);
            console.log('Team B Score:', scoreB);

            // Optionally, you can update other elements on the page based on the database response
            // For example, you can update the total score or display a success message

            // Assuming the response contains the updated total score
            var totalScore = parseInt(response.totalScore);
            $('#totalScore').text(totalScore);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});
});
  </script>


<script>
  $(document).ready(function() {
    $('.button-tournament').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var bracketId = selectedOption.data('bracket-id');
        var teamId = selectedOption.data('team-id');
        console.log('Bracket ID:', bracketId);
        console.log('Team ID:', teamId);
    });
});
</script>

<script>
    // Get the <select> element by its ID
    var selectElement = document.getElementById('tournament-select');

    // Add an event listener for the 'change' event
    selectElement.addEventListener('change', function() {
        // Get the selected option
        var selectedOption = this.options[this.selectedIndex];

        // Get the team_score_id from the selected option's data attribute
        var bracketId = selectedOption.getAttribute('data-bracket-id');
        var teamScoreId = selectedOption.getAttribute('data-team-score-id');

        // Log the team_score_id
        console.log('Selected bracket_id:', bracketId );

        // You can perform any further actions with the team_score_id here
    });
</script>

    <script type="text/javascript">
      $('.menu_btn').click(function (e) {
        e.preventDefault();
        var $this = $(this).parent().find('.sub_list');
        $('.sub_list').not($this).slideUp(function () {
          var $icon = $(this).parent().find('.change-icon');
          $icon.removeClass('bx-chevron-down').addClass('bx-chevron-right');
        });

        $this.slideToggle(function () {
          var $icon = $(this).parent().find('.change-icon');
          $icon.toggleClass('bx-chevron-right bx-chevron-down')
        });
      });

      $(window).bind("resize", function () {
        if ($(this).width() < 500) {
          $('div').removeClass('open');
          closeBtn.classList.replace("bx-arrow-to-left", "bx-menu");
        }
        else if ($(this).width() > 500) {
          $('.sidebar').addClass('open');
          closeBtn.classList.replace("bx-menu", "bx-arrow-to-left");
        }
      }).trigger('resize');
    </script>
  </body>

</html>