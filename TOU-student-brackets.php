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
    <title>View Brackets</title>
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
    <link rel="stylesheet" href="./css/TOU-student-live-scoring.css">
    <link rel="stylesheet" href="./css/TOU-brackets.css">
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
        <div class="container-fluid d-flex row justify-content-center align-items-center flex wrap m-0" style="position: absolute; z-index: 9999;">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <select id="tournamentEvent" class="form-select w-100" aria-label="Default select example">
                    </select>
                </div>
                <div class="col-auto">
                    <select id="tournamentCategory" class="form-select w-100" aria-label="Default select example">
                        <option selected>Select Tournament Event</option>
                    </select>
                </div>
                <div class="col-auto">
                    <select id="viewScoreBracket" class="form-select w-100" aria-label="Default select example">
                        <option value="1">Live Scoring</option>
                        <option selected value="2">Bracket Viewing</option>
                    </select>
                </div>
            </div>
        </div>
        <div style="width:100vw; height:100vh;" id="tree"></div>
    </section>
    <script>
    // First AJAX request to populate the #tournamentEvent <select> options
    var selectEvent = $('#tournamentEvent');
    var selectedEventName;

    document.getElementById("viewScoreBracket").addEventListener("change", function() {
      var selectedValue = this.value;
      if (selectedValue === "1") {
        // Redirect to the PHP page
        window.location.href = "TOU-student-live-scoring.php";
      }
    });

    $.ajax({
        url: './php/TOU-get-bracket-events.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            selectEvent.empty();
            selectEvent.append('<option selected>Select Tournament Event</option>');

            // Populate the #tournamentEvent <select> with the event names received from the server
            $.each(data, function(index, eventName) {
                selectEvent.append('<option value="' + eventName + '">' + eventName + '</option>');
            });

            // After populating #tournamentEvent, trigger the change event to execute the second AJAX request
            selectEvent.trigger('change');
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });

    // Second AJAX request to populate #tournamentCategory <select> based on the selected value from #tournamentEvent
    var selectCategory = $('#tournamentCategory');

    selectEvent.on('change', function() {
        selectedEventName = $(this).val();

        // AJAX request to populate the #tournamentCategory <select> options
        $.ajax({
            url: './php/TOU-get-bracket-categories.php',
            type: 'GET',
            dataType: 'json',
            data: { eventValue: selectedEventName },
            success: function(data) {
                selectCategory.empty();
                selectCategory.append('<option selected>Select Tournament Category</option>');

                // Populate the #tournamentCategory <select> with the category names received from the server
                $.each(data, function(index, categoryName) {
                    selectCategory.append('<option value="' + categoryName + '">' + categoryName + '</option>');
                });

                // After populating #tournamentCategory, trigger the change event to execute the third AJAX request
                selectCategory.trigger('change');
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });

    // Third AJAX request to use both selected event name and category name
    selectCategory.on('change', function() {
      var selectedCategoryName = $(this).val();
        // AJAX request to use both selected event name and category name for further processing
        $.ajax({
            url: './php/TOU-get-brackets.php', // Replace with the URL for the third AJAX request
            type: 'GET', // Use POST or the appropriate method for your use case
            dataType: 'json',
            data: {
                eventValue: selectedEventName,
                categoryValue: selectedCategoryName
            },
            success: function(data) {
              console.log(data)
                // Create the OrgChart with the received data
                OrgChart.templates.diva.link = '<path stroke-linejoin="round" stroke="#aeaeae" stroke-width="1px" fill="none" d="{edge}" />';
                var chart = new OrgChart(document.getElementById("tree"), {
                    template: "diva",
                    enableSearch: false,
                    mouseScroll: OrgChart.action.none,
                    orientation: OrgChart.orientation.right,
                    nodeBinding: {
                        field_0: "team_name",
                        field_1: "overall_score",
                        img_0: "img"
                    },
                    nodes: data // Use the received data to populate the nodes of the OrgChart
                });

                // Add a click event handler that returns false
                // This is added to prevent the OrgChart from interfering with other click events
                chart.on('click', function() {
                    return false;
                });
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });
    </script>
    <!-- Scripts -->
    <script src="./js/script.js"></script>
    <script src="./js/change-theme.js"></script>
    <script src="./js/jquery-3.6.4.js"></script>
    <script src="./js/HOM-popup.js"></script>
    <script src="./js/orgchart.js"></script>
    <script>
    // First AJAX request to populate the #tournamentEvent <select> options
    var selectEvent = $('#tournamentEvent');
    var selectedEventName;

    document.getElementById("viewScoreBracket").addEventListener("change", function() {
      var selectedValue = this.value;
      if (selectedValue === "1") {
        // Redirect to the PHP page
        window.location.href = "TOU-student-live-scoring.php";
      }
    });

    $.ajax({
        url: './php/TOU-get-bracket-events.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            selectEvent.empty();
            selectEvent.append('<option selected>Select Tournament Event</option>');

            // Populate the #tournamentEvent <select> with the event names received from the server
            $.each(data, function(index, eventName) {
                selectEvent.append('<option value="' + eventName + '">' + eventName + '</option>');
            });

            // After populating #tournamentEvent, trigger the change event to execute the second AJAX request
            selectEvent.trigger('change');
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });

    // Second AJAX request to populate #tournamentCategory <select> based on the selected value from #tournamentEvent
    var selectCategory = $('#tournamentCategory');

    selectEvent.on('change', function() {
        selectedEventName = $(this).val();

        // AJAX request to populate the #tournamentCategory <select> options
        $.ajax({
            url: './php/TOU-get-bracket-categories.php',
            type: 'GET',
            dataType: 'json',
            data: { eventValue: selectedEventName },
            success: function(data) {
                selectCategory.empty();
                selectCategory.append('<option selected>Select Tournament Category</option>');

                // Populate the #tournamentCategory <select> with the category names received from the server
                $.each(data, function(index, categoryName) {
                    selectCategory.append('<option value="' + categoryName + '">' + categoryName + '</option>');
                });

                // After populating #tournamentCategory, trigger the change event to execute the third AJAX request
                selectCategory.trigger('change');
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });

    // Third AJAX request to use both selected event name and category name
    selectCategory.on('change', function() {
      var selectedCategoryName = $(this).val();
        // AJAX request to use both selected event name and category name for further processing
        $.ajax({
            url: './php/TOU-get-brackets.php', // Replace with the URL for the third AJAX request
            type: 'GET', // Use POST or the appropriate method for your use case
            dataType: 'json',
            data: {
                eventValue: selectedEventName,
                categoryValue: selectedCategoryName
            },
            success: function(data) {
              console.log(data)
                // Create the OrgChart with the received data
                var chart = new OrgChart(document.getElementById("tree"), {
                    template: "diva",
                    enableSearch: false,
                    mouseScroll: OrgChart.action.none,
                    orientation: OrgChart.orientation.right,
                    nodeBinding: {
                        field_0: "team_name",
                        field_1: "overall_score",
                    },
                    nodes: data // Use the received data to populate the nodes of the OrgChart
                });

                // Add a click event handler that returns false
                // This is added to prevent the OrgChart from interfering with other click events
                chart.on('click', function() {
                    return false;
                });
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
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
    </script>
    <!--Popper JS-->
    <script src="./js/popper.min.js"></script>
    <!--Bootstrap JS-->
    <script src="./js/bootstrap.min.js"></script>
  </body>

</html>