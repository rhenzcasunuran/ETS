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
    <div class="container-fluid popup-wrapper-delete<?php echo $row[5];?>" id="popup-wrapper-delete">
      <div id="confirm-cancel" class="row">
        <div class="col-5 text-center">
          <i class='bx bxs-error popup-icon' id="error-icon"></i>
        </div>
        <div class="col-7" id="text-confirm">
          <h3 class="bold">Delete Event?</h3>
          <p>This action cannot be undone.</p>
        </div>
        <div class="row flex-column flex-md-row d-flex align-items-center">
          <button class="btn btn-confirm content-box-shadow" id="btn-return" onclick="hide<?php echo $row[0];?>()"><i class='bx bx-x'></i><span>Cancel</span></button>
          <a href="EVE-admin-list-of-events.php?eed=<?php echo $row[5]?>">
            <button class="btn btn-danger btn-confirm content-box-shadow"><i class='bx bx-trash' ></i><span>Delete</span></button>
          </a> 
        </div>
      </div>
    </div>
    <div class="container-fluid popup-wrapper-done<?php echo $row[5];?>" id="popup-wrapper-done">
      <div id="confirm-cancel" class="row">
        <div class="col-5 text-center">
          <i class='bx bxs-check-circle popup-icon' id="success-icon"></i>
        </div>
        <div class="col-7" id="text-confirm">
          <h3 class="bold">Mark as Done?</h3>
          <p>Marked events will be removed from events list.</p>
        </div>
        <div class="row flex-column flex-md-row d-flex align-items-center">
          <button class="btn btn-confirm content-box-shadow" id="btn-return" onclick="hideDone<?php echo $row[0];?>()"><i class='bx bx-x'></i><span>Cancel</span></button>
          <a href="#event-done">
            <button class="btn btn-success btn-confirm content-box-shadow"><i class='bx bx-check' ></i><span>Confirm</span></button>
          </a> 
        </div>
      </div>
    </div>  
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
              <div class="d-flex justify-content-between align-items-center pr-4 w-100">
                <div class="header">List of Events</div>
                <a href="EVE-admin-create-event.php?add event">
                  <button class="btn btn-danger text-center" id="add-event-btn">
                    <i class='bx bx-add-to-queue d-flex justify-content-center align-items-center'>
                      <span>Add Event</span>
                    </i>
                  </button>
                </a>
                <div class="btn btn-warning d-flex justify-content-center align-items-center badge-pill" id="edit-event-btn">
                  <i class='bx bx-edit text-white'></i>
                </div>
              </div>
            <?php
            while ($row = mysqli_fetch_array($event_data2)):;?>
            <div class="justify-content-start align-items-start content-box-shadow" id="event-data-container">
              <div class="row flex-column flex-sm-row">
                <div class="data-group col-md-6 col-lg-3">
                  <p class="data-label fw-bold">Event</p>
                  <p class="data-content fw-bold"><?php echo $row[1];?></p>
                </div>
                <div class="data-group col-md-6 col-lg-3">
                  <p class="data-label fw-bold">Event Type</p>
                  <p class="data-content fw-bold"><?php echo $row[2];?></p>
                </div>
                <div class="data-group col-md-6 col-lg-3">
                  <p class="data-label fw-bold">Category</p>
                  <p class="data-content fw-bold"><?php echo $row[3];?></p>
                </div>
                <div class="data-group col-md-6 col-lg-3">
                  <p class="data-label fw-bold">Date and Time</p>
                  <p class="data-content fw-bold"><?php 
                  $time_sql = "SELECT TIME_FORMAT('$row[7]', '%h:%i %p') AS formattedTime FROM listofeventtb;";
                  $time_result = mysqli_query($dbname, $time_sql);
                  $get_time_result = mysqli_fetch_assoc($time_result);
                  $time = $get_time_result['formattedTime'];
                  echo $row[6];?>, <?php echo $time;?></p>
                </div>
              </div>
              <br>
              <div class="row flex-column flex-md-row">
                <div class="data-group col-md-6">
                  <p class="data-label fw-bold">Event Desciption</p>
                  <p class="data-content fw-bold description"><?php echo $row[4];?></p>
                </div>
                <div class="data-group col-md-3">
                  <p class="data-label fw-bold">Code</p>
                  <p class="data-content fw-bold"><?php echo $row[5];?></p>
                </div>
                <div class="data-group col-md-12" id="eventBtn">
                  <button class="btn event-done-btn<?php echo $row[0];?>" id="event-done-btn"  onclick="showDone<?php echo $row[0];?>()">Mark as Done</button>
                  <div class="more-btn<?php echo $row[0];?>" id="more-btn">
                    <a href="EVE-admin-edit-event.php?eec=<?php echo $row[5]?>">
                      <button class="btn btn-warning text-white badge-pill" id="event-edit-btn">Edit Event</button>
                    </a>
                      <button class="btn btn-danger text-white badge-pill" id="event-delete-btn" onclick="show<?php echo $row[0];?>()">
                        <i class='bx bx-trash'></i>
                      </button>
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
                  </script>
                  <script type="text/javascript" src="./js/EVE-admin-edit-button-state.js"></script>
                </div>
              </div>
            </div>
            
            <script>
            popupCancel<?php echo $row[0];?> = document.querySelector('.popup-wrapper-delete<?php echo $row[5];?>');
        
            var show<?php echo $row[0];?> = function() {
                popupCancel<?php echo $row[0];?>.style.display ='flex';
            }
            var hide<?php echo $row[0];?> = function() {
                popupCancel<?php echo $row[0];?>.style.display ='none';
            }

            popupDone<?php echo $row[0];?> = document.querySelector('.popup-wrapper-done<?php echo $row[5];?>');
        
            var showDone<?php echo $row[0];?> = function() {
                popupDone<?php echo $row[0];?>.style.display ='flex';
            }
            var hideDone<?php echo $row[0];?> = function() {
                popupDone<?php echo $row[0];?>.style.display ='none';
            }
          </script>
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
                  <a href="EVE-admin-create-event.php?create new event" class="btn btn-danger badge-pill text-center" id="create-event-btn">
                    <i class='bx bx-add-to-queue d-flex justify-content-center align-items-center'>
                      <span>Create an Event</span>
                    </i>
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