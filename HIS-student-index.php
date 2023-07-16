<?php 
include('./php/database_connect.php');
include './php/admin-signin.php';
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event History</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="./css/theme-mode.css">
    <script src="./js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <link rel="stylesheet" href="./css/home-sidebar-style.css">
    <link rel="stylesheet" href="./css/system-wide.css">


    <!-- EVENT HISTORY -->
       <!-- CSS only -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">


<link rel="stylesheet" type="text/css" href="./css/HIS-student.css">
          </head>


  <body>
    <!--Sidebar-->
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
      $activeModule = 'event-history';

      // Include the sidebar template
      require './php/student-sidebar.php';
    ?>
    <!--Page Content-->
    <section class="home-section">
    <div class="header">
  Event History
  <input type="text" id="search" placeholder="Search" maxlength="30">
  <div class="dropdown">
  <i class="bx bx-filter-alt dropbtn bx-sm" onclick="myFunction()"></i>
  <style>



</style>

<div id="myDropdown" class="dropdown-content">
  <a href="#" onclick="filterByEventName('GIVE')">
    <img src="./photos/cover-GIVE.png" alt="GIVE" class="org-img">
  </a>
  <a href="#" onclick="filterByEventName('JMAP')">
    <img src="./photos/cover-JMAP.png" alt="JMAP" class="org-img">
  </a>
  <a href="#" onclick="filterByEventName('AECES')">
    <img src="./photos/cover-AECES.png" alt="AECES" class="org-img">
  </a>
  <a href="#" onclick="filterByEventName('JPIA')">
    <img src="./photos/cover-JPIA.png" alt="JPIA" class="org-img">
  </a>
  <a href="#" onclick="filterByEventName('PIIE')">
    <img src="./photos/cover-PIIE.png" alt="PIIE" class="org-img">
  </a>
  <a href="#" onclick="filterByEventName('JEHRA')">
    <img src="./photos/cover-JEHRA.png" alt="JEHRA" class="org-img">
  </a>
  <a href="#" onclick="filterByEventName('ACAP')">
    <img src="./photos/cover-ACAP.png" alt="ACAP" class="org-img">
  </a>
  <a href="#" onclick="filterByEventName('ELITE')">
    <img src="./photos/cover-ELITE.png" alt="ELITE" class="org-img">
  </a>
  <a href="#" onclick="filterByEventName('STUDENT COUNCIL')">
    <img src="./photos/cover-SC.png" alt="STUDENT COUNCIL" class="org-img">
  </a>
</div>



</div>

<div class="flex-container">
<div class="container" id="main-containers">
  <div class="container">
    
    <div class="col-md-12">
      <div class="row">
        <div id="carousel" class="col-md-12 text-white carousel-container">
          <?php
          require('./php/database_connect.php');

          $query = "SELECT * FROM highlights";
          $result = mysqli_query($conn, $query);

          $slides = '';
          $active = 'active';
          while ($row = mysqli_fetch_assoc($result)) {
            $imageFilenames = explode(',', $row['filename']);
            $imageInfo = $row['image_info'];
            $imageDesc = $row['image_description'];

            foreach ($imageFilenames as $filename) {
              $imagePath = "./images/" . trim($filename);
              $slides .= '<div class="carousel-item ' . $active . '" data-bs-info="' . $imageInfo . '" data-bs-desc="' . $imageDesc . '"><img src="' . $imagePath . '"></div>';
              $active = '';
            }
          }

          mysqli_data_seek($result, 0);
          $active = 'active';

          mysqli_close($conn);
          ?>

<div id="eventsImages" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <?php
    if (empty($slides)) {
      // Display default image
      echo '<div class="carousel-item active">';
      echo '<img src="./pictures/norwester.svg" alt="Default Image">';
      echo '</div>';
    } else {
      // Display images from the database
      echo $slides;
    }
    ?>
  </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#eventsImages" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#eventsImages" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  
        <div class="row" id="contain">
          <div class="col-md-12 text-white text-container">
            <!-- Additional content here -->
          </div>
        </div>
     



        <div class="row justify-content-center">
  <div class="col-md-12 left-container custom-left-container">
    <div class="container-fluid left-part">
      <div class="row">
        <div class="col-md-12 event">
          <div id="card-container">
          <?php
