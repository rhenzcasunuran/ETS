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
  $sql = "SELECT team_id, team_name FROM teams";
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
    <link rel="stylesheet" href="./css/TOU-bracketing.css">
  </head>

  <body>
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
                  <a href="TOU-Live-Scoring-Admin.php"   >
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Live Scoring</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="TOU-bracket-admin.php" class="sub-active">
                    <i class="bx bxs-circle sub-icon color-green"></i>
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
    <div>
        <div class="Link_Style">
            <label> <a target="_blank" class="First" href='https://docs.google.com/spreadsheets/d/1aYVJ68IonLwiFKHKV1ZaT9QW4cdZ-g5XIc6N4KX1BN0/edit#gid=0'>ORG LIST</a></label>
        </div>

        

        <form name = "formId0" class="formId0">
            <label class="number">Current Battle Mode First To</label>

            <select name="Result0" id="Result0" class="ResulT00 ResulT0">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>

            </select> <label class="wins">Wins</label>

        </form>

    </div>

    <div class="Container"> <!--part 1: Branch 1 going to contain everything 1x of this-->
    <!-------------------------1-------------------------------------------->
        <div class="Branch_1"><!--Part 2: The part which contain each 4 of the matches in this branch.-->
            
            <div class="Match">
            <div class="Object_1"> <!--Part 3: Name of player & Result 4x of this in this branch-->

                <div><select class="Name" >
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["team_id"] . "'>" . $row["team_name"] . "</option>";
            }
        } else {
            echo "<option>No options available</option>";
        }
        ?>
        </select></div>  <!--Part 4: Name of player 8x of this in this branch-->

                <div> <!--Part 4: Results 8x of this-->
                <form name="FormId1" class="Result">
                <select id="Result1"> 
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    

                </select>
                </form>
                </div>

                <div><select class="Name" id="Player2">
        </select></div><!--Part 4: Name of player 8x of this-->

                <div> <!--Part 4: Results 8x of this-->
                <form name="FormId2" class="Result">
                <select id="Result2"> 
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>

                </select>
                </form>
                </div>
            </div>

            </div>

<!----------------------------------2----------------------------------->
            <div class="Match">
            <div class="Object_1"> <!--Part 3: Name of player & Result 4x of this in this branch-->

                <div><select class="Name" type="text" id="Player3"></select></div><!--Part 4: Name of player 8x of this in this branch-->

                <div> <!--Part 4: Results 8x of this-->
                <form name="FormId3" class="Result">
                <select id="Result3"> 
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>

                </select>
                </form>
                </div>

                <div><select class="Name" type="text" id="Player4"></select></div><!--Part 4: Name of player 8x of this in this branch-->

                <div> <!--Part 4: Results 8x of this-->
                <form name="FormId4" class="Result">
                <select id="Result4"> 
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>

                </select>
                </form>
                </div>
                </div>
            </div>
<!---------------------------------3 (Half)------------------------------------>
<div class="Match">
<div class="Object_1"> <!--Part 3: Name of player & Result 4x of this in this branch-->

    <div><select class="Name" type="text" id="Player5"></select></div><!--Part 4: Name of player 8x of this in this branch-->

    <div> <!--Part 4: Results 8x of this-->
    <form name="FormId5" class="Result">
    <select id="Result5"> 
        <option value="0">0</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>

    </select>
    </form>
    </div>

    <div><select class="Name" type="text" id="Player6"></select></div><!--Part 4: Name of player 8x of this in this branch-->

    <div> <!--Part 4: Results 8x of this-->
    <form name="FormId6" class="Result">
    <select id="Result6"> 
        <option value="0">0</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>

    </select>
    </form>
    </div>
