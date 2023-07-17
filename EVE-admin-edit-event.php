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

    <script src="./js/jquery-3.6.4.js"></script>
  </head>

  <body>
    <?php 
      $popUpID = "discardCreateEvent";
      $showPopUpButtonID = "cancelBtn";
      $icon = "<i class='bx bxs-error-circle warning-color'></i>";
      $title = "Discard Changes?";
      $message = "Any unsaved progress will be lost.";
      $your_link = "EVE-admin-list-of-events.php";
      $id_name = "";
      $id = "";

      include './php/popup.php'; 
    ?>

    <!--Sidebar-->
    <?php
      $activeModule = 'events';
      $activeSubItem = 'list-of-events';

      require './php/admin-sidebar.php';
    ?>
    <!--Page Content-->
    <section class="home-section">
      <div class="container-fluid d-flex row justify-content-center align-items-center m-0" id="event-edit-wrapper">
        <div class="element">
          <form id="add-event-form" action="" method="POST" role="form">
            <div class="row flex-column flex-md-row">
            <div class="form-group col-md-4" id="eventTypeS">
                  <label class="form-label fw-bold">Event Type</label>
                  <div id="select-event-type" name="select-event-type" class="form-control disable"><?php echo $edit_event_row['event_type']?></div>
              </div>
              <div class="form-group col-md-4" id="eventNameS">
                  <label class="form-label fw-bold">Event</label>
                  <div id="select-event-name" name="select-event-name" class="form-control disable"><?php echo $edit_event_row['event_name']?></div>
              </div>
              <div class="form-group col-md-4" id="categoryNameS">
                <label class="form-label fw-bold">Category</label>
                <div id="select-category-name" name="select-category-name" class="form-control disable"><?php echo $edit_event_row['category_name']?></div>
            </div>
          </div>
          <div id="createEventContent"></div>
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

      $(document).ready(function() {
        var type = "<?php echo $edit_event_row['event_type_id'] ?>";
        var description = "<?php echo $edit_event_row['event_description'] ?>";
        var code = "<?php echo $edit_event_row['event_code'] ?>";
        var date = "<?php echo $edit_event_row['event_date'] ?>";
        var time = "<?php echo $edit_event_row['event_time'] ?>";
        var eventID = "<?php echo $edit_event_row['event_id'] ?>";
        var popUp = "<?php echo $popUpID ?>";
        var showPopUp = "<?php echo $showPopUpButtonID ?>";
        var overallIncluded = "<?php echo $edit_event_row['overall_include'] ?>";

        function fetchTypeData(type, description, date, time, code, eventID, popUp, showPopUp, overallIncluded) {
          $.ajax({
              url: './php/EVE-admin-edit-event-type.php',
              method: 'POST',
              data: { eventID: eventID, type: type, desc: description, e_date: date, e_time: time, e_code: code, e_popUp: popUp, e_showPopUp: showPopUp, overallIncluded: overallIncluded },
              success: function(response) {
                  $('#createEventContent').html(response);

                  if (description !== "") {
                      checkDesc.style.visibility = "visible";
                      textDesc.style.color = "var(--default-success-color)";
                  }
                  if (date !== "") {
                      checkDate.style.visibility = "visible";
                      textDate.style.color = "var(--default-success-color)";
                  }
                  if (time !== "") {
                      checkTime.style.visibility = "visible";
                      textTime.style.color = "var(--default-success-color)";
                  }
                  // Update description variable on input
                  $('#event-description').on('input', function() {
                      description = $(this).val();
                  });

                  $('#date').change(function() {
                    date = $(this).val();
                  });

                  $('#time').change(function() {
                    time = $(this).val();
                  });

                  $('#date').on('input', function() {
                    date = $(this).val();
                  });

                  $('#time').on('input', function() {
                    time = $(this).val();
                  });
              }
          });
        }

        fetchTypeData(type, description, date, time, code, eventID, popUp, showPopUp, overallIncluded);
      });

      $(document).ready(function() {
            var eventID = "<?php echo $edit_event_row['event_id']?>";
            var default_category_name = "<?php echo $edit_event_row['category_name_id']?>";
            // Initial data fetch based on categoryPicker value
            fetchCategoryData(default_category_name, eventID);



        function fetchCategoryData(category, event) {
            $.ajax({
                url: './php/EVE-admin-edit-event-criteria.php',
                method: 'POST',
                data: { category: category, event: event },
                success: function(response) {
                  var parsedResponse = JSON.parse(response);
                  var totalPercent = parsedResponse.totalPercent;

                  totalPercentage = totalPercent;
                  // Replace the form section with updated data
                  $('#criteria-container').html(parsedResponse.output);
                  buttonState();
                }
            });
        }

      });

          // Fetch data based on changed typePicker value
          var selectedType =<?php echo $edit_event_row['event_type_id'] ?>;

          if (selectedType === 3) {
            // Remove the div with id "categoryNameS"
            $('#categoryNameS').remove();
            $('#eventTypeS').removeClass('col-md-4').addClass('col-md-6');
            $('#eventNameS').removeClass('col-md-4').addClass('col-md-6');
          }
    </script>
        <script type="text/javascript" src="./js/EVE-admin-edit-disable-button.js"></script>
  </body>

</html>