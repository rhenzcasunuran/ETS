//validate calendar
$(document).ready(function(){
  var todaysDate = new Date();
  
  var year = todaysDate.getFullYear();		
  var maxYear = year+1;
  var month = ("0" + (todaysDate.getMonth() + 1)).slice(-2); 
  var day = ("0" + todaysDate.getDate()).slice(-2);

  var dtToday = (year + "-" + month + "-" + day);
  var dtMax = (maxYear + "-" + month + "-" + day);
  
  $("#calendar").attr('max', dtMax);
  $("#calendar").attr('min', dtToday);
});

//read description line breaks
document.getElementById("description").addEventListener("change", processDescription);

function processDescription() {
  var textareaValue = document.getElementById("description").value;
  var lines = textareaValue.split("\n");
  
  for (var i = 0; i < lines.length; i++) {
    console.log("Line " + (i+1) + ": " + lines[i]);
  }
}

//clear form
document.getElementById("clear").addEventListener("click", clearInput);

function clearInput(){
  var form = document.getElementById("post-form");
  var calendar = document.getElementById("calendar");
  var tag = document.getElementById("tag");
  var title = document.getElementById("title");
  var description = document.getElementById("description");

  tag.removeAttribute("required");
  title.removeAttribute("required");
  description.removeAttribute("required");

  form.reset();

  tag.setAttribute("required", "required");
  title.setAttribute("required", "required");
  description.setAttribute("required", "required");
}

