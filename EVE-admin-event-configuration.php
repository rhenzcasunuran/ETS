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

    <script type="text/javascript" src="./js/jquery-3.6.4.js"></script>
  </head>

  <body>
    <?php
      $row = mysqli_num_rows($eventName2);
      if ($row > 0){
        while ($row = mysqli_fetch_array($eventName2)):;
    ?>
      <?php 
          $popUpID = "deleteEventName{$row['event_name_id']}";
          $showPopUpButtonID = "eventNameDelete{$row['event_name_id']}";
          $icon = "<i class='bx bxs-trash danger-color'></i>";
          $title = "Delete \"{$row['event_name']}\"?";
          $message = "This action cannot be undone. All related categories will also be deleted. Ongoing events may still go but won't be able to restore after it is done or deleted.";
          $your_link = "EVE-admin-event-configuration.php";
          $id_name = "eni";
          $id = $row['event_name_id'];

          // Make sure to include your php query to the your page

        include './php/popup.php'; 
      ?>
    <?php
    endwhile;
      }
    ?>
    <?php
      $row = mysqli_num_rows($categoryName2);
      if ($row > 0){
        while ($row = mysqli_fetch_array($categoryName2)):;
    ?>
      <?php 
          $popUpID = "deleteCategoryName{$row['category_name_id']}";
          $showPopUpButtonID = "categoryNameDelete{$row['category_name_id']}";
          $icon = "<i class='bx bxs-trash danger-color'></i>";
          $title = "Delete \"{$row['category_name']}\"?";
          $message = "This action cannot be undone. You won't be able to use it again after deletion.";
          $your_link = "EVE-admin-event-configuration.php";
          $id_name = "cni";
          $id = $row['category_name_id'];

          // 1. Make sure to include your php query to the your page
          // 2. Make sure to include "<script type="text/javascript" src="./js/jquery-3.6.4.js"></script>" at the head of your page

        include './php/popup.php'; 
      ?>
    <?php
    endwhile;
      }
    ?>
    <!--Sidebar-->
    <?php
      $activeModule = 'events';
      $activeSubItem = 'event-configuration';

      require './php/admin-sidebar.php';
    ?>
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
                          <i class='bx bx-x align-self-center color-red' name="eventNameDataDeleteBtn" id="eventNameDelete<?php echo $result['event_name_id'] ?>"></i>
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
                    <label for="selectEventType" class="fs-6">Event Type <span class="req">*</span></label>
                    <select name="selectEventType" id="selectEventType" title="Select Event Type" class="form-control selectpicker" required>
                      <option value="" selected>Select Event Type</option>
                      <?php 
                      $row = mysqli_num_rows($eventType);
                      if ($row > 0) {
                      while($row = mysqli_fetch_array($eventType)):;
                        if($row['event_type'] != 'Standard'){
                      ?>
                      <option value="<?php echo $row[0]; ?>">
                        <?php echo $row[1]; ?>
                      </option>
                      <?php } endwhile; 
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
                    <label for="inputCategoryName" class="fs-6">Category <span class="req">*</span></label>
                    <input type="text" class="form-control" id="inputCategoryName" placeholder="Enter Category Name" name="inputCategoryName" minlength="5" maxlength="25" required>
                    <div class="text-danger d-flex w-100 justify-content-center" id="checkCategoryName"><?php if(isset($error['categoryName'])) echo $error['categoryName']?></div>
                  </div>
                  </div>
                  <div class="button-container config-button row">
                    <button type="submit" class="primary-button col-6" id="categorySaveBtn" name="categorySaveBtn" disabled>
                      <div class="tooltip-popup flex-column" id="tooltipCategory">
                        <div class="tooltipText" id="selectType">Event Type<i class='bx bx-check' id="checkSelectType"></i></div>
                        <div class="tooltipText" id="selectEvent">Event<i class='bx bx-check' id="checkSelectEvent"></i></div>
                        <div class="tooltipText" id="textCategory">Category Name (5 or more char)<i class='bx bx-check' id="checkCategory"></i></div>
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
                          $categoryEventName_query = "SELECT * FROM event_name WHERE event_name_id = $result[1]";
                          $categoryEventNameResult = mysqli_query($conn,$categoryEventName_query);
                          $categoryEventNameFetch = mysqli_fetch_array($categoryEventNameResult);
                          $categoryEventName = $categoryEventNameFetch[1];

                          $categoryEventType_query = "SELECT * FROM event_type WHERE event_type_id = $result[2]";
                          $categoryEventTypeResult = mysqli_query($conn,$categoryEventType_query);
                          $categoryEventTypeFetch = mysqli_fetch_array($categoryEventTypeResult);
                          $categoryEventType = $categoryEventTypeFetch[1];
                      ?>
                      <tr id="categoryNameDataTable">
                          <td><?php echo "$result[3] </td><td class='category-details'>($categoryEventName)($categoryEventType)</td>"; ?> 
                          <td class="text-right">
                            <i class='bx bx-x align-self-end color-red' name="categoryNameDataDeleteBtn" id="categoryNameDelete<?php echo $result['category_name_id']?>"></i>
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
          if (!txt.match(/[A-Za-z0-9 \-']/)) {
              return false;
          }
        });

        $('input').on('input', function(e) {
          $(this).val(function(i, v) {
            return v.replace(/[^\w\s\-']|_/gi, '');
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