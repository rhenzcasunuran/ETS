<?php include './php/database_connect.php'; ?>

<!DOCTYPE html>
<html lang="en">

  <head>
  <?php include 'php/title.php' ?> 
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css" rel="stylesheet">


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
    <select class="form-control" name="event_name" id="event_name" data-name="Event Name">
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
          <input class="drop-zone__input" type="file" name="uploadfile[]" id="uploadfile"  multiple data-name="Image file">
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

// Number of items to display per page
$itemsPerPage = 4;

// Retrieve all filenames and highlight IDs from the database
$query = "SELECT highlight_id, filename FROM highlights ORDER BY highlight_id DESC";
$result = mysqli_query($conn, $query);
$allImages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $filenames = explode(',', $row['filename']);
    $id = $row['highlight_id'];

    foreach ($filenames as $filename) {
        if (!empty(trim($filename))) {
            $allImages[] = [
                'highlight_id' => $id,
                'filename' => trim($filename)
            ];
        }
    }
}
mysqli_free_result($result);

// Calculate the total number of items
$totalItems = count($allImages);

// Calculate the total number of pages
$totalPages = ceil($totalItems / $itemsPerPage);

// Get the current page number from the URL or set it to 1
$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Ensure the current page is within valid bounds
$currentPage = max(1, min($totalPages, $currentPage));

// Calculate the starting index for the current page
$startIndex = ($currentPage - 1) * $itemsPerPage;

// Get the chunk of images for the current page
$currentImages = array_slice($allImages, $startIndex, $itemsPerPage);

// Display images for the current page
foreach ($currentImages as $image) {
    $id = $image['highlight_id'];
    $filename = $image['filename'];

    $imagePath = './images/' . $filename;
    if (file_exists($imagePath)) {
        echo '<div class="image">';
        echo '<img src="' . $imagePath . '" onclick="expandImage(this)" class="gallery-image">';
        echo '<div class="delete"><a href="#" onclick="confirmDelete(' . $id . ', \'' . $filename . '\')"><i class="bx bxs-trash bx-xs bx-tada-hover bx-border-circle"></i></a></div>';
        echo '<div class="expanded-image" onclick="collapseImage(this)"><img src="' . $imagePath . '" class="expanded-image-inner"></div>';
        echo '</div>';
    }
}

// Display pagination links
echo '<div class="pagination">';

// Calculate the previous and next page numbers
$prevPage = max($currentPage - 1, 1);
$nextPage = min($currentPage + 1, $totalPages);

// Display "Previous" link if not on the first page
if ($currentPage > 1) {
    echo '<a href="?page=' . $prevPage . '" class="pagination-link">&lt;</a>';
}

// Display the page numbers (up to a maximum of 3)
for ($i = max(1, $currentPage - 1); $i <= min($totalPages, $currentPage + 1); $i++) {
    if ($i === $currentPage) {
        echo '<span class="pagination-link active">' . $i . '</span>';
    } else {
        echo '<a href="?page=' . $i . '" class="pagination-link">' . $i . '</a>';
    }
}

// Display "Next" link if not on the last page
if ($currentPage < $totalPages) {
    echo '<a href="?page=' . $nextPage . '" class="pagination-link">&gt;</a>';
}

echo '</div>';

mysqli_close($conn);
?>



  </div>


      </div>
      <div class="bg-white p-3" id="container-3">
        <div class="form-group">
          <input type="text" maxlength="150" name="image_Info" id="image_Info" placeholder="Input Title"data-name="Highlights Title"> 
        </div>
        <div class="form-group">
        <div class="textarea-wrapper">
  <textarea maxlength="3000" name="image_Description" id="image_Description" placeholder="Input Summary" data-name="Highlights Summary"></textarea>
  <span id="character-counter">3000 characters remaining</span>
</div>
</div>
      </div>

        
      <div class="container" id="button-container" style="display: flex; flex-direction: column; align-items: flex-end;">
      <div id="tooltip" class="tooltip-text"></div>
        <button type="submit" id="upload-btn" class="btn btn-primary">Upload</button>

  </div>
  
    </div>
    
  </div>
 
  <div class="popUpDisableBackground" id="customPopup">
    <div class="popUpContainer">
        <!-- Icon (e.g., success icon) -->
        <i class="bx bxs-check-circle success-color" id="successIcon"></i>
        <!-- Icon for Error (Exclamation) -->
        <i class="bx bxs-error-circle warning-color" id="errorIcon"></i>
        <!-- Icon for Question (Question Mark) -->
        <i class='bx bx-question-mark' id="questionIcon"></i>
        <!-- Pop-up Header and Message -->
        <div class="popUpHeader" id="popupHeader"></div>
        <div class="popUpMessage" id="popupMessage"></div>

        <!-- Pop-up Button Container -->
        <div class="popUpButtonContainer">
    <button class="secondary-button" id="cancelButton"><i class='bx bx-x'></i>Cancel</button>
    <button class="secondary-button" id="closeButton"><i class='bx bx-x'></i>Close</button>
    <button class="primary-button confirmPopUp" id="confirmButton"><i class='bx bx-check'></i>Confirm</button>
