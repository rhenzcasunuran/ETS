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
    <title>Edit Tournament</title>
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
      $activeSubItem = 'manage-tournament';

      // Include the sidebar template
      require './php/admin-sidebar.php';
    ?>
    <section class="home-section flex-row">
      <div class="header">Edit Tournament</div>
        <div class="container-fluid d-flex row justify-content-center align-items-center flex wrap m-0">
            <?php
              // Retrieve the id from the query string
              $id = $_GET['id'];

              // Check if the id is valid
              if ($id !== null && $id !== "") {
                // The id is valid, perform actions based on it
                
                // Prepare the SQL statement with a parameter placeholder
                $query = "SELECT bf.id, bf.max_column, bf.current_column, bf.current_column_status, bf.category_name, bf.event_name, ot.team_name, ot.current_team_status, ot.current_overall_score, ot.current_score FROM bracket_forms AS bf INNER JOIN ongoing_teams AS ot ON bf.id = ot.bracket_form_id WHERE bf.id = ? AND bf.is_active = 1";
                $stmt = mysqli_prepare($conn, $query);
                // Bind the id parameter to the prepared statement
                mysqli_stmt_bind_param($stmt, "s", $id);
                // Execute the prepared statement
                mysqli_stmt_execute($stmt);
                // Get the result of the query
                $result = mysqli_stmt_get_result($stmt);

                // Fetch the rows from the result set
                if (mysqli_num_rows($result) > 0) {
                  // Fetch the data from the result
                  $row = mysqli_fetch_assoc($result);

                  $id = $row['id']; 
                  $event_name = $row['event_name'];    
                  $category_name = $row['category_name'];             
                }
              }
            ?>
            <div class="div">
                <div class="element">
                    <div class="row">
                        <div class="element-group">
                            <div class="element-label">Tournament ID #<?php echo $id; ?><br> Event: <?php echo $event_name;?><br> Category: <?php echo $category_name;?></div>
                            <br>
                            <div class="element-content">
                              <form method="POST" action="./php/TOU-process-scheduling.php">
                                <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
                                <input type="hidden" id="event_name" name="event_name" value="<?php echo $event_name;?>">
                                <input type="hidden" id="category_name" name="category_name" value="<?php echo $category_name;?>">
                                <div class="container text-center p-2 fs-4">
                                  <div class="row align-items-center">
                                      <div class="col">
                                        <?php 
                                          $query2 = "SELECT ot.id AS team_one_id,
                                          ot2.id AS team_two_id,
                                          ot.team_name AS team_one_name,
                                          ot2.team_name AS team_two_name,
                                          ot.current_team_status AS team_one_status, 
                                          ot2.current_team_status AS team_two_status 
                                          FROM bracket_teams AS bt 
                                          INNER JOIN bracket_forms AS bf ON bt.bracket_form_id = bf.id
                                          INNER JOIN ongoing_teams AS ot ON ot.id = bt.team_one_id
                                          INNER JOIN ongoing_teams AS ot2 ON ot2.id = bt.team_two_id
                                          WHERE bf.id = ?";

                                          $stmt2 = mysqli_prepare($conn, $query2);
                                          // Bind the id parameter to the prepared statement
                                          mysqli_stmt_bind_param($stmt2, "s", $id);
                                          // Execute the prepared statement
                                          mysqli_stmt_execute($stmt2);
                                          // Get the result of the query
                                          $result2 = mysqli_stmt_get_result($stmt2);

                                          if (mysqli_num_rows($result2) === 0) {
                                          echo "<h1>No Tournament Brackets to Schedule</h1>";
                                          } else {
                                          while ($row2 = mysqli_fetch_assoc($result2)) {
                                          $team_one_id = $row2['team_one_id'];
                                          $team_two_id = $row2['team_two_id'];
                                          $team_name_one = $row2['team_one_name'];
                                          $team_name_two = $row2['team_two_name'];

                                          echo '<input type="hidden" id="team_one_id" name="team_one_id[]" value="'.$team_one_id.'">' .
                                          '<input type="hidden" id="team_two_id" name="team_two_id[]" value="'.$team_two_id.'">' .
                                          '<div class="d-inline-flex p-2 justify-content-between">' .
                                          '<div>' . $team_name_one  . '</div>'.
                                          '<div>' . ' vs ' . '</div>'.
                                          '<div>'. $team_name_two . '</div>' .
                                          '<select class="form-select w-50" aria-label="Default select example" name="event_id[]"></select>' .
                                          '</div>' . '<br>';
                                          }

                                        }                                      
                                        ?>
                                      </div>
                                  </div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary float-end">Submit</button>
                              </form>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Scripts -->
    <script src="./js/script.js"></script>
    <script src="./js/theme.js"></script>
    <script type="text/javascript">
  $(document).ready(function() {
    // Retrieve the values of event_name and category_name
    var event_name = $('#event_name').val();
    var category_name = $('#category_name').val();

    // Create an AJAX request
    $.ajax({
      url: './php/TOU-json-get-event-ids.php',
      type: 'POST',
      data: {
        event_name: event_name,
        category_name: category_name
      },
      success: function(response) {
        // Handle the response from the PHP script
        var eventIds = JSON.parse(response);

        // Iterate through each select element and populate the options
        $('select[name="event_id[]"]').each(function(index) {
          var select = $(this);

          // Clear existing options
          select.empty();

          // Add default option
          select.append('<option selected value="">Select Match Schedule</option>');

          // Add options using eventIds array
          for (var i = 0; i < eventIds.length; i++) {
            select.append('<option value="' + eventIds[i] + '">' + eventIds[i] + '</option>');
          }
        });

        // Add change event listener to all select elements
        $('select[name="event_id[]"]').change(function() {
          var selectedValues = [];
          var errorContainer = $('#error-container');
          errorContainer.empty();

          // Iterate through all select elements
          $('select[name="event_id[]"]').each(function() {
            var value = $(this).val();

            // Check if value is not empty and already exists in selectedValues array
            if (value && selectedValues.includes(value)) {
              errorContainer.text('Same event dates are not allowed');
              return false; // Stop the iteration
            }

            // Add value to selectedValues array
            selectedValues.push(value);
          });
        });
      },
      error: function(xhr, status, error) {
        // Handle any errors that occur during the AJAX request
        console.log(error);
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