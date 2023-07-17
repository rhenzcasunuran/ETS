<?php include './php/database_connect.php'
 ?>

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
$perPage = 4; // Number of buttons per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number

// Query to fetch events with pagination
$query = "SELECT e.event_name, o.event_id
          FROM ongoing_event_name e
          JOIN ongoing_list_of_event o ON e.event_name_id = o.event_name_id
          WHERE o.is_archived = 1 AND o.is_deleted = 0 AND e.is_done = 1
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
$visiblePages = 3; // Set the number of visible pages

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
  document.getElementById("add_button").addEventListener("click", function() {
    if (!selectedEvent) {
      Swal.fire({
        title: 'Error',
        text: 'Please select an event first.',
        icon: 'error',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
      return;
    }

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



</body>

</html>
