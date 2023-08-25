<?php include './php/database_connect.php' ?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Manage Results</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="page-id" content="manageresult">
      <!-- Side Bar CSS -->
      <link rel="stylesheet" href="./css/boxicons.css">
      <link rel="stylesheet" href="./css/COM-theme-mode.css">
      <link rel="stylesheet" href="./css/responsive.css">
      <link rel="stylesheet" href="./css/COM-style.css">
      <link rel="stylesheet" href="./css/sidebar-style.css">
      <!-- Page specific CSS -->
      <link rel="stylesheet" href="./css/COM-manage_results_page.css">
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
    <!--Sidebar Start-->
    <?php 
        $activeModule = 'competition';
        $activeSubItem = 'manage-results';
        require './php/admin-sidebar.php';
    ?>
    <!--Sidebar End-->
    <!--Content Start-->
    <section class="home-section removespace">
      <div class="header">Manage Results</div>
    </section>
    <section class="home-section actualbody">
        <div id="empty" class="empty">
        <img src="./pictures/no_result.svg" class="no-result" width="500px" height="500px">
            <h1 class="empty_header">No Results</h1>
            <p class="empty_p">There are no results published yet.<br>Tap the button to schedule a result.</p>
            <button class="go_to_tobepubBtn" onclick="window.location.href='./COM-tobepublished_page.php';"><i class='bx bxs-plus-square'></i><p class="btnContent">To Publish</p></button>
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
                    require './php/COM-display_accordions.php';
                } catch (Throwable $e) {
                    // Show error message na hindi nag connect sa db
                    // Pero sa ngayon wag muna
                    echo 'Error';
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
    <script src='./js/COM-manage_results_page.js'></script>
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
  </body>
