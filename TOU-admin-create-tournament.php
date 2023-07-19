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
        function populateEvents() {
            // Make an AJAX request to retrieve the event data
            $.ajax({
                url: './php/TOU-get-json-events.php', // Replace with the correct file path
                type: 'GET',
                success: function(response) {
                    // Parse the JSON response
                    const data = response;

                    // Populate the event select element
                    var eventSelect = $('#event_name');
                    eventSelect.empty(); // Clear previous options
                    $.each(data.events, function(index, event) {
                        eventSelect.append($('<option></option>').val(event).text(event));
                    });

                    // Trigger change event on initial page load or when events are populated
                    eventSelect.trigger('change');
                },
                error: function() {
                    console.log('Error occurred while retrieving event data.');
                }
            });
        }

        function populateCategories(selectedEvent) {
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

                    // Trigger change event for the category select element after populating
                    categorySelect.trigger('change');
                },
                error: function() {
                    console.log('Error occurred while retrieving category data.');
                }
            });
        }

        // Event change event handler
        $('#event_name').on('change', function() {
            var selectedEvent = $(this).val();
            populateCategories(selectedEvent);
        });

// Category change event handler
$('#category_name').on('change', function() {
  var selectedEvent = $('#event_name').val();
  var selectedCategory = $(this).val();

  // Make an AJAX request to retrieve the number of wins for the selected event and category
  $.ajax({
    url: './php/TOU-get-json-no-of-wins.php', // Replace with the actual path to your PHP script
    method: 'GET',
    data: {
      event: selectedEvent,
      category: selectedCategory // Send the selected category as well, if needed
    },
    dataType: 'json',
    success: function(response) {
      // Update the DOM with the received data
      var $div = $('#best_of_no_display');
      var $hiddenInput = $('#best_of_no');

      // Display the number_of_wins_number in the div
      $div.text(response.number_of_wins);

      // Set the number_of_wins_number in the hidden input
      $hiddenInput.val(response.number_of_wins_number);

      // Generate input fields based on the number of wins
      generateInputFields(response.number_of_wins_number);

      // Call the validation function to hide/show the error message
      validateInputs();
    },
    error: function(xhr, status, error) {
      // Handle the error, if any
      console.error(error);
    }
  });
});

// Populate events on page load
populateEvents();

function isNonZeroPositiveInteger(inputValue) {
  return /^\d+$/.test(inputValue) && parseInt(inputValue) > 0;
}

function generateInputFields(numberOfWinsNumber) {
  // Clear existing input fields and error message
  $('#dynamic-inputs-match-max').empty();

  // Create and display input fields based on the number of wins
  for (var i = 1; i <= numberOfWinsNumber; i++) {
    var inputField = $('<input>').attr({
      type: 'text',
      name: 'dynamic-inputs-match-max[' + i + ']',
      required: true,
      maxlength: 3 // Set maximum length to 3 characters
    });

    // Add the keypress event to the input field
    inputField.on('keypress', function (event) {
      var charCode = event.which ? event.which : event.keyCode;

      // Only allow digits (0-9) and prevent non-numeric input
      if (charCode < 48 || charCode > 57) {
        event.preventDefault();
      }
    });

    // Add the input event to the input field
    inputField.on('input', function (event) {
      var inputValue = $(this).val();

      // Remove any non-numeric characters (including emojis)
      var sanitizedValue = inputValue.replace(/\D/g, '');
      $(this).val(sanitizedValue);
    });

    // Add the paste event to the input field
    inputField.on('paste', function (event) {
      // Access the clipboard data
      var clipboardData = event.originalEvent.clipboardData || window.clipboardData;
      var pastedData = clipboardData.getData('text/plain');

      // Remove any non-numeric characters (including emojis)
      var sanitizedValue = pastedData.replace(/\D/g, '');

      // Manually set the input value after sanitizing
      $(this).val(sanitizedValue);

      // Prevent the default paste behavior
      event.preventDefault();
    });

    // Append the input field to the dynamic-inputs-match-max div
    $('#dynamic-inputs-match-max').append(inputField);
  }
}


