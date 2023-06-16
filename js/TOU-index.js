// Home status
let homeCount = 0;
let changeCount = document.getElementById("home--btn");
let decreaseOneButton = document.getElementById("btn--one")

function plusOne() {
    homeCount += 1;
    changeCount.textContent = homeCount;
    decreaseOneButton.disabled = false;
}

function plusTwo() {
    homeCount += 2;
    changeCount.textContent = homeCount;
    decreaseOneButton.disabled = false;
}

function plusThree() {
    homeCount += 3;
    changeCount.textContent = homeCount;
    decreaseOneButton.disabled = false;
}

function minusValueOne() {
    if (homeCount > 0) {
        homeCount -= 1;
        changeCount.textContent = homeCount;
    }

    if (homeCount === 0) {
        decreaseOneButton.disabled = true; // Disable the button
    }

}

function minusValueTwo() {
    if (homeCount > 1) {
        homeCount -= 2;
        changeCount.textContent = homeCount;
    }

    if (homeCount === 1) {
        decreaseOneButton.disabled = true; // Disable the button
    }
}

function minusValueThree() {
    if (homeCount > 2) {
        homeCount -= 3;
        changeCount.textContent = homeCount;
    }

    if (homeCount === 2) {
        decreaseOneButton.disabled = true; // Disable the button
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
    if (guestCount > 0) {
        guestCount -= 1;
        guestCountChange.textContent = guestCount;
    }
}

function decreaseValueTwo() {
    if (guestCount > 1) {
        guestCount -= 2;
        guestCountChange.textContent = guestCount;
    }
}

function decreaseValueThree() {
    if (guestCount > 2) {
        guestCount -= 3;
        guestCountChange.textContent = guestCount;
    }
}

// Save items
let saveCountHome;
let saveCountGuest;
let domHome = document.getElementById("home--count");
let domGuest = document.getElementById("guest--count");


function saveClick() {
    saveCountHome = homeCount + " -- ";
    domHome.textContent += saveCountHome;

    saveCountGuest = guestCount + " -- ";
    domGuest.textContent += saveCountGuest;

    if(counter<5){
        document.getElementById("save--counter").innerHTML += "<input type='radio'>";
        counter++;
    }
    else{
        document.getElementById("id").disabled=true;
    }

    $(document).ready(function() {
        var textValues = ['1st Quarter', '2nd Quarter', '3rd Quarter', '4th Quarter']; // Array of text values
        var currentIndex = 0; // Current index of the array
        
        $('save--counter').click(function() {
            $('#textToChange').text(textValues[currentIndex]);
            currentIndex = (currentIndex + 1) % textValues.length; // Increment the index and wrap around if necessary
        });
    });

    
   // Save the current text displayed in localStorage
  // localStorage.setItem("savedHomeText", domHome.textContent);
  // localStorage.setItem("savedGuestText", domGuest.textContent); 
} 

popupEndMatch = document.getElementById('EndMatchWrapper');
popupSaveScore = document.getElementById('SaveScoreWrapper');

var showSaveScore = function() {
    popupSaveScore.style.display = 'flex';
}

var hideSaveScore = function() {
    popupSaveScore.style.display = 'none';
}

// Retrieve the saved text when the page loads
/* window.addEventListener("load", function () {
    const savedHomeText = localStorage.getItem("savedHomeText");
    const savedGuestText = localStorage.getItem("savedGuestText");

    if (savedHomeText) {
        domHome.textContent = savedHomeText;
    }

    if (savedGuestText) {
        domGuest.textContent = savedGuestText;
    }
}); */