include('./php/database_connect.php');

            $searchQuery = $_GET['search'] ?? '';
            $query = "SELECT 
            en.event_name, 
            e.category_name, 
            YEAR(e.event_date) AS event_year, 
            e.suggested_status, 
            e.event_description,
            h.filename
          FROM 
            ongoing_list_of_event e
          JOIN 
            ongoing_event_name en ON e.event_name_id = en.event_name_id
          LEFT JOIN 
            highlights h ON e.event_id = h.event_id
          WHERE 
            e.is_archived = 1
          GROUP BY 
          e.event_id
          ORDER BY 
            e.suggested_status
            ;";

$result = mysqli_query($conn, $query);

if ($result === false) {
    die('Query Error: ' . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    $suggestedEvents = [];
    $otherEvents = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $eventName = $row['event_name'];
        $categoryName = $row['category_name'];
        $eventYear = $row['event_year'];
        $eventDescription = $row['event_description'];
        $suggestedStatus = $row['suggested_status'];
        $imageFilename = $row['filename'];

        // Check if the event is suggested
        if ($suggestedStatus == 1) {
            $suggestedEvents[] = [
                'eventName' => $eventName,
                'categoryName' => $categoryName,
                'eventYear' => $eventYear,
                'eventDescription' => $eventDescription,
                'imageFilename' => $imageFilename,
            ];
        } else {
            $otherEvents[] = [
                'eventName' => $eventName,
                'categoryName' => $categoryName,
                'eventYear' => $eventYear,
                'eventDescription' => $eventDescription,
                'imageFilename' => $imageFilename,
            ];
        }
    }

    echo '<div class="event-container">';
    echo '  <div class="suggested-events">';
    echo '    <h2 class="section-heading">Suggested Events</h2>';
    echo '    <div class="event-cards">';
    
    // Display suggested events
    foreach ($suggestedEvents as $index => $event) {
        $eventName = $event['eventName'];
        $categoryName = $event['categoryName'];
        $eventYear = $event['eventYear'];
        $eventDescription = $event['eventDescription'];
        $imageFilename = $event['imageFilename'];
    
        echo '<div class="event-card" id="event_' . $eventName . '" data-bs-desc="' . $eventDescription . '">';
    
        // Display event image if available
        if (!empty($imageFilename)) {
            $imageFilenamesArray = explode(',', $imageFilename);
            foreach ($imageFilenamesArray as $filename) {
                $imagePath = 'images/' . trim($filename);
                echo '<div class="modal-image">';
                echo '<img src="' . $imagePath . '" alt="Event Image" data-bs-toggle="modal" data-bs-target="#event-modal" data-bs-event="' . $eventName . '">';
                echo '</div>';
            }
        } else {
            // Display default image
            echo '<div class="modal-image">';
            echo '<img src="./pictures/norwester.svg" alt="Default Image" data-bs-toggle="modal" data-bs-target="#event-modal" data-bs-event="' . $eventName . '">';
            echo '</div>';
        }
    
        echo '<div class="event-info">';
        echo '<h3 class="event-name">' . $eventName . '</h3>';
        echo '<p class="category">' . $categoryName . '</p>';
        echo '<p class="year">' . $eventYear . '</p>';
        echo '</div>';
        echo '</div>';
    }
    
    // Check if there are no suggested events
    if (empty($suggestedEvents)) {
        // Display text message
        echo '<p class="no-events-message">No suggested events available</p>';
      }
    
    echo '    </div>'; // Close event-cards
    echo '  </div>'; // Close suggested-events
    echo '</div>'; // Close event-container
    

    //** OTHER EVENTS START ! */
  //** OTHER EVENTS START ! */
if (!empty($otherEvents)) {
  echo '<div class="other-events">';
  echo '<h2 class="section-heading">Other Events</h2>';
  echo '<div class="event-cards">';

  foreach ($otherEvents as $index => $event) {
    $eventName = $event['eventName'];
    $categoryName = $event['categoryName'];
    $eventYear = $event['eventYear'];
    $eventDescription = $event['eventDescription'];
    $imageFilename = $event['imageFilename'];

    echo '<div class="event-card" id="event_' . $eventName . '" data-bs-desc="' . $eventDescription . '">';

    if (!empty($imageFilename)) {
      $imageFilenamesArray = explode(',', $imageFilename);
      foreach ($imageFilenamesArray as $filename) {
        $imagePath = 'images/' . trim($filename);
        echo '<div class="modal-image">';
        echo '<img src="' . $imagePath . '" alt="Event Image" data-bs-toggle="modal" data-bs-target="#event-modal" data-bs-event="' . $eventName . '">';
        echo '</div>';
      }
    } else {
      // Display default image
      echo '<div class="modal-image">';
      echo '<img src="./pictures/norwester.svg" alt="Default Image" data-bs-toggle="modal" data-bs-target="#event-modal" data-bs-event="' . $eventName . '">';
      echo '</div>';
    }
    

    echo '<div class="event-info">';
    echo '<h3 class="event-name">' . $eventName . '</h3>';
    echo '<p class="category">' . $categoryName . '</p>';
    echo '<p class="year">' . $eventYear . '</p>';
    echo '</div>';
    echo '</div>';
  }

  echo '</div>';
  echo '</div>';

  // Display modal for event details
}

  


} else {
    echo "No events found.";
}

