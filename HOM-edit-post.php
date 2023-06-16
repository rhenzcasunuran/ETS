<?php
  include './php/sign-in.php';
  include './php/database_connect.php';
  include './php/HOM-edit-post.php';
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
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/HOM-style.css">
    <link rel="stylesheet" href="./css/HOM-config.css">
  </head>

  <body>
    <div class="popup-background" id="discardChanges-popup">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-error prompt-icon warning-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Discard Changes?</h3>   <!--header-->
                <p>Any unsaved progress will be lost.</h2> <!--text-->
            </div>
            <div  class="div">
                <button class="outline-button" onclick="hide_discardChanges()"><i class='bx bx-chevron-left'></i>Return</button>
                <a href="HOM-manage-post.php" class="text-decoration-none">
                  <button class="primary-button"><i class='bx bx-x'></i>Discard</button>
                </a>
            </div>
        </div>
    </div>
    <!--Sidebar-->
    <?php
      // Set the active module and sub-active sub-item variables
      $activeModule = 'posts';
      $activeSubItem = 'edit-post';

      // Include the sidebar template
      require './php/admin-sidebar.php';
    ?>
    <!--Page Content-->
    <section class="home-section">
      <div class="container">
        <h1 class="row title">
          Edit Post
        </h1>
        <form id="post-form" method="post">
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
                    Tag
                  </h2>
                  <select id="tag" name="post_tag" >
                    <option value="SC">Student Council</option>
                    <option value="ACAP">ACAP</option>
                    <option value="AECES">AECES</option>
                    <option value="ELITE">ELITE</option>
                    <option value="GIVE">GIVE</option>
                    <option value="JEHRA">JEHRA</option>
                    <option value="JMAP">JMAP</option>
                    <option value="JPIA">JPIA</option>
                    <option value="PIIE">PIIE</option>
                  </select>
                </div>
              </div>
              <div class="row textbox">
                <h2>
                  Title
                </h2>
                <input type="text" id="title" name="post_title" placeholder="Enter Title" maxlength="60" value="<?php echo $post_row[3];?>" required>
              </div>
              <div class="row textbox">
                <h2>
                  Description
                </h2>
                <textarea id="description" name="post_description" placeholder="Enter Description" rows="4" cols="50" required><?php echo $post_row[4];?></textarea>
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
                <div class="col-6 outline-button" onclick="show_discardChanges()">
                    Discard Changes
                </div>
                <button class="col-6 primary-button" type="submit" name="post">
                    Save Changes
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </section>
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
    <script>
      //get calendar
      var existingCalendar = "<?php echo $post_row[1];?>";

      var dateInput = document.getElementById("calendar");

      dateInput.value = existingCalendar;

      //get tag
      var selectedTag = "<?php echo $post_row[2];?>";

      var selectElement = document.getElementById("tag");

      for (var i = 0; i < selectElement.options.length; i++) {
        if (selectElement.options[i].value === selectedTag) {
          selectElement.options[i].selected = true;
          break;
        }
      }
    </script>
  </body>
</html>