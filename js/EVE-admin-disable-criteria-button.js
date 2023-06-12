const formButton = document.querySelector("#criteriaSaveBtn");
var tooltip = document.querySelector('#tooltip');

const textCriterionName = document.querySelector("#textCriterionName");
const textPercentage = document.querySelector("#textPercentage");
const textTotalPercentage = document.querySelector("#textTotalPercentage");

const checkCriterionName = document.querySelector("#checkCriterionName");
const checkPercentage = document.querySelector("#checkPercentage");
const checkTotalPercentage = document.querySelector("#checkTotalPercentage");

function updateTotalPercentage() {
    var total = 0;
    var allCriterionValuesEntered = true; 
    var allPercentValuesEntered = true; 

    $('input[name="criterion[]"]').keypress(function(e) {
      var txt = String.fromCharCode(e.which);
      if (!txt.match(/[A-Za-z ]/)) {
          return false;
      }
    });

    $('input[name="percentage[]"]').keypress(function(e) {
      var txt = String.fromCharCode(e.which);
      if (!txt.match(/[0-9]/)) {
          return false;
      }
    });

    $('input[name="criterion[]"]').on('input', function(e) {
      $(this).val(function(i, v) {
        return v.replace(/[^\w\s]|_/gi, '');
      });
    });

    $('input[name="criterion[]"]').each(function() {
      var value = $(this).val();
      if ($(this).val() === '' || value.replace(/\s/g, '').length < 5 || value.trim() === '')  {
          allCriterionValuesEntered = false;
      }
      else{
        allCriterionValuesEntered = true;
      }
    });

    $('input[name="percentage[]"]').on('input', function(e) {
      $(this).val(function(i, v) {
        return v.replace(/[^\d]|/g, '');
      });
    });

    $('input[name="percentage[]"]').each(function() {
      var percentage = parseFloat($(this).val());
      if (!isNaN(percentage)) {
          total += percentage;
      }
      if ($(this).val() === '' || ($(this).val() === '0') || ($(this).val() === '00') || ($(this).val() === '000')) {
          allPercentValuesEntered = false;
      }
      else{
        allPercentValuesEntered = true;
      }
    });

    $('#totalPercentage p').text(total + '%');
    
    if (total !== 100 || allCriterionValuesEntered === false || allPercentValuesEntered === false) {
      formButton.disabled = true;
      tooltip.style.display = 'flex';
      if(allCriterionValuesEntered === false) {
        checkCriterionName.style.visibility = "hidden";
        textCriterionName.style.color = "var(--not-active-text-color)";
      }
      else {
        checkCriterionName.style.visibility = "visible";
        textCriterionName.style.color = "var(--default-success-color)";
      }
      if(total !== 100 || allPercentValuesEntered === false){
        $('#totalPercentage p').css("color", "red");
      }
      if(total !== 100){
        checkTotalPercentage.style.visibility = "hidden";
        textTotalPercentage.style.color = "var(--not-active-text-color)";
      }
      else {
        $('#totalPercentage p').css("color", "var(--color-content-text)");
        checkTotalPercentage.style.visibility = "visible";
        textTotalPercentage.style.color = "var(--default-success-color)";
      }
      if(allPercentValuesEntered === false) {
        checkPercentage.style.visibility = "hidden";
        textPercentage.style.color = "var(--not-active-text-color)";
      }
      else {
        checkPercentage.style.visibility = "visible";
        textPercentage.style.color = "var(--default-success-color)";
      }
    }
    else {
      formButton.disabled = false;
      tooltip.style.display = 'none';
      if(total === 100){
        $('#totalPercentage p').css("color", "var(--color-content-text)");
      }
    }
}
