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
    <title>Create Tournament</title>
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
      $activeSubItem = 'create-tournament';

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
      <div class="header">Create Tournament</div>
        <div class="container-fluid d-flex row justify-content-center align-items-center flex wrap m-0">
            <div class="element">
                <div class="row">
                    <div class="element-group">
                    <form method="POST" action="./php/TOU-process-tournament.php">
                       <!-- Add the gameTypeSelect and bestOfDropdown values -->
                        <div class="d-flex justify-content-start">
                            Event:
                            <select id="event_name" name="event_name"></select>
                            <!-- Add spacing using CSS margin -->
                            <div style="margin-left: 10px;"></div>
                            Category:
                            <select id="category_name" name="category_name"></select>
                        </div>
                        <br>
                        <div class="container text-center">
                            <div class="row align-items-start">
                                <div class="col">
                                    <button type="button" class="btn btn-primary" onclick="addInput()">Add Team</button>
                                    <div id="dynamic-inputs">
                                        <!-- Additional form fields can be added here -->
                                    </div>
                                </div>
                                <div class="col">
                                  <select id="gameTypeSelect" name="gameTypeSelect" class="form-select w-75 text-center">
                                    <option selected disabled>Select whether time or score based</option>
                                    <option value="score-based">Score-based</option>
                                    <option value="time-based">Time-based</option>
                                  </select>
                                  <br>
                                  <select id="bestOfDropdown" name="bestOfDropdown" class="form-select w-75 text-center">
                                    <option selected disabled>Select no. of best of</option>
                                    <option value="1">Best of 1</option>
                                    <option value="2">Best of 2</option>
                                    <option value="3">Best of 3</option>
                                    <option value="4">Best of 4</option>
                                    <option value="5">Best of 5</option>
                                    <option value="6">Best of 6</option>
                                    <option value="7">Best of 7</option>
                                    <option value="8">Best of 8</option>
                                    <option value="9">Best of 9</option>
                                  </select>
                                  <br>
                                  <div class="w-75 text-center" id="gameOptions"></div>
                                </div>
                                <br>
                              </div>
                          </div>
                        </div>                        
                        <br>
                        <div class="d-flex justify-content-end">
                            <input type="submit" value="Submit">
                        </div>
                        <div id="error-message" class="invalid-feedback">
                            Duplicate or odd number of teams are not allowed.
                        </div>
                    </form>

                    <script>
                      const gameTypeSelect = document.getElementById('gameTypeSelect');
                      const bestOfDropdown = document.getElementById('bestOfDropdown');
                      const gameOptionsDiv = document.getElementById('gameOptions');

                      // Hide the second selection field initially
                      bestOfDropdown.style.display = 'none';

                      gameTypeSelect.addEventListener('change', function() {
                        bestOfDropdown.style.display = 'block';
                        const selectedValue = parseInt(bestOfDropdown.value);
                        generateGameOptions(selectedValue);
                      });

                      bestOfDropdown.addEventListener('change', function() {
                        const selectedValue = parseInt(bestOfDropdown.value);
                        generateGameOptions(selectedValue);
                      });

                      function generateGameOptions(selectedValue) {
                        gameOptionsDiv.innerHTML = '';

                        for (let i = 1; i <= selectedValue; i++) {
                          const containerDiv = document.createElement('div');
                          const inputField = document.createElement('input');
                          inputField.type = 'number';
                          inputField.name = 'game_options[' + i + ']';
                          inputField.placeholder = 'Enter value ' + i;

                          containerDiv.appendChild(inputField);
                          gameOptionsDiv.appendChild(containerDiv);
                        }
                      }
                    </script>

                    <script>
                        var maxInputs = 8; // Maximum number of input fields allowed
                        var currentInputs = 0; // Counter for current number of input fields
                        var dataTable = [
                            ['ACAP', 'ACAP'],
                            ['AECES', 'AECES'],
                            ['ELITE', 'ELITE'],
                            ['GIVE', 'GIVE'],
                            ['JEHRA', 'JEHRA'],
                            ['JMAP', 'JMAP'],
                            ['JPIA', 'JPIA'],
                            ['PIIE', 'PIIE']
                        ];
                        var selectedOptions = []; // Array to store the selected options

                        function addInput() {
                            if (currentInputs >= maxInputs) {
                                return; // Exit the function if the maximum limit is reached
                            }

                            var dynamicInputs = document.getElementById('dynamic-inputs');

                            // Create a new container div for the input field and remove button
                            var container = document.createElement('div');
                            container.classList.add('input-container');

                            // Create a select dropdown
                            var newSelect = document.createElement('select');
                            newSelect.setAttribute('name', 'dynamic_input[]');
                            newSelect.addEventListener('change', validateDuplicateTeams); // Add change event listener

                            // Add options to the select dropdown
                            for (var i = 0; i < dataTable.length; i++) {
                                var optionValue = dataTable[i][0];
                                var optionText = dataTable[i][1];
                                if (!selectedOptions.includes(optionValue)) {
                                    var option = document.createElement('option');
                                    option.value = optionValue;
                                    option.text = optionText;
                                    newSelect.add(option);
                                }
                            }

                            // Create a remove button
                            var removeButton = document.createElement('button');
                            removeButton.setAttribute('type', 'button');
                            removeButton.classList.add('btn', 'btn-danger');
                            removeButton.textContent = 'Remove Team';
                            removeButton.addEventListener('click', function() {
                                removeInput(container);
                                validateDuplicateTeams();
                            });

                            // Append the select dropdown and remove button to the container
                            container.appendChild(newSelect);
                            container.appendChild(removeButton);

                            // Append the container to the dynamic-inputs div
                            dynamicInputs.appendChild(container);

                            currentInputs++; // Increment the counter
                            validateDuplicateTeams(); // Validate teams after adding a new input
                        }

                        function removeInput(container) {
                            var dynamicInputs = document.getElementById('dynamic-inputs');
                            dynamicInputs.removeChild(container);
                            currentInputs--; // Decrement the counter

                            // Check if the counter goes below 0 and reset it to 0
                            if (currentInputs < 0) {
                                currentInputs = 0;
                            }

                            validateDuplicateTeams(); // Validate teams after removing an input
                        }

                        function validateDuplicateTeams() {
                            var selects = document.querySelectorAll('select[name="dynamic_input[]"]');
                            var selectedValues = [];
                            var errorOccurred = false;

                            for (var i = 0; i < selects.length; i++) {
                                var value = selects[i].value;
                                if (selectedValues.includes(value)) {
                                selects[i].classList.add('is-invalid');
                                errorOccurred = true;
                                } else {
                                selects[i].classList.remove('is-invalid');
                                }
                                selectedValues.push(value);
                            }

                            var errorMessage = document.getElementById('error-message');
                            var isOddNumber = selects.length % 2 !== 0; // Check if the number of fields is odd
                            errorMessage.style.display = errorOccurred || isOddNumber ? 'block' : 'none';
                            }

                    </script>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Scripts -->
    <script src="./js/script.js"></script>
    <script src="./js/theme.js"></script>
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