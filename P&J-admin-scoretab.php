<?php
  include './php/sign-in.php';
  include './php/database_connect.php';
  
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Score Tabulation</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="./css/theme-mode.css">
    <script src="./js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="css/P&J-participantsandjudges.css">
    <link rel="stylesheet" href="css/system-wide.css">
    <link rel="stylesheet" href="css/boxicons.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/sidebar-style.css">
    <link rel="stylesheet" href="css/home-sidebar-style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400&amp;display=swap">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
      .centered-container {
      display: flex;
      justify-content: center;
    }
      .inputscore {
    margin: 0 auto; /* This centers the container horizontally */
    float: none; /* Remove any floating behavior */
  }
     /* CSS to hide the elements */
  .hidden {
    display: none;
  }

  /* CSS to show the elements */
  .visible {
    display: block;
  }

    /* Styles for the modal dialog */
    
    .modal {
      display: none;
      position: fixed;
      left: 0;
      top: 0;
      width: 50%;
      height: 50%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 2;
    }

    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 400px;
    }

    /* Styles for the blurred background when the modal is shown */
    .blurred-background {
      filter: blur(8px);
      pointer-events: none;
    }
  </style>

  </head>

  <body style="background: rgb(25,20,36);">
  <div id="auth-form" class="modal">
    <h2>Authentication</h2>
    <input type="text" id="event_code" name="event_code"placeholder="Event Code">
    <input type="text" id="judge_name" name="judge_name" placeholder="Judge Name">
    <button class="primary-button"id="login-btn" onclick="authenticate();">Authenticate</button>
  </div>
    <div class="popup-background" id="submitWrapper">
    <div class="row popup-container">
        <div class="col-4">
            <i class='bx bxs-check-circle prompt-icon success-color'></i>
        </div>
        <div class="col-8 text-start text-container">
            <h3 class="text-header">Submit All to Database?</h3>
            <p>You cannot undo this action.</p>
        </div>
        <div class="div">
            <button class="outline-button" onclick="hideSubmit()"><i class='bx bx-x'></i>Cancel</button>
            <button class="success-button" id="submitPopup"><i class='bx bx-check'></i>Confirm</button>
        </div>
    </div>
</div>
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
            <button class="primary-button" id="cancelButtonP" onclick="discardChanges()"><i class='bx bx-x'></i>Discard</button>
        </div>
    </div>
