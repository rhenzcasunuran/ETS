<?php
include './php/database_connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
<?php include 'php/title.php' ?> 
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="Website Icon" type="png" href="./pictures/logo.png">

  <title>Event History | Manage Event</title>
  <!-- Theme Mode -->
  <link rel="stylesheet" href="./css/theme-mode.css">
  <script src="./js/default-theme.js"></script>
  <!-- Link Styles -->
  <link rel="stylesheet" href="./css/boxicons.css">
  <link rel="stylesheet" href="./css/responsive.css">
  <link rel="stylesheet" href="./css/sidebar-style.css">
  <link rel="stylesheet" href="./css/system-wide.css">

  <!-- Event History CSS -->
  <link rel="stylesheet" href="./css/HIS-manage-v1.css">
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

    <div class="header">Event Page</div>
    <div class="flex-container">
      <div class="main-containers">
        <div class="container-header">Events</div>
        <div class="flex-box-1">
          <div class="search-wrapper">
            <input type="text" maxlength="50" name="search" id="search" placeholder="Search Event" onkeyup="filterButtons()">
          </div>

          <?php
          // Pagination configuration
          $perPage = 5; // Number of buttons per page
          $page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number

          // Query to fetch events with pagination
          $query = "SELECT e.event_name, o.event_id
                    FROM ongoing_event_name e
                    JOIN ongoing_list_of_event o ON e.event_name_id = o.event_name_id
                    WHERE o.is_archived = 1 AND o.is_deleted = 0
                    GROUP BY e.ongoing_event_name_id  DESC";

          $result = mysqli_query($conn, $query);

          if ($result === false) {
              die('Query Error: ' . mysqli_error($conn));
          }

          $totalEvents = mysqli_num_rows($result); // Total number of events
          $totalPages = ceil($totalEvents / $perPage); // Total number of pages

          // Calculate the offset for the current page
          $offset = ($page - 1) * $perPage;

          // Query to fetch events for the current page
          $query .= " LIMIT $offset, $perPage";

          $result = mysqli_query($conn, $query);

          if ($result === false) {
              die('Query Error: ' . mysqli_error($conn));
          }

          if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                  $eventHistoryId = $row['event_id'];
                  $eventName = $row['event_name'];

                  echo "<button id='event_" . $eventName . "' class='event_button' data-event-history-id='$eventHistoryId' onclick='handleEventClick(\"$eventName\")'>$eventName</button>";
              }
          } else {
              echo "No events found.";
          }

          // Pagination links
          echo "<div class='pagination'>";

          // Limit the number of pagination links displayed
          $visiblePages = 2; // Set the number of visible pages

          // Calculate the start and end page numbers based on the visible pages
          $startPage = max($page - floor($visiblePages / 2), 1);
          $endPage = min($startPage + $visiblePages - 1, $totalPages);

          if ($endPage - $startPage + 1 < $visiblePages) {
              $startPage = max($endPage - $visiblePages + 1, 1);
          }

          // "Previous" button
          if ($page > 1) {
              echo "<a href='?page=" . ($page - 1) . "' class='pagination-link'><</a>";
          }

          // Pagination links
          for ($i = $startPage; $i <= $endPage; $i++) {
              $activeClass = $i == $page ? 'active' : '';
              echo "<a href='?page=$i' class='pagination-link $activeClass'><span>$i</span></a>";
          }

          // "Next" button
          if ($page < $totalPages) {
              echo "<a href='?page=" . ($page + 1) . "' class='pagination-link'>></a>";
          }

          echo "</div>";
          ?>

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

                    $query = "SELECT o.category_name, o.suggested_status, o.is_archived
                    FROM ongoing_list_of_event o
                    JOIN ongoing_event_name e ON o.ongoing_event_name_id = e.ongoing_event_name_id
                    WHERE e.event_name = '" . $eventName . "' AND o.is_archived = 1 AND o.is_deleted = 0";


                    $categoryResult = mysqli_query($conn, $query);

                    if ($categoryResult === false) {
                        die('Query Error: ' . mysqli_error($conn));
                    }

                    $categories = array(); // Initialize an array to store category names

                    // Retrieve all category names for the event
                    while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
                        $categoryName = $categoryRow['category_name'];
                        $suggestedStatus = $categoryRow['suggested_status'];
                        $categories[] = array(
                            'name' => $categoryName,
                            'status' => $suggestedStatus
                        );
                    }

                    if (!empty($categories)) {
                        $maxLength = max(array_map('strlen', array_column($categories, 'name')));

                        foreach ($categories as $category) {
                            $categoryName = $category['name'];
                            $isChecked = $category['status'] == 1 ? 'checked' : '';

                            echo "<label class='form-check'>";
                            echo "<input class='form-check-input' type='checkbox' name='activity_" . $eventName . "[]' value='" . $categoryName . "' " . $isChecked . ">";
                            echo "<span class='form-check-label'>" . str_pad($categoryName, $maxLength, ' ', STR_PAD_RIGHT) . "</span>";
                            echo "</label>";
                        }
                    } else {
                        echo "No categories found for this event.";
                    }

                    echo "</div>";
                }
            }
            ?>
          </div>
        </div>

        <div class="add-btn-container">
          <button id="add_button" class="add-btn">Update</button>
        </div>
      </div>
    </div>
    
  </section>
  <div class="popUpDisableBackground" id="markAsDone">
    <div class="popUpContainer">
        <!-- Icon for Success (Check) -->
        <i class="bx bxs-check-circle success-color" id="successIcon"></i>
        <!-- Icon for Error (Exclamation) -->
        <i class="bx bxs-error-circle warning-color" id="errorIcon"></i>
        <!-- Icon for Question (Question Mark) -->
        <i class='bx bx-question-mark' id="questionIcon"></i>
        <div class="popUpHeader">Mark as Done?</div>
        <div class="popUpMessage">Marked events will be removed from the events list and will transfer to the history.</div>
        <div class="popUpButtonContainer">
            <button class="secondary-button" id="cancelButton"><i class='bx bx-x'></i>Cancel</button>
                <button class="primary-button confirmPopUp"><i id="confirmIcon" class='bx bx-check'></i>Confirm</button>
                <button class="secondary-button" id="closeButton"><i class='bx bx-x'></i>Close</button>

              </a>
        </div>
    </div>
