var formDesc = document.querySelector("#event-description");
var formDate = document.querySelector("#date");
var formTime = document.querySelector("#time");
var formButton = document.querySelector("#save-btn");
var formIncluded = document.querySelector("#overallIncluded");
var formMatchStyle = document.querySelector('#event-match-style');

var textDesc = document.querySelector("#textDescription");
var textMatchStyle = document.querySelector("#textMatchStyle");
var textDate = document.querySelector("#textDate");
var textTime = document.querySelector("#textTime");
var textHasChanges = document.querySelector("#textHasChanges");

var checkDesc = document.querySelector("#checkDescription");
var checkMatchStyle = document.querySelector("#checkMatchStyle");
var checkDate = document.querySelector("#checkDate");
var checkTime = document.querySelector("#checkTime");
var checkHasChanges = document.querySelector("#checkHasChanges");

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

var initialDescValue = formDesc.value;
var initialDateValue = formDate.value;
var initialTimeValue = formTime.value;
var initialIncludedValue = formIncluded.value;
var initialMatchStyleValue = formMatchStyle.value;

var hasChanged = false;

function checkFormChanges() {
    if (
      formDesc.value !== initialDescValue ||
      formDate.value !== initialDateValue ||
      formTime.value !== initialTimeValue ||
      formMatchStyle.value !== initialMatchStyleValue ||
      formIncluded.value !== initialIncludedValue
    ) {
        hasChanged = true; // Changes have been made
    }
    else {
        hasChanged = false; // No changes
    }
  }

// alternative is to use "change" - explained below
formDesc.addEventListener("keyup", () => buttonState(checkFormChanges()));
formDate.addEventListener("keyup", () => buttonState(checkFormChanges()));
formDate.addEventListener("change", () => buttonState(checkFormChanges()));
formTime.addEventListener("keyup", () => buttonState(checkFormChanges()));
formTime.addEventListener("change", () => buttonState(checkFormChanges()));
formMatchStyle.addEventListener("change", () => buttonState(checkFormChanges()));
formIncluded.addEventListener("click", () => {
    setTimeout(() => {
      buttonState(checkFormChanges());
    }, 50); // Delay of 500 milliseconds (adjust the delay as needed)
  });

console.log(formMatchStyle.value);

function buttonState() {
    var descValue = formDesc.value.trim().replace(/\s\s+/g, ""); // Remove multiple consecutive spaces

    if (hasChanged && formDesc.value !== "" && descValue.length >= 5 && formDate.value !== "" && formDate.value <= nextYearDateString && formTime.value !== "" && formMatchStyle.value !== "") {
        formButton.disabled = false; // enable the button once the input field has content
        tooltip.style.display = 'none';
    } else {
        tooltip.style.display = 'flex';
        formButton.disabled = true; // return disabled as true whenever the input field is empty
        //Changes
        if (!hasChanged) {
            checkHasChanges.style.visibility = "hidden";
            textHasChanges.style.color = "var(--not-active-text-color)";
        }
        else {
            checkHasChanges.style.visibility = "visible";
            textHasChanges.style.color = "var(--default-success-color)";
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
        //Match Style
        if (formMatchStyle.value === "") {
            checkMatchStyle.style.visibility = "hidden";
            textMatchStyle.style.color = "var(--not-active-text-color)";
        }
        else {
            checkMatchStyle.style.visibility = "visible";
            textMatchStyle.style.color = "var(--default-success-color)";
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