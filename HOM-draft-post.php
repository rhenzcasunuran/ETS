<?php
  include './php/sign-in.php';
  include './php/database_connect.php';
  include './php/HOM-get-drafts.php';
  include './php/HOM-delete-post.php';
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
    <link rel="stylesheet" href="./css/HOM-style.css">
    <link rel="stylesheet" href="./css/HOM-list.css">
  </head>

  <body>
    <!--Sidebar-->
    <?php
      // Set the active module and sub-active sub-item variables
      $activeModule = 'posts';
      $activeSubItem = 'draft-post';

      // Include the sidebar template
      require './php/admin-sidebar.php';
    ?>
    <!--Page Content-->
    <section class="home-section">
      <div class="container">
        <p class="row title">
          Draft Post
        </p>
        <?php
          $row = mysqli_num_rows($get_posts);
          if($row > 0){
            while($count = mysqli_fetch_array($get_posts)){
        ?>
              <div class="container-fluid" id="popup">
                <div class="row popup-card">
                  <i class='row warning-icon bx bx-trash' ></i>
                  <h3 class="row d-flex justify-content-center align-items-center">
                    Delete Post?
                  </h3>
                  <h6 class="row d-flex justify-content-center align-items-center">
                    You cannot undo this action.
                  </h6>
                  <div class="row">
                    <div class="col">
                      <a href="HOM-manage-post.php?eed=<?php echo $count[0]?>" class="text-decoration-none" onclick="hide()">
                        <div id="clear" class="button-clone continue" onclick="hide()">
                          &nbsp;Continue
                        </div>
                      </a>
                    </div>
                    <div class="col">
                      <div class="button-clone cancel" onclick="hide()">
                        &nbsp;Cancel
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row manage-post">
                <div class="col-7">
                  <div class="row">
                    <p class="data">
                      Title
                    </p>
                  </div>
                  <div class="row">
                    <p class="data-value">
                      <?php echo $count[3];?>
                    </p>
                  </div>
                </div>
                <div class="col-2">
                  <div class="row">
                    <p class="data">
                      Tag
                    </p>
                  </div>
                  <div class="row">
                    <p class="data-value">
                      <?php echo $count[2];?>
                    </p>
                  </div>
                </div>
                <div class="col-2">
                  <a href="HOM-edit-draft.php?eec=<?php echo $count[0]?>" class="text-decoration-none">
                    <button class="button-clone edit-post">
                      <i class='bx bx-edit'></i>
                      &nbsp;Edit Draft
                    </button>
                  </a>
                </div>
                <div class="col-1">
                  <div class="button-clone delete" onclick="show()">
                    <i class='bx bx-trash'></i>
                  </div>
                </div>
              </div>
        <?php
            }
          }
          else{
        ?>
              <div class="text-center" id="no-post-container">
                <i class='bx bx-calendar-x'></i>
                <h1>No Posts</h1>
                <p>Looks like there are no posts created.</p>
                <a href="create_event.php?create new event">
                </a>
              </div>
        <?php
          }
        ?>
      </div>
    </section>
    <!-- Scripts -->
    <script src="./js/script.js"></script>
    <script src="./js/jquery-3.6.4.js"></script>
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