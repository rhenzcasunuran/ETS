<?php
  include './php/sign-in.php';
  include './php/database_connect.php';
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
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
    <nav class="navbar navbar-light navbar-expand-md" style="background: #282135;">
        <div class="container">
                        <h1 class="text-start" style="color: rgb(255,255,255); font-weight: 1000; margin-top: 20px;margin-left:400px;">Score Tabulation</h1>
            </div>
        </div>
    </nav>
    <div class="container" style="margin:auto;">
        <div class="row" style="margin-top: 16px;">
            <div class="col-xl-3 col-xxl-2 offset-xxl-0"><label class="form-label" style="color: rgb(255,255,255);margin-left:30px;">Event</label><br>
            <form action="php/P&J-admin-action-temp-S.php" method="POST" id="add_form">
            <input type='text' class='inputpname cforms' style='border-radius:10px; margin-left:20px;' placeholder='Event Code' name='event_code_temp' id="event_code_temp" minlength="12" maxlength="12" style="margin-left:30px;width: 180px; height: 40px;" Required pattern="[a-zA-Z0-9 ]*"/>
            </div>
            <div class="col"><label class="form-label" style="color: rgb(255,255,255);margin-left:30px;">Group</label><br>
                <select style="border-radius: 10px;width: 180.031px;height: 40px;margin-left: 19px;background: var(--bs-light);color: var(--bs-body-color); text-align: center;" name=" group_name_temp" id="group_name_temp">
                    <option>ITDS</option>
                    <option>JPIA</option>
                </select>
            </div>
        </div>
        <div class="row" style="margin-top: 20px; margin-bottom:20px;">
            <div class="col-lg-6 col-xl-6 col-xxl-4 offset-lg-0 offset-xxl-2">
            

</div>
</div>

        <div class="row" style="margin-top: 20px; margin-bottom:20px;">
            <div class="col-lg-6 col-xl-6 col-xxl-4 offset-lg-0 offset-xxl-2 inputscore show"><label class="form-label" style="margin-left:20px;color: rgb(255,255,255);">Criteria</label>
                <div class="d-table" style="background: #423c4e;margin-left: 10px;min-height: auto;padding-top: 33px;padding-left: 31px;padding-right: 39px;padding-bottom: 20px;min-width: auto;width: 100%;border-radius: 10px;box-shadow: 7px 5px 13px;">
                    <div class="row">
                        <div class="col" style="text-align: center;">
                            <div class="row">
                                <div class="col"><label class="col-form-label" style="color: rgb(255,255,255);font-weight:1000;">ITDS</label></div>
                                <div class="col"><label class="col-form-label" style="color: rgb(255,255,255);">Scores</label></div>
                            </div>
                            
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col"><label class="col-form-label" style="color: rgb(255,255,255);">Criteria 1</label></div>
                                        <div class="col"><input type="number" class="cforms" name="criteria_1_temp" id="criteria_1_temp" oninput="calculateTotal()" style="text-align: center;color: rgb(255,255,255);background: rgba(0,0,0,0.22);" min="1" max="10" placeholder="10" Required></div>
                                    </div>
                                    <div class="row">
                                        <div class="col"><label class="col-form-label" style="color: rgb(255,255,255);">Criteria 2</label></div>
                                        <div class="col"><input type="number" class="cforms" name="criteria_2_temp" id="criteria_2_temp" oninput="calculateTotal()" style="text-align: center;color: rgb(255,255,255);background: rgba(0,0,0,0.22);" min="1" max="10" placeholder="10" Required></div>
                                    </div>
                                    <div class="row">
                                        <div class="col"><label class="col-form-label" style="color: rgb(255,255,255);">Criteria 3</label></div>
                                        <div class="col"><input type="number" class="cforms" name="criteria_3_temp" id="criteria_3_temp" oninput="calculateTotal()" style="text-align: center;color: rgb(255,255,255);background: rgba(0,0,0,0.22);" min="1" max="10" placeholder="10" required></div>
                                    </div>
                                    <div class="row">
                                        <div class="col"><label class="col-form-label" style="color: rgb(255,255,255);">Criteria 4</label></div>
                                        <div class="col"><input type="number" class="cforms" name="criteria_4_temp"  id="criteria_4_temp" oninput="calculateTotal()" style="text-align: center;color: rgb(255,255,255);background: rgba(0,0,0,0.22);" min="1" max="10" placeholder="10" required></div>
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
                                
                                </form>
                                <form action="php/P&J-admin-action-scores.php" method="POST"> <!--  -->
                                <button onclick="showSubmit()" class="success-button buttonsubmit" type="submit" style="text-align: center;"  value="Add" id="save_btnS" >Submit</button>
                                
                                </form>
                                <button onclick="cancelInput()" class="secondary-button delJ" id="can_btnS" type="button"  style="display:inline;" >Cancel</button>
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
                <button class="success-button" id="submitPopup" name="save_btnS"><i class='bx bx-check'></i>Confirm</button>
            </div>
        </div>
    </div>
            <div class="col-lg-5 col-xxl-4 offset-lg-1 offset-xl-1 offset-xxl-1" style="padding: 0px;">
                <div style="background: #282135;margin-top: 27px;height: 100% auto;border-radius: 10px;box-shadow: 3px 3px 8px;">
                    <div class="container">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="color: rgb(255,255,255);">Group/Participants</th>
                                        <th style="color: rgb(255,255,255);">Scores</th>
                                        <th style="color: rgb(255,255,255);">Edit</th>
                                    </tr>
                                </thead>
                                <?php include 'php/P&J-admin-action-editscores.php'; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="./js/jquery-3.6.4.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">

