<?php
  include './php/sign-in.php';
  include './php/database_connect.php';
  include './php/EVE-admin-event-config-get-data.php';
  include './php/EVE-admin-edit-event.php';
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
    <link rel="stylesheet" href="./css/system-wide.css">

    <!-- Event Config Styles -->
    <link rel="stylesheet" href="./css/EVE-admin-bootstrap-select.min.css">
    <link rel="stylesheet" href="./css/EVE-admin-bootstrap4.min.css">
    <link rel="stylesheet" href="./css/EVE-admin-list-of-events.css">
    <link rel="stylesheet" href="./css/EVE-admin-confirmation.css">

    <script src="./js/jquery-3.6.4.js"></script>
  </head>

  <body>
    <?php
      $row = mysqli_num_rows($event_result);
      if ($row > 0){
        while ($row = mysqli_fetch_array($event_data)):;
    ?>
      <div class="popup-background" id="deleteWrapper<?php echo $row[3];?>">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-error prompt-icon danger-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Delete Event?</h3>   <!--header-->
                <p>This will delete the event permanently. This action cannot be undone.</p> <!--text-->
            </div>
            <div class="div">
                <button class="outline-button" onclick="hideDelete<?php echo $row[0];?>()"><i class='bx bx-x'></i>Cancel</button>
                <a href="EVE-admin-list-of-events.php?eed=<?php echo $row[3]?>">
                  <button class="danger-button"><i class='bx bx-trash'></i>Delete</button>
                </a>
            </div>
        </div>
      </div>
      <?php 
          $popUpID = "markAsDone{$row['event_id']}";
          $showPopUpButtonID = "eventDoneBtn{$row['event_id']}";
          $icon = "<i class='bx bxs-check-circle success-color'></i>";
          $title = "Mark as Done?";
          $message = "Marked events will be removed from events list and will transfer to the history.";
          $your_link = "EVE-admin-list-of-events.php";
          $id_name = "mad";
          $id = $row['event_id'];

          // Make sure to include your php query to the your page

        include './php/popup.php'; 
      ?>
    <?php
    endwhile;
      }
    ?>
    <!--Sidebar-->
    <?php
      $activeModule = 'events';
      $activeSubItem = 'list-of-events';

      require './php/admin-sidebar.php';
    ?>
    <!--Page Content-->
    <section class="home-section">
      <div class="container-fluid d-flex row justify-content-center m-0" id="event-wrapper">
        <?php
          $row = mysqli_num_rows($event_result2);
          if ($row > 0){
            ?>
                <!--Pagination-->
          <?php
            $list_table_query = "SELECT * FROM ongoing_list_of_event WHERE is_archived = '0';";
            $your_php_location = "EVE-admin-list-of-events.php";
            require './php/pagination.php';
            $list_table_query_with_limit = "SELECT ole.*,
                                            oen.*,
                                            et.*
                                            FROM ongoing_event_name AS oen
                                            JOIN event_type AS et
                                            JOIN ongoing_list_of_event AS ole ON ole.ongoing_event_name_id = oen.ongoing_event_name_id AND ole.event_type_id = et.event_type_id
                                            WHERE is_archived = 0
                                            ORDER BY event_date ASC, event_time ASC
                                            LIMIT $start_from, $numberOfItems;";
            $listedItems = mysqli_query($conn, $list_table_query_with_limit);
          ?>
              <div class="row d-flex justify-content-between align-items-center w-100">
                <div class="header col-7">List of Events</div>
                <div class="button-container col-5">
                  <a href="EVE-admin-create-event.php?add new event">
                    <button class="primary-button icon-button" id="create-event-btn"><i class='bx bx-add-to-queue'></i></button>
                  </a>
                  <button class="secondary-button icon-button" id="edit-event-btn"><i class='bx bx-edit'></i></button>
                </div>
              </div>
            <?php
            while ($row = mysqli_fetch_array($listedItems)):;?>
            <div class="element">
              <div class="row">
              <div class="element-group col-sm-6 col-lg-3">
                  <p class="element-label">Event Type</p>
                  <p class="element-content"><?php echo $row['event_type'];?></p>
                </div>
                <div class="element-group col-sm-6 col-lg-3">
                  <p class="element-label">Event</p>
                  <p class="element-content"><?php echo $row['event_name'];?></p>
                </div>
                <div class="element-group col-sm-6 col-lg-3">
                  <p class="element-label">Category</p>
                  <p class="element-content"><?php echo $row['category_name'];?></p>
                </div>
                <div class="element-group col-sm-6 col-lg-3">
                  <p class="element-label">Date & Time</p>
                  <p class="element-content"><?php 
                  $date_sql = "SELECT DATE_FORMAT('$row[event_date]', '%M %d, %Y') AS formattedDate FROM ongoing_list_of_event;";
                  $date_result = mysqli_query($conn, $date_sql);
                  $get_date_result = mysqli_fetch_assoc($date_result);
                  $date = $get_date_result['formattedDate'];

                  $time_sql = "SELECT TIME_FORMAT('$row[event_time]', '%h:%i %p') AS formattedTime FROM ongoing_list_of_event;";
                  $time_result = mysqli_query($conn, $time_sql);
                  $get_time_result = mysqli_fetch_assoc($time_result);
                  $time = $get_time_result['formattedTime'];
                  echo $date;?>; <?php echo $time;?></p>
                </div>
              </div>
              <div class="row">
                <div class="element-group col-sm-6 col-lg-6">
                  <p class="element-label">Event Desciption</p>
                  <p class="element-content"><?php echo $row['event_description'];?></p>
                </div>
                <div class="element-group col-sm-6 col-lg-2">
                  <p class="element-label">Code 
                    <i class='bx bx-copy' onclick="copyCode<?php echo $row[0];?>(this)" data-placement="bottom" title="Copy">
                      
                    </i> 
                    <i class='bx bx-hide' id="revealCode<?php echo $row[0];?>"></i>
                  </p>
                  <p class="element-content-secured" id="eventCode<?php echo $row['event_id'];?>"><?php echo $row['event_code'];?></p>
                </div>
                <div class="element-group col-sm-12 col-lg-4" id="eventBtn">
                  <button class="success-button justify-self-end event-done-btn<?php echo $row['event_id'];?>" id="eventDoneBtn<?php echo $row['event_id'];?>">Mark as Done</button>
                  <div class="button-container more-btn<?php echo $row[0];?>" id="more-btn">
                    <a href="EVE-admin-edit-event.php?eec=<?php echo $row['event_id']?>">
                      <button class="primary-button justify-self-end" id="event-edit-btn<?php echo $row['event_id'];?>"><i class='bx bx-edit-alt'></i>Edit Event</button>
                    </a>
                    <button class="danger-button icon-button" id="event-delete-btn" onclick="showDelete<?php echo $row[0];?>()"><i class='bx bx-trash'></i></button>
                  </div>

                  <script>
                    //Enable Button on Date
                    var markAsDoneButton = document.querySelector('button.event-done-btn<?php echo $row['event_id'];?>');
                    var editEventButton = document.querySelector('button#event-edit-btn<?php echo $row['event_id'];?>');

                    var targetDateTime = new Date('<?php echo $row['event_date'] . ' ' . $row['event_time']; ?>');

                    var currentDateTime = new Date();

                    if (currentDateTime > targetDateTime) {
                      markAsDoneButton.disabled = false;
                      editEventButton.disabled = true;
                    }
                    else {
                      markAsDoneButton.disabled = true;
                      editEventButton.disabled = false;
                    }


                    const moreBtn<?php echo $row[0];?> = document.querySelector(".more-btn<?php echo $row[0];?>");
                    const doneBtn<?php echo $row[0];?> = document.querySelector(".event-done-btn<?php echo $row[0];?>");

                    if (typeof(Storage) !== "undefined") {
                        // If we need to open the bar
                        if(localStorage.getItem("editEvent") == "active"){
                          moreBtn<?php echo $row[0];?>.classList.add("editOpen");
                          doneBtn<?php echo $row[0];?>.classList.add("doneClose");
                          document.querySelector("#edit-event-btn").classList.add("editOpen");
                        }
                        else if (localStorage.getItem("editEvent") == "notActive"){
                          moreBtn<?php echo $row[0];?>.classList.remove("editOpen");
                          doneBtn<?php echo $row[0];?>.classList.remove("doneClose"); 
                          document.querySelector("#edit-event-btn").classList.remove("editOpen");
                        }
                    }

                    const eventCode<?php echo $row[0];?> = document.querySelector("#eventCode<?php echo $row[0];?>");
                    const eye<?php echo $row[0];?> = document.querySelector("#revealCode<?php echo $row[0];?>");

                    function copyCode<?php echo $row[0];?>(element) {
                      // Show tooltip
                      $(element).attr('title', 'Copied');
                      $(element).tooltip('show');

                      // Hide tooltip after a delay
                      setTimeout(function() {
                        $(element).tooltip('hide');
                      }, 1500); // Adjust the delay as needed
                      var range = document.createRange();
                      eventCode<?php echo $row[0];?>.style.webkitTextSecurity = "none";
                      range.selectNode(eventCode<?php echo $row[0];?>);
                      window.getSelection().removeAllRanges(); // clear current selection
                      window.getSelection().addRange(range); // to select text
                      document.execCommand("copy");


                      if(eye<?php echo $row[0];?>.classList.contains("reveal")){
                        eventCode<?php echo $row[0];?>.style.webkitTextSecurity = "none";
                      }
                      else{
                        eventCode<?php echo $row[0];?>.style.webkitTextSecurity = "disc";
                      }

                      window.getSelection().removeAllRanges();// to deselect
                      $(element).removeAttr('data-toggle').removeAttr('title').off('mouseenter mouseleave');
                    }

                    eye<?php echo $row[0];?>.addEventListener("click", function(){
                        if(eye<?php echo $row[0];?>.classList.toggle("reveal")){
                          eye<?php echo $row[0];?>.classList.remove("bx-hide");
                          eye<?php echo $row[0];?>.classList.add("bx-show");
                          eventCode<?php echo $row[0];?>.style.webkitTextSecurity = "none";
                        }
                        else{
                          eye<?php echo $row[0];?>.classList.remove("bx-show");
                          eye<?php echo $row[0];?>.classList.add("bx-hide");
                          eventCode<?php echo $row[0];?>.style.webkitTextSecurity = "disc";
                        }
                    });
                  </script>
                </div>
              </div>
            </div>
        <?php
          endwhile; 
          }
          else{
            ?>
              <div class="header">List of Events</div>
              <div class="text-center" id="no-event-container">
                <i class='bx bx-calendar-x'></i>
                <h1>No Events</h1>
                <p>Looks like you have no events created. <br> You can do so by clicking the button below.</p>
                <div class="row justify-content-center">
                  <a href="EVE-admin-create-event.php?create new event">
                    <button class="primary-button" id="create-new-event-btn">
                      <i class='bx bx-add-to-queue d-flex justify-content-center align-items-center'></i>
                      Create an Event
                    </button>
                  </a>
                </div>
              </div>
            <?php
          }
        ?>
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
    <script type="text/javascript" src="./js/EVE-admin-list-of-events.js"></script>
    <script>

    </script>
  </body>

</html>