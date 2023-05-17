const formEvent = document.querySelector("#select-event-name");
const formType = document.querySelector("#select-event-type");
const formCategory = document.querySelector("#select-category-name");
const formDesc = document.querySelector("#event-description");
const formDate = document.querySelector("#date");
const formTime = document.querySelector("#time");
const formButton = document.querySelector("#save-btn");

// the default state is 'disabled'
formButton.disabled = true; 

// alternative is to use "change" - explained below
formEvent.addEventListener("change", buttonState);
formType.addEventListener("change", buttonState);
formCategory.addEventListener("change", buttonState);
formDesc.addEventListener("keyup", buttonState);
formDate.addEventListener("keyup", buttonState);
formDate.addEventListener("change", buttonState);
formTime.addEventListener("keyup", buttonState);
formTime.addEventListener("change", buttonState);

function buttonState() {
    if (formDesc.value !== "" && formDesc.value.trim().length !== 0 && formDate.value !== "" && formTime.value !== "" && formEvent.value !== "" && formType.value !== "" && formCategory.value !== "") {
        formButton.disabled = false; // enable the button once the input field has content
    } else {
        formButton.disabled = true; // return disabled as true whenever the input field is empty
    }
}