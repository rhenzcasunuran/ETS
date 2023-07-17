var formDesc = document.querySelector("#event-description");
var formDate = document.querySelector("#date");
var formTime = document.querySelector("#time");
var formButton = document.querySelector("#save-btn");

var textDesc = document.querySelector("#textDescription");
var textDate = document.querySelector("#textDate");
var textTime = document.querySelector("#textTime");

var checkDesc = document.querySelector("#checkDescription");
var checkDate = document.querySelector("#checkDate");
var checkTime = document.querySelector("#checkTime");

var tooltip = document.querySelector('#tooltip');

var nextYearDate = new Date(); // Get current date
var currentDate = new Date(); // Get current date
nextYearDate.setFullYear(currentDate.getFullYear() + 1); // Add a year to the current 
currentDate.setFullYear(currentDate.getFullYear()); // Current date

var nextYearDateString = nextYearDate.toISOString().split("T")[0];
var currentDateString = currentDate.toISOString().split("T")[0];

var nextYearDay = nextYearDate.getDate();
var nextYearMonth = nextYearDate.getMonth() + 1; // Month is zero-based, so add 1
var nextYearYear = nextYearDate.getFullYear();

var nextYearDate1 = `${nextYearDay}/${nextYearMonth}/${nextYearYear}`;


var dateText = document.querySelector("#dateText");
dateText.textContent = "Date not later than " + nextYearDate1;


// alternative is to use "change" - explained below
formDesc.addEventListener("keyup", () => buttonState());
formDate.addEventListener("keyup", () => buttonState());
formDate.addEventListener("change", () => buttonState());
formTime.addEventListener("keyup", () => buttonState());
formTime.addEventListener("change", () => buttonState());

function buttonState() {
    var descValue = formDesc.value.trim().replace(/\s\s+/g, ""); // Remove multiple consecutive spaces

    if (formDesc.value !== "" && descValue.length >= 5 && formDate.value !== "" && formDate.value < nextYearDateString && formTime.value !== "") {
        formButton.disabled = false; // enable the button once the input field has content
        tooltip.style.display = 'none';
    } else {
        tooltip.style.display = 'flex';
        formButton.disabled = true; // return disabled as true whenever the input field is empty
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
        if(formDate.value !== "" && formDate.value < nextYearDateString) {
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