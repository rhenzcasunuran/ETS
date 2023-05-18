<?php include './php/connections.php' ?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event History | Manage Event</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="./css/theme-mode.css">
    <script src="./js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">

     <!-- Event History CSS -->
     <link rel="stylesheet" href="./css/HIS-manage-v1.css">


<!--
  Event History Configurations
---->
<form method="GET" action="?search=<?php echo $search_term; ?>">
  </head>

  <body>
    <!--Sidebar-->
    <div class="sidebar box-shadow">
      <div class="bottom-design">
        <div class="design1"></div>
        <div class="design2"></div>
      </div>

      <div class="logo_details">
        <img src="./pictures/logo.png" alt="student council logo" class="icon logo">
        <div class="logo_name">Events Tabulation System</div>
        <i class="bx bx-arrow-to-right" id="btn"></i>
      </div>
      <div class="wrapper">
        <li class="nav-item top">
        <a href="./HIS-student-index.php">
            <i class="bx bx-home-alt"></i>
            <span class="link_name">Go Back</span>
          </a>
        </li>
        <div class="sidebar-content-container">
          <ul class="nav-list">
            <li class="nav-item">
              <a href="#posts" class="menu_btn ">
                <i class="bx bx-news"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Posts
                  <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
              </a>
              <ul class="sub_list">
                <li class="sub-item">
                  <a href="#create_posts">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Create Post</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="#manage_posts">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Manage Posts</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#event_menu">
                <i class="bx bx-calendar-edit"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Events
                  <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
              </a>
              <ul class="sub_list">
                <li class="sub-item">
                  <a href="#list_of_events">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">List of Events</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="#event_config">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Event Configuration</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="#criteria_config">
                    <i class="bx bxs-circle sub-icon color-yellow"></i>
                    <span class="sub_link_name">Criteria Configuration</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="menu_btn">
                <i class="bx bx-calendar"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Calendar
                  <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
              </a>
              <ul class="sub_list">
                <li class="sub-item">
                  <a href="./CAL-admin-overall.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Overview</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="./CAL-admin-logs.php">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Logs</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#tournaments" class="menu_btn">
                <i class="bx bx-trophy"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Tournaments
                  <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
              </a>
              <ul class="sub_list">
                <li class="sub-item">
                  <a href="#live_scoring">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Live Scoring</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="#manage_brackets">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Manage Brackets</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="#brackets">
                    <i class="bx bxs-circle sub-icon color-yellow"></i>
                    <span class="sub_link_name">Brackets</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#competition" class="menu_btn">
                <i class="bx bx-medal"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Competition
                  <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
              </a>
              <ul class="sub_list">
                <li class="sub-item">
                  <a href="#manage_results">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Manage Results</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="#to_publish">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">To Publish</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="#published_results">
                    <i class="bx bxs-circle sub-icon color-yellow"></i>
                    <span class="sub_link_name">Published Results</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="#archive">
                    <i class="bx bxs-circle sub-icon color-yellow"></i>
                    <span class="sub_link_name">Archive</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="./HIS-admin-ManageEvent.php" class="menu_btn active">
                <i class="bx bx-history"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Event History
                  <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
              </a>
              <ul class="sub_list">
                <li class="sub-item">
                  <a href="./HIS-admin-ManageEvent.php"class="sub-active">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Event Page</span>
                  </a>
                </li>
                <li class="sub-item">
                <a href="./HIS-admin-highlights.php">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Highlights Page</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="./P&J-admin-formPJ.php">
                <i class="bx bx-group"></i>
                <span class="link_name">Judges & <br> Participants</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!--Page Content-->
    <section class="home-section">
      <div class="header">Manage Event</div>
        <div class="flex-container">
          <div class="main-containers">

            
         <div class="flex-box">
          
         <div class="search-wrapper">
         <input type="text" name="search" id="search" onkeyup="filterButtons()">
  </div>
  <div id="button-container">
  <?php
      $sql = "SELECT * FROM events";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          echo "<button id='event_".$row['event_id']."' name='".$row['event_name']."' class='event_button'>".$row['event_name']."</button>";
        }
      }
    ?>
          </div>
          </div>
         <div class="flex-box">
         <div id="select_event_text">Select an event first</div>

            <div class=radio-holder>
         <?php
                if ($result->num_rows > 0) {
                  $result->data_seek(0);
                  while($row = $result->fetch_assoc()) {
                    echo "<div class='activity_container' id='activity_".$row['event_id']."' style='display:none;'>";
                    echo "<label>".$row['activity_1']."<input type='radio' name='activity_".$row['event_id']."' value='".$row['activity_1']."'></label>";
                    echo "<label>".$row['activity_2']."<input type='radio' name='activity_".$row['event_id']."' value='".$row['activity_2']."'></label>";
                    echo "<label>".$row['activity_3']."<input type='radio' name='activity_".$row['event_id']."' value='".$row['activity_3']."'></label>";
                    echo "<label>".$row['activity_4']."<input type='radio' name='activity_".$row['event_id']."' value='".$row['activity_4']."'></label>";
                    echo "<label>".$row['activity_5']."<input type='radio' name='activity_".$row['event_id']."' value='".$row['activity_5']."'></label>";
                    echo "</div>";
                  }
                }
              ?>
       </div>
          </select>  
        </div>
       
          <div class="btn-group" id="diffbutton">
            <button type="button" id="but">Add + </button>
            <button type="button" id="but">Delete -</button>
          </div>
        </div>




        </div>
      
    </section>
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
    </script>
    <!--
Event History Scripts
-->
<script>

const searchInput = document.getElementById('search');
    const buttons = document.querySelectorAll('#button-container button');

    searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value.toLowerCase();
        buttons.forEach(button => {
            const buttonName = button.textContent.toLowerCase();
            if (buttonName.includes(searchTerm)) {
                button.style.display = 'block';
            } else {
                button.style.display = 'none';
            }
        });
    });
    </script>

<script>
var event_buttons = document.getElementsByClassName("event_button");
var selectEventText = document.getElementById("select_event_text");
var selected_event = null;
for (var i = 0; i < event_buttons.length; i++) {
  event_buttons[i].addEventListener("click", function() {
    // Remove highlight from previously selected button
    var prev_selected_button = document.querySelector(".selected");
    if (prev_selected_button) {
      prev_selected_button.classList.remove("selected");
    }
    
    //Hide activities of previously clicked event button
    var prev_activity_container = document.querySelector(".activity_container.show");
    if (prev_activity_container) {
      prev_activity_container.classList.remove("show");
      prev_activity_container.style.display = "none";
    }
    
    // Highlight the clicked button and show its activities
    if (selected_event !== this) {
      this.classList.add("selected");
      selected_event = this;
      var event_id = this.id.split("_")[1];
      var activity_container = document.getElementById("activity_"+event_id);
      if (activity_container.style.display === "none") {
        activity_container.classList.add("show");
        activity_container.style.display = "block";
      } else {
        activity_container.classList.remove("show");
        activity_container.style.display = "none";
      }
      
      selectEventText.style.display = "none";
    } else {
      selected_event = null;
      selectEventText.style.display = "block";
    }
  });
}
</script>
  </body>

</html>