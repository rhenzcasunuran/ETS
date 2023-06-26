<?php include './php/database_connect.php' ?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Archive</title>
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
      <link rel="stylesheet" href="./css/COM-archive_page.css">
      <link rel="stylesheet" href="./css/system-wide.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
      <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
      <link rel="stylesheet" type="text/css" media="all" href="./css/COM-daterangepicker.css" />
      <link rel="stylesheet" href="./css/COM-pagination.css">
  <head>

  <body>
    <!--Popup Confirm / Success-->
    <div class="popup-background" id="markAsDoneWrapper" onclick="hideMarkAsDone()">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-check-circle prompt-icon success-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Successfully Republished!</h3>   <!--header-->
                <p style="max-width: 235px; padding-left:15px;">The result is now republished. You may check it right now.</p> <!--text-->
            </div>
            <div  class="div">
                <button id="gotopublishBtn" class="outline-button"><i class='bx bx-calendar' ></i>Go to To Publish</button>
                <button class="success-button" onclick="hideMarkAsDone()"><i class='bx bx-chevron-left'></i>Return</button>
            </div>
        </div>
    </div>

    <!--Popup Confirm / Successfully Deleted-->
    <div class="popup-background" id="markAsDeletedWrapper" onclick="hideMarkAsDeleted()">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-check-circle prompt-icon success-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Successfully Deleted!</h3>   <!--header-->
                <p style="max-width: 235px; padding-left:15px;">The selected results are now deleted.</p> <!--text-->
            </div>
            <div  class="div">
                <!--<button id="gotopublishBtn" class="outline-button"><i class='bx bxs-file-archive'></i>Go to To Publish</button>-->
                <button class="success-button" onclick="hideMarkAsDeleted()"><i class='bx bx-chevron-left'></i>Return</button>
            </div>
        </div>
    </div>

    <!--Popup Cancel / Warning-->
    <div class="popup-background" id="cancelWrapper" onclick="hideCancel()">
        <div class="row popup-container">
            <div class="col-4">
            <i class='bx bx-repost' style='font-size:95px;'  ></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Republish result?</h3>   <!--header-->
                <p style="max-width: 235px; padding-left:15px;">Are you sure you want to republish the result?</p> <!--text-->
            </div>
            <div  class="div">
                <button class="outline-button" onclick="hideCancel()"><i class='bx bx-x'></i>Cancel</button>
                <button id="confirmBtn" class="primary-button"><i class='bx bx-check'></i>Confirm</button>
            </div>
        </div>
    </div>

    <!--Popup No selected results to delete-->
    <div class="popup-background" id="noselectWrapper" onclick="hidenoselect()">
        <div class="row popup-container">
            <div class="col-4">
            <i class='bx bxs-error prompt-icon warning-color'></i><!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">No results to delete</h3>   <!--header-->
                <p style="max-width: 235px; padding-left:15px;">Select a result to delete first</p> <!--text-->
            </div>
            <div  class="div">
                <button class="outline-button" onclick="hidenoselect()"><i class='bx bx-x'></i>Cancel</button>
            </div>
        </div>
    </div>

    <!--Popup Delete / Danger-->
    <div class="popup-background" id="deleteWrapper" onclick="hideDelete()">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-error prompt-icon danger-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Delete Result?</h3>   <!--header-->
                <p>This will delete the selected competition result permanently. This action cannot be undone.</p> <!--text-->
            </div>
            <div  class="div">
                <button class="outline-button" onclick="hideDelete()"><i class='bx bx-x'></i>Cancel</button>
                <button id="deleteBtn" class="danger-button"><i class='bx bx-trash'></i>Delete</button>
            </div>
        </div>
    </div>
   <!--End of popups-->
    <!--Sidebar Start-->
    <?php 
        $activeModule = 'competition';
        $activeSubItem = 'archive';
        require './php/admin-sidebar.php';
    ?>
    <!--Sidebar End-->
    <!--Content Start-->
    <section class="home-section removespace">
      <div class="header">Archive</div>
    </section>
    <section class="home-section actualbody">
        <div id="empty" class="empty">
        <img src="./pictures/no_result.png" class="no-result" width="500px" height="500px">
            <h1 class="empty_header">No Archived Results</h1>
            <p class="empty_p">There are no competition results archived yet.</p>
            <button class="go_to_tobepubBtn" onclick="window.location.href='./COM-published_page.php';"><i class='bx bxs-plus-square'></i><p class="btnContent">To Published</p></button>
        </div>
        <div class="content">
        <div class="inputAndDeleteDiv">
          <div class="left search bar" id='search'>
          <i class='bx bx-search'></i>
	          <input class="searchInput" type="text" placeholder="Search..">
          </div>
          <button id="deleteAll" class="deleteAll"><i class='bx bxs-trash' ></i></button>
        </div>
        <?php
        try {
            require './php/COM-display_archive.php';
        } catch (Throwable $e) {
            // Show error message na hindi nag connect sa db
            // Pero sa ngayon wag muna
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
    <script src="./js/COM-theme.js"></script>
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
    <script src='./js/COM-archive_page.js'></script>
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
            $.ajax({
              type: "POST",
              url: "./php/COM-change_color_black.php",
              data: { competitionName: competitionName },
                success: function(response) {
                  console.log(response);
                  if (response == 'grey') {
                    document.getElementById(competitionName +' btn').style.backgroundColor = response + "!important";
                    element.textContent = "Unavailable";
                    element.disabled = false;
                  }
                  if (response == 'notempty') {
                    element.disabled = false;
                  }
                }
              });
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
  </body>
