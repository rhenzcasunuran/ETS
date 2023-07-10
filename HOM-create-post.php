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
    <title>Configuration</title>
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
  </head>

  <body>
    <form id="post-form" action="./php/HOM-insert-post.php" method="post" enctype="multipart/form-data">
    <div class="popup-background" id="cancelPost-popup">
      <div class="row popup-container">
        <div class="col-4">
          <i class='bx bxs-error prompt-icon warning-color'></i>
        </div>
        <div class="col-8 text-start text-container">
          <h3 class="text-header">Cancel Post?</h3>
          <p>This will delete your progress. You cannot undo this action.</h2>
        </div>
        <div class="div">
          <div class="outline-button" onclick="hide_cancelPost()"><i class='bx bx-chevron-left'></i>Return</div>
          <a href="HOM-manage-post.php" class="text-decoration-none">
            <div id="clear" class="primary-button">Continue<i class='bx bx-chevron-right'></i></div>
          </a>
        </div>
      </div>
    </div>
    <div class="popup-background" id="saveDraft-popup">
      <div class="row popup-container">
        <div class="col-4">
          <i class='bx bx-save prompt-icon warning-color'></i>
        </div>
        <div class="col-8 text-start text-container">
          <h3 class="text-header">Save Draft?</h3>
          <p>This will save your progress. You can edit this post in Drafts.</h2>
        </div>
        <div class="div">
          <div class="outline-button" onclick="hide_saveDraft()"><i class='bx bx-chevron-left'></i>Return</div>
          <button class="primary-button" type="submit" name="save"><i class='bx bx-save'></i>Continue</button>
        </div>
      </div>
    </div>
    <div class="popup-background" id="postNow-popup">
      <div class="row popup-container">
        <div class="col-4">
          <i class='bx bx-upload prompt-icon warning-color'></i>
        </div>
        <div class="col-8 text-start text-container">
          <h3 class="text-header">Post Now?</h3>
          <p>This will publish the post now. You can edit this post in Manage Post.</h2>
        </div>
        <div class="div">
          <div class="outline-button" onclick="hide_postNow()"><i class='bx bx-chevron-left'></i>Return</div>
          <button class="primary-button" type="submit" name="post"><i class='bx bx-upload'></i>Continue</button>
        </div>
      </div>
    </div>
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
      <div class="container">
        <h1 class="row">
          Create Post
        </h1>
          <div class="row config">
            <div class="col-7">
              <div class="row">
                <div class="col textbox">
                  <h2>
                    Add to Calendar (Optional)
                  </h2>
                  <input type="date" id="calendar" name="post_calendar" placeholder="Select Date">
                </div>
                <div class="col textbox">
                  <h2>
                    Tags
                  </h2>
                  <select id="tags" name="organization_id" required>
                    <?php echo $options;?>
                  </select>
                </div>
              </div>
              <div class="row textbox">
                <h2>
                  Title
                </h2>
                <input type="text" id="title" name="post_title" placeholder="Enter Title" maxlength="60" required>
              </div>
              <div class="row textbox">
                <h2>
                  Description
                </h2>
                <textarea id="description" name="post_description" placeholder="Enter Description" maxlength="2000" rows="4" cols="50" required></textarea>
              </div>
            </div>
            <div class="col-5 column2">
              <div>
                <h2>
                  Cover
                </h2>
                <div class="temp-cover">
                  <input type="file" name="cover">
                </div>
              </div>
              <div>
                <h2>
                  Photo
                </h2>
                <div class="temp-photos">
                  <input type="file" name="photo[]" multiple>
                </div>
              </div>
              <div class="row buttons">
                <div class="col outline-button" onclick="show_cancelPost()">
                  <i class='bx bx-x'></i>
                  &nbsp;Cancel
                </div>
                <div class="col secondary-button" id="save_draft" onclick="show_saveDraft()">
                  <i class='bx bx-save'></i>
                  &nbsp;Draft
                </div>    
                <div class="col post-menu primary-button" id="post">
                  <i class='bx bx-upload'></i>
                  &nbsp;Post
                  <div class="post-menu-content">
                    <a href="#" class="post-now" id="post_now" onclick="show_postNow()">Now</a>
                    <a href="#" class="post-later">Later</a>
                    <a href="#" class="no-hover">
                      <i class='bx bx-upload'></i>
                      &nbsp;Post
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </section>
    </form>
    <!-- Scripts -->
    <script src="./js/script.js"></script>
    <script src="./js/jquery-3.6.4.js"></script>
    <script src="./js/HOM-create-post.js"></script>
    <script src="./js/HOM-popup.js"></script>
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