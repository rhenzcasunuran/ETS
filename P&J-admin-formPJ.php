<?php
  include './php/sign-in.php';
  include './php/database_connect.php';
?>
<!-- add other php modules on the sidebar -->

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0"/>
    <title>Judges and Participants</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="css/theme-mode.css">
    <script src="js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="css/P&J-participantsandjudges.css"/>
    <link rel="stylesheet" href="./css/system-wide.css"> 
    <link rel="stylesheet" href="css/boxicons.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/sidebar-style.css">
    <link rel="stylesheet" href="css/home-sidebar-style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400&amp;display=swap">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.3/css/bootstrap.min.css'/>
    <style>
     .table-container {
  overflow-x: auto;
}

table {
  table-layout: fixed;
  border-collapse: collapse;
}

th, td {
  padding: 8px;
  white-space: nowrap;
}

@media (max-width: 480px) {
  th, td {
    display: block;
    width: 100%;
  }
}

input[readonly] {
  background-color: var(--color-content-card)!important; 
  color: var(--color-content-text)!important;
  border: none;
  border-color: var(--color-content-card)!important;
  padding: 0;
  cursor: pointer;
}

.editable {
      cursor: pointer;
    }

    
    </style>
    
    

  </head>
  <body>
    <?php
      $activeModule = 'judges-participants';

      require 'php/admin-sidebar.php';
    ?>
    <!--Page Content-->
    <!--Popup Confirm / Success for submit all button-->
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
                <button class="success-button" id="submitPopup"><i class='bx bx-check'></i>Confirm</button>
            </div>
        </div>
    </div>
    <!--Popup Cancel / Warning for judges-->
    <div class="popup-background" id="popup">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-error prompt-icon warning-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Delete Judge Row?</h3>   <!--header-->
                <p>Any unsaved progress will be lost.</p> <!--text-->
            </div>
            <div  class="div">
                <button class="outline-button" onclick="hide()"><i class='bx bx-chevron-left'></i>Return</button>
                <button id="clear" class="primary-button continue" onclick="deleteSelected();hide();"><i class='bx bx-x'></i>Discard</button>
            </div>
        </div>
    </div>
             
    <!--Popup Cancel / Warning for participants-->
    <div class="popup-background" id="popupPar">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-error prompt-icon warning-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Discard Changes?</h3>   <!--header-->
                <p>Any unsaved progress will be lost.</p> <!--text-->
            </div>
            <div  class="div">
                <button class="outline-button" onclick="hidep()"><i class='bx bx-chevron-left'></i>Return</button>
                <button class="primary-button" onclick="deleteSelectedP();hidep();"><i class='bx bx-x'></i>Discard</button>
            </div>
        </div>
    </div>
              
    <!--Popup Cancel / Warning for participants grouped-->
    <div class="popup-background" id="popupparg">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-error prompt-icon warning-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Discard Changes?</h3>   <!--header-->
                <p>Any unsaved progress will be lost.</p> <!--text-->
            </div>
            <div  class="div">
                <button class="outline-button" onclick="hidepg()"><i class='bx bx-chevron-left'></i>Return</button>
                <button class="primary-button" onclick="deleteSelectedPG();hidepg();"><i class='bx bx-x'></i>Discard</button>
            </div>
        </div>
    </div>
  
              

    <section class="home-section">
    <form action="php/P&J-admin-action.php" method="POST" id="submitAll">
      <div class="container">
        <div class="row" style="min-width: 100%;">
            <div class="col-md-10" style="max-width: 100%;min-width: 100% auto;">
                <div class="row" style="margin-bottom: 20px;margin-top: 20px;">
                    <div class="col">
                        <h4 class="fw-bold d-table-cell title">Judges and Participants</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xxl-12"><label class="form-label fw-bold" style="margin-left: 25px; color:var(--color-content-text);">Event</label><label for="Participant Category" class="form-label fw-bold" style="margin-left: 190px; color:var(--color-content-text);">Participant Category</label>
                        <div class="dropdown"><input type='text' class='inputpname' style='border-radius:20px; margin-left:20px;width:200px' placeholder='Event Code' name='event_code' id='event_code' minlength="12" maxlength="12" style="margin-left:30px;width: 180px; height: 40px;" Required/>
                        
                        <select name ="Participant Category"class='btn dropdown-toggle div-toggle' aria-expanded='false' data-bs-toggle='dropdown' type='button' style='border-radius: 20px;width: 180.031px;margin-left: 50px;background: var(--bs-light);color: var(--bs-body-color);' data-target=".participantsform">
                        <option data-show=".individual">Individual</option>
                        <option data-show=".group">Group</option>
                        </select>
                        </div>
                        <div class="row">
                          <div class="col">
                              <label class="col-form-label" style="font-weight:1000;margin-top: 25px; color:var(--color-content-text);">Judges</label>
                          </div>
                          <div class="col text-end" style="margin-right: 18px;">
                            <div style="display: flex; justify-content: flex-end;">
                                <button onClick="addRow();" class="buttonadd success-button icon-button" style="margin-right: 5px;" type="button" id="judgeadd">
                                <i class='bx bxs-user-plus'></i></button>
                                <button onclick="show()" class="buttonadd delete-button icon-button" style="margin-left: 5px;" type="button" id="judgeadd">
                                <i class='bx bxs-trash-alt'></i></button>
                            </div>
                          </div>
                        </div>


    <div class="div">
        <div class="element">
            <div class="row">
                <div class="element-group">
                <div id="show_judges">
                                    <div class="row">
                                    <div class="col">
                                    
                                  </div>
                                  <div>
                                  <table class="#" style="text-align:center; margin-left:40px; margin-top:1px; color:var(--color-content-text); min-width:90%;" id="Jtable">
                                  <thread>
                                    <tr>
                                    <th class="bordertable">
                                      <input type="checkbox" id="select-all" onchange="toggleAllCheckboxesJ()">
                                  </th>
                                  <th class="bordertable"><h6 class='judgeheader'>Judge Name</h6></th>
                                  <th class="bordertable"><h6 class='judgeheader'>Judge Nickname</h6></th>
                                  <th class="bordertable"><h6 class='judgeheader'>Scoring Link</h6></th>
                                  </tr>
                                  </thread>      
                                     <tbody>
                                      
                                     <?php
                  $sql = "SELECT * FROM judges";
                  
                  $result = $conn->query($sql);

                  if (!$conn) {
                    die("Connection Failed: " . mysqli_connect_error());
                  }

                  while ($row = $result->fetch_assoc()) {
                    $judgeId = $row['judge_id'];
                    $judgeName = $row['judge_name'];
                    $judgeNick = $row['judge_nickname'];
                    $scoringLink = "https://sample.link";

                    
                    echo "<tr class='editable-row' data-id='" . $row['judge_id'] . "'>
                      <td>
                        <input type='checkbox' class='checkbox'>
                      </td>
                      <td><input type='text' style='border-radius:20px;' class='inputjname editable cformj' value='$judgeName' readonly ondblclick='makeEditable(this)' onkeydown='handleKeyDown(event)'></td>
                      <td><input type='text' style='border-radius:20px;' class='inputjnick editable cformj' value='$judgeNick' readonly ondblclick='makeEditable(this)' onkeydown='handleKeyDown(event)'></td>
                      <td><a href='P&J-admin-scoretab.php' target='_blank'><button onClick='showl()' class='buttonlink1' type='button' style='border-radius:15px;width: 160px; height: 40px; color: white;background: #73A9CC;'><i class='bx bx-link'></i>Score Tabulation</button></a></td>
                    </tr>";
                  }
                  ?>
                                      
                                    <ul>