</div>

    </div>
</div>



    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.bundle.min.js"></script>
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
  // Function to open the custom pop-up
  function openCustomPopup(title, message, icon, showConfirmButton = true, callback) {
    const popup = document.getElementById("customPopup");
    const popupHeader = document.getElementById("popupHeader");
    const popupMessage = document.getElementById("popupMessage");
    const confirmButton = document.getElementById("confirmButton");

    popupHeader.textContent = title;
    popupMessage.textContent = message;

    if (showConfirmButton) {
      confirmButton.style.display = "block";
    } else {
      confirmButton.style.display = "none";
    }

    // Handle the callback when the Confirm button is clicked
    confirmButton.onclick = function () {
      closeCustomPopup();
      if (callback) {
        callback();
      }
    };

    popup.style.visibility = "visible";
    popup.classList.add("show");
  }

  // Function to close the custom pop-up
  function closeCustomPopup() {
    const popup = document.getElementById("customPopup");

    popup.classList.remove("show");
    setTimeout(function () {
      popup.style.visibility = "hidden";
    }, 100);
  }
  $(document).ready(function () {
  // Function to update the "Upload" button state and cursor style
  function updateUploadButtonState() {
    var event_name = $('#event_name').val();
    var uploadfile = $('#uploadfile').prop('files');
    var image_Info = $('#image_Info').val();
    var image_Description = $('#image_Description').val();

    // Check if any of the required fields are empty
    var isEmpty = event_name === '' || uploadfile.length === 0 || image_Info === '' || image_Description === '';

    // Disable or enable the "Upload" button based on the field state
    var uploadButton = $('#upload-btn');
    uploadButton.prop('disabled', isEmpty);

    // Update the cursor style based on the field state
    if (isEmpty) {
      uploadButton.addClass('disabled-button');
      uploadButton.css('cursor', 'not-allowed');

      // Get the names of the empty fields and display them in the tooltip
      var emptyFieldNames = [];
      $('[data-name]').each(function() {
        var fieldName = $(this).attr('data-name');
        if ($(this).val() === '') {
          emptyFieldNames.push(fieldName);
        }
      });
      var tooltipText = 'Please fill in the following required fields: ' + emptyFieldNames.join(', ');

      // Update the tooltip text and make it visible
      $('#tooltip').text(tooltipText).css('visibility', 'visible');
    } else {
      uploadButton.removeClass('disabled-button');
      uploadButton.css('cursor', 'pointer');

      // Hide the tooltip when the fields are not empty
      $('#tooltip').css('visibility', 'hidden');
    }
  }



    // Call the function initially to set the initial state of the "Upload" button
    updateUploadButtonState();
    

    // Add event listeners for input changes to update the button state
    $('#event_name, #uploadfile, #image_Info, #image_Description').on('input', updateUploadButtonState);

    // Create a new FormData object when the "Upload" button is clicked
    $('#upload-btn').click(function () {
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
        document.getElementById("errorIcon").style.display = "inline";
        document.getElementById("successIcon").style.display = "none";
        document.getElementById("questionIcon").style.display = "none";
        var errorMessage = 'Please fill in the following required fields: ' + requiredFields.join(', ');

        // Display the validation error message using the custom pop-up
        openCustomPopup('Validation Error', errorMessage, 'error');

        // Return to prevent further execution
        return;
      }

// If all fields are filled, proceed with the upload
var formData = new FormData($('form')[0]);
var confirmButton = document.getElementById("confirmButton");

document.getElementById("errorIcon").style.display = "none";
document.getElementById("successIcon").style.display = "none";
document.getElementById("questionIcon").style.display = "inline";
document.getElementById("closeButton").style.display = "none";
// Assuming that confirmButton is accessible in this scope, you can hide it like this:
document.getElementById("confirmButton").style.display = "none";

openCustomPopup('Are you sure?', 'Proceed with image upload?', 'question', true, function () {
  // Handle confirmation action here
  // Perform the AJAX form submission
  $.ajax({
    url: './php/HIS-upload.php',
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      document.getElementById("errorIcon").style.display = "none";
      document.getElementById("successIcon").style.display = "inline";
      document.getElementById("questionIcon").style.display = "none";
      document.getElementById("closeButton").style.display = "inline";
      
      // Hide the confirmButton
      document.getElementById("confirmButton").style.display = "none";
      
      cancelButton.style.display = "none";

      openCustomPopup(
  'Success!',
  'Image uploaded successfully',
  'success',
  false, // Do not show the "Confirm" button
  function () {
    // This function will be executed when the popup is displayed,
    // but no "Confirm" button will be shown.
    setTimeout(function () {
      closeCustomPopup();
      location.reload(); // Reload the page
    }, 1000); // Delay in milliseconds (2 seconds in this example)
  }
);

      // You can decide when to hide the success message based on your requirements
      // For example, you can add a delay before hiding it:
      setTimeout(function () {
        closeCustomPopup();
        location.reload(2000);
      }, 3000); // Delay in milliseconds (3 seconds in this example)
    },
    error: function (xhr, status, error) {
      // Handle the error response
      console.log(error);
      document.getElementById("errorIcon").style.display = "inline";
      document.getElementById("successIcon").style.display = "none";
      document.getElementById("questionIcon").style.display = "none";
      openCustomPopup('Error!', 'Image upload error', 'error');
    }
  });
});
});


    // Add event listener for the custom pop-up close button
    $('#closeButton').click(function () {
      closeCustomPopup();
    });

    document.getElementById("cancelButton").addEventListener("click", function () {
      closeCustomPopup();
    });
    
    document.getElementById("closeButton").addEventListener("click", function () {
      closeCustomPopup();
    });
  });
