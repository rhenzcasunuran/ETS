<?php 
include('./php/database_connect.php');

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
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <link rel="stylesheet" href="./css/home-sidebar-style.css">


    <!-- EVENT HISTORY -->
       <!-- CSS only -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">


          <link rel="stylesheet" href="./css/HIS-student.css">  </head>


  <body>
    <!--Sidebar-->
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
              <a href="HIS-student-index.php" class="active">
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
      <div class="header">Event History</div>
      <div class="flex-container">
    <div class="container" id="main-containers">
      <div class="container">
    <div class="row">
      <div class="col-md-3 left-container">
        <div class="container-fluid left-part">
          <input type="text" class="form-control" placeholder="Search Event">
          <p>Other Events</p>
          <div class="row">
            <div class="col-12 event">
                              <?php 
                  require('./php/database_connect.php');
                  require('./php/HIS-upload.php');

                  $query = "SELECT filename FROM image ORDER BY id DESC LIMIT 3";
                  $result = mysqli_query($conn, $query);
                  if (!$result) {
                      die("Error in the query: " . mysqli_error($conn));
                  }
                  $images = mysqli_fetch_all($result, MYSQLI_ASSOC);

                  for ($i = 0; $i < 3; $i++) {
                    echo '<div class="row">
                              <div class="col-12">';
                    if (isset($images[$i])) {
                        $imagePath = "./images/" . $images[$i]['filename'];
                        echo '<div><img src="' . $imagePath . '" style="width: 100%; height: 150px;" /></div>';
                    }
                    echo '</div>
                          </div>';
                    
                    mysqli_data_seek($result, 0);
                  }

                  mysqli_close($conn);
                  ?>

            </div>
          </div>
          
        </div>
      </div>
      <div class="col-md-6">
        <div class="row">
          <div id="carousel" class="col-md-12 text-white carousel-container">
          <?php
              require('./php/database_connect.php');

              $query = "SELECT * FROM image";
              $result = mysqli_query($conn, $query);

              $slides = '';
              $active = 'active';
              while ($row = mysqli_fetch_assoc($result)) {
                  $imagePath = "./images/" . $row['filename'];
                  $imageInfo = $row['image_Info'];
                  $imageDesc = $row['image_Description'];
                  $slides .= '<div class="carousel-item ' . $active . '" data-bs-info="' . $imageInfo . '" data-bs-desc="' . $imageDesc . '"><img src="' . $imagePath . '"></div>';
                  $active = '';
              }

              mysqli_data_seek($result, 0);
              $active = 'active';

              mysqli_close($conn);
              ?>

              <div id="eventsImages" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                  <?php echo $slides; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#eventsImages" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#eventsImages" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
                </div>
          </div>
    </div>
        <div class="row" id="contain">
        <div class="col-md-12 text-white text-container">
          
        </div>
        </div>
      </div>
      
        <div class="col-md-2 right-container">
          <h3>Filter</h3>
          <button type="button" id="button">ELITE</button>
          <button type="button">GIVE</button>
          <button type="button">JMAP</button>
          <button type="button">AECES</button>
          <button type="button">JPIA</button>
          <button type="button">PIIE</button>
          <button type="button">JEHRA</button>
          <button type="button">ACAP</button>
          <button type="button">STUDENT COUNCIL</button>
        </div>
        

    </div>

      </div>
    </div>
  
  <!-- Bootstrap 5 JS -->

</script>

    </section>
    <!-- Scripts -->
    <script src="./js/HOM-popup.js"></script>

    <script src="./js/script.js"></script>
    <script src="./js/change-theme.js"></script>
    <script src="./js/jquery-3.6.4.js"></script>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
  
    
    <script>
    var firstSlide = document.querySelector('#eventsImages .carousel-item:first-child');
    var imageInfo = firstSlide.getAttribute('data-bs-info');
    var imageDesc = firstSlide.getAttribute('data-bs-desc');


    var textContainer = document.querySelector('.text-container');
    textContainer.innerHTML = '<h3>' + imageInfo + '</h3><p>' + imageDesc + '</p>';

    var carousel = document.querySelector('#eventsImages');
    carousel.addEventListener('slide.bs.carousel', function(event) {
      var currentSlide = event.relatedTarget;
      var imageInfo = currentSlide.getAttribute('data-bs-info');
      var imageDesc = currentSlide.getAttribute('data-bs-desc');

      var textContainer = document.querySelector('.text-container');
      textContainer.innerHTML = '<h3>' + imageInfo + '</h3><p>' + imageDesc + '</p>';
      textContainer.style.wordWrap = 'break-word'; // Allow words to break
      textContainer.style.maxWidth = '100%'; 
      textContainer.style.textAlign = 'justify'; // Justify the content in the paragraph

    });
</script>

  </body>

</html>