<!-- Judge Form -->
                                      
                                    </ul>
                                    </tbody>
                                    </table>
                                    </div>
                                    <div>

                                    </div>
                                    </div>
                                </div>
                </div>
            </div>
        </div>
    </div>
                        </div>
    
                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="participantsform">
                                              <div class="individual hide">
                      <div class="row">
                          <div class="col"><label class="col-form-label" style="font-weight:1000;margin-top: 25px; color:var(--color-content-text);">Participants</label></div>
                          <div class="col text-end" style="display:flex;">
                            <button onClick="addRowP();" class="buttonadd success-button icon-button" style="margin-left:auto;" type="button" id="paraddi"><i class='bx bxs-user-plus'></i></button>
                            <button onclick="showp()" class="buttonadd delete-button icon-button" style="margin-left: 5px;" type="button" id="judgeadd">
                                <i class='bx bxs-trash-alt'></i></button>
                          </div>
                      </div>
                                            
                                            </div>
                                            <div class="group hide">
                      <div class="row">
                          <div class="col"><label class="col-form-label" style="font-weight:1000;margin-top: 25px; color:var(--color-content-text);">Participants</label></div>
                          <div class="col text-end" style="display:flex;">
                            <button onclick="generateDiv()" class="buttonadd success-button icon-button" style="margin-left:auto;" type="button" id="paraddg"><i class='bx bxs-group'></i></button>
                            <button onclick="showpg()" class="buttonadd delete-button icon-button" style="margin-left: 5px;" type="button">
                                <i class='bx bxs-trash-alt'></i></button>
                          </div>
                      </div> 
                                            
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    <div class="div">
        <div class="element">
            <div class="row">
                <div class="element-group participantsform">
                <div class="individual hide">
                                  <div class="col">
                                  <div class="col">
