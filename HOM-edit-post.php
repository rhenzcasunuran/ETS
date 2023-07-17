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
    <title>Edit Post</title>
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
      $popUpID = "cancel-popup";
      $showPopUpButtonID = "cancel";
      $icon = "<i class='bx bxs-error prompt-icon warning-color'></i>";
      $title = "Discard Changes?";
      $message = "This will delete your progress.<br>You cannot undo this action.";
      $your_link = "HOM-posts.php";
      $id_name = "";
      $id = "";

      include './php/popup-clone-button.php';
    ?>
    <?php 
      $popUpID = "savePost-popup";
      $showPopUpButtonID = "save_post";
      $icon = "<i class='bx bx-save prompt-icon'></i>";
      $title = "Save Changes?";
      $message = "This will save your changes.<br>You can edit this in Posts.";
      $your_link = "";
      $id_name = "";
      $id = "";
      $submitName = "save_post";

      include './php/popup-submit-button.php';
    ?>
    <!--Sidebar-->
    <?php
      $activeModule = 'posts';
      require './php/admin-sidebar.php';
    ?>
    <!--Page Content-->
    <section class="home-section">
      <div class="header">Edit Post</div>
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
              <input type="text" id="title" name="post_title" placeholder="Enter Title" maxlength="60" required value="<?php echo $post_row['post_title'];?>">
            </div>
            <div class="row textbox">
              <h2>Description<span>&nbsp;*</span></h2>
              <textarea id="description" name="post_description" placeholder="Enter Description" maxlength="2000" rows="4" cols="50" required><?php echo $post_row['post_description'];?></textarea>
            </div>
          </div>
          <div class="col-5 column2">
            <h2>Cover</h2>
            <input class="cover" type="file" name="cover" value="<?php echo $post_row['post_cover'];?>">
            <h2>Photo</h2>
            <input class="photo" type="file" name="photo[]" multiple>
            <div class="row buttons">
              <button type="button" class="col outline-button" id="cancel">
                <i class='bx bx-x'></i>
                Cancel
              </button>
              <button type="button" class="col primary-button" id="save_post" disabled>
                <i class='bx bx-save'></i>
                Save
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
    <script src="./js/HOM-edit-post.js"></script>
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