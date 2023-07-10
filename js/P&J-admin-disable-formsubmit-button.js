const formButton = document.querySelector("#pjFormSaveBtn");
var tooltip = document.querySelector('#tooltip');

const textJName = document.querySelector("#textJName");
const textJNameSubmitted = document.querySelector("#textJNameSubmitted");

const textJNick = document.querySelector("#textJNick");
const textJNickSubmitted = document.querySelector("#textJNickSubmitted");

const textPName = document.querySelector("#textPName");
const textPNameSubmitted = document.querySelector("#textPNameSubmitted");

const textPSection = document.querySelector("#textPSection");
const textPSectionSubmitted = document.querySelector("#textPSectionSubmitted");

const checkJNameValue = document.querySelector("#checkJNameValue");
const checkJNameValueChar = document.querySelector("#checkJNameValueChar");

const checkJNickValue = document.querySelector("#checkJNickValue");
const checkJNickValueChar = document.querySelector("#checkJNickValueChar");

const checkPNameValue = document.querySelector("#checkPNameValue");
const checkPNameValueChar = document.querySelector("#checkPNameValueChar");

const checkPSectionValue = document.querySelector("#checkPSectionValue");
const checkPSectionValueChar = document.querySelector("#checkPSectionValueChar");

const eventCodeInput = document.querySelector("#event_code");

eventCodeInput.addEventListener("keypress", function (e) {
  var txt = String.fromCharCode(e.which);
  if (!txt.match(/[A-Za-z0-9]/)) {
    e.preventDefault();
  }
});

function updateTotalValuesJ() {
  var allJNameValuesEntered = false;
  var allJNickValuesEntered = false;
  var nmbrJName = 0;
  var nmbrJNick = 0;
  var allInputsReadOnly = true;

  var judgeName = document.querySelectorAll('input[name="judge_name[]"]');
  var judgeNameCount = judgeName.length;

  var judgeNick = document.querySelectorAll('input[name="judge_nickname[]"]');
  var judgeNickCount = judgeNick.length;

  $('input[name="judge_name[]"]').keypress(function (e) {
    var txt = String.fromCharCode(e.which);
    if (!txt.match(/[A-Za-z0-9 \-]/)) {
      return false;
    }
  });

  $('input[name="judge_nickname[]"]').keypress(function (e) {
    var txt = String.fromCharCode(e.which);
    if (!txt.match(/[A-Za-z0-9 \-]/)) {
      return false;
    }
  });

  $('input[name="judge_name[]"]').on('input', function (e) {
    $(this).val(function (i, v) {
      return v.replace(/[^\w\s-]/gi, '');
    });
    updateTotalValuesJ();
  });

  $('input[name="judge_name[]"]').each(function () {
    var value = $(this).val();
    if ($(this).val() === '' || value.replace(/\s/g, '').length < 5 || value.trim() === '') {

    } else {
      nmbrJName += 1;
    }
    if (!$(this).is('[readonly]')) {
      allInputsReadOnly = false;
    }
  });

  $('input[name="judge_nickname[]"]').on('input', function (e) {
    $(this).val(function (i, v) {
      return v.replace(/[^\w\s-]/gi, '');
    });
    updateTotalValuesJ();
  });

  $('input[name="judge_nickname[]"]').each(function () {
    var value = $(this).val();
    if ($(this).val() === '' || value.replace(/\s/g, '').length < 5 || value.trim() === '') {

    } else {
      nmbrJNick += 1;
    }
    if (!$(this).is('[readonly]')) {
      allInputsReadOnly = false;
    }
  });

  if (nmbrJName === judgeNameCount) {
    allJNameValuesEntered = true;
  } else {
    allJNameValuesEntered = false;
  }

  if (nmbrJNick === judgeNickCount) {
    allJNickValuesEntered = true;
  } else {
    allJNickValuesEntered = false;
  }

  if (allJNameValuesEntered === false || allJNickValuesEntered === false || !allInputsReadOnly) {
    formButton.disabled = true;
    tooltip.style.display = 'flex';

    if (allJNameValuesEntered === false) {
      checkJNameValue.style.visibility = "hidden";
      textJName.style.color = "var(--not-active-text-color)";
    } else {
      checkJNameValue.style.visibility = "visible";
      textJName.style.color = "var(--default-success-color)";
    }

    if (allJNickValuesEntered === false) {
      checkJNickValue.style.visibility = "hidden";
      textJNick.style.color = "var(--not-active-text-color)";
    } else {
      checkJNickValue.style.visibility = "visible";
      textJNick.style.color = "var(--default-success-color)";
    }
  } else {
    formButton.disabled = false;
    tooltip.style.display = 'none';
  }
}

