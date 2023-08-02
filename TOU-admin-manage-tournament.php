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
    <title>Manage Tournament</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="./css/theme-mode.css">
    <script src="./js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <link rel="stylesheet" href="./css/system-wide.css">
    <link rel="stylesheet" href="./css/TOU-colors.css">
    <script src="./js/jquery-3.6.4.js"></script>
  </head>

  <body>
    <!--Sidebar-->
    <?php
      // Set the active module and sub-active sub-item variables
      $activeModule = 'tournament';
      $activeSubItem = 'manage-tournament';

      // Include the sidebar template
      require './php/admin-sidebar.php';
    ?>

    <!-- Event And Category Fetch -->
    <script type="text/javascript">
        $(document).ready(function() {
            // Make an AJAX request to retrieve the event data
            $.ajax({
                url: './php/TOU-get-json-events.php', // Replace with the correct file path
                type: 'GET',
                success: function(response) {
                    // Parse the JSON response
                    const data = response;

                    // Populate the event select element
                    var eventSelect = $('#event_name');
                    $.each(data.events, function(index, event) {
                        eventSelect.append($('<option></option>').val(event).text(event));
                    });

                    // Trigger change event on initial page load
                    eventSelect.trigger('change');
                },
                error: function() {
                    console.log('Error occurred while retrieving event data.');
                }
            });

            // Event change event handler
            $('#event_name').on('change', function() {
                var selectedEvent = $(this).val();

                // Make an AJAX request to retrieve the categories for the selected event
                $.ajax({
                    url: './php/TOU-get-json-category.php', // Replace with the correct file path
                    type: 'GET',
                    data: { event: selectedEvent },
                    success: function(response) {
                        // Parse the JSON response
                        const data = response;

                        // Populate the category select element
                        var categorySelect = $('#category_name');
                        categorySelect.empty(); // Clear previous options
                        $.each(data.categories, function(index, category) {
                            categorySelect.append($('<option></option>').val(category).text(category));
                        });
                    },
                    error: function() {
                        console.log('Error occurred while retrieving category data.');
                    }
                });
            });
        });
    </script>
    <section class="home-section flex-row">
      <div class="header">Manage Tournament</div>
        <div class="container-fluid d-flex row justify-content-center align-items-center flex wrap m-0">
          <div id="active-tournaments"></div>
        </div>
    </section>
    <!-- Scripts -->
    <script src="./js/script.js"></script>
    <script src="./js/theme.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $.ajax({
            url: './php/TOU-fetch-active-tournament.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var activeTournamentsDiv = $('#active-tournaments');

                if (data.length > 0) {
                    data.forEach(function (tournament) {
                        var buttonHtml = `<button class="primary-button" id="edit-tournament-${tournament.id}">Edit</button>`;

                        var elementHtml = `
                            <div class="div">
                                <div class="element">
                                    <div class="row">
                                        <div class="element-group">
                                            <div class="element-label">${tournament.event_name}</div>
                                            <div class="element-content">${tournament.category_name}</div>
                                            <div class="d-flex justify-content-end">${buttonHtml}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

                        activeTournamentsDiv.append(elementHtml);

                        // Attach a click event handler to all buttons with IDs starting with "edit-tournament-"
                        $("[id^='edit-tournament-']").on("click", function() {
                            // Get the numerical ID from the clicked button's ID attribute
                            let numericalId = this.id.split("-").pop();

                            // Redirect to the desired page with the numerical ID
                            window.location.href = "TOU-admin-edit-tournament.php?id=" + numericalId;
                        });
                    });
                } else {
                    $('#active-tournaments').append('<div class="container text-center mt-3"><img src="./pictures/No_Tournament.svg" alt="No tournaments found" class="img-fluid max-width"><h1 class="text-center" id="tournament-not-found"><b>No Tournaments</b></h1><p id="sub-text">Looks like there\'s no tournaments to manage found.</p><br><div class="d-flex justify-content-center"><button class="primary-button" id="create-tournament-button"><i class="bx bx-add-to-queue"></i>Create Tournament</button></div>');
                    }


                    // Get the reference to the "Create Tournament" button
                    const createTournamentButton = document.getElementById('create-tournament-button');

                    // Add a click event listener to the button
                    createTournamentButton.addEventListener('click', function () {
                    // Set the URL of the destination page you want to redirect to
                    const destinationURL = 'TOU-admin-create-tournament.php'; // Replace with the actual URL

                    // Redirect to the destination page
                    window.location.href = destinationURL;
                    });
                },
                error: function(error) {
                  $('#active-tournaments').append('<div class="container text-center mt-3"><img src="./pictures/No_Tournament.svg" alt="No tournaments found" class="img-fluid max-width"><h1 class="text-center" id="tournament-not-found"><b>No Tournaments</b></h1><p id="sub-text">Looks like there\'s no tournaments to manage found.</p><br><div class="d-flex justify-content-center"><button class="primary-button" id="create-tournament-button"><i class="bx bx-add-to-queue"></i>Create Tournament</button></div>');
                    
                     // Get the reference to the "Create Tournament" button
                     const createTournamentButton = document.getElementById('create-tournament-button');

                    // Add a click event listener to the button
                    createTournamentButton.addEventListener('click', function () {
                    // Set the URL of the destination page you want to redirect to
                    const destinationURL = 'TOU-admin-create-tournament.php'; // Replace with the actual URL

                    // Redirect to the destination page
                    window.location.href = destinationURL;
                    });
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
    <!--Popper JS-->
    <script src="./js/popper.min.js"></script>
    <!--Bootstrap JS-->
    <script src="./js/bootstrap.min.js"></script>
  </body>

</html>