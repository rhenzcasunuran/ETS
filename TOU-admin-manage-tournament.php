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
    <!--Popup Confirm / Success-->
    <div class="popup-background" id="markAsDoneWrapper">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-check-circle prompt-icon success-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Conclude Tournament?</h3>   <!--header-->
                <p>This will end the tournament and declare a champion. Are you sure?</p> <!--text-->
            </div>
            <div  class="div">
                <button class="outline-button" onclick="hideMarkAsDone()"><i class='bx bx-x'></i>Cancel</button>
                <div id="dynamic-successful"></div>
            </div>
        </div>
    </div>

    <!--Popup Delete / Danger-->
    <div class="popup-background" id="deleteWrapper">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-error prompt-icon danger-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Delete Event?</h3>   <!--header-->
                <p>This will delete the event permanently. This action cannot be undone.</p> <!--text-->
            </div>
            <div  class="div">
                <button class="outline-button" onclick="hideDelete()"><i class='bx bx-x'></i>Cancel</button>
                <button class="danger-button"><i class='bx bx-trash'></i>Delete</button>
            </div>
        </div>
    </div>
    <section class="home-section flex-row">
      <div class="header">Manage Tournament</div>
        <div class="container-fluid d-flex row justify-content-center align-items-center flex wrap m-0">
          <div id="active-tournaments">
          </div>
        </div>
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
                console.log(data)
                var activeTournamentsDiv = $('#active-tournaments');

                if (data.length > 0) {
                    data.forEach(function (tournament) {
                        var buttonHtml;
                        if (tournament.concluding_tournament_id !== null) {
                            // Dynamically create the Confirm button with the appropriate ID
                            buttonHtml = `<button class="success-button" id="confirm-${tournament.concluding_tournament_id}" onclick="showMarkAsDone(${tournament.concluding_tournament_id})">Conclude</button>`;
                        } else {
                            buttonHtml = `<button class="primary-button" id="edit-tournament-${tournament.id}">Edit</button>`;
                        }

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
                    $('#active-tournaments').append('<div class="container text-center mt-3"><div class="row align-items-start"><div class="col"></div><div class="col"><img src="./pictures/No_Tournament.svg" alt="No tournaments found" class="img-fluid max-width"><h1 class="text-center" id="tournament-not-found"><b>No Tournaments</b></h1><p id="sub-text">Looks like there\'s no tournaments to manage found.</p><br><button class="primary-button" id="create-tournament-button"><i class="bx bx-add-to-queue d-flex justify-content-center align-items-center"></i>Create Tournament</button></div><div class="col"></div></div></div>');
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
                  console.error(error)
                  $('#active-tournaments').append('<div class="container text-center mt-3"><div class="row align-items-start"><div class="col"></div><div class="col"><img src="./pictures/No_Tournament.svg" alt="No tournaments found" class="img-fluid max-width"><h1 class="text-center" id="tournament-not-found"><b>No Tournaments</b></h1><p id="sub-text">Looks like there\'s no tournaments to manage found.</p><br><button class="primary-button" id="create-tournament-button"><i class="bx bx-add-to-queue d-flex justify-content-center align-items-center"></i>Create Tournament</button></div><div class="col"></div></div></div>');
                    
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

        // Confirm
        popupMarkAsDone = document.getElementById('markAsDoneWrapper');
  
        var showMarkAsDone = function(tournamentID) {
            popupMarkAsDone.style.display = 'flex';
            
            // Create the Confirm button dynamically
            var confirmButton = `<button class="success-button" id="confirm-conclude-${tournamentID}"><i class='bx bx-check'></i>Confirm</button>`;
            
            // Append the Confirm button to the container
            $("#dynamic-successful").html(confirmButton);

            // Attach a click event handler to all buttons with IDs starting with "edit-tournament-"
            $("[id^='confirm-conclude-']").on("click", function() {
                // Get the numerical ID from the clicked button's ID attribute
                let numericalId = this.id.split("-").pop();

                // Redirect to the desired page with the numerical ID
                window.location.href = "TOU-admin-edit-tournament.php?id=" + numericalId;
            });
        }
        var hideMarkAsDone = function() {
            popupMarkAsDone.style.display ='none';
        }

        // Cancel
        popupCancel = document.getElementById('cancelWrapper');
  
        var showCancel = function() {
            popupCancel.style.display ='flex';
        }
        var hideCancel = function() {
            popupCancel.style.display ='none';
        }

        //Delete
        popupDelete = document.getElementById('deleteWrapper');
  
        var showDelete = function() {
            popupDelete.style.display ='flex';
        }
        var hideDelete = function() {
            popupDelete.style.display ='none';
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
    <!--Popper JS-->
    <script src="./js/popper.min.js"></script>
    <!--Bootstrap JS-->
    <script src="./js/bootstrap.min.js"></script>
  </body>

</html>