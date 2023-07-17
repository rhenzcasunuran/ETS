<?php
    include 'database_connect.php';

    $type = $_POST['type'];
    $desc = $_POST['desc'];
    $date = $_POST['e_date'];
    $time = $_POST['e_time'];
    $popUpID = $_POST['e_popUp'];
    $showPopUpButtonID = $_POST['e_showPopUp'];

    $output = '';

    if ($type == 1) {
        $sql = "SELECT * FROM number_of_wins;";
        $NoW = mysqli_query($conn, $sql);

        $output .= '<div class="row flex-column flex-md-row">' .
            '<div class="form-group col-md-8">' .
                '<label for="event-description" class="form-label fw-bold">Event Description <span class="req" id="reqDesc">*</span></label>' .
                '<textarea id="event-description" name="event-description" class="form-control second-layer" placeholder="Type Description Here" minlength="5" maxlength="255" required>'.$desc.'</textarea>' .
            '</div>' .
            '<div class="form-group col-md-4">' .
                '<label class="form-label fw-bold">Date & Time <span class="req" id="reqDateTime">*</span></label>' .
                '<input type="date" class="form-control date" id="date" max="" min="" name="date" value="'.$date.'" required>' .
                '<input type="time" class="form-control mt-2" id="time" name="time" value="'.$time.'" required>' .
                '<label class="form-label fw-bold mt-1">Match Style <span class="req" id="reqMatchStyle">*</span></label>' .
                '<select id="event-match-style" class="form-control selectpicker" title="Select Match Style" name="event-match-style" required>' .
                '<option value="" selected>Select Match Style</option>';
                    $row = mysqli_num_rows($NoW);
                    if ($row > 0) {
                        while ($row = mysqli_fetch_array($NoW)) {
                            $output .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                        }
                    }
                $output .=    '</select>' .
            '</div>' .
        '</div>' .
        '<div class="row flex-column flex-md-row d-flex justify-content-end align-items-center">' .
            '<button type="submit" class="primary-button" id="save-btn" name="save-btn-tournament" onclick="saveEvent()" disabled>' .
                '<div class="tooltip-popup flex-column" id="tooltip">' .
                    '<div class="tooltipText" id="textType">Event Type<i class="bx bx-check" id="checkType"></i></div>' .
                    '<div class="tooltipText" id="textEvent">Event<i class="bx bx-check" id="checkEvent"></i></div>' .
                    '<div class="tooltipText" id="textCategory">Category<i class="bx bx-check" id="checkCategory"></i></div>' .
                    '<div class="tooltipText" id="textDescription">Event Description (5 or more char)<i class="bx bx-check" id="checkDescription"></i></div>' .
                    '<div class="tooltipText" id="textDate">Date: <span id="dateText"></span><i class="bx bx-check" id="checkDate"></i></div>' .
                    '<div class="tooltipText" id="textTime">Time<i class="bx bx-check" id="checkTime"></i></div>' .
                    '<div class="tooltipText" id="textMatchStyle">Match Style<i class="bx bx-check" id="checkMatchStyle"></i></div>' .
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
        '<script type="text/javascript" src="./js/EVE-admin-disable-button-tournament.js"></script>';
    
    }
    else if ($type == 2 || $type == "") {
        $output .= '<div class="row flex-column flex-md-row">' .
        '<div class="form-group col-md-6">' .
            '<label for="event-description" class="form-label fw-bold">Event Description <span class="req" id="reqDesc">*</span></label>' .
            '<textarea id="event-description" name="event-description" class="form-control second-layer" placeholder="Type Description Here" minlength="5" maxlength="255" required>'.$desc.'</textarea>' .
        '</div>' .
        '<div class="form-group col-md-6">' .
            '<div class="groupCriteria">' .
              '<label class="form-label fw-bold">Criteria</label>' .
              '<div class="text-button icon-button" id="editCriteria"><i class="bx bx-edit-alt"></i></div>' .
            '</div>' .
            '<div class="form-control second-layer" id="criteria" name="criteria">' .
              '<div id="criteria-container"></div>' .
            '</div>' .
        '</div>' .
      '</div>' .
      '<div class="row flex-column flex-md-row">' .
        '<div class="form-group col-md-4">' .
            '<label class="form-label fw-bold">Judges</label>' .
            '<div id="event-judges" class="form-control judges-container" name="event-judges"></div>' .
        '</div>' .
        '<div class="form-group col-md-4">' .
            '<label class="form-label fw-bold">Date & Time <span class="req" id="reqDateTime">*</span></label>' .
            '<input type="date" class="form-control date" id="date" max="" min="" name="date" value="'.$date.'" required>' .
            '<input type="time" class="form-control mt-2" id="time" name="time" value="'.$time.'" required>' .
        '</div>' .
        '<div class="form-group col-md-4">' .
          '<label class="form-label fw-bold">Code</label>' .
          '<div class="form-control" id="no-code">--------------------</div>' .
          '<input type="hidden" class="form-control" id="code" name="code" readonly required>' .
        '</div>' .
      '</div>' .
      '<div class="row flex-column flex-md-row d-flex justify-content-end align-items-center">' .

        '<button type="submit" class="primary-button" id="save-btn" name="save-btn" onclick="saveEvent()" disabled>' .
          '<div class="tooltip-popup flex-column" id="tooltip">' .
              '<div class="tooltipText" id="textType">Event Type<i class="bx bx-check" id="checkType"></i></div>' .
              '<div class="tooltipText" id="textEvent">Event<i class="bx bx-check" id="checkEvent"></i></div>' .
              '<div class="tooltipText" id="textCategory">Category<i class="bx bx-check" id="checkCategory"></i></div>' .
              '<div class="tooltipText" id="textDescription">Event Description (5 or more char)<i class="bx bx-check" id="checkDescription"></i></div>' .
              '<div class="tooltipText" id="textCriteria">Criteria should be 100%<i class="bx bx-check" id="checkCriteria"></i></div>' .
              '<div class="tooltipText" id="textDate">Date: <span id="dateText"></span><i class="bx bx-check" id="checkDate"></i></div>' .
              '<div class="tooltipText" id="textTime">Time<i class="bx bx-check" id="checkTime"></i></div>' .
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
            $("#editCriteria").click(function() {
                window.location.href = "EVE-admin-criteria-configuration.php";
            });
        </script>' .
      '<script type="text/javascript" src="./js/EVE-admin-generate-codes.js"></script>' .
      '<script type="text/javascript" src="./js/EVE-admin-other-codes.js"></script>' .
      '<script type="text/javascript" src="./js/EVE-admin-disable-button.js"></script>';
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
            '<input type="date" class="form-control date" id="date" max="" min="" name="date" value="'.$date.'" required>' .
            '<input type="time" class="form-control mt-2" id="time" name="time" value="'.$time.'" required>' .
        '</div>' .
      '</div>' .
      '<div class="row flex-column flex-md-row d-flex justify-content-end align-items-center">' .

        '<button type="submit" class="primary-button" id="save-btn" name="save-btn-standard" onclick="saveEvent()" disabled>' .
          '<div class="tooltip-popup flex-column" id="tooltip">' .
              '<div class="tooltipText" id="textType">Event Type<i class="bx bx-check" id="checkType"></i></div>' .
              '<div class="tooltipText" id="textEvent">Event<i class="bx bx-check" id="checkEvent"></i></div>' .
              '<div class="tooltipText" id="textDescription">Event Description (5 or more char)<i class="bx bx-check" id="checkDescription"></i></div>' .
              '<div class="tooltipText" id="textDate">Date: <span id="dateText"></span><i class="bx bx-check" id="checkDate"></i></div>' .
              '<div class="tooltipText" id="textTime">Time<i class="bx bx-check" id="checkTime"></i></div>' .
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
      '<script type="text/javascript" src="./js/EVE-admin-disable-button-standard.js"></script>';
    }


    echo $output;
?>