<!-- Participants Form Individual -->
                                  </div>
                                  <table class="#" style="text-align:center; margin-left:40px; margin-top:1px; color:var(--color-content-text); min-width:90%;" id="Ptable">
                                  <thread>
                                    <tr>
                                    <th class="bordertable">
                                      <input type="checkbox" id="select-allP" onchange="toggleAllCheckboxesP()">
                                  </th>
                                  <th class="bordertable"><h6 class='judgeheader'>Participant Name</h6></th>
                                  <th class="bordertable"><h6  class='judgeheader'>Section</h6></th>
                                  <th class="bordertable"><h6  class='judgeheader'>Organization</h6></th>
                                  </tr>
                                  </thread>
                                  <tbody id="Pbox">
                                      <?php
                                      $query = "SELECT participants.participants_id, participants.participant_name, participants.participant_section, organization.organization_name FROM participants JOIN organization ON participants.organization_id = organization.organization_id";
                                      $result = mysqli_query($conn, $query);

                                      if (!$conn) {
                                        die("Connection Failed: " . mysqli_connect_error());
                                    }

                                    while($row = $result -> fetch_assoc()) {
                                      $prtId = $row['participants_id'];
                                      $prtName = $row['participant_name'];
                                      $prtSection = $row['participant_section'];
                                      $prtOrganization = $row['organization_name'];

                                      echo "<tr class='editable-row' data-id='" . $row['participants_id'] . "'>
                      <td>
                        <input type='checkbox' class='checkboxP'>
                      </td>
                      <td><input type='text' style='border-radius:20px;' class='inputjname editable cformpi' value='$prtName' readonly ondblclick='makeEditable(this)' onkeydown='handleKeyDown(event)'></td>
                      <td><input type='text' style='border-radius:20px;' class='inputpcs editable cformpi' value='$prtSection' readonly ondblclick='makeEditable(this)' onkeydown='handleKeyDown(event)'></td>
                      <td><input type='text' style='border-radius:20px;' class='inputpcsd editable cformpi' value='$prtOrganization' readonly ondblclick='makeEditable(this)' onkeydown='handleKeyDown(event)'></td>
                    </tr>";
                                    }
                                    
                                      
                                      ?>
                                      
                                      
                                  
                                   
                                    </tbody>
                                    </table>
                                  </div>
                                  
                                  </div>
                                  <div class="col group hide" style="width:auto;">
                                  <div>
 
  <!-- Participants grouped -->
                                  
                                      <div id="mainDiv">
                                      <input type="checkbox" id="mainCheckbox" onclick="toggleAllCheckboxesPG()">

                                    </div>
                                  </div>
                                    <br>

                            </div>
                            
                        </div>
                        
                </div>
            </div>
        </div>
    </div>
    <div class="row">
  
    <div class="row d-flex justify-content-end">
  <button type="submit" class="primary-button mx-2" name="pjFormSaveBtn" id="pjFormSaveBtn" style="float:right; margin-bottom:10px;" onclick="showSubmit(event)" disabled>
    <div class="tooltip-popup flex-column" id="tooltip">
      <div class="tooltipText" id="textJName">All Judge Names have a value (5 or more characters)<i class='bx bx-check' id="checkJNameValue"></i></div>
      <div class="tooltipText" id="textJNick">All Judge Nicknames have a value (5 or more characters)<i class='bx bx-check' id="checkJNickValue"></i></div>
      <div class="tooltipText" id="textPName">All Participant Names have a value (5 or more characters)<i class='bx bx-check' id="checkPNameValue"></i></div>
      <div class="tooltipText" id="textPSection">All Participant Sections are valid (e.g., 1-1)<i class='bx bx-check' id="checkPSectionValue"></i></div>
    </div>
    Save
  </button>
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
    <script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js'></script>
    <script src="./js/script.js"></script>
    <script src="./js/P&J-admin-disable-formsubmit-button.js"></script>
    <script src="./js/jquery-3.6.4.js"></script>
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


    </script>
