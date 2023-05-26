<?php

$server= "localhost";
$username = "root";
$password = "";
$dbname = "pupets";

$conn = mysqli_connect($server, $username, $password, $dbname);

if(!$conn) {
    die("Connection Failed:".mysqli_connect_error());
}


// Fetch data from the "users" table
$sql = "SELECT * FROM pjscorestemp";
$result = $conn->query($sql);

// Display data in HTML table
echo "<table class='table'>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td style='color: rgb(255,255,255);'>" . $row['group_name_temp'] . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>";
    echo "<td style='color: rgb(255,255,255);'>" . $row['total_score_temp'] . "%</td>";
    // Add more columns as needed
    echo '<td><button onClick="window.location.href=\'.../../P&J-admin-scoretabedit.php\'" class="buttonsave" style="background: rgb(255,181,70);">Edit</button></td>';
    echo "</tr>";
}
echo "</table>";

$conn->close();

?>