/*
        // ajax request
        $("#add_form").submit(function(e){
                e.preventDefault();
                $("#add_btnS").val('Adding...');
                $.ajax({
                    url:'php/P&J-admin-action-temp-S.php',
                    method:'POST',
                    data: $(this).serialize(),
                    success:function(response){
                        console.log(response);
                        $("#add_btnS").val('Add');
                        document.getElementById("criteria_1_temp").value = "0";
                        document.getElementById("criteria_2_temp").value = "0";
                        document.getElementById("criteria_3_temp").value = "0";
                        document.getElementById("criteria_4_temp").value = "0";
                        validateForm()
                    }
                })
            });
*/
    </script>
    <script>
    function calculateTotal() {
      var criteria1 = Number(document.getElementById('criteria_1_temp').value);
      var criteria2 = Number(document.getElementById('criteria_2_temp').value);
      var criteria3 = Number(document.getElementById('criteria_3_temp').value);
      var criteria4 = Number(document.getElementById('criteria_4_temp').value);

      var sum = ((criteria1 + criteria2 + criteria3 + criteria4)/(10+10+10+10)*100);

      document.getElementById('sum').value = sum;
      
    }
  </script>
  <script>
function cancelInput() {
  document.getElementById("criteria_1_temp").value = "0";
  document.getElementById("criteria_2_temp").value = "0";
  document.getElementById("criteria_3_temp").value = "0";
  document.getElementById("criteria_4_temp").value = "0";
  document.getElementById("sum").value = "0";
}
</script>
<script type="text/javascript">
    /*
  const formSubmit = document.getElementById('add_form');
  const popupSubmit = document.getElementById('submitWrapper');
  const okButton = document.getElementById('submitPopup');
  const addBtn = document.getElementById('add_btnS');
  const saveBtn = document.getElementById('save_btnS');
  const cancelBtn = document.getElementById('can_btnS');

  formSubmit.addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting directly
  });

  var showSubmit = function() {
    popupSubmit.style.display = 'flex';
  }

  var hideSubmit = function() {
    popupSubmit.style.display = 'none';
  }

  // Add event listener to handle form submission on OK button click
  okButton.addEventListener('click', function() {
    formSubmit.submit(); // Submit the form
  });

  // Get the form and submit button element
  const form = document.getElementById('add_form');
  const dynamicInputs = document.getElementsByClassName('cforms');

  // Add event listener to the form for input change
  form.addEventListener('input', validateForm);

  // Validate the form inputs
  function validateForm() {
    let hasInvalidInput = false;

    // Loop through each dynamic input
    for (let i = 0; i < dynamicInputs.length; i++) {
      const input = dynamicInputs[i];
      if (input.value.trim() === '') {
        hasInvalidInput = true;
        break;
      }
      // Add your specific input validation logic here
      // For example, check if the input follows a certain pattern or meets specific criteria
      // If the input is invalid, set hasInvalidInput to true and break the loop
    }

    // Disable or enable the submit button based on the input validity
    addBtn.disabled = hasInvalidInput || dynamicInputs.length === 0;
    saveBtn.disabled = hasInvalidInput || dynamicInputs.length === 0;
    cancelBtn.disabled = hasInvalidInput || dynamicInputs.length === 0;
  }

  // Call the validateForm function initially to set the button states
  validateForm();
  */
</script>

</body>

</html>