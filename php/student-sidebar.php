<!-- Instructions

Replace the current <div> of sidebar with this via include:

<php
    // Set the active module and sub-active sub-item variables
    // $activeModule = '';
    // $activeSubItem = '';

    // Include the sidebar template
    // require './php/student-sidebar.php';
?>

List of variables: 

Here are the variables for the sidebar items in the provided HTML code:

1. Home:
   - Active: `$activeModule = 'home'`

2. Calendar:
   - Active: `$activeModule = 'calendar'`

3. Results:
   - Active: `$activeModule = 'results'`
   - Sub-Active (Overall Champion): `$activeSubItem = 'overall-champion'`
   - Sub-Active (Tournament): `$activeSubItem = 'tournament'`
   - Sub-Active (Competition): `$activeSubItem = 'competition'`

4. Event History:
   - Active: `$activeModule = 'event-history'`

5. About:
   - Active: `$activeModule = 'about'`

6. Configuration:
   - Active: `$activeModule = 'configuration'`

7. Sign Out:
   - Active: `$activeModule = 'sign-out'`

8. Sign In:
   - Active: `$activeModule = 'sign-in'`

Note: If $activeSubItem variable doesnt exist, only do $activeModule.

-->
<div class="container-fluid" id="popup">
  <div class="row popup-card">
    <form method="post">
      <div class="row title">
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
        <input type="text" class="adminInput" name="user_username" placeholder="Username" maxlength="20" required/>
      </div>
      <div class="row">
        <input type="password" class="adminInput" name="user_password" placeholder="Password" maxlength="128" required/>
      </div>
      <div class="row justify-content-center">
        <button input type="submit" name="sign-in-button" class="sign-in-button">Sign In</button>
      </div>
    </form>
  </div>
</div>
<div class="sidebar open box-shadow">
  <div class="bottom-design">
    <div class="design1"></div>
    <div class="design2"></div>
  </div>
  <div class="logo_details">
    <img src="./pictures/logo.png" alt="student council logo" class="icon logo">
    <div class="logo_name">Events Tabulation System</div>
    <i class="bx bx-arrow-to-right" id="btn"></i>
    <script src="./js/sidebar-state.js"></script>
  </div>
  <div class="wrapper">
    <div class="sidebar-content-container" style="border: none !important;">
      <ul class="nav-list">
        <li class="nav-item">
          <a href="index.php" class="<?php echo $activeModule === 'home' ? 'active' : ''; ?>">
            <i class="bx bx-home-alt"></i>
            <span class="link_name">Home</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="CAL-student-overall.php" class="<?php echo $activeModule === 'calendar' ? 'active' : ''; ?>">
            <i class="bx bx-calendar"></i>
            <span class="link_name">Calendar</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="#posts" class="menu_btn <?php echo $activeModule === 'results' ? 'active' : ''; ?>">
            <i class="bx bx-line-chart"><i class="dropdown_icon bx bx-chevron-down"></i></i>
            <span class="link_name">Results
              <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
            </span>
          </a>
          <ul class="sub_list">
            <li class="sub-item">
              <a href="BAR-student.php" class="<?php echo $activeSubItem === 'overall-champion' ? 'sub-active' : ''; ?>">
                <i class="bx bxs-circle sub-icon color-red"></i>
                <span class="sub_link_name">Overall Champion</span>
              </a>
            </li>
            <li class="sub-item">
              <a href="TOU-student-side.php" class="<?php echo $activeSubItem === 'tournament' ? 'sub-active' : ''; ?>">
                <i class="bx bxs-circle sub-icon color-green"></i>
                <span class="sub_link_name">Tournament</span>
              </a>
            </li>
            <li class="sub-item">
              <a href="COM-student_page.php" class="<?php echo $activeSubItem === 'competition' ? 'sub-active' : ''; ?>">
                <i class="bx bxs-circle sub-icon color-yellow"></i>
                <span class="sub_link_name">Competition</span>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="HIS-student-index.php" class="<?php echo $activeModule === 'event-history' ? 'active' : ''; ?>">
            <i class="bx bx-history"></i>
            <span class="link_name">Event History</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="about.php" class="<?php echo $activeModule === 'about' ? 'active' : ''; ?>">
            <i class="bx bx-info-circle"></i>
            <span class="link_name">About</span>
          </a>
        </li>
        <?php if(isset($_SESSION['user_username'])) { ?>
        <li class="nav-item">
          <a href="HOM-manage-post.php" class="<?php echo $activeModule === 'configuration' ? 'active' : ''; ?>">
            <i class="bx bx-cog"></i>
            <span class="link_name">Configuration</span>
          </a>
        </li>
        <?php } ?>
      </ul>
    </div>
    <div class="bottom-container">
      <div class="mode-btn" id="theme-toggle">
        <i class='lightmode bx bx-sun'></i>
        <i class='darkmode bx bx-moon'></i>
      </div>
      <?php if(isset($_SESSION['user_username'])) { ?>
        <li class="nav-item bottom">
          <a href="./php/sign-out.php" class="<?php echo $activeModule === 'sign-out' ? 'active' : ''; ?>">
            <i class="bx bx-log-out"></i>
            <span class="link_name">Sign Out</span>
          </a>
        </li>
      <?php } else { ?>
        <li class="nav-item bottom">
          <a onclick="show()" class="<?php echo $activeModule === 'sign-in' ? 'active' : ''; ?>">
            <i class="bx bx-log-in"></i>
            <span class="link_name">Sign In</span>
          </a>
        </li>
      <?php } ?>
    </div>
  </div>
</div>
