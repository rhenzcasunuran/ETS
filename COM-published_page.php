<?php include './php/database_connect.php' ?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Published</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
  <head>

  <body>
  <div class="archive-wrapper" id="archive-pp-wrap" style="display:none;">
          <div class="arcc" id="archive-pp">
            <i class="fa fa-check-circle"></i>
            <h1 class="arc-head">Successfully Moved!</h1>
            <p class="arc-p">The result is now moved to archived.<br>You may check it right now.</p>
            <button class="arc-btn" id="close-btn"><i class="fa fa-long-arrow-right"></i></button>
          </div>
        </div>
        <div class="cau-wrapper" id="caution-pp-wrap" style="display:none;">
          <div class="bacc" id="caution-pp">
          <i class='bx bxs-file-archive' style="color: var(--color-text); font-size: 90px"></i>
            <h1 class="arc-head">Archive Result?</h1>
            <p class="arc-p">Are you sure you want to archive this result?</p>
            <button class="gobackbtn" id="backbtn">Cancel</button>
            <button class="gobtn" id="gobtn">Confirm</button>
          </div>
        </div>
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
        <img src="./pictures/no_result.png" class="no-result" width="500px" height="500px">
            <h1 class="empty_header">No Published Results</h1>
            <p class="empty_p">There are no competition results to published yet.</p>
            <button class="go_to_tobepubBtn" onclick="window.location.href='./COM-tobepublished_page.php';"><i class='bx bxs-plus-square'></i><p class="btnContent">To Publish</p></button>
        </div>
        <div class="content">
        <?php
        try {
            require './php/COM-display_published.php';
        } catch (Throwable $e) {
            // Show error message na hindi nag connect sa db
            // Pero sa ngayon wag muna
        }
        ?>
        </div>
        
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
  </body>
