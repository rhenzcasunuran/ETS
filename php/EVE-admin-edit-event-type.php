<?php
    include 'database_connect.php';

    $eventID = $_POST['eventID'];
    $type = $_POST['type'];
    $desc = $_POST['desc'];
    $date = $_POST['e_date'];
    $time = $_POST['e_time'];
    $code = $_POST['e_code'];
    $popUpID = $_POST['e_popUp'];
    $showPopUpButtonID = $_POST['e_showPopUp'];
    $overallIncluded = isset($_POST['overallIncluded']) ? $_POST['overallIncluded'] : 0;

    $checkedAttribute = ($overallIncluded == 0) ? 'checked' : '';

    $output = '';

    if ($type == 1) {
        $sql = "SELECT * FROM number_of_wins;";
        $NoW = mysqli_query($conn, $sql);

        $sql = "SELECT number_of_wins_id FROM tournament WHERE event_id = $eventID;";
        $query = mysqli_query($conn, $sql);
        if ($row2 = mysqli_num_rows($query) > 0){
            $data = mysqli_fetch_array($query);
            $TNoW = $data[0];

            $sql = "SELECT number_of_wins FROM number_of_wins WHERE number_of_wins_id = '$TNoW'";
            $query = mysqli_query($conn, $sql);
            $data = mysqli_fetch_array($query);
            $TNoWText = $data['number_of_wins'];
        }


        $output .= '<div class="row flex-column flex-md-row">' .
            '<div class="form-group col-md-8">' .
                '<label for="event-description" class="form-label fw-bold">Event Description <span class="req" id="reqDesc">*</span></label>' .
                '<textarea id="event-description" name="event-description" class="form-control second-layer tou-desc" placeholder="Type Description Here" minlength="5" maxlength="255" required>'.$desc.'</textarea>' .
            '</div>' .
            '<div class="form-group col-md-4">' .
                '<label class="form-label fw-bold">Date & Time <span class="req" id="reqDateTime">*</span></label>' .
                '<input type="date" class="form-control date" id="date" max="" min="'.$date.'" name="date" value="'.$date.'" required>' .
                '<input type="time" class="form-control mt-2" id="time" name="time" value="'.$time.'" required>' .
                '<label class="form-label fw-bold mt-1">Match Style ';

                if ($date <= date('Y-m-d')) {
                    $output .=  '</label>' .
                                '<div id="event-match-style" class="form-control disable" name="event-match-style">'.$TNoWText.'</div>';
                } else {
                    $output .= '<span class="req" id="reqMatchStyle">*</span></label>' .
                            '<select id="event-match-style" class="form-control selectpicker" title="Select Match Style" name="event-match-style" required>' .
                            '<option value="" selected>Select Match Style</option>';
                    
                    $row = mysqli_num_rows($NoW);
                    if ($row > 0) {
                        while ($row = mysqli_fetch_array($NoW)) {
                            if ($row2 = mysqli_num_rows($query) > 0) {
                                if ($TNoW !== $row[0]) {
                                    $output .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                                } else {
                                    $output .= '<option value="' . $row[0] . '" selected>' . $row[1] . '</option>';
                                }
                            } else {
                                $output .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                            }
                        }
                    }
                    
                    $output .= '</select>';
                }

                $output .= '<div class="overall-included form-control">' .
                '<input type="checkbox" id="overallIncluded" name="overall" value="'.$overallIncluded.'" '.$checkedAttribute.'>' .
                '<label class="form-label fw-bold">Exclude from Overall Statistics</label>' .
                '<script>

                $(document).ready(function() {
                    var overallIncluded = '.$overallIncluded.';
                    var checkedAttribute = "'.$checkedAttribute.'";
            
                    $("#overallIncluded").change(function() {
                        overallIncluded = $(this).is(":checked") ? 0 : 1;
                        $(this).val(overallIncluded);
                        console.log(overallIncluded);
                    }).change();
                });

                </script>' .
            '</div>' .
            '</div>' .
            '<input type="hidden" name="id" value='.$eventID.'>' .
        '</div>' .
        '<div class="row flex-column flex-md-row d-flex justify-content-end align-items-center">' .
            '<button class="primary-button" id="save-btn" name="save-btn-tournament" disabled>' .
                '<div class="tooltip-popup flex-column" id="tooltip">' .
                    '<div class="tooltipText" id="textDescription">Event Description (5 or more char)<i class="bx bx-check" id="checkDescription"></i></div>' .
                    '<div class="tooltipText" id="textDate"><span id="dateText"></span><i class="bx bx-check" id="checkDate"></i></div>' .
                    '<div class="tooltipText" id="textTime">Time<i class="bx bx-check" id="checkTime"></i></div>';
                    if ($date > date('Y-m-d')) {
                        $output .= '<div class="tooltipText" id="textMatchStyle">Match Style<i class="bx bx-check" id="checkMatchStyle"></i></div>' ;
                    }
                    $output .= '<div class="tooltipText" id="textHasChanges">Any changes are made<i class="bx bx-check" id="checkHasChanges"></i></div>' .
                '</div>' .
                'Save Changes' .
            '</button>' .
            '<div class="outline-button" id="cancelBtn">Cancel</div>' .
        '</div>' .
        '<script>
            $("#'.$showPopUpButtonID.'").click(function() {
                $(".popUpDisableBackground#'.$popUpID.'").css("visibility", "visible");
                $(".popUpContainer").addClass("show");
            });
        </script>' .
        '<script type="text/javascript" src="./js/EVE-admin-edit-other-codes.js"></script>' .
        '<script type="text/javascript" src="./js/EVE-admin-edit-disable-button-tournament.js"></script>';
    
    }
    else if ($type == 2) {
        $sql = "SELECT ole.event_id, c.competition_id, j.* 
        FROM ongoing_list_of_event AS ole
        JOIN competition AS c ON c.event_id = ole.event_id
        JOIN judges AS j ON j.competition_id = c.competition_id
        WHERE ole.event_id = $eventID";

        $query = mysqli_query($conn, $sql);

        $output .= '<div class="row flex-column flex-md-row">' .
        '<div class="form-group col-md-6">' .
            '<label for="event-description" class="form-label fw-bold">Event Description <span class="req" id="reqDesc">*</span></label>' .
            '<textarea id="event-description" name="event-description" class="form-control second-layer" placeholder="Type Description Here" minlength="5" maxlength="255" required>'.$desc.'</textarea>' .
        '</div>' .
        '<div class="form-group col-md-6 disable">' .
            '<div class="groupCriteria">' .
              '<label class="form-label fw-bold">Criteria</label>' .
            '</div>' .
            '<div class="form-control second-layer" id="criteria" name="criteria">' .
              '<div id="criteria-container"></div>' .
            '</div>' .
        '</div>' .
      '</div>' .
      '<div class="row flex-column flex-md-row">' .
        '<div class="form-group col-md-4 disable">' .
            '<label class="form-label fw-bold">Judges</label>' .
            '<div id="event-judges" class="form-control judges-container" name="event-judges">';
            $row = mysqli_num_rows($query);
                if ($row > 0){
                    while ($row = mysqli_fetch_array($query)) {
                        $output .= '<div class = "judge-name">' .$row['judge_name'].' ('.$row['judge_nickname'].')</div>';
                    }
                }
            $output .=   '</div>' .
        '</div>' .
        '<div class="form-group col-md-4">' .
            '<label class="form-label fw-bold">Date & Time <span class="req" id="reqDateTime">*</span></label>' .
            '<input type="date" class="form-control date" id="date" max="" min="'.$date.'" name="date" value="'.$date.'" required>' .
            '<input type="time" class="form-control mt-2" id="time" name="time" value="'.$time.'" required>' .
        '</div>' .
        '<div class="form-group col-md-4">' .
            '<label class="form-label fw-bold">Code <i class="bx bx-copy" onclick="copyCode(this)" data-placement="bottom" title="Copied"></i> <i class="bx bx-hide" id="revealCode"></i></label>' .
            '<div class="form-control" id="display-code">'.$code.'</div>' .
            '<input type="hidden" id="eventId" name="eventId" value="'.$eventID.'">' .
            '<div class="overall-included form-control">' .
                '<input type="checkbox" id="overallIncluded" name="overall" value="'.$overallIncluded.'" '.$checkedAttribute.'>' .
                '<label class="form-label fw-bold">Exclude from Overall Statistics</label>' .
                '<script>

                $(document).ready(function() {
                    var overallIncluded = '.$overallIncluded.';
                    var checkedAttribute = "'.$checkedAttribute.'";
            
                    $("#overallIncluded").change(function() {
                        overallIncluded = $(this).is(":checked") ? 0 : 1;
                        $(this).val(overallIncluded);
                    }).change();
                });

                </script>' .
            '</div>' .
        '</div>' .
      '</div>' .
      '<div class="row flex-column flex-md-row d-flex justify-content-end align-items-center">' .

        '<button type="submit" class="primary-button" id="save-btn" name="save-btn" disabled>' .
          '<div class="tooltip-popup flex-column" id="tooltip">' .
              '<div class="tooltipText" id="textDescription">Event Description (5 or more char)<i class="bx bx-check" id="checkDescription"></i></div>' .
              '<div class="tooltipText" id="textDate"><span id="dateText"></span><i class="bx bx-check" id="checkDate"></i></div>' .
              '<div class="tooltipText" id="textTime">Time<i class="bx bx-check" id="checkTime"></i></div>' .
              '<div class="tooltipText" id="textHasChanges">Any changes are made<i class="bx bx-check" id="checkHasChanges"></i></div>' .
          '</div>' .
          'Save Changes' .
      '</button>' .
        '<div class="outline-button" id="cancelBtn">Cancel</div>' .
      '</div>' .
      '<script>
            $("#'.$showPopUpButtonID.'").click(function() {
                $(".popUpDisableBackground#'.$popUpID.'").css("visibility", "visible");
                $(".popUpContainer").addClass("show");
            });
        </script>' .
      '<script>' .
      'var eventCode = document.querySelector("#display-code");
      var eye = document.querySelector("#revealCode");
      var eventCodeCode = eventCode.textContent;
  
      function copyCode(element) {
        // Show tooltip
        $(element).tooltip(\'show\');
  
        // Hide tooltip after a delay
        setTimeout(function() {
          $(element).tooltip(\'hide\');
        }, 1500); // Adjust the delay as needed
        var range = document.createRange();
        navigator.clipboard.writeText(eventCodeCode);
        $(element).removeAttr(\'data-toggle\').removeAttr(\'title\').off(\'mouseenter mouseleave\');
      }
  
      eye.addEventListener("click", function(){
        if(eye.classList.toggle("reveal")){
          eye.classList.remove("bx-hide");
          eye.classList.add("bx-show");
          eventCode.style.webkitTextSecurity = "none";
        }
        else{
          eye.classList.remove("bx-show");
          eye.classList.add("bx-hide");
          eventCode.style.webkitTextSecurity = "disc";
        }
      });' .
      '</script>' .
      '<script type="text/javascript" src="./js/EVE-admin-edit-other-codes.js"></script>' .
      '<script type="text/javascript" src="./js/EVE-admin-edit-disable-button.js"></script>';
    }
    else if ($type == 3) {
        $output .= '<div class="row flex-column flex-md-row">' .
      '</div>' .
      '<div class="row flex-column flex-md-row">' .
        '<div class="form-group col-md-8">' .
            '<label for="event-description" class="form-label fw-bold">Event Description <span class="req" id="reqDesc">*</span></label>' .
            '<textarea id="event-description" name="event-description" class="form-control second-layer" placeholder="Type Description Here" minlength="5" maxlength="255" required>'.$desc.'</textarea>' .
        '</div>' .
        '<div class="form-group col-md-4">' .
            '<label class="form-label fw-bold">Date & Time <span class="req" id="reqDateTime">*</span></label>' .
            '<input type="date" class="form-control date" id="date" max="" min="'.$date.'" name="date" value="'.$date.'" required>' .
            '<input type="time" class="form-control mt-2" id="time" name="time" value="'.$time.'" required>' .
            '<input type="hidden" name="id" value='.$eventID.'>' .
        '</div>' .
      '</div>' .
      '<div class="row flex-column flex-md-row d-flex justify-content-end align-items-center">' .

        '<button type="submit" class="primary-button" id="save-btn" name="save-btn-standard" onclick="saveEvent()" disabled>' .
          '<div class="tooltip-popup flex-column" id="tooltip">' .
              '<div class="tooltipText" id="textDescription">Event Description (5 or more char)<i class="bx bx-check" id="checkDescription"></i></div>' .
              '<div class="tooltipText" id="textDate">Date: <span id="dateText"></span><i class="bx bx-check" id="checkDate"></i></div>' .
              '<div class="tooltipText" id="textTime">Time<i class="bx bx-check" id="checkTime"></i></div>' .
              '<div class="tooltipText" id="textHasChanges">Any changes are made<i class="bx bx-check" id="checkHasChanges"></i></div>' .
          '</div>' .
          'Save Changes' .
      '</button>' .
        '<div class="outline-button" id="cancelBtn">Cancel</div>' .
      '</div>' .
      '<script>
            $("#'.$showPopUpButtonID.'").click(function() {
                $(".popUpDisableBackground#'.$popUpID.'").css("visibility", "visible");
                $(".popUpContainer").addClass("show");
            });
        </script>' .
      '<script type="text/javascript" src="./js/EVE-admin-other-codes.js"></script>' .
      '<script type="text/javascript" src="./js/EVE-admin-edit-disable-button-standard.js"></script>';
    }

    echo $output;
?>