</div>
    <nav class="navbar navbar-light navbar-expand-md" style="background: #282135;">
        <div class="container">
                        <h1 class="text-start" style="color: rgb(255,255,255); font-weight: 1000; margin-top: 20px;margin-left:400px;">Score Tabulation</h1>
            </div>
        </div>
    </nav>
    <div id="blurred-background" class="blurred-background">
    <div class="container" style="margin:auto;">
        <div class="row" style="margin-top: 20px; margin-bottom:20px;">
            <div class="col-lg-6 col-xl-6 col-xxl-4 offset-lg-0 offset-xxl-2 inputscore show"><label class="form-label" style="margin-left:20px;color: rgb(255,255,255);">Scoring</label>
                <div class="d-table" style="background: #423c4e;margin-left: 10px;min-height: auto;padding-top: 33px;padding-left: 31px;padding-right: 39px;padding-bottom: 20px;min-width: auto;width: 100%;border-radius: 10px;box-shadow: 7px 5px 13px;">
                    <div class="row">
                        <div class="col" style="text-align: center;" id='placeholder-table'>
                            <div class="row">
                                <div class="col"><label class="col-form-label" style="color: rgb(255,255,255);font-weight:1000;">Criteria</label></div>
                                <div class="col"><label class="col-form-label" style="color: rgb(255,255,255);">Scores</label></div>
                            </div>
                            
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col"><label class="col-form-label" style="color: rgb(255,255,255);">Criteria 1</label></div>
                                        <div class="col"><input type="number" class="cforms" name="criteria_1_temp" id="criteria_1_temp"  style="text-align: center;color: rgb(255,255,255);background: rgba(0,0,0,0.22);" min="1" max="10" placeholder="10" Required></div>
                                    </div>
                                    <div class="row">
                                        <div class="col"><label class="col-form-label" style="color: rgb(255,255,255);">Criteria 2</label></div>
                                        <div class="col"><input type="number" class="cforms" name="criteria_2_temp" id="criteria_2_temp"   style="text-align: center;color: rgb(255,255,255);background: rgba(0,0,0,0.22);" min="1" max="10" placeholder="10" Required></div>
                                    </div>
                                    <div class="row">
                                        <div class="col"><label class="col-form-label" style="color: rgb(255,255,255);">Criteria 3</label></div>
                                        <div class="col"><input type="number" class="cforms" name="criteria_3_temp" id="criteria_3_temp"   style="text-align: center;color: rgb(255,255,255);background: rgba(0,0,0,0.22);" min="1" max="10" placeholder="10" required></div>
                                    </div>
                                    <div class="row">
                                        <div class="col"><label class="col-form-label" style="color: rgb(255,255,255);">Criteria 4</label></div>
                                        <div class="col"><input type="number" class="cforms" name="criteria_4_temp"  id="criteria_4_temp"   style="text-align: center;color: rgb(255,255,255);background: rgba(0,0,0,0.22);" min="1" max="10" placeholder="10" required></div>
                                    </div>
                                    <div class="row">
                                        <div class="col"><label class="col-form-label" style="color: rgb(255,255,255);">Total:</label></div>
                                        <div class="col"><input type="number" name="sum" id="sum" style="text-align: center;color: rgb(255,255,255);background: rgba(0,0,0,0.22);" min="1" max="10" placeholder="100" readonly></div>
                                    </div>
                                    <div class="row text-center" style="text-align: center;">

                    <div class="col offset-xl-1 offset-xxl-1" style="text-align: center;">
                        <div class="btn-toolbar" style="text-align: center;">
                            <div class="btn-group" role="group" style="text-align: center;margin-top: 10px;">
                            <button class="primary-button" type="submit" value="Add" id="add_btnS" >Save</button>
                                
                                
                                <button class="success-button buttonsubmit" type="submit" style="text-align: center;">Submit</button>
                                
                                
                                <button onclick="cancelInput(event)" class="secondary-button delJ" id="can_btnS" type="button"  style="display:inline;" >Cancel</button>
                                </div>
                        </div>
                    </div>
                </div>
                                </div>
                            </div>
                            
                            
                        </div>
                        
                    </div>
                </div>
            </div>
            

            
            
        </div>
    </div>
    </div>
    
    
    <div class="popup hidden" id="editPopup">
    <div class="container" style="margin:auto;">
    <div class="row" style="margin-top: 20px; margin-bottom:20px;">
        <!-- Scoring Container -->
        <div class="col-lg-6 col-xl-6 col-xxl-4 offset-lg-0 offset-xxl-2 inputscore show">
            <label class="form-label" style="margin-left:20px;color: rgb(255,255,255);">Scoring</label>
            <div class="d-table" style="background: #423c4e;margin-left: 10px;min-height: auto;padding-top: 33px;padding-left: 31px;padding-right: 39px;padding-bottom: 20px;min-width: auto;width: 100%;border-radius: 10px;box-shadow: 7px 5px 13px;">
                <div class="row">
                    <form action="php/P&J-admin-action-scores.php" method="POST" id="score_form">
                        <div class='row' style="text-align: center;" id="criteria-table">
                            <!-- Content for the Scoring container goes here -->
                        </div>
                        <div style="text-align: center;">
                        <div class="btn-toolbar" style="text-align: center;">
                            <div class="btn-group" role="group" style="text-align: center;margin-top: 10px; 
                            align-items: center;">
                            <button class="primary-button" type="submit" value="Add" id="save_btnS" name="save_scores">Save</button>
                            <button name="submit_scores" class="success-button buttonsubmit" type="submit" style="text-align: center;"  value="Add" id="submit_btnS">Submit</button> <!-- onclick="showSubmit(event)" for popup, tinanggal ko lang kasi ayaw magsubmit ng maayos -_- -->
                            <button onclick="showCancel(event)" class="secondary-button delJ" id="cancelButton" type="button"  style="display:inline;" disabled>Cancel</button>
                            </div>
                          </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
  
    <div class="container" style="margin-top: 20px;">
  <div class="row">
  <div class="col-lg-6 col-xl-6 col-xxl-4 offset-lg-0 offset-xxl-2 inputscore">
  <label class="form-label" style="margin-left: 20px; color: rgb(255, 255, 255);">Participant Scores</label>
  <div class="d-table" style="background: #423c4e; margin-left: 10px; min-height: auto;min-width: auto; width: 100%; border-radius: 10px; box-shadow: 7px 5px 13px;">
    <!-- PHP code to fetch participant scores -->
    <?php
