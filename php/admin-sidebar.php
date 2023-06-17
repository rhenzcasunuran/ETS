<!-- Instructions

Replace the current <div> of sidebar with this via include:

<php
    // Set the active module and sub-active sub-item variables
    // $activeModule = '';
    // $activeSubItem = '';

    // Include the sidebar template
    // require './php/admin-sidebar.php';
?>

List of variables: 

1. Calendar:
   - Active: `$activeModule = 'calendar'`
   - Sub-Active: `$activeSubItem = 'overview'`
   - Sub-Active: `$activeSubItem = 'logs'`

2. Posts:
   - Active: `$activeModule = 'posts'`
   - Sub-Active (Create Post): `$activeSubItem = 'create-post'`
   - Sub-Active (Draft & Scheduled Post): `$activeSubItem = 'draft-scheduled-post'`
   - Sub-Active (Manage Post): `$activeSubItem = 'manage-post'`

3. Events:
   - Active: `$activeModule = 'events'`
   - Sub-Active (List of Events): `$activeSubItem = 'list-of-events'`
   - Sub-Active (Event Configuration): `$activeSubItem = 'event-configuration'`
   - Sub-Active (Criteria Configuration): `$activeSubItem = 'criteria-configuration'`

4. Overall Results:
   - Active: `$activeModule = 'overall-results'`

5. Tournaments:
   - Active: `$activeModule = 'tournaments'`
   - Sub-Active (Create Tournament): `$activeSubItem = 'create-tournament'`
   - Sub-Active (Live Scoring): `$activeSubItem = 'live-scoring'`
   - Sub-Active (Manage Brackets): `$activeSubItem = 'manage-brackets'`

6. Competition:
   - Active: `$activeModule = 'competition'`
   - Sub-Active (Manage Results): `$activeSubItem = 'manage-results'`
   - Sub-Active (To Publish): `$activeSubItem = 'to-publish'`
   - Sub-Active (Published Results): `$activeSubItem = 'published-results'`
   - Sub-Active (Archive): `$activeSubItem = 'archive'`

7. Event History:
   - Active: `$activeModule = 'event-history'`
   - Sub-Active (Event Page): `$activeSubItem = 'event-page'`
   - Sub-Active (Highlights Page): `$activeSubItem = 'highlights-page'`

8. Judges & Participants:
   - Active: `$activeModule = 'judges-participants'`

Note: If $activeSubItem variable doesnt exist, only do $activeModule.

-->

