document.addEventListener("DOMContentLoaded", function() {

  const eventSelect = document.getElementById('eventSelect');
  eventSelect.addEventListener('change', function() {
    document.getElementById('myForm').submit();
  });
  
  const graphSection = document.querySelector("#graph-section");
  const arrowBtn = document.querySelector("#arrow-btn");
  const selectOrg = graphSection.classList.contains("select_org");
  updateLogoClickability(selectOrg);

  function updateLogoClickability(selectOrg) {
    const logoContainers = document.querySelectorAll(".logo_container");
    logoContainers.forEach((container) => {
      const logoName = container.querySelector("img").getAttribute("name");
      if (selectOrg) {
        container.addEventListener("click", handleLogoClick);
        container.style.cursor = "pointer";
      } else {
        container.removeEventListener("click", handleLogoClick);
        container.style.cursor = "default";
      }
    });
  }

    arrowBtn.addEventListener("click", function() {
      graphSection.classList.toggle("select_org");
      graphSection.classList.remove("placement_open");
      const selectOrg = graphSection.classList.contains("select_org");

      updateLogoClickability(selectOrg);
    });

const anonButton = document.getElementById("anon_button");
const slider = document.querySelector(".slider");
const cancelWrapper = document.getElementById("anon-confirm");

anonButton.addEventListener("click", function(event) {
  console.log("owow")
  event.stopPropagation();
  cancelWrapper.style.display = "flex";
});

const confirmButton = document.getElementById("anon_button_confirm");
confirmButton.addEventListener("click", function() {
  const isChecked = anonButton.checked ? 1 : 0;
  const selectedEventName = eventSelect.value; 
  $.ajax({
    url: "./php/BAR-update-anon.php",
    type: "POST",
    data: { isAnon: isChecked, selectedEventName: selectedEventName },
    success: function() {
      console.log("Anonymity updated successfully");
      slider.classList.toggle("slide");
      cancelWrapper.style.display = "none";
      anonButton.checked = isChecked === 1;
      location.reload();
    },
    error: function(error) {
      console.error("Update failed:", error);
    }
  });
});


cancelWrapper.addEventListener("click", function(event) {
  const target = event.target;
  if (target === cancelWrapper || target.classList.contains("outline-button") || target.classList.contains("primary-button")) {
    if (target.classList.contains("outline-button")) {
      cancelWrapper.style.display = "none";
      anonButton.checked = !anonButton.checked;
    }
  } else {
    event.preventDefault();
    event.stopPropagation();
  }
});

    
function anonymous() {
  const anon = document.getElementById("anon_button");
  const noticeDiv = document.getElementById("notice");
  const anonDiv = document.getElementById("anon-admin-popup");
  const selectedEventName = eventSelect.value;

  $.ajax({
    url: "./php/BAR-anon.php",
    type: "GET",
    dataType: "json",
    data: { selectedEventName: selectedEventName },
    success: function (response) {
      if (response.isAnon === "1") {
        anon.checked = true;
        noticeDiv.classList.remove("hide");
        anonDiv.classList.remove("hide");
      } else {
        anon.checked = false;
        noticeDiv.classList.add("hide");
        anonDiv.classList.add("hide");
      }
    },
    error: function (error) {
      console.error("Request failed:", error);
    },
  });
}

      function handleLogoClick(event) {
        const logoName = event.target.getAttribute("name");
        graphSection.classList.add("placement_open");
        const placementOpen = graphSection.classList.contains("placement_open");
        if (placementOpen) {
          let logoSrc;
          let profileText;  

          $.ajax({
            url: "./php/BAR-get-competition.php",
            type: "GET",
            dataType: "json",
            success: function() {

                switch (logoName) {
                  case "ACAP":
                    console.log("ACAP logo clicked");
                    logoSrc = "logos/ACAP.png";
                    profileText = "Association of Competent and Aspiring Psychologists";
                    break;
                  case "AECES":
                    console.log("AECES logo clicked");
                    logoSrc = "logos/AECES.png";
                    profileText = "Association of Electronics and Communications Engineering Students";
                    break;
                  case "ELITE":
                    console.log("ELITE logo clicked");
                    logoSrc = "logos/ELITE.png";
                    profileText = "Eligible League of Information Technology Enthusiasts";
                    break;
                  case "GIVE":
                    console.log("GIVE logo clicked");
                    logoSrc = "logos/GIVE.png";
                    profileText = "Guild of Imporous and Valuable Educators";
                    break;
                  case "JEHRA":
                    console.log("JEHRA logo clicked");
                    logoSrc = "logos/JEHRA.png";
                    profileText = "Junior Executive of Human Resource Association";
                    break;
                  case "JMAP":
                    console.log("JMAP logo clicked");
                    logoSrc = "logos/JMAP.png";
                    profileText = "Junior Marketing Association of the Philippines";
                    break;
                  case "JPIA":
                    console.log("JPIA logo clicked");
                    logoSrc = "logos/JPIA.png";
                    profileText = "Junior Philippine Institute of Accountants";
                    break;
                  case "PIIE":
                    console.log("PIIE logo clicked");
                    logoSrc = "logos/PIIE.png";
                    profileText = "Philippine Institute of Industrial Engineers";
                    break;
                  default:
                    console.log("lmao mali");
                    return;
                }
            
                const logoImage = document.querySelector(".profile-logo");
                if (logoImage) {
                  logoImage.src = logoSrc;
                } else {
                  console.log("Logo element not found");
                }
            
                const profileName = document.querySelector("#profile-name");
                if (profileName) {
                  profileName.textContent = profileText;
                } else {
                  console.log("Profile name element not found");
                }
            },
            error: function(xhr) {
                console.error(xhr);
            }
          });
      
          
        }
      }  
      anonymous()
});
