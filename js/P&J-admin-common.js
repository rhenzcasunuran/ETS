function discardChanges() {
    // Get the form element
    var form = document.getElementById('score_form');

    if (form) {
        // Reset the form to clear all inputs
        form.reset();

        // Hide the cancelWrapper popup
        hideCancel();
    } else {
        console.error('Form with ID "score_form" not found.');
    }
}

function populateScores(participantId, scores) {
    var scoreInputs = document.querySelectorAll('.cforms.scoreinp');
    
    scores.forEach(function(score, index) {
      scoreInputs[index].value = score;
    });
  
    var formContainer = document.querySelector('.inputscore');
    formContainer.scrollIntoView({ behavior: 'smooth' });
  }
