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
    <link rel="stylesheet" href="css/HOM-style.css">
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
  background-color: var(--color-content-card);
  color:var(--color-content-text)
  border: none;
  border-color: var(--color-content-card);
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
                <h3 class="text-header">Discard Changes?</h3>   <!--header-->
                <p>Any unsaved progress will be lost.</p> <!--text-->
            </div>
            <div  class="div">
                <button class="outline-button" onclick="hide()"><i class='bx bx-chevron-left'></i>Return</button>
                <button id="clear" class="primary-button continue" onclick="deleteListJ();hide();"><i class='bx bx-x'></i>Discard</button>
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
                <button class="primary-button" onclick="deleteListP();hidep();"><i class='bx bx-x'></i>Discard</button>
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
                <button class="primary-button" onclick="deleteListPG();hidepg();"><i class='bx bx-x'></i>Discard</button>
            </div>
        </div>
    </div>
  
              <div class="popup container-fluid" id="popuplink">
                <div class="popup-card">
  <div class="popup-content">
    <span class="close" onclick="closePopup()" style="color:var(--color-content-text);">&times;</span>
    <h2 style="color:var(--color-content-text)">Copy the link to score</h2>
    <p style="color:var(--color-content-text)">Copy the scoring link below:</p>
    <input type="text" style="color:var(--color-content-text" value="Https//:SampleLink" readonly><a href='P&J-admin-scoretab.php' target="_blank" style="position:relative;top:0; right:0;">
                <button class="buttonadd"id="clearlink"style="width:100%;">
                 <i class='bx bxs-copy' ></i>
                </button>
                </a></input>
                <h6 style="color:var(--color-content-text)">*Only authorized persons can access the link.*</h6>
  </div>
</div>
</div>

    <section class="home-section">
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
                        <div class="dropdown"><input type='text' class='inputpname cformj' style='border-radius:20px; margin-left:20px;' placeholder='Event Code' name='event_code' minlength="12" maxlength="12" style="margin-left:30px;width: 180px; height: 40px;" pattern="[a-zA-Z0-9 ]*" Required/>
                        
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
                                <button onclick="deleteSelected()" class="buttonadd delete-button icon-button" style="margin-left: 5px;" type="button" id="judgeadd">
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
                                  <table class="#" style="text-align:center; margin-left:40px; margin-top:1px; color:var(--color-content-text);" id="Jtable">
                                  <thread>
                                    <tr>
                                    <th class="bordertable">
                                      <input type="checkbox" id="select-all" onchange="toggleAllCheckboxes()">
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
                    $judgeNick = $row['judge_nick'];
                    $scoringLink = "https://sample.link";

                    
                    echo "<tr class='editable-row' data-id='" . $row['judge_id'] . "'>
                      <td>
                        <input type='checkbox' class='checkbox'>
                      </td>
                      <td><input type='text' style='border-radius:20px;' class='inputjname editable cformj' value='$judgeName' readonly ondblclick='makeEditable(this)' onkeydown='handleKeyDown(event)'></td>
                      <td><input type='text' style='border-radius:20px;' class='inputjnick editable cformj' value='$judgeNick' readonly ondblclick='makeEditable(this)' onkeydown='handleKeyDown(event)'></td>
                      <td>https://sample.link</td>
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
                            <button onclick="deleteSelectedP()" class="buttonadd delete-button icon-button" style="margin-left: 5px;" type="button" id="judgeadd">
                                <i class='bx bxs-trash-alt'></i></button>
                          </div>
                      </div>
                                            
                                            </div>
                                            <div class="group hide">
                      <div class="row">
                          <div class="col"><label class="col-form-label" style="font-weight:1000;margin-top: 25px; color:var(--color-content-text);">Participants</label></div>
                          <div class="col text-end" style="display:flex;">
                            <button onclick="createPG()" class="buttonadd success-button icon-button" style="margin-left:auto;" type="button" id="paraddg"><i class='bx bxs-group'></i></button>
                            <button onclick="deleteCheckedPG()" class="buttonadd delete-button icon-button" style="margin-left: 5px;" type="button">
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
                                  <table class="#" style="text-align:center; margin-left:40px; margin-top:1px; color:var(--color-content-text);" id="Ptable">
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
                                      $sql = "SELECT * FROM participants";
                                      $result = $conn -> query($sql);

                                      if (!$conn) {
                                        die("Connection Failed: " . mysqli_connect_error());
                                    }

                                    while($row = $result -> fetch_assoc()) {
                                      $prtId = $row['participants_id'];
                                      $prtName = $row['participant_name'];
                                      $prtSection = $row['participant_section'];
                                      $prtOrganization = $row['organization_id'];

                                      echo "<tr class='editable-row' data-id='" . $row['participants_id'] . "'>
                      <td>
                        <input type='checkbox' class='checkbox'>
                      </td>
                      <td><input type='text' class='editable cformpi' value='$prtName' readonly ondblclick='makeEditable(this)' onkeydown='handleKeyDown(event)'></td>
                      <td><input type='text' class='editable cformpi' value='$prtSection' readonly ondblclick='makeEditable(this)' onkeydown='handleKeyDown(event)'></td>
                      <td><input type='text' class='editable cformpi' value='$prtOrganization' readonly ondblclick='makeEditable(this)' onkeydown='handleKeyDown(event)'></td>
                    </tr>";
                                    }
                                    
                                      
                                      ?>
                                      
                                      
                                  <form action="#" method="POST" id="add_form3">
                                    <ul >
                                      
                                    </ul>
                                    </tbody>
                                    </table>
                                  </div>
                                  
                                  </form>
                                  </div>
                                  <div class="col group hide" style="width:auto;">
                                  <div>
 <table class="table" style=" color:var(--color-content-text);">
    <thead>
      <tr>
        
    </tbody>
  </table>
  <!-- Participants grouped -->
                                  <form action="#" method="POST">
                                      <div id="Pboxg">
                                      
                                    </div>

                                    </form>
                                  </div>
                                    <br>

                            </div>
                            
                        </div>
                        
                </div>
            </div>
        </div>
    </div>
    <div class="row">
  <form action="php/P&J-admin-action.php" method="POST" id="submitAll">
    <div class="col text-end" style="margin-top: 10px;margin-bottom: 10px;margin-right: 16px;">
      <button class="success-button buttonsubmit" type="submit" style="float:right; margin-bottom:10px;" value="Add" id="save_btnS" onclick="showSubmit()" disabled>Submit</button>
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
    <script src="./js/jquery-3.6.4.js"></script>
    <script src="./js/HOM-popup.js"></script>
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

