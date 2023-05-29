<?php
  include './php/sign-in.php';
  include './php/database_connect.php';
  include './php/EVE-admin-event-config-data.php';
  include './php/EVE-admin-event-config-get-data.php';
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Configuration</title>
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
    <link rel="stylesheet" href="./css/EVE-admin-event-config.css">
    <link rel="stylesheet" href="./css/EVE-admin-confirmation.css">
    <link rel="stylesheet" href="./css/EVE-admin-create-add-event.css">
  </head>

  <body>
    <?php
      $row = mysqli_num_rows($eventName2);
      if ($row > 0){
        while ($row = mysqli_fetch_array($eventName2)):;
    ?>
      <div class="popup-background popup-wrapper-delete-name<?php echo $row[0];?>" id="deleteWrapper">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-error prompt-icon danger-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Delete <?php echo $row[1];?>?</h3>   <!--header-->
                <p>This action cannot be undone. All related categories will also be deleted</p> <!--text-->
            </div>
            <div  class="div">
                <button class="outline-button" onclick="hide<?php echo $row[0];?>()"><i class='bx bx-x'></i>Cancel</button>
                <a href="EVE-admin-event-configuration.php?eventNameId=<?php echo $row[0]?>">
                  <button class="danger-button"><i class='bx bx-trash'></i>Delete</button>
                </a>
            </div>
        </div>
      </div>
    <?php
    endwhile;
      }
    ?>
    <?php
      $row = mysqli_num_rows($categoryName2);
      if ($row > 0){
        while ($row = mysqli_fetch_array($categoryName2)):;
    ?>
      <div class="popup-background popup-wrapper-delete-category-name<?php echo $row[0];?>" id="deleteWrapper">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-error prompt-icon danger-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Delete <?php echo $row[3];?>?</h3>   <!--header-->
                <p>This action cannot be undone.</p> <!--text-->
            </div>
            <div  class="div">
                <button class="outline-button" onclick="hide<?php echo $row[0];?>()"><i class='bx bx-x'></i>Cancel</button>
                <a href="EVE-admin-event-configuration.php?categoryNameId=<?php echo $row[0]?>">
                  <button class="danger-button"><i class='bx bx-trash'></i>Delete</button>
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
                  <a href="EVE-admin-list-of-events.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">List of Events</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="EVE-admin-event-configuration.php" class="sub-active">
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
      <div class="header">Event Configuration</div>
      <div class="container-fluid d-flex flex-column flex-md-row" id="configWrapper">
        <div class="element config-container d-flex flex-md-column col-md-6 justify-content-center align-items-center">
          <div class="event-name-config-container row flex-column d-flex justify-content-center content-box-shadow align-self-center">
            <div class="d-flex justify-content-center position-relative h-config">
              <div class="container position-absolute h-100">
                <div class="h3 text-center">Event</div>
                <form autocomplete="off" class="d-flex flex-column" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                  <div class="form-group">
                    <label for="inputEventName" class="fs-6">Event <span class="req">*</span> </label>
                    <input type="text" class="form-control" id="inputEventName" placeholder="Enter Event Name" name="inputEventName" minlength="5" maxlength="25" required>       
                    <div class="text-danger d-flex w-100 justify-content-center" id="checkEventName"><?php if(isset($error['eventName'])) echo $error['eventName']?></div>  
                  </div>
                  <div class="button-container config-button row">
                    <button type="submit" class="primary-button col-6" id="eventSaveBtn" name="eventSaveBtn" disabled>
                      <div class="tooltip-popup flex-column" id="tooltipEvent">
                        <div class="tooltipText" id="textEventName">Event (5 or more char)<i class='bx bx-check' id="checkEventName"></i></div>
                      </div>
                      Save
                    </button>
                    <div class="outline-button col-6" id="eventClearBtn" name="eventClearBtn" onclick="clearFormEvent('inputEventName', 'eventSaveBtn')">Clear</div>
                  </div>  
                </form>
              </div>
            </div>
            <div class="d-flex justify-content-center position-relative h-data">
              <div class="d-flex container position-absolute h-100 flex-column">
                <i class='bx bx-search icon'></i>
                <input type="text" id="eventNameData" class="form-control my-2" placeholder="Search..." onkeyUp="eventNameSearch()">
                <div class="event-name-data-container">
                  <table id="eventNameTable">
                    <?php
                      $row = mysqli_num_rows($eventName);
                      if ($row > 0) {
                        while($result = mysqli_fetch_array($eventName)):;
                    ?>
                    <tr id="eventNameDataTable">
                      <td class="d-flex justify-content-between px-4">
                        <?php echo $result[1]; ?> 
                          <i class='bx bx-x align-self-center color-red' name="eventNameDataDeleteBtn" onclick="show<?php echo $result[0];?>()"></i>
                      </td>
                    </tr>
                    <script>
                      popupDeleteEventName<?php echo $result[0];?> = document.querySelector('.popup-wrapper-delete-name<?php echo $result[0];?>');
                  
                      var show<?php echo $result[0];?> = function() {
                          popupDeleteEventName<?php echo $result[0];?>.style.display ='flex';
                      }
                      var hide<?php echo $result[0];?> = function() {
                          popupDeleteEventName<?php echo $result[0];?>.style.display ='none';
                      }
                    </script>
                    <?php endwhile; 
                      }
                      else{
                    ?>
                    <div id="noDataCat">
                      <div class="d-flex px-4">
                        There is NO Event Data...
                      </div>
                    </div>
                    <?php
                      }
                    ?>
                    <div id="noResultEve">
                      <div class="d-flex justify-content-center px-4">
                        No results found...
                      </div>
                    </div>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="element config-container d-flex flex-md-column col-md-6 justify-content-center align-items-center">
          <div class="category-name-config-container row flex-column d-flex justify-content-center content-box-shadow align-self-center">
            <div class="d-flex justify-content-center position-relative h-config">
              <div class="container position-absolute h-100">
                <div class="h3 text-center">Category</div>
                <form autocomplete="off" class="d-flex flex-column" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                  <div class="element-group">
                  <div class="form-group">
                    <label for="selectEventName" class="fs-6">Event <span class="req">*</span></label>
                    <select name="selectEventName" id="selectEventName" title="Select Event Name" class="form-control selectpicker" data-live-search="true" required>
                      <option value="" selected>Select Event Name</option>
                      <?php 
                      $row = mysqli_num_rows($eventName);
                      if ($row > 0) {
                      while($row = mysqli_fetch_array($selectEventName)):;?>
                      <option value="<?php echo $row[0]; ?>">
                        <?php echo $row[1]; ?>
                      </option>
                      <?php endwhile; 
                      }
                      else{
                    ?>
                      <option disabled class="noEventNameData">
                        
                      </option>
                    <?php
                      }
                    ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="selectEventType" class="fs-6">Event Type <span class="req">*</span></label>
                    <select name="selectEventType" id="selectEventType" title="Select Event Type" class="form-control selectpicker" required>
                      <option value="" selected>Select Event Type</option>
                      <?php 
                      $row = mysqli_num_rows($eventType);
                      if ($row > 0) {
                      while($row = mysqli_fetch_array($eventType)):;?>
                      <option value="<?php echo $row[0]; ?>">
                        <?php echo $row[1]; ?>
                      </option>
                      <?php endwhile; 
                      }
                      else{
                    ?>
                      <option disabled class="noEventTypeData">
                        No event type found...
                      </option>
                    <?php
                      }
                    ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="inputCategoryName" class="fs-6">Category <span class="req">*</span></label>
                    <input type="text" class="form-control" id="inputCategoryName" placeholder="Enter Category Name" name="inputCategoryName" minlength="5" maxlength="25" required>
                    <div class="text-danger d-flex w-100 justify-content-center" id="checkCategoryName"><?php if(isset($error['categoryName'])) echo $error['categoryName']?></div>
                  </div>
                  </div>
                  <div class="button-container config-button row">
                    <button type="submit" class="primary-button col-6" id="categorySaveBtn" name="categorySaveBtn" disabled>
                      <div class="tooltip-popup flex-column" id="tooltipCategory">
                        <div class="tooltipText" id="selectEvent">Event<i class='bx bx-check' id="checkSelectEvent"></i></div>
                        <div class="tooltipText" id="selectType">Event Type<i class='bx bx-check' id="checkSelectType"></i></div>
                        <div class="tooltipText" id="textCategory">Category Name<i class='bx bx-check' id="checkCategory"></i></div>
                      </div>
                    Save
                    </button>
                    <div class="outline-button col-6" id="categoryClearBtn" name="categoryClearBtn" onclick="clearFormCategory('inputCategoryName', 'categorySaveBtn')">Clear</div>
                  </div>  
                </form>
              </div>
            </div>
            <div class="d-flex justify-content-center position-relative h-data">
                <div class="container position-absolute h-100 flex-column">
                  <i class='bx bx-search icon'></i>
                  <input type="text" id="categoryNameData" class="form-control my-2" placeholder="Search..." onkeyUp="categoryNameSearch()">
                  <div class="category-name-data-container">
                    <table id="categoryNameTable" data-name="categoryNameTable">
                      <?php
                        $row = mysqli_num_rows($categoryName);
                        if ($row > 0) {
                          while($result = mysqli_fetch_array($categoryName)):;
                          $categoryEventName_query = "SELECT * FROM eventnametb WHERE event_name_id = $result[1]";
                          $categoryEventNameResult = mysqli_query($dbname,$categoryEventName_query);
                          $categoryEventNameFetch = mysqli_fetch_array($categoryEventNameResult);
                          $categoryEventName = $categoryEventNameFetch[1];

                          $categoryEventType_query = "SELECT * FROM eventtypetb WHERE event_type_id = $result[2]";
                          $categoryEventTypeResult = mysqli_query($dbname,$categoryEventType_query);
                          $categoryEventTypeFetch = mysqli_fetch_array($categoryEventTypeResult);
                          $categoryEventType = $categoryEventTypeFetch[1];
                      ?>
                      <tr id="categoryNameDataTable">
                          <td><?php echo "$result[3] </td><td class='category-details'>($categoryEventName)($categoryEventType)</td>"; ?> 
                          <td class="text-right">
                            <i class='bx bx-x align-self-end color-red' name="categoryNameDataDeleteBtn" onclick="show<?php echo $result[0];?>()"></i>
                        </td>
                      </tr>
                      <script>
                        popupDeleteCategoryName<?php echo $result[0];?> = document.querySelector('.popup-wrapper-delete-category-name<?php echo $result[0];?>');
                    
                        var show<?php echo $result[0];?> = function() {
                            popupDeleteCategoryName<?php echo $result[0];?>.style.display ='flex';
                        }
                        var hide<?php echo $result[0];?> = function() {
                            popupDeleteCategoryName<?php echo $result[0];?>.style.display ='none';
                        }
                    </script>
                      <?php endwhile; 
                        }
                        else{
                      ?>
                      <div id="noDataCat">
                        <div class="d-flex px-4">
                          There is NO Category Data...
                        </div>
                      </div>
                      <?php
                        }
                      ?>
                      <div id="noResultCat">
                        <div class="d-flex justify-content-center px-4">
                          No results found...
                        </div>
                      </div>
                    </table>
                  </div>
                </div>
              </div>
          </div>
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

      $(document).ready(function(){
        searchBox = document.getElementsByTagName('input');
        $(searchBox).attr('maxlength', '25');

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
            return v.replace(/[^\w\s]/gi, '');
          });
        });
      });

      function clearFormEvent(e, b){
        id = document.getElementById(e);
        id.value = '';

        button = document.querySelector('#'+b);
        $(button).attr('disabled', 'true');
      }

      function clearFormCategory(e, b){
        id = document.getElementById(e);
        id.value = '';

        button = document.querySelector('#'+b);
        $(button).attr('disabled', 'true');
        
        $('#selectEventName option:selected').prop('selected', false);
        $('#selectEventName').selectpicker('refresh');

        $('#selectEventType option:selected').prop('selected', false);
        $('#selectEventType').selectpicker('refresh');
      }
    </script>

    <!-- Event Config Scripts -->
    <script type="text/javascript" src="./js/EVE-admin-bootstrap4.bundle.min.js"></script>
    <script type="text/javascript" src="./js/EVE-admin-bootstrap-select.min.js"></script>
    <script type="text/javascript" src="./js/EVE-admin-event-config.js"></script>
    <script type="text/javascript" src="./js/EVE-admin-event-config-disable-button.js"></script>
  </body>
</html>