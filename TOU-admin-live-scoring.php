<?php
  include './php/database_connect.php';
  include './php/sign-in.php';
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
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <link rel="stylesheet" href="./css/system-wide.css">
    <script src="./js/jquery-3.6.4.js"></script>
  </head>

  <body>
    <!--Sidebar-->
    <?php
      // Set the active module and sub-active sub-item variables
      $activeModule = 'tournament';
      $activeSubItem = 'live-scoring';

      // Include the sidebar template
      require './php/admin-sidebar.php';
    ?>
    <section class="home-section flex-row">
      <div class="header">Live Scoring</div>
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
            <div class="container-fluid text-center position-absolute top-50 start-50 translate-middle">
              <form id="match-form" action="./php/TOU-process-winner.php" method="POST">
                <input type="hidden" id="bracketFormId" name="bracketFormId">
                <input type="hidden" id="scheduledTeamBrackets" name="scheduledTeamBrackets">
                <input type="hidden" id="teamOneName" name="teamOneName">
                <input type="hidden" id="teamTwoName" name="teamTwoName">
              </form>
              <div class="row">
                <div class="col">
                  <div class="row">
                    <h1 id="team-one-name"></h1>
                  </div>
                  <div class="row">
                    <h1 id="team-one-score"></h1>
                  </div>
                  <div id="team_one_btn"></div>
                  <br>
                  <button type="button" class="btn btn-danger" id="disqualify-team-one-btn">Disqualify</button>
                </div>
                <div class="col">
                  <br>
                  <h1>VS</h1>
                  <button type="button" class="btn btn-danger" id="end-match-btn">End Match</button>
                </div>
                <div class="col">
                  <div class="row">
                    <h1 id="team-two-name"></h1>
                  </div>
                  <div class="row">
                    <h1 id="team-two-score"></h1>
                  </div>
                  <div id="team_two_btn"></div>
                  <br>
                  <button type="button" class="btn btn-danger" id="disqualify-team-two-btn">Disqualify</button>
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
              var teamOneNameVar;
              var teamTwoNameVar;

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
                $('#team_one_btn').empty();
                $('#team_two_btn').empty();
                selectedId = '';
                selectedId = $(this).val(); // Get the selected ID

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
                $('#team_one_btn').empty();
                $('#team_two_btn').empty();
                selectedValue = '';
                selectedValue = $(this).val(); // Get the selected value

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
                      teamOneNameVar = matchup.team_one_name;
                      teamTwoNameVar = matchup.team_two_name;


                      // Generate buttons for team one
                      $('#team_one_btn').empty(); // Clear existing buttons
                      $('#team_one_btn').append(
                        '<button type="button" class="btn btn-primary btn-sm p-2 me-1 mt-1" id="btn-minus-' + matchup.team_one_id + '" value="-3">-3</button>' +
                        '<button type="button" class="btn btn-primary btn-sm p-2 me-1 mt-1" id="btn-minus-' + matchup.team_one_id + '" value="-2">-2</button>' +
                        '<button type="button" class="btn btn-primary btn-sm p-2 me-1 mt-1" id="btn-minus-' + matchup.team_one_id + '" value="-1">-1</button>' +
                        '<button type="button" class="btn btn-primary btn-sm p-2 me-1 mt-1" id="btn-plus-' + matchup.team_one_id + '" value="1">+1</button>' +
                        '<button type="button" class="btn btn-primary btn-sm p-2 me-1 mt-1" id="btn-plus-' + matchup.team_one_id + '" value="2">+2</button>' +
                        '<button type="button" class="btn btn-primary btn-sm p-2 me-1 mt-1" id="btn-plus-' + matchup.team_one_id + '" value="3">+3</button>'
                      );

                      // Generate buttons for team two
                      $('#team_two_btn').empty(); // Clear existing buttons
                      $('#team_two_btn').append(
                        '<button type="button" class="btn btn-primary btn-sm p-2 me-1 mt-1" id="btn-minus-' + matchup.team_two_id + '" value="-3">-3</button>' +
                        '<button type="button" class="btn btn-primary btn-sm p-2 me-1 mt-1" id="btn-minus-' + matchup.team_two_id + '" value="-2">-2</button>' +
                        '<button type="button" class="btn btn-primary btn-sm p-2 me-1 mt-1" id="btn-minus-' + matchup.team_two_id + '" value="-1">-1</button>' +
                        '<button type="button" class="btn btn-primary btn-sm p-2 me-1 mt-1" id="btn-plus-' + matchup.team_two_id + '" value="1">+1</button>' +
                        '<button type="button" class="btn btn-primary btn-sm p-2 me-1 mt-1" id="btn-plus-' + matchup.team_two_id + '" value="2">+2</button>' +
                        '<button type="button" class="btn btn-primary btn-sm p-2 me-1 mt-1" id="btn-plus-' + matchup.team_two_id + '" value="3">+3</button>'
                      );
                    }
                  },
                  error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                  }
                });
              });

              // Event handler for buttons within team_one_btn div
              $('#team_one_btn').on('click', 'button', function() {
                let value = $(this).val(); // Get the value of the clicked button
                let buttonId = $(this).attr('id');
                let idNumber = buttonId.split('-').pop();
                let bracketFormId = selectedId;

                // Send the action to the PHP script via AJAX
                $.ajax({
                  url: './php/TOU-team-one-update.php', // Replace with your PHP script URL
                  type: 'POST', // Change the request type to POST
                  data: { id: idNumber, score: value, bracketFormId: bracketFormId, teamOneTwoId: selectedValue },
                  dataType: 'json',
                  success: function(response) {
                    if (response.error === 'Team 1 disable buttons.') {
                      // Disable the plus one buttons in the team_one_btn element
                      $('#team_two_btn button[value="1"]').prop('disabled', true);
                      $('#team_two_btn button[value="2"]').prop('disabled', true);
                      $('#team_two_btn button[value="3"]').prop('disabled', true);
                      $('#team_two_btn button[value="-1"]').prop('disabled', true);
                      $('#team_two_btn button[value="-2"]').prop('disabled', true);
                      $('#team_two_btn button[value="-3"]').prop('disabled', true);
                      $('#team_one_btn button[value="1"]').prop('disabled', true);
                      $('#team_one_btn button[value="2"]').prop('disabled', true);
                      $('#team_one_btn button[value="3"]').prop('disabled', true);
                    } else {
                      // Enable the plus one buttons in the team_one_btn element
                      $('#team_two_btn button[value="1"]').prop('disabled', false);
                      $('#team_two_btn button[value="2"]').prop('disabled', false);
                      $('#team_two_btn button[value="3"]').prop('disabled', false);
                      $('#team_two_btn button[value="-1"]').prop('disabled', false);
                      $('#team_two_btn button[value="-2"]').prop('disabled', false);
                      $('#team_two_btn button[value="-3"]').prop('disabled', false);
                      $('#team_one_btn button[value="1"]').prop('disabled', false);
                      $('#team_one_btn button[value="2"]').prop('disabled', false);
                      $('#team_one_btn button[value="3"]').prop('disabled', false);
                      // Update the value in the <h1> element
                      $('#team-one-score').text(response.current_score);
                    }
                  },
                  error: function(xhr, status, error) {
                    console.log(error);
                  }
                });
              });

              // Event handler for buttons within team_two_btn div
              $('#team_two_btn').on('click', 'button', function() {
                let value = $(this).val(); // Get the value of the clicked button
                let buttonId = $(this).attr('id');
                let idNumber = buttonId.split('-').pop();
                let bracketFormId = selectedId;

                // Send the action to the PHP script via AJAX
                $.ajax({
                  url: './php/TOU-team-two-update.php', // Replace with your PHP script URL
                  type: 'POST', // Change the request type to POST
                  data: { id: idNumber, score: value, bracketFormId: bracketFormId, teamOneTwoId: selectedValue },
                  dataType: 'json',
                  success: function(response) {
                    if (response.error === 'Team 2 disable buttons.') {
                      // Disable the plus one buttons in the team_two_btn element
                      $('#team_one_btn button[value="1"]').prop('disabled', true);
                      $('#team_one_btn button[value="2"]').prop('disabled', true);
                      $('#team_one_btn button[value="3"]').prop('disabled', true);
                      $('#team_one_btn button[value="-1"]').prop('disabled', true);
                      $('#team_one_btn button[value="-2"]').prop('disabled', true);
                      $('#team_one_btn button[value="-3"]').prop('disabled', true);
                      $('#team_two_btn button[value="1"]').prop('disabled', true);
                      $('#team_two_btn button[value="2"]').prop('disabled', true);
                      $('#team_two_btn button[value="3"]').prop('disabled', true);
                    } else {
                      // Enable the plus one buttons in the team_two_btn element
                      $('#team_one_btn button[value="1"]').prop('disabled', false);
                      $('#team_one_btn button[value="2"]').prop('disabled', false);
                      $('#team_one_btn button[value="3"]').prop('disabled', false);
                      $('#team_one_btn button[value="-1"]').prop('disabled', false);
                      $('#team_one_btn button[value="-2"]').prop('disabled', false);
                      $('#team_one_btn button[value="-3"]').prop('disabled', false);
                      $('#team_two_btn button[value="1"]').prop('disabled', false);
                      $('#team_two_btn button[value="2"]').prop('disabled', false);
                      $('#team_two_btn button[value="3"]').prop('disabled', false);
                      // Update the value in the <h1> element
                      $('#team-two-score').text(response.current_score);
                    }
                  },
                  error: function(xhr, status, error) {
                    console.log(error);
                  }
                });
              });

              // Set the values of the hidden input fields when the "End Match" button is clicked
              $('#end-match-btn').click(function() {
                  selectedId = selectEvent.val();
                  selectedValue = selectMatchup.val();
                  teamOneNameVar = teamOneName.text();
                  teamTwoNameVar = teamTwoName.text();

                  // Set the values of the hidden input fields
                  $('#bracketFormId').val(selectedId);
                  $('#scheduledTeamBrackets').val(selectedValue);
                  $('#teamOneName').val(teamOneNameVar);
                  $('#teamTwoName').val(teamTwoNameVar);

                  // Submit the form
                  $('#match-form').submit();
                });
            });
          </script>
          <div style="width:100%; height:700px; color:var(--color-body);" id="tree"></div>
        </div>
    </section>
    <!-- Scripts -->
    <script src="./js/script.js"></script>
    <script src="./js/theme.js"></script>
    <script src="./js/orgchart.js"></script>
    <script>
      var chart = new OrgChart(document.getElementById("tree"), {
          template: "diva",
          enableSearch: false,
          mouseScroll: OrgChart.action.none,
          orientation: OrgChart.orientation.right,
          nodeBinding: {
              field_0: "name",
              field_1: "title",
              img_0: "img"
          },
          nodes: [
              { id: 1, pid: 0, name: "Amber McKenzie", title: "CEO", img: "https://cdn.balkan.app/shared/empty-img-blue.svg" },
              { id: 2, pid: 1, name: null, title: "IT Manager", img: "https://cdn.balkan.app/shared/empty-img-blue.svg" },
              { id: 3, pid: 1, name: "Rhys Harper", img: "https://cdn.balkan.app/shared/empty-img-blue.svg" },
              { id: 4, pid: 2, name: "Ava Field", title: "IT Manager", img: "https://cdn.balkan.app/shared/empty-img-blue.svg" },
              { id: 5, pid: 2, name: "Rhys Harper", img: "https://cdn.balkan.app/shared/empty-img-blue.svg" },
              { id: 6, pid: 3, name: "Ava Field", title: "IT Manager", img: "https://cdn.balkan.app/shared/empty-img-blue.svg" },
              { id: 7, pid: 3, name: "Rhys Harper", img: "https://cdn.balkan.app/shared/empty-img-blue.svg" },
              { id: 8, pid: 4, name: "2", title: "IT Manager", img: "https://cdn.balkan.app/shared/empty-img-blue.svg" },
              { id: 9, pid: 4, name: "7", img: "https://cdn.balkan.app/shared/empty-img-blue.svg" },
              { id: 10, pid: 5, name: "4", title: "IT Manager", img: "https://cdn.balkan.app/shared/empty-img-blue.svg" },
              { id: 11, pid: 5, name: "5", img: "https://cdn.balkan.app/shared/empty-img-blue.svg" },
              { id: 12, pid: 6, name: "1", title: "IT Manager", img: "https://cdn.balkan.app/shared/empty-img-blue.svg" },
              { id: 13, pid: 6, name: "3", img: "https://cdn.balkan.app/shared/empty-img-blue.svg" },
              { id: 14, pid: 7, name: "6", title: "IT Manager", img: "https://cdn.balkan.app/shared/empty-img-blue.svg" },
              { id: 15, pid: 7, name: "8", img: "https://cdn.balkan.app/shared/empty-img-blue.svg" }
          ]
      });

      // Add a click event handler that returns false
      chart.on('click', function() {
        return false;
      });
    </script>
    <script type="text/javascript">
      $('.menu_btn').click(function (e) {
        e.preventDefault();
        var $this = $(this).parent().find('.sub_list');
        $('.sub_list').not($this).slideUp(function () {
          var $icon = $(this).parent().find('.change-icon');
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