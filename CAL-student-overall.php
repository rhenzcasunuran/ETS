<?php
@include './php/database_connect.php';
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
        $_SESSION['message']="You are now Loggged In";
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
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <link rel="stylesheet" href="./css/home-sidebar-style.css">
    <!--Calendar JS-->
    <link rel="stylesheet" href="./css/CAL-calendar.css">
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
              <a href="index.php">
                <i class="bx bx-home-alt"></i>
                <span class="link_name">Home</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="CAL-student-overall.php" class="menu_btn active">
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
                  <a href="#competition">
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
   <!--Page Content-->
   <section class="home-section">
      <div class="header">Calendar</div>
        <div class="d-flex justify-content-between">
          <h1 id="calendar-title"></h1>
          <!-- Filter Dropdown -->
          <div class="dropdown">
            <button class="btn btn-light btn-lg dropdown-toggle" style="width: 200px;" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
              Filters
            </button>
            <ul class="dropdown-menu" style="width: 200px;" aria-labelledby="dropdownMenuButton">
              <li>
                <div class="accordion" id="organizationAccordion">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" data-bs-parent="#organizationAccordion">
                        Organization
                      </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne">
                      <div class="accordion-body">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="check-all-organization" checked>
                          <label class="form-check-label" for="check-all-organization">
                            All
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="ACAP" id="check-acap">
                          <label class="form-check-label" for="check-acap">
                            ACAP
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="AECES" id="check-aeces">
                          <label class="form-check-label" for="check-aeces">
                            AECES
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="ELITE" id="check-elite">
                          <label class="form-check-label" for="check-elite">
                            ELITE
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="GIVE" id="check-give">
                          <label class="form-check-label" for="check-give">
                            GIVE
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="JEHRA" id="check-jehra">
                          <label class="form-check-label" for="check-jehra">
                            JEHRA
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="JMAP" id="check-jmap">
                          <label class="form-check-label" for="check-jmap">
                            JMAP
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="JPIA" id="check-jpia">
                          <label class="form-check-label" for="check-jpia">
                            JPIA
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="PIIE" id="check-piie">
                          <label class="form-check-label" for="check-piie">
                            PIIE
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li>
                <div class="accordion" id="eventTypeAccordion">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" data-bs-parent="#eventTypeAccordion">
                        Event Type
                      </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo">
                      <div class="accordion-body">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="check-all-event" checked>
                          <label class="form-check-label" for="check-all-event">
                            All
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="Tournament" id="check-tournament">
                          <label class="form-check-label" for="check-tournament">
                            Tournament
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="Competition" id="check-competition">
                          <label class="form-check-label" for="check-competition">
                            Competition
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="Standard" id="check-standard">
                          <label class="form-check-label" for="check-standard">
                            Standard
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <!-- Calendar -->
        <div class="container-fluid">
          <div class="row">
            <div class="container-fluid">
              <div class="calendar-row-styled shadow-lg p-3 mb-5">
                <div class="calendar-navigation">
                  <button type="button" id="prev-month" class="btn btn-primary rounded-pill"><h2><</h2></button>
                  <button type="button" id="next-month" class="btn btn-primary rounded-pill"><h2>></h2></button>
                </div>
                <table id="calendar" class="table table-bordered">
                  <thead class="calendar-weeks">
                    <tr class="border border-0">
                      <th class="fw-normal fs-5 text-center border border-0" scope="col">SUNDAY</th>
                      <th class="fw-normal fs-5 text-center border border-0" scope="col">MONDAY</th>
                      <th class="fw-normal fs-5 text-center border border-0" scope="col">TUESUDAY</th>
                      <th class="fw-normal fs-5 text-center border border-0" scope="col">WEDNESDAY</th>
                      <th class="fw-normal fs-5 text-center border border-0" scope="col">THURSDAY</th>
                      <th class="fw-normal fs-5 text-center border border-0" scope="col">FRIDAY</th>
                      <th class="fw-normal fs-5 text-center border border-0" scope="col">SATURDAY</th>
                    </tr>
                  </thead>
                  <tbody class="calendar-days border border-5">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <br>
      <br>   
    </section>
    <!-- Scripts -->
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
    <!--Calendar JS-->
    <script src="./js/CAL-student-calendar.js"></script>
    <!--Popper JS-->
    <script src="./js/popper.min.js"></script>
    <!--Bootstrap JS-->
    <script src="./js/bootstrap.min.js"></script>
  </body>
</html>