<script  type="text/javascript">
  function makeEditable(input) {
  input.readOnly = false;
  input.classList.add("active");
  input.focus();
}

// Add an event listener to handle blur (focus lost) on editable cells
document.getElementById("Jtable").addEventListener("blur", function(event) {
  var target = event.target;
  if (target.classList.contains("editable")) {
    target.readOnly = true;
    target.classList.remove("active");
  }
});

function toggleAllCheckboxesJ() {
            var checkboxes = document.getElementsByClassName('checkbox');
            var selectAllCheckbox = document.getElementById('select-all');
            
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = selectAllCheckbox.checked;
            }
            enableSubmitButton();
            updateTotalValuesJ();
        }

        function deleteSelected() {
            var checkboxes = document.getElementsByClassName('checkbox');
            var selectAllCheckbox = document.getElementById('select-all');

            for (var i = checkboxes.length - 1; i >= 0; i--) {
                if (checkboxes[i].checked) {
                    checkboxes[i].parentNode.parentNode.remove();
                }
            }

            selectAllCheckbox.checked = false;
        }

function toggleAllCheckboxesP() {
            var checkboxesP = document.getElementsByClassName('checkboxP');
            var selectAllCheckbox = document.getElementById('select-allP');
            
            for (var i = 0; i < checkboxesP.length; i++) {
                checkboxesP[i].checked = selectAllCheckbox.checked;
            }
            updateTotalValuesP();
        }

        function deleteSelectedP() {
            var checkboxesP = document.getElementsByClassName('checkboxP');
            var selectAllCheckboxP = document.getElementById('select-allP');

            for (var i = checkboxesP.length - 1; i >= 0; i--) {
                if (checkboxesP[i].checked) {
                    checkboxesP[i].parentNode.parentNode.remove();
                }
            }

            selectAllCheckboxP.checked = false;
        }

        function deleteSelectedPG() {
            var checkboxesP = document.getElementsByClassName('checkboxPG');
            var selectAllCheckboxP = document.getElementById('select-allP');

            for (var i = checkboxesP.length - 1; i >= 0; i--) {
                if (checkboxesP[i].checked) {
                    checkboxesP[i].parentNode.parentNode.remove();
                }
            }

            selectAllCheckboxP.checked = false;
        }

function updateLabel(dropdown) {
      var dropdownId = dropdown.id;
      var label = document.querySelector('label[for="' + dropdownId + '"]');
      label.textContent = dropdown.value;
    }

    popupSubmit = document.getElementById('submitWrapper');
  
    function showSubmit(event) {
        event.preventDefault(); // Prevent the form from submitting immediately
        document.getElementById('submitWrapper').style.display = 'flex';
    }
  var hideSubmit = function() {
    popupSubmit.style.display ='none';
  }

  document.getElementById('submitPopup').addEventListener('click', function() {
        document.getElementById('submitAll').submit();
    });

  popup = document.getElementById('popup');
var show = function(){
    popup.style.display = 'flex';
}
var hide = function(){
    popup.style.display = 'none';
}

clearPopup = document.getElementById('clear-popup');
var show_clear = function(){
    clearPopup.style.display = 'flex';
}
var hide_clear = function(){
    clearPopup.style.display = 'none';
}

discardChangesPopup = document.getElementById('discardChanges-popup');
var show_discardChanges = function(){
    discardChangesPopup.style.display = 'flex';
}
var hide_discardChanges = function(){
    discardChangesPopup.style.display = 'none';
}


popupp = document.getElementById('popupPar');
var showp = function(){
    popupp.style.display = 'flex';
}
var hidep = function(){
    popupp.style.display = 'none';
}

clearPopupp = document.getElementById('clear-popupp');
var show_clearp = function(){
    clearPopupp.style.display = 'flex';
}
var hide_clearp = function(){
    clearPopupp.style.display = 'none';
}

discardChangesPopupp = document.getElementById('discardChanges-popupp');
var show_discardChangesp = function(){
    discardChangesPopupp.style.display = 'flex';
}
var hide_discardChangesp = function(){
    discardChangesPopupp.style.display = 'none';
}

popuppg = document.getElementById('popupparg');
var showpg = function(){
    popuppg.style.display = 'flex';
}
var hidepg = function(){
    popuppg.style.display = 'none';
}

clearPopuppg = document.getElementById('clear-popuppg');
var show_clearpg = function(){
    clearPopuppg.style.display = 'flex';
}
var hide_clearpg = function(){
    clearPopuppg.style.display = 'none';
}

