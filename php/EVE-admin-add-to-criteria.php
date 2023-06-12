<?php
// Include the database connection file
require 'database_connect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected category and criterion data from the form
    $categoryPickerValue = $_POST['categoryPickerValue'];
    $criterionData = $_POST['criterion'];
    $percentageData = $_POST['percentage'];
    $criterionIDs = $_POST['criterion_id'];

    // Loop through the criterion data
    foreach ($criterionData as $key => $criterion) {
        // Get the corresponding percentage value
        $percentage = $percentageData[$key];

        // Trim leading and trailing spaces
        $criterion = trim($criterion);
        // Remove extra white spaces within the criterion value
        $criterion = preg_replace('/\s+/', ' ', $criterion);

        // Check if the criterion ID is provided (for existing criterion)
        if (isset($criterionIDs[$key])) {
            $criterionID = $criterionIDs[$key];
            // Update the existing criterion in the database
            $sql = "UPDATE criterion SET criterion_name = ?, criterion_percent = ? WHERE criterion_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sdi', $criterion, $percentage, $criterionID);
            $stmt->execute();
        } else {
            // Insert the new criterion into the database
            $sql = "INSERT INTO criterion (criterion_name, criterion_percent, category_name_id) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sds', $criterion, $percentage, $categoryPickerValue);
            $stmt->execute();
        }
    }
}
?>
