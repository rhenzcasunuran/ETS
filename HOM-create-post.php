<?php
  include './php/sign-in.php';
  include './php/database_connect.php';
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
    <link rel="stylesheet" href="./css/system-wide.css">
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/HOM-style.css">
    <link rel="stylesheet" href="./css/HOM-create-post.css">
  </head>

  <body>
    <div class="popup-background" id="cancelWrapper">
      <div class="row popup-container">
        <div class="col-4">
          <i class='bx bxs-error prompt-icon warning-color'></i>
        </div>
        <div class="col-8 text-start text-container">
          <h3 class="text-header">Discard Changes?</h3>
          <p>Any unsaved progress will be lost.</p>
        </div>
        <div class="div">
          <button class="outline-button" onclick="hideCancel()"><i class='bx bx-chevron-left'></i>Return</button>
          <button class="primary-button"><i class='bx bx-x'></i>Discard</button>
        </div>
      </div>
    </div>
    <div class="container-fluid" id="clear-popup">
      <div class="row popup-card">
        <i class='row warning-icon bx bx-reset' ></i>
        <h3 class="row d-flex justify-content-center align-items-center">
          Clear Form?
        </h3>
        <h6 class="row d-flex justify-content-center align-items-center">
          You cannot undo this action.
        </h6>
        <div class="row">
          <div class="col">
            <div id="clear" class="button-clone continue" onclick="hide_clear()">
              &nbsp;Continue
            </div>
          </div>
          <div class="col">
            <div class="button-clone cancel" onclick="hide_clear()">
              &nbsp;Cancel
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid" id="post-popup">
      <div class="row popup-card">
        <i class='row warning-icon bx bx-reset' ></i>
        <h3 class="row d-flex justify-content-center align-items-center">
          Post Now?
        </h3>
        <h6 class="row d-flex justify-content-center align-items-center">
          You can edit thisin Manage Post.
        </h6>
        <div class="row">
          <div class="col">
            <div id="clear" class="button-clone continue" onclick="hide_post()">
              &nbsp;Continue
            </div>
          </div>
          <div class="col">
            <div class="button-clone cancel" onclick="hide_post()">
              &nbsp;Cancel
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Sidebar-->
    <?php
      // Set the active module and sub-active sub-item variables
      $activeModule = 'posts';
      $activeSubItem = 'create-post';

      // Include the sidebar template
      require './php/admin-sidebar.php';
    ?>
    <!--Page Content-->
    <section class="home-section">
      <div class="container">
        <p class="row title">
          Create Post
        </p>
        <form id="post-form" action="./php/HOM-create-post.php" method="post">
          <div class="row create-post">
            <div class="col-7">
              <div class="row">
                <div class="col textbox">
                  <p class="text">
                    Add to Calendar (Optional)
                  </p>
                  <input type="date" id="calendar" name="post_calendar" placeholder="Select Date">
                </div>
                <div class="col textbox">
                  <p class="text">
                    Tag
                  </p>
                  <select id="tag" name="post_tag">
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
                <p class="text">
                  Title
                </p>
                <input type="text" id="title" name="post_title" placeholder="Enter Title" maxlength="60" required>
              </div>
              <div class="row textbox">
                <p class="text">
                  Description
                </p>
                <textarea id="description" name="post_description" placeholder="Enter Description" rows="4" cols="50" required></textarea>
              </div>
            </div>
            <div class="col-5 column2">
              <div>
                <p class="text">
                  Cover
                </p>
                <div class="temp-cover">

                </div>
              </div>
              <div>
                <p class="text">
                  Photos
                </p>
                <div class="temp-photos">

                </div>
              </div>
              <div class="row buttons">
                <div class="col outline-button" onclick="show_clear()">
                  <i class='bx bx-reset'></i>
                  &nbsp;Clear
                </div>
                <button class="col secondary-button">
                  <i class='bx bx-save'></i>
                  &nbsp;Save
                </button>
                <button class="col primary-button" type="submit" name="post">
                  <i class='bx bx-upload'></i>
                  &nbsp;Post
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
    <!-- Date and Time Helper from Calendar -->
    <script>
      $(document).ready(function() {
        var date = "<?php echo isset($sanitizedDate) ? $sanitizedDate : null; ?>";

        $("#calendar").val(date);
      });
    </script>
  </body>
</html>