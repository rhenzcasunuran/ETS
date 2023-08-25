<?php include './php/database_connect.php' ?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Published</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="page-id" content="published">
      <!-- Side Bar CSS -->
      <link rel="stylesheet" href="./css/boxicons.css">
      <link rel="stylesheet" href="./css/COM-theme-mode.css">
      <link rel="stylesheet" href="./css/responsive.css">
      <link rel="stylesheet" href="./css/COM-style.css">
      <link rel="stylesheet" href="./css/sidebar-style.css">
      <!-- Page specific CSS -->
      <link rel="stylesheet" href="./css/COM-published_page.css">
      <link rel="stylesheet" href="./css/system-wide.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
      <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
      <link rel="stylesheet" type="text/css" media="all" href="./css/COM-daterangepicker.css" />
      <link rel="stylesheet" href="./css/COM-pagination.css">
      <script src="./js/COM-theme.js"></script>
  <head>

  <body>
    <!--Popup Confirm / Success-->
    <div class="popup-background" id="markAsDoneWrapper" onclick="hideMarkAsDone()">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-check-circle prompt-icon success-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Successfully Moved!</h3>   <!--header-->
                <p style="max-width: 235px; padding-left:15px;">The result is now moved to archive. You may check it right now.</p> <!--text-->
            </div>
            <div  class="div">
                <button id="gotoarchiveBtn" class="outline-button"><i class='bx bxs-file-archive'></i>Go To Archive</button>
                <button id="returnBtn" class="success-button" onclick="hideMarkAsDone()"><i class='bx bx-chevron-left'></i>Return</button>
            </div>
        </div>
    </div>

    <!--Popup Cancel / Warning-->
    <div class="popup-background" id="cancelWrapper" onclick="hideCancel()">
        <div class="row popup-container">
            <div class="col-4">
              <i class='bx bxs-file-archive' style="font-size: 95px;"></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Archive Result?</h3>   <!--header-->
                <p style="max-width: 235px; padding-left:15px;">Are you sure you want to archive the result?</p> <!--text-->
            </div>
            <div  class="div">
                <button id="cancelBtn" class="outline-button" onclick="hideCancel()"><i class='bx bx-x'></i>Cancel</button>
                <button id="confirmBtn" class="primary-button"><i class='bx bx-check'></i>Confirm</button>
            </div>
        </div>
    </div>
   <!--End of popups-->

    <!--Sidebar Start-->
    <?php 
        $activeModule = 'competition';
        $activeSubItem = 'published-results';
        require './php/admin-sidebar.php';
    ?>
    <!--Sidebar End-->
    <!--Content Start-->
    <section class="home-section removespace">
      <div class="header">Published</div>
    </section>
    <section class="home-section actualbody">
        <div id="empty" class="empty">
        <img src="./pictures/no_result.svg" class="no-result" width="500px" height="500px">
            <h1 class="empty_header">No Published Results</h1>
            <p class="empty_p">There are no competition results to published yet.</p>
            <button class="go_to_tobepubBtn" onclick="window.location.href='./COM-tobepublished_page.php';"><i class='bx bxs-plus-square'></i><p class="btnContent">To Publish</p></button>
        </div>
        <div class="content">
        <div class="inputAndDeleteDiv">
          <div class="left search bar" id='search'>
          <i class='bx bx-search'></i>
	          <input id="searchInput" class="searchInput" type="text" placeholder="Search..">
          </div>
        </div>
        <?php
        try {
            require './php/COM-display_published.php';
        } catch (Throwable $e) {
            // Show error message na hindi nag connect sa db
            // Pero sa ngayon wag muna
            ?><script>console.log("Nag error");</script><?php
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
    <script src='./js/COM-published_page.js'></script>
    <!--Side Bar Scripts End-->
    <script type="text/javascript" src="./js/COM-daterangepicker.js"></script>
    <script>
      console.log("daterangepicker in the html");
      //encase this function in an if statement of listening if the sched btn is clicked
        $(function() {
            $('input[name="datetimes"]').daterangepicker({
                timePicker: true,
                startDate: moment().startOf('hour'),
                endDate: moment().startOf('hour').add(32, 'hour'),
                locale: {
                    format: 'MMMM D, YYYY hh:mm A',
                    applyLabel: "Set Schedule",
                    cancelLabel: "Cancel",
                    "daysOfWeek": [
                        "Sun",
                        "Mon",
                        "Tue",
                        "Wed",
                        "Thu",
                        "Fri",
                        "Sat"
                    ],
                    monthNames: [
                        "January",
                        "February",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July",
                        "August",
                        "September",
                        "October",
                        "November",
                        "December"
                    ],
                }
            });
            $('input[name="datetimes"]').val('');
            console.log('datepicker is created');
        });
    </script>
    <script>
      window.onload = function(){
        if (document.querySelectorAll('.daterangepicker')){
          buttons.forEach((button) => {
        var parentElement = button.parentElement;
        var id = parentElement.id;
        var competitionName = id;

        // Send the competition name to the PHP file using AJAX
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            // Check the response from the PHP file and change the color of the button
            console.log(this.responseText);
            var response = JSON.parse(this.responseText);
            var schedule = response['schedule'];
            var element = document.getElementById(competitionName+' btn');
            var inputfield = document.getElementById(competitionName+'-input');
            if (schedule === null){
              element.disabled = false;
              console.log("The competition: "+competitionName+" have a schedule of");
              console.log(schedule);
            } else {
              element.disabled = false;
              console.log("The competition: "+competitionName+" have a schedule of");
              console.log(schedule);
              inputfield.value = schedule;
              console.log("The input field value is "+inputfield.value);
              /*A code to change the color to black by sending compName to php */
            }
            
          }
        };
        const url = "./php/COM-get_compname.php";
        xhttp.open("GET", url +"?competitionName="+ competitionName, true);
        xhttp.send();
      });
        }
      }
    </script>
    <script type="text/javascript" src="./js/COM-pagination.js"></script>
    <script>
      var resultContainers;
      $(document).ready(function() {
        // Get all the draggableDiv elements
        resultContainers = $(".result_container");

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