mysqli_close($conn);
?>

<!-- Bootstrap 5 Modal -->
<div class="modal fade" id="event-modal" tabindex="-1" aria-labelledby="event-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="event-modal-label">Event Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h3 id="modal-event-name"></h3>
        <p>Category: <span id="modal-category"></span></p>
        <p>Year: <span id="modal-year"></span></p>
        <p>Description: <span id="modal-description"></span></p>
        <div id="modal-event-images"></div>
      </div>
    </div>
  </div>
</div>


  </div>
</div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</div>
</div>
    </div>
  </div>
    </section>
  
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    <script src="./js/HOM-popup.js"></script>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>    
    <script>
   
 /* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
  }

  // Close the dropdown menu if the user clicks outside of it
  window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
    }
  }


</script>

<script>
document.getElementById('search').addEventListener('keyup', function () {
  var searchQuery = this.value.toLowerCase();
  var eventCards = document.getElementsByClassName('event-card');
  var suggestedEvents = document.querySelector('.suggested-events');
  var hasMatchingResults = false;

  for (var i = 0; i < eventCards.length; i++) {
    var eventName = eventCards[i].querySelector('.event-name').textContent.toLowerCase();
    var category = eventCards[i].querySelector('.category').textContent.toLowerCase();
    var year = eventCards[i].querySelector('.year').textContent.toLowerCase();
    var eventInfo = eventName + " " + category + " " + year;

    if (eventInfo.includes(searchQuery)) {
      eventCards[i].style.display = 'block'; // Show the event card
      if (eventCards[i].parentNode.parentNode === suggestedEvents) {
        hasMatchingResults = true; // At least one suggested event has matching results
      }
    } else {
      eventCards[i].style.display = 'none'; // Hide the event card
    }
  }

  // Check if the selected card is visible
  if (selectedCard && selectedCard.style.display === 'none') {
    selectedCard = null; // Reset selected card if it is hidden
  }

  // Update the text container for the selected card
  updateTextContainer();

  if (searchQuery !== '' && !hasMatchingResults) {
    suggestedEvents.style.display = 'none'; // Hide the suggested events container when there are no matching results
  } else {
    suggestedEvents.style.display = 'block'; // Show the suggested events container in all other cases
  }
});
var previousEvent = ""; // Variable to store the previous event name

function filterByEventName(eventName) {
  var eventCards = document.getElementsByClassName('event-card');
  var suggestedEvents = document.querySelector('.suggested-events');
  var hasMatchingResults = false;

  if (eventName === previousEvent) {
    window.location.reload(); // Reload the page to display all events without filter
  }

  for (var i = 0; i < eventCards.length; i++) {
    var currentEventCard = eventCards[i];
    var eventNameElement = currentEventCard.querySelector('.event-name');
    var eventNameText = eventNameElement.textContent.toLowerCase();

    if (eventNameText.includes(eventName.toLowerCase())) {
      currentEventCard.style.display = 'block'; // Show the event card
      if (currentEventCard.parentNode.parentNode === suggestedEvents) {
        hasMatchingResults = true; // At least one suggested event has matching results
      }
    } else {
      currentEventCard.style.display = 'none'; // Hide the event card
    }
  }

  previousEvent = eventName;



  // Check if the selected card is visible
  if (selectedCard && selectedCard.style.display === 'none') {
    selectedCard = null; // Reset selected card if it is hidden
  }

  updateTextContainer();

  if (!hasMatchingResults) {
    suggestedEvents.style.display = 'none'; // Hide the suggested events container when there are no matching results
  } else {
    suggestedEvents.style.display = 'block'; // Show the suggested events container in all other cases
  }
}

document.addEventListener('DOMContentLoaded', function() {
  var eventCards = document.querySelectorAll('.event-card');
  var modalEventName = document.getElementById('modal-event-name');
  var modalCategory = document.getElementById('modal-category');
  var modalYear = document.getElementById('modal-year');
  var modalDescription = document.getElementById('modal-description');
  var modalEventImages = document.getElementById('modal-event-images');
  var carouselInner = document.querySelector('#eventsImages .carousel-inner');
  var textContainer = document.querySelector('.text-container');
  var selectedCard = null;

  function updateTextContainer() {
    if (selectedCard) {
      var categoryName = selectedCard.querySelector('.category').innerText;
      var imageDesc = selectedCard.getAttribute('data-bs-desc');
      textContainer.innerHTML = '<h3>' + categoryName + '</h3><p>' + imageDesc + '</p>';
      textContainer.style.wordWrap = 'break-word'; // Allow words to break
      textContainer.style.maxWidth = '100%';
      textContainer.style.textAlign = 'justify'; // Justify the content in the paragraph
    }
  }

  function handleCardClick(card) {
    var eventName = card.getAttribute('data-bs-event');
    var eventDescription = card.getAttribute('data-bs-desc');
    var eventImages = card.querySelectorAll('img');

    modalEventName.textContent = eventName;
    modalCategory.textContent = card.querySelector('.category').textContent;
    modalYear.textContent = card.querySelector('.year').textContent;
    modalDescription.textContent = eventDescription;

    // Clear previous images
    modalEventImages.innerHTML = '';

    if (eventImages.length === 0) {
      var noImagesMessage = document.createElement('p');
      noImagesMessage.textContent = 'There are no images from this event.';
      modalEventImages.appendChild(noImagesMessage);
    } else {
      // Add event images to the modal
      eventImages.forEach(function(image) {
        var clonedImage = image.cloneNode(true);
        modalEventImages.appendChild(clonedImage);
      });
    }

    if (selectedCard === card) {
      // Card is already selected, refresh the page
      location.reload();
    } else {
      // Card is not selected, select it
      if (selectedCard) {
        // Unselect the previously selected card
        selectedCard.classList.remove('selected');
      }
      selectedCard = card;
      selectedCard.classList.add('selected');
      updateTextContainer();
    }

    carouselInner.innerHTML = '';

    // Get the image elements from the clicked event card
    var images = card.querySelectorAll('.modal-image img');

    // Add the images to the carousel inner
    images.forEach(function(image) {
      var carouselItem = document.createElement('div');
      carouselItem.classList.add('carousel-item');
      carouselItem.innerHTML = '<img src="' + image.src + '">';
      carouselInner.appendChild(carouselItem);
    });

    // Activate the first carousel item
    carouselInner.firstChild.classList.add('active');

    // Show the carousel
    var eventsImages = new bootstrap.Carousel(document.getElementById('eventsImages'));
    eventsImages.to(0); // Go to the first slide
  }

  eventCards.forEach(function(card) {
    card.addEventListener('click', function() {
      handleCardClick(card);
    });
  });

  var searchInput = document.getElementById('search');
  var suggestedEvents = document.querySelector('.suggested-events');

  searchInput.addEventListener('keyup', function() {
    var searchQuery = this.value.toLowerCase();
    var hasMatchingResults = false;

    eventCards.forEach(function(eventCard) {
      var eventName = eventCard.querySelector('.event-name').textContent.toLowerCase();
      var category = eventCard.querySelector('.category').textContent.toLowerCase();
      var year = eventCard.querySelector('.year').textContent.toLowerCase();
      var eventInfo = eventName + ' ' + category + ' ' + year;

      if (eventInfo.includes(searchQuery)) {
        eventCard.style.display = 'block'; // Show the event card
        if (eventCard.parentNode.parentNode === suggestedEvents) {
          hasMatchingResults = true; // At least one suggested event has matching results
        }
      } else {
        eventCard.style.display = 'none'; // Hide the event card
      }
    });

    // Check if the selected card is visible
    if (selectedCard && selectedCard.style.display === 'none') {
      selectedCard = null; // Reset selected card if it is hidden
    }

    updateTextContainer();

    if (searchQuery !== '' && !hasMatchingResults) {
      suggestedEvents.style.display = 'none'; // Hide the suggested events container when there are no matching results
    } else {
      suggestedEvents.style.display = 'block'; // Show the suggested events container in all other cases
    }
  });
});

</script>






  </body>

</html>