<?php
@include './php/database_connect.php';

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
      <title>Competitions</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- Side Bar CSS -->
      <link rel="stylesheet" href="./css/boxicons.css">
      <link rel="stylesheet" href="./css/COM-theme-mode.css">
      <link rel="stylesheet" href="./css/responsive.css">
      <link rel="stylesheet" href="./css/COM-style.css">
      <link rel="stylesheet" href="./css/sidebar-style.css">
      <!-- Page specific CSS -->
      <link rel="stylesheet" href="./COM-student_page/COM-student_page.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <head>

  <body>
  <div class="container-fluid" id="popup">
      <div class="row popup-card">
        <form method="post">
          <div class="row title">
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
            <input type="text" class="adminInput" name="user_username" placeholder="Username" maxlength="20" required/>
          </div>
          <div class="row">
            <input type="password" class="adminInput" name="user_password" placeholder="Password" maxlength="128" required/>
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
        <div class="sidebar-content-container" style="border: none;">
          <ul class="nav-list">
            <li class="nav-item">
              <a href="index.php" class="menu_btn">
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
                <i class="bx bx-line-chart"><i class="dropdown_icon bx bx-chevron-right"></i></i>
                <span class="link_name">Results
                  <i class="change-icon dropdown_icon bx bx-chevron-down"></i>
                </span>
              </a>
              <ul class="sub_list" style="display: block;">
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
                <li class="sub-item active">
                  <a href="#competition">
                    <i class="bx bxs-circle sub-icon color-yellow" style="color: var(--color-sidebar-sublist-3) !important;"></i>
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
    <!--Sidebar End-->
    <!--Content Start-->
    <section class="home-section removespace">
      <div class="header">Competitions</div>
        <div class="left search bar">
            <i class="fa fa-search"></i>
	        <input class="searchInput" type="text" placeholder="Search..">
        </div>
    </section>
    <section class="home-section actualbody">
        <div id="empty" class="empty">
            <h1 class="empty_header">No Competitions (T^T)</h1>
            <p class="empty_p">Maybe the competitions are still ongoing. Look around for now.</p>
            <button class="go_to_tobepubBtn" onclick="window.location.href='index.php';"><i class='bx bxs-plus-square'></i><p class="btnContent">Go back Home</p></button>
        </div>
        <div class="container">
            <?php
                try {
                    require './COM-student_page/COM-student_accordion.php';
                } catch (Throwable $e) {
                    // Show error message na hindi nag connect sa db
                    // Pero sa ngayon wag muna
                    echo 'ERROR';
                }
            ?>
        </div>
        <!--<div class='piechart-popup'></div>-->
    </section>
    <!--Content End-->
    <!--Side Bar Scripts-->
    <script src="./js/script.js"></script>
    <script src="./js/COM-student-theme.js"></script>
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
    <script src='./COM-student_page/COM-student_page.js'></script>
    <!--Side Bar Scripts End-->
  </body>
