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
                <button class="success-button" id="submitPopup" name="save_btnS"><i class='bx bx-check'></i>Confirm</button>
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
    <input type="text" value="Https//:SampleLink" readonly><a href='P&J-admin-scoretab.php' target="_blank" style="position:relative;top:0; right:0;">
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
                    <form action="#" method="POST" id="add_form2">
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
                                     <tbody id="Jbox">
                                      <?php
                                      $sql = "SELECT * FROM pjjudgestemp";
                                      $result = $conn -> query($sql);

                                      if (!$conn) {
                                        die("Connection Failed: " . mysqli_connect_error());
                                    }

                                    while($row = $result -> fetch_assoc()) {

                                      echo"
                                      <tr>
                                      <td>
                                          <input type='checkbox' class='checkbox'>
                                      </td>
                                      <td><span class='editable' onclick='editEntry(this)'>" . $row["judge_name_temp"] . "</span></td>
                                      <td><span class='editable' onclick='editEntry(this)'>" . $row["judge_nick_temp"] . "</span></td>
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
                                
                                </form>
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
                          <div class="col text-end" style="margin-right: 18px;">
                            <button onClick="add_parg();" class="buttonadd success-button icon-button" style="margin-left:auto;" type="button" id="paraddg"><i class='bx bxs-group'></i></button>
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
                                  <th class="bordertable"><h6  class='judgeheader'>Course</h6></th>
                                  <th class="bordertable"><h6  class='judgeheader'>Section</h6></th>
                                  <th class="bordertable"><h6  class='judgeheader'>Organization</h6></th>
                                  </tr>
                                  </thread>
                                  <tbody id="Pbox">
                                      <?php
                                      $sql = "SELECT * FROM pjparticipantstemp";
                                      $result = $conn -> query($sql);

                                      if (!$conn) {
                                        die("Connection Failed: " . mysqli_connect_error());
                                    }

                                    while($row = $result -> fetch_assoc()) {

                                      echo"
                                      <tr>
                                      <td>
                                          <input type='checkbox' class='checkboxP'>
                                      </td>
                                      <td>" . $row["participants_name_temp"] . "</td>
                                      <td>" . $row["participants_course_temp"] . "</td>
                                      <td>" . $row["participants_section_temp"] . "</td>
                                      <td>" . $row["participants_organization_temp"] . "</td>
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
        <?php
                                      $sql = "SELECT * FROM pjparticipantsgrouptemp";
                                      $result = $conn -> query($sql);

                                      if (!$conn) {
                                        die("Connection Failed: " . mysqli_connect_error());
                                    }

                                    while($row = $result -> fetch_assoc()) {
       echo" <th style='color:var(--color-content-text);'>Group Name</th>
       <th style='color:var(--color-content-text);'>" . $row["participants_organization_group_temp"] . " <a class='btn btn-primary btn-sm' style='margin-left:30px;'>Edit</a></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>" . $row["participants_name_group_temp"] . "</td>
        <td>
          <table>
            <thead>
              <tr>
                <th style='color:var(--color-content-text);'>Member Name</th>
                <th style='color:var(--color-content-text);'>Course</th>
                <th style='color:var(--color-content-text);'>Section</th>
              </tr>
            </thead>";
            $sql = "SELECT * FROM pjparticipantsgroupmemberstemp";
                                      $result = $conn -> query($sql);

                                      if (!$conn) {
                                        die("Connection Failed: " . mysqli_connect_error());
                                    }

                                    while($row = $result -> fetch_assoc()) {
            echo"<tbody>
              <tr>
                <td>" . $row["participants_name_g_temp"] . "</td>
                <td>" . $row["participants_course_group_temp"] . "</td>
                <td>" . $row["participants_section_group_temp"] . "</td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>";
    }
  }
                                    
                                      
    ?>
    </tbody>
  </table>
                                  <form action="#" method="POST" id="add_form4">
                                    <ul id="Pboxg">
                                      <div class="Pargdel">
                                      <button class='delete-button icon-button delPGD btndel' id='deleteP' type="button" style="float:right;"><i class='bx bxs-trash-alt' ></i></button>
                                    <li style='list-style-type: none;'>
                                    <table  style="margin-left:30px;">
                                  <th><h6 style="margin-left:20px; font-weight:1000; color:var(--color-content-text);">Group Name</h6></th>
                                  <th><h6 style="color: white; margin-left:120px; font-weight:1000; color:var(--color-content-text);">Organization</h6></th>
                                  </table>
<!-- Participants Form Group -->
                                    <input type='text' class='inputpname cformpg' style='border-radius:20px;' name="participants_name_group_temp[]" placeholder='Group Name' style="margin-left:30px;width: 180px; height: 40px;" minlength="4" maxlength="10" Required pattern="[a-zA-Z1-9\- ]*"/>
                                    <div class="dropdown" style="display:inline;">
                                    <select class='btn dropdown-toggle' name='participants_organization_group_temp[]' aria-expanded='false' data-bs-toggle='dropdown' type='button' style='border-radius: 20px;width: 180.031px;margin-left: 8px;background: var(--bs-light);color: var(--bs-body-color);'>
                                            <option disabled selected>Organization</option>
                                            <option>ELITE</option>
                                            <option>JPIA</option>
                                          </select>
                                          
                                  </div>
                                  <div class="col" style="margin-top: 21px;">
                                  <div class="col">
                                    <table>
                                  <th><h6 style="color: white; font-weight:1000; color:var(--color-content-text);">Members</h6></th>
                                  </table>
                                  </div>
                                  </li>
                                      <li style='list-style-type: none;'>
                                      <input type='text' class='inputpname subform cformpg' name="participants_name_g_temp[]" style='border-radius:20px;' placeholder='Participants Name' minlength="4" maxlength="20" Required pattern="[a-zA-Z1-9\- ]*"/>
                                          <input type='text' class='inputpcs cformpg' name="participants_course_group_temp[]" style='border-radius:20px;' placeholder='Course' minlength="4" maxlength="5" Required pattern="[a-zA-Z ]*"/>
                                          <input type='text' class='inputpcs cformpg' name="participants_section_group_temp[]" style='border-radius:20px;width:110px;' placeholder='Section' minlength="3" maxlength="3"  Required pattern="[\d-]*"/>
                                          <label class="orgChanged" style="margin-left:40px; margin-right: 70px;color:white;font-weight:1000; color:var(--color-content-text);"></label>
                                          <button class='delete-button icon-button delPG btndel' id='deleteP' type="button" style="float:right;"><i class='bx bxs-trash-alt' ></i></button>
                                          <br/>
                                      </li>
                                      <div class="subformContainer">

                                    </div>
                                    <button onclick="addSubform(this)" class="buttonadd success-button icon-button" style="float:right; margin-top:0px;" type="button"><i class='bx bxs-user-plus'></i></button>
                                    <br>
                                    <hr>
                                    </div>
                                    </div>

                                    
                                    </ul>
                                    <div class="col text-end" style="margin-top:30px;">
                                    <button class="primary-button" type="submit" value="Add" id="save_btnPG" style="display:inline;" disabled>Save</button>
                                  <button onClick="showpg()" class="secondary-button" type="button" id="can_btnPG"  style="display:inline;" disabled>Cancel</button>
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
                            <button class="success-button buttonsubmit" type="submit" style="float:right; margin-bottom:10px;"  value="Add" name="save_btnS" id="save_btnS"onclick="showSubmit()" disabled>Submit</button>
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

function toggleAllCheckboxes() {
            var checkboxes = document.getElementsByClassName('checkbox');
            var selectAllCheckbox = document.getElementById('select-all');
            
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = selectAllCheckbox.checked;
            }
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

// Confirm
const formSubmit = document.getElementById('submitAll');
const popupSubmit = document.getElementById('submitWrapper');
const okButton = document.getElementById('submitPopup');

formSubmit.addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent the form from submitting directly
  
});

