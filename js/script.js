const sidebar = document.querySelector(".sidebar");
const closeBtn = document.querySelector("#btn");

function openNav() {
  // If localStorage is supported by the browser
  if (typeof Storage !== "undefined") {
    // Save the state of the sidebar as "open"
    localStorage.setItem("sidebar", "open");
  }
}

function closeNav() {
  // If localStorage is supported by the browser
  if (typeof Storage !== "undefined") {
    // Save the state of the sidebar as "closed"
    localStorage.setItem("sidebar", "closed");
  }
}

function menuBtnChange() {
  if (sidebar.classList.contains("open")) {
    closeBtn.classList.replace("bx-arrow-to-right", "bx-arrow-to-left");
  } else {
    closeBtn.classList.replace("bx-arrow-to-left", "bx-arrow-to-right");
  }
}

function updateSidebarState() {
  const isWindowLarge = window.innerWidth >= 799;

  if (isWindowLarge) {
    sidebar.classList.add("open");
    openNav();
  } else {
    sidebar.classList.remove("open");
    closeNav();
  }

  menuBtnChange();
}

closeBtn.addEventListener("click", function () {
  if (sidebar.classList.toggle("open")) {
    openNav();
  } else {
    closeNav();
  }

  menuBtnChange();
});

window.addEventListener("resize", updateSidebarState);

window.addEventListener("load", function () {
  if (typeof Storage !== "undefined") {
    const storedState = localStorage.getItem("sidebar");

    if (storedState === "open") {
      sidebar.classList.add("open");
    } else if (storedState === "closed") {
      sidebar.classList.remove("open");
    }
  }
  
  updateSidebarState();
});

// Open the sidebar if the window size is initially large
window.addEventListener("DOMContentLoaded", function () {
  const isWindowLarge = window.innerWidth >= 1390;

  if (isWindowLarge) {
    sidebar.classList.add("open");
    openNav();
    menuBtnChange();
  }
});
