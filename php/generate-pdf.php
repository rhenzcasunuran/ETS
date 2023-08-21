<?php
use Dompdf\Dompdf;
use Dompdf\Options;

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

// SQL query to retrieve events for a specific event name
$eventNameId = isset($_GET["eventNameId"]) ? intval($_GET["eventNameId"]) : 0;

$sql = "SELECT * FROM ongoing_list_of_event WHERE event_name_id = $eventNameId AND is_archived = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Initialize Dompdf
    require_once '../vendor/autoload.php';

    $options = new Options();
    $options->setChroot(__DIR__); 
    
    $dompdf = new Dompdf($options);
    // Custom header HTML
    $headerHtml = '
    <html>
    <head>
        <style>
            .header {
                text-align: center;
                padding: 10px;
                background-color: #f2f2f2;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>Event Report</h1>
        </div>
    </body>
    </html>
    ';

    // Custom footer HTML
    $footerHtml = '
    <html>
    <head>
        <style>
            .footer {
                text-align: center;
                padding: 10px;
                background-color: #f2f2f2;
            }
        </style>
    </head>
    <body>
        <div class="footer">
            <p>Page {PAGE_NUM} of {PAGE_COUNT}</p>
        </div>
    </body>
    </html>
    ';

    // Define the event details HTML and CSS
    $eventDetailsHtml = '';
    $eventDetailsCss = '
    <style>
        .event-details {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 24px;
            color: #333;
            margin-top: 0;
        }

        p {
            font-size: 16px;
            margin: 10px 0;
        }

        .event-images img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }
    </style>
    ';

    // Generate the event list HTML
    while ($row = $result->fetch_assoc()) {
        $eventDetailsHtml .= '<div class="event-details">';
        $eventDetailsHtml .= '<h2>Event Details</h2>';
        $eventDetailsHtml .= '<p><strong>Category:</strong> ' . $row["category_name"] . '</p>';
        $eventDetailsHtml .= '<p><strong>Description:</strong> ' . $row["event_description"] . '</p>';
        $eventDetailsHtml .= '<p><strong>Date:</strong> ' . $row["event_date"] . '</p>';
        $eventDetailsHtml .= '<p><strong>Time:</strong> ' . $row["event_time"] . '</p>';

        // Query the highlights table to get image filenames
        $eventId = $row["event_id"];
        $highlightsSql = "SELECT filename, image_description FROM highlights WHERE event_id = $eventId";
        $highlightsResult = $conn->query($highlightsSql);

        if ($highlightsResult->num_rows > 0) {
            $eventDetailsHtml .= '<div class="event-images">';
            $eventDetailsHtml .= '<h2>Event Images</h2>';

            while ($imageRow = $highlightsResult->fetch_assoc()) {
                $filenames = explode(',', $imageRow["filename"]); // Split filenames by comma

                foreach ($filenames as $filename) {
                    $filename = trim($filename);
                    $imageDescription = $imageRow["image_description"];

                    if (!empty($filename)) { // Check if the filename is not empty
                        $imagePath = '../images/' . $filename;
                        $eventDetailsHtml .= '<div class="event-image"><img src="' . $imagePath . '" alt="' . $imageDescription . '"></div>';
                    }
                }
            }
            $eventDetailsHtml .= '</div>';
        }

        $eventDetailsHtml .= '</div>';
    }

    // Complete HTML document
    $html = '<html>';
    $html .= '<head>';
    $html .= $eventDetailsCss;
    $html .= '</head>';
    $html .= '<body>';
    $html .= $headerHtml . $eventDetailsHtml . $footerHtml;
    $html .= '</body>';
    $html .= '</html>';

    // Load HTML content into Dompdf
    $dompdf->loadHtml($html);

    // Set paper size and orientation (A4 portrait)
    $dompdf->setPaper('A4', 'portrait');

    // Render the PDF (output buffering)
    $dompdf->render();

    // Set the PDF filename
    $filename = 'event_report.pdf';

    // Output the PDF to the browser with the option to download
    $dompdf->stream($filename, array("Attachment" => false));
} else {
    echo "<p>No events found for the selected event name.</p>";
}

// Close the database connection
$conn->close();
?>
