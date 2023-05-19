<?php
  include './php/sign-in.php';
  include './php/database_connect.php';
  include './php/HOM-create-post.php';
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
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/BAR-obg.css">
    <script src="./js/BAR-java.js"></script>
  </head>

  <body>
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
              <a href="BAR-admin.php" class="menu_btn active">
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

      <div class="container-fluid" id="body-content">

        <div class="row" id="switches">
          <div class="col" id="toggle-container">
            <div class="anon">
              <label class="switch">
                <input type="checkbox" id="anon_button">
                <span class="slider"></span>
                <div class="row" id="anon-label">Show&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hide</div>
              </label>
            </div>
          </div>
  
          <div class="col" id="add-container">
            <div class="add">Add Org Photo</div>
          </div>
        </div>

        <div class="col" id="graph-section">
          <div class="graph_container">
            <div class="row" id="arrow-container">
              <div class="arrow">
                <i class="bx bx-arrow-to-left" id="arrow-btn"></i>
              </div>
            </div>
            <div class="row">
              <div class="col" id="rank_container">
                <div class="row" id="logos">
                  <div class="logo_container"><img src="logos\ACAP.png" alt="" class="logos" name="acap"></div>
                </div>
                <div class="row" id="logos">
                  <div class="logo_container"><img src="logos\aeces.png" alt="" class="logos" name="aeces"></div>
                </div>
                <div class="row" id="logos">
                  <div class="logo_container"><img src="logos\elite.png" alt="" class="logos" name="elite"></div>
                </div>
                <div class="row" id="logos">
                  <div class="logo_container"><img src="logos\give.png" alt="" class="logos" name="give"></div>
                </div>
                <div class="row" id="logos">
                  <div class="logo_container"><img src="logos\jehra.png" alt="" class="logos" name="jehra"></div>
                </div>
                <div class="row" id="logos">
                  <div class="logo_container"><img src="logos\jmap.png" alt="" class="logos" name="jmap"></div>
                </div>
                <div class="row" id="logos">
                  <div class="logo_container"><img src="logos\jpia.png" alt="" class="logos" name="jpia"></div>
                </div>
                <div class="row" id="logos">
                  <div class="logo_container"><img src="logos\piie.png" alt="" class="logos" name="piie"></div>
                </div>
              </div>
              <div class="col-11">
                <div class="row">
                  <div class="meter_container">
                    <div class="meter" id="acap_bar" name="acap"></div>
                  </div>
                </div>
                <div class="row">
                  <div class="meter_container">
                    <div class="meter" id="aeces_bar" name="aeces"></div>
                  </div>
                </div>
                <div class="row">
                  <div class="meter_container">
                    <div class="meter" id="elite_bar" name="elite"></div>
                  </div>
                </div>
                <div class="row">
                  <div class="meter_container">
                    <div class="meter" id="give_bar" name="give"></div>
                  </div>
                </div>
                <div class="row">
                  <div class="meter_container">
                    <div class="meter" id="jehra_bar" name="jehra"></div>
                  </div>
                </div>
                <div class="row">
                  <div class="meter_container">
                    <div class="meter" id="jmap_bar" name="jmap"></div>
                  </div>
                </div>
                <div class="row">
                  <div class="meter_container">
                    <div class="meter" id="jpia_bar" name="jpia"></div>
                  </div>
                </div>
                <div class="row">
                  <div class="meter_container">
                    <div class="meter" id="piie_bar" name="piie"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col" id="org-profile">
            <div class="col" id="org-body">
              <div class="row" id="org-content">
                <div class="col-2">
                  <div class="profile-logo-container">
                    <img src="" alt="" class="profile-logo" id="profile-logo">
                  </div>
                </div>
                <div class="col">
                  <div class="profile-name-container">
                    <label class="profile-name" id="profile-name"></label>
                  </div>
                </div>
              </div>
              <div class="row" id="org-window">
                <div class="col-4" id="winnings-container">
                  <div class="winnings">
                    
                  </div>
                </div>
                <div class="col" id="org-photo-container">
                  <div class="org-photo">
                    <img src="" alt="" class="org-photo-image">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
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
  </body>
</html>