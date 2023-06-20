document.addEventListener("DOMContentLoaded", function() {
  anonymous()
  
  const graphSection = document.querySelector("#graph-section");
  const arrowBtn = document.querySelector("#arrow-btn");
  const containerFluid = document.querySelector(".container-fluid");
  const placementOpen = graphSection.classList.contains("placement_open");
  updateLogoClickability(placementOpen);

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
    }

    arrowBtn.addEventListener("click", function() {
      graphSection.classList.toggle("placement_open");

      const placementOpen = graphSection.classList.contains("placement_open");

      updateLogoClickability(placementOpen);

      containerFluid.classList.toggle("placement_open", placementOpen);

      if (typeof Storage !== "undefined") {
        localStorage.setItem("graph", placementOpen ? "open" : "closed");
      }
    });

    const anonButton = document.getElementById("anon_button");
const slider = document.querySelector(".slider");
const cancelWrapper = document.getElementById("cancelWrapper");

anonButton.addEventListener("click", function(event) {
  event.stopPropagation();
  cancelWrapper.style.display = "flex";
});

const confirmButton = document.getElementById("anon_button_confirm");
confirmButton.addEventListener("click", function() {
  const isChecked = anonButton.checked ? 1 : 0;
  $.ajax({
    url: "./php/BAR-update-anon.php",
    type: "POST",
    data: { isAnon: isChecked },
    success: function() {
      console.log("Anonymity updated successfully");
      anonymous();
      slider.classList.toggle("slide");
      cancelWrapper.style.display = "none";
      anonButton.checked = isChecked === 1;
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

    
    function anonymous(){
      const anon = document.getElementById("anon_button")
      const logos = document.querySelectorAll("#logos");
      const meters = document.querySelectorAll(".meter");

      $.ajax({
        url: "./php/BAR-anon.php",
        type: "GET",
        dataType: "json",
        success: function(response) {
          if (response.isAnon === "1") {
            anon.checked = true;
            console.log("true")
            logos.forEach(function(container) {
              const imageAnonPath = "logos/anon.png";
              const img = container.querySelector("img");
              img.src = imageAnonPath;
            });
            meters.forEach(function(meter) {
              meter.setAttribute("id", "anon");
            });
          } else {
            anon.checked = false;
            console.log("false")
            $.ajax({
              url: "./php/BAR-organization.php",
              type: "GET",
              dataType: "json",
              success: function (organizations) {
                logos.forEach(function (container, index) {
                  const organization = organizations[index];
                  const imagePath = "logos/" + organization + ".png";
                  const img = container.querySelector("img");
                  img.src = imagePath;
                });
                meters.forEach(function (meter, index) {
                  const organization = organizations[index];
                  meter.setAttribute("id", organization);
                });
              },
              error: function (error) {
                console.error("Failed to fetch organizations:", error);
              },
            });
          }
        },
        error: function(error) {
          console.error("Request failed:", error);
        }
      });
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
                console.log(response);
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
});
