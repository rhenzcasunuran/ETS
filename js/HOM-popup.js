popup = document.getElementById('popup');
var show = function(){
    popup.style.display = 'flex';
    $('[data-bs-toggle="popover"]').popover('hide');
}
var hide = function(){
    popup.style.display = 'none';
    $('[data-bs-toggle="popover"]').popover('hide');
}

cancelPostPopup = document.getElementById('cancelPost-popup');
var show_cancelPost = function(){
    cancelPostPopup.style.display = 'flex';
}
var hide_cancelPost = function(){
    cancelPostPopup.style.display = 'none';
}

saveDraftPopup = document.getElementById('saveDraft-popup');
var show_saveDraft = function(){
    saveDraftPopup.style.display = 'flex';
}
var hide_saveDraft = function(){
    saveDraftPopup.style.display = 'none';
}

saveChangesPopup = document.getElementById('saveChanges-popup');
var show_saveChanges = function(){
    saveChangesPopup.style.display = 'flex';
}
var hide_saveChanges = function(){
    saveChangesPopup.style.display = 'none';
}

postNowPopup = document.getElementById('postNow-popup');
var show_postNow = function(){
    postNowPopup.style.display = 'flex';
}
var hide_postNow = function(){
    postNowPopup.style.display = 'none';
}

discardChangesPopup = document.getElementById('discardChanges-popup');
var show_discardChanges = function(){
    discardChangesPopup.style.display = 'flex';
}
var hide_discardChanges = function(){
    discardChangesPopup.style.display = 'none';
}

savePostPopup = document.getElementById('savePost-popup');
var show_savePost = function(){
    savePostPopup.style.display = 'flex';
}
var hide_savePost = function(){
    savePostPopup.style.display = 'none';
}