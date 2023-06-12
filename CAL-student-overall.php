<?php
include './php/database_connect.php';
include './php/CAL-connect-to-gapi.php';

session_start();

if($conn){
  if(isset($_POST['sign-in-button'])){
    $username=mysqli_real_escape_string($conn,$_POST['user_username']);
    $password=mysqli_real_escape_string($conn,$_POST['user_password']);
    $sql="SELECT * FROM user WHERE user_username='$username' AND user_password='$password'";
    $result=mysqli_query($conn,$sql);
    if($result){
      if(mysqli_num_rows($result)>0){
        $_SESSION['message']="You are now Loggged In";
        $_SESSION['user_username']=$username;
        header("location:HOM-create-post.php");
      }
      else{
        echo '<script>alert("Username or Password combination are incorrect")</script>';
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuration</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="./css/theme-mode.css">
    <script src="./js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <link rel="stylesheet" href="./css/home-sidebar-style.css">
    <link rel="stylesheet" href="./css/system-wide.css">
    <!--Calendar JS-->
    <link rel="stylesheet" href="./css/CAL-calendar.css">
  </head>

  <body>
    <div class="container-fluid" id="popup">
      <div class="row popup-card">
        <form method="post">
          <div class="row">
            <div class="col-11 admin-text">
              <p>
                Administrator
              </p>
            </div>
            <div class="col-1 close ">
              <i class='bx bx-x' onclick="hide()"></i>
            </div>
          </div>
          <div class="row">
            <input type="text" name="user_username" placeholder="Username" maxlength="20" required/>
          </div>
          <div class="row">
            <input type="password" name="user_password" placeholder="Password" maxlength="128" required/>
          </div>
          <div class="row justify-content-center">
            <button input type="submit" name="sign-in-button" class="sign-in-button">Sign In</button>
          </div>
        </form>
      </div>
    </div>
     <!--SIDEBAR-->
     <?php
      // Set the active module and sub-active sub-item variables
      $activeModule = 'calendar';

      // Include the sidebar template
      require './php/student-sidebar.php';
    ?>
<!--Page Content-->
<section class="home-section mobile-size">
      <div id="calendar-container">
        <br>
        <br>
        <div id="calendar-header">
          <div class="calendar-navigation">
            <button type="button" id="mobile-prev-month" class="btn btn-outline-secondary"><</button>
            <button type="button" id="mobile-next-month" class="btn btn-outline-secondary">></button>
          </div>
          <h2 id="current-month"></h2>
        </div>
        <table id="mobile-calendar" class="table">
          <thead>
            <tr>
              <th class="text-center" scope="col">SU</th>
              <th class="text-center" scope="col">M</th>
              <th class="text-center" scope="col">TU</th>
              <th class="text-center" scope="col">W</th>
              <th class="text-center" scope="col">TH</th>
              <th class="text-center" scope="col">F</th>
              <th class="text-center" scope="col">SA</th>
            </tr>
          </thead>
          <tbody id="mobile-calendar-days" class="border border-5">
          </tbody>
        </table>
        <div>
          <p>Test</p>
          <p>Test</p>
          <p>Test</p>
          <p>Test</p>
          <p>Test</p>
          <p>Test</p>
          <p>Test</p>
        </div>
      </div>
    </section>
    <!-- Calendar Computer-->
    <section class="home-section computer-size">
      <div class="header">Calendar</div>
        <div class="d-flex">
          <h1 class="p-2" id="calendar-title"></h1>
          <!-- Mini Calendar -->
          <div class="flex-grow-1 p-2">
            <i id="calendarToggle" class="bx bxs-down-arrow"></i>
          </div>
          <div id="miniCalendar">
            <div class="mini-calendar-header">
              <button id="miniPreviousButton" class="previous-button"><i class='bx bxs-left-arrow'></i></button>
              <h2 id="miniCalendarHeader"></h2>
              <button id="miniNextButton" class="next-button"><i class='bx bxs-right-arrow'></i></button>
            </div>
            <table id="miniCalendarTable"></table>
          </div>
          <!-- Filter Dropdown -->
          <div class="dropdown p-2">
            <button class="btn btn-light btn-lg dropdown-toggle" style="width: 200px;" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
              Filters
            </button>
            <ul class="dropdown-menu" style="width: 200px;" aria-labelledby="dropdownMenuButton">
              <li>
                <div class="accordion" id="organizationAccordion">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" data-bs-parent="#organizationAccordion">
                        Organization
                      </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne">
                      <div class="accordion-body">
                        <div class="form-check org-type">
                          <input class="form-check-input" type="checkbox" value="" id="check-all-organization" checked>
                          <label class="form-check-label" for="check-all-organization">
                            <span class="pill-all">All</span>
                          </label>
                        </div>
                        <div class="form-check org-type">
                          <input class="form-check-input" type="checkbox" value="ACAP" id="check-acap">
                          <label class="form-check-label" for="check-acap">
                            <span class="pill-acap">ACAP</span>
                          </label>
                        </div>
                        <div class="form-check org-type">
                          <input class="form-check-input" type="checkbox" value="AECES" id="check-aeces">
                          <label class="form-check-label" for="check-aeces">
                            <span class="pill-aeces">AECES</span>
                          </label>
                        </div>
                        <div class="form-check org-type">
                          <input class="form-check-input" type="checkbox" value="ELITE" id="check-elite">
                          <label class="form-check-label" for="check-elite">
                            <span class="pill-elite">ELITE</span>
                          </label>
                        </div>
                        <div class="form-check org-type">
                          <input class="form-check-input" type="checkbox" value="GIVE" id="check-give">
                          <label class="form-check-label" for="check-give">
                            <span class="pill-give">GIVE</span>
                          </label>
                        </div>
                        <div class="form-check org-type">
                          <input class="form-check-input" type="checkbox" value="JEHRA" id="check-jehra">
                          <label class="form-check-label" for="check-jehra">
                            <span class="pill-jehra">JEHRA</span>
                          </label>
                        </div>
                        <div class="form-check org-type">
                          <input class="form-check-input" type="checkbox" value="JMAP" id="check-jmap">
                          <label class="form-check-label" for="check-jmap">
                            <span class="pill-jmap">JMAP</span>
                          </label>
                        </div>
                        <div class="form-check org-type">
                          <input class="form-check-input" type="checkbox" value="JPIA" id="check-jpia">
                          <label class="form-check-label" for="check-jpia">
                            <span class="pill-jpia">JPIA</span>
                          </label>
                        </div>
                        <div class="form-check org-type">
                          <input class="form-check-input" type="checkbox" value="PIIE" id="check-piie">
                          <label class="form-check-label" for="check-piie">
                            <span class="pill-piie">PIIE</span>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
              <li>
                <div class="accordion" id="eventTypeAccordion">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" data-bs-parent="#eventTypeAccordion">
                        Event Type
                      </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo">
                      <div class="accordion-body">
                        <div class="form-check event-type">
                          <input class="form-check-input" type="checkbox" value="" id="check-all-event" checked>
                          <label class="form-check-label" for="check-all-event">
                            All
                          </label>
                        </div>
                        <div class="form-check event-type">
                          <input class="form-check-input" type="checkbox" value="Tournament" id="check-tournament">
                          <label class="form-check-label" for="check-tournament">
                            <i class='bx bxs-square'></i> Tournament
                          </label>
                        </div>
                        <div class="form-check event-type">
                          <input class="form-check-input" type="checkbox" value="Competition" id="check-competition">
                          <label class="form-check-label" for="check-competition">
                            <i class='bx bxs-circle' ></i> Competition
                          </label>
                        </div>
                        <div class="form-check event-type">
                          <input class="form-check-input" type="checkbox" value="Standard" id="check-standard">
                          <label class="form-check-label" for="check-standard">
                            <i class='bx bxs-up-arrow' ></i> Standard
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <!-- Calendar -->
        <div class="container-fluid">
          <div class="row">
            <div class="container-fluid">
              <div class="calendar-row-styled shadow-lg p-3 mb-5">
                <div class="calendar-navigation">
                  <button type="button" id="prev-month" class="btn btn-primary rounded-pill"><h2><</h2></button>
                  <button type="button" id="next-month" class="btn btn-primary rounded-pill"><h2>></h2></button>
                </div>
                <table id="calendar" class="table">
                  <thead class="calendar-weeks">
                    <tr class="border border-0">
                      <th class="fw-normal fs-5 text-center border border-0" scope="col">SUNDAY</th>
                      <th class="fw-normal fs-5 text-center border border-0" scope="col">MONDAY</th>
                      <th class="fw-normal fs-5 text-center border border-0" scope="col">TUESDAY</th>
                      <th class="fw-normal fs-5 text-center border border-0" scope="col">WEDNESDAY</th>
                      <th class="fw-normal fs-5 text-center border border-0" scope="col">THURSDAY</th>
                      <th class="fw-normal fs-5 text-center border border-0" scope="col">FRIDAY</th>
                      <th class="fw-normal fs-5 text-center border border-0" scope="col">SATURDAY</th>
                    </tr>
                  </thead>
                  <tbody class="calendar-days border border-5">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <br>
      <br>
    </section>
    <!-- Scripts -->
    <script src="./js/script.js"></script>
    <script src="./js/change-theme.js"></script>
    <script src="./js/jquery-3.6.4.js"></script>
    <script src="./js/HOM-popup.js"></script>
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
    <!--Calendar JS-->
    <script defer src="./js/CAL-student-calendar.js"></script>
    <!-- Google API Calendar -->
    <script type="text/javascript">
      const CLIENT_ID = '<?php echo $CLIENT_ID; ?>';
      const API_KEY = '<?php echo $API_KEY; ?>';
      const DISCOVERY_DOC = '<?php echo $DISCOVERY_DOC; ?>';
      const SCOPES = '<?php echo $SCOPES; ?>';

      let tokenClient;
      let gapiInited = false;
      let gisInited = false;

      function gapiLoaded() {
        gapi.load('client', initializeGapiClient);
      }

      async function initializeGapiClient() {
        await gapi.client.init({
          apiKey: API_KEY,
          discoveryDocs: [DISCOVERY_DOC],
        });
        gapiInited = true;
      }

      function gisLoaded() {
        tokenClient = google.accounts.oauth2.initTokenClient({
          client_id: CLIENT_ID,
          scope: SCOPES,
          callback: '',
        });
        gisInited = true;
      }

      async function handleAuthClick(eventDate, categoryName, eventDescription, eventTime) {
        tokenClient.callback = async (resp) => {
          if (resp.error !== undefined) {
            throw (resp);
          }
          await listUpcomingEvents(eventDate, categoryName, eventDescription, eventTime);
        };

        if (gapi.client.getToken() === null) {
          tokenClient.requestAccessToken({prompt: 'consent'});
        } else {
          tokenClient.requestAccessToken({prompt: ''});
          await handleSignoutClick();
        }
      }

      async function handleSignoutClick() {
        const token = gapi.client.getToken();
        if (token !== null) {
          google.accounts.oauth2.revoke(token.access_token);
          gapi.client.setToken('');
        }
      }

      async function listUpcomingEvents(eventDate, categoryName, eventDescription, eventTime) {

        let timeString = eventTime;
        let date = new Date();
        date.setHours(0); // Set the date to a fixed value to only represent the time
        date.setMinutes(0);
        date.setSeconds(0);

        let timeParts = timeString.split(':');
        let hours = parseInt(timeParts[0], 10);
        let minutes = parseInt(timeParts[1].split(' ')[0], 10);

        if (timeString.indexOf('PM') !== -1 && hours !== 12) {
          hours += 12;
        }

        date.setHours(hours);
        date.setMinutes(minutes);

        let formattedTime = date.toLocaleTimeString('en-US', { hour12: false });

        const encodedEventDesc = he.encode(eventDescription);
        const encodedCategoryName = he.encode(categoryName);

        const event = {
          'summary': encodedCategoryName,
          'description': encodedEventDesc,
          'start': {
            'dateTime': eventDate + 'T' + formattedTime,
            'timeZone': 'Asia/Singapore'
          },
          'end': {
            'dateTime': eventDate + 'T' + formattedTime,
            'timeZone': 'Asia/Singapore'
          },
          'reminders': {
            'useDefault': false,
            'overrides': [
              {'method': 'email', 'minutes': 24 * 60},
              {'method': 'popup', 'minutes': 10}
            ]
          }
        };

        const request = gapi.client.calendar.events.insert({
          'calendarId': 'primary',
          'resource': event
        });

        function appendPre(message) {
          var content = document.getElementById('content');
          var pre = document.createElement('pre');
          pre.textContent = message;
          content.appendChild(pre);
        }

        request.execute(function(event) {
          appendPre('Event added successfully!');
        });
      }
    </script>
    <script async defer src="https://apis.google.com/js/api.js" onload="gapiLoaded()"></script>
    <script async defer src="https://accounts.google.com/gsi/client" onload="gisLoaded()"></script>
    <!--Popper JS-->
    <script src="./js/popper.min.js"></script>
    <!--Bootstrap JS-->
    <script src="./js/bootstrap.min.js"></script>
    <!--HE JS-->
    <script src="https://cdn.jsdelivr.net/npm/he/he.js"></script>
  </body>
</html>