</div>





  <script src="./js/script.js"></script>
<script src="./js/jquery-3.6.4.js"></script>
<!--SweetAlert-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
  $('.menu_btn').click(function (e) {
    e.preventDefault();
    var $this = $(this).parent().find('.sub_list');
    $('.sub_list').not($this).slideUp(function () {
      var $icon = $(this).parent().find('.change-icon');
      var $icon = $(this).parent().find('.change-icon');
      $icon.removeClass('bx-chevron-down').addClass('bx-chevron-right');
    });

    $this.slideToggle(function () {
      var $icon = $(this).parent().find('.change-icon');
      $icon.toggleClass('bx-chevron-right bx-chevron-down')
    });
  });
</script>
<!-- Event History JS -->
<script>
  var event_buttons = document.querySelectorAll(".event_button");
  var selectEventText = document.getElementById("select_event_text");
  var activityContainers = document.querySelectorAll(".activity_container");

  var selectedEvent = null;

  function handleEventClick(eventName) {
    var eventButton = document.getElementById("event_" + eventName);

    var prevSelectedButton = document.querySelector(".selected");
    if (prevSelectedButton) {
      prevSelectedButton.classList.remove("selected");
    }

    var prevActivityContainer = document.querySelector(".activity_container.show");
    if (prevActivityContainer) {
      prevActivityContainer.classList.remove("show");
      prevActivityContainer.style.display = "none";
    }

    if (selectedEvent !== eventButton) {
      eventButton.classList.add("selected");
      selectedEvent = eventButton;
      var eventId = eventButton.dataset.eventHistoryId;
      var activityContainer = document.getElementById("activity_" + eventName);
      if (activityContainer.style.display === "none") {
        activityContainer.classList.add("show");
        activityContainer.style.display = "block";
      } else {
        activityContainer.classList.remove("show");
        activityContainer.style.display = "none";
      }

      selectEventText.style.display = "none";
    } else {
      selectedEvent = null;
      selectEventText.style.display = "block";
    }
  }

  function filterButtons() {
    var input, filter, buttons, button, i, txtValue;
    input = document.getElementById("search");
    filter = input.value.toUpperCase();
    buttons = document.querySelectorAll('.event_button'); // Select all event buttons

    for (i = 0; i < buttons.length; i++) {
      button = buttons[i];
      txtValue = button.textContent || button.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        button.style.display = ""; // Show the button if it matches the filter
      } else {
        button.style.display = "none"; // Hide the button if it doesn't match the filter
      }
    }
  }
