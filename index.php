<?php
  include './php/database_connect.php';
  include './php/HOM-get-posts.php';

  session_start();

  if($conn){
    if(isset($_POST['sign-in-button'])){
      $username=mysqli_real_escape_string($conn,$_POST['user_username']);
      $password=mysqli_real_escape_string($conn,$_POST['user_password']);
      $sql="SELECT * FROM user WHERE user_username='$username' AND user_password='$password'";
      $result=mysqli_query($conn,$sql);
      if($result){
        if(mysqli_num_rows($result)>0){
          $_SESSION['user_username']=$username;
          header("location:HOM-create-post.php");
        }
        else{
          echo '<script>alert("Username or Password combination are incorrect")</script>';
        }
      }
    }
  }
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
    <div class="sidebar open box-shadow">
      <div class="bottom-design">
        <div class="design1"></div>
        <div class="design2"></div>
      </div>
      <div class="logo_details">
        <img src="./pictures/logo.png" alt="student council logo" class="icon logo">
        <div class="logo_name">Events Tabulation System</div>
        <i class="bx bx-arrow-to-right" id="btn"></i>
        <script src="./js/sidebar-state.js"></script>
      </div>
      <div class="wrapper">
        <div class="sidebar-content-container">
          <ul class="nav-list">
            <li class="nav-item">
              <a href="index.php" class="menu_btn active">
                <i class="bx bx-home-alt"></i>
                <span class="link_name">Home</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="CAL-student-overall.php">
                <i class="bx bx-calendar"></i>
                <span class="link_name">Calendar</span>
              </a>
            </li>
            <li class="nav-item">
            <a href="#posts" class="menu_btn">
                <i class="bx bx-line-chart"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Results
                  <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
              </a>
              <ul class="sub_list">
                <li class="sub-item">
                  <a href="BAR-student.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Overall Champion</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="#tournament">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Tournament</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="COM-student_page.php">
                    <i class="bx bxs-circle sub-icon color-yellow"></i>
                    <span class="sub_link_name">Competition</span>
                  </a>
                </li>
              </ul>
            </li>
            
            <li class="nav-item">
              <a href="HIS-student-index.php">
                <i class="bx bx-history"></i>
                <span class="link_name">Event History</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="about.php">
                <i class="bx bx-info-circle"></i>
                <span class="link_name">About</span>
              </a>
            </li>
            <?php
              if(isset($_SESSION['user_username'])){
            ?>
            <li class="nav-item">
              <a href="HOM-create-post.php">
                <i class="bx bx-cog"></i>
                <span class="link_name">Configuration</span>
              </a>
            </li>
            <?php
              }
            ?>
          </ul>
        </div>
        <div class="bottom-container">
          <div class="mode-btn" id="theme-toggle">
            <i class='lightmode bx bx-sun'></i>
            <i class='darkmode bx bx-moon'></i>
          </div>
          <?php
            if(isset($_SESSION['user_username'])){
          ?>
            <li class="nav-item bottom">
              <a href="./php/sign-out.php">
                <i class="bx bx-log-out"></i>
                <span class="link_name">Sign Out</span>
              </a>
            </li>
          <?php
            }
            else{
          ?>
              <li class="nav-item bottom">
                <a onclick="show()">
                  <i class="bx bx-log-in"></i>
                  <span class="link_name">Sign In</span>
                </a>
              </li>
          <?php
            }
          ?>
        </div>
      </div>
    </div>
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
              while($count = mysqli_fetch_array($get_posts)){
                $date = date("F d, Y", strtotime($count[7]));
          ?>
            <a href="HOM-post.php?eec=<?php echo $count[0]?>" class="post-click ALL <?php echo $count[2];?>">
              <div class="post-card">
                <img class="post-cover" src="photos/cover-<?php echo $count[2];?>.png">
                <div class="post-detail">
                  <p class="post-date">
                    Posted on <?php echo $date;?>
                  </p>
                  <div class="post-title-container">
                    <p class="post-title-text">
                      <?php echo $count[3];?>
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
    <script src="./js/HOM-script.js"></script>
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