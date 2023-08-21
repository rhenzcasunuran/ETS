<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Event Report</title>
    <script>
        // JavaScript function to update event list when a new event name is selected
        function updateEventList() {
            var selectedEventNameId = document.getElementById("eventNames").value;
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
            var selectedEventNameId = document.getElementById("eventNames").value;
            window.location.href = "php/generate-pdf.php?eventNameId=" + selectedEventNameId;
        }
    </script>
</head>
<body>
    <h1>Event Report</h1>
    
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
    
    <!-- Display the events for the selected event name -->
    <div id="eventList">
        <p>Select an event name from the dropdown to view events.</p>
    </div>

    <!-- Button to generate and download PDF (hidden by default) -->
    <button id="generatePDFButton" style="display: none;" onclick="generatePDF()">Generate PDF</button>

</body>
</html>
