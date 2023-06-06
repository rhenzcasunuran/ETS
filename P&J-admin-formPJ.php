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
    </style>
    
    

  </head>
  <body>
  <div class="sidebar open box-shadow">
      <div class="bottom-design">
        <div class="design1"></div>
        <div class="design2"></div>
      </div>
      <div class="logo_details">
        <img src="./pictures/logo.png" alt="student council logo" class="icon logo">
        <div class="logo_name">Events Tabulation System</div>
        <i class="bx bx-arrow-to-right" id="btn"></i>
        <script src="./js/sidebar-state.js"></script>
      </div>
      <div class="wrapper">
        <li class="nav-item top">
          <a href="index.php">
            <i class="bx bx-home-alt"></i>
            <span class="link_name">Go Back</span>
          </a>
        </li>
        <div class="sidebar-content-container">
          <ul class="nav-list">
            <li class="nav-item">
              <a href="#posts" class="menu_btn">
                <i class="bx bx-news"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Posts
                  <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
              </a>
              <ul class="sub_list">
                <li class="sub-item">
                  <a href="HOM-create-post.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Create Post</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="HOM-draft-scheduled-post.php">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Draft & Scheduled Post</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="HOM-manage-post.php">
                    <i class="bx bxs-circle sub-icon color-yellow"></i>
                    <span class="sub_link_name">Manage Post</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#event_menu" class="menu_btn">
                <i class="bx bx-calendar-edit"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Events
                  <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
              </a>
              <ul class="sub_list">
                <li class="sub-item">
                  <a href="EVE-admin-list-of-events.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">List of Events</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="EVE-admin-event-configuration.php">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Event Configuration</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="#criteria_config">
                    <i class="bx bxs-circle sub-icon color-yellow"></i>
                    <span class="sub_link_name">Criteria Configuration</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="menu_btn">
                <i class="bx bx-calendar"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Calendar
                  <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
              </a>
              <ul class="sub_list">
                <li class="sub-item">
                  <a href="CAL-admin-overall.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Overview</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="CAL-admin-logs.php">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Logs</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="BAR-admin.php">
                <i class='bx bx-bar-chart-alt-2'></i>
                <span class="link_name">Overall Results</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#tournaments" class="menu_btn">
                <i class="bx bx-trophy"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Tournaments
                  <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
              </a>
              <ul class="sub_list">
                <li class="sub-item">
                  <a href="TOU-Live-Scoring-Admin.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Live Scoring</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="TOU-bracket-admin.php">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Manage Brackets</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#competition" class="menu_btn">
                <i class="bx bx-medal"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Competition
                  <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
              </a>
              <ul class="sub_list">
                <li class="sub-item">
                  <a href="COM-manage_results_page.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Manage Results</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="COM-tobepublished_page.php">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">To Publish</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="COM-published_page.php">
                    <i class="bx bxs-circle sub-icon color-yellow"></i>
                    <span class="sub_link_name">Published Results</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="#archive">
                    <i class="bx bxs-circle sub-icon color-purple"></i>
                    <span class="sub_link_name">Archive</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#event_history" class="menu_btn">
                <i class="bx bx-history"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Event History
                  <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
              </a>
              <ul class="sub_list">
                <li class="sub-item">
                  <a href="HIS-admin-ManageEvent.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Event Page</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="HIS-admin-highlights.php">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Highlights Page</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="P&J-admin-formPJ.php" class="menu_btn active">
                <i class="bx bx-group"></i>
                <span class="link_name">Judges & <br> Participants</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    
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
                        <h4 class="fw-bold d-table-cell" style="color:var(--color-content-text);font-weight:1000;">Judges and Participants</h4>
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
                          <div class="col"><label class="col-form-label" style="font-weight:1000;margin-top: 25px; color:var(--color-content-text);">Judges</label></div>
                          <div class="col text-end" style="margin-right: 18px;">
                            <button onClick="add_judge();" class="buttonadd success-button icon-button" style="margin-left:auto;" type="button" id="judgeadd"><i class='bx bxs-user-plus'></i></button>
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
                                  <table>
                                    <tr>
                                  <th><h6 class="judgeheader">Judge Name</h6></th>
                                  <th><h6 class="judgeheader">Judge Nickname</h6></th>
                                  <th><h6 class="judgeheader">Scoring Link</h6></th>
                                  </tr>
                                  </table>
                                    <ul id="Jbox">
