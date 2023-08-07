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
    <style>
      .searchbar-container {
        position: relative;
        max-width: 450px;     
      }

      #searchIcon {
        position: absolute;
        left: 15px; /* Adjust this value to control the icon's position */
        top: 37%;
        transform: translateY(-45%);
        color: var(--color-content-text) !important;
      }

      #searchInput {
        text-indent: 30px; /* Adjust this value to add more margin to the placeholder */ 
      }

      .dropdown-menu-style {
        user-select: none;
        left: -45px !important;
        top: 10px !important;
        box-shadow: 0px 0px 10px 0 var(--shadow-color)!important;
        background-color: var(--color-content-card) !important;
        color: var(--color-content-text) !important;
        padding: 15% !important;
        border: none!important;
        border-radius: 15px!important;
        width: 200px !important;
      }

      .radio-set {
        margin-left: 8px !important;
      }

      .dropdown-divider {
        margin-left: -10px !important;
      }
    </style>
  </head>

  <body>
    <!--Popup Delete / Danger-->
    <div class="popup-background" id="deleteWrapper">
      <div class="row popup-container">
        <div class="col-4">
          <i class='bx bxs-error prompt-icon danger-color'></i> <!--icon-->
        </div>
        <div class="col-8 text-start text-container">
          <h3 class="text-header">Delete Tournament?</h3>   <!--header-->
          <p>This will delete the tournament and its data permanently. This action cannot be undone.</p> <!--text-->
        </div>
        <div class="div">
          <button class="outline-button" id="delete-hide"><i class='bx bx-x'></i>Cancel</button>
          <div id="dynamicDeleteButton"></div>
        </div>
        </div>
      </div>
    </div>
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
        <div class="d-flex flex-row gap-2" id="userTools">
          <div class="searchbar-container flex-grow-1">
            <i class="bx bx-search bx-sm" id="searchIcon"></i>
            <input class="w-100 mt-1" type="text" id="searchInput" placeholder="Search" maxlength="25" autocomplete="off">
          </div>
          <div class="dropdown-center dropdown">
            <button type="button" class="btn btn-primary h-75 sort-dropdown-btn" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
              <div class="d-flex justify-content-center"><div class="me-2"><b>Sort by</b></div><div><i class='bx bx-filter mt-1'></i></div></div>
            </button>
            <ul class="dropdown-menu dropdown-menu-style">
              <div class="radio-set">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="eventRadio">
                  <label class="form-check-label" for="eventRadio">
                    Event Name
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="categoryRadio">
                  <label class="form-check-label" for="categoryRadio">
                    Category Name
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="dateTimeRadio" checked>
                  <label class="form-check-label" for="dateTimeRadio">
                    Date & Time
                  </label>
                </div>
                <li><hr class="dropdown-divider"></li>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="flexRadioDefault2" id="ascendingRadio" checked>
                  <label class="form-check-label" for="ascendingRadio">
                    Ascending
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="flexRadioDefault2" id="descendingRadio">
                  <label class="form-check-label" for="descendingRadio">
                    Descending
                  </label>
                </div>
              </div>
            </ul>
          </div>
        </div>
        <div id="active-tournaments">
        </div>
      </div>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
    </section>
    <!-- Scripts -->
    <script src="./js/script.js"></script>
    <script src="./js/theme.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
      // Store the values of the checked radio buttons in variables
      let flexRadioDefaultValue = "Date & Time";
      let flexRadioDefault2Value = "Ascending";
      let searchInputValue = "";
      var activeTournamentsDiv = $('#active-tournaments');

      // Event listener for the "input" event on the search input
      $("#searchInput").on("input", function() {
        // Get the current value of the input field
        searchInputValue = $(this).val();
        activeTournamentsDiv.empty();
        initializeDynamicContent(flexRadioDefaultValue, flexRadioDefault2Value, searchInputValue)
      });

      // Event Name, Category Name, and Date & Time radio buttons
      $("#eventRadio, #categoryRadio, #dateTimeRadio").on("click", function () {
        flexRadioDefaultValue = $(this).next().text().trim();
        initializeDynamicContent(flexRadioDefaultValue, flexRadioDefault2Value, searchInputValue)
      });
      
      // ASC and DESC radio buttons
      $("#ascendingRadio, #descendingRadio").on("click", function () {
        flexRadioDefault2Value = $(this).next().text().trim();
        initializeDynamicContent(flexRadioDefaultValue, flexRadioDefault2Value, searchInputValue)
      });

      function initializeDynamicContent(flexRadioDefaultValue, flexRadioDefault2Value, searchInputValue) {
        $.ajax({
          url: './php/TOU-fetch-active-tournament.php',
          type: 'POST',
          dataType: 'json',
          data: {
            flexRadioDefault: flexRadioDefaultValue,
            flexRadioDefault2: flexRadioDefault2Value,
            searchInputValue: searchInputValue
          },
          success: function(data) {
              activeTournamentsDiv.empty();

              if (data.length > 0) {
                data.forEach(function (tournament) {
                    var buttonHtml = ` 
                    <div class="div">     
                      <button class="danger-button" id="delete-show-${tournament.id}">Delete</button>
                      <button class="primary-button" id="edit-tournament-${tournament.id}">Edit</button>
                    </div>`;

                    var elementHtml = `
                        <div class="div">
                            <div class="element">
                                <div class="row">
                                    <div class="element-group col-sm-6 col-lg-3">
                                        <div class="element-label">Event Name</div>
                                        <div class="element-content">${tournament.event_name}</div>
                                    </div>
                                    <div class="element-group col-sm-6 col-lg-3">
                                        <div class="element-label">Category Name</div>
                                        <div class="element-content">${tournament.category_name}</div>
                                    </div>
                                     <div class="element-group col-sm-6 col-lg-3">
                                        <div class="element-label">Date & Time</div>
                                        <div class="element-content">${tournament.event_datetime}</div>
                                    </div>
                                    <div class="d-flex justify-content-end">${buttonHtml}</div>
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

                // Event listener for elements with IDs starting with "delete-show-"
                $("[id^='delete-show-']").on("click", function() {       
                  // Get the numerical ID from the clicked button's ID attribute
                  let numericalId = this.id.split("-").pop();
                  // Create the dynamic delete button with classes and icon
                  let dynamicDeleteButton = $(`<button class="danger-button" id="delete-tournament-${numericalId}"><i class='bx bx-trash'></i>Delete</button>`);
                  // Append the button to the dynamicDeleteButton div
                  $("#dynamicDeleteButton").empty();
                  $("#dynamicDeleteButton").append(dynamicDeleteButton);
                  $('#deleteWrapper').css("display", "flex");

                  // Event listener for elements with IDs starting with "delete-show-"
                  $("[id^='delete-tournament-']").on("click", function() {  
                    // Get the numerical ID from the clicked button's ID attribute
                    let numericalId = this.id.split("-").pop();
                    // Send AJAX request to the PHP script for handling the DELETE operation
                    $.ajax({
                      url: "./php/TOU-delete-bracket-form.php", // Replace with the path to your PHP script
                      method: "POST",
                      data: { id: numericalId },
                      success: function(response) {
                        // Handle the response from the server, if needed
                        $("#dynamicDeleteButton").empty();
                        $("#dynamicDeleteButton").append(dynamicDeleteButton);
                        $('#deleteWrapper').css("display", "none");
                        initializeDynamicContent(flexRadioDefaultValue, flexRadioDefault2Value, searchInputValue)
                      },
                      error: function(xhr, status, error) {
                        // Handle errors, if any
                        console.error(xhr.responseText);
                      }
                    });
                  });
                });

                $("#delete-hide").on("click", function() {
                  $('#deleteWrapper').css("display", "none");
                });
              } else {
                activeTournamentsDiv.empty();

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
                activeTournamentsDiv.empty();

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
      }

      initializeDynamicContent(flexRadioDefaultValue, flexRadioDefault2Value, searchInputValue)
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