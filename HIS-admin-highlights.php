<?php include './php/database_connect.php'; ?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event History | Highlights</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="./css/theme-mode.css">
    <script src="./js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">

     <!-- Event History CSS -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

     <link rel="stylesheet" href="./css/HIS-highlights-v1.css">


<!--
  Event History Configurations
---->
<form method="GET" action="?search=<?php echo $search_term; ?>">
  </head>

  <body>
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
        <div class="sidebar-content-container">
          <ul class="nav-list">
            <li class="nav-item">
              <a href="#posts" class="menu_btn">
                <i class="bx bx-news"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Posts
                  <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
              </a>
              <ul class="sub_list">
                <li class="sub-item">
                  <a href="HOM-create-post.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Create Post</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="HOM-draft-scheduled-post.php">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Draft & Scheduled Post</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="HOM-manage-post.php">
                    <i class="bx bxs-circle sub-icon color-yellow"></i>
                    <span class="sub_link_name">Manage Post</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#event_menu" class="menu_btn">
                <i class="bx bx-calendar-edit"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Events
                  <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
              </a>
              <ul class="sub_list">
                <li class="sub-item">
                  <a href="EVE-admin-list-of-events.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">List of Events</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="EVE-admin-event-configuration.php">
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
                  <a href="CAL-admin-overall.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Overview</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="CAL-admin-logs.php">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Logs</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="BAR-admin.php">
                <i class='bx bx-bar-chart-alt-2'></i>
                <span class="link_name">Overall Results</span>
              </a>
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
                  <a href="TOU-Live-Scoring-Admin.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Live Scoring</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="TOU-bracket-admin.php">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Manage Brackets</span>
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
                  <a href="COM-manage_results_page.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Manage Results</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="COM-tobepublished_page.php">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">To Publish</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="COM-published_page.php">
                    <i class="bx bxs-circle sub-icon color-yellow"></i>
                    <span class="sub_link_name">Published Results</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="#archive">
                    <i class="bx bxs-circle sub-icon color-purple"></i>
                    <span class="sub_link_name">Archive</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#event_history" class="menu_btn active">
                <i class="bx bx-history"><i class="dropdown_icon bx bx-chevron-down"></i></i>
                <span class="link_name">Event History
                  <i class="change-icon dropdown_icon bx bx-chevron-right"></i>
                </span>
              </a>
              <ul class="sub_list">
                <li class="sub-item">
                  <a href="HIS-admin-ManageEvent.php">
                    <i class="bx bxs-circle sub-icon color-red"></i>
                    <span class="sub_link_name">Event Page</span>
                  </a>
                </li>
                <li class="sub-item">
                  <a href="HIS-admin-highlights.php"  class="sub-active">
                    <i class="bx bxs-circle sub-icon color-green"></i>
                    <span class="sub_link_name">Highlights Page</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="P&J-admin-formPJ.php">
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
    <div class="header">Event Highlights</div>
  <div class="flex-container">
    <div class="container" id="main-containers">
      <div class="bg-white p-3" id="container-1">
        <div class="file-type-container">Image Selection</div>
        <form method="POST" action="" enctype="multipart/form-data">
          <div class="form-group">
            <input class="form-control" type="file" name="uploadfile" id="uploadfile" value="" required />
          </div>
        </form>
      </div>
      <div class="bg-white p-3" id="container-2">
        <div class="file-type-container">
          Gallery
        </div>
        <div class="container" id="img-container">
          <?php
            require('./php/database_connect.php');
            $query = "SELECT * FROM image ORDER BY id DESC";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
              $image = $row['filename'];
              $id = $row['id'];
              echo "<div class='image'>";
              echo "<img src='./images/$image' onclick='expandImage(this)'>";
              echo "<div class='delete'><a href='#' onclick='confirmDelete($id)'><i class='bx bxs-trash bx-xs bx-tada-hover bx-border-circle '></i></a></div>";
              echo "<div class='expanded-image' onclick='collapseImage(this)'><img src='./images/$image'></div>";
              echo "</div>";
            }
            mysqli_free_result($result);
            mysqli_close($conn);
          ?>
        </div>
      </div>
      <div class="bg-white p-3" id="container-3">
        <div class="form-group">
          <input type="text" maxlength="150" name="image_Info" id="image_Info" placeholder="Input Title" >
        </div>
        <div class="form-group">
        <div class="textarea-wrapper">
  <textarea maxlength="3000" name="image_Description" id="image_Description" placeholder="Input Summary"></textarea>
  <span id="character-counter">3000 characters remaining</span>
