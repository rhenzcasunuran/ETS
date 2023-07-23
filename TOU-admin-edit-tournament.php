<?php
    include './php/database_connect.php';
    include './php/sign-in.php';

    // Retrieve the id from the query string
    $id = $_GET['id'];

    // Check if the id is valid
    if ($id !== null && $id !== "") {
      // The id is valid, perform actions based on it
      
      // Prepare the SQL statement with a parameter placeholder
      $query = "SELECT bf.id, oen.event_name, olfe.category_name, bf.current_column FROM `tournament` AS tou 
      INNER JOIN bracket_forms AS bf
      ON tou.tournament_id = bf.id
      INNER JOIN ongoing_list_of_event AS olfe
      ON olfe.event_id = tou.event_id
      INNER JOIN ongoing_event_name AS oen
      ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
      WHERE bf.is_active = 1
      AND tou.has_set_tournament = 1
      AND tou.bracket_form_id IS NOT NULL
      AND olfe.is_archived = 0
      AND oen.is_done = 0
      AND olfe.is_deleted = 0
      AND bf.id = ?;";
      $stmt = mysqli_prepare($conn, $query);
      // Bind the id parameter to the prepared statement
      mysqli_stmt_bind_param($stmt, "i", $id);
      // Execute the prepared statement
      mysqli_stmt_execute($stmt);
      // Get the result of the query
      $result = mysqli_stmt_get_result($stmt);

      // Fetch the rows from the result set
      if (mysqli_num_rows($result) > 0) {
        // Fetch the data from the result
        $row = mysqli_fetch_assoc($result);

        $id = $row['id'];      
        $event_name = $row['event_name'];
        $category_name = $row['category_name'];
        $current_column = $row['current_column'];         
      } else {
        header("Location: TOU-admin-manage-tournament.php");
      }
    }

    // Prepare the SQL query with a placeholder for the parameter
    $query = "SELECT COUNT(*) AS active_teams_count FROM ongoing_teams WHERE bracket_form_id = ? AND current_team_status = 'active'";

    // Create a prepared statement
    $stmt = $conn->prepare($query);

    // Bind the parameter to the prepared statement
    $stmt->bind_param("i", $id);

    // Execute the query
    $stmt->execute();

    // Bind the result to a variable
    $stmt->bind_result($activeTeamsCount);

    // Fetch the result
    $stmt->fetch();

    // Close the statement
    $stmt->close();

    // Check if there is only one active team left and declare the champion if needed
    if ($activeTeamsCount === 1) {
        // Prepare the SQL query to update the current champion team's status
        $updateQuery = "UPDATE ongoing_teams SET current_team_status = 'champion' WHERE bracket_form_id = ? AND current_team_status = 'active'";
        
        // Create a prepared statement for the update
        $stmtUpdate = $conn->prepare($updateQuery);
        
        // Bind the parameter to the prepared statement
        $stmtUpdate->bind_param("i", $id);
        
        // Execute the update query
        $stmtUpdate->execute();
        
        // Close the update statement
        $stmtUpdate->close();

        // UPDATE query
        $updateQuery = "UPDATE bracket_forms SET is_active = 0 WHERE id = ? AND is_active = 1";

        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Close the UPDATE statement
        $stmt->close();

        // Close the database connection
        $conn->close();
        
        // Reload the current page using JavaScript
        // Redirect to the desired page using JavaScript after a short delay (replace "TOU-admin-manage-tournament.php" with the actual URL)
        echo '<script>window.location.href = "TOU-admin-manage-tournament.php";</script>';
        exit(); // Make sure to exit the script after reloading the page
    }
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Tournament</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="./css/theme-mode.css">
    <script src="./js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <link rel="stylesheet" href="./css/system-wide.css">
    <link rel="stylesheet" href="./css/TOU-colors.css">
    <script src="./js/jquery-3.6.4.js"></script>
  </head>

  <body>
    <!--Sidebar-->
    <?php
      // Set the active module and sub-active sub-item variables
      $activeModule = 'tournament';
      $activeSubItem = 'manage-tournament';

      // Include the sidebar template
      require './php/admin-sidebar.php';
    ?>
    <!--Popup Cancel / Warning-->
    <div class="popup-background" id="cancelWrapper">
      <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-error prompt-icon warning-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Discard Changes?</h3>   <!--header-->
                <p>Any unsaved progress will be lost.</p> <!--text-->
            </div>
            <div class="div">
                <button class="outline-button" onclick="hideCancel()"><i class='bx bx-chevron-left'></i>Return</button>
                <button class="primary-button" id="cancel-btn"><i class='bx bx-x'></i>Discard</button>
            </div>
        </div>
    </div>
    <section class="home-section flex-row">
      <div class="header">Schedule Tournament</div>
        <div class="container-fluid d-flex row justify-content-center align-items-center flex wrap m-0">
            <div class="div">
                <div class="element">
                    <div class="row">
                        <div class="element-group">
                            <div class="element-label">Tournament ID #<?php echo $id; ?><br> Event: <?php echo $event_name;?><br> Category: <?php echo $category_name;?></div>
                            <br>
                            <div class="element-content">
                              <form method="POST" action="./php/TOU-process-scheduling.php" id="myForm">
                                <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
                                <input type="hidden" id="event_name" name="event_name" value="<?php echo $event_name;?>">
                                <input type="hidden" id="category_name" name="category_name" value="<?php echo $category_name;?>">
                                <div class="container text-center p-2 fs-4">
                                  <div class="row align-items-center">
                                      <div class="col">
                                      <?php 
                                          $query2 = "SELECT ot.id AS team_one_id,
                                          ot2.id AS team_two_id,
                                          org.organization_name AS team_one_name,
                                          org2.organization_name AS team_two_name,
                                          ot.current_team_status AS team_one_status, 
                                          ot2.current_team_status AS team_two_status,
                                          bf.current_column FROM bracket_teams AS bt 
                                          INNER JOIN ongoing_teams AS ot
                                          ON ot.id = bt.team_one_id
                                          INNER JOIN ongoing_teams AS ot2
                                          ON ot2.id = bt.team_two_id
                                          INNER JOIN organization AS org
                                          ON ot.team_id = org.organization_id
                                          INNER JOIN organization AS org2
                                          ON ot2.team_id = org2.organization_id
                                          INNER JOIN bracket_forms AS bf
                                          ON bf.id = bt.bracket_form_id
                                          INNER JOIN tournament AS tou 
                                          ON tou.bracket_form_id = bf.id
                                          INNER JOIN ongoing_list_of_event AS olfe
                                          ON olfe.event_id = tou.event_id
                                          INNER JOIN ongoing_event_name AS oen
                                          ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
                                          AND bf.is_active = 1
                                          AND (ot.current_team_status = 'active' OR ot2.current_team_status = 'active') 
                                          AND bf.current_column = bf.current_column                                            											 AND olfe.event_type_id = 1 
                                          AND oen.is_done = 0 
                                          AND olfe.is_archived = 0 
                                          AND olfe.is_deleted = 0
                                          AND tou.has_set_tournament = 1
                                          AND bf.id = ?;";

                                          $stmt2 = mysqli_prepare($conn, $query2);
                                          // Bind the id parameter to the prepared statement
                                          mysqli_stmt_bind_param($stmt2, "i", $id);
                                          // Execute the prepared statement
                                          mysqli_stmt_execute($stmt2);
                                          // Get the result of the query
                                          $result2 = mysqli_stmt_get_result($stmt2);

                                          if (mysqli_num_rows($result2) === 0) {
                                            // Prepare the SQL query with placeholders for parameters
                                            $query = "SELECT ot.id AS team_one_id,
                                            ot2.id AS team_two_id,
                                            org.organization_name AS team_one_name,
                                            org2.organization_name AS team_two_name,
                                            ot.current_team_status AS team_one_status, 
                                            ot2.current_team_status AS team_two_status,
                                            bt.bracket_position FROM bracket_teams AS bt 
                                            INNER JOIN ongoing_teams AS ot
                                            ON ot.id = bt.team_one_id
                                            INNER JOIN ongoing_teams AS ot2
                                            ON ot2.id = bt.team_two_id
                                            INNER JOIN organization AS org
                                            ON ot.team_id = org.organization_id
                                            INNER JOIN organization AS org2
                                            ON ot2.team_id = org2.organization_id
                                            INNER JOIN bracket_forms AS bf
                                            ON bf.id = bt.bracket_form_id
                                            INNER JOIN tournament AS tou 
                                            ON tou.bracket_form_id = bf.id
                                            INNER JOIN ongoing_list_of_event AS olfe
                                            ON olfe.event_id = tou.event_id
                                            INNER JOIN ongoing_event_name AS oen
                                            ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
                                            AND bf.is_active = 1
                                            AND (ot.current_team_status = 'won' OR ot2.current_team_status = 'won')
                                            AND olfe.event_type_id = 1 
                                            AND oen.is_done = 0 
                                            AND olfe.is_archived = 0 
                                            AND olfe.is_deleted = 0
                                            AND tou.has_set_tournament = 1
                                            AND bf.id = ?";

                                            // Create a prepared statement
                                            $stmt = $conn->prepare($query);

                                            // Bind the parameter to the prepared statement
                                            $stmt->bind_param("i", $id);

                                            // Execute the query
                                            $stmt->execute();

                                            // Get the result set
                                            $result = $stmt->get_result();

                                            // Create an array to store the team names
                                            $wonTeamsArray = array();

                                            // Fetch the team names that have 'won' and store them in the array
                                            while ($row = $result->fetch_assoc()) {
                                              if ($row['team_one_status'] === 'won') {
                                                $wonTeamsArray[] = $row['team_one_name'];
                                              }
                                              if ($row['team_two_status'] === 'won') {
                                                $wonTeamsArray[] = $row['team_two_name'];
                                              }
                                            }

                                            // Close the statement
                                            $stmt->close();

                                            // Iterate through the wonTeamsArray and fetch the IDs for each team
                                            foreach ($wonTeamsArray as $teamName) {
                                                // Prepare the SQL query with placeholders for parameters
                                                $query = "SELECT ot.id FROM bracket_teams AS bt 
                                                            INNER JOIN ongoing_teams AS ot
                                                            ON ot.id = bt.team_one_id
                                                            INNER JOIN organization AS org
                                                            ON ot.team_id = org.organization_id
                                                            INNER JOIN bracket_forms AS bf
                                                            ON bf.id = bt.bracket_form_id
                                                            INNER JOIN tournament AS tou 
                                                            ON tou.bracket_form_id = bf.id
                                                            INNER JOIN ongoing_list_of_event AS olfe
                                                            ON olfe.event_id = tou.event_id
                                                            INNER JOIN ongoing_event_name AS oen
                                                            ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
                                                            AND bf.is_active = 1
                                                            AND ot.current_team_status = 'active'
                                                            AND olfe.event_type_id = 1 
                                                            AND oen.is_done = 0 
                                                            AND olfe.is_archived = 0 
                                                            AND olfe.is_deleted = 0
                                                            AND tou.has_set_tournament = 1
                                                            AND bf.id = ?
                                                            AND org.organization_name = ?";

                                                // Create a prepared statement
                                                $stmt = $conn->prepare($query);

                                                // Bind the parameters to the prepared statement
                                                $stmt->bind_param("is", $id, $teamName);

                                                // Execute the query
                                                $stmt->execute();

                                                // Get the result set
                                                $result = $stmt->get_result();

                                                // Fetch the ID and store it in the array
                                                while ($row = $result->fetch_assoc()) {
                                                    $wonTeamsIdsArray[] = $row['id'];
                                                }

                                                // Close the statement
                                                $stmt->close();
                                            }                            

                                            // Prepare the SQL query with placeholders for parameters
                                            $query = "SELECT DISTINCT bt.current_column FROM bracket_teams AS bt 
                                            INNER JOIN ongoing_teams AS ot
                                            ON ot.id = bt.team_one_id
                                            INNER JOIN ongoing_teams AS ot2
                                            ON ot2.id = bt.team_two_id
                                            INNER JOIN organization AS org
                                            ON ot.team_id = org.organization_id
                                            INNER JOIN organization AS org2
                                            ON ot2.team_id = org2.organization_id
                                            INNER JOIN bracket_forms AS bf
                                            ON bf.id = bt.bracket_form_id
                                            INNER JOIN tournament AS tou 
                                            ON tou.bracket_form_id = bf.id
                                            INNER JOIN ongoing_list_of_event AS olfe
                                            ON olfe.event_id = tou.event_id
                                            INNER JOIN ongoing_event_name AS oen
                                            ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
                                            AND bf.is_active = 1
                                            AND (ot.current_team_status = 'won' OR ot2.current_team_status = 'won')
                                            AND olfe.event_type_id = 1 
                                            AND oen.is_done = 0 
                                            AND olfe.is_archived = 0 
                                            AND olfe.is_deleted = 0
                                            AND tou.has_set_tournament = 1
                                            AND bf.id = ?;";

                                            // Create a prepared statement
                                            $stmt = $conn->prepare($query);

                                            // Bind the parameter to the prepared statement
                                            $stmt->bind_param("i", $id);

                                            // Execute the query
                                            $stmt->execute();

                                            // Bind the result to a variable
                                            $stmt->bind_result($currentColumn);

                                            // Fetch the distinct value
                                            $stmt->fetch();

                                            // Close the statement
                                            $stmt->close();

                                            // Increment the current column
                                            $currentColumn++;

                                            // Prepare the SQL query with a parameter placeholder
                                            $sql = "SELECT COUNT(*) AS no_of_teams
                                                    FROM ongoing_teams
                                                    WHERE bracket_form_id = ?";

                                            // Prepare the statement
                                            $stmt1 = $conn->prepare($sql);

                                            // Bind the parameter value to the placeholder
                                            $stmt1->bind_param('i', $id); // 'i' for integer, use 's' for string, 'd' for double, etc.

                                            // Execute the query
                                            $stmt1->execute();

                                            // Bind the result to a variable
                                            $stmt1->bind_result($count);

                                            // Fetch the result
                                            $stmt1->fetch();

                                            // Close the statement
                                            $stmt1->close();

                                            // Prepare the SQL query with a parameter placeholder
                                            $sqlCount = "SELECT node_id_start FROM `bracket_forms` WHERE id = ?;";

                                            // Prepare the statement
                                            $stmt2 = $conn->prepare($sqlCount);

                                            // Bind the parameter value to the placeholder
                                            $stmt2->bind_param('i', $id); // 'i' for integer, use 's' for string, 'd' for double, etc.

                                            // Execute the query
                                            $stmt2->execute();

                                            // Bind the result to a variable
                                            $stmt2->bind_result($countNode);

                                            // Fetch the result
                                            $stmt2->fetch();

                                            // Close the statement
                                            $stmt2->close();

                                            if (($countNode - 2) <= $count) {
                                              // Prepare the SQL query for inserting into the new bracket form
                                              $insertQuery = "INSERT INTO bracket_teams (bracket_form_id, bracket_position, team_one_id, team_two_id, current_column) 
                                              VALUES (?, ?, ?, ?, ?)";
                                              $stmt = $conn->prepare($insertQuery);

                                              // Counter variable for bracket position
                                              $bracketPosition = 1;
                                              $teamOneID = $wonTeamsIdsArray[0];
                                              $teamTwoID = $wonTeamsIdsArray[1];

                                              // Bind the parameters to the prepared statement for insertion
                                              $stmt->bind_param("iiiii", $id, $bracketPosition, $teamTwoID, $teamOneID, $currentColumn);

                                              // Execute the prepared statement
                                              $stmt->execute();
                                            } else {
                                              // Prepare the SQL query for inserting into the new bracket form
                                              $insertQuery = "INSERT INTO bracket_teams (bracket_form_id, bracket_position, team_one_id, team_two_id, current_column) 
                                              VALUES (?, ?, ?, ?, ?)";
                                              $stmt = $conn->prepare($insertQuery);

                                              // Counter variable for bracket position
                                              $bracketPosition = 1;

                                              // Loop through the won teams array
                                              for ($i = 0; $i < count($wonTeamsIdsArray); $i += 2) {
                                                // Bind the parameters to the prepared statement for insertion
                                                $teamOneID = $wonTeamsIdsArray[$i];
                                                $teamTwoID = $wonTeamsIdsArray[$i + 1];

                                                // Bind the parameters to the prepared statement
                                                $stmt->bind_param("iiiii", $id, $bracketPosition, $teamTwoID, $teamOneID, $currentColumn);

                                                // Execute the prepared statement
                                                $stmt->execute();

                                                // Increment bracket position for the next row
                                                $bracketPosition++;
                                              }
                                            }
                                            
                                            // Close the statement
                                            $stmt->close();

                                            // Prepare the SQL query with a placeholder for the parameter
                                            $query = "UPDATE `bracket_forms` 
                                            SET current_column = current_column + 1 
                                            WHERE id = ?";

                                            $stmt = mysqli_prepare($conn, $query);
                                            // Bind the id parameter to the prepared statement
                                            mysqli_stmt_bind_param($stmt, "i", $id);
                                            // Execute the prepared statement
                                            mysqli_stmt_execute($stmt);
                                            mysqli_stmt_close($stmt);

                                            // Function to check if there is only one active team left
                                            function isOneTeamLeft($conn, $id) {
                                              $query = "SELECT COUNT(*) AS active_teams_count FROM ongoing_teams WHERE current_team_status = 'active' AND bracket_form_id = ?";
                                              $stmt = $conn->prepare($query);
                                              $stmt->bind_param("i", $id);
                                              $stmt->execute();
                                              $result = $stmt->get_result();
                                              $row = $result->fetch_assoc();
                                              $activeTeamsCount = $row['active_teams_count'];
                                              $stmt->close();
                                              return $activeTeamsCount === 1;
                                            }

                                            // Function to declare the champion team
                                            function declareChampion($conn, $id) {
                                              $query = "UPDATE ongoing_teams SET current_team_status = 'champion', current_overall_score = current_overall_score + 1 WHERE current_team_status = 'active' AND bracket_form_id = ?";
                                              $stmt = $conn->prepare($query);
                                              $stmt->bind_param("i", $id);
                                              $stmt->execute();
                                              $stmt->close();
                                              $query = "UPDATE bracket_forms SET is_active = 0 WHERE id = ?";
                                              $stmt = $conn->prepare($query);
                                              $stmt->bind_param("i", $id);
                                              $stmt->execute();
                                              $stmt->close();
                                            }

                                            // Check if there is only one active team left and declare the champion if needed
                                            if (isOneTeamLeft($conn, $id)) {
                                              declareChampion($conn, $id);
                                            }

                                            // Get the bracket teams based on the bracket_form_id
                                            $query = "SELECT ot.id AS team_one_id,
                                            ot2.id AS team_two_id,
                                            org.organization_name AS team_one_name,
                                            org2.organization_name AS team_two_name,
                                            ot.current_team_status AS team_one_status, 
                                            ot2.current_team_status AS team_two_status,
                                            bf.current_column FROM bracket_teams AS bt 
                                            INNER JOIN ongoing_teams AS ot
                                            ON ot.id = bt.team_one_id
                                            INNER JOIN ongoing_teams AS ot2
                                            ON ot2.id = bt.team_two_id
                                            INNER JOIN organization AS org
                                            ON ot.team_id = org.organization_id
                                            INNER JOIN organization AS org2
                                            ON ot2.team_id = org2.organization_id
                                            INNER JOIN bracket_forms AS bf
                                            ON bf.id = bt.bracket_form_id
                                            INNER JOIN tournament AS tou 
                                            ON tou.bracket_form_id = bf.id
                                            INNER JOIN ongoing_list_of_event AS olfe
                                            ON olfe.event_id = tou.event_id
                                            INNER JOIN ongoing_event_name AS oen
                                            ON olfe.ongoing_event_name_id = oen.ongoing_event_name_id
                                            AND bf.is_active = 1
                                            AND (ot.current_team_status = 'active' OR ot2.current_team_status = 'active') 
                                            AND bf.current_column = bf.current_column                                            											 AND olfe.event_type_id = 1 
                                            AND oen.is_done = 0 
                                            AND olfe.is_archived = 0 
                                            AND olfe.is_deleted = 0
                                            AND tou.has_set_tournament = 1
                                            AND bf.id = ?";

                                            $stmt = $conn->prepare($query);
                                            $stmt->bind_param("i", $id);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            // Check if there are any active teams left in the bracket
                                            $activeTeamCount = 0;
                                            $championTeamId = null;
                                            while ($row = $result->fetch_assoc()) {
                                              $team_one_status = $row['team_one_status'];
                                              $team_two_status = $row['team_two_status'];
                                              
                                              if ($team_one_status === 'active') {
                                                  $activeTeamCount++;
                                                  $championTeamId = $row['team_one_id'];
                                              }

                                              if ($team_two_status === 'active') {
                                                  $activeTeamCount++;
                                                  $championTeamId = $row['team_two_id'];
                                              }

                                              echo '<input type="hidden" id="team_one_id" name="team_one_id[]" value="'.$row['team_one_id'].'">' .
                                              '<input type="hidden" id="team_two_id" name="team_two_id[]" value="'.$row['team_two_id'].'">
                                                <div class="container mt-5">
                                                  <div class="row">
                                                    <div class="col text-center">
                                                    <h2>'.$row['team_one_name'].' vs '.$row['team_two_name'].'</h2>
                                                    </div>
                                                  </div>
                                                  <div class="row mt-3">
                                                    <div class="col-md-6 offset-md-3 col-sm-12">
                                                      <label for="matchDateTime">Match Date and Time:</label><br>
                                                      <input type="datetime-local" name="event_date_time[]" id="eventDateTimeInput" class="form-control">
                                                    </div>
                                                  </div>
                                                </div>';
                                            }

                                            $stmt->close();

                                            // If there is only one active team left, handle the champion case
                                            if ($activeTeamCount === 1 && $championTeamId) {
                                              declareChampion($conn, $id);
                                            }
                                          } else {
                                            while ($row2 = mysqli_fetch_assoc($result2)) {
                                              $team_one_id = $row2['team_one_id'];
                                              $team_two_id = $row2['team_two_id'];
                                              $team_name_one = $row2['team_one_name'];
                                              $team_name_two = $row2['team_two_name'];

                                              echo '<input type="hidden" id="team_one_id" name="team_one_id[]" value="'.$team_one_id.'">' .
                                              '<input type="hidden" id="team_two_id" name="team_two_id[]" value="'.$team_two_id.'">
                                               <div class="container mt-5">
                                                 <div class="row">
                                                   <div class="col text-center">
                                                     <h2>'.$team_name_one.' vs '.$team_name_two.'</h2>
                                                   </div>
                                                 </div>
                                                 <div class="row mt-3">
                                                   <div class="col-md-6 offset-md-3 col-sm-12">
                                                     <label for="matchDateTime">Match Date and Time:</label><br>
                                                     <input type="datetime-local" name="event_date_time[]" id="eventDateTimeInput" class="form-control">
                                                   </div>
                                                 </div>
                                               </div>';                                                                          
                                            }
                                          }                                      
                                        ?>
                                      </div>
                                  </div>
                                <br>
                                <div id="error-container" style="color: red;"></div>
                                <div class="div d-flex justify-content-end">
                                  <button type="button" class="outline-button" onclick="showCancel()">Cancel</button>
                                  <button id="submit" type="submit" class="primary-button float-end">Submit</button>
                                </div>
                              </form>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- Scripts -->
    <script src="./js/script.js"></script>
    <script src="./js/theme.js"></script>
    <script type="text/javascript">
        // Get the current date and time in the format YYYY-MM-DDTHH:mm (datetime-local format)
  function getCurrentDateTime() {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');

    return `${year}-${month}-${day}T${hours}:${minutes}`;
  }

  // Attach the event listener to the datetime-local input
  const datetimeInput = document.querySelector('input[type="datetime-local"]');
  datetimeInput.setAttribute('min', getCurrentDateTime());

        // Cancel
        popupCancel = document.getElementById('cancelWrapper');
  
        var showCancel = function() {
            popupCancel.style.display ='flex';
        }
        var hideCancel = function() {
            popupCancel.style.display ='none';
        }

        // Attach a click event handler to the button with id "cancel-btn"
  $('#cancel-btn').on('click', function() {
    // Set the URL you want to redirect to
    var redirectUrl = 'TOU-admin-manage-tournament.php'; // Replace this with the desired URL

    // Perform the redirection
    window.location.href = redirectUrl;
  });

    </script>
    <script type="text/javascript">
      $('.menu_btn').click(function (e) {
        e.preventDefault();
        var $this = $(this).parent().find('.sub_list');
        $('.sub_list').not($this).slideUp(function () {
          var $icon = $(this).parent().find('.change-icon');
          $icon.removeClass('bx-chevron-down').addClass('bx-chevron-right');
        });

        $this.slideToggle(function () {
          var $icon = $(this).parent().find('.change-icon');
          $icon.toggleClass('bx-chevron-right bx-chevron-down')
        });
      });

      $(window).bind("resize", function () {
        if ($(this).width() < 500) {
          $('div').removeClass('open');
          closeBtn.classList.replace("bx-arrow-to-left", "bx-menu");
        }
        else if ($(this).width() > 500) {
          $('.sidebar').addClass('open');
          closeBtn.classList.replace("bx-menu", "bx-arrow-to-left");
        }
      }).trigger('resize');
    </script>
    <!--Popper JS-->
    <script src="./js/popper.min.js"></script>
    <!--Bootstrap JS-->
    <script src="./js/bootstrap.min.js"></script>
  </body>
</html>