discardChangesPopuppg = document.getElementById('discardChanges-popuppg');
var show_discardChangespg = function(){
    discardChangesPopuppg.style.display = 'flex';
}
var hide_discardChangespg = function(){
    discardChangesPopuppg.style.display = 'none';
}
</script>

<script defer>
  function enableEditing() {
    var editableRows = document.getElementsByClassName('editable-row');

    for (var i = 0; i < editableRows.length; i++) {
      var row = editableRows[i];
      var cells = row.getElementsByTagName('td');

    }
    
  }

  function handleKeyDown(event) {
  if (event.key === "Enter") {
    event.preventDefault();
    event.target.readOnly = true;
    event.target.classList.remove("active");
  }
}

  enableEditing();
    
    function addRow() {
    var table = document.getElementById("Jtable");

    var row = table.insertRow(-1);

    var checkBoxCell = row.insertCell(0);
    var checkBox = document.createElement("input");
    checkBox.type = "checkbox";
    checkBox.className = "checkbox";
    checkBoxCell.appendChild(checkBox);

    var nameCell = row.insertCell(1);
    var nameInput = document.createElement("input");
    nameInput.type = "text";
    nameInput.className = "inputjname cformj";
    nameInput.name = "judge_name[]";
    nameInput.style = "border-radius:20px;";
    nameInput.pattern = "[A-Za-z0-9 -]{4,20}";
    nameInput.minLength = 4;
    nameInput.maxLength = 20;
    nameInput.placeholder = "Judge Name";
    nameInput.title = "Enter a valid name (4-20 characters)";
    nameInput.addEventListener("dblclick", function () {
      this.readOnly = false;
    });
    nameCell.appendChild(nameInput);

    var nicknameCell = row.insertCell(2);
    var nicknameInput = document.createElement("input");
    nicknameInput.type = "text";
    nicknameInput.className = "inputjnick cformj";
    nicknameInput.name = "judge_nickname[]";
    nicknameInput.style = "border-radius:20px;";
    nicknameInput.minLength = 4;
    nicknameInput.maxLength = 10;
    nicknameInput.placeholder = "Nickname";
    nicknameInput.addEventListener("dblclick", function () {
      this.readOnly = false;
    });
    nicknameCell.appendChild(nicknameInput);

    var buttonCell = row.insertCell(3);
      var generateLinkButton = document.createElement("button");
      generateLinkButton.type = "button";
      generateLinkButton.className = "buttonlink1";
      
      generateLinkButton.style = "border-radius:15px;min-width: 160px; height: 40px; color: white;background: #73A9CC; margin-bottom: 20px;";
      generateLinkButton.innerHTML = "<i class='bx bx-link'></i> Score Tabulation";
      generateLinkButton.onclick = function() {
        window.location.href = "P&J-admin-scoretab.php" , "_blank";
      };
    buttonCell.appendChild(generateLinkButton);

    checkBox.onclick = function () {
      enableSubmitButton();
            updateTotalValuesJ();
    };

    nameInput.onkeydown = function (event) {
      if (event.key === "Enter") {
        event.preventDefault();
        this.readOnly = true;
        enableSubmitButton();
            updateTotalValuesJ();
        
      }
    };

    nicknameInput.onkeydown = function (event) {
      if (event.key === "Enter") {
        event.preventDefault();
        this.readOnly = true;
        enableSubmitButton();
            updateTotalValuesJ();
      }
    };

    enableSubmitButton();
    updateTotalValuesJ();
  }

    function submitData() {
      var table = document.getElementById("");
      var rows = table.rows;
      var data = [];
      
      for (var i = 1; i < rows.length; i++) {
        var cells = rows[i].cells;
        var rowData = {
          name: cells[1].querySelector("input[type='text']").value,
          nickname: cells[2].querySelector("input[type='text']").value
        };
        data.push(rowData);
      }
      
      // Send data to the server or perform desired actions
      console.log(data);
    }