</div>


        </div>
        
        <div class="container" id="button-container">
        <button type="submit" id="upload-btn">Upload</button>
      </div>
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
<!--
Event History Scripts
-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
  $(document).ready(function() {
    $('#upload-btn').click(function() {
      var file_data = $('#uploadfile').prop('files')[0];
      var allowedTypes = ['image/jpeg', 'image/png', 'image/heic']; // Include 'image/heic' for iOS images
      var form_data = new FormData();
      
      if ($('#image_Info').val() == "" || $('#image_Description').val() == "" || $('#image_Info').val() == "" || !file_data) {
  var requiredFields = [];
  if (!file_data) {
    requiredFields.push("Image");
  }
  
  if ($('#image_Info').val() == "") {
    requiredFields.push("Title");
  }
  
  if ($('#image_Description').val() == "") {
    requiredFields.push("Description");
  }
  
 
  
  var errorMessage = 'Please fill in the following required fields: ' + requiredFields.join(', ');
  
  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: errorMessage,
  });
  
  return false;
}

      
      if (allowedTypes.indexOf(file_data.type) == -1) {
        Swal.fire({
          icon: 'error',
          title: 'Upload Failed',
          text: 'File must be an image (JPG, JPEG, PNG, HEIC)!',
        });
        return false;
      }
    
      
      form_data.append('file', file_data);
      form_data.append('image_Info', $('#image_Info').val());
      form_data.append('image_Description', $('#image_Description').val());

      Swal.fire({
        title: 'Are you sure?',
        text: 'Proceed with image upload?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, upload it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: './php/HIS-upload.php',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(response) {
              Swal.fire(
                'Success!',
                'Image uploaded successfully',
                'success'
              ).then(() => {
                location.reload();
              });
            },
            error: function(response) {
              console.log(response); // Check the error response in the browser console
              Swal.fire(
                'Error!',
                'Image upload error',
                'error'
              );
            }
          });
        }
      });

      return false;
    });
  });
</script>



<script>
function confirmDelete(id) {
  Swal.fire({
    title: 'Are you sure you want to delete this image?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      deleteImage(id);
    }
  });
}

function deleteImage(id) {
  $.ajax({
    url: "./php/HIS-delete.php",
    type: "POST",
    data: { id: id },
    success: function(response) {
      Swal.fire(
        'Deleted!',
        'Your file has been deleted.',
        'success'
      ).then(() => {
        location.reload(); // Refresh the page
      });
    }
  });
}

</script>

<script>
  const textarea = document.getElementById('image_Description');
  
  textarea.addEventListener('input', () => {
    if (textarea.value.length < textarea.maxLength) {
      textarea.style.borderColor = 'darkblue';
      textarea.style.borderWidth = '2px'; // set border size to 1px
    } else {
      textarea.style.borderColor = 'red';
      textarea.style.borderWidth = '2px'; // set border size to 3px
      Swal.fire({
      icon: 'warning',
      title: 'Oops...',
      text: 'Maximum Character Limit Reach',
})
    }
  });
</script>
<script>
  const input = document.getElementById('image_Info');
  
  input.addEventListener('input', () => {
    if (input.value.length < input.maxLength) {
      input.style.borderColor = 'darkblue';
      input.style.borderWidth = '2px'; // set border size to 1px
    } else {
      input.style.borderColor = 'red';
      input.style.borderWidth = '2px'; // set border size to 3px
      Swal.fire({
      icon: 'warning',
      title: 'Oops...',
      text: 'Maximum Character Limit Reach',
})    }
  });
</script>
<script>
  function expandImage(img) {
    img.parentNode.querySelector(".expanded-image").style.display = "block";
  }

  function collapseImage(expandedImg) {
    expandedImg.style.display = "none";
  }
</script>
<script>
  var fileInput = document.getElementById('uploadfile');

  fileInput.addEventListener('click', function() {
    fileInput.accept = '.jpg, .jpeg, .png';
  });
  // Get the textarea element

// Get the counter element
var counter = document.getElementById('character-counter');

// Set the maximum character limit
var maxLength = 3000;

// Add an input event listener to the textarea
textarea.addEventListener('input', function() {
  // Calculate the remaining characters
  var remaining = maxLength - textarea.value.length;
  
  // Update the counter text
  counter.textContent = remaining + ' characters remaining';
});

</script>



  </body>

</html>