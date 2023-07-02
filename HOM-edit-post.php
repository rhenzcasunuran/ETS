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
    <form id="post-form" method="post">
    <div class="popup-background" id="discardChanges-popup">
      <div class="row popup-container">
        <div class="col-4">
          <i class='bx bxs-error prompt-icon warning-color'></i>
        </div>
        <div class="col-8 text-start text-container">
          <h3 class="text-header">Discard Changes?</h3>
          <p>This will delete your progress. You cannot undo this action.</h2>
        </div>
        <div class="div">
          <div class="outline-button" onclick="hide_discardChanges()"><i class='bx bx-chevron-left'></i>Return</div>
          <a href="HOM-manage-post.php" class="text-decoration-none">
            <div id="clear" class="primary-button"><i class='bx bx-x'></i>Continue</div>
          </a>
        </div>
      </div>
    </div>
    <div class="popup-background" id="savePost-popup">
      <div class="row popup-container">
        <div class="col-4">
          <i class='bx bx-upload prompt-icon warning-color'></i>
        </div>
        <div class="col-8 text-start text-container">
          <h3 class="text-header">Save Changes?</h3>
          <p>This will save your progress. You can edit this post anytime.</h2>
        </div>
        <div class="div">
          <div class="outline-button" onclick="hide_savePost()"><i class='bx bx-chevron-left'></i>Return</div>
          <button class="primary-button" type="submit" name="save_post"><i class='bx bx-upload'></i>Continue</button>
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
        <h1 class="row title">
          Edit Post
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
                  <select id="tags" name="organization_id" >
                    <?php echo $options;?>
                  </select>
                </div>
              </div>
              <div class="row textbox">
                <h2>
                  Title
                </h2>
                <input type="text" id="title" name="post_title" placeholder="Enter Title" maxlength="60" value="<?php echo $post_row['post_title'];?>" required>
              </div>
              <div class="row textbox">
                <h2>
                  Description
                </h2>
                <textarea id="description" name="post_description" placeholder="Enter Description" maxlength="2000" rows="4" cols="50" required><?php echo $post_row['post_description'];?></textarea>
              </div>
            </div>
            <div class="col-5 column2">
              <div>
                <h2>
                  Cover
                </h2>
                <div class="temp-cover">

                </div>
              </div>
              <div>
                <h2>
                  Photos
                </h2>
                <div class="temp-photos">

                </div>
              </div>
              <div class="row buttons">
                <div class="col outline-button" onclick="show_discardChanges()">
                  <i class='bx bx-x'></i>
                  &nbsp;Discard Changes
                </div>
                <div class="col primary-button" id="save_post">
                  <i class='bx bx-upload'></i>
                  &nbsp;Save Changes
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
  </body>
</html>