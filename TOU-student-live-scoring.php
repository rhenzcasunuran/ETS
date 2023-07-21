<?php
include './php/database_connect.php';
include './php/admin-signin.php';
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Scoring</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="./css/theme-mode.css">
    <script src="./js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <link rel="stylesheet" href="./css/home-sidebar-style.css">
    <link rel="stylesheet" href="./css/system-wide.css">
    <link rel="stylesheet" href="./css/TOU-admin-live-scoring.css">
    <script src="./js/jquery-3.6.4.js"></script>
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
     <!--SIDEBAR-->
     <?php
      // Set the active module and sub-active sub-item variables
      $activeModule = 'results';
      $activeSubItem = 'tournament';

      // Include the sidebar template
      require './php/student-sidebar.php';
    ?>
    <section class="home-section flex-row">
      <div id="viewBracket" class="container-fluid text-center position-absolute top-50 start-50 translate-middle" style="display: none;">
        <div style="width:100%; height:100%;" id="tree"></div>   
      </div>
      <div class="d-flex justify-content-between">
        <div class="header">Live Scoring</div>
          <select id="viewScoreBracket" class="form-select w-25 h-25 mt-4 me-3 text-center" style="z-index:999;" aria-label="Default select example">
            <option selected value="1">Live Scoring</option>
            <option value="2">Bracket Viewing</option>
          </select>
        </div>
        <div class="container-fluid d-flex row justify-content-center align-items-center flex wrap m-0">
          <div class="row justify-content-center">
            <div class="col-auto">
              <select id="tournamentEvent" class="form-select w-100" aria-label="Default select example">
              </select>
            </div>
            <div class="col-auto">
              <select id="tournamentMatchup" class="form-select w-100" aria-label="Default select example">
                <option selected>Select Matchup</option>
              </select>
            </div>
            <div id="viewScore" class="container-fluid text-center position-absolute top-50 start-50 translate-middle">
              <div class="row">
                <div class="col">
                  <div class="row">
                    <h1 id="team-one-name"></h1>
                  </div>
                  <div class="row">
                    <h1 id="team-one-score"></h1>
                  </div>
                  <br>
                </div>
                <div class="col">
                  <br>
                  <h2 id="template-overall-score">0-0</h2>
                  <h1 id="template-vs">VS</h1>
                </div>
                <div class="col">
                  <div class="row">
                    <h1 id="team-two-name"></h1>
                  </div>
                  <div class="row">
                    <h1 id="team-two-score"></h1>
                  </div>
                  <br>
                </div>
              </div>
            </div>
          </div>
          <script>
            $(document).ready(function() {
              var selectEvent = $('#tournamentEvent');
              var selectMatchup = $('#tournamentMatchup');
              var teamOneName = $('#team-one-name');
              var teamTwoName = $('#team-two-name');
              var teamOneScore = $('#team-one-score');
              var teamTwoScore = $('#team-two-score');
              var selectedId;
              var selectedValue;

              // Function to handle empty values and set default text
              function setDefaultText(elementId, defaultText) {
                var element = $('#' + elementId);
                if (!element.text().trim()) {
                  element.text(defaultText);
                }
              }

              // Call the function to set default text for empty elements
              setDefaultText('team-one-name', 'TEAM 1');
              setDefaultText('team-two-name', 'TEAM 2');
              setDefaultText('team-one-score', '0');
              setDefaultText('team-two-score', '0');

               document.getElementById("viewScoreBracket").addEventListener("change", function() {
                var selectedValue = this.value;
                if (selectedValue === "2") {
                  // Redirect to the PHP page
                  window.location.href = "TOU-student-brackets.php";
                }
              });

              // AJAX request to populate the <select> options
              $.ajax({
                url: './php/TOU-get-event-category.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                  selectEvent.empty();
                  selectEvent.append('<option selected>Select Tournament Event</option>');

                  $.each(data, function(index, matchup) {
                    var optionText = matchup.event_name + ' -- ' + matchup.category_name;
                    selectEvent.append('<option value="' + matchup.id + '">' + optionText + '</option>');
                  });
                },
                error: function(xhr, status, error) {
                  console.log(xhr.responseText);
                }
              });

              // Event handler for tournament event change
              selectEvent.on('change', function() {
                selectMatchup.empty();
                selectMatchup.append('<option selected>Select Matchup</option>');
                teamOneName.text(''); // Empty team one name
                teamTwoName.text(''); // Empty team two name
                teamOneScore.text(''); // Empty team one name
                teamTwoScore.text(''); // Empty team two name
                // Call the function to set default text for empty elements
                setDefaultText('team-one-name', 'TEAM 1');
                setDefaultText('team-two-name', 'TEAM 2');
                setDefaultText('team-one-score', '0');
                setDefaultText('team-two-score', '0');

                var selectedId = $(this).val(); // Get the selected ID

                // Send the ID to another AJAX request
                $.ajax({
                  url: './php/TOU-get-scheduled-brackets.php',
                  type: 'GET',
                  data: { id: selectedId },
                  dataType: 'json',
                  success: function(response) {
                    $.each(response, function(index, matchup) {
                      var optionText = matchup.team_one_name + ' vs ' + matchup.team_two_name;
                      selectMatchup.append('<option value="' + matchup.id  + '">' + optionText + '</option>');
                    });
                  },
                  error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                  }
                });
              });

              // Event handler for matchup selection change
              selectMatchup.on('change', function() {
                teamOneName.text(''); // Empty team one name
                teamTwoName.text(''); // Empty team two name
                teamOneScore.text(''); // Empty team one score
                teamTwoScore.text(''); // Empty team two score
                var selectedValue = $(this).val(); // Get the selected value
                // Call the function to set default text for empty elements
                setDefaultText('team-one-name', 'TEAM 1');
                setDefaultText('team-two-name', 'TEAM 2');
                setDefaultText('team-one-score', '0');
                setDefaultText('team-two-score', '0');

                // Send the selected value to the PHP script via AJAX
                $.ajax({
                  url: './php/TOU-get-team-details.php',
                  type: 'GET',
                  data: { id: selectedValue },
                  dataType: 'json',
                  success: function(response) {
                    if (response.length > 0) {
                      var matchup = response[0]; // Assuming only one matchup is returned

                      // Populate team names and scores
                      teamOneName.text(matchup.team_one_name);
                      teamTwoName.text(matchup.team_two_name);
                      teamOneScore.text(matchup.team_one_current_score);
                      teamTwoScore.text(matchup.team_two_current_score);
                    }
                  },
                  error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                  }
                });
              });

              // Function to check and log the selected value
              function checkSelectedValue() {
                var selectedValue = selectMatchup.val(); // Get the selected value
                teamOneScore.text(''); // Empty team one score
                teamTwoScore.text(''); // Empty team two score
                // Call the function to set default text for empty elements
                setDefaultText('team-one-name', 'TEAM 1');
                setDefaultText('team-two-name', 'TEAM 2');
                setDefaultText('team-one-score', '0');
                setDefaultText('team-two-score', '0');

                // Send the selected value to the PHP script via AJAX
                $.ajax({
                  url: './php/TOU-get-team-details.php',
                  type: 'GET',
                  data: { id: selectedValue },
                  dataType: 'json',
                  success: function(response) {
                    if (response.length > 0) {
                      var matchup = response[0]; // Assuming only one matchup is returned
                      // Populate team names and scores
                      teamOneScore.text(matchup.team_one_current_score);
                      teamTwoScore.text(matchup.team_two_current_score);
                    }
                  },
                  error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                  }
                });
              }

              // Check and log the selected value every 10 seconds
              setInterval(checkSelectedValue, 10000);
            });
          </script>
        </div>
    </section>
    <!-- Scripts -->
    <script src="./js/script.js"></script>
    <script src="./js/change-theme.js"></script>
    <script src="./js/jquery-3.6.4.js"></script>
    <script src="./js/HOM-popup.js"></script>
    <script src="./js/orgchart.js"></script>
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
    </script>
    <!--Popper JS-->
    <script src="./js/popper.min.js"></script>
    <!--Bootstrap JS-->
    <script src="./js/bootstrap.min.js"></script>
  </body>

</html>
