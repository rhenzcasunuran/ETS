<?php

// Get the selected event name ID from the GET request
if (isset($_GET["eventNameId"])) {
    $eventNameId = intval($_GET["eventNameId"]);

    // Connect to your database (replace with your actual database connection code)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ets";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to retrieve events for the selected event name
    $sql = "SELECT * FROM ongoing_list_of_event WHERE event_name_id = $eventNameId AND is_archived = 1";
    $result = $conn->query($sql);

    // Start buffering the output
    ob_start();

    // Generate the event list HTML
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='event-details'>";
            echo "<h2>Event Details</h2>";
            echo "<p><strong>Category:</strong> " . $row["category_name"] . "</p>";
            echo "<p><strong>Description:</strong> " . $row["event_description"] . "</p>";
            echo "<p><strong>Date:</strong> " . $row["event_date"] . "</p>";
            echo "<p><strong>Time:</strong> " . $row["event_time"] . "</p>";

            // Query the highlights table to get image filenames
            $eventId = $row["event_id"];
            $highlightsSql = "SELECT filename, image_description FROM highlights WHERE event_id = $eventId";
            $highlightsResult = $conn->query($highlightsSql);

            if ($highlightsResult->num_rows > 0) {
                echo "<div class='event-images'>";
                echo "<h2>Event Images</h2>";

                while ($imageRow = $highlightsResult->fetch_assoc()) {
                    $filenames = explode(',', $imageRow["filename"]); // Split filenames by comma

                    foreach ($filenames as $filename) {
                        $filename = trim($filename);
                        $imageDescription = $imageRow["image_description"];

                        if (!empty($filename)) { // Check if the filename is not empty
                            echo "<div class='event-image'><img src='images/$filename' alt='$imageDescription'></div>";
                        }
                    }
                }

                echo "</div>";
            }

            echo "</div>";
        }
    } else {
        echo "<p>No events found for the selected event name.</p>";
    }

    // Get the buffered content
    $html = ob_get_contents();
    ob_end_clean();

    // Output the HTML content with CSS styling
    echo <<<HTML
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Event Report</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }

            .event-details {
                border: 1px solid #ccc;
                padding: 10px;
                margin-bottom: 20px;
            }

            h2 {
                font-size: 18px;
                margin-top: 0;
            }

            strong {
                font-weight: bold;
            }

            .event-images img {
                max-width: 100%;
                height: auto;
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
        <h1>Event Report</h1>
        $html
    </body>
    </html>
    HTML;

    // Close the database connection
    $conn->close();
} else {
    echo "<p>Event name ID not provided.</p>";
}
?>
