<?php
// Create a MySQL connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pupets";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Unique identifier for the row
$rowId = 5; // Update this with the actual row identifier column name

// Retrieve the existing value for Team A from the database
$sql = "SELECT scoring_team_a FROM scores WHERE score_id = '$rowId'"; // Replace "id_column_name" with the actual column name for row identifiers
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$existingValueA = $row['scoring_team_a'];

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
    $sql = "UPDATE scores SET scoring_team_a = $newValueA WHERE score_id = $rowId";
    if ($conn->query($sql) === TRUE) {
      // Update the existing value for Team A
      $existingValueA = $newValueA;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}

// Retrieve the existing value for Team B from the database
$sql = "SELECT scoring_team_b FROM scores WHERE score_id = $rowId";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$existingValueB = $row['scoring_team_b'];

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
    $sql = "UPDATE scores SET scoring_team_b = $newValueB WHERE score_id = $rowId";
    if ($conn->query($sql) === TRUE) {
      // Update the existing value for Team B
      $existingValueB = $newValueB;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}
  // Query to retrieve data from the database
  $sql = "SELECT bracket_id, bracket_sports FROM bracket";
  $result = $conn->query($sql);
  
  // Close the database connection
  $conn->close();
  @include '/php/TOU-fetch-data.php';


?>

<?php
  session_start();
  @include '/php/database_connections.php';
  @include '/php/TOU-scoring.php'
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuration</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="./css/theme-mode.css">
    <script src="./js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <link rel="stylesheet" href="./css/home-sidebar-style.css">
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/TOU-live-score.css">
    <link rel="stylesheet" href="./css/system-wide.css">
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
        <img src="./pictures/logo.png" alt="student council logo" class="icon logo">
        <div class="logo_name">Events Tabulation System</div>
        <i class="bx bx-arrow-to-right" id="btn"></i>
        <script src="./js/sidebar-state.js"></script>
      </div>
      <div class="wrapper">
        <li class="nav-item top">
          <a href="index.php">
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
                  <a href="HOM-create-post.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Create Post</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="HOM-draft-scheduled-post.php">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Draft & Scheduled Post</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="HOM-manage-post.php">
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
                  <a href="EVE-admin-list-of-events.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">List of Events</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="EVE-admin-event-configuration.php">
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
                  <a href="CAL-admin-overall.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Overview</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="CAL-admin-logs.php">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Logs</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="BAR-admin.php">
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
                <a href="TOU-Create-Tournament.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Create Tournament</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="TOU-Live-Scoring-Admin.php"   class="sub-active">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Live Scoring</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="TOU-bracket-admin.php">
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
                  <a href="COM-manage_results_page.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Manage Results</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="COM-tobepublished_page.php">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">To Publish</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="COM-published_page.php">
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
                  <a href="HIS-admin-ManageEvent.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Event Page</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="HIS-admin-highlights.php">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Highlights Page</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="P&J-admin-formPJ.php">
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
      <header class="header">Live Scoring</header>
      <div class="container">
        <div class="home">
            <h1>TEAM A</h1>
            <button name="score_a" id="home--btn"><?php echo $existingValueA; ?></button>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    
    <div class="operate">
      <button type="submit" name="updated_value_a" value="-3" id="btn--three"disabled>-3</button>
      <button type="submit" name="updated_value_a" value="-2" id="btn--two" disabled>-2</button>
      <button type="submit" name="updated_value_a" value="-1" id="btn--one" disabled>-1</button>
      <button type="submit" name="updated_value_a" value="1" id="btn--one" disabled>+1</button>
      <button type="submit" name="updated_value_a" value="2" id="btn--two" disabled>+2</button>
      <button type="submit" name="updated_value_a" value="3" id="btn--three" disabled>+3</button>
    </div>
  </form>
        </div>
        <div class="dropdown-tournament">
        <form action="/action_page.php">
    <select id="sport" class="button-tournament">
        <option value="TOURNAMENT">TOURNAMENT</option>
        <option value="BASKETBALL">BASKETBALL</option>
        <option value="VOLLEYBALL">VOLLEYBALL</option>
        <option value="CHESS">CHESS</option>
        <option value="BADMINTON">BADMINTON</option>
    </select>
</form>

<script>
        // Get the dropdown element
        var dropdown = document.getElementById("sport");

        // Add an event listener to handle the selection change
        dropdown.addEventListener("change", function() {
            // Get the selected value
            var selectedValue = dropdown.value;

            // Redirect to a new page based on the selected value
            switch (selectedValue) {
                case "BASKETBALL":
                    window.location.href = "./php/TOU-basketball.php";
                    break;
                case "VOLLEYBALL":
                    window.location.href = "./php/TOU-volleyball.php";
                    break;
                case "CHESS":
                    window.location.href = "./php/TOU-chess.php";
                    break;
                case "BADMINTON":
                    window.location.href = "./php/TOU-badminton.php";
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
            <button class="button-end-match" onclick="showEndMatch()" disabled>End Match</button>
      </div>
        </div>
        <div class="guest">
            <h1>TEAM B</h1>
            <button id="guest--btn"><?php echo $existingValueB; ?></button>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    
    <div class="operate">
      <button type="submit" name="updated_value_b" value="-3" id="btn--three" disabled>-3</button>
      <button type="submit" name="updated_value_b" value="-2" id="btn--two" disabled>-2</button>
      <button type="submit" name="updated_value_b" value="-1" id="btn--one" disabled>-1</button>
      <button type="submit" name="updated_value_b" value="1" id="btn--one" disabled>+1</button>
      <button type="submit" name="updated_value_b" value="2" id="btn--two" disabled>+2</button>
      <button type="submit" name="updated_value_b" value="3" id="btn--three" disabled>+3</button>
    </div>
  </form>
        </div>
    </div>
    <div class="container-two">

        
        <p id="home--count" onclick="homeCount">TEAM A : </p>
        <p id="guest--count" onclick="guestCount">TEAM B : </p>
        <button type="submit" id="save--counter" class="save--btn" onclick="showSaveScore()" name="update_score_data" disabled>SAVE</button>
    </div>

    <script src="./index.js"></script>
    <script src="./js/tournament_type.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </section>
    <!-- Scripts -->
    <script src="./js/script.js"></script>
    <script src="./js/TOU-index.js"></script>
    <script src="./js/theme.js"></script>
    <script src="./js/jquery-3.6.4.js"></script>
    <script type="text/javascript" src="./js/TOU-popup.js"></script>
    <script type="text/javascript" src="./js/TOU-AJAX.js"></script>

    <script>
        function showAlert() {
            alert("Match Ended"); // Display the alert box with a message
        }
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