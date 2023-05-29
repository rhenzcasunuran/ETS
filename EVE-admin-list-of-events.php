<?php
  include './php/sign-in.php';
  include './php/database_connect.php';
  include './php/EVE-admin-event-config-get-data.php';
  include './php/EVE-admin-edit-event.php';
  include './php/EVE-admin-get-event-data.php';
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuration</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="./css/theme-mode.css">
    <script src="./js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <link rel="stylesheet" href="./css/system-wide.css">

    <!-- Event Config Styles -->
    <link rel="stylesheet" href="./css/EVE-admin-bootstrap-select.min.css">
    <link rel="stylesheet" href="./css/EVE-admin-bootstrap4.min.css">
    <link rel="stylesheet" href="./css/EVE-admin-list-of-events.css">
    <link rel="stylesheet" href="./css/EVE-admin-confirmation.css">
  </head>

  <body>
    <?php
      $row = mysqli_num_rows($event_result);
      if ($row > 0){
        while ($row = mysqli_fetch_array($event_data)):;
    ?>
      <div class="popup-background" id="deleteWrapper<?php echo $row[5];?>">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-error prompt-icon danger-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Delete Event?</h3>   <!--header-->
                <p>This will delete the event permanently. This action cannot be undone.</p> <!--text-->
            </div>
            <div class="div">
                <button class="outline-button" onclick="hideDelete<?php echo $row[0];?>()"><i class='bx bx-x'></i>Cancel</button>
                <a href="EVE-admin-list-of-events.php?eed=<?php echo $row[5]?>">
                  <button class="danger-button"><i class='bx bx-trash'></i>Delete</button>
                </a>
            </div>
        </div>
      </div>

      <div class="popup-background" id="markAsDoneWrapper<?php echo $row[5];?>">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-check-circle prompt-icon success-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Mark as Done?</h3>   <!--header-->
                <p>Marked events will be removed from events list.</p> <!--text-->
            </div>
            <div  class="div">
                <button class="outline-button" onclick="hideMarkAsDone<?php echo $row[0];?>()"><i class='bx bx-x'></i>Cancel</button>
                <a href="EVE-admin-list-of-events.php?mad=<?php echo $row[5]?>">
                  <button class="success-button"><i class='bx bx-check'></i>Confirm</button>
                </a>
            </div>
        </div>
    </div>

      <script>
        popupDelete<?php echo $row[0];?> = document.querySelector('#deleteWrapper<?php echo $row[5];?>');
  
        var showDelete<?php echo $row[0];?> = function() {
            popupDelete<?php echo $row[0];?>.style.display ='flex';
        }
        var hideDelete<?php echo $row[0];?> = function() {
            popupDelete<?php echo $row[0];?>.style.display ='none';
        }

        popupMarkAsDone<?php echo $row[0];?> = document.querySelector('#markAsDoneWrapper<?php echo $row[5];?>');
  
        var showMarkAsDone<?php echo $row[0];?> = function() {
            popupMarkAsDone<?php echo $row[0];?>.style.display ='flex';
        }
        var hideMarkAsDone<?php echo $row[0];?> = function() {
            popupMarkAsDone<?php echo $row[0];?>.style.display ='none';
        }
      </script>

    <?php
    endwhile;
      }
    ?>
    <!--Sidebar-->
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
              <a href="#event_menu" class="menu_btn active">
                <i class="bx bx-calendar-edit"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Events
                  <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
              </a>
              <ul class="sub_list">
                <li class="sub-item">
                  <a href="EVE-admin-list-of-events.php" class="sub-active">
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
              <a href="P&J-admin-formPJ.php">
                <i class="bx bx-group"></i>
                <span class="link_name">Judges & <br> Participants</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!--Page Content-->
    <section class="home-section">
      <div class="container-fluid d-flex row justify-content-center m-0" id="event-wrapper">
        <?php
          $row = mysqli_num_rows($event_result2);
          if ($row > 0){
            ?>
              <div class="row d-flex justify-content-between align-items-center w-100">
                <div class="header col-7">List of Events</div>
                <div class="button-container col-5">
                  <a href="EVE-admin-create-event.php?add new event">
                    <button class="primary-button icon-button" id="create-event-btn"><i class='bx bx-add-to-queue'></i></button>
                  </a>
                  <button class="secondary-button icon-button" id="edit-event-btn"><i class='bx bx-edit'></i></button>
                </div>
              </div>
            <?php
            while ($row = mysqli_fetch_array($event_data2)):;?>
            <div class="element">
              <div class="row">
                <div class="element-group col-sm-6 col-lg-3">
                  <p class="element-label">Event</p>
                  <p class="element-content"><?php echo $row[1];?></p>
                </div>
                <div class="element-group col-sm-6 col-lg-3">
                  <p class="element-label">Event Type</p>
                  <p class="element-content"><?php echo $row[2];?></p>
                </div>
                <div class="element-group col-sm-6 col-lg-3">
                  <p class="element-label">Category</p>
                  <p class="element-content"><?php echo $row[3];?></p>
                </div>
                <div class="element-group col-sm-6 col-lg-3">
                  <p class="element-label">Date & Time</p>
                  <p class="element-content"><?php 
                  $date_sql = "SELECT DATE_FORMAT('$row[6]', '%M %d, %Y') AS formattedDate FROM listofeventtb;";
                  $date_result = mysqli_query($dbname, $date_sql);
                  $get_date_result = mysqli_fetch_assoc($date_result);
                  $date = $get_date_result['formattedDate'];

                  $time_sql = "SELECT TIME_FORMAT('$row[7]', '%h:%i %p') AS formattedTime FROM listofeventtb;";
                  $time_result = mysqli_query($dbname, $time_sql);
                  $get_time_result = mysqli_fetch_assoc($time_result);
                  $time = $get_time_result['formattedTime'];
                  echo $date;?>; <?php echo $time;?></p>
                </div>
              </div>
              <div class="row">
                <div class="element-group col-sm-6 col-lg-6">
                  <p class="element-label">Event Desciption</p>
                  <p class="element-content"><?php echo $row[4];?></p>
                </div>
                <div class="element-group col-sm-6 col-lg-2">
                  <p class="element-label">Code 
                    <i class='bx bx-copy' onclick="copyCode<?php echo $row[0];?>(this)" data-placement="bottom" title="Copy">
                      
                    </i> 
                    <i class='bx bx-hide' id="revealCode<?php echo $row[0];?>"></i>
                  </p>
                  <p class="element-content-secured" id="eventCode<?php echo $row[0];?>"><?php echo $row[5];?></p>
                </div>
                <div class="element-group col-sm-12 col-lg-4" id="eventBtn">
                  <button class="success-button justify-self-end event-done-btn<?php echo $row[0];?>" onclick="showMarkAsDone<?php echo $row[0];?>()">Mark as Done</button>
                  <div class="button-container more-btn<?php echo $row[0];?>" id="more-btn">
                    <a href="EVE-admin-edit-event.php?eec=<?php echo $row[5]?>">
                      <button class="primary-button justify-self-end" id="event-edit-btn"><i class='bx bx-edit-alt'></i>Edit Event</button>
                    </a>
                    <button class="danger-button icon-button" id="event-delete-btn" onclick="showDelete<?php echo $row[0];?>()"><i class='bx bx-trash'></i></button>
                  </div>
                  <script>
                    const moreBtn<?php echo $row[0];?> = document.querySelector(".more-btn<?php echo $row[0];?>");
                    const doneBtn<?php echo $row[0];?> = document.querySelector(".event-done-btn<?php echo $row[0];?>");

                    if (typeof(Storage) !== "undefined") {
                        // If we need to open the bar
                        if(localStorage.getItem("editEvent") == "active"){
                          moreBtn<?php echo $row[0];?>.classList.add("editOpen");
                          doneBtn<?php echo $row[0];?>.classList.add("doneClose");
                          document.querySelector("#edit-event-btn").classList.add("editOpen");
                        }
                        else if (localStorage.getItem("editEvent") == "notActive"){
                          moreBtn<?php echo $row[0];?>.classList.remove("editOpen");
                          doneBtn<?php echo $row[0];?>.classList.remove("doneClose"); 
                          document.querySelector("#edit-event-btn").classList.remove("editOpen");
                        }
                    }

                    const eventCode<?php echo $row[0];?> = document.querySelector("#eventCode<?php echo $row[0];?>");
                    const eye<?php echo $row[0];?> = document.querySelector("#revealCode<?php echo $row[0];?>");

                    function copyCode<?php echo $row[0];?>(element) {
                      // Show tooltip
                      $(element).attr('title', 'Copied');
                      $(element).tooltip('show');

                      // Hide tooltip after a delay
                      setTimeout(function() {
                        $(element).tooltip('hide');
                      }, 1500); // Adjust the delay as needed
                      var range = document.createRange();
                      eventCode<?php echo $row[0];?>.style.webkitTextSecurity = "none";
                      range.selectNode(eventCode<?php echo $row[0];?>);
                      window.getSelection().removeAllRanges(); // clear current selection
                      window.getSelection().addRange(range); // to select text
                      document.execCommand("copy");


                      if(eye<?php echo $row[0];?>.classList.contains("reveal")){
                        eventCode<?php echo $row[0];?>.style.webkitTextSecurity = "none";
                      }
                      else{
                        eventCode<?php echo $row[0];?>.style.webkitTextSecurity = "disc";
                      }

                      window.getSelection().removeAllRanges();// to deselect
                      $(element).removeAttr('data-toggle').removeAttr('title').off('mouseenter mouseleave');
                    }

                    eye<?php echo $row[0];?>.addEventListener("click", function(){
                        if(eye<?php echo $row[0];?>.classList.toggle("reveal")){
                          eye<?php echo $row[0];?>.classList.remove("bx-hide");
                          eye<?php echo $row[0];?>.classList.add("bx-show");
                          eventCode<?php echo $row[0];?>.style.webkitTextSecurity = "none";
                        }
                        else{
                          eye<?php echo $row[0];?>.classList.remove("bx-show");
                          eye<?php echo $row[0];?>.classList.add("bx-hide");
                          eventCode<?php echo $row[0];?>.style.webkitTextSecurity = "disc";
                        }
                    });

                  </script>
                </div>
              </div>
            </div>
        <?php
          endwhile; 
          }
          else{
            ?>
              <div class="header">List of Events</div>
              <div class="text-center" id="no-event-container">
                <i class='bx bx-calendar-x'></i>
                <h1>No Events</h1>
                <p>Looks like you have no events created. <br> You can do so by clicking the button below.</p>
                <div class="row justify-content-center">
                  <a href="EVE-admin-create-event.php?create new event">
                    <button class="primary-button" id="create-new-event-btn">
                      <i class='bx bx-add-to-queue d-flex justify-content-center align-items-center'></i>
                      Create an Event
                    </button>
                  </a>
                </div>
              </div>
            <?php
          }
        ?>
      </div>
    </section>
    <!-- Scripts -->
    <script src="./js/script.js"></script>
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

      $(document).ready(function() {
        // Initialize tooltips

      });
    </script>

    <!-- Event Config Scripts -->
    <script type="text/javascript" src="./js/EVE-admin-bootstrap4.bundle.min.js"></script>
    <script type="text/javascript" src="./js/EVE-admin-bootstrap-select.min.js"></script>
    <script type="text/javascript" src="./js/EVE-admin-bootstrap-select-picker.js"></script>
    <script type="text/javascript" src="./js/EVE-admin-list-of-events.js"></script>
    <script>

    </script>
  </body>

</html>