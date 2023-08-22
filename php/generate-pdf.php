<?php
require_once '../tcpdf-main/tcpdf.php';
require_once 'database_connect.php'; // Include your database connection script

// SQL query to retrieve events for a specific event name
$eventNameId = isset($_GET["eventNameId"]) ? intval($_GET["eventNameId"]) : 0;

$sql = "SELECT * FROM ongoing_list_of_event WHERE event_name_id = $eventNameId AND is_archived = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Create a new TCPDF instance
    $eventNameId = isset($_GET["eventNameId"]) ? intval($_GET["eventNameId"]) : 0;
    $eventName = isset($_GET["eventName"]) ? $_GET["eventName"] : "";

    // Create a new TCPDF instance using the CustomPDF class
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Event Report - ' . $eventName);
    $pdf->SetSubject('Event Report');
    $pdf->SetKeywords('Event, Report');

    // Add a page
    $pdf->AddPage();

    // Custom header <HTML></HTML>
    $headerHtml = '
    <html>
    <head>
    <style>
    .header {
        color: black;
        padding: 20px;
        text-align: center;
    }

    .header h1 {
        font-size: 12px;
        margin: 0;
    }

    .header p {
        font-size: 8px;
        margin: 5px 0;
    }

    .date {
        font-size: 8px;
    }
    </style>
    </head>
    <body>
    <div class="header">
        <h1>Event Report - ' . $eventName . '</h1>
        <p class="date">Date: ' . date("Y-m-d") . '</p>
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
        position: absolute;
        bottom: 0;
        right: 0;
        text-align: right;
        padding: 20px;
        color: black;
    }

    .footer h1 {
        font-size: 12px;
        margin: 0;
    }

    .footer p {
        font-size: 8px;
        margin: 5px 0;
    }

    .date {
        font-size: 8px;
    }

    .page-number {
        font-size: 8px;
    }
    </style>
    </head>
    <body>
    <div class="footer">
        <h1>Event Report - ' . $eventName . '</h1>
        <p class="date">Date: ' . date("Y-m-d") . '</p>
        <p class="page-number">Page ' . $pdf->getAliasNumPage() . ' of ' . $pdf->getAliasNbPages() . '</p>
    </div>
    </body>
    </html>
    ';

    // Define the event details CSS
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
        margin-bottom: 10px;
    }

    .participants {
        font-size: 16px;
    }

    /* Add a new class for CSS Grid */
    .image-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        justify-content: flex-start;
    }

    .image-grid .event-image {
        text-align: center;
    }

    .image-grid img {
        max-width: 150px;
        height: auto;
    }

    .event-image img {
        max-width: 100px;
        height: 100px;
    }
    </style>
    ';

    // Define the event details HTML
    $eventDetailsHtml = '';

    // Generate the event list HTML
    while ($row = $result->fetch_assoc()) {
        $eventDetailsHtml .= '<div class="event-details">';
        $eventDetailsHtml .= '<h2>Event Details</h2>';
        $eventDetailsHtml .= '<p><strong>Category:</strong> ' . $row["category_name"] . '</p>';
        $eventDetailsHtml .= '<p><strong>Description:</strong> ' . $row["event_description"] . '</p>';
        $eventDetailsHtml .= '<p><strong>Date:</strong> ' . $row["event_date"] . '</p>';
        $eventDetailsHtml .= '<p><strong>Time:</strong> ' . $row["event_time"] . '</p>';

        $eventId = $row["event_id"];

        // Fetch participants for the event
    
    // Fetch participants for the event by joining the competition and participants tables
    $participantsSql = "SELECT participants.participant_name, organization.organization_name, participants.participant_section 
                       FROM participants
                       JOIN competition ON participants.competition_id = competition.competition_id
                       JOIN organization ON participants.organization_id = organization.organization_id
                       WHERE competition.event_id = $eventId";
    $participantsResult = $conn->query($participantsSql);

    if ($participantsResult->num_rows > 0) {
        $eventDetailsHtml .= '<div class="participants">';
        $eventDetailsHtml .= '<h2>Participants</h2>';
        $eventDetailsHtml .= '<table border="1">';
        $eventDetailsHtml .= '<tr><th>Participant Name</th><th>Organization</th><th>Participant Section</th></tr>';
        while ($participantRow = $participantsResult->fetch_assoc()) {
            $participantName = $participantRow["participant_name"];
            $organizationName = $participantRow["organization_name"];
            $participantSection = $participantRow["participant_section"];
            $eventDetailsHtml .= '<tr><td>' . $participantName . '</td><td>' . $organizationName . '</td><td>' . $participantSection . '</td></tr>';
        }
        $eventDetailsHtml .= '</table>';
        $eventDetailsHtml .= '</div>';
    }

        $highlightsSql = "SELECT filename, image_description FROM highlights WHERE event_id = $eventId";
        $highlightsResult = $conn->query($highlightsSql);

        if ($highlightsResult->num_rows > 0) {
            $eventDetailsHtml .= '<div class="event-images">';
            $eventDetailsHtml .= '<h2>Images from this category</h2>';

            $eventDetailsHtml .= '<table>';
            $eventDetailsHtml .= '<tr>';
            $cellCount = 0;

            while ($imageRow = $highlightsResult->fetch_assoc()) {
                $filenames = explode(',', $imageRow["filename"]);

                foreach ($filenames as $filename) {
                    $filename = trim($filename);
                    $imageDescription = $imageRow["image_description"];

                    if (!empty($filename)) {
                        $imagePath = dirname(__FILE__) . '/../images/' . $filename;

                        if ($cellCount % 3 == 0 && $cellCount != 0) {
                            $eventDetailsHtml .= '</tr><tr>';
                        }

                        $eventDetailsHtml .= '<td style="padding: 10px;">';
                        $eventDetailsHtml .= '<img src="' . $imagePath . '" alt="' . $imageDescription . '" style="max-width: 100px; height: 100px;">';
                        $eventDetailsHtml .= '</td>';

                        $cellCount++;
                    }
                }
            }

            $eventDetailsHtml .= '</tr>';
            $eventDetailsHtml .= '</table>';

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

    // Write the HTML content to the PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Set the PDF filename
    $filename = 'event_report.pdf';

    // Output the PDF to the browser with the option to download
    $pdf->Output($filename, 'I');
} else {
    echo "<p>No events found for the selected event name.</p>";
}

// Close the database connection (not needed here as it's included from database_connect.php)
// $conn->close();
?>
