//validate input and disable buttons
const calendar = document.getElementById('calendar');
const tags = document.getElementById('tags');
const title = document.getElementById('title');
const description = document.getElementById('description');
const save_post = document.getElementById('save_post');

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
  const newCalendar = calendar.value !== oldCalendar;
  const newTags = tags.value !== oldTags;
  const newTitle = title.value !== oldTitle;
  const newDescription = description.value !== oldDescription;

  if (validCalendar && validTags && validTitle && validDescription && (newCalendar || newTags || newTitle || newDescription)) {
    save_post.classList.remove('disabled');
    save_post.setAttribute('onclick', 'show_savePost()');
  }
  else{
    save_post.classList.add('disabled');
    save_post.removeAttribute('onclick');
  }
}

calendar.addEventListener('input', checkFormValidity);
tags.addEventListener('change', checkFormValidity);
title.addEventListener('input', checkFormValidity);
description.addEventListener('input', checkFormValidity);

//read description line breaks
document.getElementById("description").addEventListener("change", processDescription);

function processDescription() {
  var textareaValue = document.getElementById("description").value;
  var lines = textareaValue.split("\n");
  
  for (var i = 0; i < lines.length; i++) {
    console.log("Line " + (i+1) + ": " + lines[i]);
  }
}

