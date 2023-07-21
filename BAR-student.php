<?php 
  include './php/database_connect.php';
  include './php/admin-signin.php';
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overall Champion</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="./css/theme-mode.css">
    <script src="./js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <link rel="stylesheet" href="./css/home-sidebar-style.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/BAR-obg.css">
    <link rel="stylesheet" href="./css/system-wide.css">
    <link rel="Website Icon" type="png" href="./pictures/logo.png">
    <script src="./js/jquery-3.6.4.js"></script>
    <script src="./js/BAR-student-java.js"></script>
  </head>

  <body>
      <div class="popup-background hide" id="anon-admin-popup" style="display: flex; justif-content: center; align-items: center; text-align: center;">
        <div class="row popup-container">
          <div class="col text-start text-container">
            <h3 class="text-header" style="text-align: center;">Who's your champion?</h3>   <!--header-->
            <p style="text-align: center;">Uh-oh! Looks like the event is still ongoing. Be sure to check it back again later.</p> <!--text-->
          </div>
          <div  class="div">
            <button class="success-button" onclick="hideMarkAsDone()">Will do!</button>
          </div>
        </div>
      </div>
    <?php
    $activeModule = 'results';
    $activeSubItem = 'overall-champion';
    require './php/student-sidebar.php';

    $barGraph = "bar_graph";
    $imageAnonPath = "logos/anon.png";
    $query = "SELECT COUNT(*) as count FROM " . $barGraph;
    $result = mysqli_query($conn, $query);

    if ($result) 
    {
      $row = mysqli_fetch_assoc($result);
      $rowCount = $row['count'];

      if ($rowCount > 0) 
      {
        ?>
        <section class="home-section">
          <div class="header">Overall Organization Standing</div>
          <div class="container-fluid" id="body-content">
            <div class="row" id="switches">
              <div class="col" id="event-select" style="padding-bottom: 20px;">
                <p>Event&nbsp</p>
                <form id="myForm" method="POST">
                  <div class="select-container">
                    <select name="ongoing_event_name_id" id="eventSelect">
              <?php
                $options = "SELECT * FROM `ongoing_event_name`";
                $result = $conn->query($options);

                if ($result->num_rows > 0) {
                  $selectedEventName = isset($_POST['ongoing_event_name_id']) ? $_POST['ongoing_event_name_id'] : '';
                
                  if ($selectedEventName === '') {
                    $firstRow = $result->fetch_assoc();
                    $selectedEventName = $firstRow['ongoing_event_name_id'];
                    echo "<option value='{$firstRow['ongoing_event_name_id']}' selected>{$firstRow['event_name']} {$firstRow['year_created']}</option>";
                  }
                
                  $result->data_seek(0);
                
                  while ($option = $result->fetch_assoc()) {
                    $eventID = $option['ongoing_event_name_id'];
                    $value = $option['event_name'];
                    $year = $option['year_created'];
                    $isSelected = ($eventID == $selectedEventName) ? 'selected' : '';
                    if ($eventID != $firstRow['ongoing_event_name_id']) {
                      echo "<option value='$eventID' $isSelected>$value $year</option>";
                    }
                  }
                }
                $obg = "SELECT * FROM `bar_graph`
                INNER JOIN organization ON bar_graph.organization_id = organization.organization_id 
                INNER JOIN ongoing_event_name ON bar_graph.ongoing_event_name_id = ongoing_event_name.ongoing_event_name_id
                WHERE bar_graph.ongoing_event_name_id = $selectedEventName
                ORDER BY bar_meter DESC;";
                $result = $conn->query($obg);

                echo
                '</select>
                </form>
                </div>
                </div>
                </div>
                
                <div class="col" id="graph-section">
                  <div class="graph_container">
                    <div class="row" id="arrow-container">
                      <div class="arrow">
                        <i class="hide-arrow bx bx-arrow-to-left" id="arrow-btn"></i>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col" id="rank_container">';
                      if ($result->num_rows > 0) {
                        $organizations = array();
                        while ($row = $result->fetch_assoc()) {
                            $row['isAnon'] = $row['isAnon'] == 1 ? true : false;
                            $organizations[] = $row;
                        }

                        foreach ($organizations as $org) {
                          $organization = $org["organization_name"];
                          $barMeter = $org["bar_meter"];
                          $isAnon = $org["isAnon"];
                          $percentage = number_format($barMeter, 0, '.', '');

                          $imagePath = $isAnon ? $imageAnonPath : "logos/" . $organization . ".png";

                          $imageName = $isAnon ? "anon" : $organization;
                      
                          echo '<div class="row" id="logos">
                                  <div class="logo_container" ><img src="' . $imagePath . '" name="' . $imageName . '"></div>
                                </div>';
                        }                      
                      }
                      echo 
                      '</div>
                      <div class="col-11">';

                      $obg = "SELECT * FROM `bar_graph`
                      INNER JOIN organization on bar_graph.organization_id = organization.organization_id 
                      INNER JOIN ongoing_event_name ON bar_graph.ongoing_event_name_id = ongoing_event_name.ongoing_event_name_id
                      WHERE bar_graph.ongoing_event_name_id = '$selectedEventName'
                      ORDER BY bar_meter DESC;";
                      $result = $conn->query($obg);

                      if ($result->num_rows > 0) {
                        $organizations = array();
                        while ($row = $result->fetch_assoc()) {
                            $row['isAnon'] = $row['isAnon'] == 1 ? true : false;
                            $organizations[] = $row;
                        }
                        
                        foreach ($organizations as $org) {
                          $organization = $org["organization_name"];
                          $barMeter = $org["bar_meter"];
                          $isAnon = $org["isAnon"];
                          $percentage = number_format($barMeter, 0, '.', '');

                          $imagePath = $isAnon ? $imageAnonPath : "logos/" . $organization . ".png";

                          $meterID = $isAnon ? "anon" : $organization;
                          $meterName = $isAnon ? "anon" : $organization;
                      
                          echo '<div class="row">
                              <div class="meter_container">
                                  <div class="meter" id="' . $meterID . '" name="' . $meterName . '" style="width: ' . $barMeter . '%;">
                                      <div id="percentage">
                                          ' . $percentage . '%
                                      </div>
                                  </div>
                              </div>
                          </div>';
                        }                      
                      }
                      echo 
                      '</div>
                      </div>
                      </div>
                      <div class="col" id="org-profile">
                        <div class="col" id="org-body">
                          <div class="col" id="select-org">
                            <div class="select-group">
                              <img src="pictures\select.png" alt="" id="select-img">
                              <p id="select-text">Please select an organization</p>
                            </div>
                          </div>
                          <div class="row" id="org-content">
                            <div class="col-2">
                              <div class="profile-logo-container">
                                <img src="" alt="" class="profile-logo" id="profile-logo">
                              </div>
                            </div>
                            <div class="col">
                              <div class="profile-name-container">
                                <label class="profile-name" id="profile-name"></label>
                              </div>
                            </div>
                          </div>
                          <div class="row" id="participation">
                            <div class="col profile-button" id="tournament">
                              <div class="profile-btn" id="tourna-btn">
                                Tournaments
                              </div>
                            </div>
                            <div class ="col profile-button" id="competition">
                              <div class="profile-btn"  id="comp-btn">
                                Competitions
                              </div>
                            </div>
                          </div>
                          <div class="row" id="org-window">
                            <div class="col" id="winnings-container">
                              <div class="winnings">
                                
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>';
              }
            } else {
      ?>
        <div class="text-center" id="no-event-container">
          <i class='bx bx-calendar-x'></i>
          <h1>No Events</h1>
          <p>Looks like you have no events created. <br> You can do so by clicking the button below.</p>
          <div class="row justify-content-center">
            <button class="primary-button" id="create-new-event-btn">
              <i class='bx bx-add-to-queue d-flex justify-content-center align-items-center'></i>
              Create an Event
            </button>
          </div>
        </div>
        </div>
  </section>

          <script>
            $(document).ready(function () {
              $("#create-new-event-btn").click(function (event) {
                event.preventDefault(); // Prevent default form submission

                window.location.href = "EVE-admin-create-event.php";
              });
            });
          </script>
        <?php
    }
    mysqli_close($conn);
  ?>

    <!-- Scripts -->
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

      adminPopup = document.getElementById('anon-admin-popup');

      var hideMarkAsDone = function () {
        adminPopup.style.display = 'none';
      }
    </script>
  </body>
</html>