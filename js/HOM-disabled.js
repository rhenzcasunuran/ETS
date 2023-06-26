// Get the required input field and the submit button
const title = document.getElementById('title');
const description = document.getElementById('description');
const save_draft = document.getElementById('save_draft');
const post = document.getElementById('post');

// Function to check if the form is valid and update the submit button
function checkFormValidity() {
  if (tags.validity.valid && title.validity.valid && description.validity.valid) {
    save_draft.classList.remove('disabled');
    save_draft.setAttribute("onclick", "show_saveDraft()");
    post.classList.remove('disabled');
  } else {
    save_draft.classList.add('disabled');
    save_draft.removeAttribute("onclick");
    post.classList.add('disabled');
    postMenu.classList.remove('active');
  }
}

// Add event listeners to the input field and select dropdown
title.addEventListener('input', checkFormValidity);
description.addEventListener('input', checkFormValidity);