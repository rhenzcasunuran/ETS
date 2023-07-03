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
          <div id="button-container">
            <?php
            $query = "SELECT o.event_id, e.event_name, c.category_name
                      FROM ongoing_list_of_event o
                      JOIN ongoing_event_name e ON o.event_id = e.event_name_id
                      JOIN ongoing_category_name c ON o.category_name_id = c.category_name_id
                      WHERE o.is_archived = 1
                      GROUP BY e.event_name";
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

        $query = "SELECT DISTINCT c.category_name, o.suggested_status, o.is_archived
        FROM ongoing_event_name e
        JOIN ongoing_category_name c ON e.event_name_id = c.event_name_id
        JOIN ongoing_list_of_event o ON o.category_name_id = c.category_name_id
        WHERE e.event_name = '" . $eventName . "' AND o.is_archived = 1";
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

  <!--SweetAlert-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    document.getElementById("add_button").addEventListener("click", function() {
      if (selectedEvent) {
        // Rest of the code for updating activities
        // ...

        // For testing purpose, display a success message
        Swal.fire({
          title: 'Success',
          text: 'Activities updated successfully.',
          icon: 'success',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
        });
      } else {
        Swal.fire({
          title: 'Error',
          text: 'Please select an event first.',
          icon: 'error',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
        });
      }
    });

    function filterButtons() {
      var input, filter, buttons, button, i, txtValue;
      input = document.getElementById("search");
      filter = input.value.toUpperCase();
      buttons = document.getElementById("button-container").getElementsByTagName("button");

      for (i = 0; i < buttons.length; i++) {
        button = buttons[i];
        txtValue = button.textContent || button.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          button.style.display = "";
        } else {
          button.style.display = "none";
        }
      }
    }
  </script>
</body>

</html>
