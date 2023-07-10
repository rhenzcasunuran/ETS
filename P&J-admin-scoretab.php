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
    /* Styles for the modal dialog */
    .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 400px;
        }
    .edit-form {
      display: none;
    }
  </style>

  </head>

  <body style="background: rgb(25,20,36);">
  <div id="auth-form">
    <h2>Authentication</h2>
    <input type="text" id="event_code" name="event_code"placeholder="Event Code">
    <input type="text" id="judge_name" name="judge_name" placeholder="Judge Name">
    <button id="login-btn" onclick="authenticate()">Authenticate</button>
  </div>
  <div class="popup-background" id="submitWrapper">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-check-circle prompt-icon success-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Submit All to Database?</h3>   <!--header-->
                <p>You cannot undo this action.</p> <!--text-->
            </div>
            <div  class="div">
                <button class="outline-button" onclick="hideSubmit()"><i class='bx bx-x'></i>Cancel</button>
                <button class="success-button" onclick="submitForm()"><i class='bx bx-check'></i>Confirm</button>
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
            <div  class="div">
                <button class="outline-button" onclick="hideCancel()"><i class='bx bx-chevron-left'></i>Return</button>
                <button class="primary-button"><i class='bx bx-x'></i>Discard</button>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-light navbar-expand-md" style="background: #282135;">
        <div class="container">
                        <h1 class="text-start" style="color: rgb(255,255,255); font-weight: 1000; margin-top: 20px;margin-left:400px;">Score Tabulation</h1>
            </div>
        </div>
    </nav>
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

                    <div class="col offset-xl-2 offset-xxl-1" style="text-align: center;">
                        <div class="btn-toolbar" style="text-align: center;">
                            <div class="btn-group" role="group" style="text-align: center;margin-top: 10px;">
                            <button class="primary-button" type="submit" value="Add" id="add_btnS" >Save</button>
                                
                                
                                <button onclick="showSubmit()" class="success-button buttonsubmit" type="submit" style="text-align: center;"  value="Add" id="save_btnS" >Submit</button>
                                
                                
                                <button onclick="cancelInput()" class="secondary-button delJ" id="can_btnS" type="button"  style="display:inline;" >Cancel</button>
                                </div>
                        </div>
                    </div>
                </div>
                                </div>
                            </div>
                            
                            
                        </div>
                        <form action="php/P&J-admin-action-scores.php" method="POST"> <!--  -->
                        <div class='row' style="text-align: center;" id="criteria-table">
                        
                            </div>
                            
                            </form>
                    </div>
                </div>
            </div>
            

            
            
        </div>
    </div>
    <!-- Scripts -->
    <script src="./js/jquery-3.6.4.js"></script>
    <script src="js/bootstrap.min.js"></script>
   
  <script>
    let isAuthenticated = false;
// Function to show the authentication popup
function showPopup() {
  const popup = document.getElementById('auth-form');
  popup.style.display = 'block';
  popup.classList.add('active');
}

// Function to hide the authentication popup
function hidePopup() {
  const popup = document.getElementById('auth-form');
  popup.style.display = 'none';
  popup.classList.remove('active');
}

window.addEventListener("DOMContentLoaded", function() {
        var form = document.querySelector('form[action="php/P&J-admin-action-scores.php"]');
        form.addEventListener("submit", function(event) {
            submitForm(); // Call your custom function
        });
    });

        function submitForm() {
            var form = document.querySelector('form[action="php/P&J-admin-action-scores.php"]');
            form.submit();
        }

        popupCancel = document.getElementById('cancelWrapper');
  
        var showCancel = function() {
            popupCancel.style.display ='flex';
        }
        var hideCancel = function() {
            popupCancel.style.display ='none';
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
    .catch(error => {
      console.error('Error:', error);
      alert('An error occurred during authentication.');
    });
}

// Show the popup if the user is not authenticated
if (!isAuthenticated) {
  showPopup();
}

// Event listener for the Authenticate button
document.getElementById('login-btn').addEventListener('click', authenticate);


</script>


</body>

</html>