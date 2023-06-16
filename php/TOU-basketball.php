<?php
  // Database connection details
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
        <script src="./js/sidebar-state.js"></script>
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
      <header class="header">Basketball Live Scoring</header>
      <div class="container">
        <div class="home">
            <h1>ELITE</h1>
            <button name="score_a" id="home--btn">0</button>
            <div class="operate">
                <button id="btn--three" onclick="minusValueThree()">-3</button>
                <button id="btn--two" onclick="minusValueTwo()">-2</button>
                <button type ="submit" name="btn_one" id="btn--one" onclick="minusValueOne()">-1</button>
                <button type ="submit" name="btn_one" id="btn--one" onclick="plusOne()">+1</button>
                <button id="btn--two" onclick="plusTwo()">+2</button>
                <button id="btn--three" onclick="plusThree()">+3</button>
                
            </div>
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
                    window.location.href = "TOU-basketball.php";
                    break;
                case "VOLLEYBALL":
                    window.location.href = "TOU-volleyball.php";
                    break;
                case "CHESS":
                    window.location.href = "TOU-chess.php";
                    break;
                case "BADMINTON":
                    window.location.href = "TOU-badminton.php";
                    break;
                default:
                    // Do nothing or handle the default case
                    break;
            }
        });
    </script>
            <div class="quarter" >
                <h2>1st <br> Quarter</h2>
            </div>
            <div>
            <button class="button-end-match" onclick="showEndMatch()">End Match</button>
      </div>
        </div>
        <div class="guest">
            <h1>AECES</h1>
            <button id="guest--btn">0</button>
            <div class="operate">
                <button id="btn--three" onclick="decreaseValueThree()">-3</button>
                <button id="btn--two" onclick="decreaseValueTwo()">-2</button>
                <button type ="submit" name="btn_one" id="btn--one" onclick="decreaseValueOne()">-1</button>
                <button id="btn--one" onclick="guestPlusOne()">+1</button>
                <button id="btn--two" onclick="guestPlusTwo()">+2</button>
                <button id="btn--three" onclick="guestPlusThree()">+3</button>
            </div>
        </div>
    </div>
    <div class="container-two">

        
        <p id="home--count" onclick="homeCount">ELITE : </p>
        <p id="guest--count" onclick="guestCount">AECES : </p>
        <button type="submit" id="save--counter" class="save--btn" onclick="showSaveScore()" name="update_score_data">SAVE</button>
    </div>

    <script src="../index.js"></script>
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