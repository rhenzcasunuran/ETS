const formEvent = document.querySelector("#select-event-name");
const formType = document.querySelector("#select-event-type");
const formCategory = document.querySelector("#select-category-name");
const formDesc = document.querySelector("#event-description");
const formDate = document.querySelector("#date");
const formTime = document.querySelector("#time");
const formButton = document.querySelector("#save-btn");

const textEvent = document.querySelector("#textEvent");
const textType = document.querySelector("#textType");
const textCategory = document.querySelector("#textCategory");
const textDesc = document.querySelector("#textDescription");
const textDate = document.querySelector("#textDate");
const textTime = document.querySelector("#textTime");

const checkEvent = document.querySelector("#checkEvent");
const checkType = document.querySelector("#checkType");
const checkCategory = document.querySelector("#checkCategory");
const checkDesc = document.querySelector("#checkDescription");
const checkDate = document.querySelector("#checkDate");
const checkTime = document.querySelector("#checkTime");

var tooltip = document.querySelector('#tooltip');

// the default state is 'disabled'
formButton.disabled = false; 
tooltip.style.display = 'none';
textEvent.style.color = "var(--default-success-color)";
textType.style.color = "var(--default-success-color)";
textCategory.style.color = "var(--default-danger-color)";
textDesc.style.color = "var(--default-success-color)";
textDate.style.color = "var(--default-success-color)";

textTime.style.color = "var(--default-success-color)";
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
    const descValue = formDesc.value.trim().replace(/\s\s+/g, ""); // Remove multiple consecutive spaces
    if (formDesc.value !== "" && descValue.length >= 5 && formDate.value !== "" && formTime.value !== "" && formEvent.value !== "" && formType.value !== "" && formCategory.value !== "") {
        formButton.disabled = false; // enable the button once the input field has content
        tooltip.style.display = 'none';
    } else {
        tooltip.style.display = 'flex';
        formButton.disabled = true; // return disabled as true whenever the input field is empty
        //Event
        if(formEvent.value === "") {
            checkEvent.style.visibility = "hidden";
            textEvent.style.color = "var(--not-active-text-color)";
        }
        else{
            checkEvent.style.visibility = "visible";
            textEvent.style.color = "var(--default-success-color)";
        }
        //Type
        if(formType.value === "") {
            checkType.style.visibility = "hidden";
            textType.style.color = "var(--not-active-text-color)";
        }
        else{
            checkType.style.visibility = "visible";
            textType.style.color = "var(--default-success-color)";
        }
        //Category
        if(formCategory.value === "") {
            checkCategory.style.visibility = "hidden";
            textCategory.style.color = "var(--not-active-text-color)";
        }
        else{
            checkCategory.style.visibility = "visible";
            textCategory.style.color = "var(--default-success-color)";
        }
        //Description
        if (descValue.length < 5) {
            checkDesc.style.visibility = "hidden";
            textDesc.style.color = "var(--not-active-text-color)";
        }
        else {
            checkDesc.style.visibility = "visible";
            textDesc.style.color = "var(--default-success-color)";
        }
        //Date
        if(formDate.value === "") {
            checkDate.style.visibility = "hidden";
            textDate.style.color = "var(--not-active-text-color)";
        }
        else{
            checkDate.style.visibility = "visible";
            textDate.style.color = "var(--default-success-color)";
        }
        //Time
        if(formTime.value === "") {
            checkTime.style.visibility = "hidden";
            textTime.style.color = "var(--not-active-text-color)";
        }
        else{
            checkTime.style.visibility = "visible";
            textTime.style.color = "var(--default-success-color)";
        }
    }
}