function anonymous() {
  const logos = document.querySelectorAll('.logo_container img');
  logos.forEach(logo => {
    const organizationName = logo.getAttribute('name');
    const isAnon = logo.getAttribute('data-anon');

    if (isAnon === '1') {
      logo.setAttribute('src', 'logos/anon.png');
      logo.setAttribute('name', 'Anon Organization');
    } else {
      logo.setAttribute('src', 'logos/' + organizationName + '.png');
    }
  });
}


document.addEventListener("DOMContentLoaded", function() {
  anonymous();
  const eventSelect = document.getElementById('eventSelect');
  eventSelect.addEventListener('change', function () {
    anonymous();
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
        container.addEventListener("click", function() {
          handleLogoClick(logoName);
        });
        container.style.cursor = "pointer";
      } else {
        container.removeEventListener("click", function() {
          handleLogoClick(logoName);
        });
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

  // Move the AJAX request for anonymity to the top
  $.ajax({
    url: "./php/BAR-anon.php",
    type: "GET",
    dataType: "json",
    data: { selectedEventName: eventSelect.value },
    success: function(response) {
      const logos = document.querySelectorAll("#logos");
      const meters = document.querySelectorAll(".meter");
      const logo_container = document.querySelectorAll("img");
      const anonDiv = document.getElementById("anon-admin-popup");
      const arrowBtn = document.querySelector("#arrow-btn");
      arrowBtn.classList.add("hide-arrow");

      if (response.isAnon === "1") {
        anonDiv.classList.remove("hide");
        console.log("Anonymity is turned on");
        logos.forEach(function(container) {
          const imageAnonPath = "logos/anon.png";
          const img = container.querySelector("img");
          img.src = imageAnonPath;
        });
        meters.forEach(function(meter) {
          meter.setAttribute("id", "anon");
        });
        logo_container.forEach(function(container) {
          container.setAttribute("name", "anon");
        });
      } else {
        arrowBtn.classList.remove("hide-arrow");
        anonDiv.classList.add("hide");
        console.log("Anonymity is turned off");
        $.ajax({
          url: "./php/BAR-organization.php",
          type: "GET",
          dataType: "json",
          data: { selectedEventName: eventSelect.value },
          success: function(organizations) {
            logos.forEach(function(container, index) {
              const organization = organizations[index];
              const imagePath = "logos/" + organization + ".png";
              const img = container.querySelector("img");
              img.src = imagePath;
              img.setAttribute("name", organization);
            });
            meters.forEach(function(meter, index) {
              const organization = organizations[index];
              meter.setAttribute("id", organization);
            });

            // Call the handleLogoClick function to update the profile on initial load
            const logoName = graphSection.querySelector(".logo_container img").getAttribute("name");
            handleLogoClick(logoName);
          },
          error: function(error) {
            console.error("Failed to fetch organizations:", error);
          },
        });
      }
    },
    error: function(error) {
      console.error("Request failed:", error);
    }
  });

  function handleLogoClick(logoName) {
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
});
