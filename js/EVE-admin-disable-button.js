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
const textCriteria = document.querySelector("#textCriteria");
const textDate = document.querySelector("#textDate");
const textTime = document.querySelector("#textTime");

const checkEvent = document.querySelector("#checkEvent");
const checkType = document.querySelector("#checkType");
const checkCategory = document.querySelector("#checkCategory");
const checkDesc = document.querySelector("#checkDescription");
const checkCriteria = document.querySelector("#checkCriteria");
const checkDate = document.querySelector("#checkDate");
const checkTime = document.querySelector("#checkTime");

var tooltip = document.querySelector('#tooltip');

const nextYearDate = new Date(); // Get current date
const currentDate = new Date(); // Get current date
nextYearDate.setFullYear(currentDate.getFullYear() + 1); // Add a year to the current 
currentDate.setFullYear(currentDate.getFullYear()); // Current date

const nextYearDateString = nextYearDate.toISOString().split("T")[0];
const currentDateString = currentDate.toISOString().split("T")[0];

const currentDay = currentDate.getDate();
const currentMonth = currentDate.getMonth() + 1; // Month is zero-based, so add 1
const currentYear = currentDate.getFullYear();

const currentDate1 = `${currentDay}/${currentMonth}/${currentYear}`;

const nextYearDay = nextYearDate.getDate();
const nextYearMonth = nextYearDate.getMonth() + 1; // Month is zero-based, so add 1
const nextYearYear = nextYearDate.getFullYear();

const nextYearDate1 = `${nextYearDay}/${nextYearMonth}/${nextYearYear}`;


const dateText = document.querySelector("#dateText");
dateText.textContent = "(" + currentDate1 + ") to (" + nextYearDate1 + ")";


// the default state is 'disabled'
formButton.disabled = true; 

// alternative is to use "change" - explained below
formEvent.addEventListener("change", () => buttonState(totalPercentage));
formType.addEventListener("change", () => buttonState(totalPercentage));
formCategory.addEventListener("change", () => buttonState(totalPercentage));
formDesc.addEventListener("keyup", () => buttonState(totalPercentage));
formDate.addEventListener("keyup", () => buttonState(totalPercentage));
formDate.addEventListener("change", () => buttonState(totalPercentage));
formTime.addEventListener("keyup", () => buttonState(totalPercentage));
formTime.addEventListener("change", () => buttonState(totalPercentage));

function buttonState(totalPercentage) {
    const descValue = formDesc.value.trim().replace(/\s\s+/g, ""); // Remove multiple consecutive spaces
    var total = totalPercentage;
    console.log(total);


    if (total === 100 && formDesc.value !== "" && descValue.length >= 5 && formDate.value !== "" && formDate.value < nextYearDateString && formDate.value >= currentDateString && formTime.value !== "" && formEvent.value !== "" && formType.value !== "" && formCategory.value !== "") {
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
        //Criteria
        if (total === 100) {
            checkCriteria.style.visibility = "visible";
            textCriteria.style.color = "var(--default-success-color)";
        }
        else {
            checkCriteria.style.visibility = "hidden";
            textCriteria.style.color = "var(--not-active-text-color)";
        }
        //Date
        if(formDate.value !== "" && (formDate.value < nextYearDateString && formDate.value >= currentDateString)) {
            checkDate.style.visibility = "visible";
            textDate.style.color = "var(--default-success-color)";
        }
        else{
            checkDate.style.visibility = "hidden";
            textDate.style.color = "var(--not-active-text-color)";
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