function addRowP() {
  
      var table = document.getElementById("Ptable");
      var row = table.insertRow(-1);

      // Create checkbox
      var checkCellP = row.insertCell(0);
      var checkboxP = document.createElement("input");
      checkboxP.type = "checkbox";
      checkboxP.className = "checkboxP";
      checkCellP.appendChild(checkboxP);
      
      // Create judge name input
      var nameCellP = row.insertCell(1);
      var parNameInput = document.createElement("input");
      parNameInput.type = "text";
      parNameInput.className = "inputpname cformj";
      parNameInput.name = "participant_name[]";
      parNameInput.style = "border-radius:20px;";
      parNameInput.minLength = 4;
      parNameInput.maxLength = 20;
      parNameInput.placeholder = "Participant Name";
      parNameInput.title = "Enter a valid name (4-20 characters)";
      parNameInput.addEventListener("dblclick", function() {
        this.readOnly = false;
      });
      nameCellP.appendChild(parNameInput);

      var sectionCellP = row.insertCell(2);
      var sectionInputP = document.createElement("input");
      sectionInputP.type = "text";
      sectionInputP.className = "inputpcs cformj";
      sectionInputP.name = "participant_section[]";
      sectionInputP.style = "border-radius:20px;";
      sectionInputP.minLength = 3;
      sectionInputP.maxLength = 3;
      sectionInputP.placeholder = "Section";
      sectionInputP.addEventListener("dblclick", function() {
        this.readOnly = false;
      });
      sectionCellP.appendChild(sectionInputP);

      // Organization dropdown
      
      var orgSelectP = document.createElement("select");
      
      
 // Create dropdown
 fetch('php/P&J-fetch-options.php')
    .then(response => response.json())
    .then(data => {
      var orgCellP = row.insertCell(3);
      const orgSelectP = document.createElement('select');
      orgSelectP.name = "organization_id[]";
      orgSelectP.className = "inputpcs dropdown-toggle div-toggle";
      orgSelectP.style = "border-radius:20px; background-color:white; width: auto; margin-bottom: 20px;";

      // Add a default option (optional)
      const orgOption = document.createElement('option');
      orgOption.text = 'Organization';
      orgOption.disabled = true;
      orgOption.selected = true;
      orgSelectP.appendChild(orgOption);

      // Populate the dropdown with options from the fetched data
      data.forEach(option => {
        const orgElement = document.createElement('option');
        orgElement.text = option.organization_name;  
        orgElement.value = option.organization_id;  
        orgSelectP.appendChild(orgElement);
      });

      // Append the dropdown to the container
      orgCellP.appendChild(orgSelectP);
    })
    .catch(error => console.error('Error fetching options:', error));
      checkboxP.onclick = function () {
      enableSubmitButton();
            updateTotalValuesP();
    };

    parNameInput.onkeydown = function (event) {
      if (event.key === "Enter") {
        event.preventDefault();
        this.readOnly = true;
        enableSubmitButton();
            updateTotalValuesP();
      }
    };

    sectionInputP.onkeydown = function (event) {
      if (event.key === "Enter") {
        event.preventDefault();
        this.readOnly = true;
        enableSubmitButton();
            updateTotalValuesP();
      }
    };

    enableSubmitButton();
    updateTotalValuesP();

    }

    let divCount = 0;


    function generateDiv() {
      
  divCount++;
  const divId = `div${divCount}`;
  let organizationId;

  // Create the main div element
  const div = document.createElement('div');
  div.id = divId;

  // Create the container for the organization dropdown
  const dropdownContainer = document.createElement('div');
  dropdownContainer.style.marginBottom = '10px';
  div.appendChild(dropdownContainer);

  // Create dropdown
  fetch('php/P&J-fetch-options.php')
    .then(response => response.json())
    .then(data => {
      const organizationId = data[0].organization_id;
      const dropdown = document.createElement('select');
      dropdown.className = "btn dropdown-toggle div-toggle";
      dropdown.style = "border-radius: 20px;width: 180.031px;margin-left: 50px;background: var(--bs-light);color: var(--bs-body-color);";
      dropdown.name = "organization_id[]";


      // Add a default option (optional)
      const defaultOption = document.createElement('option');
      defaultOption.text = 'Organization';
      defaultOption.disabled = true;
      defaultOption.selected = true;
      dropdown.appendChild(defaultOption);

      // Populate the dropdown with options from the fetched data
      data.forEach(option => {
        const optionElement = document.createElement('option');
        optionElement.text = option.organization_name;
        optionElement.value = option.organization_id;
        dropdown.appendChild(optionElement);
      });

      // Append the dropdown to the dropdown container
      dropdownContainer.appendChild(dropdown);
    })
    .catch(error => console.error('Error fetching options:', error));

  // Create a container for the table
  const tableContainer = document.createElement('div');
  div.appendChild(tableContainer);

  // Create the table
  const table = document.createElement('table');
  table.className = 'row-table';
  tableContainer.appendChild(table);

  // Create the table body
  const tbody = document.createElement('tbody');
  table.appendChild(tbody);

  // Create the button to toggle visibility of rows
  const toggleButton = document.createElement('button');
  toggleButton.type = 'button';
  toggleButton.innerHTML = "<i class='bx bx-hide'></i>";
  toggleButton.style = "justify-content: center; align-items: center; text-align: center; font-size: 16px!important; font-weight: 500!important; border-radius: 30px!important; box-shadow: 0 4px 6px 0 var(--shadow-color); border: none!important; outline: none!important; cursor: pointer; user-select: none; background-color: var(--active-success-color)!important; color: var(--white-text-color)!important; background-color: var(--default-success-color)!important; border: 2px transparent solid!important; width:40px; height:40px; margin-right: 10px; margin-left: 10px;";
  toggleButton.onclick = function () {
    const rows = document.querySelectorAll(`#${divId} .row`);
    rows.forEach(row => {
      row.style.display = row.style.display === 'none' ? 'block' : 'none';
    });
  };
  const toggleButtonCell = document.createElement('td');
  toggleButtonCell.appendChild(toggleButton);

  // Create the button to add more rows
  const addRowButton = document.createElement('button');
  addRowButton.type = 'button';
  addRowButton.innerHTML = "<i class='bx bxs-user-plus'></i>";
  addRowButton.style = "justify-content: center; align-items: center; text-align: center; font-size: 16px!important; font-weight: 500!important; border-radius: 30px!important; box-shadow: 0 4px 6px 0 var(--shadow-color); border: none!important; outline: none!important; cursor: pointer; user-select: none; background-color: var(--active-success-color)!important; color: var(--white-text-color)!important; background-color: var(--default-success-color)!important; border: 2px transparent solid!important; width:40px; height:40px;";
  addRowButton.onclick = function () {
    const newRow = createRow(divId, organizationId);
    tbody.appendChild(newRow);
    updateTotalValuesP();
  };
  const addRowButtonCell = document.createElement('td');
  addRowButtonCell.appendChild(addRowButton);

  // Create the table row for buttons
  const buttonsRow = document.createElement('tr');
  buttonsRow.appendChild(toggleButtonCell);
  buttonsRow.appendChild(addRowButtonCell);
  tbody.appendChild(buttonsRow);

  // Create the container for rows
  const rowsContainer = document.createElement('div');
  rowsContainer.id = `${divId}-rows`;
  div.appendChild(rowsContainer);

  document.getElementById('mainDiv').appendChild(div);
  
  // Create the delete button
  const deleteButton = document.createElement('button');
  deleteButton.type = 'button';
  deleteButton.innerHTML = "<i class='bx bx-trash'></i>";
  deleteButton.style = "justify-content: center; align-items: center; text-align: center; font-size: 16px!important; font-weight: 500!important; border-radius: 30px!important; box-shadow: 0 4px 6px 0 var(--shadow-color); border: none!important; outline: none!important; cursor: pointer; user-select: none; background-color: var(--active-danger-color)!important; color: var(--white-text-color)!important; background-color: var(--default-danger-color)!important; border: 2px transparent solid!important; width:40px; height:40px;";
  deleteButton.onclick = function () {
    removeDiv(divId);
  };
  const deleteButtonCell = document.createElement('td');
  deleteButtonCell.appendChild(deleteButton);

  // Create the table row for buttons
  buttonsRow.appendChild(toggleButtonCell);
  buttonsRow.appendChild(addRowButtonCell);
  buttonsRow.appendChild(deleteButtonCell); // Add the delete button cell
  tbody.appendChild(buttonsRow);
  
  updateTotalValuesP();

}

