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
        <?php
            // Perform the SQL query to retrieve the results
            $query = "SELECT * FROM bracket_forms";
            $result = mysqli_query($conn, $query);

            // Check if there are any results
            if (mysqli_num_rows($result) > 0) {
                echo '<div id="registered-tournament">';
                
                // Loop through each row of the results
                while ($row = mysqli_fetch_assoc($result)) {
                    // Extract the desired values from the row
                    $id = $row['id'];
                    $categoryName = $row['category_name'];
                    $eventName = $row['event_name'];
                    $isActive = $row['is_active'];
                    
                    // Generate the HTML for each result
                    echo '<div class="element">';
                    echo '    <div class="row">';
                    echo '        <div class="element-group">';
                    echo '            <h3>'.$eventName.'</h3><br>';
                    echo '            <p>Category: '.$categoryName.'</p>';
                    echo '            <div class="d-flex justify-content-between">';
                    echo '            <p><a href="TOU-admin-edit-tournament.php?id='.$id.'">Edit Tournament</a></p></div>';
                    echo '            ';
                    echo '        </div>';
                    echo '    </div>';
                    echo '</div>';
                }
                
                echo '</div>';
            } else {
                echo 'No results found.';
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
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