<!-- Judge Form -->
                                      <div class="append_judges">
                                        <li style='list-style-type: none;'>
                                        <tr>
                                          <td><input type='text' class='inputjname cformj' name='judge_name_temp[]' style='border-radius:20px;' placeholder='Judge Name' minlength="4" maxlength="20" Required pattern="[a-zA-Z1-9\- ]*"/></td>
                                          <td><input type='text' class='inputjnick cformj' name='judge_nick_temp[]' style='border-radius:20px;' placeholder='Nickname' minlength="4" maxlength="10" Required/></td>
                                          <td><button onClick='showl()' class='buttonlink1' type='button' style='border-radius:15px;width: 160px; height: 40px; color: white;background: #73A9CC;'><i class='bx bx-link'></i>Generate Link</button></td>
                                          <td><button class='delete-button icon-button delJ btndel' id='deleteJA' style="float:right;"><i class='bx bxs-trash-alt' ></i></button></td>
                                          </tr>
                                          <br>
                                        </li>
                                        <li style='list-style-type: none;'>
                                        <br><tr>
                                          <td><input type='text' class='inputjname cformj' name='judge_name_temp[]' style='border-radius:20px;' placeholder='Judge Name' minlength="4" maxlength="20" Required pattern="[a-zA-Z1-9\- ]*"/></td>
                                          <td><input type='text' class='inputjnick cformj' name='judge_nick_temp[]' style='border-radius:20px;' placeholder='Nickname' minlength="4" maxlength="10" Required/></td>
                                          <td><button onClick='showl()' class='buttonlink1' type='button' style='border-radius:15px;width: 160px; height: 40px; color: white;background: #73A9CC;'><i class='bx bx-link'></i>Generate Link</button></td>
                                          <td><button class='delete-button icon-button delJ btndel' id='deleteJB' style="float:right;"><i class='bx bxs-trash-alt' ></i></button></td>
                                          </tr>
                                          <br>
                                        </li>
                                        </div>
                                    </ul>
                                    </div>
                                    <div>

                                    </div>
                                    </div>
                                </div>
                                <div class="col text-end" style="margin-right:30px;">
                                <button class="primary-button" type="submit" value="Add" id="save_btnJ" style="display:inline;" disabled>Save</button>
                                <button onClick="show()" class="secondary-button delJ" id="can_btnJ" type="button"  style="display:inline;" disabled>Cancel</button></div>
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
                          <div class="col text-end" style="margin-right: 18px;">
                            <button onClick="add_par();" class="buttonadd success-button icon-button" style="margin-left:auto;" type="button" id="paraddi"><i class='bx bxs-user-plus'></i></button>
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
                                  <table>
                                  <th><h6 style=" margin-left:30px; font-weight:1000; color:var(--color-content-text);">Participant Name</h6></th>
                                  <th><h6 style="color: white; margin-left:60px; font-weight:1000; color:var(--color-content-text);">Course</h6></th>
                                  <th><h6 style="color: white; margin-left:50px; font-weight:1000; color:var(--color-content-text);">Section</h6></th>
                                  <th><h6 style="color: white; margin-left:70px; font-weight:1000; color:var(--color-content-text);">Organization</h6></th>
                                  </table>
                                  <form action="#" method="POST" id="add_form3">
                                    <ul id="Pbox">
                                      <li style='list-style-type: none;'>
                                          <input type='text' class='inputpname cformpi' name='participants_name_temp[]' style='border-radius:20px;' placeholder='Participants Name' minlength="4" maxlength="20" Required pattern="[a-zA-Z1-9\- ]*"/>
                                          <input type='text' class='inputpcs cformpi' name='participants_course_temp[]' style='border-radius:20px;' placeholder='Course' minlength="4" maxlength="5" Required pattern="[a-zA-Z ]*"/>
                                          <input type='text' class='inputpcs cformpi' name='participants_section_temp[]' style='border-radius:20px; width:110px;' placeholder='Section' minlength="3" maxlength="3" Required pattern="[\d-]*"/>
                                          <select class='btn dropdown-toggle' name='participants_organization_temp[]' aria-expanded='false' data-bs-toggle='dropdown' type='button' style='border-radius: 20px;width: 180.031px;margin-left: 8px;background: var(--bs-light);color: var(--bs-body-color);'>
                                            <option disabled selected>Organization</option>
                                            <option>ELITE</option>
                                            <option>JPIA</option>
                                          </select>
                                          <button class='delete-button icon-button delP btndel' id='deleteP' style="float:right;"><i class='bx bxs-trash-alt' ></i></button><br/>
                                      </li>
                                      <li style='list-style-type: none;'>
                                      <br>
                                          <input type='text' class='inputpname cformpi' name='participants_name_temp[]' style='border-radius:20px;' placeholder='Participants Name' minlength="4" maxlength="20" Required pattern="[a-zA-Z1-9\- ]*"/>
                                          <input type='text' class='inputpcs cformpi' name='participants_course_temp[]' style='border-radius:20px;' placeholder='Course' minlength="4" maxlength="5" Required pattern="[a-zA-Z ]*"/>
                                          <input type='text' class='inputpcs cformpi' name='participants_section_temp[]' style='border-radius:20px;width:110px;' placeholder='Section' minlength="3" maxlength="3" Required pattern="[\d-]*"/>
                                          <select class='btn dropdown-toggle' name='participants_organization_temp[]' aria-expanded='false' data-bs-toggle='dropdown' type='button' style='border-radius: 20px;width: 180.031px;margin-left: 8px;background: var(--bs-light);color: var(--bs-body-color);'>
                                            <option disabled selected>Organization</option>
                                            <option>ELITE</option>
                                            <option>JPIA</option>
                                          </select>
                                          <button class='delete-button icon-button delP btndel' id='deleteP' style="float:right;"><i class='bx bxs-trash-alt' ></i></button><br/>
                                      </li>
                                    </ul>
                                  </div>
                                  <div class="col text-end" style="margin-top:30px;">
                                  <button class="primary-button" type="submit" value="Add" id="save_btnPI" style="display:inline;" disabled>Save</button>
                                  <button onClick="showp()" class="secondary-button" type="button" id="can_btnPI"  style="display:inline;" disabled>Cancel</button></div>
                                  </form>
                                  </div>
                                  <div class="col group hide" style="width:auto;">
                                  <div>
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
var saveJudge = document.getElementById("save_btnJ");
var saveParIndiv = document.getElementById("save_btnPI");
var saveParGroup = document.getElementById("save_btnPG");
var saveAll = document.getElementById("save_btnS");

