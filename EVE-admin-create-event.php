<?php
  include './php/sign-in.php';
  include './php/database_connect.php';
  include './php/EVE-admin-event-config-get-data.php';
  include './php/EVE-admin-add-event.php';
  include './php/EVE-admin-get-event-data.php';
  include './php/CAL-datetime-fill.php';
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
    <?php
      $activeModule = 'events';
      $activeSubItem = 'list-of-events';

      require './php/admin-sidebar.php';
    ?>
    <!--Page Content-->
    <section class="home-section flex-row">
      <div class="container-fluid d-flex row justify-content-center align-items-center m-0" id="event-create-wrapper">
        <div class="element">
          <form id="add-event-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" role="form">
            <div class="row flex-column flex-md-row">
              <div class="form-group col-md-4">
                  <label for="select-event-name" class="form-label fw-bold">Event <span class="req" id="reqName">*</span></label>
                  <select id="select-event-name" name="select-event-name" title="Select Event" class="form-control selectpicker" data-live-search="true" required>
                  <option value="" selected>Select Event</option>
                  <?php 
                      $row = mysqli_num_rows($eventName);
                      if ($row > 0) {
                      while($row = mysqli_fetch_array($selectEventName)):;?>
                      <option value="<?php echo $row[0]; ?>">
                        <?php echo $row[1]; ?>
                      </option>
                      <?php endwhile; }
                      ?>
                  </select>
              </div>
              <div class="form-group col-md-4">
                  <label for="select-event-type" class="form-label fw-bold">Event Type <span class="req" id="reqType">*</span></label>
                  <select disabled='disabled' id="select-event-type" name="select-event-type" title="Select Event Type" class="form-control selectpicker" required>
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
                    ?>
                  </select>
              </div>
              <div class="form-group col-md-4">
                <label for="select-category-name" class="form-label fw-bold">Category <span class="req" id="reqCategory">*</span></label>
                <select disabled='disabled' id="select-category-name" name="select-category-name" title="Select Category" class="form-control selectpicker" data-live-search="true" required>
                  <option value="" selected>Select Category</option>
                </select>
            </div>
          </div>
          <div class="row flex-column flex-md-row">
            <div class="form-group col-md-6">
                <label for="event-description" class="form-label fw-bold">Event Description <span class="req" id="reqDesc">*</span></label>
                <textarea id="event-description" name="event-description" class="form-control second-layer" placeholder="Type Description Here" minlength="5" maxlength="255" required></textarea>
            </div>
            <div class="form-group col-md-6">
                <label class="form-label fw-bold">Criteria</label>
                <div class="form-control second-layer" id="criteria" name="criteria">
                  <div id="criteria-container">
                    <div class="upper-layer row">
                      <p class="col-6 text-center">Criteria</p>
                      <p class="col-6 text-center">%</p>
                    </div>
                    <div class="middle-layer flex-column">
                      <div id="criterion-container" class="row">
                        <p class="col-6">Criterion A</p>
                        <p class="col-6 text-center">100%</p>
                      </div>
                      <div id="criterion-container" class="row">
                        <p class="col-6">Criterion A</p>
                        <p class="col-6 text-center">100%</p>
                      </div>
                    </div>
                    <div class="lower-layer row">
                      <p class="col-6 text-center">Total</p>
                      <p class="col-6 text-center">100%</p>
                    </div>
                  </div>
                </div>
            </div>
          </div>
          <div class="row flex-column flex-md-row">
            <div class="form-group col-md-5">
                <label class="form-label fw-bold">Judges</label>
                <div id="event-judges" class="form-control judges-container" name="event-judges"></div>
            </div>
            <div class="form-group col-md-4">
                <label class="form-label fw-bold">Date & Time <span class="req" id="reqDateTime">*</span></label>
                <input type="date" class="form-control date" id="date" max="" min="" name="date" required>
                <input type="time" class="form-control mt-2" id="time" name="time" required>
            </div>
            <div class="form-group col-md-3">
              <label class="form-label fw-bold">Code</label>
              <div class="form-control" id="no-code">--------------------</div>
              <input type="hidden" class="form-control" id="code" name="code" readonly required>
            </div>
          </div>
          <div class="row flex-column flex-md-row d-flex justify-content-end align-items-center">

            <button type="submit" class="primary-button" id="save-btn" name="save-btn" onclick="saveEvent()" disabled>
              <div class="tooltip-popup flex-column" id="tooltip">
                  <div class="tooltipText" id="textEvent">Event<i class='bx bx-check' id="checkEvent"></i></div>
                  <div class="tooltipText" id="textType">Event Type<i class='bx bx-check' id="checkType"></i></div>
                  <div class="tooltipText" id="textCategory">Category<i class='bx bx-check' id="checkCategory"></i></div>
                  <div class="tooltipText" id="textDescription">Event Description (5 or more char)<i class='bx bx-check' id="checkDescription"></i></div>
                  <div class="tooltipText" id="textDate">Date: <span id="dateText"></span><i class='bx bx-check' id="checkDate"></i></div>
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
    <script type="text/javascript" src="./js/EVE-admin-popup.js"></script>
    <script>

      function randomString(length, chars) {
          var mask = '';
          if (chars.indexOf('a') > -1) mask += 'abcdefghijklmnopqrstuvwxyz';
          if (chars.indexOf('A') > -1) mask += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
          if (chars.indexOf('#') > -1) mask += '0123456789';
          if (chars.indexOf('!') > -1) mask += '~`!@#$%^&*()_+-={}[]:";\'<>?,./|\\';
          var result = '';
          for (var i = length; i > 0; --i) result += mask[Math.round(Math.random() * (mask.length - 1))];
          return result;
      }

      var code = randomString(12, 'aA#');
      $('#code').prop('value', code);
      
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
          document.querySelector("#save-btn").disabled = true;
          checkCategory.style.visibility = "hidden";
          textCategory.style.color = "var(--not-active-text-color)";
          if($(this).val() === ""){
            $('#select-category-name').prop('disabled', true);
            $('#select-category-name').selectpicker('refresh');
          }
          $.ajax({
            url:"./php/EVE-admin-action.php",
            method: "POST",
            data:{s_eventNameID:s_event_name_id, eventTypeID:event_type_id},
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
      });

      //Date and Time Helper from Calendar
      $(document).ready(function() {
          var time = "<?php echo isset($sanitizedTime) ? $sanitizedTime : ''; ?>";
          var date = "<?php echo isset($sanitizedDate) ? $sanitizedDate : ''; ?>";
          document.getElementById('time').value = time;
          document.getElementById('date').value = date;
      });

      function saveEvent(){
        windows.location.href = "EVE-admin-list-of-events.php?event successfully saved";
      }
    </script>
      <script type="text/javascript" src="./js/EVE-admin-disable-button.js"></script>
  </body>

</html>