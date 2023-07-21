<?php
  include './php/database_connect.php';
  include './php/HOM-get-post.php';
  include './php/admin-signin.php';
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Tabulation System</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="./css/theme-mode.css">
    <script src="./js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <link rel="stylesheet" href="./css/home-sidebar-style.css">
    <link rel="stylesheet" href="./css/system-wide.css">
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/HOM-index.css">
  </head>

  <body>
    <div class="container-fluid" id="popup">
      <div class="row popup-card">
        <form method="post">
          <div class="row">
            <div class="col-11 admin-text">
              <p>
                Administrator
              </p>
            </div>
            <div class="col-1 close ">
              <i class='bx bx-x' onclick="hide()"></i>
            </div>
          </div>
          <div class="row">
            <input type="text" name="user_username" placeholder="Username" maxlength="20" required/>
          </div>
          <div class="row">
            <input type="password" name="user_password" placeholder="Password" maxlength="128" required/>
          </div>
          <div class="row justify-content-center">
            <button input type="submit" name="sign-in-button" class="sign-in-button">Sign In</button>
          </div>
        </form>
      </div>
    </div>
    <!--SIDEBAR-->
    <?php
      $activeModule = 'home';
      require './php/student-sidebar.php';
    ?>
    <!--PAGE-->
    <section class="home-section">
        <div class="row header filters">
          <button class="col filter-button active-filter" data-filter="ALL">
            All
          </button>
          <button class="col filter-button" data-filter="SC">
            SC
          </button>
          <button class="col filter-button" data-filter="ACAP">
            ACAP
          </button>
          <button class="col filter-button" data-filter="AECES">
            AECES
          </button>
          <button class="col filter-button" data-filter="ELITE">
            ELITE
          </button>
          <button class="col filter-button" data-filter="GIVE">
            GIVE
          </button>
          <button class="col filter-button" data-filter="JEHRA">
            JEHRA
          </button>
          <button class="col filter-button" data-filter="JMAP">
            JMAP
          </button>
          <button class="col filter-button" data-filter="JPIA">
            JPIA
          </button>
          <button class="col filter-button" data-filter="PIIE">
            PIIE
          </button>
        </div>
        <div class="container-fluid d-flex row justify-content-center">
          <div class="post-container element" id="post-container">
            <?php
              $no_post = false;
              $row = mysqli_num_rows($get_posts);
              if($row > 0){
                while($row = mysqli_fetch_array($get_posts)){
                  $date = date("F d, Y", strtotime($row['post_schedule']));
                  $time = date("h:i A", strtotime($row['post_schedule']));

            ?>
              <a href="HOM-post.php?eec=<?php echo $row['post_id'];?>" class="post-click ALL <?php echo $row['organization_name'];?>">
                <div class="post-card <?php echo $row['organization_name'];?>">
                  <img class="post-cover" src="post/<?php echo $row['post_cover'];?>">
                  <div class="post-detail">
                    <p class="post-date">
                    <?php echo $row['organization_name'];?> · <?php echo $date;?> · <?php echo $time;?>
                    </p>
                    <div class="post-title-container">
                      <p class="post-title-text">
                        <?php echo $row[3];?>
                      </p>
                    </div>
                  </div>
                </div>
              </a>
            <?php
                }
            ?>
              <div class="text-center" id="no-post-container">
                <img class="p-2 img-fluid" id="noEvents" src="./pictures/HOM-student.svg" alt="No Events">
                <h1>No Posts</h1>
              </div>
            <?php
              }
              else{
            ?>
                <div class="text-center" id="no-event-container">
                  <img class="p-2 img-fluid" id="noEvents" src="./pictures/HOM-student.svg" alt="No Events">
                  <h1>No Posts</h1>
                </div>
            <?php
              }
            ?>
          </div>
        </div>
    </section>
    <!--SCRIPT -->
    <script src="./js/script.js"></script>
    <script src="./js/change-theme.js"></script>
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
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        // Get all filter buttons
        const filterButtons = document.querySelectorAll(".filter-button");

        // Get all image divs
        const cards = document.querySelectorAll(".post-click");

        // Get the scroll container element
        const scrollContainer = document.getElementById("post-container");

        // Add click event listener to each filter button
        filterButtons.forEach(function(button) {
          button.addEventListener("click", function() {
            // Remove 'active' class from all buttons
            filterButtons.forEach(function(btn) {
              btn.classList.remove("active-filter");
            });

            // Add 'active' class to the clicked button
            this.classList.add("active-filter");

            // Get the data-filter attribute value
            const filterValue = this.getAttribute("data-filter");

            // Show/hide image divs based on the filter value
            const noPostContainer = document.getElementById("no-post-container");
            let allCardsValid = false;
            cards.forEach(function(div) {
              if (filterValue === "ALL" || div.classList.contains(filterValue)) {
                div.style.display = "block"; // Show the image div
                allCardsValid = true;
              } else {
                div.style.display = "none"; // Hide the image div
              }
            });
            if (allCardsValid) {
              noPostContainer.style.display = "none";
            } else {
              noPostContainer.style.display = "grid";
            }
            // Scroll back to the top of the container
            scrollContainer.scrollLeft = 0;
          });
        });
      });
    </script>
  </body>
</html>