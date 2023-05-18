//get calendar
var existingCalendar = "<?php echo $post_row[1];?>";

var dateInput = document.getElementById("calendar");

dateInput.value = existingCalendar;

//get tag
var selectedTag = "<?php echo $post_row[2];?>";

var selectElement = document.getElementById("tag");

for (var i = 0; i < selectElement.options.length; i++) {
  if (selectElement.options[i].value === selectedTag) {
    selectElement.options[i].selected = true;
    break;
  }
}