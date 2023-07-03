$(document).ready(function() {
    var markAsDoneButton = $('#markAsDoneBtn');

    var targetDate = new Date($('#date').val());

    var currentDate = new Date();

    if (currentDate < targetDate) {
      markAsDoneButton.prop('disabled', true);
    }
    else {
      markAsDoneButton.prop('disabled', false);
    }
  });