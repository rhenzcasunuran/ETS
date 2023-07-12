<?php
  session_start();
  @include './php/database_connect.php';

  // Query to retrieve data from the database
  $sql = "SELECT team1_id, team2_id FROM tou_bracket";
  $result = $conn->query($sql);

  @include './php/TOU-fetch-data.php';
  @include './php/TOU-scoring.php';

  // Fetch option values from MySQL
  $sql = "SELECT organization.organization_name, tou_team_stat.winning, tou_team_stat.team_id
  FROM organization
  INNER JOIN tou_team_stat ON organization.organization_id = tou_team_stat.organization_id WHERE tournament_id = 8";
  $result = $conn->query($sql);

  

  // Store options and default values in arrays
$options = [];
$defaultValues = [];
$idValues = [];


if ($result->num_rows) { // Exclude the first row
 // Move the pointer to the second row
    while ($row = $result->fetch_assoc()) {
        $options[] = $row["organization_name"];
        $defaultValues[] = $row["winning"];
        $idValues[] = $row["team_id"];
    }
}

$sql = "SELECT winning FROM tou_team_stat";
$wins = [];

$sql = "SELECT category_name FROM ongoing_list_of_event WHERE event_type_id = 1 AND is_archived = 0";
$result = $conn->query($sql);
$sports = [];




  // Close the database connection
  $conn->close();
?>

<script>

// JavaScript code (using jQuery)
function updateSelectedValue(dropdown) {
  var selectedIndex = dropdown.selectedIndex;
  var selectedOption = dropdown.options[selectedIndex];
  var selectedValue = selectedOption.value;

  // AJAX request to fetch the ID
  $.ajax({
    url: 'get_id.php',
    type: 'POST',
    data: { selectedValue: selectedValue },
    success: function(response) {
      // Update the hidden input field with the fetched ID
      var dropdownID = $(dropdown).data('index');
      $('#dropdownID_' + dropdownID).val(response);
      
      // Display the ID in a separate element
      $('#dropdownID_' + dropdownID + '_display').text(response);
    },
    error: function() {
      // Handle error if needed
    }
  });
}
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

        // JavaScript code (using jQuery)

    </script>
<!DOCTYPE html>
<html lang="en">

  <head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#dropdown').change(function() {
        var selectedValue = $(this).val();
        if (selectedValue !== '') {
          $.ajax({
            url: 'get_page_url.php',
            method: 'POST',
            data: { selectedValue: selectedValue },
            success: function(response) {
              if (response !== '') {
                window.location.href = response;
              }
            }
          });
        }
      });
    });
  </script>
    <style>
      form .wins {
    width: 50px;
    height: 50px;
    background-color: var(--color-body);
    border: transparent;
    color: var(--color-content-text);
}</style>
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
      
       <div class="Sports">
       <select id="dropdown">
    <option value="">Select Tournament</option>
    <?php
    // Connect to MySQL and fetch the dropdown options
    $connection = mysqli_connect('localhost', 'root', '', 'ets');
    $query = "SELECT * FROM dropdown_options";
    $result = mysqli_query($connection, $query);
    
    while ($row = mysqli_fetch_assoc($result)) {
      echo '<option value="' . $row['category_name'] . '">' . $row['category_name'] . '</option>';
    }
    
    mysqli_close($connection);
    ?>
  </select>
</div>
<div>
  BASKETBALL
  </div>

        

    </div>

    <div class="Container"> <!--part 1: Branch 1 going to contain everything 1x of this-->
    <div class="quarter-finals">
    <form action="./php/process_form.php" method="POST">
    <?php
    // Display multiple dropdowns
    for ($i = 1; $i <= 8; $i++) {
        echo '<div class="dropdown-container">';
        echo '<select name="dropdown' . $i . '" onchange="updateSelectedValue(this)" data-index="' . ($i - 1) . '" class="custom-dropdown">';
        
        // Add default option
        echo '<option value="">Select team</option>';
        
        // Add options from the fetched values
        for ($j = 0; $j < count($options); $j++) {
            echo '<option value="' . $idValues[$j] . '">' . $options[$j] . '</option>';
        }
        
        echo '</select>';
        
        // Add input field
        echo '<input type="text" class="wins" id="inputField' . $i . '" name="inputField' . $i . '" value="' . $defaultValues[$i - 1] . '">';
        
        // Add hidden input field for ID
        echo '<input type="hidden" id="dropdownID_' . ($i - 1) . '" name="dropdown' . $i . '_id" value="">';
        
        echo '</div>';
        
        if ($i % 2 == 0) {
            // Add a line break or any other separator for even-numbered dropdowns
            echo '<br>';
        }
    }
    ?>
    <input type="submit" value="Submit">
</form> </div>
<div class = "semi-finals">
    <form id="myForm" method="post" action="./php/update_mysql.php">
    <?php
    // Display multiple dropdowns
    for ($i = 1; $i <= 4; $i++) {
        echo '<div class="dropdown-container">';
        echo '<select name="dropdown"' . $i . '" onchange="updateSelectedValue(this)" data-index="' . ($i - 1) . '" class="custom-dropdown">';

        // Add default option
        echo '<option value="">Select team</option>';

        // Add options from the array
        foreach ($options as $option) {
            echo '<option value="' . $option . '">' . $option . '</option>';
        }

        echo '</select>';

        // Add input field
        echo '<input type="text" class="wins" id="inputField' . $i . '" name="inputField' . $i . '" value="' . $defaultValues[$i - 1] . '">';

        echo '</div>';

        if ($i % 2 == 0) {
            // Add a line break or any other separator for even-numbered dropdowns
            echo '<br>';
        }
    }
?></div>
<div class = "finals">
    <form id="myForm" method="post" action="./php/update_mysql.php">
    <?php
    // Display multiple dropdowns
    for ($i = 1; $i <= 2; $i++) {
        echo '<div class="dropdown-container">';
        echo '<select name="dropdown"' . $i . '" onchange="updateSelectedValue(this)" data-index="' . ($i - 1) . '" class="custom-dropdown">';

        // Add default option
        echo '<option value="">Select team</option>';

        // Add options from the array
        foreach ($options as $option) {
            echo '<option value="' . $option . '">' . $option . '</option>';
        }

        echo '</select>';

        // Add input field
        echo '<input type="text" class="wins" id="inputField' . $i . '" name="inputField' . $i . '" value="' . $defaultValues[$i - 1] . '">';

        echo '</div>';

        if ($i % 2 == 0) {
            // Add a line break or any other separator for even-numbered dropdowns
            echo '<br>';
        }
    }
    
?>
</div>

<button type="button" id="lockButton" onclick="lockSelection()">Save</button>
    <button type="submit" onclick="groupAndSubmit()">Submit</button>

  </div>
    
    <script>
        function groupAndSubmit() {
            var dropdowns = document.querySelectorAll('.custom-dropdown');
            var inputFields = document.querySelectorAll('.input-field');
            var groupedData = [];

            // Group dropdown and input field values
            for (var i = 0; i < dropdowns.length; i++) {
                var dropdownValue = dropdowns[i].value;
                var inputFieldValue = inputFields[i].value;
                groupedData.push({
                    dropdown: dropdownValue,
                    inputField: inputFieldValue
                });
            }

            // Create a hidden input field to store the grouped data as JSON
            var groupedDataInput = document.createElement('input');
            groupedDataInput.type = 'hidden';
            groupedDataInput.name = 'groupedData';
            groupedDataInput.value = JSON.stringify(groupedData);
            document.getElementById('myForm').appendChild(groupedDataInput);

            // Submit the form
            document.getElementById('myForm').submit();
        }
    </script>
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