function createRow(divId, organizationId) {
  const row = document.createElement('tr');
  row.className = 'row';

  // Create the checkbox for the row
  const checkbox = document.createElement('input');
  checkbox.type = 'checkbox';
  checkbox.className = "checkboxPG";
  checkbox.onclick = function () {
    toggleCheckbox(divId);
  };
  const checkboxCell = document.createElement('td');
  checkboxCell.appendChild(checkbox);
  row.appendChild(checkboxCell);

  // Create a hidden input field for organization_id
  const organizationIdInput = document.createElement('input');
  organizationIdInput.type = 'hidden';
  organizationIdInput.name = 'organization_id[]';
  organizationIdInput.value = organizationId; // Set the organization_id value for this row
  row.appendChild(organizationIdInput);

  // Create the textbox for the name
  const nameInputCell = document.createElement('td');
  const nameInputPG = document.createElement('input');
  nameInputPG.type = 'text';
  nameInputPG.placeholder = 'Name';
  nameInputPG.className = "inputpname cformj";
  nameInputPG.name = "participant_name[]";
  nameInputPG.style = "border-radius:20px;";
  nameInputPG.minLength = 4;
  nameInputPG.maxLength = 20;
  nameInputPG.placeholder = "Participant Name";
  nameInputPG.title = "Enter a valid name (4-20 characters)";
  nameInputPG.addEventListener("dblclick", function() {
        this.readOnly = false;
      });
      nameInputCell.appendChild(nameInputPG);
  row.appendChild(nameInputCell);
  updateTotalValuesP();

  // Create the textbox for the section
  const sectionInputCell = document.createElement('td');
  const sectionInputPG = document.createElement('input');
  sectionInputPG.type = 'text';
  sectionInputPG.placeholder = 'Section';
  sectionInputPG.className = "inputpcs cformj";
  sectionInputPG.name = "participant_section[]";
  sectionInputPG.style = "border-radius:20px;";
  sectionInputPG.minLength = 3;
  sectionInputPG.maxLength = 3;
  sectionInputPG.placeholder = "Section";
  sectionInputPG.addEventListener("dblclick", function() {
        this.readOnly = false;
      });
  sectionInputCell.appendChild(sectionInputPG);
  row.appendChild(sectionInputCell);

  nameInputPG.onkeydown = function (event) {
      if (event.key === "Enter") {
        event.preventDefault();
        this.readOnly = true;
        enableSubmitButton();
            updateTotalValuesP();
      }
    };

    sectionInputPG.onkeydown = function (event) {
      if (event.key === "Enter") {
        event.preventDefault();
        this.readOnly = true;
        enableSubmitButton();
            updateTotalValuesP();
      }
    };

    
    enableSubmitButton();
    updateTotalValuesP();
    

  return row;

}




