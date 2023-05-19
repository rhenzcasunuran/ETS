$(document).ready(function() {

  var filtersOrg = [];

  const allCheckboxOrg = document.getElementById('check-all-organization');
  const acapCheckbox = document.getElementById('check-acap');
  const aecesCheckbox = document.getElementById('check-aeces');
  const eliteCheckbox = document.getElementById('check-elite');
  const giveCheckbox = document.getElementById('check-give');
  const jehraCheckbox = document.getElementById('check-jehra');
  const jmapCheckbox = document.getElementById('check-jmap');
  const jpiaCheckbox = document.getElementById('check-jpia');
  const piieCheckbox = document.getElementById('check-piie');

  function updateAllCheckboxOrg() {
    if (
      !acapCheckbox.checked &&
      !aecesCheckbox.checked &&
      !eliteCheckbox.checked &&
      !giveCheckbox.checked &&
      !jehraCheckbox.checked &&
      !jmapCheckbox.checked &&
      !jpiaCheckbox.checked &&
      !piieCheckbox.checked
    ) {
      allCheckboxOrg.checked = false;
    } else if (
      acapCheckbox.checked &&
      aecesCheckbox.checked &&
      eliteCheckbox.checked &&
      giveCheckbox.checked &&
      jehraCheckbox.checked &&
      jmapCheckbox.checked &&
      jpiaCheckbox.checked &&
      piieCheckbox.checked
    ) {
      allCheckboxOrg.checked = true;
    } else {
      allCheckboxOrg.checked = false;
    }
    // update checkbox array
    filtersOrg.length = 0; // clear previous values
    if (acapCheckbox.checked) {
      filtersOrg.push(acapCheckbox.value);
    }
    if (aecesCheckbox.checked) {
      filtersOrg.push(aecesCheckbox.value);
    }
    if (eliteCheckbox.checked) {
      filtersOrg.push(eliteCheckbox.value);
    }
    if (giveCheckbox.checked) {
      filtersOrg.push(giveCheckbox.value);
    }
    if (jehraCheckbox.checked) {
      filtersOrg.push(jehraCheckbox.value);
    }
    if (jmapCheckbox.checked) {
      filtersOrg.push(jmapCheckbox.value);
    }
    if (jpiaCheckbox.checked) {
      filtersOrg.push(jpiaCheckbox.value);
    }
    if (piieCheckbox.checked) {
      filtersOrg.push(piieCheckbox.value);
    }
  }

  // Add event listeners to update "All" checkbox when other checkboxes are clicked
  acapCheckbox.addEventListener('click', updateAllCheckboxOrg);
  aecesCheckbox.addEventListener('click', updateAllCheckboxOrg);
  eliteCheckbox.addEventListener('click', updateAllCheckboxOrg);
  giveCheckbox.addEventListener('click', updateAllCheckboxOrg);
  jehraCheckbox.addEventListener('click', updateAllCheckboxOrg);
  jmapCheckbox.addEventListener('click', updateAllCheckboxOrg);
  jpiaCheckbox.addEventListener('click', updateAllCheckboxOrg);
  piieCheckbox.addEventListener('click', updateAllCheckboxOrg);

  // Add event listener to check other checkboxes when "All" checkbox is checked
  allCheckboxOrg.addEventListener('click', function() {
    filtersOrg.length = 0;
    if (allCheckboxOrg.checked) {
      acapCheckbox.checked = true;
      aecesCheckbox.checked = true;
      eliteCheckbox.checked = true;
      giveCheckbox.checked = true;
      jehraCheckbox.checked = true;
      jmapCheckbox.checked = true;
      jpiaCheckbox.checked = true;
      piieCheckbox.checked = true;
      filtersOrg.push(acapCheckbox.value);
      filtersOrg.push(aecesCheckbox.value);
      filtersOrg.push(eliteCheckbox.value);
      filtersOrg.push(giveCheckbox.value);
      filtersOrg.push(jehraCheckbox.value);
      filtersOrg.push(jmapCheckbox.value);
      filtersOrg.push(jpiaCheckbox.value);
      filtersOrg.push(piieCheckbox.value);
    } else {
      acapCheckbox.checked = false;
      aecesCheckbox.checked = false;
      eliteCheckbox.checked = false;
      giveCheckbox.checked = false;
      jehraCheckbox.checked = false;
      jmapCheckbox.checked = false;
      jpiaCheckbox.checked = false;
      piieCheckbox.checked = false;
    }
    updateCalendarOrg();
  });

  // Select all checkboxes at startup
  allCheckboxOrg.checked = true;
  acapCheckbox.checked = true;
  aecesCheckbox.checked = true;
  eliteCheckbox.checked = true;
  giveCheckbox.checked = true;
  jehraCheckbox.checked = true;
  jmapCheckbox.checked = true;
  jpiaCheckbox.checked = true;
  piieCheckbox.checked = true;

  
  function updateCalendarOrg() {
    //generateCalendar(currentMonth, currentYear, filtersOrg);
  }

  acapCheckbox.addEventListener('click', updateCalendarOrg);
  aecesCheckbox.addEventListener('click', updateCalendarOrg);
  eliteCheckbox.addEventListener('click', updateCalendarOrg);
  giveCheckbox.addEventListener('click', updateCalendarOrg);
  jehraCheckbox.addEventListener('click', updateCalendarOrg);
  jmapCheckbox.addEventListener('click', updateCalendarOrg);
  jpiaCheckbox.addEventListener('click', updateCalendarOrg);
  piieCheckbox.addEventListener('click', updateCalendarOrg);

  function updateAllCheckboxOrg() {
    if (
      !acapCheckbox.checked &&
      !aecesCheckbox.checked &&
      !eliteCheckbox.checked &&
      !giveCheckbox.checked &&
      !jehraCheckbox.checked &&
      !jmapCheckbox.checked &&
      !jpiaCheckbox.checked &&
      !piieCheckbox.checked
    ) {
      allCheckboxOrg.checked = false;
    } else if (
      acapCheckbox.checked &&
      aecesCheckbox.checked &&
      eliteCheckbox.checked &&
      giveCheckbox.checked &&
      jehraCheckbox.checked &&
      jmapCheckbox.checked &&
      jpiaCheckbox.checked &&
      piieCheckbox.checked
    ) {
      allCheckboxOrg.checked = true;
    } else {
      allCheckboxOrg.checked = false;
    }
    // update checkbox array
    filtersOrg.length = 0; // clear previous values
    if (acapCheckbox.checked) {
      filtersOrg.push(acapCheckbox.value);
    }
    if (aecesCheckbox.checked) {
      filtersOrg.push(aecesCheckbox.value);
    }
    if (eliteCheckbox.checked) {
      filtersOrg.push(eliteCheckbox.value);
    }
    if (giveCheckbox.checked) {
      filtersOrg.push(giveCheckbox.value);
    }
    if (jehraCheckbox.checked) {
      filtersOrg.push(jehraCheckbox.value);
    }
    if (jmapCheckbox.checked) {
      filtersOrg.push(jmapCheckbox.value);
    }
    if (jpiaCheckbox.checked) {
      filtersOrg.push(jpiaCheckbox.value);
    }
    if (piieCheckbox.checked) {
      filtersOrg.push(piieCheckbox.value);
    }
  }

  const allCheckboxAdmin = document.getElementById('check-all-admin');
  const adminOneCheckbox = document.getElementById('check-admin-one');
  const adminTwoCheckbox = document.getElementById('check-admin-two');
  const adminThreeCheckbox = document.getElementById('check-admin-three');  
  
  function updateAllCheckboxAdmin() {
    if (!adminOneCheckbox.checked && !adminTwoCheckbox.checked && !adminThreeCheckbox.checked) {
      allCheckboxAdmin.checked = false;
    } else if (adminOneCheckbox.checked && adminTwoCheckbox.checked && adminThreeCheckbox.checked) {
      allCheckboxAdmin.checked = true;
    } else {
      allCheckboxAdmin.checked = false;
    }
    // update checkbox array
    filtersAdmin.length = 0; // clear previous values
    if (adminOneCheckbox.checked) {
      filtersAdmin.push(adminOneCheckbox.value);
    }
    if (adminTwoCheckbox.checked) {
      filtersAdmin.push(adminTwoCheckbox.value);
    }
    if (adminThreeCheckbox.checked) {
      filtersAdmin.push(adminThreeCheckbox.value);
    }
  }
  
  // Add event listeners to update "All" checkbox when other checkboxes are clicked
  adminOneCheckbox.addEventListener('click', updateAllCheckboxAdmin);
  adminTwoCheckbox.addEventListener('click', updateAllCheckboxAdmin);
  adminThreeCheckbox.addEventListener('click', updateAllCheckboxAdmin);
  
  // Add event listener to check other checkboxes when "All" checkbox is checked
  allCheckboxAdmin.addEventListener('click', function () {
    if (allCheckboxAdmin.checked) {
      adminOneCheckbox.checked = true;
      adminTwoCheckbox.checked = true;
      adminThreeCheckbox.checked = true;
      filtersAdmin = [
        adminOneCheckbox.value,
        adminTwoCheckbox.value,
        adminThreeCheckbox.value
      ];
    } else {
      adminOneCheckbox.checked = false;
      adminTwoCheckbox.checked = false;
      adminThreeCheckbox.checked = false;
      filtersAdmin = [];
    }
    updateAllCheckboxAdmin(); // Update the "All" checkbox based on the individual checkboxes' state
    updateLogs(); // Call the updateLogs function to perform any necessary actions
  });  
  
  // Select all checkboxes at startup
  allCheckboxAdmin.checked = true;
  adminOneCheckbox.checked = true;
  adminTwoCheckbox.checked = true;
  adminThreeCheckbox.checked = true;
  
  function updateLogs() {
    //generateLogs(currentMonth, currentYear, filtersAdmin);
  }
  
  adminOneCheckbox.addEventListener('click', updateLogs);
  adminTwoCheckbox.addEventListener('click', updateLogs);
  adminThreeCheckbox.addEventListener('click', updateLogs);
});