function toggleAllCheckboxes() {
            var checkboxes = document.getElementsByClassName('checkbox');
            var selectAllCheckbox = document.getElementById('select-all');
            
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = selectAllCheckbox.checked;
            }
            enableSubmitButton();
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
            enableSubmitButton();
        }

function toggleAllCheckboxesP() {
            var checkboxesP = document.getElementsByClassName('checkboxP');
            var selectAllCheckbox = document.getElementById('select-allP');
            
            for (var i = 0; i < checkboxesP.length; i++) {
                checkboxesP[i].checked = selectAllCheckbox.checked;
            }
            enableSubmitButton();
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
            enableSubmitButton();
        }

function updateLabel(dropdown) {
      var dropdownId = dropdown.id;
      var label = document.querySelector('label[for="' + dropdownId + '"]');
      label.textContent = dropdown.value;
    }

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

popupl = document.getElementById('popuplink');
var showl = function(){
    popupl.style.display = 'flex';
}
var hidel = function(){
    popupl.style.display = 'none';
}

clearPopupl = document.getElementById('clear-popup');
var show_clearl = function(){
    clearPopupl.style.display = 'flex';
}
var hide_clearl = function(){
    clearPopupl.style.display = 'none';
}

discardChangesPopupl = document.getElementById('discardChanges-popup');
var show_discardChangesl = function(){
    discardChangesPopupl.style.display = 'flex';
}
var hide_discardChangesl = function(){
    discardChangesPopupl.style.display = 'none';
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
    nicknameInput.pattern = "[A-Za-z0-9 -]{4,10}";
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
      generateLinkButton.onclick = showl;
      generateLinkButton.style = "border-radius:15px;min-width: 160px; height: 40px; color: white;background: #73A9CC;";
      generateLinkButton.innerHTML = "<i class='bx bx-link'></i> Generate Link";
    buttonCell.appendChild(generateLinkButton);

    checkBox.onclick = function () {
      enableSubmitButton();
    };

    nameInput.onkeydown = function (event) {
      if (event.key === "Enter") {
        event.preventDefault();
        this.readOnly = true;
        enableSubmitButton();
      }
    };

    nicknameInput.onkeydown = function (event) {
      if (event.key === "Enter") {
        event.preventDefault();
        this.readOnly = true;
        enableSubmitButton();
      }
    };

    enableSubmitButton();
  }

  function enableSubmitButton() {
    var submitButton = document.getElementById("save_btnS");
    var inputs = document.getElementsByClassName("cformj");
    var allFilled = true;
    for (var i = 0; i < inputs.length; i++) {
      if (inputs[i].type === "text" && inputs[i].value === "") {
        allFilled = false;
        break;
      }
    }
    submitButton.disabled = !allFilled;
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
      parNameInput.pattern = "[A-Za-z0-9 -]{4,20}";
      parNameInput.minLength = 4;
      parNameInput.maxLength = 20;
      parNameInput.placeholder = "Participant Name";
      parNameInput.title = "Enter a valid name (4-20 characters)";
      parNameInput.addEventListener("dblclick", function() {
        toggleEdit(this);
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
      sectionInputP.pattern = "[1-9\\-]+";
      sectionInputP.placeholder = "Section";
      sectionInputP.addEventListener("dblclick", function() {
        toggleEdit(this);
      });
      sectionCellP.appendChild(sectionInputP);

      // Organization dropdown
      var orgCellP = row.insertCell(3);
      var orgSelectP = document.createElement("select");
      orgSelectP.name = "organization_id[]";
      orgSelectP.style = "border-radius:20px; background-color:white;";
      orgSelectP.className = "btn dropdown-toggle";
      orgCellP.appendChild(orgSelectP);

      var defaultOptionP = document.createElement("option");
      defaultOptionP.disabled = true;
      defaultOptionP.selected = true;
      defaultOptionP.innerHTML = "Organization";
      orgSelectP.appendChild(defaultOptionP);

      var eliteOptionP = document.createElement("option");
      eliteOptionP.value = "ELITE";
      eliteOptionP.innerHTML = "ELITE";
      orgSelectP.appendChild(eliteOptionP);

      var jpiOptionP = document.createElement("option");
      jpiOptionP.value = "JPIA";
      jpiOptionP.innerHTML = "JPIA";
      orgSelectP.appendChild(jpiOptionP);

      checkboxP.onclick = function () {
      enableSubmitButton();
    };

    parNameInput.onkeydown = function (event) {
      if (event.key === "Enter") {
        event.preventDefault();
        this.readOnly = true;
        enableSubmitButton();
      }
    };

    sectionInputP.onkeydown = function (event) {
      if (event.key === "Enter") {
        event.preventDefault();
        this.readOnly = true;
        enableSubmitButton();
      }
    };

    enableSubmitButton();

    }

  function add_par(){
    intParTextBox++;
    var objNewPDiv = document.createElement('div');
    objNewPDiv.setAttribute('id', 'div_' + intParTextBox);
    objNewPDiv.innerHTML = `<div class='row'><li style='list-style-type: none;'><br>
                                          <input type='text' class='inputpname cformpi' name='participants_name_temp[]' style='border-radius:20px;' placeholder='Participants Name' minlength="4" maxlength="20" Required pattern="[a-zA-Z1-9\- ]*"/>
                                          <input type='text' class='inputpcs cformpi' name='participants_course_temp[]' style='border-radius:20px;' placeholder='Course' minlength="4" maxlength="5" Required pattern="[a-zA-Z ]*"/>
                                          <input type='text' class='inputpcs cformpi' name='participants_section_temp[]' style='border-radius:20px;width:110px;' placeholder='Section' minlength="3" maxlength="3" Required pattern="[\d-]*"/>
                                          <select class='btn dropdown-toggle' name='participants_organization_temp[]' aria-expanded='false' data-bs-toggle='dropdown' type='button' style='border-radius: 20px;width: 180.031px;margin-left: 8px;background: var(--bs-light);color: var(--bs-body-color);'>
                                            <option disabled selected>Organization</option>
                                            <option>ELITE</option>
                                            <option>JPIA</option>
                                          </select>
                                          <button class='delete-button icon-button delP btndel' id='deleteP' style="float:right;"><i class='bx bxs-trash-alt' ></i></button><br/>
                                      </li></div>`;
    document.getElementById('Pbox').appendChild(objNewPDiv);  
    var submitButtonpi = document.getElementById("save_btnPI");
    submitButtonpi.disabled = true;
    var cancelButtonpi = document.getElementById("can_btnPI");
    cancelButtonpi.disabled = true;
  }


// Get the form and submit button element
const formpg = document.getElementById('add_form4');
const submitButtonpg = document.getElementById('save_btnPG');
const cancelButtonpg = document.getElementById('can_btnPG');


// Add event listener to the "Add Input" button
document.getElementById('paraddg').addEventListener('click', paraddg);

let dropdownCount = 0;

    function createPG() {
      dropdownCount++;

      const container = document.getElementById('Pboxg');

      // Create dropdown menu
      const dropdown = document.createElement('select');
      dropdown.className = "btn dropdown-toggle div-toggle";
      dropdown.style = "border-radius: 20px;width: 180.031px;margin-left: 50px;background: var(--bs-light);color: var(--bs-body-color);";
      dropdown.innerHTML = `
        <option value="option1">Option 1</option>
        <option value="option2">Option 2</option>
        <option value="option3">Option 3</option>
        <option value="option4">Option 4</option>
        <option value="option5">Option 5</option>
      `;

      // Create checkbox to select all in the row
      const selectAllCheckbox = document.createElement('input');
      selectAllCheckbox.type = 'checkbox';
      selectAllCheckbox.addEventListener('change', function () {
        const rowCheckboxes = container.querySelectorAll('.row input[type="checkbox"]');
        rowCheckboxes.forEach(function (checkbox) {
          checkbox.checked = this.checked;
        }, this);
      });

      // Create button to toggle row visibility
      const toggleButton = document.createElement('button');
      toggleButton.type = 'button';
      toggleButton.className = "buttonadd success-button icon-button";
      toggleButton.innerHTML = "<i class='bx bxs-user-plus'></i>";
      toggleButton.style = "display:inline-block";
      toggleButton.addEventListener('click', () => {
        const rows = container.querySelectorAll('.row');
        rows.forEach((row) => {
          row.classList.toggle('hide');
        });
      });

      container.appendChild(dropdown);
      container.appendChild(selectAllCheckbox);
      container.appendChild(toggleButton);

      // Create button to add new row
      const addRowButton = document.createElement('button');
      addRowButton.type = 'button';
      addRowButton.className = "buttonadd success-button icon-button";
      addRowButton.innerHTML = "<i class='bx bxs-user-plus'></i>";
      addRowButton.style = "display:inline-block";
      addRowButton.addEventListener('click', () => {
        const row = createMembers();
        container.appendChild(row);
      });

      const row = createMembers();
      container.appendChild(addRowButton);
    }

    function createMembers() {
  // Create container element for the row
  const container = document.createElement('div');

  // Create checkbox
  const checkbox = document.createElement('input');
  checkbox.type = 'checkbox';

  // Create text inputs for name and section
  const nameInput = document.createElement('input');
  nameInput.type = 'text';
  nameInput.className = "inputpcs";
  nameInput.placeholder = 'Name';

  const sectionInputPG = document.createElement('input');
  sectionInputPG.type = "text";
  sectionInputPG.className = "inputpcs cformj";
  sectionInputPG.name = "participant_section[]";
  sectionInputPG.style = "border-radius:20px;";
  sectionInputPG.minLength = 3;
  sectionInputPG.maxLength = 3;
  sectionInputPG.pattern = "[1-9\\-]+";
  sectionInputPG.placeholder = "Section";
  sectionInputPG.addEventListener("dblclick", function() {
        toggleEdit(this);
      });

  // Append checkbox, name input, and section input to the container
  container.appendChild(checkbox);
  container.appendChild(nameInput);
  container.appendChild(sectionInputPG);

  return container;
}

    function deleteCheckedPG() {
      const checkboxes = document.querySelectorAll('.row input[type="checkbox"]:checked');
      checkboxes.forEach(function (checkbox) {
        const row = checkbox.parentNode;
        row.parentNode.removeChild(row);
      });
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

            // ajax request
            $("#add_form2").submit(function(e){
                e.preventDefault();
                $("#save_btnJ").val('Adding...');
                $.ajax({
                    url:'php/P&J-admin-action-temp.php',
                    method:'POST',
                    data: $(this).serialize(),
                    success:function(response){
                        console.log(response);
                        $("#save_btnJ").val('Add');
                        $(".append_judges").remove();
    intJudgeTextBox++;
    var objNewJDiv = document.createElement('ul');
    objNewJDiv.setAttribute('id', 'ul_' + intJudgeTextBox);
    objNewJDiv.innerHTML = `
    <li style='list-style-type: none;'>
                                        <br><tr>
                                          <td><input type='text' class='inputjname cformj' name='judge_name_temp[]' style='border-radius:20px;' placeholder='Judge Name' minlength="4" maxlength="20" Required pattern="[a-zA-Z1-9\- ]*"/></td>
                                          <td><input type='text' class='inputjnick cformj' name='judge_nick_temp[]' style='border-radius:20px;' placeholder='Nickname' minlength="4" maxlength="10" Required/></td>
                                          <td><button onClick='showl()' class='buttonlink1' type='button' style='border-radius:15px;width: 160px; height: 40px; color: white;background: #73A9CC;'><i class='bx bx-link'></i>Generate Link</button></td>
                                          <td><button class='delete-button icon-button delJ btndel' id='deleteJB' style="float:right;"><i class='bx bxs-trash-alt' ></i></button></td>
                                          </tr>
                                          <br>
                                        </li>`;
    document.getElementById('Jbox').appendChild(objNewJDiv); 
                    }
                })
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
<script>
    function openPopup() {
  var popup = document.getElementById("popuplink");
  popup.style.display = "block";
}

function closePopup() {
  var popup = document.getElementById("popuplink");
  popup.style.display = "none";
}
</script>
  </body>

</html>