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
    <title>Configuration</title>
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
      // Set the active module and sub-active sub-item variables
      $activeModule = 'home';

      // Include the sidebar template
      require './php/student-sidebar.php';
    ?>
    <!--PAGE-->
    <section class="home-section">
      <div class="container">
        <div class="row filters">
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
        <div class="post-container post-snap" id="post-container">
          <?php
            $row = mysqli_num_rows($get_posts);
            if($row > 0){
              while($row = mysqli_fetch_array($get_posts)){
                $date = date("F d, Y", strtotime($row[6]));
          ?>
            <a href="HOM-post.php?eec=<?php echo $row['post_id']?>" class="post-click ALL <?php echo $row['organization_name'];?>">
              <div class="post-card">
                <img class="post-cover" src="photos/cover-<?php echo $row['organization_name'];?>.png">
                <div class="post-detail">
                  <p class="post-date">
                    Posted on <?php echo $date;?>
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
        <div class="row category">
          <div class="col">
            <p class="row category-text">
              Tournaments
            </p>
            <div class="row category-container mx-auto">
              <div class="row category-card mx-auto">
                <div class="col category-column">
                  <p class="row tournament-score">
                    1
                  </p>
                  <p class="row tournament-org ELITE">
                    ELITE
                  </p>
                </div>
                <div class="col category-column">
                  <img class="row tournament-sport" src="photos/basketball.png">
                  <p class="row tournament-vs">
                    VS
                  </p>
                </div>
                <div class="col category-column">
                  <p class="row tournament-score">
                    2
                  </p>
                  <p class="row tournament-org AECES">
                    AECES
                  </p>
                </div>
              </div>
              <div class="row category-card mx-auto">
                <div class="col category-column">
                  <p class="row tournament-score">
                    1
                  </p>
                  <p class="row tournament-org ELITE">
                    ELITE
                  </p>
                </div>
                <div class="col category-column">
                  <img class="row tournament-sport" src="photos/basketball.png">
                  <p class="row tournament-vs">
                    VS
                  </p>
                </div>
                <div class="col category-column">
                  <p class="row tournament-score">
                    2
                  </p>
                  <p class="row tournament-org AECES">
                    AECES
                  </p>
                </div>
              </div>
              <div class="row category-card mx-auto">
                <div class="col category-column">
                  <p class="row tournament-score">
                    1
                  </p>
                  <p class="row tournament-org ELITE">
                    ELITE
                  </p>
                </div>
                <div class="col category-column">
                  <img class="row tournament-sport" src="photos/basketball.png">
                  <p class="row tournament-vs">
                    VS
                  </p>
                </div>
                <div class="col category-column">
                  <p class="row tournament-score">
                    2
                  </p>
                  <p class="row tournament-org AECES">
                    AECES
                  </p>
                </div>
              </div>
              <div class="row category-card mx-auto">
                <div class="col category-column">
                  <p class="row tournament-score">
                    1
                  </p>
                  <p class="row tournament-org ELITE">
                    ELITE
                  </p>
                </div>
                <div class="col category-column">
                  <img class="row tournament-sport" src="photos/basketball.png">
                  <p class="row tournament-vs">
                    VS
                  </p>
                </div>
                <div class="col category-column">
                  <p class="row tournament-score">
                    2
                  </p>
                  <p class="row tournament-org AECES">
                    AECES
                  </p>
                </div>
              </div>
              <div class="row category-card mx-auto">
                <div class="col category-column">
                  <p class="row tournament-score">
                    1
                  </p>
                  <p class="row tournament-org ELITE">
                    ELITE
                  </p>
                </div>
                <div class="col category-column">
                  <img class="row tournament-sport" src="photos/basketball.png">
                  <p class="row tournament-vs">
                    VS
                  </p>
                </div>
                <div class="col category-column">
                  <p class="row tournament-score">
                    2
                  </p>
                  <p class="row tournament-org AECES">
                    AECES
                  </p>
                </div>
              </div>
              <div class="row category-card mx-auto">
                <div class="col category-column">
                  <p class="row tournament-score">
                    1
                  </p>
                  <p class="row tournament-org ELITE">
                    ELITE
                  </p>
                </div>
                <div class="col category-column">
                  <img class="row tournament-sport" src="photos/basketball.png">
                  <p class="row tournament-vs">
                    VS
                  </p>
                </div>
                <div class="col category-column">
                  <p class="row tournament-score">
                    2
                  </p>
                  <p class="row tournament-org AECES">
                    AECES
                  </p>
                </div>
              </div>
              <div class="row category-card mx-auto">
                <div class="col category-column">
                  <p class="row tournament-score">
                    1
                  </p>
                  <p class="row tournament-org ELITE">
                    ELITE
                  </p>
                </div>
                <div class="col category-column">
                  <img class="row tournament-sport" src="photos/basketball.png">
                  <p class="row tournament-vs">
                    VS
                  </p>
                </div>
                <div class="col category-column">
                  <p class="row tournament-score">
                    2
                  </p>
                  <p class="row tournament-org AECES">
                    AECES
                  </p>
                </div>
              </div>
              <div class="row category-card mx-auto">
                <div class="col category-column">
                  <p class="row tournament-score">
                    1
                  </p>
                  <p class="row tournament-org ELITE">
                    ELITE
                  </p>
                </div>
                <div class="col category-column">
                  <img class="row tournament-sport" src="photos/basketball.png">
                  <p class="row tournament-vs">
                    VS
                  </p>
                </div>
                <div class="col category-column">
                  <p class="row tournament-score">
                    2
                  </p>
                  <p class="row tournament-org AECES">
                    AECES
                  </p>
                </div>
              </div>
              <div class="row category-card mx-auto">
                <div class="col category-column">
                  <p class="row tournament-score">
                    1
                  </p>
                  <p class="row tournament-org ELITE">
                    ELITE
                  </p>
                </div>
                <div class="col category-column">
                  <img class="row tournament-sport" src="photos/basketball.png">
                  <p class="row tournament-vs">
                    VS
                  </p>
                </div>
                <div class="col category-column">
                  <p class="row tournament-score">
                    2
                  </p>
                  <p class="row tournament-org AECES">
                    AECES
                  </p>
                </div>
              </div>
              <div class="row category-card mx-auto">
                <div class="col category-column">
                  <p class="row tournament-score">
                    1
                  </p>
                  <p class="row tournament-org ELITE">
                    ELITE
                  </p>
                </div>
                <div class="col category-column">
                  <img class="row tournament-sport" src="photos/basketball.png">
                  <p class="row tournament-vs">
                    VS
                  </p>
                </div>
                <div class="col category-column">
                  <p class="row tournament-score">
                    2
                  </p>
                  <p class="row tournament-org AECES">
                    AECES
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <p class="row category-text">
              Competitions
            </p>
            <div class="row category-container mx-auto">
              <div class="row category-card mx-auto">
              </div>
              <div class="row category-card mx-auto">
              </div>
              <div class="row category-card mx-auto">
              </div>
              <div class="row category-card mx-auto">
              </div>
              <div class="row category-card mx-auto">
              </div>
            </div>
          </div>
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
            cards.forEach(function(div) {
              if (filterValue === "ALL" || div.classList.contains(filterValue)) {
                div.style.display = "block"; // Show the image div
              } else {
                div.style.display = "none"; // Hide the image div
              }
            });

            // Scroll back to the top of the container
            scrollContainer.scrollLeft = 0;
          });
        });
      });
    </script>
  </body>
</html>