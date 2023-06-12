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
    <?php
      // Set the active module and sub-active sub-item variables
      $activeModule = 'event-history';

      // Include the sidebar template
      require './php/student-sidebar.php';
    ?>
    <!--Page Content-->
    <section class="home-section">
    <div class="header">
  Event History
  <input type="text" id="search" placeholder="Search" maxlength="30">
  <div class="dropdown">
    <i class="bx bx-filter-alt dropbtn bx-sm" onclick="myFunction()"></i>
    <div id="myDropdown" class="dropdown-content">
      <a href="#">GIVE</a>
      <a href="#">JMAP</a>
      <a href="#">AECES</a>
      <a href="#">JPIA</a>
      <a href="#">PIIE</a>
      <a href="#">JEHRA</a>
      <a href="#">ACAP</a>
      <a href="#">ELITE</a>
      <a href="#">STUDENT COUNCIL</a>
    </div>
  </div>
</div>

<div class="flex-container">
  <div class="container" id="main-containers">
    <div class="container">
      <div class="col-md-12">
        <div class="row">
          <div id="carousel" class="col-md-12 text-white carousel-container"> <!-- Added carousel-container class -->
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
            <!-- Additional content here -->
          </div>
        </div>
      </div>
    </div>
  </div>



<div class="row justify-content-center">
      <div class="col-md-12 left-container custom-left-container">
    <div class="container-fluid left-part">
      <div class="row">
        <div class="col-md-12 event">
          <div id="card-container">
                  <?php
                require('./php/database_connect.php');

                $query = "SELECT event_name, category_name, YEAR(event_date) AS event_year, suggested_status FROM eventhistorytb ORDER BY suggested_status DESC";
                $result = mysqli_query($conn, $query);
                
                if ($result === false) {
                    die('Query Error: ' . mysqli_error($conn));
                }
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $eventName = $row['event_name'];
                        $categoryName = $row['category_name'];
                        $eventYear = $row['event_year'];
                        $suggestedStatus = $row['suggested_status'];
                
                        echo '<div class="event-card" id="event_' . $eventName . '">';
                        echo '  <div class="event-info">';
                        echo '    <h3 class="event-name">' . $eventName . '</h3>';
                        echo '    <p class="category">' . $categoryName . '</p>';
                        echo '    <p class="year">' . $eventYear . '</p>';
                
                        // Check if the event is suggested
                        if ($suggestedStatus == 1) {
                          echo '    <p class="suggested-text">Suggested</p>'; // Add the class here
                        }
                
                        echo '  </div>';
                        echo '</div>';
                    }
                } else {
                    echo "No events found.";
                }
                
        ?>
          </div>
        </div>
      </div>
    </div>
      </div>
</div>
</div>
    </section>
  
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    function updateTextContainer(slide) {
        var imageInfo = slide.getAttribute('data-bs-info');
        var imageDesc = slide.getAttribute('data-bs-desc');

        var textContainer = document.querySelector('.text-container');
        textContainer.innerHTML = '<h3>' + imageInfo + '</h3><p>' + imageDesc + '</p>';
        textContainer.style.wordWrap = 'break-word'; // Allow words to break
        textContainer.style.maxWidth = '100%';
        textContainer.style.textAlign = 'justify'; // Justify the content in the paragraph
    }

    var firstSlide = document.querySelector('#eventsImages .carousel-item:first-child');
    updateTextContainer(firstSlide);

    var carousel = document.querySelector('#eventsImages');
    carousel.addEventListener('slide.bs.carousel', function(event) {
        var currentSlide = event.relatedTarget;
        updateTextContainer(currentSlide);
    });
 /* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
  }

  // Close the dropdown menu if the user clicks outside of it
  window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
    }
  }


</script>



  </body>

</html>