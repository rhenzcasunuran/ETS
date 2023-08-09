<?php
include 'database_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Assuming you have a database connection setup
    // Replace the following with your database connection code

    // Retrieve data from the AJAX request
    $action = $_POST["action"];
    $teamId = $_POST["teamId"];

    // Perform the necessary action based on $action
    if ($action === "forfeit") {
        // TODO: Perform the forfeit action for the team with $teamId
        // Example: Update the database record to mark the team as forfeited
        // Prepare and execute the SQL query
        $stmt = $conn->prepare("UPDATE ongoing_teams SET current_team_status = 'forfeit' WHERE id = ?");
        $stmt->bind_param("i", $teamId); // "i" represents integer type
        $stmt->execute();
        $stmt->close();

        // Get the IDs of teams that are not the same as $teamId
        $otherTeamIds = array();
        $stmt = $conn->prepare("SELECT bt.team_one_id, bt.team_two_id FROM `bracket_teams` bt 
                                INNER JOIN ongoing_teams ot
                                ON bt.team_one_id = ot.id
                                INNER JOIN ongoing_teams ot2
                                ON bt.team_two_id = ot2.id
                                WHERE (ot.id = ? OR ot2.id = ?)");
        $stmt->bind_param("ii", $teamId, $teamId); // "i" represents integer type
        $stmt->execute();

        // Fetch the results and store the IDs of other teams in the $otherTeamIds array
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            foreach ($row as $id) {
                $otherTeamIds[] = $id;
            }
        }

        // Close the statement
        $stmt->close();

        foreach ($otherTeamIds as $otherTeamId) {
            if ($otherTeamId != $teamId) {
                $stmt = $conn->prepare("UPDATE ongoing_teams SET current_team_status = 'won' WHERE id = ?");
                $stmt->bind_param("i", $otherTeamId); // "i" represents integer type
                $stmt->execute();
                $stmt->close();
            }
        }

        // Send a response back to the client
        $response = array("status" => "success", "message" => "Team forfeited successfully");
        echo json_encode($response);
    } else {
        // Send an error response
        $response = array("status" => "error", "message" => "Invalid action");
        echo json_encode($response);
    }
} else {
    // Send an error response for unsupported request method
    $response = array("status" => "error", "message" => "Invalid request method");
    echo json_encode($response);
}
?>