<?php
  include './php/sign-in.php';
  include './php/database_connect.php';
  include './php/EVE-admin-event-config-get-data.php';
  include './php/EVE-admin-get-event-data.php';
  include './php/EVE-admin-edit-event.php';
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
    <link rel="stylesheet" href="./css/EVE-admin-create-add-event.css">
  </head>

  <body>
    <div class="popup-background" id="discardWrapper">
      <div class="row popup-container">
          <div class="col-4">
              <i class='bx bxs-error prompt-icon warning-color'></i> <!--icon-->
          </div>
          <div class="col-8 text-start text-container">
              <h3 class="text-header">Discard Changes?</h3>   <!--header-->
              <p>Any unsaved progress will be lost.</p> <!--text-->
           </div>
          <div  class="div">
              <button class="outline-button" onclick="hideCancel()"><i class='bx bx-chevron-left'></i>Return</button>
              <a href="EVE-admin-list-of-events.php">
                <button class="primary-button"><i class='bx bx-x'></i>Discard</button>
              </a>
          </div>
      </div>
    </div>

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
      <div class="container-fluid d-flex row justify-content-center align-items-center m-0" id="event-edit-wrapper">
        <div class="element">
          <form id="add-event-form" action="" method="POST" role="form">
            <div class="row flex-column flex-md-row">
              <div class="form-group col-md-4">
                  <label for="select-event-name" class="form-label fw-bold">Event <span class="req" id="reqName">*</span></label>
                  <select id="select-event-name" name="select-event-name" title="<?php echo $edit_event_row[1]?>" class="form-control selectpicker" data-live-search="true" required>
                  <option value="">Select Event Name</option>
                  <?php 
                      $row = mysqli_num_rows($eventName);
                      if ($row > 0) {
                      while($row = mysqli_fetch_array($selectEventName)):;
                        if($edit_event_row[1] !== $row[1]){
                      ?>
                      <option value="<?php echo $row[0]; ?>">
                        <?php echo $row[1]; ?>
                      </option>
                      <?php } 
                        else {
                          ?>
                          <option value="<?php echo $row[0]?>" selected><?php echo $edit_event_row[1]?></option>
                          <?php
                        }  
                    
                    endwhile; }
                      ?>
                  </select>
              </div>
              <div class="form-group col-md-4">
                  <label for="select-event-type" class="form-label fw-bold">Event Type <span class="req" id="reqType">*</span></label>
                  <select id="select-event-type" name="select-event-type" title="<?php echo $edit_event_row[2]?>" class="form-control selectpicker" required>
                  <option value="">Select Event Type</option>
                  <?php 
                      $row = mysqli_num_rows($eventType);
                      if ($row > 0) {
                      while($row = mysqli_fetch_array($eventType)):;
                        if($edit_event_row[2] !== $row[1]){
                      ?>
                      <option value="<?php echo $row[0]; ?>">
                        <?php echo $row[1]; ?>
                      </option>
                      <?php } 
                        else{
                          ?>
                            <option value="<?php echo $row[0]?>" selected><?php echo $edit_event_row[2]?></option>
                          <?php
                        }  
                    
                    endwhile; 
                      }
                    ?>
                  </select>
              </div>
              <div class="form-group col-md-4">
                <label for="select-category-name" class="form-label fw-bold">Category <span class="req" id="reqCategory">*</span></label>
                <select id="select-category-name" name="select-category-name" title="<?php echo $edit_event_row[3]?>" class="form-control selectpicker" data-live-search="true" required>
                  <option value="<?php echo $edit_event_row[3]?>" id="selectedCategory" selected><?php echo $edit_event_row[3]?></option>
                </select>
            </div>
          </div>
          <div class="row flex-column flex-md-row">
            <div class="form-group col-md-6">
                <label for="event-description" class="form-label fw-bold">Event Description <span class="req" id="reqDesc">*</span></label>
                <textarea id="event-description" name="event-description" class="form-control second-layer" placeholder="Type Description Here" minlength="5" maxlength="255" required><?php echo $edit_event_row[4] ?></textarea>
            </div>
            <div class="form-group col-md-6">
                <label class="form-label fw-bold">Criteria</label>
                <div class="form-control second-layer" id="criteria"></div>
            </div>
          </div>
          <div class="row flex-column flex-md-row">
            <div class="form-group col-md-5">
                <label class="form-label fw-bold">Judges</label>
                <div id="event-judges" class="form-control judges-container"></div>
            </div>
            <div class="form-group col-md-4">
                <label class="form-label fw-bold">Date and Time <span class="req" id="reqDateTime">*</span></label>
                <input type="date" class="form-control date" id="date" max="" min="" name="date" value="<?php echo $edit_event_row[6] ?>">
                <input type="time" class="form-control mt-2" id="time" name="time" value="<?php echo $edit_event_row[7] ?>">
            </div>
            <div class="form-group col-md-3">
              <label class="form-label fw-bold">Code <i class='bx bx-copy' onclick="copyCode(this)" data-placement="bottom" title="Copied"></i> <i class='bx bx-hide' id="revealCode"></i></label>
              <div class="form-control" id="display-code"><?php echo $edit_event_row[5]?></div>
            </div>
          </div>
          <div class="row flex-column flex-md-row d-flex justify-content-end align-items-center">
            <button type="submit" class="primary-button" id="save-btn" name="save-btn" onclick="saveEvent()" disabled>
              <div class="tooltip-popup flex-column" id="tooltip">
                <div class="tooltipText" id="textEvent">Event<i class='bx bx-check' id="checkEvent"></i></div>
                <div class="tooltipText" id="textType">Event Type<i class='bx bx-check' id="checkType"></i></div>
                <div class="tooltipText" id="textCategory">Category<i class='bx bx-check' id="checkCategory"></i></div>
                <div class="tooltipText" id="textDescription">Event Description (5 or more char)<i class='bx bx-check' id="checkDescription"></i></div>
                <div class="tooltipText" id="textDate">Date<i class='bx bx-check' id="checkDate"></i></div>
                <div class="tooltipText" id="textTime">Time<i class='bx bx-check' id="checkTime"></i></div>
              </div>
                Save Changes
          </button>
            <div class="outline-button" onclick="showCancel()">Cancel</div>
          </div>
          </form>

          <script>
            popupDiscard = document.getElementById('discardWrapper');
      
            var showCancel = function() {
                popupDiscard.style.display ='flex';
            }
            var hideCancel = function() {
                popupDiscard.style.display ='none';
            }

            const eventCode = document.querySelector("#display-code");
            const eye = document.querySelector("#revealCode");
            const eventCodeCode = eventCode.textContent;

            function copyCode(element) {
              // Show tooltip
              $(element).tooltip('show');

              // Hide tooltip after a delay
              setTimeout(function() {
                $(element).tooltip('hide');
              }, 1500); // Adjust the delay as needed
              var range = document.createRange();
              navigator.clipboard.writeText(eventCodeCode);
              $(element).removeAttr('data-toggle').removeAttr('title').off('mouseenter mouseleave');
            }

            eye.addEventListener("click", function(){
              if(eye.classList.toggle("reveal")){
                eye.classList.remove("bx-hide");
                eye.classList.add("bx-show");
                eventCode.style.webkitTextSecurity = "none";
              }
              else{
                eye.classList.remove("bx-show");
                eye.classList.add("bx-hide");
                eventCode.style.webkitTextSecurity = "disc";
               }
            });
          </script>
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

    <!-- Event Config Scripts -->
    <script type="text/javascript" src="./js/EVE-admin-bootstrap4.bundle.min.js"></script>
    <script type="text/javascript" src="./js/EVE-admin-bootstrap-select.min.js"></script>
    <script type="text/javascript" src="./js/EVE-admin-bootstrap-select-picker.js"></script>
    <script type="text/javascript" src="./js/EVE-admin-edit-disable-button.js"></script>
    <script type="text/javascript" src="./js/EVE-admin-popup.js"></script>
    <script>

      $(document).ready(function(){
        var todaysDate = new Date();
        
        var year = todaysDate.getFullYear();		
        var maxYear = year+1;
        var month = ("0" + (todaysDate.getMonth() + 1)).slice(-2); 
        var day = ("0" + todaysDate.getDate()).slice(-2);

        var dtToday = (year + "-" + month + "-" + day);
        var dtMax = (maxYear + "-" + month + "-" + day);
        
        $("#date").attr('max', dtMax);
        $("#date").attr('min', dtToday);
      });

      $(document).ready(function(){
        var default_event_name_id = $("#select-event-name").val();
        var default_event_type_id = $("#select-event-type").val();
        var default_category_name = '<?php echo $edit_event_row[3]?>';

        $.ajax({
            url:"./php/EVE-admin-edit-action.php",
            method: "POST",
            data:{s_eventNameID:default_event_name_id, eventTypeID:default_event_type_id, categoryName:default_category_name},
            success: function(data){
              $("#select-category-name").html(data);
              $('#select-category-name').selectpicker('refresh');
            }
        });
        $("#select-event-name").change(function(){
          var event_name_id = $(this).val();
          if($('#select-event-type').prop('disabled', false)){
            $('#select-event-type').prop('disabled', false);
          }
          $('#select-event-type option:selected').prop('selected', false);
          $('#select-event-type').selectpicker('refresh');
          $('#select-category-name').prop('disabled', true);
          $('#select-category-name option:selected').prop('selected', false);
          $('#select-category-name').selectpicker('refresh');
          document.querySelector("#save-btn").disabled = true;
          tooltip.style.visibility = 'visible';
          checkType.style.visibility = "hidden";
          textType.style.color = "var(--not-active-text-color)";
          checkCategory.style.visibility = "hidden";
          textCategory.style.color = "var(--not-active-text-color)";
          if($(this).val() === ""){
            $('#select-event-type').prop('disabled', true);
            $('#select-event-type').selectpicker('refresh');
          }
        });
        $("#select-event-type").change(function(){
          var s_event_name_id = $("#select-event-name").val();
          var event_type_id = $(this).val();
          if($('#select-category-name').prop('disabled', false)){
            $('#select-category-name').prop('disabled', false);
          }
          $('#select-category-name').selectpicker('refresh');
          $('#selectedCategory').removeAttr("selected");
          document.querySelector("#save-btn").disabled = true;
          tooltip.style.visibility = 'visible';
          checkCategory.style.visibility = "hidden";
          textCategory.style.color = "var(--not-active-text-color)";
          $('#select-category-name').attr('title', 'Select Category');
          if($(this).val() === ""){
            $('#select-category-name').prop('disabled', true);
            $('#select-category-name').selectpicker('refresh');
          }
          $.ajax({
            url:"./php/EVE-admin-edit-action.php",
            method: "POST",
            data:{s_eventNameID:s_event_name_id, eventTypeID:event_type_id, categoryName:default_category_name},
            success: function(data){
              $("#select-category-name").html(data);
              $('#select-category-name').selectpicker('refresh');
            }
          });
        });
        
      }); 

      $(document).ready(function() {
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

      function saveEvent(){
        windows.location.href = "EVE-admin-list-of-events.php?event successfully saved";
      }
    </script>
  </body>

</html>