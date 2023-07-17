<?php
    include 'database_connect.php';

    $category = $_POST['category'];
    $event = $_POST['event'];

   // Prepare the SQL statement to fetch the criterion data for the selected category
    $sql = "SELECT criterion_id, category_name_id, criterion_name, criterion_percent FROM `ongoing_criterion` WHERE category_name_id = ? AND event_id = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $category, $event);
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

    $output = '';
    $totalPercent = 0;

    if ($categoryData->num_rows > 0) {
        // Loop through the criteria array and generate the HTML for the input fields
        $output .= '        <div class="upper-layer row">';
        $output .= '            <p class="col-7 text-start disable">Name</p>';
        $output .= '            <p class="col-5 text-center disable">Percent (%)</p>';
        $output .= '        </div>';
        $output .= '        <div class="middle-layer flex-column">';
        foreach ($criteria as $criterion) {
            $output .= '        <div id="criterion-container" class="row">';
            $output .= '            <p class="col-7 disable" id="criterionName">' . $criterion['criterion_name'] . '</p>';
            $output .= '            <p class="col-5 text-center disable">' . $criterion['criterion_percent'] . '%</p>';
            $output .= '        </div>';
            $totalPercent += $criterion['criterion_percent'];
        }
        $output .= '        </div>';
        $output .= '        <div class="lower-layer row">';
        $output .= '            <p class="col-7 text-end disable">Total</p>';
        $output .= '            <p class="col-5 text-center disable" id="criterionPercent">'.$totalPercent.'%</p>';
        $output .= '        </div>';
        $output .= '<script>';
        $output .= '    $(document).ready(function() {';
        $output .= '        if (' . $totalPercent . ' !== 100) {';
        $output .= '            $("#criterionPercent").css("color", "red");';
        $output .= '        } else {';
        $output .= '            $("#criterionPercent").css("color", "#999");';
        $output .= '        }';
        $output .= '    });';
        $output .= '</script>';
    }
    // Return the output and totalPercent as JSON
    $response = array(
        'output' => $output,
        'totalPercent' => $totalPercent
    );
    echo json_encode($response);
?>
