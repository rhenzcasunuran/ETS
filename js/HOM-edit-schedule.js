//validate input and disable buttons
const calendar = document.getElementById('calendar');
const tags = document.getElementById('tags');
const title = document.getElementById('title');
const description = document.getElementById('description');
const save_schedule = document.getElementById('save_schedule');
const post = document.getElementById('post');

let oldCalendar = calendar.value;
let oldTags = tags.value;
let oldTitle = title.value;
let oldDescription = description.value;

document.addEventListener('DOMContentLoaded', function() {
  checkFormValidity();
});

function checkFormValidity() {
  const validCalendar = calendar.validity.valid;
  const validTags = tags.validity.valid;
  const validTitle = title.validity.valid && title.value.length >= 5;
  const validDescription = description.validity.valid && description.value.length >= 50;
  const newCalendar = calendar.value == oldCalendar;
  const newTags = tags.value == oldTags;
  const newTitle = title.value == oldTitle;
  const newDescription = description.value == oldDescription;

  if (validCalendar && validTags && validTitle && validDescription) {
    post.disabled = false;
  }
  else{
    post.disabled = true;
    postMenu.classList.remove('active');
  }

  if((newCalendar && newTags && newTitle && newDescription) && (validCalendar && validTags && validTitle && validDescription)){
    save_schedule.disabled = true;
  }
  else{
    save_schedule.disabled = false;
  }
}

calendar.addEventListener('input', checkFormValidity);
tags.addEventListener('change', checkFormValidity);
title.addEventListener('input', checkFormValidity);
description.addEventListener('input', checkFormValidity);

//toggle post button menu
const postMenu = document.querySelector('.post-menu');
const postMenuContent = document.querySelector('.post-menu-content');

postMenu.addEventListener('click', function() {
  if (!postMenu.classList.contains('disabled')) {
    postMenu.classList.toggle('active');
  }
});

document.addEventListener('click', function(e) {
  if (!postMenu.contains(e.target) && !postMenuContent.contains(e.target)) {
    postMenu.classList.remove('active');
  }
});

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