var showSubmit = function() {
      popupSubmit.style.display ='flex';
  }
  var hideSubmit = function() {
      popupSubmit.style.display ='none';
  }

// Add event listener to handle form submission on OK button click
okButton.addEventListener('click', function() {
  //formSubmit.submit(); // Submit the form
});
  


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
// Get the form and submit button element
const form = document.getElementById('add_form2');
const submitButton = document.getElementById('save_btnJ');
const cancelButton = document.getElementById('can_btnJ');

// Add event listener to the form for input change
form.addEventListener('input', validateForm);

// Add event listener to the "Add Input" button
document.getElementById('judgeadd').addEventListener('click', judgeadd);

// Validate the form inputs
function validateForm() {
  // Get all dynamic input elements
  const dynamicInputs = document.getElementsByClassName('cformj');
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

}
function toggleEdit(element) {
      element.readOnly = !element.readOnly;
      element.classList.toggle("editable");
    }

var intParTextBox = 0;
var intJudgeTextBox = 0;
var activeInput = null;

function editEntry(span) {
      if (activeInput) {
        activeInput.parentNode.innerHTML = activeInput.value;
        activeInput = null;
      }
      
      var input = document.createElement("input");
      input.type = "text";
      input.value = span.innerText;
      
      activeInput = input;
      
      span.innerHTML = "";
      span.appendChild(input);
      
      input.focus();
      input.addEventListener("keypress", function(event) {
        if (event.keyCode === 13) {
          event.preventDefault();
          span.innerHTML = input.value;
          activeInput = null;
        }
      });
      
      input.addEventListener("blur", function() {
        span.innerHTML = input.value;
        activeInput = null;
      });
    }

