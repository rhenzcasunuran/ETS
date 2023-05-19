// Home status 

let homeCount = 0;
let changeCount = document.getElementById("home--btn");

function plusOne() {
    homeCount += 1;
    changeCount.textContent = homeCount;
}
function plusTwo() {
    homeCount += 2;
    changeCount.textContent = homeCount;
}
function plusThree() {
    homeCount += 3;
    changeCount.textContent = homeCount;
}

function minusValueOne() {
    var valueElement = document.getElementById("home--btn");
    var homeCount = parseInt(valueElement.textContent);

    if (homeCount > 0) {
        valueElement.textContent = homeCount - 1;
    }
}

function minusValueTwo() {
    var valueElement = document.getElementById("home--btn");
    var guestCount = parseInt(valueElement.textContent);

    if (homeCount > 0) {
        valueElement.textContent = homeCount - 2;
    }
}

function minusValueThree() {
    var valueElement = document.getElementById("home--btn");
    var homeCount = parseInt(valueElement.textContent);

    if (homeCount > 0) {
        valueElement.textContent = homeCount - 3;
    }
}


// Guest status 
let guestCount = 0;
let guestCountChange = document.getElementById("guest--btn");

function guestPlusOne() {
    guestCount += 1;
    guestCountChange.textContent = guestCount;
}
function guestPlusTwo() {
    guestCount += 2;
    guestCountChange.textContent = guestCount;
}
function guestPlusThree() {
    guestCount += 3;
    guestCountChange.textContent = guestCount;
}


function decreaseValueOne() {
    var valueElement = document.getElementById("guest--btn");
    var guestCount = parseInt(valueElement.textContent);

    if (guestCount > 0) {
        valueElement.textContent = guestCount - 1;
    }
}

function decreaseValueTwo() {
    var valueElement = document.getElementById("guest--btn");
    var guestCount = parseInt(valueElement.textContent);

    if (guestCount > 0) {
        valueElement.textContent = guestCount - 2;
    }
}

function decreaseValueThree() {
    var valueElement = document.getElementById("guest--btn");
    var guestCount = parseInt(valueElement.textContent);

    if (guestCount > 0) {
        valueElement.textContent = guestCount - 3;
    }
}






// save items 

let saveCountHome;
let saveCountGuest;
let domHome = document.getElementById("home--count")
let domGuest = document.getElementById("guest--count")

function saveClick() {
    saveCountHome  = homeCount + " -- "
    domHome.textContent += saveCountHome;

    saveCountGuest  = guestCount + " -- "
    domGuest.textContent += saveCountGuest;

    changeCount.textContent = 0;
    homeCount = 0;
    guestCountChange.textContent = 0;
    guestCount = 0;

}

