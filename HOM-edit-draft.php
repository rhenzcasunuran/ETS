<?php
  include './php/sign-in.php';
  include './php/database_connect.php';
  include './php/HOM-tags.php';
  include './php/HOM-update-post.php';
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Draft</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="./css/theme-mode.css">
    <script src="./js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/system-wide.css">
    <link rel="stylesheet" href="./css/HOM-config.css">

    <script type="text/javascript" src="./js/jquery-3.6.4.js"></script>
  </head>

  <body>
    <form id="post-form" method="post" enctype="multipart/form-data">
    <?php 
      $popUpID = "cancelPost-popup";
      $showPopUpButtonID = "cancel_post";
      $icon = "<i class='bx bxs-error prompt-icon warning-color'></i>";
      $title = "Cancel Post?";
      $message = "This will delete your progress.<br>You cannot undo this action.";
      $your_link = "HOM-drafts.php";
      $id_name = "";
      $id = "";

      include './php/popup-clone-button.php';
    ?>
    <?php 
      $popUpID = "saveDraft-popup";
      $showPopUpButtonID = "save_draft";
      $icon = "<i class='bx bx-save prompt-icon'></i>";
      $title = "Save Changes?";
      $message = "This will save your changes.<br>You can edit this in Drafts.";
      $your_link = "";
      $id_name = "";
      $id = "";
      $submitName = "save_draft";

      include './php/popup-submit-button.php';
    ?> 
    <?php 
      $popUpID = "postNow-popup";
      $showPopUpButtonID = "post_now";
      $icon = "<i class='bx bx-upload prompt-icon'></i>";
      $title = "Post Now?";
      $message = "This will publish the draft now.<br>You can edit this in Posts.";
      $your_link = "";
      $id_name = "";
      $id = "";
      $submitName = "post_now";

      include './php/popup-submit-button.php';
    ?>  
    <?php
      $popUpID = "postLater-popup";
      $showPopUpButtonID = "post_later";
      $icon = "<i class='bx bx-timer prompt-icon'></i>";
      $title = "Schedule Post";
      $message = "This will publish the draft later.<br>You can edit this in Schedules.";
      $submitName = "post_later";
    
      echo "<div class=\"popUpDisableBackground\" id=\"$popUpID\">
        <div class=\"popUpContainer\">
          $icon
          <div class=\"popUpHeader\">$title</div>
          <input type=\"datetime-local\" id=\"schedule\" name=\"post_schedule\">
          <div class=\"popUpMessage\">$message</div>
          <div class=\"popUpButtonContainer\">
            <div class=\"secondary-button\" id=\"$popUpID\"><i class='bx bx-x'></i>Cancel</div>
            <button class=\"primary-button confirmPopUp\" type=\"submit\" name=\"$submitName\"><i class='bx bx-check'></i>Confirm</button>
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

              $('#schedule').click(function(event) {
                event.stopPropagation();
              });
          });
        </script>
      </div>"
    ?>
    <!--Sidebar-->
    <?php
      $activeModule = 'posts';
      require './php/admin-sidebar.php';
    ?>
    <!--Page Content-->
    <section class="home-section">
      <div class="header">Edit Draft</div>
      <div class="container-fluid d-flex row justify-content-center m-0">
        <div class="row element">
          <div class="col-7">
            <div class="row">
              <div class="col textbox">
                <h2>Add to Calendar</h2>
                <input type="datetime-local" id="calendar" name="post_calendar" value="<?php echo $post_row['post_calendar'];?>">
              </div>
              <div class="col textbox">
                <h2>Tags<span>&nbsp;*</span></h2>
                <select id="tags" name="organization_id" required>
                  <?php echo $options;?>
                </select>
              </div>
            </div>
            <div class="row textbox">
              <h2>Title<span>&nbsp;*</span></h2>
              <input type="text" id="title" name="post_title" placeholder="Enter Title (5-50 Characters)" maxlength="60" required value="<?php echo $post_row['post_title'];?>">
            </div>
            <div class="row textbox">
              <h2>Description<span>&nbsp;*</span></h2>
              <textarea id="description" name="post_description" placeholder="Enter Description (50-2000 Characters)" maxlength="2000" rows="4" cols="50" required><?php echo $post_row['post_description'];?></textarea>
            </div>
          </div>
          <div class="col-5 column2">
            <h2>Cover</h2>
            <input class="cover" type="file" name="cover" value="<?php echo $post_row['post_cover'];?>">
            <h2>Photo</h2>
            <input class="photo" type="file" name="photo[]" multiple>
            <div class="row buttons">
              <button type="button" class="col outline-button" id="cancel_post">
                <i class='bx bx-x'></i>
                &nbsp;Cancel
              </button>
              <button type="button" class="col secondary-button" id="save_draft" disabled>
                <i class='bx bx-save'></i>
                &nbsp;Save
              </button>    
              <button type="button" class="col post-menu primary-button" id="post" disabled>
                <i class='bx bx-upload'></i>
                &nbsp;Post
                <div class="post-menu-content">
                  <a href="#" class="post-now" id="post_now">Now</a>
                  <a href="#" class="post-later" id="post_later">Later</a>
                  <a href="#" class="no-hover">
                    <i class='bx bx-upload'></i>
                    &nbsp;Post
                  </a>
                </div>
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>
    </form>
    <!-- Scripts -->
    <script src="./js/script.js"></script>
    <script>
      //get calendar
      var existingCalendar = "<?php echo $post_row['post_calendar'];?>";

      var dateInput = document.getElementById("calendar");

      dateInput.value = existingCalendar;

      //get tags
      var selectedTags = "<?php echo $post_row['organization_id'];?>";

      var selectElement = document.getElementById("tags");

      for (var i = 0; i < selectElement.options.length; i++) {
        if (selectElement.options[i].value === selectedTags) {
          selectElement.options[i].selected = true;
          break;
        }
      }
    </script>
    <script src="./js/HOM-edit-draft.js"></script>
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
  </body>
</html>