function enableSubmitButton() {
    var allInputsReadOnly = true;
  
    $('input[name="judge_name[]"], input[name="judge_nickname[]"], input[name="participant_name[]"], input[name="participant_section[]"]').each(function () {
      if (!$(this).is('[readonly]') || $(this).val() === '') {
        allInputsReadOnly = false;
        return false; // Exit the loop if any input is not readonly or has an empty value
      }
    });
  
    if (allInputsReadOnly) {
      formButton.disabled = false;
    } else {
      formButton.disabled = true;
    }
  }
  

function updateTotalValuesP() {
    var allPNameValuesEntered = false;
    var allPSectionValuesEntered = false;
    var nmbrPName = 0;
    var nmbrPSection = 0;
    var allInputsReadOnly = true;
  
    var participantName = document.querySelectorAll('input[name="participant_name[]"]');
    var participantNameCount = participantName.length;
  
    var participantSection = document.querySelectorAll('input[name="participant_section[]"]');
    var participantSectionCount = participantSection.length;
  
    $('input[name="participant_name[]"]').keypress(function (e) {
      var txt = String.fromCharCode(e.which);
      if (!txt.match(/[A-Za-z0-9 \-]/)) {
        return false;
      }
    });
  
    $('input[name="participant_section[]"]').keypress(function (e) {
      var txt = String.fromCharCode(e.which);
      if (!txt.match(/[1-9 \-]/)) {
        return false;
      }
    });
  
    $('input[name="participant_name[]"]').on('input', function (e) {
      $(this).val(function (i, v) {
        return v.replace(/[^\w\s-]/gi, '');
      });
      updateTotalValuesP();
      updateTextPName(); // Update textPName on input change
    });
  
    $('input[name="participant_name[]"]').each(function () {
      var value = $(this).val();
      if ($(this).val() === '' || value.replace(/\s/g, '').length < 5 || value.trim() === '') {
  
      } else {
        nmbrPName += 1;
      }
      if (!$(this).is('[readonly]')) {
        allInputsReadOnly = false;
      }
    });
  
    $('input[name="participant_section[]"]').on('input', function (e) {
      $(this).val(function (i, v) {
        return v.replace(/[^\w\s-]/gi, '');
      });
      updateTotalValuesP();
      updateTextPSection(); // Update textPSection on input change
    });
  
    $('input[name="participant_section[]"]').each(function () {
      var value = $(this).val();
      if ($(this).val() === '' || value.replace(/\s/g, '').length < 3 || value.trim() === '') {
  
      } else {
        nmbrPSection += 1;
      }
      if (!$(this).is('[readonly]')) {
        allInputsReadOnly = false;
      }
    });
  
    if (nmbrPName === participantNameCount) {
      allPNameValuesEntered = true;
    } else {
      allPNameValuesEntered = false;
    }
  
    if (nmbrPSection === participantSectionCount) {
      allPSectionValuesEntered = true;
    } else {
      allPSectionValuesEntered = false;
    }
  
    if (allPNameValuesEntered === false || allPSectionValuesEntered === false || !allInputsReadOnly) {
      formButton.disabled = true;
      tooltip.style.display = 'flex';
  
      if (allPNameValuesEntered === false) {
        checkPNameValue.style.visibility = "hidden";
        textPName.style.color = "var(--not-active-text-color)";
      } else {
        checkPNameValue.style.visibility = "visible";
        textPName.style.color = "var(--default-success-color)";
      }
  
      if (allPSectionValuesEntered === false) {
        checkPSectionValue.style.visibility = "hidden";
        textPSection.style.color = "var(--not-active-text-color)";
      } else {
        checkPSectionValue.style.visibility = "visible";
        textPSection.style.color = "var(--default-success-color)";
      }
    } else {
      formButton.disabled = false;
      tooltip.style.display = 'none';
    }
  }

  function updateTextPName() {
    var allPNameValuesEntered = true;
    $('input[name="participant_name[]"]').each(function () {
      var value = $(this).val();
      if ($(this).val() === '' || value.replace(/\s/g, '').length < 5 || value.trim() === '') {
        allPNameValuesEntered = false;
        return false; // Exit the loop if any value is invalid
      }
    });
  
    if (allPNameValuesEntered) {
      textPName.style.visibility = "visible";
    } else {
      textPName.style.visibility = "hidden";
    }
  }
  
  function updateTextPSection() {
    var allPSectionValuesEntered = true;
    $('input[name="participant_section[]"]').each(function () {
      var value = $(this).val();
      if ($(this).val() === '' || value.replace(/\s/g, '').length < 3 || value.trim() === '') {
        allPSectionValuesEntered = false;
        return false; // Exit the loop if any value is invalid
      }
    });
  
    if (allPSectionValuesEntered) {
      textPSection.style.visibility = "visible";
    } else {
      textPSection.style.visibility = "hidden";
    }
  }