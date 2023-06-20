<?php 
include './php/database_connect.php';

include './php/admin-signin.php';
    $activeModule = 'results';
    $activeSubItem = 'overall-champion';

    require './php/student-sidebar.php';
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
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <link rel="stylesheet" href="./css/home-sidebar-style.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/BAR-obg.css">
    <link rel="stylesheet" href="./css/system-wide.css">
    <script src="./js/BAR-java.js"></script>
  </head>


  <body>
    <!--Page Content-->
    <section class="home-section" style="display: flex; justify-content: center; align-items: center;">
      <div class="container-fluid" id="body-content">

        <div class="col" id="graph-section">
          <div class="graph_container">
            <div class="row" id="arrow-container">
              <div class="arrow">
                <i class="bx bx-arrow-to-left" id="arrow-btn"></i>
              </div>
            </div>
            <div class="row">

              <div class="col" id="rank_container">
                <?php
                  $obg = "SELECT organization, barMeter, isAnon FROM bar_graph ORDER BY barMeter DESC";
                  $result = $conn->query($obg);
                  
                  if ($result->num_rows > 0) {
                    $organizations = array();
                    while ($row = $result->fetch_assoc()) {
                        $organizations[] = $row;
                    }
                
                    foreach ($organizations as $org) {
                        $organization = $org["organization"];
                        $imagePath = "logos/" . $organization . ".png";
                
                        echo '<div class="row" id="logos">
                          <div class="logo_container"><img src="' . $imagePath . '"></div>
                        </div>';
                    }
                } else {
                    echo "No organizations found in the database.";
                }

                ?>
              </div>

              <div class="col-11">
                <?php
                $obg = "SELECT organization, barMeter, isAnon FROM bar_graph ORDER BY barMeter DESC";
                $result = $conn->query($obg);

                if ($result->num_rows > 0) {
                  $organizations = array();
                  while ($row = $result->fetch_assoc()) {
                      $organizations[] = $row;
                  }
              
                  foreach ($organizations as $org) {
                    $organization = $org["organization"];
                    $barMeter = $org["barMeter"];
              
                      echo '<div class="row">
                  <div class="meter_container">
                    <div class="meter" id="'. $organization .'" style="width: ' . $barMeter . '%;"></div>
                  </div>
                </div>';
                  }
              } else {
                  echo "No organizations found in the database.";
              }
                ?>
              </div>

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
                <div class="col-4" id="winnings-container">
                  <div class="winnings">
                    
                  </div>
                </div>
                <div class="col" id="org-photo-container">
                  <div class="org-photo">
                    <img src="" alt="" class="org-photo-image">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

</script>

    </section>
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
    var firstSlide = document.querySelector('#eventsImages .carousel-item:first-child');
    var imageInfo = firstSlide.getAttribute('data-bs-info');
    var imageDesc = firstSlide.getAttribute('data-bs-desc');


    var textContainer = document.querySelector('.text-container');
    textContainer.innerHTML = '<h3>' + imageInfo + '</h3><p>' + imageDesc + '</p>';

    var carousel = document.querySelector('#eventsImages');
    carousel.addEventListener('slide.bs.carousel', function(event) {
      var currentSlide = event.relatedTarget;
      var imageInfo = currentSlide.getAttribute('data-bs-info');
      var imageDesc = currentSlide.getAttribute('data-bs-desc');

      var textContainer = document.querySelector('.text-container');
      textContainer.innerHTML = '<h3>' + imageInfo + '</h3><p>' + imageDesc + '</p>';
      textContainer.style.wordWrap = 'break-word'; // Allow words to break
      textContainer.style.maxWidth = '100%'; 
      textContainer.style.textAlign = 'justify'; // Justify the content in the paragraph

    });
</script>

  </body>

</html>