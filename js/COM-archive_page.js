//New popups
var gotopublishBtn = document.getElementById('gotopublishBtn');
var confirmBtn = document.getElementById('confirmBtn');
var deleteBtn = document.getElementById('deleteBtn');
// Republished Success
popupMarkAsDone = document.getElementById('markAsDoneWrapper');

var showMarkAsDone = function() {
    popupMarkAsDone.style.display ='flex';
}
var hideMarkAsDone = function() {
    popupMarkAsDone.style.display ='none';
}

// Deleted Success
popupMarkAsDeleted = document.getElementById('markAsDeletedWrapper');

var showMarkAsDeleted = function() {
    popupMarkAsDeleted.style.display ='flex';
}
var hideMarkAsDeleted = function() {
    popupMarkAsDeleted.style.display ='none';
}

// Republish?
popupCancel = document.getElementById('cancelWrapper');

var showCancel = function() {
    popupCancel.style.display ='flex';
}
var hideCancel = function() {
    popupCancel.style.display ='none';
}

// Delete?
popupDelete = document.getElementById('deleteWrapper');

var showDelete = function() {
    popupDelete.style.display = 'flex';
}
var hideDelete = function() {
    popupDelete.style.display = 'none';
}

// No selected result to delete
popupNoselect = document.getElementById('noselectWrapper');

var shownoselect = function() {
    popupNoselect.style.display = 'flex';
}
var hidenoselect = function() {
    popupNoselect.style.display = 'none';
}

const buttons = document.querySelectorAll('.republished_btn');
buttons.forEach((button) => {
  button.addEventListener("click", (e) => {
    var parentElement = button.parentElement;
    var id = parentElement.id;
    var competitionName = id;

    showCancel();
    confirmBtn.addEventListener("click", function(e){
        hideCancel();
        var post = document.getElementById(competitionName).parentElement;
        var remaining_posts = document.querySelectorAll('.result_container');
        console.log(remaining_posts);
            if (post != null){
                console.log("competitionName is "+competitionName);
                $.ajax({
                    type: "POST",
                    url: "./php/COM-republish.php",
                    data: { competitionName: competitionName },
                      success: function(response) {
                        post.remove();
                        showMarkAsDone();
                        remaining_posts = document.querySelectorAll('.result_container');
                      }
                    });
                    if (remaining_posts.length-1 <= 0){
                        var empty = document.getElementById('empty');
                        var searchbar = document.querySelector('.inputAndDeleteDiv');
                        var pagini = document.querySelector('.pagination');
                        empty.style.display = 'flex';
                        searchbar.style.display = 'none';
                        pagini.style.display = 'none';
                    }
            }
            
            if (remaining_posts.length <= 0){
                var empty = document.getElementById('empty');
                var searchbar = document.querySelector('.inputAndDeleteDiv');
                var pagini = document.querySelector('.pagination');
                empty.style.display = 'flex';
                searchbar.style.display = 'none';
                pagini.style.display = 'none';
            }
        e.stopPropagation();
    })
    gotopublishBtn.addEventListener("click", function(e) {
        hideMarkAsDone();
        window.location.href = "COM-tobepublished_page.php";
        e.stopPropagation();
    })
  });
});

var deleteAll = document.getElementById('deleteAll');
deleteAll.addEventListener("click", function() {
    //make an if statement that checks if there is atleast selected button, if not, then do nothing
    const selecteds = document.querySelectorAll('.selected');
    const remaining_posts = document.querySelectorAll('.result_container');
    if (selecteds.length >= 1) {
        showDelete();
        var deleted = document.getElementById('deleteBtn');
        //query all buttons that contains the class 'selected'
        deleted.addEventListener("click", function() {
            //delete all parent element of the buttons with the class 'selected'
            selecteds.forEach((selected) => {
                var competitionName = selected.parentElement.id;
                $.ajax({
                    type: "POST",
                    url: "./php/COM-delete.php",
                    data: { competitionName: competitionName },
                    success: function(response) {
                        post.remove();
                        showMarkAsDone();
                    }
                });
                var post = document.getElementById(competitionName).parentElement;
                post.remove();
            })
            showMarkAsDeleted();
            if (remaining_posts.length <= 0){
                var empty = document.getElementById('empty');
                empty.style.display = 'flex';
            }
        })
    } else {
        shownoselect();
    }
    
})

const selecteds = document.querySelectorAll('.selectBtn');
selecteds.forEach((selected) => {
    selected.addEventListener("click", (e) => {
        var parentElement = selected.parentElement;
        var id = parentElement.id;
        var competitionName = id;

        var element = selected;
    
        if (element.classList.contains('selected')) {
            element.classList.remove('selected');
        } else {
            element.classList.add('selected');
        }
    });
})