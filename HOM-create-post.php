<?php
  include './php/sign-in.php';
  include './php/database_connect.php';
  include './php/HOM-tags.php';
  include './php/CAL-datetime-fill.php'; // CAL datetime autofill php
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
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
    <form id="post-form" action="./php/HOM-insert-post.php" method="post" enctype="multipart/form-data">
    <?php 
      $popUpID = "cancelPost-popup";
      $showPopUpButtonID = "cancel_post";
      $icon = "<i class='bx bxs-error prompt-icon warning-color'></i>";
      $title = "Cancel Post?";
      $message = "This will delete your progress.<br>You cannot undo this action.";
      $your_link = "HOM-manage-post.php";
      $id_name = "";
      $id = "";

      include './php/popup-clone-button.php';
    ?>
    <?php 
      $popUpID = "saveDraft-popup";
      $showPopUpButtonID = "save_draft";
      $icon = "<i class='bx bx-save prompt-icon warning-color'></i>";
      $title = "Save Draft?";
      $message = "This will save your progress.<br>You can edit this post in Drafts.";
      $your_link = "";
      $id_name = "";
      $id = "";
      $submitName = "save";

      include './php/popup-submit-button.php';
    ?>
    <?php 
      $popUpID = "postNow-popup";
      $showPopUpButtonID = "post_now";
      $icon = "<i class='bx bx-upload prompt-icon warning-color'></i>";
      $title = "Post Now?";
      $message = "This will publish the post now.<br>You can edit this post in Manage Post.";
      $your_link = "";
      $id_name = "";
      $id = "";
      $submitName = "post";

      include './php/popup-submit-button.php';
    ?>  
    <?php
      $popUpID = "postLater-popup";
      $showPopUpButtonID = "post_later";
      $icon = "<i class='bx bx-timer prompt-icon warning-color'></i>";
      $title = "Schedule Post";
      $message = "This will publish the post later.<br>You can edit this post in Schedule Posts.";
      $submitName = "postlater";
    
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
      // Set the active module and sub-active sub-item variables
      $activeModule = 'posts';
      $activeSubItem = 'manage-post';

      // Include the sidebar template
      require './php/admin-sidebar.php';
    ?>
    <!--Page Content-->
    <section class="home-section">
      <div class="header">Create Post</div>
      <div class="container-fluid d-flex row justify-content-center m-0">
        <div class="row element">
          <div class="col-7">
            <div class="row">
              <div class="col textbox">
                <h2>Add to Calendar (Optional)</h2>
                <input type="datetime-local" id="calendar" name="post_calendar">
              </div>
              <div class="col textbox">
                <h2>Tags</h2>
                <select id="tags" name="organization_id" required>
                  <?php echo $options;?>
                </select>
              </div>
            </div>
            <div class="row textbox">
              <h2>Title</h2>
              <input type="text" id="title" name="post_title" placeholder="Enter Title" maxlength="60" required>
            </div>
            <div class="row textbox">
              <h2>Description</h2>
              <textarea id="description" name="post_description" placeholder="Enter Description" maxlength="2000" rows="4" cols="50" required></textarea>
            </div>
          </div>
          <div class="col-5 column2">
            <h2>Cover</h2>
            <input class="cover" type="file" name="cover">
            <h2>Photo</h2>
            <input class="photo" type="file" name="photo[]" multiple>
            <div class="row buttons">
              <button type="button" class="col outline-button" id="cancel_post">
                <i class='bx bx-x'></i>
                &nbsp;Cancel
              </button>
              <button type="button" class="col secondary-button" id="save_draft" disabled>
                <i class='bx bx-save'></i>
                &nbsp;Draft
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
    <script src="./js/HOM-create-post.js"></script>
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
    <!-- Date and Time Helper from Calendar -->
    <script>
      $(document).ready(function() {
        var date = "<?php echo isset($sanitizedDate) ? $sanitizedDate : null; ?>";

        $("#calendar").val(date);
      });
    </script>
  </body>
</html>