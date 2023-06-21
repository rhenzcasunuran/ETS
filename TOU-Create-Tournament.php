<?php
  include './php/sign-in.php';
  include './php/database_connect.php';
  include './php/EVE-admin-event-config-get-data.php';
  include './php/EVE-admin-add-event.php';
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
    <div class="container-fluid" id="popup-wrapper">
      <div id="confirm-cancel" class="row">
        <div class="col-5 text-center">
          <i class='bx bxs-error popup-icon' id="error-icon"></i>
        </div>
        <div class="col-7" id="text-confirm">
          <h3 class="bold">Cancel Editing?</h3>
          <p>Changes will not be saved.</p>
        </div>
        <div class="row flex-column flex-md-row d-flex align-items-center justify-content-center">
          <button class="btn btn-confirm content-box-shadow" id="btn-return" onclick="hide()">Return to Editing</button>
          <a href="EVE-admin-list-of-events.php">
            <button class="btn btn-danger btn-confirm content-box-shadow">Continue</button>
          </a> 
        </div>
      </div>
    </div>    
    <!--Sidebar-->
    <?php
      // Set the active module and sub-active sub-item variables
      $activeModule = 'tournaments';      
      $activeSubItem = 'create-tournament';

      // Include the sidebar template
      require './php/admin-sidebar.php';
    ?>
    <!--Page Content-->
    <section class="home-section">
      <div class="d-flex justify-content-between align-items-center pr-4">
        <div class="header">Create Event</div>
      </div>
      <div class="container-fluid d-flex row justify-content-center align-items-start m-0" id="event-wrapper">
        <div class="justify-content-center align-items-start content-box-shadow" id="add-event-container">
          <form id="add-event-form" action="" method="POST" role="form">
            <div class="row flex-column flex-md-row">
              <div class="form-group col-md-4">
                <label for="select-category-name" class="form-label fw-bold">Category <span class="req">(required)</span></label>
                <select id="select-category-name" name="select-category-name" title="Select Category" class="form-control selectpicker" data-live-search="true" required>
                  <option value="" selected>Select Category</option>
                  <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["event_history_id"] . "'>" . $row["category_name"] . "</option>";
            }
        } else {
            echo "<option>No options available</option>";
        }
        ?>
                </select>
            </div>
          </div>
          <div class="row flex-column flex-md-row">
            <div class="form-group col-md-6">
                <label for="event-description" class="form-label fw-bold">Event Description <span class="req">(required)</span></label>
                <textarea id="event-description" name="event-description" class="form-control second-layer" placeholder="Type Description Here" minlength="5" maxlength="255" required></textarea>
            </div>
            <div class="form-group col-md-6">
                <label for="criteria" class="form-label fw-bold">Criteria</label>
                <div class="form-control second-layer" id="criteria" name="criteria"></div>
            </div>
          </div>
          <div class="row flex-column flex-md-row">
            <div class="form-group col-md-5">
                <label for="event-judges" class="form-label fw-bold">Judges</label>
                <div id="event-judges" class="form-control judges-container" name="event-judges"></div>
            </div>
            <div class="form-group col-md-4">
                <label for="date" class="form-label fw-bold">Date and Time <span class="req">(required)</span></label>
                <input type="date" class="form-control date" id="date" max="" min="" name="date" required>
                <input type="time" class="form-control mt-2" id="time" name="time" required>
            </div>
            <div class="form-group col-md-3">
              <label for="code" class="form-label fw-bold">Code</label>
              <div class="form-control" id="no-code">--------------------</div>
              <input type="hidden" class="form-control" id="code" name="code" readonly required>
            </div>
          </div>
          <div class="row flex-column flex-md-row d-flex justify-content-end align-items-center">
            <a href="EVE-admin-list-of-events.php?event successfully saved"><button type="submit" class="btn btn-danger" id="save-btn" name="save-btn" disabled>Save Changes</button></a>
            <a class="btn" id="cancel-btn" onclick="show()">Cancel</a>
          </div>
          </form>
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
    <script type="text/javascript" src="./js/EVE-admin-list-of-events.js"></script>
    <script type="text/javascript" src="./js/EVE-admin-disable-button.js"></script>
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
        var maxYear = year+10;
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

    </script>
  </body>

</html>