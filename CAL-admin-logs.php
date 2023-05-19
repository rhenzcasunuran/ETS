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
      <div class="header">Logs</div>
      <br>
      <br>
      <!-- Search Bar and Filter -->
      <div class="container">
        <div class="row">
          <div class="d-flex justify-content-between">
            <div class="input-group input-group-sm custom-search-bar">
              <input type="text" class="form-control" maxlength="50" style="height:50px;" placeholder="Search">
              <button class="btn btn-outline-primary" style="height:50px;" type="button">
                <i class="bx bx-search"></i>
              </button>
            </div>
            <div class="dropdown">
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
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="check-all-organization" checked>
                            <label class="form-check-label" for="check-all-organization">
                              All
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="ACAP" id="check-acap">
                            <label class="form-check-label" for="check-acap">
                              ACAP
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="AECES" id="check-aeces">
                            <label class="form-check-label" for="check-aeces">
                              AECES
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="ELITE" id="check-elite">
                            <label class="form-check-label" for="check-elite">
                              ELITE
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="GIVE" id="check-give">
                            <label class="form-check-label" for="check-give">
                              GIVE
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="JEHRA" id="check-jehra">
                            <label class="form-check-label" for="check-jehra">
                              JEHRA
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="JMAP" id="check-jmap">
                            <label class="form-check-label" for="check-jmap">
                              JMAP
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="JPIA" id="check-jpia">
                            <label class="form-check-label" for="check-jpia">
                              JPIA
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="PIIE" id="check-piie">
                            <label class="form-check-label" for="check-piie">
                              PIIE
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
            <input type="text" id="dateInput" pattern="(0[1-9]|1[0-2])/(0[1-9]|[12][0-9]|3[01])/\d{4}" placeholder="mm/dd/yyyy" maxlength="10" style="height:48px;">
          </div>
          <div id="dateError" style="color: red;"></div>
          <br>
          <br>
          <table class="table table-dark table-bordered">
            <caption>1-3 of 3</caption>
            <thead>
              <tr>
                <th scope="col" class="sortable-header" data-column="0">Date <i class="bx bx-chevron-up"></i></th> 
                <th scope="col" class="sortable-header" data-column="1">Time <i class="bx bx-chevron-up"></i></th>
                <th scope="col" class="sortable-header" data-column="2">Admin <i class="bx bx-chevron-up"></i></th>
                <th scope="col" class="sortable-header" data-column="3">Activity Description <i class="bx bx-chevron-up"></i></th>
                <th scope="col" class="sortable-header" data-column="4">Date Scheduled <i class="bx bx-chevron-up"></i></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">3/29/2023</th>
                <td>1:27 PM</td>
                <td>Admin 2</td>
                <td>Posted in Announcement</td>
                <td>4/20/2023</td>
              </tr>
              <tr>
                <th scope="row">3/29/2023</th>
                <td>1:20 PM</td>
                <td>Admin 1</td>
                <td>Added in Events</td>
                <td>5/16/2023</td>
              </tr>
              <tr>
                <th scope="row">3/29/2023</th>
                <td>1:20 PM</td>
                <td>Admin 3</td>
                <td>Posted in Announcement</td>
                <td>6/23/2023</td>
              </tr>
            </tbody>
          </table>
          <span class="small-button">
            <button type="button" class="btn btn-secondary btn-sm">
                &lt;
            </button>
            <button type="button" class="btn btn-secondary btn-sm">
              &gt;
            </button>
          <span>
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
    <!-- Table Sort JavaScript -->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const table = document.querySelector('.table');
        const headers = table.querySelectorAll('.sortable-header');
        let ascending = true; // Indicates the sorting direction

        headers.forEach(header => {
          header.addEventListener('click', () => {
            const column = header.dataset.column;
            const rows = Array.from(table.querySelectorAll('tbody tr'));

            rows.sort((rowA, rowB) => {
              const valueA = rowA.children[column].textContent.trim();
              const valueB = rowB.children[column].textContent.trim();

              // Compare the values based on the data type of the column
              if (isNaN(valueA) || isNaN(valueB)) {
                return valueA.localeCompare(valueB);
              } else {
                return Number(valueA) - Number(valueB);
              }
            });

            // Reverse the order if the same header is clicked again
            if (!ascending) {
              rows.reverse();
            }

            // Update the table with the sorted rows
            table.tBodies[0].append(...rows);

            // Toggle the sorting direction
            ascending = !ascending;

            // Update the sort icons in the header
            headers.forEach(header => {
              header.querySelector('i').classList.remove('bx-chevron-up', 'bx-chevron-down');
              if (header.dataset.column === column) {
                header.querySelector('i').classList.add(ascending ? 'bx-chevron-up' : 'bx-chevron-down');
              }
            });
          });
        });
      });
    </script>
    <script>
      const dateInput = document.getElementById('dateInput');
      const dateError = document.getElementById('dateError');

      dateInput.addEventListener('input', formatAndValidateDate);
      dateInput.addEventListener('keypress', restrictNonNumericInput);
      dateInput.addEventListener('blur', resetInputIfInvalid);

      function formatAndValidateDate() {
        let dateValue = dateInput.value;

        // Remove any non-numeric characters
        dateValue = dateValue.replace(/\D/g, '');

        // Apply the format mm/dd/yyyy
        if (dateValue.length > 2 && dateValue.charAt(2) !== '/') {
          dateValue = `${dateValue.slice(0, 2)}/${dateValue.slice(2)}`;
        }
        if (dateValue.length > 5 && dateValue.charAt(5) !== '/') {
          dateValue = `${dateValue.slice(0, 5)}/${dateValue.slice(5)}`;
        }

        // Update the input value
        dateInput.value = dateValue;

        // Validate the date
        validateDate();
      }

      function restrictNonNumericInput(event) {
        const key = event.which || event.keyCode;
        const char = String.fromCharCode(key);

        // Allow only numeric characters and backspace/delete
        if (!/[\d\b]/.test(char)) {
          event.preventDefault();
        }
      }

      function resetInputIfInvalid() {
        if (!dateInput.checkValidity()) {
          dateInput.value = '';
          dateError.textContent = '';
        }
      }

      function validateDate() {
        const dateValue = dateInput.value;

        // Regular expression pattern for mm/dd/yyyy format
        const datePattern = /^(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])\/\d{4}$/;

        if (datePattern.test(dateValue)) {
          const [month, day, year] = dateValue.split('/');

          // Validate the month (mm)
          const monthInt = parseInt(month, 10);
          if (monthInt < 1 || monthInt > 12) {
            // Invalid month
            dateInput.setCustomValidity('Invalid month');
            dateError.textContent = 'Invalid month';
            return;
          }

          // Validate the day (dd) based on the month
          const dayInt = parseInt(day, 10);
          if (dayInt < 1 || dayInt > getDaysInMonth(monthInt, year)) {
            // Invalid day
            dateInput.setCustomValidity('Invalid day');
            dateError.textContent = 'Invalid day';
            return;
          }

          // Create a Date object to validate the input as a valid date
          const inputDate = new Date(`${year}-${month}-${day}`);

          if (
            inputDate.getFullYear().toString() === year &&
            (inputDate.getMonth() + 1).toString().padStart(2, '0') === month &&
            inputDate.getDate().toString().padStart(2, '0') === day
          ) {
            // Valid date
            dateInput.setCustomValidity('');
            dateError.textContent = '';
          } else {
            // Invalid date
            dateInput.setCustomValidity('Invalid date');
            dateError.textContent = 'Invalid date';
          }
        } else {
          // Date format doesn't match mm/dd/yyyy
          dateInput.setCustomValidity('Invalid date format');
          dateError.textContent = 'Invalid date format';
        }
      }

      function getDaysInMonth(month, year) {
        // Returns the number of days in a month (accounts for leap years)
        return new Date(year, month, 0).getDate();
      }
    </script>
    <!--Logs JS-->
    <script src="./js/CAL-admin-logs.js"></script>
    <!--Popper JS-->
    <script src="./js/popper.min.js"></script>
    <!--Bootstrap JS-->
    <script src="./js/bootstrap.min.js"></script>
  </body>
</html>