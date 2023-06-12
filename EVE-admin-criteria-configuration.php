<?php
  include './php/sign-in.php';
  include './php/database_connect.php';
  include './php/EVE-admin-criteria-get-category.php';
  include './php/EVE-admin-criteria.php';
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criteria Configuration</title>
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
    <link rel="stylesheet" href="./css/EVE-admin-create-add-event.css">
    <link rel="stylesheet" href="./css/EVE-admin-criteria-config.css"> 
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
              <a href="#event_menu" class="menu_btn active">
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
                  <a href="#criteria_config" class="sub-active">
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
        <div class="header">Criteria Configuration</div>
        <div class="container-fluid d-flex justify-content-center align-items-start m-0" id="criteriaConfigWrapper">
            <div class="element">
                <div class="upper-element">
                    <h3>Criteria</h3>
                    <div class="div align-items-center">
                      <p>Category</p>
                      <select name="categoryPicker" class="form-select selectpicker" id="categoryPicker" data-live-search="true">
                        <?php 
                        $row = mysqli_num_rows($categoryName);
                        if ($row > 0) {
                          while($row = mysqli_fetch_array($categoryName)):;?>
                            <option value="<?php echo $row[0]; ?>">
                              <?php echo $row[3]; ?>
                            </option>
                        <?php endwhile; 
                        }
                      ?>
                      </select>
                    </div>
                </div>
                <form action="" method="POST" autocomplete="off" id="criteriaForm">
                  <input type="hidden" name="categoryPickerValue" id="categoryPickerValue">
                    <div class="middle-element flex-column">
                      <div id="criterionData" class="flex-column"></div>
                      <div id="criterionForm" class="flex-column">
                        <div id="criterionField" class="row form-fields"></div>
                      </div>
                        <div class="outline-button" id="addCriterion"><i class='bx bx-plus'></i></div>
                    </div>
                    <div class="lower-element">
                        <div class="row my-3">
                            <div class="col-9">
                                <p>Total</p>
                            </div>
                            <div class="col-3" id="totalPercentage">
                                <p>0%</p>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-end">
                            <button type="submit" class="primary-button mx-2" name="criteriaSaveBtn" id="criteriaSaveBtn" disabled>
                            <div class="tooltip-popup flex-column" id="tooltip">
                              <div class="tooltipText" id="textCriterionName">All Criterion Name has value<i class='bx bx-check' id="checkCriterionName"></i></div>
                              <div class="tooltipText" id="textPercentage">All Percentage has value<i class='bx bx-check' id="checkPercentage"></i></div>
                              <div class="tooltipText" id="textTotalPercentage">Total Percentage is equal to 100%<i class='bx bx-check' id="checkTotalPercentage"></i></div>
                            </div>  
                            Save
                          </button>
                            <div class="outline-button">Cancel</div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </section>
    <!-- Scripts -->
    <script type="text/javascript" src="./js/script.js"></script>
    <script type="text/javascript" src="./js/jquery-3.6.4.js"></script>
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
    <script type="text/javascript" src="./js/EVE-admin-add-more.js"></script>
    <script type="text/javascript" src="./js/EVE-admin-disable-criteria-button.js"></script>
    
    <script>

        $(document).ready(function() {
            // Initial data fetch based on categoryPicker value
            fetchCategoryData($('#categoryPicker').val());
        });

        $('#categoryPicker').change(function() {
            // Fetch data based on changed categoryPicker value
            var selectedCategory = $(this).val();
            fetchCategoryData(selectedCategory);
        });

        function fetchCategoryData(category) {
            $.ajax({
                url: './php/EVE-admin-fetch-criterion.php',
                method: 'POST',
                data: { category: category },
                success: function(response) {
                    // Replace the form section with updated data
                    $('#criterionData').html(response);
                    updateTotalPercentage();
                }
            });
        }

      $('#criteriaForm').submit(function(e){
        e.preventDefault();
        $('#criteriaSaveBtn').val('Saving...');
        $('#categoryPickerValue').val($('#categoryPicker').val());
        $.ajax({
          url: './php/EVE-admin-add-to-criteria.php',
          method: 'POST',
          data: $(this).serialize(),
          success: function(response) {
            $('#criteriaSaveBtn').val('Save');
            $('#criteriaForm')[0].reset();
            $('.appended').remove();

            var selectedCategory = $('#categoryPicker').val();
            fetchCategoryData(selectedCategory);
            updateTotalPercentage();
          }
        })
      })

      $(document).on('input', 'input[name="percentage[]"]', function() {
          // Update the total percentage when any input value changes
          updateTotalPercentage();
      });

      $(document).on('input', 'input[name="criterion[]"]', function() {
          // Update the total percentage when any input value changes
          updateTotalPercentage();
      });

      function deleteCriterion(criterionId) {
        $.ajax({
          url: './php/EVE-admin-criteria.php',
          method: 'POST',
          data: { criterionId: criterionId },
          success: function(response) {
            // Refresh the criterion data without reloading the page
            var selectedCategory = $('#categoryPicker').val();
            fetchCategoryData(selectedCategory);
          }
        });
    }

    $(document).ready(function(){
        $('.selectpicker').selectpicker();
        $('.bs-searchbox input').attr('maxlength', '25');

        $('input').keypress(function (e) {
          var txt = String.fromCharCode(e.which);
          if (!txt.match(/[A-Za-z0-9 ]/)) {
              return false;
          }
        });

        $('input').on('input', function(e) {
          $(this).val(function(i, v) {
            return v.replace(/[^\w\s]|_/gi, '');
          });
        });
      });
    </script>
  </body>
</html>