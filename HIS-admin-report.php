<?php include './php/database_connect.php'; ?>

<!DOCTYPE html>
<html lang="en">

  <head>
  <?php include '.php/title.php' ?> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="Website Icon" type="png" href="./pictures/logo.png">
    <title>Event History | Reports</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="./css/theme-mode.css">
    <script src="./js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <link rel="stylesheet" href="./css/system-wide.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css" rel="stylesheet">


     <!-- Event History CSS -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

     <link rel="stylesheet" href="./css/HIS-admin-report.css">


<!--
  Event History Configurations
---->
  </head>

  <body>
    <!--Sidebar-->
     <?php
      // Set the active module and sub-active sub-item variables
      $activeModule = 'event-history';
      $activeSubItem = 'report-page';

      // Include the sidebar template
      require './php/admin-sidebar.php';
    ?>
    <!--Page Content-->
    <section class="home-section">
      
    <div class="header">Event Report</div>
  <div class="flex-container">
    <div class="container" id="main-containers">
      <div class="white-space-cover"></div>

    <script>
    // Initialize a variable to store the selected event name
    var selectedEventName = "";

    // JavaScript function to update event list when a new event name is selected
    function updateEventList() {
        var selectedEventNameId = document.getElementById("eventNames").value;
        selectedEventName = document.getElementById("eventNames").options[document.getElementById("eventNames").selectedIndex].text; // Store the selected event name

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("eventList").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "PHP/HIS-get-events.php?eventNameId=" + selectedEventNameId, true);
        xhttp.send();

        // Show/hide the "Generate PDF" button based on the selection
        var generatePDFButton = document.getElementById("generatePDFButton");
        generatePDFButton.style.display = selectedEventNameId ? "block" : "none";
    }

    // JavaScript function to generate and download the PDF
    function generatePDF() {
        // Pass the selected event name when generating the PDF
        window.location.href = "php/generate-pdf.php?eventNameId=" + document.getElementById("eventNames").value + "&eventName=" + encodeURIComponent(selectedEventName);
    }
</script>

</head>
<body>
    
    <!-- Dropdown to select an event name -->
    <label for="eventNames">Select an Event Name:</label>
    <select id="eventNames" onchange="updateEventList()">
        <option value="">Select an Event Name</option>
        <?php
        // Connect to the database (replace with your actual database connection code)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "ets";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL query to retrieve all event names
        $eventNamesQuery = "SELECT * FROM ongoing_event_name";
        $eventNamesResult = $conn->query($eventNamesQuery);

        // Populate the dropdown with event names
        if ($eventNamesResult->num_rows > 0) {
            while ($row = $eventNamesResult->fetch_assoc()) {
                echo "<option value='" . $row["event_name_id"] . "'>" . $row["event_name"] . "</option>";
            }
        }
        ?>
    </select>
    <button id="generatePDFButton" style="display: none;" onclick="generatePDF()">Generate PDF</button>

    <!-- Display the events for the selected event name -->
    <div id="eventList">
        <p>Select an event name from the dropdown to view events.</p>
    </div>

    <!-- Button to generate and download PDF (hidden by default) -->


      </div>
      
   

  
      </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./js/script.js"></script>
    <script src="./js/jquery-3.6.4.js"></script>
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
    <!--
Event History Scripts
-->


<!--
Event History Scripts
-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


  </body>

</html>