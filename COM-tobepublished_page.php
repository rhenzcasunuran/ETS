<!DOCTYPE html>
<html lang="en">
  <head>
        <title>To Publish</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Side Bar CSS -->
        <link rel="stylesheet" href="./css/boxicons.css">
        <link rel="stylesheet" href="./css/COM-theme-mode.css">
        <link rel="stylesheet" href="./css/responsive.css">
        <link rel="stylesheet" href="./css/COM-style.css">
        <link rel="stylesheet" href="./css/sidebar-style.css">
        <link rel="stylesheet" href="./css/system-wide.css">
        <!-- Page specific CSS -->
        <link rel="stylesheet" href="./css/COM-tobepublished_page.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        
        <link rel="stylesheet" type="text/css" media="all" href="./css/COM-daterangepicker.css" />
  <head>
  <body>
    <!--Popup Success-->
    <div class="popup-background" id="markAsDoneWrapper"  style="z-index:4000 !important;">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-check-circle prompt-icon success-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Success!</h3>   <!--header-->
                <p>The result is scheduled and will be published.</p> <!--text-->
            </div>
            <div  class="div">
                <!--<button class="outline-button"  id="success-cancel"><i class='bx bx-x'></i>Cancel</button>-->
                <button class="success-button"  id="success-confirm"><i class='bx bx-check'></i>Confirm</button>
            </div>
        </div>
    </div>

    <!--Popup Discard Changes?-->
    <div class="popup-background" id="cancelWrapper" onclick="hideCancel()" style="z-index:4000 !important;">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-error prompt-icon warning-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Discard Changes?</h3>   <!--header-->
                <p>Any unsaved progress will be lost.</p> <!--text-->
            </div>
            <div  class="div">
                <button class="outline-button" id="discard-return"><i class='bx bx-chevron-left'></i>Return</button> <!--Change to function to show calendar -->
                <button class="primary-button" id="discard-ok"><i class='bx bx-x'></i>Discard</button>
            </div>
        </div>
    </div>

    <!--Popup: Edit Schedule?-->
    <div class="popup-background edit-sched" id="editWrapper" onclick="hideEdit()" style="z-index:4000 !important;">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-error prompt-icon warning-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Edit Schedule?</h3>   <!--header-->
                <p>Are you sure you want to change the schedule?</p> <!--text-->
            </div>
            <div  class="div">
                <button class="outline-button" onclick="hideEdit()" id="edit-cancel"><i class='bx bx-chevron-left'></i>Cancel</button>
                <button class="primary-button" onclick="openCalendar()" id="edit-ok"><i class='bx bx-x'></i>Edit Schedule</button>
            </div>
        </div>
    </div>

    <!--Popup: Unavailable-->
    <div class="popup-background" id="deleteWrapper" onclick="hideDelete()" style="z-index:4000 !important;">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-error prompt-icon danger-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Incomplete</h3>   <!--header-->
                <p>The result is not yet complete. Please make sure that all required scores are completed.</p> <!--text-->
            </div>
            <div  class="div">
                <button class="outline-button" onclick="hideDelete()"><i class='bx bx-x'></i>Cancel</button>
                <!--<button class="danger-button"><i class='bx bx-trash'></i>Delete</button>-->
            </div>
        </div>
    </div>
    <!--Popups End-->
    <!--Sidebar Start-->
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
        <div class="sidebar-content-container" style="border:none;">
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
              <a href="#competition" class="menu_btn active">
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
                  <a href="COM-tobepublished_page.php" class="sub-active">
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
              <a href="P&J-admin-formPJ.php">
                <i class="bx bx-group"></i>
                <span class="link_name">Judges & <br> Participants</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!--Sidebar End-->
    <!--Content Start-->
    <section class="home-section removespace">
      <div class="header">To Publish</div>
    </section>
    <section class="home-section actualbody">
        <div id="empty" class="empty">
            <h1 class="empty_header">No Results</h1>
            <p class="empty_p">There are no competition results to be published yet.</p>
            <button class="go_to_manageBtn" onclick="window.location.href='./COM-manage_results_page.php';"><i class='bx bxs-plus-square'></i><p class="pBtn">Manage Results</p></button>
        </div>
        <div class="content">
        <?php
        try {
            require './php/COM-display-result-in-topublish.php';
        } catch (Throwable $e) {
            // Show error message na hindi nag connect sa db
            // Pero sa ngayon wag muna
        }
        ?>
        </div>
    </section>
    <!--Content End-->
    <!--Side Bar Scripts-->
    <script src="./js/script.js"></script>
    <script src="./js/COM-theme.js"></script>
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
    <!--Side Bar Scripts End-->
    <script type="text/javascript" src="./js/COM-daterangepicker.js"></script>
    <script>
      console.log("daterangepicker in the html");
      //encase this function in an if statement of listening if the sched btn is clicked
        $(function() {
            $('input[name="datetimes"]').daterangepicker({
                timePicker: true,
                startDate: moment().startOf('hour'),
                endDate: moment().startOf('hour').add(32, 'hour'),
                locale: {
                    format: 'MMMM D, YYYY hh:mm A',
                    applyLabel: "Set Schedule",
                    cancelLabel: "Cancel",
                    "daysOfWeek": [
                        "Sun",
                        "Mon",
                        "Tue",
                        "Wed",
                        "Thu",
                        "Fri",
                        "Sat"
                    ],
                    monthNames: [
                        "January",
                        "February",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July",
                        "August",
                        "September",
                        "October",
                        "November",
                        "December"
                    ],
                }
            });
            $('input[name="datetimes"]').val('');
        });
    </script>
    <script>
      // Success
      popupMarkAsDone = document.getElementById('markAsDoneWrapper');
  
  var showMarkAsDone = function() {
    popupMarkAsDone.style.display ='flex';
  }
  var hideMarkAsDone = function() {
    popupMarkAsDone.style.display ='none';
    //input.disabled = true;
  }

  // Unsaved Changes
  popupCancel = document.getElementById('cancelWrapper');

  var showCancel = function() {
    popupCancel.style.display ='flex';
  }
  var hideCancel = function() {
    popupCancel.style.display ='none';
    //input.disabled = true;
  }

  //Incomplete
  popupDelete = document.getElementById('deleteWrapper');

  var showDelete = function() {
    popupDelete.style.display ='flex';
  }
  var hideDelete = function() {
    popupDelete.style.display ='none';
    //input.disabled = true;
  }
  
  //Edit Schedule
  popupEditChanges = document.getElementById('editWrapper');

  var showEdit = function() {
    popupEditChanges.style.display ='flex';
  }
  var hideEdit = function() {
    popupEditChanges.style.display ='none';
    //input.disabled = true;
  }

  // Function to call the calendar
  var openCalendar = function(x,competitionName) {
    name = competitionName;
    compId = competitionName+"-input";
    input = x;
    hideEdit();
    hideDelete();
    hideCancel();
    hideMarkAsDone();
    console.log(input+" is the input value in the calendar");
    input.disabled = false;
    if (input.id == compId) {
      input.click();
      console.log("input.id: "+input.id);
      console.log("compId: "+compId);
    }
    
    input.disabled = true;
  }
    </script>
    <script>
      const buttons = document.querySelectorAll('.sched_btn');
      buttons.forEach((button) => {
        button.addEventListener("click", (e) => {
          const h2 = e.target.closest('.parent');
          const input = h2.querySelector('.sched_output');
          var parentElement = button.parentElement;
          var id = parentElement.id;
          var competitionName = id;
          var x = document.getElementById(competitionName+"-input");
          console.log(x.id+" is the current id");
          console.log(input.id+" is the input id");
          
          
          // Popups depending on the button type
          if (button.textContent === "Edit Schedule") {
            showEdit();
            openCalendar(x,competitionName);
            //var editOk = document.getElementById("edit-ok");
            //editOk.addEventListener("click", function open(e){
            //  if (x.id == input.id){
            //    
            //  }
            //  e.stopPropagation();
            //});
          }
          if (button.textContent === "Unavailable") { 
            showDelete();
          }
          e.stopPropagation();
        });
      });
      // Set button name and color
      // Get the competition name from the h2 element
      buttons.forEach((button) => {
        var parentElement = button.parentElement;
        var id = parentElement.id;
        var competitionName = id;

        // Send the competition name to the PHP file using AJAX
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            // Check the response from the PHP file and change the color of the button
            console.log(this.responseText);
            var response = JSON.parse(this.responseText);
            var schedule = response['schedule'];
            var element = document.getElementById(competitionName+' btn');
            
            if (schedule === null){
              element.style.backgroundColor = 'rgb(216, 232, 90)';
              element.textContent = "Schedule";
              element.disabled = false;
              console.log(competitionName);
              console.log(schedule);
              console.log("yellow dpat to")
            } else {
              element.style.backgroundColor = 'rgb(102, 232, 90)';
              element.textContent = "Edit Schedule";
              element.disabled = false;
              console.log(competitionName);
              console.log(schedule);
              console.log("Green dpat to")
              /*A code to change the color to black by sending compName to php */
            }
            $.ajax({
              type: "POST",
              url: "./php/COM-change_color_black.php",
              data: { competitionName: competitionName },
                success: function(response) {
                  console.log(response);
                  if (response == 'grey') {
                    document.getElementById(competitionName +' btn').style.backgroundColor = response + "!important";
                    element.textContent = "Unavailable";
                    element.disabled = false;
                  }
                  if (response == 'notempty') {
                    element.disabled = false;
                  }
                }
              });
          }
        };
        const url = "./php/COM-get_compname.php";
        xhttp.open("GET", url +"?competitionName="+ competitionName, true);
        xhttp.send();
      });
    </script>
    <script>
      
    </script>
  </body>
</html>