<!--Instructions
    Include this before the sidebar

    THIS EXAMPLE HAS AN EXAMPLE DATA, MAKE SURE TO CHANGE THEM

    <php 
          $popUpID = "markAsDone";                                      // Create an ID to your Popup
          $showPopUpButtonID = "eventDoneBtn";                          // Your div id when opening the popup
          $icon = "<i class='bx bxs-check-circle success-color'></i>";  // Pick your icons --- If you want to change the color, system-wide.css has colors e.g. success-color, warning-color, danger-color. Just include it to the class
          $title = "Mark as Done?";                                     // Your Title
          $message = "Marked events will be removed from events list and will transfer to the history.";        // Your Message
          $your_link = "EVE-admin-list-of-events.php";                  // Your link
          $id_name = "mad";         //OPTIONAL                          // Create your id name (IF ONLY YOU ARE MANIPULATING A DATA E.G. DELETE, MARK AS DONE, ETC)
          $id = $row['event_id'];   //OPTIONAL                          // Set the id (IF ONLY YOU ARE MANIPULATING A DATA E.G. DELETE, MARK AS DONE, ETC)

          // 1. Make sure to include your php query to the your page
          // 2. Make sure to include "<script type="text/javascript" src="./js/jquery-3.6.4.js"></script>" at the head of your page

        include './php/popup.php'; 
      ?>

-->

<?php
    echo "<div class=\"popUpDisableBackground\" id=\"$popUpID\">
    <div class=\"popUpContainer\">
        $icon
        <div class=\"popUpHeader\">$title</div>
        <div class=\"popUpMessage\">$message</div>
        <div class=\"popUpButtonContainer\">
            <div class=\"secondary-button\" id=\"$popUpID\"><i class='bx bx-x'></i>Cancel</div>
            <a href=\"$your_link?$id_name=$id\" class=\"text-decoration-none\">
                <div class=\"primary-button confirmPopUp\"><i class='bx bx-check'></i>Confirm</div>
            </a>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#$popUpID').click(function() {
                $('.popUpDisableBackground#$popUpID').addClass('hide');
                setTimeout(function() {
                    $('.popUpDisableBackground#$popUpID').css('visibility', 'hidden');
                    $('.popUpDisableBackground#$popUpID').removeClass('hide');
                }, 300);
                $('.popUpContainer').removeClass('show');
            });

            $('.popUpDisableBackground#$popUpID').click(function() {
                $('.popUpDisableBackground#$popUpID').addClass('hide');
                setTimeout(function() {
                    $('.popUpDisableBackground#$popUpID').css('visibility', 'hidden');
                    $('.popUpDisableBackground#$popUpID').removeClass('hide');
                }, 300);
                $('.popUpContainer').removeClass('show');
            });

            $('.confirmPopUp').click(function() {
                $('.popUpDisableBackground#$popUpID').css('visibility', 'hidden');
                $('.popUpContainer').removeClass('show');
            });

            $('#$showPopUpButtonID').click(function() {
                $('.popUpDisableBackground#$popUpID').css('visibility', 'visible');
                $('.popUpContainer').addClass('show');
            });
        });
    </script>
</div>"
?>