<!--Sidebar-->
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
    <li class="nav-item top">
      <a href="index.php">
        <i class="bx bx-home-alt"></i>
        <span class="link_name">Go Back</span>
      </a>
    </li>
    <div class="sidebar-content-container"  style="border:none !important;">
      <ul class="nav-list">
        <li class="nav-item">
          <a href="#posts" class="menu_btn <?php echo ($activeModule === 'posts') ? 'active' : ''; ?>">
            <i class="bx bx-news"><i class="dropdown_icon bx bx-chevron-down"></i></i>
            <span class="link_name">Posts
              <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
            </span>
          </a>
          <ul class="sub_list">
            <li class="sub-item">
              <a href="HOM-create-post.php" class="<?php echo ($activeSubItem === 'create-post') ? 'sub-active' : ''; ?>">
                <i class="bx bxs-circle sub-icon color-red"></i>
                <span class="sub_link_name">Create Post</span>
              </a>
            </li>
            <li class="sub-item">
              <a href="HOM-draft-scheduled-post.php" class="<?php echo ($activeSubItem === 'draft-scheduled-post') ? 'sub-active' : ''; ?>">
                <i class="bx bxs-circle sub-icon color-green"></i>
                <span class="sub_link_name">Draft & Scheduled Post</span>
              </a>
            </li>
            <li class="sub-item">
              <a href="HOM-manage-post.php" class="<?php echo ($activeSubItem === 'manage-post') ? 'sub-active' : ''; ?>">
                <i class="bx bxs-circle sub-icon color-yellow"></i>
                <span class="sub_link_name">Manage Post</span>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#event_menu" class="menu_btn <?php echo ($activeModule === 'events') ? 'active' : ''; ?>">
            <i class="bx bx-calendar-edit"><i class="dropdown_icon bx bx-chevron-down"></i></i>
            <span class="link_name">Events
              <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
            </span>
          </a>
          <ul class="sub_list">
            <li class="sub-item">
              <a href="EVE-admin-list-of-events.php" class="<?php echo ($activeSubItem === 'list-of-events') ? 'sub-active' : ''; ?>">
                <i class="bx bxs-circle sub-icon color-red"></i>
                <span class="sub_link_name">List of Events</span>
              </a>
            </li>
            <li class="sub-item">
              <a href="EVE-admin-event-configuration.php" class="<?php echo ($activeSubItem === 'event-configuration') ? 'sub-active' : ''; ?>">
                <i class="bx bxs-circle sub-icon color-green"></i>
                <span class="sub_link_name">Event Configuration</span>
              </a>
            </li>
            <li class="sub-item">
              <a href="EVE-admin-criteria-configuration.php" class="<?php echo ($activeSubItem === 'criteria-configuration') ? 'sub-active' : ''; ?>">
                <i class="bx bxs-circle sub-icon color-yellow"></i>
                <span class="sub_link_name">Criteria Configuration</span>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="CAL-admin-overall.php" class="<?php echo ($activeModule === 'calendar') ? 'active' : ''; ?>">
              <i class="bx bx-calendar"></i>
              <span class="link_name">Calendar</span>
          </a>
        </li>
        <li class="nav-item">
            <a href="BAR-admin.php" class="<?php echo ($activeModule === 'overall-results') ? 'active' : ''; ?>">
                <i class='bx bx-bar-chart-alt-2'></i>
                <span class="link_name">Overall Results</span>
            </a>
        </li>
        <li class="nav-item">
          <a href="#tournaments" class="menu_btn <?php echo ($activeModule === 'tournaments') ? 'active' : ''; ?>">
            <i class="bx bx-trophy"><i class="dropdown_icon bx bx-chevron-down"></i></i>
            <span class="link_name">Tournaments
              <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
            </span>
          </a>
          <ul class="sub_list">
          <li class="sub-item">
              <a href="TOU-Create-Tournament.php" class="<?php echo ($activeSubItem === 'create-tournament') ? 'sub-active' : ''; ?>">
                <i class="bx bxs-circle sub-icon color-red"></i>
                <span class="sub_link_name">Create Tournament</span>
              </a>
            </li>
            <li class="sub-item">
              <a href="TOU-Live-Scoring-Admin.php" class="<?php echo ($activeSubItem === 'live-scoring') ? 'sub-active' : ''; ?>">
                <i class="bx bxs-circle sub-icon color-green"></i>
                <span class="sub_link_name">Live Scoring</span>
              </a>
            </li>
            <li class="sub-item">
              <a href="TOU-bracket-admin.php"  class="<?php echo ($activeSubItem === 'manage-brackets') ? 'sub-active' : ''; ?>">
                <i class="bx bxs-circle sub-icon color-yellow"></i>
                <span class="sub_link_name">Manage Brackets</span>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
            <a href="#competition" class="menu_btn <?php echo ($activeModule === 'competition') ? 'active' : ''; ?>">
                <i class="bx bx-medal"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Competition
                <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
            </a>
            <ul class="sub_list">
                <li class="sub-item">
                    <a href="COM-manage_results_page.php" class="<?php echo ($activeSubItem === 'manage-results') ? 'sub-active' : ''; ?>">
                        <i class="bx bxs-circle sub-icon color-red"></i>
                        <span class="sub_link_name">Manage Results</span>
                    </a>
                </li>
                <li class="sub-item">
                    <a href="COM-tobepublished_page.php" class="<?php echo ($activeSubItem === 'to-publish') ? 'sub-active' : ''; ?>">
                        <i class="bx bxs-circle sub-icon color-green"></i>
                        <span class="sub_link_name">To Publish</span>
                    </a>
                </li>
                <li class="sub-item">
                    <a href="COM-published_page.php" class="<?php echo ($activeSubItem === 'published-results') ? 'sub-active' : ''; ?>">
                        <i class="bx bxs-circle sub-icon color-yellow"></i>
                        <span class="sub_link_name">Published Results</span>
                    </a>
                </li>
                <li class="sub-item">
                    <a href="#archive" class="<?php echo ($activeSubItem === 'archive') ? 'sub-active' : ''; ?>">
                        <i class="bx bxs-circle sub-icon color-purple"></i>
                        <span class="sub_link_name">Archive</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#event_history" class="menu_btn <?php echo ($activeModule === 'event-history') ? 'active' : ''; ?>">
                <i class="bx bx-history"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Event History
                <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
            </a>
            <ul class="sub_list">
                <li class="sub-item">
                    <a href="HIS-admin-ManageEvent.php" class="<?php echo ($activeSubItem === 'event-page') ? 'sub-active' : ''; ?>">
                        <i class="bx bxs-circle sub-icon color-red"></i>
                        <span class="sub_link_name">Event Page</span>
                    </a>
                </li>
                <li class="sub-item">
                    <a href="HIS-admin-highlights.php" class="<?php echo ($activeSubItem === 'highlights-page') ? 'sub-active' : ''; ?>">
                        <i class="bx bxs-circle sub-icon color-green"></i>
                        <span class="sub_link_name">Highlights Page</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="P&J-admin-formPJ.php" class="<?php echo ($activeModule === 'judges-participants') ? 'active' : ''; ?>">
                <i class="bx bx-group"></i>
                <span class="link_name">Judges & <br> Participants</span>
            </a>
        </li>
        <li class="nav-item">
          <a href="CAL-admin-logs.php" class="<?php echo ($activeModule === 'activity-logs') ? 'active' : ''; ?>">
              <i class='bx bx-receipt'></i>
              <span class="link_name">Activity Logs</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