saveJudge.addEventListener("click", function() {
      saveAll.disabled = false; // Enable the target button
    });
saveParIndiv.addEventListener("click", function() {
      saveAll.disabled = false; // Enable the target button
    });
saveParGroup.addEventListener("click", function() {
      saveAll.disabled = false; // Enable the target button
    });

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

  // Disable or enable the submit button based on the input validity
  save_btnJ.disabled = hasInvalidInput || dynamicInputs.length === 0;
  can_btnJ.disabled = hasInvalidInput || dynamicInputs.length === 0;
}

var intParTextBox = 0;
var intJudgeTextBox = 0;
  function add_judge(){
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
    var submitButton = document.getElementById("save_btnJ");
    submitButton.disabled = true;
    var cancelButton = document.getElementById("can_btnJ");
    cancelButton.disabled = true;
  }

  $("ul").on("click", ".delJ", function(e) {
    e.preventDefault();
    $(this).parent().remove();
    intJudgeTextBox--;
});

$("ul").on("click", "#judgedel", function(e) {
    e.preventDefault();
    $(".Jbox").parent().remove();
    intJudgeTextBox--;
});

function deleteListJ() {
  var list = document.getElementById("Jbox");
  while (list.firstChild) {
    list.firstChild.remove();
} 
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

function deleteListP() {
  var list = document.getElementById("Pbox");
  while (list.firstChild) {
    list.firstChild.remove();
} 
intParTextBox++;
    var objNewPDiv = document.createElement('ul');
    objNewPDiv.setAttribute('id', 'ul_' + intParTextBox);
    objNewPDiv.innerHTML = `<div class='row'><li style='list-style-type: none;'>
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
function deleteListPG() {
  var list = document.getElementById("Pboxg");
  while (list.firstChild) {
    list.firstChild.remove();
}
    intParTextBox++;
    var objNewPDivg = document.createElement('ul');
    objNewPDivg.setAttribute('id', 'ul_' + intParTextBox);
    objNewPDivg.innerHTML = `
    <div class="Pargdel">
      <button class='buttonlink1 delPGD btndel' style="float:right;" type="button"><i class='bx bxs-trash-alt'></i></button>
      <table style="margin-left:30px;">
        <th><h6 style="margin-left:20px; font-weight:1000; color:var(--color-content-text);">Group Name</h6></th>
        <th><h6 style="color: white; margin-left:120px; font-weight:1000; color:var(--color-content-text);">Organization</h6></th>
      </table>
      <div class="dropdown">
        <input type='text' class='inputpname cformpg' name="participants_name_group_temp[]" style='border-radius:20px;' placeholder='Group Name' style="margin-left:30px;width: 180px; height: 40px;" minlength="4" maxlength="10" Required pattern="[a-zA-Z1-9\\- ]*"/>
        <select class='btn dropdown-toggle' name='participants_organization_group_temp[]' aria-expanded='false' data-bs-toggle='dropdown' type='button' style='border-radius: 20px;width: 180.031px;margin-left: 8px;background: var(--bs-light);color: var(--bs-body-color);'>
          <option disabled selected>Organization</option>
          <option>ELITE</option>
          <option>JPIA</option>
        </select>
      </div>
      <div class="col">
        <table>
          <th><h6 style="color: white; margin-left:5px; font-weight:1000; color:var(--color-content-text);">Members</h6></th>
        </table>
        <li style='list-style-type: none;'>
          <input type='text' class='inputpname subform cformpg' name="participants_name_g_temp[]" style='border-radius:20px;' placeholder='Participants Name' minlength="4" maxlength="20" Required pattern="[a-zA-Z1-9\\- ]*"/>
          <input type='text' class='inputpcs cformpg' name="participants_course_group_temp[]" style='border-radius:20px;' placeholder='Course' minlength="4" maxlength="5" Required pattern="[a-zA-Z ]*"/>
          <input type='text' class='inputpcs cformpg' name="participants_section_group_temp[]" style='border-radius:20px;width:110px;' placeholder='Section' minlength="3" maxlength="3" Required pattern="[\d-]*"/>
          <label class="orgChanged2" style="margin-left:40px; margin-right: 70px;color:white;font-weight:1000; color:var(--color-content-text);"></label>
          <button class='buttonlink1 delP btndel' id='deleteP'><i class='bx bxs-trash-alt'></i></button></i><br/>
        </li>
      </div>
      <div class="subformContainer">

      </div>
      <button onclick="addSubform(this)" class="buttonadd" id="paradd" type="button" style="margin-left:600px;"><i class='bx bxs-user-plus'></i></button>
      <hr>
    </div>`;
    document.getElementById('Pboxg').appendChild(objNewPDivg);  
    var submitButtonpg = document.getElementById("save_btnPG");
    submitButtonpg.disabled = true;
    var cancelButtonpg = document.getElementById("can_btnPG");
    cancelButtonpg.disabled = true;
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

  // Disable or enable the submit button based on the input validity
  save_btnPI.disabled = hasInvalidInputpi || dynamicInputspi.length === 0;
  can_btnPI.disabled = hasInvalidInputpi || dynamicInputspi.length === 0;
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