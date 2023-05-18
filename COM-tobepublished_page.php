<!DOCTYPE html>
<html lang="en">
  <head>
      <title>To Be Published</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- Side Bar CSS -->
      <link rel="stylesheet" href="./css/boxicons.css">
      <link rel="stylesheet" href="./css/COM-theme-mode.css">
      <link rel="stylesheet" href="./css/responsive.css">
      <link rel="stylesheet" href="./css/COM-style.css">
      <!-- Page specific CSS -->
      <link rel="stylesheet" href="./tobepublished_page/COM-tobepublished_page.css">
      <link rel="stylesheet" href="./tobepublished_page/dist/simplepicker.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <head>

  <body>
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
                    <span class="sub_link_name">To Be Published</span>
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
      <div class="header">To Be Published</div>
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
            require './tobepublished_page/COM-display_competition_results.php';
        } catch (Throwable $e) {
            // Show error message na hindi nag connect sa db
            // Pero sa ngayon wag muna
        }
        ?>
        </div>
        <div class="succ-wrapper" id="success-pp-wrap" style="display:none;">
          <div class="succ" id="success-pp">
            <i class="fa fa-check-circle"></i>
            <h1 class="suc-head">All right!</h1>
            <p class="suc-p">The result is now scheduled and ready to be published.</p>
            <button class="suc-btn" id="close-btn"><i class="fa fa-long-arrow-right"></i></button>
          </div>
        </div>
        <div class="cau-wrapper" id="caution-pp-wrap" style="display:none;">
          <div class="bacc" id="caution-pp">
            <i class="fa fa-exclamation-triangle"></i>
            <h1 class="suc-head">Unsaved Changes</h1>
            <p class="suc-p">Changes won't be saved. Are you sure you want to discard all changes?</p>
            <button class="returnbtn" id="returnbtn">Return to editing</button>
            <button class="discardbtn" id="discardbtn">Discard</button>
          </div>
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
    <!--Side Bar Scripts End-->
    <!--Calendar (Schedule) Scripts End-->
    <script src="./tobepublished_page/dist/simplepicker.js"></script>
    <script>
      const buttons = document.querySelectorAll('.sched_btn');
      buttons.forEach((button) => {
        button.addEventListener("click", (e) => {
          const h2 = e.target.closest('.parent');
          const input = h2.querySelector('.sched_output');
          const simplepicker = new SimplePicker ({
            zIndex: 10
          });
          simplepicker.open();
          var parentElement = button.parentElement;
          var id = parentElement.id;
          var competitionName = id;
          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            // Check the response from the PHP file and change the color of the button
            console.log(this.responseText);
            var response = JSON.parse(this.responseText);
            var time = response.time;
            var day = response.day;
            var month = response.month;
            var year = response.year;
            var day_header = document.getElementById("day-headerID");
            var month_year = document.getElementById("month-yearID");
            var date_current = document.getElementById("dateID");
            var time_current = document.getElementById("timeID");
            if (month == '01'){
              month = 'January';
            }
            if (month == '02'){
              month = 'February';
            }
            if (month == '03'){
              month = 'March';
            }
            if (month == '04'){
              month = 'April';
            }
            if (month == '05'){
              month = 'May';
            }
            if (month == '06'){
              month = 'June';
            }
            if (month == '07'){
              month = 'July';
            }
            if (month == '08'){
              month = 'August';
            }
            if (month == '09'){
              month = 'September';
            }
            if (month == '10'){
              month = 'October';
            }
            if (month == '11'){
              month = 'Novemeber';
            }
            if (month == '12'){
              month = 'December';
            }
            var green = 'rgb(102, 232, 90)';
            var btnColor = button.style.backgroundColor;
            if (btnColor == green){
              day_header.textContent = 'Current Scheduled Time';
            }
            
            month_year.textContent = month +' ' +year;
            date_current.textContent = day;
            time_current.textContent = time;
          }
        };
        const url = "./tobepublished_page/COM-display_date.php";
        xhttp.open("GET", url +"?competitionName="+ competitionName, true);
        xhttp.send();
          /*Code for Caution Pop-up*/
          var calendar_wrap = document.getElementById('calendar-wrapper');
          var cancelbtn = document.getElementById('cancelbtn');
          var cau_wrap = document.getElementById('caution-pp-wrap');
          var caution_popup = document.getElementById('caution-pp');
          if (calendar_wrap) {
            calendar_wrap.addEventListener("click", function(){
            cau_wrap.style.display = "block";
            caution_popup.style.display = "block";
            var returnbtn = document.getElementById('returnbtn');
            var discardbtn = document.getElementById('discardbtn');
            returnbtn.addEventListener("click",function(){
              calendar_wrap.classList.add("active");
              cau_wrap.style.display = "none";
              caution_popup.style.display = "none";
            });
            discardbtn.addEventListener("click",function(){
              cau_wrap.style.display = "none";
              caution_popup.style.display = "none";
              calendar_wrap.remove();
            });
          });
          }
          if (cancelbtn) {
            cancelbtn.addEventListener("click", function(){
            cau_wrap.style.display = "block";
            caution_popup.style.display = "block";
            var returnbtn = document.getElementById('returnbtn');
            var discardbtn = document.getElementById('discardbtn');
            returnbtn.addEventListener("click",function(){
              calendar_wrap.classList.add("active");
              cau_wrap.style.display = "none";
              caution_popup.style.display = "none";
            });
            discardbtn.addEventListener("click",function(){
              cau_wrap.style.display = "none";
              caution_popup.style.display = "none";
              calendar_wrap.remove();
            });
          });
          }
          
          /*Code End */
          simplepicker.on("submit", function (date,readableDate){
            const dateObj = new Date(readableDate);
            console.log(dateObj);
            const year = dateObj.getFullYear();
            const month = (dateObj.getMonth() + 1).toString().padStart(2, '0');
            const day = dateObj.getDate().toString().padStart(2, '0');
            const hours = dateObj.getHours().toString().padStart(2, '0');
            const minutes = dateObj.getMinutes().toString().padStart(2, '0');
            const seconds = dateObj.getSeconds().toString().padStart(2, '0');

            const formattedDate = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
            console.log(formattedDate);
            const competitionId = h2.id;

            const xhr = new XMLHttpRequest();
            const url = "./tobepublished_page/COM-save_date.php";
            const params = "competition_name=" + competitionId + "&schedule=" + formattedDate;

            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
              if (xhr.readyState == 4 && xhr.status == 200) {
                console.log(xhr.responseText);
              }
            };
            xhr.send(params);
            /*Open success pop-up */
            var wrap_succ = document.getElementById('success-pp-wrap');
            wrap_succ.style.display = "block";
            var success_popup = document.getElementById('success-pp');
            success_popup.style.display = "flex";
            var close = document.getElementById('close-btn');
            close.addEventListener("click", function(){
              success_popup.style.display = "none";
              wrap_succ.style.display = "none";
              calendar_wrap.remove();
            });
            /*Open success pop-up code end*/
            document.getElementById(competitionId+' btn').style.backgroundColor = 'rgb(102, 232, 90)';
          });
        });
      });
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
              element.disabled = false;
              console.log(competitionName);
              console.log(schedule);
              console.log("yellow dpat to")
            } else {
              element.style.backgroundColor = 'rgb(102, 232, 90)';
              element.disabled = false;
                console.log(competitionName);
                console.log(schedule);
                console.log("Green dpat to")
              /*A code to change the color to black by sending compName to php */

              $.ajax({
              type: "POST",
              url: "./tobepublished_page/COM-change_color_black.php",
              data: { competitionName: competitionName },
                success: function(response) {
                  console.log(response);
                  if (response == 'grey') {
                    document.getElementById(competitionName +' btn').style.backgroundColor = response;
                    element.disabled = true;
                  }
                  if (response == 'notempty') {
                    element.disabled = false;
                  }
                }
              });
            }
          }
        };
        const url = "./tobepublished_page/COM-get_compname.php";
        xhttp.open("GET", url +"?competitionName="+ competitionName, true);
        xhttp.send();
      });
    </script>
  </body>
