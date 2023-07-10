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
          <form id="add-event-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" role="form">
            <div class="row flex-column flex-md-row">
            <div class="form-group col-md-4">
                  <label for="select-event-type" class="form-label fw-bold">Event Type <span class="req" id="reqType">*</span></label>
                  <select id="select-event-type" name="select-event-type" title="<?php echo $edit_event_row['event_type']?>" class="form-control selectpicker" required>
                  <option value="">Select Event Type</option>
                  <?php 
                      $row = mysqli_num_rows($eventType);
                      if ($row > 0) {
                      while($row = mysqli_fetch_array($eventType)):;
                        if($edit_event_row['event_type'] !== $row[1]){
                      ?>
                      <option value="<?php echo $row[0]; ?>">
                        <?php echo $row[1]; ?>
                      </option>
                      <?php } 
                        else{
                          ?>
                            <option value="<?php echo $row[0]?>" selected><?php echo $row[1]?></option>
                          <?php
                        }  
                    
                    endwhile; 
                      }
                    ?>
                  </select>
              </div>
              <div class="form-group col-md-4">
                  <label for="select-event-name" class="form-label fw-bold">Event <span class="req" id="reqName">*</span></label>
                  <select id="select-event-name" name="select-event-name" title="<?php echo $edit_event_row['event_name']?>" class="form-control selectpicker" data-live-search="true" required>
                  <option value="">Select Event Name</option>
                  <?php 
                      $row = mysqli_num_rows($eventName);
                      $currentEventID = $edit_event_row['event_name_id'];
                      $sql = "SELECT event_name_id, event_name FROM event_name
                              UNION
                              SELECT event_name_id, event_name FROM ongoing_event_name WHERE event_name_id = '$currentEventID'";
                      $result = mysqli_query($conn, $sql);
                      if ($row > 0) {
                      while($row = mysqli_fetch_array($result)):;
                        if($edit_event_row['event_name'] !== $row[1]){
                      ?>
                      <option value="<?php echo $row[0]; ?>">
                        <?php echo $row[1]; ?>
                      </option>
                      <?php } 
                        else {
                          ?>
                          <option value="<?php echo $row['event_name_id']?>" selected><?php echo $row['event_name']?></option>
                          <?php
                        }  
                    
                    endwhile; }
                      ?>
                  </select>
              </div>
              <div class="form-group col-md-4">
                <label for="select-category-name" class="form-label fw-bold">Category <span class="req" id="reqCategory">*</span></label>
                <select id="select-category-name" name="select-category-name" title="<?php echo $edit_event_row['category_name']?>" class="form-control selectpicker" data-live-search="true" required>
                  <option value="<?php echo $edit_event_row['category_name_id']?>" id="selectedCategory" selected><?php echo $edit_event_row['category_name']?></option>
                </select>
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
        var description = "<?php echo $edit_event_row['event_description'] ?>";
        var code = "<?php echo $edit_event_row['event_code'] ?>";
        var date = "<?php echo $edit_event_row['event_date'] ?>";
        var time = "<?php echo $edit_event_row['event_time'] ?>";
        var eventID = "<?php echo $edit_event_row['event_id'] ?>";
        var popUp = "<?php echo $popUpID ?>";
        var showPopUp = "<?php echo $showPopUpButtonID ?>";


          // Initial data fetch based on typePicker value
        fetchTypeData($('#select-event-type').val(), description, date, time, code, eventID, popUp, showPopUp);

        $('#select-event-type').change(function() {
          // Fetch data based on changed typePicker value
          var selectedType = $(this).val();
          description = $('#event-description').val(); // Capture the updated description value
          date = $('#date').val(); // Capture the updated date value
          time = $('#time').val(); // Capture the updated time value
          var popUp = "<?php echo $popUpID ?>";
          var showPopUp = "<?php echo $showPopUpButtonID ?>";
          fetchTypeData(selectedType, description, date, time, code, eventID, popUp, showPopUp);
        });

        function fetchTypeData(type, description, date, time, code, eventID, popUp, showPopUp) {
          $.ajax({
              url: './php/EVE-admin-edit-event-type.php',
              method: 'POST',
              data: { eventID: eventID, type: type, desc: description, e_date: date, e_time: time, e_code: code, e_popUp: popUp, e_showPopUp: showPopUp },
              success: function(response) {
                  $('#createEventContent').html(response);

                  if ($("#select-event-type").val() !== "") {
                      checkType.style.visibility = "visible";
                      textType.style.color = "var(--default-success-color)";
                  }
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
                      // Use the updated description variable as needed
                      console.log(description);
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
      });

      $(document).ready(function(){
        var selectedEventID = <?php echo isset($_GET['eec']) ? $_GET['eec'] : 'null'; ?>;
        var selectedEventNameID = $("#select-event-name").val();
        var selectedEventTypeID = $("#select-event-type").val();
        var selectedCategoryNameID = "<?php echo $edit_event_row['category_name_id']?>";

        fetchData();

        $('#select-event-name').change(function() {
            // Fetch data based on changed categoryPicker value
            selectedEventNameID = $(this).val();
            fetchData();
        });

        $('#select-event-type').change(function() {
            // Fetch data based on changed categoryPicker value
            selectedEventTypeID = $(this).val();
            fetchData();
        });
        
        function fetchData(){
          console.log(selectedEventID);
          console.log("Hi");
          $.ajax({
              url:"./php/EVE-admin-edit-action.php",
              method: "POST",
              data:{eventID: selectedEventID, s_eventNameID: selectedEventNameID, eventTypeID: selectedEventTypeID, categoryName: selectedCategoryNameID},
              success: function(data){
                $("#select-category-name").html(data);
                $('#select-category-name').selectpicker('refresh');
              }
          });
        }

        $(document).ready(function(){

        $('#select-event-type').change(function() {
          var event_type_id = $(this).val();
          if($('#select-event-name').prop('disabled', false)){
            $('#select-event-name').prop('disabled', false);
          }
          $('#select-event-name option:selected').prop('selected', false);
          $('#select-event-name').selectpicker('refresh');
          $('#select-category-name').prop('disabled', true);
          $('#select-category-name option:selected').prop('selected', false);
          $('#select-category-name').selectpicker('refresh');
          document.querySelector("#save-btn").disabled = true;
          tooltip.style.display = 'flex';
          tooltip.style.visibility = 'visible';
          checkEvent.style.visibility = "hidden";
          textEvent.style.color = "var(--not-active-text-color)";
          checkCategory.style.visibility = "hidden";
          textCategory.style.color = "var(--not-active-text-color)";
          if($(this).val() === ""){
            $('#select-event-name').prop('disabled', true);
            $('#select-event-name').selectpicker('refresh');
          }
        });
        $("#select-event-name").change(function(){
          var s_event_name_id = $(this).val();
          var event_type_id = $("#select-event-type").val();
          if($('#select-category-name').prop('disabled', false)){
            $('#select-category-name').prop('disabled', false);
          }
          $('#select-category-name').selectpicker('refresh');
          document.querySelector("#save-btn").disabled = true;
          tooltip.style.display = 'flex';
          tooltip.style.visibility = 'visible';
          checkCategory.style.visibility = "hidden";
          textCategory.style.color = "var(--not-active-text-color)";
          if($(this).val() === ""){
            $('#select-category-name').prop('disabled', true);
            $('#select-category-name').selectpicker('refresh');
          }
        });
      }); 
        
      }); 

      $(document).ready(function() {
            var eventID = "<?php echo $edit_event_row['event_id']?>";
            var default_category_name = "<?php echo $edit_event_row['category_name_id']?>";
            $('#select-category-name').val(default_category_name);
            // Initial data fetch based on categoryPicker value
            fetchCategoryData($('#select-category-name').val(), eventID);
        });

        $('#select-category-name').change(function() {
            // Fetch data based on changed categoryPicker value
            var selectedCategory = $(this).val();
            eventID = "<?php echo $edit_event_row['event_id']?>";
            fetchCategoryData(selectedCategory, eventID);
        });

        var totalPercentage = 0;

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
                  buttonState(totalPercentage);
                }
            });
        }
    </script>
        <script type="text/javascript" src="./js/EVE-admin-edit-disable-button.js"></script>
  </body>

</html>