</script>






<script>
 function confirmDelete(id, filename) {
  document.getElementById("errorIcon").style.display = "none";
  document.getElementById("successIcon").style.display = "none";
  document.getElementById("questionIcon").style.display = "inline";
  document.getElementById("closeButton").style.display = "none";

  openCustomPopup(
    'Are you sure?',
    "You won't be able to revert this!",
    'question',
    true,
    function () {
      deleteImage(id, filename);
    }
  );

  // Handle the "Cancel" button click for this specific popup
  document.getElementById("cancelButton").addEventListener("click", function () {
    closeCustomPopup();
  });
}

function deleteImage(id, filename) {
  $.ajax({
    url: './php/HIS-delete.php',
    type: 'POST',
    data: { id: id, filename: filename },
    success: function (response) {
      if (response === 'success') {
        document.getElementById("errorIcon").style.display = "none";
        document.getElementById("successIcon").style.display = "inline";
        document.getElementById("questionIcon").style.display = "none"; 
        document.getElementById("cancelButton").style.display = "none";
        document.getElementById("closeButton").style.display = "inline";
        
        // Assuming that confirmButton is accessible in this scope, hide it
        document.getElementById("confirmButton").style.display = "none";

        // Remove or comment out the following line to prevent the success message from hiding immediately
        openCustomPopup(
          'Deleted!',
          'Your file has been deleted.',
          'success',
          false, // Do not show the "Confirm" button
          function () {
            // This function will be executed when the popup is displayed,
            // but no "Confirm" button will be shown.
            setTimeout(function () {
              closeCustomPopup();
              location.reload(2000);
            }, 3000); // Delay in milliseconds (3 seconds in this example)
          }
        );
        
        // You can decide when to hide the success message based on your requirements
        // For example, you can add a delay before hiding it:
        setTimeout(function () {
          closeCustomPopup();
          location.reload(2000);
        }, 3000); // Delay in milliseconds (3 seconds in this example)
      } else {
        document.getElementById("errorIcon").style.display = "inline";
        document.getElementById("successIcon").style.display = "none";
        document.getElementById("questionIcon").style.display = "none"; 
        openCustomPopup('Error!', 'Failed to delete the file.', 'error');
      }
    },
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
      document.getElementById("errorIcon").style.display = "inline";
            document.getElementById("successIcon").style.display = "none";
            document.getElementById("questionIcon").style.display = "none"; 
      openCustomPopup('Oops...', 'Maximum Character Limit Reach', 'error');
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
         document.getElementById("errorIcon").style.display = "inline";
            document.getElementById("successIcon").style.display = "none";
            document.getElementById("questionIcon").style.display = "none"; 
      openCustomPopup('Oops...', 'Maximum Character Limit Reach', 'error');
    }
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