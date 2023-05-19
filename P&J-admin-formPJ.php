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
    <link rel="stylesheet" href="css/boxicons.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/sidebar-style.css">
    <link rel="stylesheet" href="css/home-sidebar-style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400&amp;display=swap">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.3/css/bootstrap.min.css'/>
    <link rel="stylesheet" href="css/P&J-participantsandjudges.css?v=<?php echo time(); ?>"> 
    <link rel="stylesheet" href="./css/HOM-style.css">
    
    

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
              <a href="#event_menu">
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
              <div class="container-fluid" id="popup">
                <div class="row popup-card">
                  <i class='row warning-icon bx bx-trash' ></i>
                  <h3 class="row d-flex justify-content-center align-items-center">
                    Delete Tables?
                  </h3>
                  <h6 class="row d-flex justify-content-center align-items-center">
                    You cannot undo this action.
                  </h6>
                  <div class="row">
                    <div class="col">
                      <a href="HOM-manage-post.php?eed=<?php echo $count[0]?>" class="text-decoration-none" onclick="hide()">
                        <div id="clear" class="button-clone continue" onclick="hide()">
                          &nbsp;Continue
                        </div>
                      </a>
                    </div>
                    <div class="col">
                      <div class="button-clone cancel" onclick="hide()">
                        &nbsp;Cancel
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="container-fluid" id="popuplink">
                <div class="row popup-card" style="width:450px; height:200px;">
                <h6>Your Score Tabulation Link is Ready! <button onclick="hidel()" class="buttonsubx" style="position:relative; top:0; left:50px;">X</button></h6> 
                  
                <div class="col">
                      
                    </div>
                    <div class="scorelink-container" >
                    <p>Copy the link to score.</p>
                    <textarea disabled>Https//:SampleLink</textarea>
                <a href='P&J-admin-scoretab.php' target="_blank" style="position:absolute;top:0; right:0;">
                <button class="buttonadd"id="clearlink">
                 <i class='bx bxs-copy' ></i>
                </button>
                </a>
                <h6>Only authorized persons can access the link.</h6>
                </div>
                  <div class="row">
                    <div class="col">
                      <a href="P&J-admin-formPJ.php?eed=<?php echo $count[0]?>" class="text-decoration-none" onclick="hidel()">
                      </a>
                    </div>
                  </div>
                </div>
              </div>

    <section class="home-section">
      <div class="container">
        <div class="row" style="min-width: 100%;">
            <div class="col-md-10" style="max-width: 1400px;min-width: 100%;">
                <div class="row" style="margin-bottom: 20px;margin-top: 20px;">
                    <div class="col">
                        <h4 class="fw-bold d-table-cell" style="color:var(--color-content-text);font-weight:1000;">Judges and Participants</h4>
                    </div>
                </div>
                <form action=""></form>
                <div class="row">
                <form action="#" method="POST" id="add_judges">
                    <div class="col-xxl-12"><label class="form-label fw-bold" style="margin-left: 25px; color:var(--color-content-text);">Event</label><label for="Participant Category" class="form-label fw-bold" style="margin-left: 190px; color:var(--color-content-text);">Participant Category</label>
                        <div class="dropdown"><select class="btn dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button" style="border-radius: 20px;width: 180.031px;margin-left: 19px;background: var(--bs-light);color: var(--bs-body-color);">Dropdown
                        <option>P-Pop Dance</option>
                        <option>IT Week</option>
                        </select>
                        
                        <select name ="Participant Category"class='btn dropdown-toggle div-toggle' aria-expanded='false' data-bs-toggle='dropdown' type='button' style='border-radius: 20px;width: 180.031px;margin-left: 50px;background: var(--bs-light);color: var(--bs-body-color);' data-target=".participantsform">
                        <option data-show=".individual">Individual</option>
                        <option data-show=".group">Group</option>
                        </select>
                        </div>
                        <div class="row">
                          <div class="col"><label class="col-form-label" style="font-weight:1000;margin-top: 25px;margin-left: 11px; color:var(--color-content-text);">Judges</label></div>
                          <div class="col text-end" style="margin-right: 18px;">
                            <button onClick="add_judge();" class="buttonadd" type="button" id="judgeadd"><i class='bx bxs-user-plus'></i></button>
                            <button  onClick="show()" class="buttonsub" type="button" id="judgedel"><i class='bx bx-trash' ></i></button>
                          </div>
                      </div>
                        <div style="border-radius: 20px;min-height: 300px; margin: auto; margin-top: 2px;width: auto;height: 100px;display: table;">
                            <div class="card-body1" style="border-radius: 20px; background: var(--color-content-card);box-shadow: 4px 5px 10px;">
                            
                              <div id="add_form">
                                  <div class="col" style="margin-top: 21px;">
                                  <div class="col">
                                    <table>
                                  <th><h6 class="judgeheader" style="color:var(--color-content-text);">Judge Name</h6></th>
                                  <th><h6 class="judgeheader" style="color:var(--color-content-text);">Judge Nickname</h6></th>
                                  <th><h6 class="judgeheader" style="color:var(--color-content-text);">Scoring Link</h6></th>
                                  </table>
                                  </div>
                                    <ul id="Jbox">
                                        <li style='list-style-type: none;'>
                                          <br>
                                          <input type='text' class='inputjname' name='judge_name[]' placeholder='Judge Name' Required/>
                                          <input type='text' class='inputjnick' name='judge_nick[]' placeholder='Nickname'Required/>
                                          <button onClick='showl()' class='buttonlink1' type='button' style='border-radius:15px;width: 160px; height: 40px; color: white;background: #73A9CC;'><i class='bx bx-link'></i>Generate Link</button>
                                          <button class='buttonlink1 delJ btndel' id='deleteJA' style='margin-left: 70px;'><i class='bx bxs-trash-alt' ></i></button>
                                          <br>
                                        </li>
                                        <li style='list-style-type: none;'>
                                        <br>
                                          <input type='text' class='inputjname' name='judge_name[]' placeholder='Judge Name' Required/>
                                          <input type='text' class='inputjnick' name='judge_nick[]' placeholder='Nickname'Required/>
                                          <button onClick='showl()' class='buttonlink1;' type='button' style='border-radius:15px;width: 160px; height: 40px; color: white;background: #73A9CC;'><i class='bx bx-link'></i>Generate Link</button>
                                          <button class='buttonlink1 delJ btndel' id='deleteJB' style='margin-left: 70px;'><i class='bx bxs-trash-alt' ></i></button>
                                          <br/>
                                        </li>
                                    </ul>
                                  </div>
                                    <br>
                                
                                <div class="col text-end">
                                  <button class="buttonsave" type="submit" value="Add" id="add_btn">Save</button>
                                  <button class="buttoncancel delJ" type="button" style="display:inline;">Cancel</button></div>
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
                                              <label class="col text-end" style="margin-top: 25px;margin-left: 11px; color:var(--color-content-text); font-weight:1000;">Participants</label>
                                            <div class="col text-end" style="margin-right: 18px;">
                                              <button onClick="add_par();" class="buttonadd" id="paradd" type="button" ><i class='bx bxs-user-plus'></i></button>
                                              <button onClick="show()" class="buttonsub delP" id="pardel" type="button"><i class='bx bx-trash' ></i></button>
                                            </div>
                                            
                                            </div>
                                            <div class="group hide">
                                            <label class="col text-end" style="margin-top: 25px;margin-left: 11px; color:var(--color-content-text); font-weight:1000;">Participants</label>
                                            <div class="col text-end" style="margin-right: 18px;">
                                            <button onClick="add_par();" class="buttonaddg" type="button"><i class='bx bxs-group'></i></button>
                                              <button onClick="show()" class="buttonsub delP" id="pardel" type="button"><i class='bx bx-trash' ></i></button>
                                            </div>
                                            
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="border-radius: 20px;min-height: 300px; margin: auto; margin-top: 2px;width: auto;height: 100px;display: table;">
                        <div class="card-body2 participantsform" style="border-radius: 20px; background: var(--color-content-card);box-shadow: 4px 5px 10px;">
                            <div class="individual hide">
                                  <div class="col" style="margin-top: 21px;">
                                  <div class="col">
                                    <table>
                                  <th><h6 style="color: white; margin-left:30px; font-weight:1000; color:var(--color-content-text);">Participant Name</h6></th>
                                  <th><h6 style="color: white; margin-left:60px; font-weight:1000; color:var(--color-content-text);">Course</h6></th>
                                  <th><h6 style="color: white; margin-left:50px; font-weight:1000; color:var(--color-content-text);">Section</h6></th>
                                  <th><h6 style="color: white; margin-left:70px; font-weight:1000; color:var(--color-content-text);">Organization</h6></th>
                                  </table>
                                  </div>
                                    <ul id="Pbox">
                                      <li style='list-style-type: none;'>
                                          <input type='text' class='inputpname' placeholder='Participants Name' Required/>
                                          <input type='text' class='inputpcs' placeholder='Course' Required/>
                                          <input type='text' class='inputpcs' placeholder='Section' Required/>
                                          <select class='btn dropdown-toggle' aria-expanded='false' data-bs-toggle='dropdown' type='button' style='border-radius: 20px;width: 180.031px;margin-left: 8px;background: var(--bs-light);color: var(--bs-body-color);'>
                                            <option disabled selected>Organization</option>
                                            <option>Org 2</option>
                                            <option>Org 3</option>
                                          </select>
                                          <button class='buttonlink1 delP btndel' id='deleteP' style='margin-left:30px;border-radius:15px;width: 40px; height: 40px; color: white;background: #ff3636;'><i class='bx bxs-trash-alt' ></i></button></i><br/>
                                      </li>
                                      <li style='list-style-type: none;'>
                                      <br>
                                          <input type='text' class='inputpname' placeholder='Participants Name' Required/>
                                          <input type='text' class='inputpcs' placeholder='Course' Required/>
                                          <input type='text' class='inputpcs' placeholder='Section' Required/>
                                          <select class='btn dropdown-toggle' aria-expanded='false' data-bs-toggle='dropdown' type='button' style='border-radius: 20px;width: 180.031px;margin-left: 8px;background: var(--bs-light);color: var(--bs-body-color);'>
                                            <option disabled selected>Organization</option>
                                            <option>Org 2</option>
                                            <option>Org 3</option>
                                          </select>
                                          <button class='buttonlink1 delP btndel' id='deleteP' style="margin-left:30px;"><i class='bx bxs-trash-alt' ></i></button></i><br/>
                                      </li>
                                    </ul>
                                  </div>
                                  <div class="col text-end" style="margin-top:30px;"><button class="buttonsave" type="button">Save</button><button class="buttoncancel" type="button">Cancel</button></div>
                                  </div>
                                  <div class="col group hide">
                                  <div class="">
                                  <input type='text' class='inputpname' placeholder='ITDS' style="margin-left:30px;width: 180px; height: 40px;" Required/>
                                    
                                  <select form="orgInput" name ="Organization" class='btn dropdown-toggle orgOption' aria-expanded='false' data-bs-toggle='dropdown' type='button' style='border-radius: 20px;width: 180.031px;margin-left: 50px;background: var(--bs-light);color: var(--bs-body-color);'>
                                    <option value="ELITE" class="ELITE">ELITE</option>
                                    <option value="JPIA" class="JPIA">JPIA</option>
                                    </select>
                                    <button onClick="#" class="buttonadd" id="paradd" type="button" style="margin-left:180px;"><i class='bx bxs-user-plus'></i></button>
                                  </div>
                                  <div class="col" style="margin-top: 21px; margin-left: 50px;">
                                  <div class="col">
                                    <table>
                                  <th><h6 style="color: white; margin-left:5px; font-weight:1000; color:var(--color-content-text);">Members</h6></th>
                                  </table>
                                  </div>
                                    <ul id="Pbox">
                                      <li style='list-style-type: none;'>
                                      <input type='text' class='inputpname' placeholder='Participants Name' Required/>
                                          <input type='text' class='inputpcs' placeholder='Course' Required/>
                                          <input type='text' class='inputpcs' placeholder='Section' Required/>
                                          <label class="orgChanged" style="margin-left:40px; margin-right: 70px;color:white;font-weight:1000; color:var(--color-content-text);">ELITE</label>
                                          <button class='buttonlink1 delP btndel' id='deleteP'><i class='bx bxs-trash-alt' ></i></button></i><br/>
                                      </li>
                                      <li style='list-style-type: none;'>
                                      <br>
                                          <input type='text' class='inputpname' placeholder='Participants Name' Required/>
                                          <input type='text' class='inputpcs' placeholder='Course' Required/>
                                          <input type='text' class='inputpcs' placeholder='Section' Required/>
                                          <label class="orgChanged" style="margin-left:40px; margin-right: 70px;color:white; font-weight:1000; color:var(--color-content-text);">ELITE</label>
                                          <button class='buttonlink1 delP btndel' id='deleteP'><i class='bx bxs-trash-alt' ></i></button></i><br/>
                                      </li>
                                    </ul>
                                  </div>
                                  <br>
                                  <div class="dropdown">
                                    <input type='text' class='inputpname' placeholder='ITDS' style="margin-left:30px;width: 180px; height: 40px;" Required/>
                        
                                    <select name ="Organization" class='btn dropdown-toggle' aria-expanded='false' data-bs-toggle='dropdown' type='button' style='border-radius: 20px;width: 180.031px;margin-left: 50px;background: var(--bs-light);color: var(--bs-body-color);'>
                                    <option>JPIA</option>
                                    <option>ELITE</option>
                                    </select>
                                    <button onClick="#" class="buttonadd" id="paradd" type="button" style="margin-left:180px;"><i class='bx bxs-user-plus'></i></button>
                                    <div class="col text-end" style="margin-top:30px;"><button class="buttonsave" type="button">Save</button><button class="buttoncancel" type="button">Cancel</button></div>
                                  </div>
                                    <br>
                            </div>
                            
                        </div>
                        
                        </div>
                        </div>
                        <div class="row">
                            <div class="col text-end" style="margin-top: 10px;margin-bottom: 10px;margin-right: 16px;"><button class="buttonsubmit" type="submit" style="width: 120px; height: 50px; text-align: center;" value="Add" id="add_btn">Submit</button></div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </section>
    <!-- Scripts -->
    <script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js'></script>
    <script src="./js/script.js"></script>
    <script src="./js/change-theme.js"></script>
    <script src="./js/jquery-3.6.4.js"></script>
    <script src="./js/jqueryPJ.min.js"></script>
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

