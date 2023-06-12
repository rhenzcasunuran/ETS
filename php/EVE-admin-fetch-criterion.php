<?php
// Include the database connection file
require 'database_connect.php';

// Get the selected category from the AJAX request
$category = $_POST['category'];

// Prepare the SQL statement to fetch the criterion data for the selected category
$sql = "SELECT * FROM `criterion` WHERE category_name_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $category);
$stmt->execute();
$categoryData = $stmt->get_result();

// Create an empty array to store the fetched criterion data
$criteria = array();

// Loop through the fetched data and add criterion names and percentages to the array
while ($row = mysqli_fetch_array($categoryData)) {
    $criteria[] = array(
        'criterion_id' => $row['criterion_id'],
        'criterion_name' => $row['criterion_name'],
        'criterion_percent' => $row['criterion_percent']
    );
}

// Create an empty variable to store the HTML output
$output = '';

// Prepare the SQL statement to fetch the criterion data for the selected category
$sql = "SELECT * FROM criterion WHERE category_name_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $category);
$stmt->execute();
$categoryData = $stmt->get_result();

if ($categoryData->num_rows > 0) {
    // Loop through the criteria array and generate the HTML for the input fields
    foreach ($criteria as $criterion) {
        $output .= '        <div id="criterionField" class="row form-fields">';
        $output .= '        <input type="hidden" name="criterion_id[]" value="' . $criterion['criterion_id'] . '">';
        $output .= '            <div class="criterion col-9">';
        $output .= '                <input type="text" class="form-control" id="criterion" name="criterion[]" placeholder="Enter Criterion" maxlength="60" required value="' . $criterion['criterion_name'] . '">';
        $output .= '            </div>';
        $output .= '            <div class="percent col-2">';
        $output .= '                <input type="text" class="form-control text-center" id="criterionPercent" name="percentage[]" placeholder="Percentage" maxlength="3" required value="' . $criterion['criterion_percent'] . '">';
        $output .= '            </div>';
        $output .= '            <div class="col-1 d-flex align-items-center justify-content-center">';
        $output .= '                <a href="javascript:void(0);" onclick="deleteCriterion(' . $criterion['criterion_id'] . ');">';
        $output .= '                    <div class="x-icon"><i class="bx bx-x"></i></div>';
        $output .= '                </a>';
        $output .= '            </div>';
        $output .= '        </div>';
    }
}
else {
    $output .= '<div id="criterionField" class="row form-fields appended">';
    $output .= '<div class="criterion col-9">';
    $output .= '<input type="text" class="form-control" id="criterionInput" name="criterion[]" placeholder="Enter Criterion" required>';
    $output .= '</div>';
    $output .= '<div class="percent col-2">';
    $output .= '<input type="text" class="form-control" id="criterionPercentInput" name="percentage[]" placeholder="Percentage" maxlength="3" required >';
    $output .= '</div>';
    $output .= '<div class="col-1 d-flex align-items-center justify-content-center">';
    $output .= '<div class="x-icon" id="removeBtn"><i class="bx bx-x"></i></div>';
    $output .= '</div>';
    $output .= '</div>';
}

// Return the generated HTML output
echo $output;
?>
