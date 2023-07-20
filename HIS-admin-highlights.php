<?php include './php/database_connect.php'; ?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="Website Icon" type="png" href="./pictures/logo.png">
    <title>Event History | Highlights</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="./css/theme-mode.css">
    <script src="./js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <link rel="stylesheet" href="./css/system-wide.css">

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
     <?php
      // Set the active module and sub-active sub-item variables
      $activeModule = 'event-history';
      $activeSubItem = 'highlights-page';

      // Include the sidebar template
      require './php/admin-sidebar.php';
    ?>
    <!--Page Content-->
    <section class="home-section">
      
    <div class="header">Event Highlights</div>
  <div class="flex-container">
    <div class="container" id="main-containers">
      <div class="bg-white p-3" id="container-1">
        <form method="POST" action="" enctype="multipart/form-data">
  <div class="form-group">
    <select class="form-control" name="event_name" id="event_name" >
      <option value="" selected disabled>Select Event</option>
      <?php
include('./php/database_connect.php');

$query = "SELECT o.event_id, o.category_name, e.event_name
          FROM ongoing_list_of_event o
          JOIN ongoing_event_name e ON o.ongoing_event_name_id = e.ongoing_event_name_id
          WHERE o.is_archived = 1 AND o.is_deleted = 0";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $eventID = $row['event_id'];
    $categoryName = $row['category_name'];
    $eventName = $row['event_name'];

    echo '<option value="' . $eventID . '">' . $eventName . ' - ' . $categoryName . '</option>';
}

mysqli_close($conn);
?>

    </select>
  </div>
  <div class="form-group">
        <div class="drop-zone text-center">
          <label for="uploadfile" class="drop-zone__prompt">
            <i class='bx bxs-file-image bx-lg'></i> <br>
            Drag and drop images here or click to upload
          </label>
          <input class="drop-zone__input" type="file" name="uploadfile[]" id="uploadfile"  multiple />
          <div class="drop-zone__files" id="preview"></div>
        </div>
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
    $query = "SELECT * FROM highlights ORDER BY highlight_id DESC";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
      $filenames = explode(',', $row['filename']);
      $id = $row['highlight_id'];

      foreach ($filenames as $filename) {
        // Skip empty filenames
        if (empty(trim($filename))) {
          continue;
        }

        $imagePath = './images/' . trim($filename);
        if (!file_exists($imagePath)) {
          // Skip non-existent images
          continue;
        }

        echo '<div class="image">';
        echo '<img src="' . $imagePath . '" onclick="expandImage(this)" class="gallery-image">';
        echo '<div class="delete"><a href="#" onclick="confirmDelete(' . $id . ', \'' . trim($filename) . '\')"><i class="bx bxs-trash bx-xs bx-tada-hover bx-border-circle"></i></a></div>';
        echo '<div class="expanded-image" onclick="collapseImage(this)"><img src="' . $imagePath . '" class="expanded-image-inner"></div>';
        echo '</div>';
      }
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
  <textarea maxlength="3000" name="image_Description" id="image_Description" placeholder="Input Summary" ></textarea>
  <span id="character-counter">3000 characters remaining</span>
</div>
</div>
      </div>

        
      <div class="container" id="button-container" style="display: flex; justify-content: flex-end;">
        <button type="submit" id="upload-btn" class="btn btn-primary">Upload</button>
      
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
  $(document).ready(function() {
    $('form').submit(function(event) {
      event.preventDefault(); // Prevent the default form submission

    // Validate the form inputs
var event_name = $('#event_name').val();
var uploadfile = $('#uploadfile').prop('files');
var image_Info = $('#image_Info').val();
var image_Description = $('#image_Description').val();

// Check if any of the required fields are empty
if (event_name === '' || uploadfile.length === 0 || image_Info === '' || image_Description === '') {
  // Generate a list of required fields
  var requiredFields = [];
  if (event_name === '') {
    requiredFields.push('Event Name');
  }
  if (uploadfile.length === 0) {
    requiredFields.push('Insert Image');
  }
  if (image_Info === '') {
    requiredFields.push('Image Info');
  }
  if (image_Description === '') {
    requiredFields.push('Image Description');
  }

  // Create the validation error message with the list of required fields
  var errorMessage = 'Please fill in the following required fields: ' + requiredFields.join(', ');

  // Display the validation error message
  Swal.fire({
    icon: 'error',
    title: 'Validation Error',
    text: errorMessage,
  });

  return;
}


      // Create a new FormData object
      var formData = new FormData($(this)[0]);

      // Display confirmation dialog
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
          // Perform the AJAX form submission
          $.ajax({
            url: './php/HIS-upload.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
              // Handle the success response
              Swal.fire(
                'Success!',
                'Image uploaded successfully',
                'success'
              ).then(() => {
                location.reload();
              });
            },
            error: function(xhr, status, error) {
              // Handle the error response
              console.log(error);
              Swal.fire(
                'Error!',
                'Image upload error',
                'error'
              );
            }
          });
        }
      });
    });
  });
</script>




<script>
function confirmDelete(id, filename) {
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
        deleteImage(id, filename);
      }
    });
  }

  function deleteImage(id, filename) {
    $.ajax({
      url: "./php/HIS-delete.php",
      type: "POST",
      data: { id: id, filename: filename },
      success: function(response) {
        if (response === "success") {
          Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          ).then(() => {
            location.reload(); // Refresh the page
          });
        } else {
          Swal.fire(
            'Error!',
            'Failed to delete the file.',
            'error'
          );
        }
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

<script>
document.addEventListener("DOMContentLoaded", () => {
  const dropZone = document.querySelector(".drop-zone");
  const previewContainer = document.querySelector("#preview");
  const fileInput = document.querySelector("#uploadfile");

  dropZone.addEventListener("click", () => {
    fileInput.click();
  });

  fileInput.addEventListener("change", () => {
    previewContainer.innerHTML = "";
    const files = fileInput.files;
    if (files && files.length > 0) {
      Array.from(files).forEach(file => {
        const reader = new FileReader();

        reader.addEventListener("load", () => {
          const preview = document.createElement("div");
          preview.className = "drop-zone__thumb";
          preview.innerHTML = `<img src="${reader.result}" alt="${file.name}" />`;
          previewContainer.appendChild(preview);
        });

        reader.readAsDataURL(file);
      });
    }
  });

  dropZone.addEventListener("dragover", e => {
    e.preventDefault();
    dropZone.classList.add("drop-zone--over");
  });

  dropZone.addEventListener("dragleave", () => {
    dropZone.classList.remove("drop-zone--over");
  });

  dropZone.addEventListener("drop", e => {
    e.preventDefault();
    dropZone.classList.remove("drop-zone--over");
    const files = e.dataTransfer.files;
    fileInput.files = files;

    Array.from(files).forEach(file => {
      const reader = new FileReader();

      reader.addEventListener("load", () => {
        const preview = document.createElement("div");
        preview.className = "drop-zone__thumb";
        preview.innerHTML = `<img src="${reader.result}" alt="${file.name}" />`;
        previewContainer.appendChild(preview);
      });

      reader.readAsDataURL(file);
    });
  });
});
</script>



  </body>

</html>