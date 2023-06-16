<?php include './php/database_connect.php' ?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event History | Manage Event</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="./css/theme-mode.css">
    <script src="./js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">

     <!-- Event History CSS -->
     <link rel="stylesheet" href="./css/HIS-manage-v1.css">
     


<!--
  Event History Configurations
---->
<form method="GET" action="?search=<?php echo $search_term; ?>">
  </head>

  <body>
    <!--Sidebar-->
   <?php
      // Set the active module and sub-active sub-item variables
      $activeModule = 'event-history';
      $activeSubItem = 'event-page';

      // Include the sidebar template
      require './php/admin-sidebar.php';
    ?>
    <!--Page Content-->
    <section class="home-section">
    <div class="header">Manage Event</div>
    <div class="flex-container">
        <div class="main-containers">
            <div class="container-header">Events</div>
            <div class="flex-box-1">
                <div class="search-wrapper">
                    <input type="text" maxlength="50" name="search" id="search" placeholder="Search Event" onkeyup="filterButtons()">
                </div>
                <div id="button-container">
    <?php
    $query = "SELECT event_history_id, event_name, category_name FROM eventhistorytb GROUP BY event_name";
    $result = mysqli_query($conn, $query);

    if ($result === false) {
        die('Query Error: ' . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $eventHistoryId = $row['event_history_id'];
            $eventName = $row['event_name'];

            echo "<button id='event_" . $eventName . "' class='event_button' data-event-history-id='$eventHistoryId' onclick='handleEventClick(\"$eventName\")'>$eventName</button>";
        }
    } else {
        echo "No events found.";
    }
    ?>
</div>

            </div>
            <div class="container-header-1">Activities</div>
            <div class="flex-box">
            <div id="select_event_text">Select an event first</div>
<div class="radio-holder">
    <?php
    if ($result->num_rows > 0) {
        $result->data_seek(0);
        while ($row = $result->fetch_assoc()) {
            $eventName = $row['event_name'];

            echo "<div class='activity_container' id='activity_" . $eventName . "' style='display:none;'>";

            $query = "SELECT category_name, suggested_status FROM eventhistorytb WHERE event_name = '" . $eventName . "'";
            $categoryResult = mysqli_query($conn, $query);

            if ($categoryResult === false) {
                die('Query Error: ' . mysqli_error($conn));
            }

            if (mysqli_num_rows($categoryResult) > 0) {
                $categories = array();
                while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
                    $categoryName = $categoryRow['category_name'];
                    $suggestedStatus = $categoryRow['suggested_status'];
                    $categories[] = array(
                        'name' => $categoryName,
                        'status' => $suggestedStatus
                    );
                }
                $maxLength = max(array_map('strlen', array_column($categories, 'name')));

                foreach ($categories as $category) {
                    $categoryName = $category['name'];
                    $suggestedStatus = $category['status'];
                    $isChecked = $suggestedStatus == 1 ? 'checked' : '';

                    echo "<label class='form-check'>";
                    echo "<input class='form-check-input' type='checkbox' name='activity_" . $eventName . "[]' value='" . $categoryName . "' " . $isChecked . ">";
                    echo "<span class='form-check-label'>" . str_pad($categoryName, $maxLength, ' ', STR_PAD_RIGHT) . "</span>";
                    echo "</label>";
                }
            }

            echo "</div>";
        }
    }
    ?>
</div>

            </div>
<div class="btn-group" id="diffbutton">
    <button type="button" id="add_button"> Update </button>
</div>
</div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> <!-- Include SweetAlert2 library -->

<script>
  document.getElementById("add_button").addEventListener("click", function() {
    Swal.fire({
      title: 'Are you sure?',
      text: 'Suggest activity/ies?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, suggest activities!'
    }).then((result) => {
      if (result.isConfirmed) {
        // Check for changes in the checkboxes
        var checkboxes = document.querySelectorAll('.activity_container input[type="checkbox"]');
        var hasChanges = Array.from(checkboxes).some(function (checkbox) {
          return checkbox.checked !== checkbox.defaultChecked;
        });

        if (hasChanges) {
          // Get the selected activities
          var selectedActivities = Array.from(document.querySelectorAll('input[name^="activity_"]:checked'))
            .map(input => input.value);

          // Make an AJAX request to update the suggested_status in the database
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "./php/HIS-update_suggested_status.php", true);
          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              // Display a success message
              Swal.fire({
                title: 'Suggest Success',
                text: 'Activities suggested successfully!',
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
              }).then((result) => {
                // Refresh the page
                if (result.isConfirmed) {
                  location.reload();
                }
              });
              console.log(xhr.responseText);
            }
          };
          xhr.send("activities=" + encodeURIComponent(JSON.stringify(selectedActivities)));
        } else {
          // Display an error message for no changes
          Swal.fire({
            title: 'Error',
            text: 'No changes applied.',
            icon: 'error',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          });
        }
      }
    });
  });
</script>





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- Scripts -->
    <script src="./js/script.js"></script>
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
    </script>
    <!--
Event History Scripts
-->

<script>

const searchInput = document.getElementById('search');
    const buttons = document.querySelectorAll('#button-container button');

    searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value.toLowerCase();
        buttons.forEach(button => {
            const buttonName = button.textContent.toLowerCase();
            if (buttonName.includes(searchTerm)) {
                button.style.display = 'block';
            } else {
                button.style.display = 'none';
            }
        });
    });
    </script>
 
<script>
  var event_buttons = document.getElementsByClassName("event_button");
  var selectEventText = document.getElementById("select_event_text");
  var selected_event = null;
  
  for (var i = 0; i < event_buttons.length; i++) {
    event_buttons[i].addEventListener("click", function() {
      var prev_selected_button = document.querySelector(".selected");
      if (prev_selected_button) {
        prev_selected_button.classList.remove("selected");
      }
      
      var prev_activity_container = document.querySelector(".activity_container.show");
      if (prev_activity_container) {
        prev_activity_container.classList.remove("show");
        prev_activity_container.style.display = "none";
      }
      
      if (selected_event !== this) {
        this.classList.add("selected");
        selected_event = this;
        var event_id = this.id.split("_")[1];
        var activity_container = document.getElementById("activity_" + event_id);
        if (activity_container.style.display === "none") {
          activity_container.classList.add("show");
          activity_container.style.display = "block";
        } else {
          activity_container.classList.remove("show");
          activity_container.style.display = "none";
        }
        
        selectEventText.style.display = "none";
      } else {
        selected_event = null;
        selectEventText.style.display = "block";
      }
    });
  }
            
</script>
  </body>

</html>