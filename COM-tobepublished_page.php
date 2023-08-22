<?php include './php/database_connect.php' ?>

<!DOCTYPE html>
<html lang="en">
  <head>
        <title>To Publish</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="page-id" content="topublish">
        <?php include '.php/title.php' ?>
        <!-- Side Bar CSS -->
        <link rel="stylesheet" href="./css/boxicons.css">
        <link rel="stylesheet" href="./css/COM-theme-mode.css">
        <link rel="stylesheet" href="./css/responsive.css">
        <link rel="stylesheet" href="./css/COM-style.css">
        <link rel="stylesheet" href="./css/sidebar-style.css">
        <link rel="stylesheet" href="./css/system-wide.css">
        <!-- Page specific CSS -->
        <link rel="stylesheet" href="./css/COM-tobepublished_page.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <link rel="stylesheet" href="./css/COM-pagination.css">
        <script src="./js/COM-theme.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="./css/COM-daterangepicker.css" />
  <head>
  <body>
    <!--Popup Success-->
    <div class="popup-background" id="markAsDoneWrapper"  style="z-index:4000 !important;">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-check-circle prompt-icon success-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Success!</h3>   <!--header-->
                <p style="max-width: 235px; padding-left:15px;">The result is scheduled and will be published.</p> <!--text-->
            </div>
            <div  class="div">
                <!--<button class="outline-button"  id="success-cancel"><i class='bx bx-x'></i>Cancel</button>-->
                <button class="success-button"  id="success-confirm"><i class='bx bx-check'></i>Confirm</button>
            </div>
        </div>
    </div>

    <!--Popup Discard Changes?-->
    <div class="popup-background" id="cancelWrapper" onclick="hideCancel()" style="z-index:4000 !important;">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-error prompt-icon warning-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Discard Changes?</h3>   <!--header-->
                <p style="max-width: 235px; padding-left:15px;">Any unsaved progress will be lost.</p> <!--text-->
            </div>
            <div  class="div">
                <button class="outline-button" id="discard-return"><i class='bx bx-chevron-left'></i>Return</button> <!--Change to function to show calendar -->
                <button class="primary-button" id="discard-ok"><i class='bx bx-x'></i>Discard</button>
            </div>
        </div>
    </div>

    <!--Popup: Edit Schedule?-->
    <div class="popup-background edit-sched" id="editWrapper" onclick="hideEdit()" style="z-index:4000 !important;">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-error prompt-icon warning-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Edit Schedule?</h3>   <!--header-->
                <p style="max-width: 235px; padding-left:15px;">Are you sure you want to change the schedule?</p> <!--text-->
            </div>
            <div  class="div">
                <button class="outline-button" id="edit-cancel"><i class='bx bx-chevron-left'></i>Cancel</button>
                <button class="primary-button" id="edit-ok"><i class='bx bx-x'></i>Edit Schedule</button>
            </div>
        </div>
    </div>

    <!--Popup: Unavailable-->
    <div class="popup-background" id="deleteWrapper" onclick="hideDelete()" style="z-index:4000 !important;">
        <div class="row popup-container">
            <div class="col-4">
                <i class='bx bxs-error prompt-icon danger-color'></i> <!--icon-->
            </div>
            <div class="col-8 text-start text-container">
                <h3 class="text-header">Incomplete</h3>   <!--header-->
                <p style="max-width: 235px; padding-left:15px;">The result is not yet complete or has less than 3 participants. <br>Please make sure that all required scores are completed <br> And there are 3 or more participant</p> <!--text-->
            </div>
            <div  class="div">
                <button class="outline-button" onclick="hideDelete()"><i class='bx bx-x'></i>Cancel</button>
                <!--<button class="danger-button"><i class='bx bx-trash'></i>Delete</button>-->
            </div>
        </div>
    </div>
    <!--Popups End-->
    <!--Sidebar Start-->
    <?php 
        $activeModule = 'competition';
        $activeSubItem = 'to-publish';
        require './php/admin-sidebar.php';
    ?>
    <!--Sidebar End-->
    <!--Content Start-->
    <section class="home-section removespace">
      <div class="header">To Publish</div>
    </section>
    <section class="home-section actualbody">
        <div id="empty" class="empty">
        <img src="./pictures/no_result.svg" class="no-result" width="500px" height="500px">
            <h1 class="empty_header">No Results</h1>
            <p class="empty_p">There are no competition results to be published yet.</p>
            <button class="go_to_manageBtn" onclick="window.location.href='EVE-admin-create-event.php';"><i class='bx bxs-plus-square'></i><p class="pBtn">Create Event</p></button>
        </div>
        <div class="content">
        <div class="inputAndDeleteDiv">
          <div class="lefty search bar" id='search'>
          <i class='bx bx-search'></i>
	          <input id="searchInput" class="searchInput" type="text" placeholder="Search..">
          </div>
        </div>
        <?php
        try {
            require './php/COM-display-result-in-topublish.php';
        } catch (Throwable $e) {
            // Show error message na hindi nag connect sa db
            // Pero sa ngayon wag muna
            ?><script>console.log("Bruh may error");</script><?php
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
      // Success
      popupMarkAsDone = document.getElementById('markAsDoneWrapper');
  
  var showMarkAsDone = function() {
    popupMarkAsDone.style.display ='flex';
  }
  var hideMarkAsDone = function() {
    popupMarkAsDone.style.display ='none';
    //input.disabled = true;
  }

  // Unsaved Changes
  popupCancel = document.getElementById('cancelWrapper');

  var showCancel = function() {
    popupCancel.style.display ='flex';
  }
  var hideCancel = function() {
    popupCancel.style.display ='none';
    //input.disabled = true;
  }

  //Incomplete
  popupDelete = document.getElementById('deleteWrapper');

  var showDelete = function() {
    popupDelete.style.display ='flex';
  }
  var hideDelete = function() {
    popupDelete.style.display ='none';
    //input.disabled = true;
  }
  
  

  // Function to call the calendar
  var openCalendar = function(x,competitionName) {
    console.log("openCalendar(php page): starts..");
    name = competitionName;
    compId = competitionName+"-input";
    input = x;
    hideEdit();
    hideDelete();
    hideCancel();
    hideMarkAsDone();
    console.log(input+" is the input value in the calendar");
    input.disabled = false;
    if (input.id == compId) {
      input.click();
      console.log("input.id: "+input.id);
      console.log("compId: "+compId);
    }
    
    input.disabled = true;
  }
  //Edit Schedule
  popupEditChanges = document.getElementById('editWrapper');

  var showEdit = function(x,competitionName) {
    popupEditChanges.style.display ='flex';
    var ok = document.getElementById('edit-ok');
    var cance = document.getElementById('edit-cancel');
    var a = x;
    var b = competitionName;
    var reclick = document.getElementById(btnClicked);
    console.log(btnClicked+" is btnClicked");
    console.log(globalComp+" is the competition name");
    ok.addEventListener("click", function(){
      if (b == btnClicked){
        openCalendar(a,b);
      }
      
    });
    cance.addEventListener("click", function(){
      popupEditChanges.style.display ='none';
    });
  }
  var hideEdit = function() {
    popupEditChanges.style.display ='none';
    //input.disabled = true;
  }
    </script>
    <script>
      var btnClicked;
      var globalComp;
      var competitionId;
      const buttons = document.querySelectorAll('.sched_btn');
      for (let i = 0; i < buttons.length; i++) {
        const button = buttons[i];
        button.addEventListener("click", (e) => {
          e.stopPropagation();
          const h2 = e.target.closest('.parent');
          const input = h2.querySelector('.sched_output');
          var parentElement = button.parentElement;
          var id = parentElement.id;
          var competitionName = id;
          globalComp = competitionName+"-input";
          var x = document.getElementById(competitionName+"-input");

          console.log(x.id+" is the current id");
          console.log(input.id+" is the input id");


          // Popups depending on the button type
          if (button.textContent === "Edit Schedule") {
            console.log("Edit schedule is clicked");
            btnClicked = competitionName;
            showEdit(x,competitionName);
            //openCalendar(x,competitionName);
            return;
          }
          if (button.textContent === "Schedule") {
            openCalendar(x,competitionName);
            return;
          }
          if (button.textContent === "Unavailable") { 
            showDelete();
            return;
          }
        });
      }
      // Set button name and color
      // Get the competition name from the h2 element
      
      buttons.forEach((button) => {
        var parentElement = button.parentElement;
        var id = parentElement.id;
        var competitionName = id;
        console.log("And competitionName ay "+competitionName);

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
              element.style.backgroundColor = 'rgb(216, 232, 90)';
              element.textContent = "Schedule";
              element.disabled = false;
              console.log("The competition: "+competitionName+" have a schedule of");
              console.log(schedule);
              console.log("yellow dpat to")
            } else {
              element.style.backgroundColor = 'rgb(102, 232, 90)';
              element.textContent = "Edit Schedule";
              element.disabled = false;
              console.log("The competition: "+competitionName+" have a schedule of");
              console.log(schedule);
              console.log("Green dpat to");
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
    </script>
    <script>
      //call to save the date
      function saveDate() {
        console.log("input value: "+document.getElementById(globalComp).value);
        var inputvalue = document.getElementById(globalComp).value;
        var dates = inputvalue.split(" - ");
        var startDate = new Date(dates[0]);
        var endDate = new Date(dates[1]);
        // Adjust for the timezone offset
        // if the time do not match, this would be the cause
        var timezoneOffset = startDate.getTimezoneOffset(); // Get the timezone offset in minutes
        startDate.setMinutes(startDate.getMinutes() - timezoneOffset);
        endDate.setMinutes(endDate.getMinutes() - timezoneOffset);

        var formattedStartDate = startDate.toISOString().slice(0, 19).replace("T", " ");
        var formattedEndDate = endDate.toISOString().slice(0, 19).replace("T", " ");

        console.log("the start date: "+formattedStartDate);
        console.log("the end date: "+formattedEndDate);

        competitionId = globalComp.replace("-input", "");
        console.log("The competitionId is "+competitionId);
        var element = document.getElementById(competitionId+' btn');
        console.log("The element text content is "+element.textContent);
        element.textContent = "Edit Schedule";

        //send dates to save_date.php
        const xhr = new XMLHttpRequest();
        const url = "./php/COM-save_date.php";
        const params = "competition_name=" + competitionId + "&schedule=" + formattedStartDate + "&schedule_end=" + formattedEndDate;

        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
          }
        };
        xhr.send(params);
      }
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
              //button is overwritten by system-wide css so it can't change color
              element.classList.add('.yellow');
              element.textContent = "Schedule";
              element.disabled = false;
              console.log("The competition: "+competitionName+" have a schedule of");
              console.log(schedule);
              console.log("yellow dpat to")
            } else {
              element.style.backgroundColor = 'var(--color-green) !important';
              element.textContent = "Edit Schedule";
              element.disabled = false;
              console.log("The competition: "+competitionName+" have a schedule of");
              console.log(schedule);
              console.log("Green dpat to");
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
    <script>
        window.onload= function () {
          console.log("[Checking if scores are complete...]");
            // Get all result containers
            var resultContainers = document.querySelectorAll('.result_container');
            
            // Loop through each result container
            resultContainers.forEach(function (container) {
                var hasNoScore = false;
                var less3participant = false;

                var participants = container.querySelectorAll('.participant-table');

                if (participants.length <= 2) {
                  var less3participant = true;
                }
                
                // Check if any text within the container has 'No score'
                if (container.textContent.includes('No score')) {
                    hasNoScore = true;
                }
                if (container.textContent.includes('NO JUDGE')) {
                    hasNoScore = true;
                }
                
                // Update the button text based on 'No score' presence
                var button = container.querySelector('.sched_btn');
                if (button) {
                    if (hasNoScore) {
                        button.textContent = 'Unavailable';
                        var compname = button.id.replace('btn','');
                        console.log("Competition:"+compname+"score not complete!");
                    }
                    if (less3participant) {
                        button.textContent = 'Unavailable';
                        var compname = button.id.replace('btn','');
                        console.log("Competition:"+compname+"score not complete!");
                    }
                }
            });
        };
    </script>
  </body>
</html>