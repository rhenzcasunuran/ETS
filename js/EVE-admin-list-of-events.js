const addEvent = document.querySelector("#add-event-container");
const addEventBtn = document.querySelector("#add-event-btn");
const cancelEventBtn = document.querySelector("#cancel-btn");

const moreBtn = document.getElementsByClassName("more-btn");
const doneBtn = document.getElementsByClassName("event-done-btn");
const editEventBtn = document.querySelector("#edit-event-btn");

editEventBtn.addEventListener("click", function(){
    if(editEventBtn.classList.toggle("editOpen")){
        openEdit();
    }
    else{
        closeEdit();
    }
    location.reload();
});

function openEdit() {
    if (typeof(Storage) !== "undefined") {
        localStorage.setItem("editEvent", "active");
    }
}

function closeEdit() {
    if (typeof(Storage) !== "undefined") {
        localStorage.setItem("editEvent", "notActive");
    }
}