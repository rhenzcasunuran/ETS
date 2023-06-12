<?php
  include './php/database_connect.php';
  include './php/HOM-post-data.php';

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
    <link rel="stylesheet" href="css/theme-mode.css">
    <script src="js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <link rel="stylesheet" href="./css/home-sidebar-style.css">
    <link rel="stylesheet" href="./css/system-wide.css">
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/HOM-index.css">
    <link rel="stylesheet" href="./css/HOM-post.css">
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
    <!--Page Content-->
    <section class="home-section">
      <div class="container">
        <div class="row">
        <a href="index.php" class="link-button">
          <i class='back bx bx-arrow-back'></i>
        </a>
        </div>
        <div class="container post">
          <div class="row">
            <p class="post-date">
              Posted on <?php echo $post_row[7];?>
            </p>
          </div>
          <div class="row">
            <p class="post-title">
              <?php echo $post_row[3];?>
            </p>
          </div>
          <div class="row">
            <p class="post-tag <?php echo $post_row[2];?>">
              <?php echo $post_row[2];?>
            </p>
          </div>
          <div class="row">
            <p class="post-description">
              <?php 
                $text = $post_row[4];
                $formattedText = nl2br($text);
                echo $formattedText;
              ?>
            </p>
          </div>
          <div class="row">

          </div>
        </div>
      </div>
    </section>
    <!-- Scripts -->
    <script src="js/script.js"></script>
    <script src="js/change-theme.js"></script>
    <script src="js/jquery-3.6.4.js"></script>
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