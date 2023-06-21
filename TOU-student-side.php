<?php
  @include './php/admin-signin.php';
  @include './php/database_connect.php';
  @include './php/TOU-scoring.php';
  @include './php/TOU-fetch-data.php';

    // Retrieve the existing value for Team A from the database
    $sql = "SELECT scoring_team_a FROM scores";
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
        $sql = "UPDATE scores SET scoring_team_a = $newValueA";
        if ($conn->query($sql) === TRUE) {
          echo "Value updated successfully!";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
        // Update the existing value for Team A
        $existingValueA = $newValueA;
      }
    }
    
    // Retrieve the existing value for Team B from the database
    $sql = "SELECT scoring_team_b FROM scores";
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
        $sql = "UPDATE scores SET scoring_team_b = $newValueB";
        if ($conn->query($sql) === TRUE) {
          echo "Value updated successfully!";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
        // Update the existing value for Team B
        $existingValueB = $newValueB;
      }
    }
      
      // Query to retrieve data from the database
      $sql = "SELECT bracket_id, bracket_sports FROM bracket";
      $result = $conn->query($sql);

    // Close the database connection
    $conn->close();
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
     
     <!--SIDEBAR-->
     <?php
      // Set the active module and sub-active sub-item variables
      $activeModule = 'results';
      $activeSubItem = 'tournament';

      // Include the sidebar template
      require './php/student-sidebar.php';
    ?>
    <!--Page Content-->
    <section class="home-section">
      <header class="header">Live Scoring</header>
      <div class="container">
        <div class="home">
            <h1>ELITE</h1>
            <button name="score_a" id="home--btn"><?php echo $existingValueA; ?></button>
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
                    window.location.href = "./php/TOU-basketball-stud.php";
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
</form>
            <div class="quarter" >
                <h2>1st <br> Quarter</h2>
            </div>
            <div>
      </div>
        </div>
        <div class="guest">
            <h1>AECES</h1>
            <button id="guest--btn"><?php echo $existingValueB; ?></button>
        </div>
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