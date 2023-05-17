const addEvent = document.querySelector("#add-event-container");
const addEventBtn = document.querySelector("#add-event-btn");
const cancelEventBtn = document.querySelector("#cancel-btn");

const moreBtn = document.getElementsByClassName("more-btn");
const doneBtn = document.getElementsByClassName("event-done-btn");
const editEventBtn = document.querySelector("#edit-event-btn");

const editEventBtnPressed = () => {
    for(const more of moreBtn){
        more.classList.toggle("editOpen")
    }
    for(const done of doneBtn){
       done.classList.toggle("doneClose")
    }
}

editEventBtn.addEventListener("click", editEventBtnPressed);

    addEventBtn.addEventListener("click",function(){      
        addEvent.classList.add("addEventOpen");
    })

    cancelEventBtn.addEventListener("click",function(){      
        addEvent.classList.remove("addEventOpen");
    })

