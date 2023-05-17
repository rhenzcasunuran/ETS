const formInputEvent = document.querySelector("#inputEventName");
const formButtonEvent = document.querySelector("#eventSaveBtn");

// the default state is 'disabled'
formButtonEvent.disabled = true; 

// alternative is to use "change" - explained below
formInputEvent.addEventListener("keyup", eventButtonState);

function eventButtonState() {
    if (formInputEvent.value !== "" && formInputEvent.value.trim().length !== 0) {
        formButtonEvent.disabled = false; // enable the button once the input field has content
    } else {
        formButtonEvent.disabled = true; // return disabled as true whenever the input field is empty
    }
}

const formEvent = document.querySelector("#selectEventName");
const formType = document.querySelector("#selectEventType");
const formCategory = document.querySelector("#inputCategoryName");
const formButton = document.querySelector("#categorySaveBtn");

// the default state is 'disabled'
formButton.disabled = true; 

// alternative is to use "change" - explained below
formEvent.addEventListener("change", categoryButtonState);
formType.addEventListener("change", categoryButtonState);
formCategory.addEventListener("keyup", categoryButtonState);

function categoryButtonState() {
    if (formEvent.value !== "" && formType.value !== "" && formCategory.value !== "" && formCategory.value.trim().length !== 0) {
        formButton.disabled = false; // enable the button once the input field has content
    } else {
        formButton.disabled = true; // return disabled as true whenever the input field is empty
    }
}