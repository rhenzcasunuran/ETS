const formInputEvent = document.querySelector("#inputEventName");
const formButtonEvent = document.querySelector("#eventSaveBtn");

const textEvent1 = document.querySelector("#textEventName");
const checkEvent1 = document.querySelector("#checkEventName");

var tooltip1 = document.querySelector('#tooltipEvent');

// the default state is 'disabled'
formButtonEvent.disabled = true; 

// alternative is to use "change" - explained below
formInputEvent.addEventListener("keyup", eventButtonState);

function eventButtonState() {
    const inputEventValue = formInputEvent.value.trim().replace(/\s\s+/g, ""); // Remove multiple consecutive spaces
    if (formInputEvent.value !== "" && inputEventValue.length >= 5) {
        formButtonEvent.disabled = false; // enable the button once the input field has content
        tooltip1.style.display = 'none';
    } else {
        tooltip1.style.display = 'flex';
        formButtonEvent.disabled = true; // return disabled as true whenever the input field is empty
        //Event
        if(inputEventValue.length < 5) {
            checkEvent1.style.visibility = "hidden";
            textEvent1.style.color = "var(--not-active-text-color)";
        }
        else{
            checkEvent1.style.visibility = "visible";
            textEvent1.style.color = "var(--default-success-color)";
        }
    }
}

const formEvent = document.querySelector("#selectEventName");
const formType = document.querySelector("#selectEventType");
const formCategory = document.querySelector("#inputCategoryName");
const formButton = document.querySelector("#categorySaveBtn");

const selectEvent = document.querySelector("#selectEvent");
const selectType = document.querySelector("#selectType");
const textCategory = document.querySelector("#textCategory");

const selectCheckEvent = document.querySelector("#checkSelectEvent");
const selectCheckType = document.querySelector("#checkSelectType");
const checkCategory = document.querySelector("#checkCategory");

var tooltip2 = document.querySelector('#tooltipCategory');

// the default state is 'disabled'
formButton.disabled = true; 

// alternative is to use "change" - explained below
formEvent.addEventListener("change", categoryButtonState);
formType.addEventListener("change", categoryButtonState);
formCategory.addEventListener("keyup", categoryButtonState);

function categoryButtonState() {
    const categoryValue = formCategory.value.trim().replace(/\s\s+/g, ""); // Remove multiple consecutive spaces
    if (formEvent.value !== "" && formType.value !== "" && formCategory.value !== "" && categoryValue.length >= 5) {
        formButton.disabled = false; // enable the button once the input field has content
        tooltip2.style.display = 'none';
    } else {
        tooltip2.style.display = 'flex';
        formButton.disabled = true; // return disabled as true whenever the input field is empty
        //Event
        if(formEvent.value === "") {
            selectCheckEvent.style.visibility = "hidden";
            selectEvent.style.color = "var(--not-active-text-color)";
        }
        else{
            selectCheckEvent.style.visibility = "visible";
            selectEvent.style.color = "var(--default-success-color)";
        }
        //Type
        if(formType.value === "") {
            selectCheckType.style.visibility = "hidden";
            selectType.style.color = "var(--not-active-text-color)";
        }
        else{
            selectCheckType.style.visibility = "visible";
            selectType.style.color = "var(--default-success-color)";
        }
        //Category
        if(categoryValue.length < 5) {
            checkCategory.style.visibility = "hidden";
            textCategory.style.color = "var(--not-active-text-color)";
        }
        else{
            checkCategory.style.visibility = "visible";
            textCategory.style.color = "var(--default-success-color)";
        }
    }
}