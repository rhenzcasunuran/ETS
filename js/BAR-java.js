document.addEventListener("DOMContentLoaded", function() {
  const graphSection = document.querySelector("#graph-section");
  const arrowBtn = document.querySelector("#arrow-btn");
  const containerFluid = document.querySelector(".container-fluid");

arrowBtn.addEventListener("click", function() {
  graphSection.classList.toggle("placement_open");

  const placementOpen = graphSection.classList.contains("placement_open");

  updateLogoClickability(placementOpen);

  arrowBtn.classList.toggle("bx-arrow-to-left", !placementOpen);
  arrowBtn.classList.toggle("bx-arrow-to-right", placementOpen);

  containerFluid.classList.toggle("placement_open", placementOpen);

  if (typeof Storage !== "undefined") {
    localStorage.setItem("graph", placementOpen ? "open" : "closed");
  }
});

const placementOpen = graphSection.classList.contains("placement_open");
updateLogoClickability(placementOpen);

const localStorageState = localStorage.getItem("graph");
if (localStorageState === "open") {
  graphSection.classList.add("placement_open");
  updateLogoClickability(true);
  arrowBtn.classList.add("bx-arrow-to-right");
  containerFluid.classList.add("placement_open");
} else if (localStorageState === "closed") {
  graphSection.classList.remove("placement_open");
  updateLogoClickability(false);
  arrowBtn.classList.add("bx-arrow-to-left");
  containerFluid.classList.remove("placement_open");
}

function updateLogoClickability(placementOpen) {
  const logoContainers = document.querySelectorAll(".logo_container");
  logoContainers.forEach((container) => {
    const logoName = container.querySelector("img").getAttribute("name");
    if (placementOpen) {
      container.addEventListener("click", () => handleLogoClick(logoName));
      container.style.cursor = "pointer";
    } else {
      container.removeEventListener("click", () => handleLogoClick(logoName));
      container.style.cursor = "default";
    }
  });

  sortMeters();
}

  function handleLogoClick(logoName) {
    const placementOpen = graphSection.classList.contains("placement_open");
    if (placementOpen) {
      let logoSrc;
      let profileText;
      let ulText;
      let orgPhotoSrc;    

      $.ajax({
        url: "./php/BAR-get-competition.php",
        type: "GET",
        dataType: "json",
        success: function(response) {
            // Handle the retrieved data
            console.log(response); // or perform other operations
            const competitionNames = response.map(item => item.competition_name);

            switch (logoName) {
              case "acap":
                console.log("ACAP logo clicked");
                logoSrc = "logos/ACAP.png";
                profileText = "Association of Competent and Aspiring Psychologists";
                ulText = 'Participated in: <li>' + competitionNames.join('</li><li>') + '</li>';
                orgPhotoSrc = "org-photos/koala.jpg";
                break;
              case "aeces":
                console.log("AECES logo clicked");
                logoSrc = "logos/AECES.png";
                profileText = "Association of Electronics and Communications Engineering Students";
                ulText = 'Participated in: <li>' + competitionNames.join('</li><li>') + '</li>';
                orgPhotoSrc = "org-photos/fruits.jpg";
                break;
              case "elite":
                console.log("ELITE logo clicked");
                logoSrc = "logos/ELITE.png";
                profileText = "Eligible League of Information Technology Enthusiasts";
                ulText = 'Participated in: <li>' + competitionNames.join('</li><li>') + '</li>';
                orgPhotoSrc = "org-photos/tower.jpg";
                break;
              case "give":
                console.log("GIVE logo clicked");
                logoSrc = "logos/GIVE.png";
                profileText = "Guild of Imporous and Valuable Educators";
                ulText = 'Participated in: <li>' + competitionNames.join('</li><li>') + '</li>';
                orgPhotoSrc = "org-photos/give.jpg";
                break;
              case "jehra":
                console.log("JEHRA logo clicked");
                logoSrc = "logos/JEHRA.png";
                profileText = "Junior Executive of Human Resource Association";
                ulText = 'Participated in: <li>' + competitionNames.join('</li><li>') + '</li>';
                orgPhotoSrc = "org-photos/jehra.jpg";
                break;
              case "jmap":
                console.log("JMAP logo clicked");
                logoSrc = "logos/JMAP.png";
                profileText = "Junior Marketing Association of the Philippines";
                ulText = 'Participated in: <li>' + competitionNames.join('</li><li>') + '</li>';
                orgPhotoSrc = "org-photos/jmap.jpg";
                break;
              case "jpia":
                console.log("JPIA logo clicked");
                logoSrc = "logos/JPIA.png";
                profileText = "Junior Philippine Institute of Accountants";
                ulText = 'Participated in: <li>' + competitionNames.join('</li><li>') + '</li>';
                orgPhotoSrc = "org-photos/jpia.jpg";
                break;
              case "piie":
                console.log("PIIE logo clicked");
                logoSrc = "logos/PIIE.png";
                profileText = "Philippine Institute of Industrial Engineers";
                ulText = 'Participated in: <li>' + competitionNames.join('</li><li>') + '</li>';
                orgPhotoSrc = "org-photos/tower.jpg";
                break;
              default:
                console.log(logoName + " logo clicked");
                return;
            }
        
            const logoImage = document.querySelector("#profile-logo");
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
        
            const ulElement = document.querySelector(".winnings");
            if (ulElement) {
              ulElement.innerHTML = ulText;
            } else {
              console.log("UL element not found");
            }
        
            const orgPhotoImage = document.querySelector(".org-photo-image");
            if (orgPhotoImage) {
              orgPhotoImage.style.display = "block";
              orgPhotoImage.src = orgPhotoSrc;
            } else {
              console.log("Org photo image element not found");
            }
        },
        error: function(xhr) {
            console.error(xhr);
        }
      });
  
      
    }
  }  

  function sortMeters() {
    const meterContainer = document.querySelector(".col-11");
    const meters = meterContainer.querySelectorAll(".meter");

    const sortedElements = Array.from(meters).sort((a, b) => {
      const widthA = parseFloat(getComputedStyle(a).width);
      const widthB = parseFloat(getComputedStyle(b).width);
      return widthB - widthA;
    });

    sortedElements.forEach((element) => {
      const parentRow = element.parentNode.parentNode;
      meterContainer.appendChild(parentRow);

      const logoName = element.getAttribute("name");
      const logoContainer = document.querySelector(`[name="${logoName}"]`).parentNode.parentNode;
      const rankContainer = document.querySelector("#rank_container");
      rankContainer.appendChild(logoContainer);
    });
  }

});