</script>
<script>
  
 // Add an event listener when the button with id "add_button" is clicked
 document.getElementById("add_button").addEventListener("click", function () {
  if (!selectedEvent) {
    // To display the error icon and hide the success icon
    document.getElementById("errorIcon").style.display = "inline";
    document.getElementById("successIcon").style.display = "none";
    document.getElementById("questionIcon").style.display = "none";
    document.getElementById("cancelButton").style.display = "none";


    // Display an error message if no event is selected with the correct error icon
    openCustomPopup("Error", "Please select an event first.", "bx bxs-error-circle");

    return;
  }

  document.getElementById("errorIcon").style.display = "none";
    document.getElementById("successIcon").style.display = "none";
    document.getElementById("questionIcon").style.display = "inline";
    document.getElementById("closeButton").style.display = "none";
    document.getElementById("cancelButton").style.display = "inline";



  openCustomPopup(
    "Are you sure?",
    "Suggest activity/ies?",
    "question",
    
    true,
    function () {
      // Handle confirmation action here
      // Check for changes in the checkboxes
      const checkboxes = document.querySelectorAll('.activity_container input[type="checkbox"]');
      const hasChanges = Array.from(checkboxes).some(function (checkbox) {
        return checkbox.checked !== checkbox.defaultChecked;
      });

      if (hasChanges) {
        // Get the selected activities
        const selectedActivities = Array.from(document.querySelectorAll('input[name^="activity_"]:checked'))
          .map(input => input.value);

        // Make an AJAX request to update the suggested_status in the database
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "./php/HIS-update_suggested_status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4) {
            if (xhr.status === 200) {
              document.getElementById("errorIcon").style.display = "none";
              document.getElementById("successIcon").style.display = "inline";
              document.getElementById("questionIcon").style.display = "none";   
              document.getElementById("cancelButton").style.display = "none";
              document.getElementById("closeButton").style.display = "inline";

              openCustomPopup(
  "Suggest Success",
  "Activities suggested successfully!",
  "bx bxs-check-circle success-color",
  
  false, // Do not show the "Confirm" button
  function () {
    // This function will be executed when the popup is displayed,
    // but no "Confirm" button will be shown.
    setTimeout(function () {
      closeCustomPopup();
      location.reload(); // Reload the page after 2 seconds
    }, 2000); // Delay in milliseconds (2 seconds)
  }
);
setTimeout(function () {
          closeCustomPopup();
          location.reload(1000);
        }, 2000);

            } else {
              document.getElementById("errorIcon").style.display = "inline";
              document.getElementById("successIcon").style.display = "none";
              document.getElementById("questionIcon").style.display = "none";
              document.getElementById("cancelButton").style.display = "none";
              document.getElementById("closeButton").style.display = "inline";


                openCustomPopup(
              "Error",
              "Failed to suggest activities. Please try again later.",
              "bx bx-x error-color",
              false,
             
            );
            }
          }
        };
        xhr.send("activities=" + encodeURIComponent(JSON.stringify(selectedActivities)));
      } else {
        document.getElementById("errorIcon").style.display = "inline";
              document.getElementById("successIcon").style.display = "none";
              document.getElementById("questionIcon").style.display = "none";  
              document.getElementById("cancelButton").style.display = "none";
              document.getElementById("closeButton").style.display = "inline";


                    openCustomPopup("Error", "No changes applied.", "error", false);

      }
    }
  );
});

// Function to open the custom popup
function openCustomPopup(title, message, icon, showConfirmButton, callback) {
  const popup = document.querySelector(".popUpDisableBackground");
  const popupContainer = document.querySelector(".popUpContainer");
  const popupHeader = document.querySelector(".popUpHeader");
  const popupMessage = document.querySelector(".popUpMessage");
  const confirmButton = document.querySelector(".confirmPopUp");

  popupHeader.textContent = title;
  popupMessage.textContent = message;

  if (showConfirmButton) {
    confirmButton.style.display = "block";
  } else {
    confirmButton.style.display = "none";
  }

  // Handle the callback when the Confirm button is clicked
  confirmButton.onclick = function () {
    closeCustomPopup();
    if (callback) {
      callback();
    }
  };

  popup.style.visibility = "visible";
  popupContainer.classList.add("show");
}

// Function to close the custom popup
function closeCustomPopup() {
  const popup = document.querySelector(".popUpDisableBackground");
  const popupContainer = document.querySelector(".popUpContainer");

  popupContainer.classList.remove("show");
    popup.style.visibility = "hidden";
}
document.getElementById("cancelButton").addEventListener("click", function () {
  closeCustomPopup();
  
});
document.getElementById("closeButton").addEventListener("click", function () {
  closeCustomPopup();
  
});

  
</script>



</body>

</html>