function addRow() {
      var table = document.getElementById("Jtable");
      var row = table.insertRow(-1);

      // Create checkbox
      var checkCell = row.insertCell(0);
      var checkbox = document.createElement("input");
      checkbox.type = "checkbox";
      checkbox.className = "checkbox";
      checkCell.appendChild(checkbox);
      
      // Create judge name input
      var nameCell = row.insertCell(1);
      var judgeNameInput = document.createElement("input");
      judgeNameInput.type = "text";
      judgeNameInput.className = "inputjname cformj";
      judgeNameInput.name = "judge_name_temp[]";
      judgeNameInput.style = "border-radius:20px;";
      judgeNameInput.pattern = "[A-Za-z0-9 -]{4,20}";
      judgeNameInput.placeholder = "Judge Name";
      judgeNameInput.title = "Enter a valid name (4-20 characters)";
      judgeNameInput.addEventListener("dblclick", function() {
        toggleEdit(this);
      });
      nameCell.appendChild(judgeNameInput);
      
      // Create judge nickname input
      var nicknameCell = row.insertCell(2);
      var judgeNickInput = document.createElement("input");
      judgeNickInput.type = "text";
      judgeNickInput.className = "inputjnick cformj";
      judgeNickInput.name = "judge_nick_temp[]";
      judgeNickInput.style = "border-radius:20px;";
      judgeNickInput.pattern = "[A-Za-z0-9 -]{4,20}";
      judgeNickInput.placeholder = "Nickname";
      judgeNickInput.title = "Enter a valid nickname (4-20 characters)";
      judgeNickInput.addEventListener("dblclick", function() {
        toggleEdit(this);
      });
      nicknameCell.appendChild(judgeNickInput);

      // Create generate link button
      var buttonCell = row.insertCell(3);
      var generateLinkButton = document.createElement("button");
      generateLinkButton.type = "button";
      generateLinkButton.className = "buttonlink1";
      generateLinkButton.onclick = showl;
      generateLinkButton.style = "border-radius:15px;min-width: 160px; height: 40px; color: white;background: #73A9CC;";
      generateLinkButton.innerHTML = "<i class='bx bx-link'></i> Generate Link";
      buttonCell.appendChild(generateLinkButton);

    }


// Get the form and submit button element
const formpi = document.getElementById('add_form3');
const submitButtonpi = document.getElementById('save_btnPI');
const cancelButtonpi = document.getElementById('can_btnPI');

// Add event listener to the form for input change
formpi.addEventListener('input', validateFormpi);

// Add event listener to the "Add Input" button
document.getElementById('paraddi').addEventListener('click', paraddi);

// Validate the form inputs
function validateFormpi() {
  // Get all dynamic input elements
  const dynamicInputspi = document.getElementsByClassName('cformpi');
  let hasInvalidInputpi = false;

  // Loop through each dynamic input
  for (let i = 0; i < dynamicInputspi.length; i++) {
    const input = dynamicInputspi[i];
    if (input.value.trim() === '') {
      hasInvalidInputpi = true;
      break;
    }
    // Add your specific input validation logic here
    // For example, check if the input follows a certain pattern or meets specific criteria
    // If the input is invalid, set hasInvalidInput to true and break the loop
  }

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
      parNameInput.className = "inputpname cformpi";
      parNameInput.name = "participants_name_temp[]";
      parNameInput.style = "border-radius:20px;";
      parNameInput.pattern = "[A-Za-z0-9 -]{4,20}";
      parNameInput.placeholder = "Participant Name";
      parNameInput.title = "Enter a valid name (4-20 characters)";
      parNameInput.addEventListener("dblclick", function() {
        toggleEdit(this);
      });
      nameCellP.appendChild(parNameInput);

      var courseCellP = row.insertCell(2);
      var courseInputP = document.createElement("input");
      courseInputP.type = "text";
      courseInputP.className = "inputpcs cformpi";
      courseInputP.name = "participants_course_temp[]";
      courseInputP.style = "border-radius:20px;";
      courseInputP.minLength = 4;
      courseInputP.maxLength = 5;
      courseInputP.pattern = "[A-Za-z]+";
      courseInputP.placeholder = "Course";
      courseInputP.addEventListener("dblclick", function() {
        toggleEdit(this);
      });
      courseCellP.appendChild(courseInputP);

      var sectionCellP = row.insertCell(3);
      var sectionInputP = document.createElement("input");
      sectionInputP.type = "text";
      sectionInputP.className = "inputpcs cformpi";
      sectionInputP.name = "participants_section_temp[]";
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
      var orgCellP = row.insertCell(4);
      var orgSelectP = document.createElement("select");
      orgSelectP.name = "participants_organization_temp[]";
      orgSelectP.style = "border-radius:20px;";
      orgSelectP.className = "btn dropdown-toggle";
      sectionInputP.addEventListener("keypress", function() {
        toggleEdit(this);
      });
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
    validateFormpi()
  }

  $(document).ready(function() {
  // Add event listener to the parent element for delete buttons
  $('#Pboxg').on('click', '.delPGD', function() {
    // Find the parent textbox and remove it
    $(this).closest('.Pargdel').remove();
    intJudgeTextBox--;
    validateFormpg();
  });
});