<script>
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
</script>

<script>
var intParTextBox = 0;
var intJudgeTextBox = 0;
  function add_judge(){
    intJudgeTextBox++;
    var objNewJDiv = document.createElement('ul');
    objNewJDiv.setAttribute('id', 'ul_' + intJudgeTextBox);
    objNewJDiv.innerHTML = "<div class='row append_judges'><li style='list-style-type: none;'><br><input type='text' class='inputjname' name='judge_name[]' placeholder='Judge Name' /><input type='text' class='inputjnickd' name='judge_nick[]' placeholder='Nickname'/><button onClick='showl()'class='buttonlink1;' type='button' style='border-radius:15px;margin-left: 3px;margin-right:5px;width: 160px; height: 40px; color: white;background: #73A9CC;'><i class='bx bx-link'></i>Generate Link</button><button class='buttonlink1 delJ btndel' id='deleteJ' style='margin-left: 70px;'><i class='bx bxs-trash-alt' ></i></button><br/></li></div>";
    document.getElementById('Jbox').appendChild(objNewJDiv);  
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

$('.orgOption').on('change', function(){
    var v = $(this).find(':selected').text();
    $('.orgChanged').text( v );
});

function deleteAll(){
           var todo =  document.getElementByID("Jbox");
           var lis = todo.getElementsByTagName("li");
           console.log(lis);
           while(lis.length > 0){                   
              todo.removeChild(lis[0]);
           }
        };   

  function add_par(){
    intParTextBox++;
    var objNewPDiv = document.createElement('ul');
    objNewPDiv.setAttribute('id', 'ul_' + intParTextBox);
    objNewPDiv.innerHTML = "<li style='list-style-type: none;'><br><input type='text' class='inputpname' placeholder='Participants Name'/><input type='text' class='inputpcsd' placeholder='Course' /><input type='text' class='inputpcsd' placeholder='Section' /><select class='btn dropdown-toggle orgmargin' aria-expanded='false' data-bs-toggle='dropdown' type='button' style='border-radius: 20px;width: 180.031px;margin-right: 4px;background: var(--bs-light);color: var(--bs-body-color);'><option disabled selected>Organization</option><option>Org 2</option><option>Org 3</option></select><button class='buttonlink1 delP btndel' id='deleteP' style='margin-left:33px;'><i class='bx bxs-trash-alt' ></i></button><br/></li>";
    document.getElementById('Pbox').appendChild(objNewPDiv);  
  }

  $("ul").on("click", ".delP" , function(a) {
    a.preventDefault();
    $(this).parent().remove();
    intParTextBox--;
});

$(document).ready(function(){
  $("#pardel").click(function(){
    $(".delP").hide();
  });
  $("#pardel").click(function(){
    $(".delP").show();
  });
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
            $("#add_form").submit(function(e){
                e.preventDefault();
                $("#add_btn").val('Adding...');
                $.ajax({
                    url:'php/P&J-admin-action.php',
                    method:'POST',
                    data: $(this).serialize(),
                    success:function(response){
                        console.log(response);
                        $("#add_btn").val('Add');
                        $("#add_form")[0].reset();
                        $(".append_judges").remove();
                        $("#show_alert").html('<div class="alert alert-success" role="alert">${response}</div>');
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

  </body>

</html>