// Access $eventId and $ongoingCriterionIds from the session
$eventId = $_SESSION['event_id'];
$judgeName = $_SESSION['judge_name'];
$ongoingCriterionIds = $_SESSION['ongoing_criterion_ids'];

// Fetch unique participant_ids and participant_names from criterion_scoring that match the event_code
$fetchParticipantScoresQuery = "SELECT DISTINCT cs.participants_id, p.participant_name
                                FROM criterion_scoring cs
                                INNER JOIN participants p ON cs.participants_id = p.participants_id
                                INNER JOIN competition c ON p.competition_id = c.competition_id
                                WHERE c.event_id = '$eventId'
                                AND cs.criterion_final_score IS NULL"; // Add this condition to exclude participants with criterion_final_score

// Fetch criteria names from the ongoing_criterion table based on the event ID
$fetchCriteriaNamesQuery = "SELECT criterion_name
                            FROM ongoing_criterion oc
                            INNER JOIN competition c ON oc.event_id = c.event_id
                            WHERE c.event_id = '$eventId'";
$criteriaNamesResult = $conn->query($fetchCriteriaNamesQuery);

$participantScoresResult = $conn->query($fetchParticipantScoresQuery);

if ($participantScoresResult->num_rows > 0) {
    echo '<label style="color: rgb(255, 255, 255); margin-left:20px; margin-top:10px;">Scored By: ' . $judgeName . '</label>';
    echo '<table style="text-align:center; margin-left:40px; margin-top:10px; margin-right:40px; color:var(--color-content-text); min-width:90%; margin-bottom:20px;">';
    echo '<thead>';
    echo '<tr>';
    echo '<th class="bordertable" style="color:white;">Participant Name</th>';
    
    // Fetch and store criterion names that match the event
    $matchingCriteriaNames = array();
    if ($criteriaNamesResult->num_rows > 0) {
        while ($criteriaNameRow = $criteriaNamesResult->fetch_assoc()) {
            $matchingCriteriaNames[] = $criteriaNameRow['criterion_name'];
        }
    }

    // Display the criterion names that match the event
    foreach ($matchingCriteriaNames as $criterionName) {
        echo '<th class="bordertable" style="color:white;">' . htmlspecialchars($criterionName) . '</th>';
    }
    
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($participantScoreRow = $participantScoresResult->fetch_assoc()) {
        $participantId = $participantScoreRow['participants_id'];
        $participantName = htmlspecialchars($participantScoreRow['participant_name']);

        echo '<tr>';
        echo '<td style="margin-left: 20px; color: rgb(255, 255, 255);">' . $participantName . '</td>';

        // Fetch participant scores for each criterion
        $fetchParticipantScoresQuery = "SELECT criterion_temp_score
                                       FROM criterion_scoring
                                       WHERE participants_id = $participantId";
        $participantScoresResult2 = $conn->query($fetchParticipantScoresQuery); // Use a different variable name

        if ($participantScoresResult2->num_rows > 0) {
            while ($scoreRow = $participantScoresResult2->fetch_assoc()) {
                echo '<td style="margin-left: 20px; color: rgb(255, 255, 255);">' . $scoreRow['criterion_temp_score'] . '</td>';
            }
        }

        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
} else {
    echo '<p style=" color: rgb(255, 255, 255);">No participant scores found.</p>';
}

$conn->close();
?>

  </div>
</div>
</div>

</div>
</div>
    <!-- Scripts -->
    <script src="./js/jquery-3.6.4.js"></script>
    <script src="js/P&J-admin-common.js"></script>
    <script src="js/bootstrap.min.js"></script>
   
  <script>

document.getElementById('submitPopup').addEventListener('click', function() {
        document.getElementById('score_form').submit();
    });
function showSubmit(event) {
        event.preventDefault(); // Prevent the form from submitting immediately
        document.getElementById('submitWrapper').style.display = 'flex';
    }
  var hideSubmit = function() {
    document.getElementById('submitWrapper').style.display = 'none';
  }

// Event listener to trigger discardChanges() when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Attach the discardChanges function to the "Discard" button
    var discardButton = document.getElementById('cancelButtonP');
    if (discardButton) {
        discardButton.addEventListener('click', discardChanges);
    }
});


    let isAuthenticated = false;
