<?php
    include './php/database_connect.php';
    include './php/sign-in.php';

    // Retrieve the id from the query string
    $id = $_GET['id'];

    // Check if the id is valid
    if ($id !== null && $id !== "") {
      // The id is valid, perform actions based on it
      
      // Prepare the SQL statement with a parameter placeholder
      $query = "SELECT bf.id, oen.event_name, olfe.category_name, bf.current_column FROM `tournament` AS tou 
      INNER JOIN bracket_forms AS bf
      ON tou.tournament_id = bf.id
      INNER JOIN ongoing_list_of_event AS olfe
      ON olfe.event_id = tou.event_id
      INNER JOIN ongoing_event_name AS oen
      ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
      WHERE bf.is_active = 1
      AND tou.has_set_tournament = 1
      AND tou.bracket_form_id IS NOT NULL
      AND olfe.is_archived = 0
      AND oen.is_done = 0
      AND olfe.is_deleted = 0
      AND bf.id = ?;";
      $stmt = mysqli_prepare($conn, $query);
      // Bind the id parameter to the prepared statement
      mysqli_stmt_bind_param($stmt, "i", $id);
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
        $current_column = $row['current_column'];         
      } else {
        header("Location: TOU-admin-manage-tournament.php");
      }
    }
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
    <!--Popup Cancel / Warning-->
    <div class="popup-background" id="cancelWrapper">
      <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-error prompt-icon warning-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Discard Changes?</h3>   <!--header-->
                <p>Any unsaved progress will be lost.</p> <!--text-->
            </div>
            <div class="div">
                <button class="outline-button" onclick="hideCancel()"><i class='bx bx-chevron-left'></i>Return</button>
                <button class="primary-button" id="cancel-btn"><i class='bx bx-x'></i>Discard</button>
            </div>
        </div>
    </div>
    <section class="home-section flex-row">
      <div class="header">Manage Tournament</div>
        <div class="container-fluid d-flex row justify-content-center align-items-center flex wrap m-0">
            <div class="div">
                <div class="element">
                    <div class="row">
                        <div class="element-group">
                          <div class="element-label">Tournament ID #<?php echo $id; ?><br> Event: <?php echo $event_name;?><br> Category: <?php echo $category_name;?></div>
                            <div class="element-content">
                              <?php 
                                $query2 = "SELECT ot.id AS team_one_id,
                                ot2.id AS team_two_id,
                                org.organization_name AS team_one_name,
                                org2.organization_name AS team_two_name,
                                ot.current_team_status AS team_one_status, 
                                ot2.current_team_status AS team_two_status,
                                bf.current_column FROM bracket_teams AS bt 
                                INNER JOIN ongoing_teams AS ot
                                ON ot.id = bt.team_one_id
                                INNER JOIN ongoing_teams AS ot2
                                ON ot2.id = bt.team_two_id
                                INNER JOIN organization AS org
                                ON ot.team_id = org.organization_id
                                INNER JOIN organization AS org2
                                ON ot2.team_id = org2.organization_id
                                INNER JOIN bracket_forms AS bf
                                ON bf.id = bt.bracket_form_id
                                INNER JOIN tournament AS tou 
                                ON tou.bracket_form_id = bf.id
                                INNER JOIN ongoing_list_of_event AS olfe
                                ON olfe.event_id = tou.event_id
                                INNER JOIN ongoing_event_name AS oen
                                ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
                                AND bf.is_active = 1
                                AND (ot.current_team_status = 'active' OR ot2.current_team_status = 'active') 
                                AND bf.current_column = bt.current_column
                                AND olfe.event_type_id = 1 
                                AND oen.is_done = 0 
                                AND olfe.is_archived = 0 
                                AND olfe.is_deleted = 0
                                AND tou.has_set_tournament = 1
                                AND bf.id = ?;";

                                $stmt2 = mysqli_prepare($conn, $query2);
                                // Bind the id parameter to the prepared statement
                                mysqli_stmt_bind_param($stmt2, "i", $id);
                                // Execute the prepared statement
                                mysqli_stmt_execute($stmt2);
                                // Get the result of the query
                                $result2 = mysqli_stmt_get_result($stmt2);

                                if (mysqli_num_rows($result2) === 0) {

                                  // SQL query with a placeholder for the $id value
                                  $sql = "SELECT COUNT(*) AS active_teams_count FROM ongoing_teams WHERE current_team_status = 'active' AND bracket_form_id = ?";

                                  // Prepare the statement
                                  $stmt = $conn->prepare($sql);

                                  // Bind the $id variable to the prepared statement as a parameter
                                  $stmt->bind_param("i", $id);

                                  // Execute the prepared statement
                                  $stmt->execute();

                                  // Bind the result to a variable
                                  $stmt->bind_result($active_teams_count);

                                  // Fetch the result
                                  $stmt->fetch();

                                  // Close the statement
                                  $stmt->close();

                                  if ($active_teams_count === 1) {
                                    echo '<div class="d-flex justify-content-center mt-5">
                                      <img src="./pictures/finished_brackets.svg" class="img-fluid" alt="Finished Brackets" width="500" height="600">
                                    </div>
                                    <br>
                                    <div class="d-flex justify-content-center">
                                      <h3>Tournament Finished</h3>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                      <p>Looks like this tournament needs a push to conlcusion!</p>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                      <button class="danger-button conclude-btn" id="'.$id.'">Conlude Tournament</button>
                                    </div>
                                    <script>
                                    $(\'.conclude-btn\').click(function() {
                                      // Get the ID from the button\'s ID attribute
                                      let id = $(this).attr(\'id\');

                                      // Make the AJAX POST request
                                      $.ajax({
                                        url: \'./php/TOU-conclude-tournament.php\',
                                        type: \'POST\',
                                        data: {id: id}, // Send the ID to the PHP script
                                        success: function(response) {
                                          // Redirect to the desired page after the AJAX request is successful
                                          window.location.href = \'TOU-admin-manage-tournament.php\';
                                        },
                                        error: function(xhr, status, error) {
                                          // Handle errors (if any)
                                          console.error(error);
                                        }
                                      });
                                    });
                                    </script>
                                    ';
                                  } else {
                                    echo '<div class="d-flex justify-content-center mt-5">
                                      <img src="./pictures/Advance_Tournament.svg" class="img-fluid" alt="Advance Tournament" width="500" height="600">
                                    </div>
                                    <br>
                                    <div class="d-flex justify-content-center">
                                      <h3>Matches Ended</h3>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                      <p>Looks like this tournament needs a push to advancement!</p>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                      <button class="danger-button advance-btn" id="'.$id.'">Advance Tournament</button>
                                    </div>
                                    <script>
                                    $(\'.advance-btn\').click(function() {
                                      // Get the ID from the button\'s ID attribute
                                      let id = $(this).attr(\'id\');

                                      // Make the AJAX POST request
                                      $.ajax({
                                        url: \'./php/TOU-advance-tournament.php\',
                                        type: \'POST\',
                                        data: {id: id}, // Send the ID to the PHP script
                                        success: function(response) {
                                          // Reload the page after the AJAX request is successful
                                          location.reload();
                                        },
                                        error: function(xhr, status, error) {
                                          // Handle errors (if any)
                                          console.error(error);
                                        }
                                      });
                                    });
                                    </script>
                                    ';
                                  }
                                } else {
                                  while ($row2 = mysqli_fetch_assoc($result2)) {
                                    $team_one_id = $row2['team_one_id'];
                                    $team_two_id = $row2['team_two_id'];
                                    $team_name_one = $row2['team_one_name'];
                                    $team_name_two = $row2['team_two_name'];

                                    echo '<form method="POST" action="./php/TOU-process-scheduling.php" id="myForm">
                                    <input type="hidden" id="id" name="id" value="'.$id.'">
                                    <div class="container text-center p-2 fs-4">
                                      <div class="row align-items-center">
                                          <div class="col">
                                    <input type="hidden" id="team_one_id" name="team_one_id[]" value="'.$team_one_id.'">' .
                                    '<input type="hidden" id="team_two_id" name="team_two_id[]" value="'.$team_two_id.'">
                                      <div class="container mt-5">
                                        <div class="row">
                                          <div class="col text-center">
                                            <h2>'.$team_name_one.' vs '.$team_name_two.'</h2>
                                          </div>
                                        </div>
                                        <div class="row mt-3">
                                          <div class="col-md-6 offset-md-3 col-sm-12">
                                            <label for="matchDateTime">Match Date and Time:</label><br>
                                            <input type="datetime-local" name="event_date_time[]" id="eventDateTimeInput" class="form-control">
                                          </div>
                                        </div>
                                      </div>
                                      <div id="error-container" style="color: red;"></div>
                                      <br>
                                      <div class="div d-flex justify-content-end">
                                      <button type="button" class="outline-button" onclick="showCancel()">Cancel</button>
                                      <button id="submit" type="submit" class="primary-button float-end">Submit</button>
                                    </div>
                                  </form>
                                  ';                                                                          
                                  }
                                }                                      
                              ?>
                            </div>
                          <br>
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
        // Get the current date and time in the format YYYY-MM-DDTHH:mm (datetime-local format)
  function getCurrentDateTime() {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');

    return `${year}-${month}-${day}T${hours}:${minutes}`;
  }

  // Attach the event listener to the datetime-local input
  const datetimeInput = document.querySelector('input[type="datetime-local"]');
  datetimeInput.setAttribute('min', getCurrentDateTime());

        // Cancel
        popupCancel = document.getElementById('cancelWrapper');
  
        var showCancel = function() {
            popupCancel.style.display ='flex';
        }
        var hideCancel = function() {
            popupCancel.style.display ='none';
        }

        // Attach a click event handler to the button with id "cancel-btn"
  $('#cancel-btn').on('click', function() {
    // Set the URL you want to redirect to
    var redirectUrl = 'TOU-admin-manage-tournament.php'; // Replace this with the desired URL

    // Perform the redirection
    window.location.href = redirectUrl;
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