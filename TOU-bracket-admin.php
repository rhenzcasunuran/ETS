<?php
  session_start();
  @include './php/database_connect.php';

  // Query to retrieve data from the database
  $sql = "SELECT team_id, team_name FROM teams";
  $result = $conn->query($sql);

  @include './php/TOU-fetch-data.php';
  @include './php/TOU-scoring.php';

  // Fetch option values from MySQL
  $sql = "SELECT team_name, team_score FROM teams";
  $result = $conn->query($sql);

  // Store options and default values in arrays
  $options = [];
  $defaultValues = [];
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $options[] = $row["team_name"];
          $defaultValues[] = $row["team_score"];
      }
  }
  // Close the database connection
  $conn->close();
?>

<script>
        function disableOptions() {
            var dropdowns = document.querySelectorAll('select');

            // Enable all options
            for (var i = 0; i < dropdowns.length; i++) {
                var options = dropdowns[i].querySelectorAll('option');
                for (var j = 0; j < options.length; j++) {
                    options[j].removeAttribute('disabled');
                }
            }

            // Disable selected options in other dropdowns
            for (var i = 0; i < dropdowns.length; i++) {
                var selectedOption = dropdowns[i].value;
                if (selectedOption !== '') {
                    for (var j = 0; j < dropdowns.length; j++) {
                        if (j !== i) {
                            var options = dropdowns[j].querySelectorAll('option');
                            for (var k = 0; k < options.length; k++) {
                                if (options[k].value === selectedOption) {
                                    options[k].setAttribute('disabled', 'disabled');
                                }
                            }
                        }
                    }
                }
            }
        }

        function updateSelectedValue(dropdown) {
            disableOptions();
        }

        function lockSelection() {
            var dropdowns = document.querySelectorAll('select');
            for (var i = 0; i < dropdowns.length; i++) {
                dropdowns[i].setAttribute('disabled', 'disabled');
                dropdowns[i].classList.add('dropdown-uninteractable');
            }

            var lockButton = document.getElementById('lockButton');
            lockButton.setAttribute('disabled', 'disabled');
        }
    </script>
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
    <?php
      // Set the active module and sub-active sub-item variables
      $activeModule = 'tournaments';      
      $activeSubItem = 'manage-brackets';

      // Include the sidebar template
      require './php/admin-sidebar.php';
    ?>
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
    <form id="myForm" method="post" action="update_mysql.php">
    <?php
// Display multiple dropdowns
for ($i = 1; $i <= 8; $i++) {
    echo '<div class="dropdown-container">';
    echo '<select name="dropdown' . $i . '" onchange="updateSelectedValue(this)" data-index="' . ($i - 1) . '" class="custom-dropdown">';

    // Add default option
    echo '<option value="">Select team</option>';

    // Add options from the array
    foreach ($options as $option) {
        echo '<option value="' . $option . '">' . $option . '</option>';
    }

    echo '</select>';

    // Add input field
    echo '<input type="text" class="input-field" id="inputField' . $i . '" name="inputField' . $i . '" value="' . $defaultValues[$i - 1] . '">';

    echo '</div>';
}

    
?>

        <button type="button" id="lockButton" onclick="lockSelection()">Save</button>
        <button type="submit">Submit</button>
    </form>
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