// Event delegation to check if all input fields have a value
$('#dynamic-inputs-match-max').on('input', 'input[type="text"]', function() {
  var allInputsFilled = true;

  // Check if any input field is empty
  $('#dynamic-inputs-match-max input[type="text"]').each(function() {
    if ($(this).val().trim() === '') {
      allInputsFilled = false;
      return false; // Exit the loop early since at least one input field is empty
    }
  });

  // Display/hide the error message based on the validation result
  var errorDiv = $('#error-dynamic-inputs-match-max');
  if (allInputsFilled) {
    errorDiv.hide();
  } else {
    errorDiv.show();
  }
});


  // Get the necessary elements
  const gameTypeSelect = document.getElementById('gameTypeSelect');
  const errorDisplay = document.getElementById('error-display');

  // Add event listener to the select element
  gameTypeSelect.addEventListener('change', function () {
    // Check if a valid option is selected
    const selectedValue = gameTypeSelect.value;
    if (selectedValue === '') {
      // Display the error message if no valid value is selected
      errorDisplay.style.display = 'block';
      submitButton.disabled = true;
    } else {
      // Hide the error message if a valid value is selected
      errorDisplay.style.display = 'none';
    }
  });

  // Attach a click event listener to the form element
document.getElementById('myForm').addEventListener('click', function(event) {
  // Check if any of the error messages have "display: block" style
  var errorMessages = document.querySelectorAll('.text-danger');
  var isErrorDisplayed = false;

  errorMessages.forEach(function (errorMessage) {
    if (window.getComputedStyle(errorMessage).display === 'block') {
      isErrorDisplayed = true;
      return;
    }
  });

  // Enable or disable the submit button based on the error status
  var submitButton = document.getElementById('submitButton');
  submitButton.disabled = isErrorDisplayed;
});

});
</script>
    <section class="home-section flex-row">
      <div class="header">Create Tournament</div>
        <div class="container-fluid d-flex row justify-content-center align-items-center flex wrap m-0">
            <div class="element">
                <div class="row">
                    <div class="element-group">
                    <form method="POST" action="./php/TOU-process-tournament.php" id="myForm">
                       <!-- Add the gameTypeSelect and bestOfDropdown values -->
                        <div class="d-flex justify-content-start">
                            Event: 
                            <div style="margin-left: 5px;"></div>
                            <select id="event_name" name="event_name"></select>
                            <div style="margin-left: 10px;"></div>
                            Category: 
                            <div style="margin-left: 5px;"></div>
                            <select id="category_name" name="category_name"></select>
                            <div style="margin-left: 10px;"></div>
                            Match Style:
                            <div style="margin-left: 5px;"></div>
                            <div id="best_of_no_display"></div>
                            <input type="hidden" id="best_of_no" name="best_of_no" required>
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
                                  <select id="gameTypeSelect" name="gameTypeSelect" class="form-select w-75 text-center" required>
                                    <option selected disabled>Select whether time or score based</option>
                                    <option value="score-based">Score-based</option>
                                    <option value="time-based">Time-based</option>
                                  </select>
                                  <br>
                                  <div class="w-75 text-center" id="noOfMatches">
                                    <div id="dynamic-inputs-match-max">
                                  </div>
                                </div>
                                <br>
                              </div>
                          </div>
                        </div>                        
                        <br>
                        <div id="error-display" class="text-danger">
                          *Please select a game type.
                        </div>
                        <div id="error-dynamic-inputs-match-max" class="text-danger">
                          *Please fill in the input.
                        </div>
                        <div id="error-message-no-team" class="text-danger">
                          *Please select teams.<br>
                          *Note: Duplicate or odd number of teams are not allowed.
                        </div>
                        <div class="d-flex justify-content-end">
                        <button type="submit" id="submitButton" class="btn btn-primary" disabled>Submit</button>
                        </div>
                    </form>

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

  var errorMessage = document.getElementById('error-message-no-team');
  var isOddNumber = selects.length % 2 !== 0;

  // Show the error message if there are no input fields or if there's a duplicate team
  errorMessage.style.display = selects.length === 0 || errorOccurred || isOddNumber ? 'block' : 'none';

  // Disable or enable the submit button based on the error status
  var submitButton = document.getElementById('submitButton');
  if (selects.length === 0 || errorOccurred || isOddNumber) {
    submitButton.disabled = true;
  }
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