// Get the form and submit button element
const formpg = document.getElementById('add_form4');
const submitButtonpg = document.getElementById('save_btnPG');
const cancelButtonpg = document.getElementById('can_btnPG');

// Add event listener to the form for input change
formpg.addEventListener('input', validateFormpg);

// Add event listener to the "Add Input" button
document.getElementById('paraddg').addEventListener('click', paraddg);

// Validate the form inputs
function validateFormpg() {
  const dynamicInputspg = document.getElementsByClassName('cformpg');
  const textBoxes = document.getElementsByClassName('subform');
  let hasInvalidInputpg = false;

  for (let i = 0; i < dynamicInputspg.length; i++) {
    const input = dynamicInputspg[i];
    if (input.value.trim() === '' || textBoxes.length === 0) {
      hasInvalidInputpg = true;
      break;
    }
    // Add your specific input validation logic here
    // For example, check if the input follows a certain pattern or meets specific criteria
    // If the input is invalid, set hasInvalidInputpg to true and break the loop
  }

  // Disable or enable the submit and cancel buttons based on the input validity
  submitButtonpg.disabled = hasInvalidInputpg || dynamicInputspg.length === 0;
  cancelButtonpg.disabled = hasInvalidInputpg || dynamicInputspg.length === 0;
}

// Function to add a new group textbox
function add_parg() {
  intParTextBox++;
  var objNewPDivg = document.createElement('div');
  objNewPDivg.setAttribute('id', 'div_' + intParTextBox);
  objNewPDivg.innerHTML = `
  <div class="Pargdel">
  <button class='delete-button icon-button delPGD btndel' id='deleteP' type="button" style="float:right;"><i class='bx bxs-trash-alt' ></i></button>
                                    <li style='list-style-type: none;'>
                                    <table  style="margin-left:30px;">
                                  <th><h6 style="margin-left:20px; font-weight:1000; color:var(--color-content-text);">Group Name</h6></th>
                                  <th><h6 style="color: white; margin-left:120px; font-weight:1000; color:var(--color-content-text);">Organization</h6></th>
                                  </table>
<!-- Participants Form Group -->
                                    <input type='text' class='inputpname cformpg' style='border-radius:20px;' name="participants_name_group_temp[]" placeholder='Group Name' style="margin-left:30px;width: 180px; height: 40px;" minlength="4" maxlength="10" Required pattern="[a-zA-Z1-9\- ]*"/>
                                    <div class="dropdown" style="display:inline;">
                                    <select class='btn dropdown-toggle' name='participants_organization_group_temp[]' aria-expanded='false' data-bs-toggle='dropdown' type='button' style='border-radius: 20px;width: 180.031px;margin-left: 8px;background: var(--bs-light);color: var(--bs-body-color);'>
                                            <option disabled selected>Organization</option>
                                            <option>ELITE</option>
                                            <option>JPIA</option>
                                          </select>
                                          
                                  </div>
                                  <div class="col" style="margin-top: 21px;">
                                  <div class="col">
                                    <table>
                                  <th><h6 style="color: white; font-weight:1000; color:var(--color-content-text);">Members</h6></th>
                                  </table>
                                  </div>
                                  </li>
                                      <li style='list-style-type: none;'>
                                      <input type='text' class='inputpname subform cformpg' name="participants_name_g_temp[]" style='border-radius:20px;' placeholder='Participants Name' minlength="4" maxlength="20" Required pattern="[a-zA-Z1-9\- ]*"/>
                                          <input type='text' class='inputpcs cformpg' name="participants_course_group_temp[]" style='border-radius:20px;' placeholder='Course' minlength="4" maxlength="5" Required pattern="[a-zA-Z ]*"/>
                                          <input type='text' class='inputpcs cformpg' name="participants_section_group_temp[]" style='border-radius:20px;width:110px;' placeholder='Section' minlength="3" maxlength="3"  Required pattern="[\d-]*" />
                                          <label class="orgChanged" style="margin-left:40px; margin-right: 70px;color:white;font-weight:1000; color:var(--color-content-text);"></label>
                                          <button class='delete-button icon-button delP btndel' id='deleteP' style="float:right;"><i class='bx bxs-trash-alt' ></i></button><br/>
                                      </li>
                                      <div class="subformContainer">

                                    </div>
                                    <button onclick="addSubform(this)" class="buttonadd success-button icon-button" style="float:right; margin-top:0px;" type="button"><i class='bx bxs-user-plus'></i></button><br>
                                    <hr>
                                    </div>
                                    </div>`;

  document.getElementById('Pboxg').appendChild(objNewPDivg);

  // Add event listener to the new group textbox for input change
  objNewPDivg.querySelector('.cformpg').addEventListener('input', validateFormpg);

  // Disable the submit and cancel buttons for the new textbox
  submitButtonpg.disabled = true;
  cancelButtonpg.disabled = true;
}

  function addSubform(button) {
  var subgroup = button.parentNode;
  var subformContainer = subgroup.querySelector(".subformContainer");

  var objNewPDivg = document.createElement('ul');
    objNewPDivg.setAttribute('id', 'ul_' + intParTextBox);
    objNewPDivg.innerHTML = `<li style='list-style-type: none;'>
                                      <input type='text' class='inputpname subform cformpg' name="participants_name_g_temp[]" style='border-radius:20px;' placeholder='Participants Name' minlength="4" maxlength="20" Required pattern="[a-zA-Z1-9\- ]*"/>
                                          <input type='text' class='inputpcs cformpg' name="participants_course_group_temp[]" style='border-radius:20px;' placeholder='Course' minlength="4" maxlength="5" Required pattern="[a-zA-Z ]*"/>
                                          <input type='text' class='inputpcs cformpg' name="participants_section_group_temp[]" style='border-radius:20px;width:110px;' placeholder='Section' minlength="3" maxlength="3" Required pattern="[\d-]*"/>
                                          <label class="orgChanged" style="margin-left:40px; margin-right: 70px;color:white;font-weight:1000; color:var(--color-content-text);"></label>
                                          <button class='delete-button icon-button delP btndel' id='deleteP' style="float:right;"><i class='bx bxs-trash-alt' ></i></button><br/>
                                      </li>`;

  subformContainer.appendChild(objNewPDivg);
  var submitButtonpg = document.getElementById("save_btnPG");
    submitButtonpg.disabled = true;
    var cancelButtonpg = document.getElementById("can_btnPG");
    cancelButtonpg.disabled = true;
}