</div>
</div>
<!------------------------------------4--------------------------------->
<div class="Match">
<div class="Object_1"> <!--Part 3: Name of player & Result 4x of this in this branch-->

    <div><select class="Name" type="text" id="Player7"></select></div><!--Part 4: Name of player 8x of this in this branch-->

    <div> <!--Part 4: Results 8x of this-->
    <form name="FormId7" class="Result">
    <select id="Result7"> 
        <option value="0">0</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>

    </select>
    </form>
    </div>

    <div><select class="Name" type="text" id="Player8"></select></div><!--Part 4: Name of player 8x of this in this branch-->

    <div> <!--Part 4: Results 8x of this-->
    <form name="FormId8" class="Result">
    <select id="Result8"> 
        <option value="0">0</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>

    </select>
    </form>
    </div>
</div>
</div>

        </div>
<!------------------Quarter-Finals------------------------------------->
<!-----------------------Branch 1 ends here---------------------------->
<!--------------------------------------------------------------------->
<div class="Branch_2"><!--Part 2: The part which contain each 2 of the matches. In this branch-->
    <div class="Match_02">       
    <div class="Object_2"> <!--Part 3: Name of player & Result 2x of this in this branch-->

        <div class="Name_Forward" type="text" id="Player9">Player</div><!--Part 4: Name of player 4x of this in this branch-->

        <div> <!--Part 4: Results 8x of this-->
        <form name="FormId9" class="Result">
        <select id="Result9"> 
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>

        </select>
        </form>
        </div>

        <div class="Name_Forward" type="text" id="Player10">Player</div><!--Part 4: Name of player 4x of this in this branch-->

        <div> <!--Part 4: Results 4x of this in this branch-->
        <form name="FormId10" class="Result">
        <select id="Result10"> 
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>

        </select>
        </form>
        </div>
</div> 
    </div>
<!----------------------------------2 (half)----------------------------------->
<div class="Match_02">
<div class="Object_2"> <!--Part 3: Name of player & Result 2x of this in this branch-->

        <div class="Name_Forward" type="text" id="Player11">Player</div><!--Part 4: Name of player 4x of this in this branch-->

        <div> <!--Part 4: Results 4x of this in this branch-->
        <form name="FormId11" class="Result">
        <select id="Result11"> 
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>

        </select>
        </form>
        </div>

        <div class="Name_Forward" type="text" id="Player12">Player</div><!--Part 4: Name of player 8x of this-->

        <div> <!--Part 4: Results 4x of this in this branch-->
        <form name="FormId12" class="Result">
        <select id="Result12"> 
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>

        </select>
        </form>
        </div>
</div>
    </div>

</div>
<!-------------------------Semi-Finals--------------------------------->
<!-----------------------Branch 2 ends here---------------------------->
<!--------------------------------------------------------------------->

<div class="Branch_3"><!--Part 2: The part which contain 1 of the matches.-->
    <div class="Match_03">       
    <div class="Object_3"> <!--Part 3: Name of player & Result 1x of this in this branch-->

        <div class="Name_Forward" type="text" id="Player13">Player</div><!--Part 2: Name of player 2x of this in this branch-->

        <div> <!--Part 4: Results 2x of this in this branch-->
        <form name="FormId13" class="Result">
        <select id="Result13"> 
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>

        </select>
        </form>
        </div>

        <div class="Name_Forward" type="text" id="Player14">Player</div><!--Part 2: Name of player 2x of this in this branch-->

        <div> <!--Part 4: Results 2x of this in this branch-->
        <form name="FormId14" class="Result">
        <select id="Result14"> 
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>

        </select>
        </form>
        </div>
</div>
    </div>

</div>
<!------------------------------Finals--------------------------------->
<!-----------------------Branch 3 ends here---------------------------->
<!--------------------------------------------------------------------->
    </div>
</section>
    <!-- Scripts -->
    <script src="./js/script.js"></script>
    <script src="./js/TOU-index.js"></script>
    <script src="./js/TOU-bracket.js"></script>
    <script src="./js/theme.js"></script>
    <script src="./js/jquery-3.6.4.js"></script>
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