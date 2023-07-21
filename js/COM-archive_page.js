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

// Search function to filter draggableDivs
function searchDrags(searchText) {
    resultContainers.forEach(div => {
      const content = div.innerText.toLowerCase();
      if (content.includes(searchText.toLowerCase())) {
        div.style.display = 'block';
      } else {
        div.style.display = 'none';
      }
    });
}
  
function handleSearchInput() {
    const searchInput = document.getElementById('searchInput').value;
    searchDrags(searchInput);
}
  
document.getElementById('searchInput').addEventListener('input', handleSearchInput);