// Function to show the authentication popup and blurred background
function showPopup() {
      const popup = document.getElementById('auth-form');
      popup.style.display = 'block';
      popup.classList.add('active');

      // Show the blurred background
      const blurredBackground = document.getElementById('blurred-background');
      blurredBackground.style.display = 'block';

      // Hide the editPopup
      const editPopup = document.getElementById('editPopup');
      editPopup.style.display = 'none';
    }

    // Function to hide the authentication popup and blurred background
    function hidePopup() {
      const popup = document.getElementById('auth-form');
      popup.style.display = 'none';
      popup.classList.remove('active');

      // Hide the blurred background
      const blurredBackground = document.getElementById('blurred-background');
      blurredBackground.style.display = 'none';

      // Show the editPopup
      const editPopup = document.getElementById('editPopup');
      editPopup.style.display = 'block';
    }

    window.addEventListener("DOMContentLoaded", function() {
    var form = document.querySelector('form[action="php/P&J-admin-action-scores.php"]');
    form.addEventListener("submit", function(event) {
        submitForm(); // Call your custom function
    });
});

    function submitForm() {
    var selectedParticipantId = document.getElementById('participant_select').value;
    document.getElementById('selected_participant_id').value = selectedParticipantId;

    var form = document.querySelector('form[action="php/P&J-admin-action-scores.php"]');
    form.submit();
}
        popupCancel = document.getElementById('cancelWrapper');
  
        var showCancel = function(event) {
          event.preventDefault();
            popupCancel.style.display ='flex';
        }
        var hideCancel = function(event) {
    
    popupCancel.style.display = 'none';
}

      function checkInputs() {
      var inputs = document.getElementsByTagName('input');
      var cancelButton = document.getElementById('cancelButton');
      var hasValue = false;

      for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].value !== '') {
          hasValue = true;
          break;
        }
      }

      cancelButton.disabled = !hasValue;
    }

// Function to send authentication data to the server for verification
function authenticate() {
  const eventCode = document.getElementById('event_code').value;
  const judgeName = document.getElementById('judge_name').value;

  // Send authentication data to the server using AJAX or Fetch API
  fetch('php/P&J-admin-authenticate.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ event_code: eventCode, judge_name: judgeName })
  })
    .then(response => response.json())
    .then(data => {
      if (data.authenticated) {
        // Authentication successful, fetch the criteria data
        fetch('php/P&J-admin-fetch_criteria.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ event_code: eventCode, judge_name: judgeName })
        })
          .then(response => response.text())
          .then(html => {
            const criteriaTable = document.getElementById('criteria-table');
            const divElement = document.getElementById('placeholder-table');
            
            divElement.style.display = "none";
            criteriaTable.innerHTML = html;
            hideAuthenticatedText();
            hidePopup();
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while fetching the criteria data.');
          });
      } else {
        alert('Authentication failed. Please check your credentials.');
        showPopup();
      }
    })
    
}

// Show the popup if the user is not authenticated
if (!isAuthenticated) {
  showPopup();
}

// Event listener for the Authenticate button
document.getElementById('login-btn').addEventListener('click', authenticate);

function hideAuthenticatedText() {
  const criteriaTable = document.getElementById('criteria-table');
  const content = criteriaTable.innerHTML;
  const authenticatedText = '{"authenticated":true}';
  
  if (content.includes(authenticatedText)) {
    const newContent = content.replace(authenticatedText, '');
    criteriaTable.innerHTML = newContent;
  }
}
</script>


</body>

</html>