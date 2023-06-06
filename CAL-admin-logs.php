<?php
  include './php/sign-in.php';
  include './php/database_connect.php';
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
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <!--Logs CSS-->
    <link rel="stylesheet" href="./css/CAL-logs.css">
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
              <a href="#"  class="menu_btn active">
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
                  <a href="CAL-admin-logs.php" class="sub-active">
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
    <section class="home-section">
      <div class="header">Activity Logs</div>
      <br>
      <br>
      <!-- Search Bar and Filter -->
      <div class="container">
        <div class="row">
          <div class="d-flex justify-content-start">
            <div class="input-group input-group-sm custom-search-bar p-2">
              <input type="text" class="form-control w-100" id="search-input" maxlength="50" style="height:50px;" placeholder="Search">
            </div>
            <!-- Filter Dropdown -->
            <div class="dropdown p-2">
              <button class="btn btn-light btn-lg dropdown-toggle" style="width: 200px;" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                Filters
              </button>
              <ul class="dropdown-menu" style="width: 200px;" aria-labelledby="dropdownMenuButton">
                <li>
                  <div class="accordion" id="organizationAccordion">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" data-bs-parent="#organizationAccordion">
                          Organization
                        </button>
                      </h2>
                      <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne">
                        <div class="accordion-body">
                          <div class="form-check org-type">
                            <input class="form-check-input" type="checkbox" value="" id="check-all-organization" checked>
                            <label class="form-check-label" for="check-all-organization">
                              <span class="pill-all">All</span>
                            </label>
                          </div>
                          <div class="form-check org-type">
                            <input class="form-check-input" type="checkbox" value="ACAP" id="check-acap">
                            <label class="form-check-label" for="check-acap">
                              <span class="pill-acap">ACAP</span>
                            </label>
                          </div>
                          <div class="form-check org-type">
                            <input class="form-check-input" type="checkbox" value="AECES" id="check-aeces">
                            <label class="form-check-label" for="check-aeces">
                              <span class="pill-aeces">AECES</span>
                            </label>
                          </div>
                          <div class="form-check org-type">
                            <input class="form-check-input" type="checkbox" value="ELITE" id="check-elite">
                            <label class="form-check-label" for="check-elite">
                              <span class="pill-elite">ELITE</span>
                            </label>
                          </div>
                          <div class="form-check org-type">
                            <input class="form-check-input" type="checkbox" value="GIVE" id="check-give">
                            <label class="form-check-label" for="check-give">
                              <span class="pill-give">GIVE</span>
                            </label>
                          </div>
                          <div class="form-check org-type">
                            <input class="form-check-input" type="checkbox" value="JEHRA" id="check-jehra">
                            <label class="form-check-label" for="check-jehra">
                              <span class="pill-jehra">JEHRA</span>
                            </label>
                          </div>
                          <div class="form-check org-type">
                            <input class="form-check-input" type="checkbox" value="JMAP" id="check-jmap">
                            <label class="form-check-label" for="check-jmap">
                              <span class="pill-jmap">JMAP</span>
                            </label>
                          </div>
                          <div class="form-check org-type">
                            <input class="form-check-input" type="checkbox" value="JPIA" id="check-jpia">
                            <label class="form-check-label" for="check-jpia">
                              <span class="pill-jpia">JPIA</span>
                            </label>
                          </div>
                          <div class="form-check org-type">
                            <input class="form-check-input" type="checkbox" value="PIIE" id="check-piie">
                            <label class="form-check-label" for="check-piie">
                              <span class="pill-piie">PIIE</span>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="accordion" id="adminAccordion">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree" data-bs-parent="#adminAccordion">
                          Admin
                        </button>
                      </h2>
                      <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree">
                        <div class="accordion-body">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="check-all-admin" checked>
                            <label class="form-check-label" for="check-all-admin">
                              All
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Admin 1" id="check-admin-one">
                            <label class="form-check-label" for="check-admin-one">
                              Admin 1
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Admin 2" id="check-admin-two">
                            <label class="form-check-label" for="check-admin-two">
                              Admin 2
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Admin 3" id="check-admin-three">
                            <label class="form-check-label" for="check-admin-three">
                              Admin 3
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="calendar-input-container p-2">
              <input type="text" id="dateInput" pattern="(0[1-9]|1[0-2])/(0[1-9]|[12][0-9]|3[01])/\d{4}" placeholder="mm/dd/yyyy" maxlength="10" style="height:48px;">
              <i class="bx bx-calendar-event" id="calendar-icon"></i>
            </div>
          </div>
          <div id="miniCalendar">
            <div class="mini-calendar-header">
              <button id="miniPreviousButton" class="previous-button"><i class='bx bxs-left-arrow'></i></button>
              <h2 id="miniCalendarHeader"></h2>
              <button id="miniNextButton" class="next-button"><i class='bx bxs-right-arrow'></i></button>
            </div>
            <table id="miniCalendarTable"></table>
          </div>
          <br>
          <br>
          <table class="table table-dark table-bordered">
            <thead>
              <tr>
                <th scope="col" class="sortable" data-column="log_id">ID <span id="sort-indicator-log_id"></span></th>
                <th scope="col" class="sortable" data-column="log_date">Date <span id="sort-indicator-log_date"></span></th>
                <th scope="col" class="sortable" data-column="log_time">Time <span id="sort-indicator-log_time"></span></th>
                <th scope="col" class="sortable" data-column="admin">Admin <span id="sort-indicator-admin"></span></th>
                <th scope="col" class="sortable" data-column="activity_description">Activity Description <span id="sort-indicator-activity_description"></span></th>
              </tr>
            </thead>
            <tbody id="log-table-body">
              <tr id="no-results-row" style="display: none;">
                <td colspan="5">No results to display</td>
              </tr>
            </tbody>
          </table>
          <div class="d-flex justify-content-end">
            <div class="text-muted p-1 me-2" id="pagination-info"></div>
            <div>
              <button type="button" class="btn btn-secondary btn-sm" id="btn-prev" disabled>
                &lt; 
              </button>
              <button type="button" class="btn btn-secondary btn-sm" id="btn-next">
                &gt;
              </button>
            </div>
          </div>
        </div>
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
    <!--Logs JS-->
    <script src="./js/CAL-admin-logs.js"></script>
    <!--Popper JS-->
    <script src="./js/popper.min.js"></script>
    <!--Bootstrap JS-->
    <script src="./js/bootstrap.min.js"></script>
  </body>
</html>