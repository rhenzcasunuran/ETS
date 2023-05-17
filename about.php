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
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <link rel="stylesheet" href="./css/home-sidebar-style.css">
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
        <div class="sidebar-content-container">
          <ul class="nav-list">
            <li class="nav-item">
              <a href="index.php">
                <i class="bx bx-home-alt"></i>
                <span class="link_name">Home</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="calendar.html">
                <i class="bx bx-calendar"></i>
                <span class="link_name">Calendar</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="results.html">
                <i class="bx bx-line-chart"></i>
                <span class="link_name">Results</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="about.html" class="menu_btn active">
                <i class="bx bx-info-circle"></i>
                <span class="link_name">About</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="configuration.html">
                <i class="bx bx-cog"></i>
                <span class="link_name">Configuration</span>
              </a>
            </li>
          </ul>
        </div>
        <div class="bottom-container">
          <div class="mode-btn" id="theme-toggle">
            <i class='lightmode bx bx-sun'></i>
            <i class='darkmode bx bx-moon'></i>
          </div>
          <li class="nav-item bottom">
            <a href="#logout">
              <i class="bx bx-log-out"></i>
              <span class="link_name">Sign Out</span>
            </a>
          </li>
        </div>
      </div>
    </div>
    <!--Page Content-->
    <section class="home-section">
      <div class="header">Home</div>
    </section>
    <!-- Scripts -->
    <script src="./js/script.js"></script>
    <script src="./js/change-theme.js"></script>
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
  </body>

</html>