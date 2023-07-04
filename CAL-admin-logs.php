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
    <title>Activity Logs</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="./css/theme-mode.css">
    <script src="./js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <link rel="stylesheet" href="./css/system-wide.css">
    <!--Logs CSS-->
    <link rel="stylesheet" href="./css/CAL-logs.css">
  </head>

  <body>
   
    <?php
      // Set the active module and sub-active sub-item variables
      $activeModule = 'activity-logs';

      // Include the sidebar template
      require './php/admin-sidebar.php';
    ?>
    <section class="home-section">
      <div class="header">Activity Logs</div>
      <!-- Search Bar and Filter -->
      <div class="container">
        <div class="row">
          <div class="d-flex flex-wrap input-group justify-content-start p-2">
            <div class="search-input-container p-2">
              <input type="text" class="form-control custom-search-bar w-100" id="search-input" maxlength="50" placeholder="Search" style="height:49px;">
              <i class='bx bx-search' id="search-icon"></i>
            </div>
            <!-- Filter Dropdown -->
            <div class="dropdown p-2">
              <button class="btn btn-light btn-lg dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                Filters
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li>
                  <div class="accordion" id="adminAccordion">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree" data-bs-parent="#adminAccordion">
                          Admin
                        </button>
                      </h2>
                      <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree">
                        <div class="accordion-body" id="adminCheckboxes">
                          <!-- Admin checkboxes will be dynamically generated here -->
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="calendar-input-container p-2">
              <input type="text" id="dateInput" pattern="(0[1-9]|1[0-2])/(0[1-9]|[12][0-9]|3[01])/\d{4}" placeholder="mm/dd/yyyy" maxlength="10" style="height:49px;">
              <i class="bx bx-calendar-event" id="calendar-icon"></i>
            </div>
            <div class="div" id="miniCalendarContainer" style="display: none;">
            <div class="element" id="calendarElement">
              <div class="row">
                <div id="miniCalendarMain">
                  <div class="d-flex justify-content-between">
                    <h5 id="miniCalendarHeader"></h5>
                    <div id="miniButtonContainer">
                      <i id="miniPreviousButton" class='bx bxs-chevron-left'></i>
                      <i id="miniNextButton" class='bx bxs-chevron-right'></i>
                    </div>
                  </div>
                  <br>
                  <table id="miniCalendar">
                    <thead id="miniCalendarThead">
                      <tr>
                        <th scope="col">SU</th>
                        <th scope="col">M</th>
                        <th scope="col">TU</th>
                        <th scope="col">W</th>
                        <th scope="col">TH</th>
                        <th scope="col">F</th>
                        <th scope="col">SA</th>
                      </tr>
                    </thead>
                    <tbody id="miniCalendarTable">
                    </tbody>
                  </table>
                  <br>
                </div>
              </div>
              <div class="div">
                <button id="clearButton" class="outline-button p-3">Clear</button>
                <button id="todayButton" class="primary-button p-3">Today</button>
              </div>
            </div>
          </div>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-borderless table-hover text-center">
              <thead class="table-dark">
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
              <div class="p-1 me-2" id="pagination-info"></div>
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