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
      <meta name="page-id" content="comstudent">
      <!-- Side Bar CSS -->
      <link rel="stylesheet" href="./css/boxicons.css">
      <link rel="stylesheet" href="./css/COM-theme-mode.css">
      <link rel="stylesheet" href="./css/responsive.css">
      <link rel="stylesheet" href="./css/COM-style.css">
      <link rel="stylesheet" href="./css/sidebar-style.css">
      <!-- Page specific CSS -->
      <link rel="stylesheet" href="./css/COM-student_page.css">
      <link rel="stylesheet" href="./css/system-wide.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="./css/COM-pagination.css">
      <link rel="stylesheet" href="./css/COM-piechart.css">
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <!-- Latest compiled and minified CSS for Bootstrap 3 -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

      <!-- Latest compiled JavaScript for Bootstrap 3 -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
      <!-- Chart.js library -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <script src="./js/COM-theme.js"></script>
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
    <?php
    // Set the active module and sub-active sub-item variables
      $activeModule = 'results';
      $activeSubItem = 'competition';

    // Include the sidebar template
     require './php/student-sidebar.php';
    ?>
    <!--Sidebar End-->
    <!--Content Start-->
    <section class="home-section removespace">
      <div class="header">Competitions</div>
    </section>
    <section class="home-section actualbody">
        <div id="empty" class="empty">
        <img src="./pictures/no_result.svg" class="no-result" width="500px" height="500px">
            <h1 class="empty_header">No Competitions posted yet</h1>
            <p class="empty_p">Maybe the competitions are still ongoing?<br>Well, you can check out the Tournaments while you wait!</p>
            <button class="go_to_tobepubBtn" onclick="window.location.href='TOU-student-live-scoring.php';"><i class='bx bxs-plus-square'></i><p class="btnContent">Go to Tournaments</p></button>
        </div>
        <div class="container">
        <div class="inputAndDeleteDiv">
          <div class="left search bar" id='search'>
          <i class='bx bx-search'></i>
	          <input id="searchInput" class="searchInput" type="text" placeholder="Search..">
          </div>
        </div>
            <?php
                try {
                    require './php/COM-student_accordion.php';
                } catch (Throwable $e) {
                    // Show error message na hindi nag connect sa db
                    // Pero sa ngayon wag muna
                    echo 'ERROR';
                }
            ?>
        </div>
        <!--PAGINATION-->
        <?php include './php/COM-pagination.php'; ?>
        <!--END-->
    </section>
    <!--Content End-->
    <!--Side Bar Scripts-->
    <script src="./js/script.js"></script>
    
    
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
    <script src='./js/COM-student_page.js'></script>
    <script type="text/javascript" src="./js/COM-pagination.js"></script>
    <script src='./js/COM-piechart.js'></script>
    <!--Side Bar Scripts End-->
    <script>
      var resultContainers;
      $(document).ready(function() {
        // Get all the draggableDiv elements
        resultContainers = $(".draggableDiv");

        // Search function
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            resultContainers.filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
            if (value.trim() === '') {
            clickPageButtonOne();
            $('.paginations').show();
            } else {
              $('.paginations').hide();
            }
        });
      });
      function clickPageButtonOne() {
    // Get the button with class 'pageBtn' and content '1'
    var buttonOne = $('.pagination-center .pageBtn:contains("1")');

    // Trigger a click event on the button
    if (buttonOne.length > 0) {
        buttonOne.trigger('click');
    }
}
      // Search function to filter draggableDivs
      function searchDrags(searchText) {
      resultContainers.forEach(div => {
      const content = div.innerText.toLowerCase();
      if (content.includes(searchText.toLowerCase())) {
        div.style.display = 'block';
      } else {
        div.style.display = 'none';
      }
    });
  }
  
  function handleSearchInput() {
    const searchInput = document.getElementById('searchInput').value;
    searchDrags(searchInput);
  }
  
  document.getElementById('searchInput').addEventListener('input', handleSearchInput);
    </script>
    <script src="./js/change-theme.js"></script>
  </body>
