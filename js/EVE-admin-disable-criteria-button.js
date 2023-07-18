const formButton = document.querySelector("#criteriaSaveBtn");
var tooltip = document.querySelector('#tooltip');

const textCriterionDuplicate = document.querySelector("#textCriterionDuplicate");
const textCriterionName = document.querySelector("#textCriterionName");
const textPercentage = document.querySelector("#textPercentage");
const textTotalPercentage = document.querySelector("#textTotalPercentage");
const textHasChanges = document.querySelector("#textHasChanges");

const checkCriterionDuplicate = document.querySelector("#checkCriterionDuplicate");
const checkCriterionName = document.querySelector("#checkCriterionName");
const checkCriterionNameChar = document.querySelector("#checkCriterionNameChar");
const checkPercentage = document.querySelector("#checkPercentage");
const checkTotalPercentage = document.querySelector("#checkTotalPercentage");
const checkHasChanges = document.querySelector("#checkHasChanges");

var initialCriterionValues = [];
var initialPercentageValues = [];

function updateTotalPercentage() {
    var total = 0;
    var nmbrCriterion = 0;
    var nmbrPercent = 0;
    var allCriterionValuesEntered = false; 
    var allPercentValuesEntered = false; 

    var criterion = document.querySelectorAll('input[name="criterion[]"]');
    var criterionCount = criterion.length;

    var percentage = document.querySelectorAll('input[name="percentage[]"]');
    var percentageCount = percentage.length;

    var criterionValues = [];
    var percentageValues = [];

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
      criterionValues.push(value);
      initialCriterionValues.push(value);
      if ($(this).val() === '' || value.replace(/\s/g, '').length < 5 || value.trim() === '')  {
 
      }
      else{
        nmbrCriterion += 1;
      }
    });

    var hasDuplicateCriterion = criterionValues.some(function(value, index) {
      return criterionValues.indexOf(value) !== index;
    });

    $('input[name="percentage[]"]').on('input', function(e) {
      $(this).val(function(i, v) {
        return v.replace(/[^\d]|/g, '');
      });
    });

    $('input[name="percentage[]"]').each(function() {
      var percentage = parseFloat($(this).val());
      percentageValues.push($(this).val());
      initialPercentageValues.push($(this).val());
      if (!isNaN(percentage)) {
          total += percentage;
      }
      if ($(this).val() === '' || ($(this).val() === '0') || ($(this).val() === '00') || ($(this).val() === '000')) {
 
      }
      else{
        nmbrPercent += 1;
      }
    });

    if (nmbrCriterion === criterionCount){
      allCriterionValuesEntered = true;
    
    }
    else{
      allCriterionValuesEntered = false;
    }

    if (nmbrPercent === percentageCount){
      allPercentValuesEntered = true;
    }
    else{
      allPercentValuesEntered = false;
    }

    $('#totalPercentage p').text(total + '%');

    var hasCriterionChanges = $('input[name="criterion[]"]').toArray().some(function(input, index) {
      console.log($(input).val());
      console.log(initialCriterionValues[index]);
      return $(input).val() !== initialCriterionValues[index];
    });

    var hasPercentageChanges = $('input[name="percentage[]"]').toArray().some(function(input, index) {
      console.log($(input).val());
      console.log(initialPercentageValues[index]);
        return $(input).val() !== initialPercentageValues[index];
    });
    
    if ((!hasCriterionChanges && !hasPercentageChanges) || total !== 100 || allCriterionValuesEntered === false || allPercentValuesEntered === false || hasDuplicateCriterion === true) {
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
      if(hasDuplicateCriterion === true) {
        checkCriterionDuplicate.style.visibility = "hidden";
        textCriterionDuplicate.style.color = "var(--not-active-text-color)";
      }
      else {
        checkCriterionDuplicate.style.visibility = "visible";
        textCriterionDuplicate.style.color = "var(--default-success-color)";
      }
      if(!hasCriterionChanges && !hasPercentageChanges){
        checkHasChanges.style.visibility = "hidden";
        textHasChanges.style.color = "var(--not-active-text-color)";
      }
      else{
        checkHasChanges.style.visibility = "visible";
        textHasChanges.style.color = "var(--default-success-color)";
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