function toggleAllCheckboxesPG() {
  const checkboxes = document.querySelectorAll('#mainDiv input[type="checkbox"]');
  const mainCheckbox = document.getElementById('mainCheckbox');

  checkboxes.forEach(checkbox => {
    checkbox.checked = mainCheckbox.checked;
  });
  updateTotalValuesP();
}

function toggleCheckboxes(divId) {
  const checkboxes = document.querySelectorAll(`#${divId} input[type="checkbox"]`);
  const mainCheckbox = document.getElementById(divId).querySelector('input[type="checkbox"]');

  checkboxes.forEach(checkbox => {
    checkbox.checked = mainCheckbox.checked;
  });
  updateTotalValuesP();
}

function toggleCheckbox(divId) {
  const checkboxes = document.querySelectorAll(`#${divId} input[type="checkbox"]`);
  const mainCheckbox = document.getElementById(divId).querySelector('input[type="checkbox"]');
  let allChecked = true;

  checkboxes.forEach(checkbox => {
    if (!checkbox.checked) {
      allChecked = false;
    }
  });
  updateTotalValuesP();
  mainCheckbox.checked = allChecked;
}

function deleteChecked() {
  const divs = document.querySelectorAll('#mainDiv > div');
  divs.forEach(div => {
    const checkbox = div.querySelector('input[type="checkbox"]');
    if (checkbox.checked) {
      div.parentNode.removeChild(div);
    } else {
      const rows = div.querySelectorAll('.row');
      rows.forEach(row => {
        const rowCheckbox = row.querySelector('input[type="checkbox"]');
        if (rowCheckbox.checked) {
          row.parentNode.removeChild(row);
        }
      });
    }
  });
}

function removeDiv(divId) {
  const divToRemove = document.getElementById(divId);
  divToRemove.remove();
  updateTotalValuesP(); // Update any totals or calculations, if needed
}

$(document).on('change', '.div-toggle', function() {
  var target = $(this).data('target');
  var show = $("option:selected", this).data('show');
  $(target).children().addClass('hide');
  $(show).removeClass('hide');
});
$(document).ready(function(){
	$('.div-toggle').trigger('change');
});

           

</script>

<script type="text/javascript">
  const select = document.querySelector(".select");
  const options_list = document.querySelector(".options-list");
  const options = document.querySelectorAll(".option");

  

  //select option
    options.forEach((option) => {
    option.addEventListener("click", () => {
    options.forEach((option) => {option.classList.remove('selected')});
    select.querySelector("span").innerHTML = option.innerHTML;
    option.classList.add("selected");
    options_list.classList.toggle("active");
    select.querySelector("bx-chevron-down").classList.toggle("bx-chevron-up");
    });
    });
</script>
  </body>

</html>