<?php
include 'database_connect.php';
include 'CAL-logger.php';

// Retrieve the event code from the AJAX request
$eventCode = $_POST['event_code'];

// Query to retrieve judges whose event_code matches the entered value
$sql = "SELECT * FROM judges 
        INNER JOIN competition ON judges.competition_id = competition.event_id
        WHERE competition.event_code = '$eventCode'";

$result = mysqli_query($conn, $sql);

if (!$result) {
  die("Query failed: " . mysqli_error($conn));
}

// Initialize a variable to store the HTML representation of the judges' table
$judgesHTML = '';

// Check if there are matching judges
if (mysqli_num_rows($result) > 0) {
  while ($row = $result->fetch_assoc()) {
    $judgeId = $row['judge_id'];
    $judgeName = $row['judge_name'];
    $judgeNick = $row['judge_nickname'];
    $scoringLink = "https://sample.link";

    // Build the HTML representation for each judge row
    $judgesHTML .= "<tr class='editable-row' data-id='$judgeId'>
      <td>
        <input type='checkbox' class='checkbox'>
      </td>
      <td><input type='text' style='border-radius:20px;' class='inputjname editable cformj' value='$judgeName' readonly ondblclick='makeEditable(this)' onkeydown='handleKeyDown(event)'></td>
      <td><input type='text' style='border-radius:20px;' class='inputjnick editable cformj' value='$judgeNick' readonly ondblclick='makeEditable(this)' onkeydown='handleKeyDown(event)'></td>
      <td><a href='P&J-admin-scoretab.php' target='_blank'><button onClick='showl()' class='buttonlink1' type='button' style='border-radius:15px;width: 160px; height: 40px; color: white;background: #73A9CC;'><i class='bx bx-link'></i>Score Tabulation</button></a></td>
    </tr>";
  }
} else {
  // No matching judges found
  $judgesHTML = 'No matching judges found for the entered event code.';
}

// Close the database connection if needed
mysqli_close($conn);

// Return the HTML representation of the judges' table
echo $judgesHTML;
?>