$("ul").on("click", ".delP" , function(a) {
    a.preventDefault();
    $(this).parent().remove();
    intParTextBox--;
    var submitButtonpi = document.getElementById("save_btnPI");
    submitButtonpi.disabled = true;
    var cancelButtonpi = document.getElementById("can_btnPI");
    cancelButtonpi.disabled = true;
    validateFormpi()
});

  $("ul").on("click", ".delPG" , function(a) {
    a.preventDefault();
    $(this).parent().remove();
    intParTextBox--;
    var submitButtonpg = document.getElementById("save_btnPG");
    submitButtonpg.disabled = true;
    var cancelButtonpg = document.getElementById("can_btnPG");
    cancelButtonpg.disabled = true;
    validateFormpg()
});

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
    validateForm()
                    }
                })
            });

            // ajax request
            $("#add_form3").submit(function(e){
                e.preventDefault();
                $("#save_btnPI").val('Adding...');
                $.ajax({
                    url:'php/P&J-admin-action-temp-PI.php',
                    method:'POST',
                    data: $(this).serialize(),
                    success:function(response){
                        console.log(response);
                        $("#save_btnPI").val('Add');
                        $("#add_form3")[0].reset();
                        $(".append_par").remove();
                        validateFormpi()
                    }
                })
            });
            // ajax request
            $("#add_form4").submit(function(e){
                e.preventDefault();
                $("#save_btnPG").val('Adding...');
                $.ajax({
                    url:'php/P&J-admin-action-temp-PG.php',
                    method:'POST',
                    data: $(this).serialize(),
                    success:function(response){
                        console.log(response);
                        $("#save_btnPG").val('Add');
                        $("#add_form4")[0].reset();
                        $(".append_parg").remove();
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