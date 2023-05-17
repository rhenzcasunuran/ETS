const sidebars = document.querySelector(".sidebar");
const closeBtns = document.querySelector("#btn");


if (typeof(Storage) !== "undefined") {
    // If we need to open the bar
    if(localStorage.getItem("sidebar") == "open"){
        // Open the bar
        sidebars.classList.add("open");
        closeBtns.classList.replace("bx-arrow-to-right","bx-arrow-to-left")
    }
    else if (localStorage.getItem("sidebar") == "closed"){
        sidebars.classList.remove("open");
        closeBtns.classList.replace("bx-arrow-to-left","bx-arrow-to-right")
    }
}