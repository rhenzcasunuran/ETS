<?php
include './php/sign-in.php';
include './php/database_connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Overall Results</title>
  <!-- Theme Mode -->
  <link rel="stylesheet" href="./css/theme-mode.css">
  <script src="./js/default-theme.js"></script>
  <!-- Link Styles -->
  <link rel="stylesheet" href="./css/boxicons.css">
  <link rel="stylesheet" href="./css/responsive.css">
  <link rel="stylesheet" href="./css/sidebar-style.css">
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/BAR-obg.css">
  <link rel="stylesheet" href="./css/system-wide.css">

  <!-- Event Config Styles -->
  <link rel="stylesheet" href="./css/EVE-admin-bootstrap-select.min.css">
  <link rel="stylesheet" href="./css/EVE-admin-bootstrap4.min.css">
  <link rel="stylesheet" href="./css/EVE-admin-list-of-events.css">
  <link rel="stylesheet" href="./css/EVE-admin-confirmation.css">
  <link rel="stylesheet" href="./css/multiselection.css">

  <script src="./js/BAR-java.js"></script>
</head>

<body>
  <div class="popup-background" id="anon-confirm">
      <div class="row popup-container" id="anon_prompt">
        <div class="col-4">
          <i class='bx bxs-error prompt-icon warning-color'></i> <!--icon-->
        </div>
        <div class="col-8 text-start text-container">
          <h3 class="text-header">Update Anonymity?</h3>   <!--header-->
          <p>This will update both the admin and student side of the module.</p> <!--text-->
        </div>
        <div class="div">
          <button class="outline-button"><i class='bx bx-chevron-left'></i>Return</button>
          <button class="primary-button" id="anon_button_confirm"><i class='bx bx-x' ></i>Confirm</button>
        </div>
      </div>
    </div>
  <?php
  $activeModule = 'overall-results';
  require './php/admin-sidebar.php';

  $barGraph = "bar_graph";
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
            <div class="col" id="toggle-container">
              <div class="anon">
                <div class="anon-switch">
                  <label class="switch">
                    <input type="checkbox" id="anon_button">
                    <span class="slider"></span>
                    <div class="row" id="anon-label">Show&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hide</div>
                  </label>
                </div>
              </div>
            </div>
          <div class="col" id="notice">
            <p><i class="bx bxs-error prompt-icon warning-color"></i> Ranking is currently hidden.</p>
          </div>
          <div class="col" id="event-select">
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
            ?>
              
            <?php
            $query = "SELECT * FROM `bar_graph`
            INNER JOIN organization ON bar_graph.organization_id = organization.organization_id 
            INNER JOIN ongoing_event_name ON bar_graph.ongoing_event_name_id = ongoing_event_name.ongoing_event_name_id
            WHERE bar_graph.ongoing_event_name_id = '$selectedEventName'
            ORDER BY bar_meter DESC";
            $result = $conn->query($query);
            
            if ($result->num_rows > 0) 
            {
              $rows = array();
          
              while ($row = $result->fetch_assoc()) 
              {
                $rows[] = $row;
              }
          
              $showDiv = true;
              foreach ($rows as $row) 
              {
                $isAnon = $row['isAnon'];
          
                if ($isAnon != 1) {
                  $showDiv = false;
                  echo '<script>document.getElementById("notice").style.display = "none";</script>';
                  break;
                }
              }
          
              if ($showDiv) 
              {
                ?>
                <div class="popup-background" id="anon-admin-popup">
                  <div class="row popup-container">
                      <div class="col-4">
                          <i class="bx bxs-hide prompt-icon" style="cursor: default;"></i> <!--icon-->
                      </div>
                      <div class="col-8 text-start text-container">
                          <h3 class="text-header">Anonymity is turned on</h3>   <!--header-->
                          <p>Toggle it off to publicly display the ranking.</p> <!--text-->
                      </div>
                      <div  class="div">
                        <button class="success-button" onclick="hideMarkAsDone()"><i class="bx bx-check"></i>Confirm</button>
                      </div>
                  </div>
                </div>
                <?php
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
                        <i class="bx bx-arrow-to-left" id="arrow-btn"></i>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col" id="rank_container">';
                      if ($result->num_rows > 0) 
                      {
                        $organizations = array();
                        while ($row = $result->fetch_assoc()) 
                        {
                          $organizations[] = $row;
                        }
            
                        foreach ($organizations as $org) 
                        {
                          $organization = $org["organization_name"];
                          $imagePath = "logos/" . $organization . ".png";
                          $imageAnonPath = "logos/anon.png";
            
                          echo '<div class="row" id="logos">
                                  <div class="logo_container" ><img src="' . $imagePath . '" name="' . $organization . '"></div>
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
                          $organizations[] = $row;
                        }
            
                        foreach ($organizations as $org) {
                          $organization = $org["organization_name"];
                          $barMeter = $org["bar_meter"];
                          $isAnon = $org["isAnon"];
                          $percentage = number_format($barMeter, 0, '.', '');
            
                          echo '<div class="row">
                                  <div class="meter_container">
                                    <div class="meter" id="' . $organization . '" style="width: ' . $barMeter . '%;">
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
                          <div class="row" id="org-window">
                            <div class="col" id="winnings-container">
                              <div class="winnings">
                                Please select an organization
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

    adminPopup = document.getElementById('anon-admin-popup');

    var hideMarkAsDone = function () {
      adminPopup.style.display = 'none';
    }
  </script>
</body>

</html>
