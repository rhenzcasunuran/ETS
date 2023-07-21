<?php
  include './php/sign-in.php';
  include './php/database_connect.php';
  include './php/HOM-get-schedule.php';
  include './php/HOM-delete-post.php';
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedules</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="./css/theme-mode.css">
    <script src="./js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <link rel="stylesheet" href="./css/system-wide.css">
    <link rel="stylesheet" href="./css/HOM-list.css">

    <!-- Event Config Styles -->
    <link rel="stylesheet" href="./css/EVE-admin-bootstrap-select.min.css">
    <link rel="stylesheet" href="./css/EVE-admin-bootstrap4.min.css">
    <link rel="stylesheet" href="./css/EVE-admin-list-of-events.css">
    <link rel="stylesheet" href="./css/EVE-admin-confirmation.css">
    <link rel="stylesheet" href="./css/multiselection.css">

    <script src="./js/jquery-3.6.4.js"></script>
  </head>

  <body>
    <!--Sidebar-->
    <?php
      $activeModule = 'posts';
      require './php/admin-sidebar.php';
    ?>
    <!--Page Content-->
    <section class="home-section">
    <form method="POST" id="listFormContainer"> 
      <?php 
        $popUpID = "deletePost-popup";
        $showPopUpButtonID = "delete-event-btn";
        $icon = "<i class='bx bxs-trash prompt-icon danger-color'></i>";
        $title = "Delete Schedule?";
        $message = "You cannot undo this action.";
        $your_link = "";
        $id_name = "";
        $id = "";
        $submitName = "deb";

        echo "<div class=\"popUpDisableBackground\" id=\"$popUpID\">
          <div class=\"popUpContainer\">
            $icon
            <div class=\"popUpHeader\">$title</div>
            <div class=\"popUpMessage\">$message</div>
            <div class=\"popUpButtonContainer\">
              <div class=\"secondary-button\" id=\"$popUpID\"><i class='bx bx-x'></i>Cancel</div>
              <button type=\"submit\" class=\"primary-button confirmPopUp\" name=\"$submitName\"><i class='bx bx-trash'></i>Confirm</button>
            </div>
          </div>
          <script>
              $(document).ready(function() {
                  $('#$popUpID').click(function() {
                      $('.popUpDisableBackground#$popUpID').addClass('hide');
                      setTimeout(function() {
                          $('.popUpDisableBackground#$popUpID').css('visibility', 'hidden');
                          $('.popUpDisableBackground#$popUpID').removeClass('hide');
                      }, 300);
                      $('.popUpContainer').removeClass('show');
                  });

                  $('.popUpDisableBackground#$popUpID').click(function() {
                      $('.popUpDisableBackground#$popUpID').addClass('hide');
                      setTimeout(function() {
                          $('.popUpDisableBackground#$popUpID').css('visibility', 'hidden');
                          $('.popUpDisableBackground#$popUpID').removeClass('hide');
                      }, 300);
                      $('.popUpContainer').removeClass('show');
                  });

                  $('.confirmPopUp').click(function() {
                      $('.popUpDisableBackground#$popUpID').css('visibility', 'hidden');
                      $('.popUpContainer').removeClass('show');
                  });

                  $('#$showPopUpButtonID').click(function() {
                      $('.popUpDisableBackground#$popUpID').css('visibility', 'visible');
                      $('.popUpContainer').addClass('show');
                  });
              });
          </script>
        </div>"
      ?>
      <div class="container-fluid d-flex row justify-content-center m-0" id="event-wrapper">
        <?php
          $row = mysqli_num_rows($event_result2);
          if ($row > 0){
            ?>
                <!--Pagination-->
            <?php
              $list_table_query = "SELECT * FROM post INNER JOIN organization 
              ON post.organization_id = organization.organization_id 
              WHERE post.post_draft = 0 && post_schedule >= '$current_date' 
              ORDER BY post.post_schedule ASC";
              $your_php_location = "HOM-schedules.php";
              require './php/pagination.php';
              $list_table_query_with_limit = "SELECT * FROM post INNER JOIN organization 
              ON post.organization_id = organization.organization_id 
              WHERE post.post_draft = 0 && post_schedule >= '$current_date' 
              ORDER BY post.post_schedule ASC
              LIMIT $start_from, $numberOfItems;";
              $listedItems = mysqli_query($conn, $list_table_query_with_limit);
            ?>  
              <style>
                #event-wrapper {
                  padding-bottom: 80px;
                }
              </style>    
              <div class="row d-flex justify-content-between align-items-center w-100">
                <div class="header col-7">
                  <a href="HOM-posts.php">
                    <i class='back bx bx-arrow-back'></i>
                  </a>
                  Post Schedules
                </div>
                <div class="button-container col-5">
                  <a href="HOM-create-post.php" data-toggle="tooltip" data-placement="bottom" title="Create Post">
                    <button class="primary-button icon-button" id="create-post"><i class='bx bx-message-square-dots'></i></button>
                  </a>
                  <button type="button" class="danger-button icon-button" id="delete-event-btn"><i class='bx bx-trash'></i></button>
                  <button class="secondary-button icon-button" id="edit-event-btn"><i class='bx bx-edit'></i></button>
                </div>
              </div>
            <?php
            while ($row = mysqli_fetch_array($listedItems)):;
            ?>
            <div class="element">
              <div class="multi-select" id="multiSelect<?php echo $row['post_id'];?>">
                <input type="checkbox" name="deleteEvent[]" value="<?php echo $row['post_id'];?>">
              </div>
              <div class="row">
                <div class="element-group col-sm-6 col-lg-6">
                  <p class="element-label">Title</p>
                  <p class="element-content"><?php echo $row['post_title'];?></p>
                </div>
                <div class="element-group col-sm-6 col-lg-2">
                  <p class="element-label">Tag</p>
                  <p class="element-content"><?php echo $row['organization_name'];?></p>
                </div>
                <div class="element-group col-sm-6 col-lg-4">
                  <p class="element-label">Scheduled</p>
                  <p class="element-content">
                    <?php
                      $date = date("F d, Y", strtotime($row['post_schedule']));
                      $time = date("h:i A", strtotime($row['post_schedule']));
                    ?>
                    <?php echo $date;?> · <?php echo $time;?>
                  </p>
                </div>
              </div>
              <div class="row">
                <div class="element-group col-sm-6 col-lg-6">
                  <p class="element-label">Description</p>
                  <p class="element-content"><?php echo $row['post_description'];?></p>
                </div>
                <div class="element-group col-sm-12 col-lg-6" id="eventBtn">
                  <div class="button-container more-btn<?php echo $row[0];?>" id="more-btn">
                      <button class="primary-button justify-self-end" id="event-edit-btn<?php echo $row['post_id'];?>"><i class='bx bx-edit-alt'></i>Edit</button>
                  </div>

                  <script>
                    $(document).ready(function() {
                      $("#event-edit-btn<?php echo $row['post_id'];?>").click(function(event) {
                        event.preventDefault(); // Prevent default form submission
                      
                        window.location.href = "HOM-edit-schedule.php?eec=<?php echo $row['post_id']?>";
                      });
                    });

                    const moreBtn<?php echo $row[0];?> = document.querySelector(".more-btn<?php echo $row[0];?>");
                    const multiSelect<?php echo $row[0]?> = document.querySelector("#multiSelect<?php echo $row[0]?>");

                    if (typeof(Storage) !== "undefined") {
                        // If we need to open the bar
                        if(localStorage.getItem("editEvent") == "active"){
                          moreBtn<?php echo $row[0];?>.classList.add("editOpen");
                          multiSelect<?php echo $row[0]?>.classList.add("deleteOpen");
                          document.querySelector("#edit-event-btn").classList.add("editOpen");
                        }
                        else if (localStorage.getItem("editEvent") == "notActive"){
                          moreBtn<?php echo $row[0];?>.classList.remove("editOpen");
                          multiSelect<?php echo $row[0]?>.classList.remove("deleteOpen");
                          document.querySelector("#edit-event-btn").classList.remove("editOpen");
                        }
                    }
                  </script>
                </div>
              </div>
            </div>
        <?php
          endwhile; 
        ?>
          <script type="text/javascript" src="./js/EVE-admin-list-of-events.js"></script>
        <?php
          }
          else{
            ?>
              <div class="header">
                <a href="HOM-posts.php">
                  <i class='back bx bx-arrow-back'></i>
                </a>
                Post Schedules
              </div>
              <div class="text-center" id="no-event-container">
                <img class="p-2 img-fluid" id="noEvents" src="./pictures/HOM-admin.svg" alt="No Events">
                <h1>No Schedules</h1>
                <p>Looks like you have no schedule created.<br>You can do so by clicking the button below.</p>
                <div class="row justify-content-center">
                  <button class="primary-button" id="create-new-event-btn">
                    <i class='bx bx-message-square-dots d-flex justify-content-center align-items-center'></i>
                      Create Post
                  </button>
                </div>
              </div>
              
              <script>
                  $(document).ready(function() {
                    $("#create-new-event-btn").click(function(event) {
                      event.preventDefault(); // Prevent default form submission
                      
                      window.location.href = "HOM-create-post.php";
                    });
                  });
              </script>
            <?php
          }
        ?>
      </div>
      </form> 
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

      $()

      if (typeof(Storage) !== "undefined") {
          // If we need to open the bar
          if(localStorage.getItem("editEvent") == "active"){
            $('#create-post').addClass("createNot");
            $('#drafts').addClass("createNot");
            $('#schedules').addClass("createNot");
            $('#delete-event-btn').addClass("deleteActive");
          }
          else if (localStorage.getItem("editEvent") == "notActive"){
            $('#create-post').removeClass("createNot");
            $('#drafts').removeClass("createNot");
            $('#schedules').removeClass("createNot");
            $('#delete-event-btn').removeClass("deleteActive");
          }
      }      

      $(document).ready(function() {
        $("#create-post").click(function(event) {
          event.preventDefault(); // Prevent default form submission
                      
          window.location.href = "HOM-create-post.php";
        });
      });

    </script>

    <!-- Event Config Scripts -->
    <script type="text/javascript" src="./js/EVE-admin-bootstrap4.bundle.min.js"></script>
    <script type="text/javascript" src="./js/EVE-admin-bootstrap-select.min.js"></script>
    <script type="text/javascript" src="./js/EVE-admin-bootstrap-select-picker.js"></script>
    <script>

    </script>
  </body>

</html>