var formEvent = document.querySelector("#select-event-name");
var formType = document.querySelector("#select-event-type");
var formCategory = document.querySelector("#select-category-name");
var formDesc = document.querySelector("#event-description");
var formDate = document.querySelector("#date");
var formTime = document.querySelector("#time");
var formButton = document.querySelector("#save-btn");

var textEvent = document.querySelector("#textEvent");
var textType = document.querySelector("#textType");
var textCategory = document.querySelector("#textCategory");
var textDesc = document.querySelector("#textDescription");
var textCriteria = document.querySelector("#textCriteria");
var textDate = document.querySelector("#textDate");
var textTime = document.querySelector("#textTime");

var checkEvent = document.querySelector("#checkEvent");
var checkType = document.querySelector("#checkType");
var checkCategory = document.querySelector("#checkCategory");
var checkDesc = document.querySelector("#checkDescription");
var checkCriteria = document.querySelector("#checkCriteria");
var checkDate = document.querySelector("#checkDate");
var checkTime = document.querySelector("#checkTime");

var tooltip = document.querySelector('#tooltip');

var nextYearDate = new Date(); // Get current date
var currentDate = new Date(); // Get current date
nextYearDate.setFullYear(currentDate.getFullYear() + 1); // Add a year to the current 
currentDate.setFullYear(currentDate.getFullYear()); // Current date

var nextYearDateString = nextYearDate.toISOString().split("T")[0];
var currentDateString = currentDate.toISOString().split("T")[0];

var currentDay = currentDate.getDate();
var currentMonth = currentDate.getMonth() + 1; // Month is zero-based, so add 1
var currentYear = currentDate.getFullYear();

var currentDate1 = `${currentDay}/${currentMonth}/${currentYear}`;

var nextYearDay = nextYearDate.getDate();
var nextYearMonth = nextYearDate.getMonth() + 1; // Month is zero-based, so add 1
var nextYearYear = nextYearDate.getFullYear();

var nextYearDate1 = `${nextYearDay}/${nextYearMonth}/${nextYearYear}`;


var dateText = document.querySelector("#dateText");
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
    var descValue = formDesc.value.trim().replace(/\s\s+/g, ""); // Remove multiple consecutive spaces
    var total = totalPercentage;

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