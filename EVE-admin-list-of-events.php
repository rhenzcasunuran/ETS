<?php
  include './php/sign-in.php';
  include './php/database_connect.php';
  include './php/EVE-admin-event-config-get-data.php';
  include './php/EVE-admin-edit-event.php';
  include './php/EVE-admin-get-event-data.php';
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Events</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="./css/theme-mode.css">
    <script src="./js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <link rel="stylesheet" href="./css/system-wide.css">

    <!-- Event Config Styles -->
    <link rel="stylesheet" href="./css/EVE-admin-bootstrap-select.min.css">
    <link rel="stylesheet" href="./css/EVE-admin-bootstrap4.min.css">
    <link rel="stylesheet" href="./css/EVE-admin-list-of-events.css">
    <link rel="stylesheet" href="./css/EVE-admin-confirmation.css">
    <link rel="stylesheet" href="./css/multiselection.css">

    <script src="./js/jquery-3.6.4.js"></script>
  </head>

  <body>
    <?php echo $popupContent; ?>
    <?php
      $row = mysqli_num_rows($event_result);
      if ($row > 0){
        while ($row = mysqli_fetch_array($event_data)):;
    ?>
      <?php 
          $popUpID = "markAsDone{$row['event_id']}";
          $showPopUpButtonID = "eventDoneBtn{$row['event_id']}";
          $icon = "<i class='bx bxs-check-circle success-color'></i>";
          $title = "Mark as Done?";
          $message = "Marked events will be removed from events list and will transfer to the history.";
          $your_link = "EVE-admin-list-of-events.php";
          $id_name = "mad";
          $id = $row['event_id'];

          // Make sure to include your php query to the your page

        include './php/popup.php'; 
      ?>
      
    <?php
    endwhile;
      }
    ?>
    <!--Sidebar-->
    <?php
      $activeModule = 'events';
      $activeSubItem = 'list-of-events';

      require './php/admin-sidebar.php';
    ?>
    <!--Page Content-->
    <section class="home-section">
    <form method="POST" id="listFormContainer"> 
      <div class="container-fluid d-flex row justify-content-center m-0" id="event-wrapper">
        <?php
          $row = mysqli_num_rows($event_result2);
          if ($row > 0){
            ?>
                <!--Pagination-->
          <?php
            $list_table_query = "SELECT * FROM ongoing_list_of_event WHERE is_archived = '0' AND is_deleted = '0'";
            $your_php_location = "EVE-admin-list-of-events.php";
            if (isset($_GET['filterValue'])) {
              $filterValues = $_GET['filterValue'];
  
              // Check if the filterValues array is not empty
              if (!empty($filterValues)) {
                $filterConditions = array();
                
                // Iterate over the filterValues and create filter conditions
                foreach ($filterValues as $filterValue) {
                  // Add appropriate condition based on the filter value
                  if ($filterValue === 'tournament') {
                    $filterConditions[] = "event_type_id = '1'";
                  } elseif ($filterValue === 'competition') {
                    $filterConditions[] = "event_type_id = '2'";
                  } elseif ($filterValue === 'standard') {
                    $filterConditions[] = "event_type_id = '3'";
                  }
                }
                
                // Combine the filter conditions with OR logic
                if (!empty($filterConditions)) {
                  $filterQuery = "(" . implode(" OR ", $filterConditions) . ")";
                  $list_table_query .= " AND $filterQuery";
                }
              }
            }

            if (isset($_GET['search'])) {
              $searchValue = $_GET['search'];
              $list_table_query = "SELECT ole.*,
                                  oen.*,
                                  et.*
                                  FROM ongoing_event_name AS oen
                                  JOIN event_type AS et
                                  JOIN ongoing_list_of_event AS ole ON ole.ongoing_event_name_id = oen.ongoing_event_name_id AND ole.event_type_id = et.event_type_id
                                  WHERE (is_archived = '0' AND ole.is_deleted = '0')";

              $list_table_query .= " AND (ole.category_name LIKE '%$searchValue%' OR oen.event_name LIKE '%$searchValue%' OR et.event_type LIKE '%$searchValue%' OR ole.event_date LIKE '%$searchValue%' OR ole.event_time LIKE '%$searchValue%' OR ole.event_description LIKE '%$searchValue%' OR ole.event_code LIKE '%$searchValue%')";                    
            }

            if (isset($_GET['filterValue'])) {
              $filterValueArray = $_GET['filterValue'];

              $filteredEventTypes = [];
          
              foreach ($filterValueArray as $filterValue) {
          
                  $sanitizedFilterValue = mysqli_real_escape_string($conn, $filterValue);
          
                  $filteredEventTypes[] = $sanitizedFilterValue;
              }
          
              $filteredEventTypesString = "'" . implode("', '", $filteredEventTypes) . "'";
          
              $list_table_query .= " AND et.event_type IN ($filteredEventTypesString)";
            }
            require './php/pagination w filter.php';
            $list_table_query_with_limit = "SELECT ole.*,
                                            oen.*,
                                            et.*
                                            FROM ongoing_event_name AS oen
                                            JOIN event_type AS et
                                            JOIN ongoing_list_of_event AS ole ON ole.ongoing_event_name_id = oen.ongoing_event_name_id AND ole.event_type_id = et.event_type_id
                                            WHERE (is_archived = 0 AND is_deleted = 0)";
                                              
          if (!empty($filterQuery)) {
            $list_table_query_with_limit .= " AND $filterQuery";
          }

          if (!empty($searchValue)) {
            $list_table_query_with_limit .= " AND (ole.category_name LIKE '%$searchValue%' OR oen.event_name LIKE '%$searchValue%' OR et.event_type LIKE '%$searchValue%' OR ole.event_date LIKE '%$searchValue%' OR ole.event_time LIKE '%$searchValue%' OR ole.event_description LIKE '%$searchValue%' OR ole.event_code LIKE '%$searchValue%')";
          }

          if ($sortValue === 'eventname') {
            $list_table_query_with_limit .= " ORDER BY  oen.event_name";
            if ($sortOrder === 'descending') {
              $list_table_query_with_limit .= " DESC";
            } else {
              $list_table_query_with_limit .= " ASC";
            }
          } elseif ($sortValue === 'eventtype') {
            $list_table_query_with_limit .= " ORDER BY et.event_type";
            if ($sortOrder === 'descending') {
              $list_table_query_with_limit .= " DESC";
            } else {
              $list_table_query_with_limit .= " ASC";
            }
          } elseif ($sortValue === 'categoryname') {
            $list_table_query_with_limit .= " ORDER BY  ole.category_name";
            if ($sortOrder === 'descending') {
              $list_table_query_with_limit .= " DESC";
            } else {
              $list_table_query_with_limit .= " ASC";
            }
          } else {
            $list_table_query_with_limit .= " ORDER BY  ole.event_date";
            if ($sortOrder === 'descending') {
              $list_table_query_with_limit .= " DESC, ole.event_time DESC";
            } else {
              $list_table_query_with_limit .= " ASC, ole.event_time ASC";
            }
          }
          
          // Apply LIMIT and OFFSET for pagination
          $list_table_query_with_limit .= " LIMIT $start_from, $numberOfItems;";

          $listedItems = mysqli_query($conn, $list_table_query_with_limit);
          ?>  
              <style>
                #event-wrapper {
                  padding-bottom: 100px;
                }
              </style>    
              <div class="row d-flex justify-content-between align-items-center w-100">
                <div class="header col-7">List of Events</div>
                <div class="button-container col-5">
                  <button class="primary-button icon-button" id="create-event-btn"><i class='bx bx-add-to-queue'></i></button>
                  <button class="danger-button icon-button" id="delete-event-btn"><i class='bx bx-trash'></i></button>
                  <button class="secondary-button icon-button" id="edit-event-btn"><i class='bx bx-edit'></i></button>
                </div>
                <div class="filter-container">
                  <div class="searchbar-container">
                      <i class='bx bx-search' id="searchIcon"></i>
                      <input type="text" id="searchInput" placeholder="Search" maxlength="25" autocomplete="off">
                  </div>
                  <div class="filtering-container">
                    <div class="element" id="filterBtn">
                      <div class="filter-group">
                        Filters 
                        <i class='bx bx-filter-alt'></i>
                      </div>
                    </div>  
                    <div class="element" id="filterDropdown">
                      <form action="" id="filterForm">
                          <div class="form-group">
                            <input type="checkbox" name="filterValue" value="tournament" id="tournament"<?php if (isset($_GET['filterValue']) && in_array('tournament', $_GET['filterValue'])) echo ' checked'; else if (empty($_GET['filterValue'])) echo ' checked'; ?>>
                            <label for="tournament">Tournament</label>
                          </div>
                          <div class="form-group">
                            <input type="checkbox" name="filterValue" value="competition" id="competition"<?php if (isset($_GET['filterValue']) && in_array('competition', $_GET['filterValue'])) echo ' checked'; else if (empty($_GET['filterValue'])) echo ' checked'; ?>>
                            <label for="competition">Competition</label>
                          </div>
                          <div class="form-group">
                            <input type="checkbox" name="filterValue" value="standard" id="standard"<?php if (isset($_GET['filterValue']) && in_array('standard', $_GET['filterValue'])) echo ' checked'; else if (empty($_GET['filterValue'])) echo ' checked'; ?>>
                            <label for="standard">Standard</label>
                          </div>
                      </form>
                    </div>
                  </div>

                  <div class="sort-container">
                    <div class="element" id="sortBtn">
                      <div class="filter-group">
                        Sort by 
                        <i class='bx bx-filter'></i>
                      </div>  
                    </div>
                    <div class="element" id="sortDropdown">
                        <form action="" method="POST" id="sortForm">
                          <div class="form-group">
                            <input type="radio" name="sortValue" value="eventname" id="event_name"<?php if (isset($_GET['sortValue']) && $_GET['sortValue'] === 'eventname') echo ' checked'; ?>>
                            <label for="event_name">Event Name</label>
                          </div>
                          <div class="form-group">
                            <input type="radio" name="sortValue" value="eventtype" id="event_type"<?php if (isset($_GET['sortValue']) && $_GET['sortValue'] === 'eventtype') echo ' checked'; ?>>
                            <label for="event_type">Event Type</label>
                          </div>
                          <div class="form-group">
                            <input type="radio" name="sortValue" value="categoryname" id="category_name"<?php if (isset($_GET['sortValue']) && $_GET['sortValue'] === 'categoryname') echo ' checked'; ?>>
                            <label for="category_name">Category Name</label>
                          </div>
                          <div class="form-group">
                            <input type="radio" name="sortValue" value="datetime" id="date_time"<?php echo (isset($_GET['sortValue']) && $_GET['sortValue'] === 'datetime') ? ' checked' : (empty($_GET['sortValue']) ? ' checked' : ''); ?>>
                            <label for="date_time">Date & Time</label>
                          </div>
                        </form>
                        <form action="" method="POST" class="order" id="orderForm">
                          <div class="form-group">
                            <input type="radio" name="sortOrder" value="ascending" id="ascending"<?php echo (isset($_GET['sortOrder']) && $_GET['sortOrder'] === 'ascending') ? ' checked' : (empty($_GET['sortOrder']) ? ' checked' : ''); ?>>
                            <label for="ascending">Ascending</label>
                          </div>
                          <div class="form-group">
                            <input type="radio" name="sortOrder" value="descending" id="descending"<?php if (isset($_GET['sortOrder']) && $_GET['sortOrder'] === 'descending') echo ' checked'; ?>>
                            <label for="descending">Descending</label>
                          </div>
                        </form>
                    </div>
                  </div>
                </div>
              </div>
            <?php
            while ($row = mysqli_fetch_array($listedItems)):;
                if ($row['event_type_id'] == '2') {
                  if ($row['overall_include'] == '0') {
                    echo '<style>';
                    echo '.element#e'.$row['event_id'].' .not-included {';
                    echo '    display: block;';
                    echo '}';
                    echo '</style>';
                  }
            ?>
            <div class="element" id="e<?php echo $row['event_id'];?>">
              <div class="not-included"></div>
              <div class="multi-select" id="multiSelect<?php echo $row['event_id'];?>">
                <input type="checkbox" name="deleteEvent[]" value="<?php echo $row['event_id'];?>">
              </div>
              <div class="row">
              <div class="element-group col-sm-6 col-lg-3">
                  <p class="element-label">Event Type</p>
                  <p class="element-content"><?php echo $row['event_type'];?></p>
                </div>
                <div class="element-group col-sm-6 col-lg-3">
                  <p class="element-label">Event</p>
                  <p class="element-content"><?php echo $row['event_name'];?></p>
                </div>
                <div class="element-group col-sm-6 col-lg-3">
                  <p class="element-label">Category</p>
                  <p class="element-content"><?php echo $row['category_name'];?></p>
                </div>
                <div class="element-group col-sm-6 col-lg-3">
                  <p class="element-label">Date & Time</p>
                  <p class="element-content"><?php 
                  $date_sql = "SELECT DATE_FORMAT('$row[event_date]', '%M %d, %Y') AS formattedDate FROM ongoing_list_of_event;";
                  $date_result = mysqli_query($conn, $date_sql);
                  $get_date_result = mysqli_fetch_assoc($date_result);
                  $date = $get_date_result['formattedDate'];

                  $time_sql = "SELECT TIME_FORMAT('$row[event_time]', '%h:%i %p') AS formattedTime FROM ongoing_list_of_event;";
                  $time_result = mysqli_query($conn, $time_sql);
                  $get_time_result = mysqli_fetch_assoc($time_result);
                  $time = $get_time_result['formattedTime'];
                  echo $date;?>; <?php echo $time;?></p>
                </div>
              </div>
              <div class="row">
                <div class="element-group col-sm-6 col-lg-6">
                  <p class="element-label">Event Desciption</p>
                  <p class="element-content"><?php echo $row['event_description'];?></p>
                </div>
                <div class="element-group col-sm-6 col-lg-2">
                  <p class="element-label">Code 
                    <i class='bx bx-copy' onclick="copyCode<?php echo $row[0];?>(this)" data-placement="bottom" title="Copy">
                      
                    </i> 
                    <i class='bx bx-hide' id="revealCode<?php echo $row[0];?>"></i>
                  </p>
                  <p class="element-content-secured" id="eventCode<?php echo $row['event_id'];?>"><?php echo $row['event_code'];?></p>
                </div>
                <div class="element-group col-sm-12 col-lg-4" id="eventBtn">
                  <button class="success-button justify-self-end event-done-btn<?php echo $row['event_id'];?>" id="eventDoneBtn<?php echo $row['event_id'];?>">Mark as Done</button>
                  <div class="button-container more-btn<?php echo $row[0];?>" id="more-btn">
                      <button class="primary-button justify-self-end" id="event-edit-btn<?php echo $row['event_id'];?>"><i class='bx bx-edit-alt'></i>Edit Event</button>
                  </div>

                  <script>
                    $(document).ready(function() {
                      $("#event-edit-btn<?php echo $row['event_id'];?>").click(function(event) {
                        event.preventDefault(); // Prevent default form submission
                      
                        window.location.href = "EVE-admin-edit-event.php?eec=<?php echo $row['event_id']?>";
                      });

                      $("#eventDoneBtn<?php echo $row['event_id'];?>").click(function(event) {
                        event.preventDefault(); // Prevent default form submission
                      });
                    });

                    //Enable Button on Date
                    var markAsDoneButton = document.querySelector('button.event-done-btn<?php echo $row['event_id'];?>');
                    var editEventButton = document.querySelector('button#event-edit-btn<?php echo $row['event_id'];?>');

                    var targetDateTime = new Date('<?php echo $row['event_date'] . ' ' . $row['event_time']; ?>');

                    var currentDateTime = new Date();

                    if (currentDateTime > targetDateTime) {
                      markAsDoneButton.disabled = false;
                    }
                    else {
                      markAsDoneButton.disabled = true;
                    }

                    const moreBtn<?php echo $row[0];?> = document.querySelector(".more-btn<?php echo $row[0];?>");
                    const doneBtn<?php echo $row[0];?> = document.querySelector(".event-done-btn<?php echo $row[0];?>");
                    const multiSelect<?php echo $row[0]?> = document.querySelector("#multiSelect<?php echo $row[0]?>");

                    if (typeof(Storage) !== "undefined") {
                        // If we need to open the bar
                        if(localStorage.getItem("editEvent") == "active"){
                          moreBtn<?php echo $row[0];?>.classList.add("editOpen");
                          doneBtn<?php echo $row[0];?>.classList.add("doneClose");
                          multiSelect<?php echo $row[0]?>.classList.add("deleteOpen");
                          document.querySelector("#edit-event-btn").classList.add("editOpen");
                        }
                        else if (localStorage.getItem("editEvent") == "notActive"){
                          moreBtn<?php echo $row[0];?>.classList.remove("editOpen");
                          doneBtn<?php echo $row[0];?>.classList.remove("doneClose"); 
                          multiSelect<?php echo $row[0]?>.classList.remove("deleteOpen");
                          document.querySelector("#edit-event-btn").classList.remove("editOpen");
                        }
                    }

                    const eventCode<?php echo $row[0];?> = document.querySelector("#eventCode<?php echo $row[0];?>");
                    const eye<?php echo $row[0];?> = document.querySelector("#revealCode<?php echo $row[0];?>");

                    function copyCode<?php echo $row[0];?>(element) {
                      // Show tooltip
                      $(element).attr('title', 'Copied');
                      $(element).tooltip('show');

                      // Hide tooltip after a delay
                      setTimeout(function() {
                        $(element).tooltip('hide');
                      }, 1500); // Adjust the delay as needed
                      var range = document.createRange();
                      eventCode<?php echo $row[0];?>.style.webkitTextSecurity = "none";
                      range.selectNode(eventCode<?php echo $row[0];?>);
                      window.getSelection().removeAllRanges(); // clear current selection
                      window.getSelection().addRange(range); // to select text
                      document.execCommand("copy");


                      if(eye<?php echo $row[0];?>.classList.contains("reveal")){
                        eventCode<?php echo $row[0];?>.style.webkitTextSecurity = "none";
                      }
                      else{
                        eventCode<?php echo $row[0];?>.style.webkitTextSecurity = "disc";
                      }

                      window.getSelection().removeAllRanges();// to deselect
                      $(element).removeAttr('data-toggle').removeAttr('title').off('mouseenter mouseleave');
                    }

                    eye<?php echo $row[0];?>.addEventListener("click", function(){
                        if(eye<?php echo $row[0];?>.classList.toggle("reveal")){
                          eye<?php echo $row[0];?>.classList.remove("bx-hide");
                          eye<?php echo $row[0];?>.classList.add("bx-show");
                          eventCode<?php echo $row[0];?>.style.webkitTextSecurity = "none";
                        }
                        else{
                          eye<?php echo $row[0];?>.classList.remove("bx-show");
                          eye<?php echo $row[0];?>.classList.add("bx-hide");
                          eventCode<?php echo $row[0];?>.style.webkitTextSecurity = "disc";
                        }
                    });
                  </script>
                </div>
              </div>
            </div>
        <?php
                }
                else if ($row['event_type_id'] == '1'){
                  if ($row['overall_include'] == '0') {
                    echo '<style>';
                    echo '.element#e'.$row['event_id'].' .not-included {';
                    echo '    display: block;';
                    echo '}';
                    echo '</style>';
                  }
        ?>
        <div class="element" id="e<?php echo $row['event_id'];?>">
          <div class="not-included"></div>
              <div class="multi-select" id="multiSelect<?php echo $row['event_id'];?>">
                <input type="checkbox" name="deleteEvent[]" value="<?php echo $row['event_id'];?>">
              </div>
              <div class="row">
              <div class="element-group col-sm-6 col-lg-3">
                  <p class="element-label">Event Type</p>
                  <p class="element-content"><?php echo $row['event_type'];?></p>
                </div>
                <div class="element-group col-sm-6 col-lg-3">
                  <p class="element-label">Event</p>
                  <p class="element-content"><?php echo $row['event_name'];?></p>
                </div>
                <div class="element-group col-sm-6 col-lg-3">
                  <p class="element-label">Category</p>
                  <p class="element-content"><?php echo $row['category_name'];?></p>
                </div>
                <div class="element-group col-sm-6 col-lg-3">
                  <p class="element-label">Date & Time</p>
                  <p class="element-content"><?php 
                  $date_sql = "SELECT DATE_FORMAT('$row[event_date]', '%M %d, %Y') AS formattedDate FROM ongoing_list_of_event;";
                  $date_result = mysqli_query($conn, $date_sql);
                  $get_date_result = mysqli_fetch_assoc($date_result);
                  $date = $get_date_result['formattedDate'];

                  $time_sql = "SELECT TIME_FORMAT('$row[event_time]', '%h:%i %p') AS formattedTime FROM ongoing_list_of_event;";
                  $time_result = mysqli_query($conn, $time_sql);
                  $get_time_result = mysqli_fetch_assoc($time_result);
                  $time = $get_time_result['formattedTime'];
                  echo $date;?>; <?php echo $time;?></p>
                </div>
              </div>
              <div class="row">
                <div class="element-group col-sm-6 col-lg-6">
                  <p class="element-label">Event Desciption</p>
                  <p class="element-content"><?php echo $row['event_description'];?></p>
                </div>
                <div class="element-group col-sm-6 col-lg-2">
                  <p class="element-label">Match Type</p>
                  <p class="element-content">

                  <?php

                    $sql = "SELECT * 
                            FROM tournament AS t 
                            LEFT JOIN number_of_wins AS nows ON nows.number_of_wins_id = t.number_of_wins_id
                            WHERE t.event_id = $row[event_id]; ";
                    $query = mysqli_query($conn, $sql);
                    $result = mysqli_fetch_array($query);
                    $numberOfWins = $result['number_of_wins'];

                    echo $numberOfWins;
                  ?>

                  </p>
                </div>
                <div class="element-group col-sm-12 col-lg-4" id="eventBtn">
                  <button class="success-button justify-self-end event-done-btn<?php echo $row['event_id'];?>" id="eventDoneBtn<?php echo $row['event_id'];?>">Mark as Done</button>
                  <div class="button-container more-btn<?php echo $row[0];?>" id="more-btn">
                      <button class="primary-button justify-self-end" id="event-edit-btn<?php echo $row['event_id'];?>"><i class='bx bx-edit-alt'></i>Edit Event</button>
                  </div>

                  <script>

                    $(document).ready(function() {
                      $("#event-edit-btn<?php echo $row['event_id'];?>").click(function(event) {
                        event.preventDefault(); // Prevent default form submission
                      
                        window.location.href = "EVE-admin-edit-event.php?eec=<?php echo $row['event_id']?>";
                      });

                      $("#eventDoneBtn<?php echo $row['event_id'];?>").click(function(event) {
                        event.preventDefault(); // Prevent default form submission
                      });
                    });

                    //Enable Button on Date
                    var markAsDoneButton = document.querySelector('button.event-done-btn<?php echo $row['event_id'];?>');
                    var editEventButton = document.querySelector('button#event-edit-btn<?php echo $row['event_id'];?>');

                    var targetDateTime = new Date('<?php echo $row['event_date'] . ' ' . $row['event_time']; ?>');

                    var currentDateTime = new Date();

                    if (currentDateTime > targetDateTime) {
                      markAsDoneButton.disabled = false;
                    }
                    else {
                      markAsDoneButton.disabled = true;
                    }

                    const moreBtn<?php echo $row[0];?> = document.querySelector(".more-btn<?php echo $row[0];?>");
                    const doneBtn<?php echo $row[0];?> = document.querySelector(".event-done-btn<?php echo $row[0];?>");
                    const multiSelect<?php echo $row[0]?> = document.querySelector("#multiSelect<?php echo $row[0]?>");

                    if (typeof(Storage) !== "undefined") {
                        // If we need to open the bar
                        if(localStorage.getItem("editEvent") == "active"){
                          moreBtn<?php echo $row[0];?>.classList.add("editOpen");
                          doneBtn<?php echo $row[0];?>.classList.add("doneClose");
                          multiSelect<?php echo $row[0]?>.classList.add("deleteOpen");
                          document.querySelector("#edit-event-btn").classList.add("editOpen");
                        }
                        else if (localStorage.getItem("editEvent") == "notActive"){
                          moreBtn<?php echo $row[0];?>.classList.remove("editOpen");
                          doneBtn<?php echo $row[0];?>.classList.remove("doneClose"); 
                          multiSelect<?php echo $row[0]?>.classList.remove("deleteOpen");
                          document.querySelector("#edit-event-btn").classList.remove("editOpen");
                        }
                    }
                  </script>
                </div>
              </div>
            </div>
        

        <?php
                }
                else if ($row['event_type_id'] == 3) {
        ?>
        <div class="element">
              <div class="multi-select" id="multiSelect<?php echo $row['event_id'];?>">
                <input type="checkbox" name="deleteEvent[]" value="<?php echo $row['event_id'];?>">
              </div>
              <div class="row">
              <div class="element-group col-sm-6 col-lg-3">
                  <p class="element-label">Event Type</p>
                  <p class="element-content"><?php echo $row['event_type'];?></p>
                </div>
                <div class="element-group col-sm-6 col-lg-3">
                  <p class="element-label">Event</p>
                  <p class="element-content"><?php echo $row['event_name'];?></p>
                </div>
                <div class="element-group col-sm-6 col-lg-6">
                  <p class="element-label">Date & Time</p>
                  <p class="element-content"><?php 
                  $date_sql = "SELECT DATE_FORMAT('$row[event_date]', '%M %d, %Y') AS formattedDate FROM ongoing_list_of_event;";
                  $date_result = mysqli_query($conn, $date_sql);
                  $get_date_result = mysqli_fetch_assoc($date_result);
                  $date = $get_date_result['formattedDate'];

                  $time_sql = "SELECT TIME_FORMAT('$row[event_time]', '%h:%i %p') AS formattedTime FROM ongoing_list_of_event;";
                  $time_result = mysqli_query($conn, $time_sql);
                  $get_time_result = mysqli_fetch_assoc($time_result);
                  $time = $get_time_result['formattedTime'];
                  echo $date;?>; <?php echo $time;?></p>
                </div>
              </div>
              <div class="row">
                <div class="element-group col-sm-12 col-lg-8">
                  <p class="element-label">Event Desciption</p>
                  <p class="element-content"><?php echo $row['event_description'];?></p>
                </div>
                <div class="element-group col-sm-12 col-lg-4" id="eventBtn">
                  <button class="success-button justify-self-end event-done-btn<?php echo $row['event_id'];?>" id="eventDoneBtn<?php echo $row['event_id'];?>">Mark as Done</button>
                  <div class="button-container more-btn<?php echo $row[0];?>" id="more-btn">
                      <button class="primary-button justify-self-end" id="event-edit-btn<?php echo $row['event_id'];?>"><i class='bx bx-edit-alt'></i>Edit Event</button>
                  </div>

                  <script>
                    $(document).ready(function() {
                      $("#event-edit-btn<?php echo $row['event_id'];?>").click(function(event) {
                        event.preventDefault(); // Prevent default form submission
                      
                        window.location.href = "EVE-admin-edit-event.php?eec=<?php echo $row['event_id']?>";
                      });
                      $("#eventDoneBtn<?php echo $row['event_id'];?>").click(function(event) {
                        event.preventDefault(); // Prevent default form submission
                      });
                    });

                    //Enable Button on Date
                    var markAsDoneButton = document.querySelector('button.event-done-btn<?php echo $row['event_id'];?>');
                    var editEventButton = document.querySelector('button#event-edit-btn<?php echo $row['event_id'];?>');

                    var targetDateTime = new Date('<?php echo $row['event_date'] . ' ' . $row['event_time']; ?>');

                    var currentDateTime = new Date();

                    if (currentDateTime > targetDateTime) {
                      markAsDoneButton.disabled = false;
                    }
                    else {
                      markAsDoneButton.disabled = true;
                    }


                    const moreBtn<?php echo $row[0];?> = document.querySelector(".more-btn<?php echo $row[0];?>");
                    const doneBtn<?php echo $row[0];?> = document.querySelector(".event-done-btn<?php echo $row[0];?>");
                    const multiSelect<?php echo $row[0]?> = document.querySelector("#multiSelect<?php echo $row[0]?>");

                    if (typeof(Storage) !== "undefined") {
                        // If we need to open the bar
                        if(localStorage.getItem("editEvent") == "active"){
                          moreBtn<?php echo $row[0];?>.classList.add("editOpen");
                          doneBtn<?php echo $row[0];?>.classList.add("doneClose");
                          multiSelect<?php echo $row[0]?>.classList.add("deleteOpen");
                          document.querySelector("#edit-event-btn").classList.add("editOpen");
                        }
                        else if (localStorage.getItem("editEvent") == "notActive"){
                          moreBtn<?php echo $row[0];?>.classList.remove("editOpen");
                          doneBtn<?php echo $row[0];?>.classList.remove("doneClose"); 
                          multiSelect<?php echo $row[0]?>.classList.remove("deleteOpen");
                          document.querySelector("#edit-event-btn").classList.remove("editOpen");
                        }
                    }
                  </script>
                </div>
              </div>
            </div>        
        <?php
          }
          endwhile; 
        ?>
          <div class="deletepopup"></div>
          <script type="text/javascript" src="./js/EVE-admin-list-of-events.js"></script>
          <script>
            $(document).ready(function() {
              $('#delete-event-btn').on('click', function() {
                // Retrieve the storedArray value from localStorage
                var storedArray = JSON.parse(localStorage.getItem('selectedEvents'));

                // Check if any checkbox is selected
                var anyCheckboxSelected = storedArray && storedArray.length > 0;

                // Log the appropriate message based on the selection
                if (anyCheckboxSelected) {
                  $(".deletepopup").html(` 
                  <div class=\"popUpDisableBackground\" id=\"hasSelected\">
                    <div class=\"popUpContainer\">
                        <i class='bx bxs-trash danger-color'></i>
                        <div class=\"popUpHeader\">Are you sure you want to delete your selected event/s?</div>
                        <div class=\"popUpMessage\">This action cannot be undone. This action cannot be undone</div>
                        <div class=\"popUpButtonContainer\">
                          <div class=\"secondary-button cancel-delete\" id=\"hasSelected\"><i class='bx bx-x'></i>Cancel</div>
                          <button type=\"submit\" name=\"deb\" class=\"primary-button confirmPopUp\"><i class='bx bx-check'></i>Confirm</button>
                        </div>
                    </div>
                  `);

                  $('#hasSelected').click(function() {
                    $('.popUpDisableBackground#hasSelected').addClass('hide');
                    setTimeout(function() {
                        $('.popUpDisableBackground#hasSelected').css('visibility', 'hidden');
                        $('.popUpDisableBackground#hasSelected').removeClass('hide');
                    }, 300);
                    $('.popUpContainer').removeClass('show');
                });

                  $('.popUpDisableBackground#hasSelected').click(function() {
                      $('.popUpDisableBackground#hasSelected').addClass('hide');
                      setTimeout(function() {
                          $('.popUpDisableBackground#hasSelected').css('visibility', 'hidden');
                          $('.popUpDisableBackground#hasSelected').removeClass('hide');
                      }, 300);
                      $('.popUpContainer').removeClass('show');
                  });

                  $('.confirmPopUp').click(function() {
                    $('.popUpDisableBackground#$hasSelected').addClass('hide');
                      setTimeout(function() {
                          $('.popUpDisableBackground#hasSelected').css('visibility', 'hidden');
                          $('.popUpDisableBackground#hasSelected').removeClass('hide');
                      }, 300);
                      $('.popUpContainer').removeClass('show');
                      
                  });

                      $('.popUpDisableBackground#hasSelected').css('visibility', 'visible');
                      $('.popUpContainer').addClass('show');

                  // Handle the click event for the confirm button
                  $(document).on('click', '.confirmPopUp', function() {
                    // Make an AJAX request to handle the deletion
                    $.ajax({
                      type: 'POST',
                      url: './php/EVE-admin-edit-event.php', // Replace with the actual PHP file name or endpoint for deletion
                      data: { selectedEvents: storedArray },
                      success: function(response) {
                        localStorage.removeItem('selectedEvents');
                        window.location.href = previousURL;
                      }
                    });
                  });

                  // Handle the click event for the cancel button
                  $(document).on('click', '.cancel-delete', function() {
                    // Clear the localStorage and deselect checkboxes
                    localStorage.removeItem('selectedEvents');
                    $('input[name="deleteEvent[]"]').prop('checked', false);
                    var currentURL = window.location.href;
                    window.location.href = currentURL;
                  });
                } else {
                  $(".deletepopup").html(` 
                  <div class=\"popUpDisableBackground\" id=\"noSelected\">
                    <div class=\"popUpContainer\">
                        <i class='bx bxs-trash danger-color'></i>
                        <div class=\"popUpHeader\">No Selected Events</div>
                        <div class=\"popUpMessage\">Looks like you have no selected event/s. Make sure to select before pressing the delete button</div>
                        <div class=\"popUpButtonContainer\">
                        <div class=\"primary-button confirmPopUp\"><i class='bx bx-check'></i>Confirm</div>
                        </div>
                    </div>
                  `);

                  $('.popUpDisableBackground#noSelected').click(function() {
                      $('.popUpDisableBackground#noSelected').addClass('hide');
                      setTimeout(function() {
                          $('.popUpDisableBackground#noSelected').css('visibility', 'hidden');
                          $('.popUpDisableBackground#noSelected').removeClass('hide');
                      }, 300);
                      $('.popUpContainer').removeClass('show');
                  });

                  $('.confirmPopUp').click(function() {
                    $('.popUpDisableBackground#noSelected').addClass('hide');
                      setTimeout(function() {
                          $('.popUpDisableBackground#noSelected').css('visibility', 'hidden');
                          $('.popUpDisableBackground#noSelected').removeClass('hide');
                      }, 300);
                      $('.popUpContainer').removeClass('show');
                  });

                      $('.popUpDisableBackground#noSelected').css('visibility', 'visible');
                      $('.popUpContainer').addClass('show');
                }
              });
            });
          </script>
        <?php
          }
          else{
            ?>
              <div class="header">List of Events</div>
              <div class="text-center" id="no-event-container">
                <img class="p-2 img-fluid" id="noEvents" src="./pictures/add-events.svg" alt="No Events">
                <h1>No Events</h1>
                <p>Looks like you have no events created. <br> You can do so by clicking the button below.</p>
                <div class="row justify-content-center">
                  <button class="primary-button" id="create-new-event-btn">
                    <i class='bx bx-add-to-queue d-flex justify-content-center align-items-center'></i>
                      Create an Event
                  </button>
                </div>
              </div>
              
              <script>
                  $(document).ready(function() {
                    $("#create-new-event-btn").click(function(event) {
                      event.preventDefault(); // Prevent default form submission
                      
                      window.location.href = "EVE-admin-create-event.php";
                    });
                  });
              </script>
            <?php
          }
        ?>
      </div>
      </form> 
    </section>
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

      $()

      if (typeof(Storage) !== "undefined") {
          // If we need to open the bar
          if(localStorage.getItem("editEvent") == "active"){
            $('#create-event-btn').addClass("createNot");
            $('#delete-event-btn').addClass("deleteActive");
          }
          else if (localStorage.getItem("editEvent") == "notActive"){
            $('#create-event-btn').removeClass("createNot");
            $('#delete-event-btn').removeClass("deleteActive");
          }
      }      

      $(document).ready(function() {
        $("#create-event-btn").click(function(event) {
          event.preventDefault(); // Prevent default form submission
                      
          window.location.href = "EVE-admin-create-event.php";
        });
        $("#delete-event-btn").click(function(event) {
          event.preventDefault(); // Prevent default form submission
                    
        });
      });

    </script>

    <!-- Event Config Scripts -->
    <script type="text/javascript" src="./js/EVE-admin-bootstrap4.bundle.min.js"></script>
    <script type="text/javascript" src="./js/EVE-admin-bootstrap-select.min.js"></script>
    <script type="text/javascript" src="./js/EVE-admin-bootstrap-select-picker.js"></script>
    <script>
        $(document).ready(function() {
          $('#sortBtn').click(function() {
            $('#sortDropdown').slideToggle();
          });

          $(document).click(function(e) {
            if (!$(e.target).closest('#sortBtn, #sortDropdown').length) {
              $('#sortDropdown').hide();
            }
          });

          $('#filterBtn').click(function() {
            $('#filterDropdown').slideToggle();
          });

          $(document).click(function(e) {
            if (!$(e.target).closest('#filterBtn, #filterDropdown').length) {
              $('#filterDropdown').hide();
            }
          });

          $('input').keypress(function (e) {
            var txt = String.fromCharCode(e.which);
            if (!txt.match(/[A-Za-z0-9 ]/)) {
                return false;
            }
          });

          $('input').on('input', function(e) {
            $(this).val(function(i, v) {
              return v.replace(/[^\w\s]|_/gi, '');
            });
          });
        });
    </script>
  </body>

</html>