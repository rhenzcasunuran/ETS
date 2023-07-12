<?php
// Establish a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ets";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Iterate through the dropdowns
    for ($i = 1; $i <= 8; $i += 2) {
        // Retrieve the selected values from the odd and even dropdowns
        $oddValue = $_POST["dropdown" . $i] ?? '';
        $evenValue = $_POST["dropdown" . ($i + 1)] ?? '';

        // Insert the values into the tou_bracket table
        $bracketSql = "INSERT INTO tou_bracket (tournament_id, team1_id, team2_id) VALUES ('8', '$oddValue', '$evenValue')";

        // Execute the bracket SQL query
        if ($conn->query($bracketSql) === TRUE) {
            echo "Dropdowns $i and " . ($i + 1) . " submitted successfully.";

            // Insert the values into the tou_team table (if the bracket_id doesn't already exist)
            $teamSql = "INSERT INTO tou_team (team_id, bracket_id, team_score)
                        SELECT team_id, bracket_id, NULL AS team_score
                        FROM (
                            SELECT team1_id AS team_id, bracket_id
                            FROM tou_bracket
                            INNER JOIN tou_team_stat ON tou_bracket.team1_id = tou_team_stat.team_id

                            UNION

                            SELECT team2_id AS team_id, bracket_id
                            FROM tou_bracket
                            INNER JOIN tou_team_stat ON tou_bracket.team2_id = tou_team_stat.team_id
                        ) AS teams
                        WHERE NOT EXISTS (
                            SELECT 1
                            FROM tou_team
                            WHERE tou_team.bracket_id = teams.bracket_id
                        )";

            // Execute the team SQL query
            if ($conn->query($teamSql) === TRUE) {
                echo " Team values inserted into tou_team table successfully.";
            } else {
                echo "Error inserting team values: " . $teamSql . "<br>" . $conn->error;
            }
        } else {
            echo "Error inserting bracket values: " . $bracketSql . "<br>" . $conn->error;
        }
    }
}


header("Location: ../TOU-bracket-admin.php");
exit;

// Close the database connection
$conn->close();
?>