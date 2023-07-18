$(document).ready(function () {
    const resultsButtons = document.querySelectorAll('.resultsBtn');
    resultsButtons.forEach((button) => {
      button.addEventListener("click", (e) => {
        var parentElement = button.parentElement;
        var id = parentElement.id;
        var modifiedid = id.replace('-content', '');
        var competitionName = modifiedid;
        console.log("See Overall Results: competitionName is " + competitionName);
  
        // Create and append the "Overall" button
        const overallButton = "<button class='btn btn-primary criterion-button' data-criterion='overall'>Overall</button>";
        $('.criteria-buttons').prepend(overallButton);

            

            $.ajax({
                type: "POST",
                url: "./php/COM-piechart.php",
                data: { competitionName: competitionName },
                success: function (response) {
                    $("#pieChartModal").remove(); // Remove any existing modal
                    $("body").append(response); // Append the modal to the body
                    $('#pieChartModal').modal('show'); // Show the modal
                
                    // Generate buttons for each criterion
                    const { header: { criterias } } = dataArray[0];
                    const criteriaButtons = criterias.map((criterion) => {
                        return `<button class='btn btn-primary criterion-button' data-criterion='${criterion}'>${criterion}</button>`;
                    });
                    const selectedCompetition = dataArray[0];
                    const participants  = selectedCompetition.participants;
                    const organizations = participants.map((participant) => participant.organization);
                    const organizationColors = {
                        'ACAP': 'rgba(148, 116, 207)',
                        'AECES': 'rgba(168, 68, 68)',
                        'ELITE': 'rgba(223, 133, 27)',
                        'GIVE': 'rgba(115, 169, 204)',
                        'JEHRA': 'rgba(211, 182, 146)',
                        'JMAP': 'rgba(255, 189, 68)',
                        'JPIA': 'rgba(207, 22, 89)',
                        'PIIE': 'rgba(22, 186, 157)',
                    };
                    $('.criteria-buttons').html(criteriaButtons.join(''));

                    // Get unique organizations from the participants data
                    const uniqueOrganizations = [...new Set(organizations)];
                    // Attach click event to the "Overall" button
                    $('.criterion-button').click(function () {
                    var selectedCriterion = $(this).data('criterion');
                    if (selectedCriterion === 'overall') {
                     // Display the overall scores in the pie chart
                        const overallScores = dataArray[0].participants.map((participant) => participant.overall_score);
                        updatePieChartOverall(overallScores, dataArray[0].participants);
                    } else {
                        // Update the pie chart based on the selected criterion and pass scoresArray
                        updatePieChartByCriterion(selectedCriterion, scoresArray);
                }
  });

            // Generate the organization list with colored circles
            
            const organizationList = uniqueOrganizations.map((org) => {
                const backgroundColor = organizationColors[org];
                return `<div class='organization-item'>
                            <div class='organization-circle' style='background-color: ${backgroundColor}'></div>
                            <div class='organization-name'>${org}</div>
                        </div>`;
            });$('.organization-list').html(organizationList.join(''));
            
                
                    createPieChart(criterias[0], scoresArray); // Create the initial pie chart with the first criterion
                    
                
                    $('.criterion-button').click(function () {
                        var selectedCriterion = $(this).data('criterion');
                        updatePieChartByCriterion(selectedCriterion, scoresArray); // Update the pie chart based on the selected criterion and pass scoresArray
                    });
                    // Attach a hidden.bs.modal event handler to the pie chart modal
                    $('#pieChartModal').on('hidden.bs.modal', function () {
                        // Remove the dynamically created div with class piemodals
                        $('.piemodals').remove();
                    });
                },
                
                error: function (xhr, status, error) {
                    console.error(error); // Log any errors to the console
                }
            });
            e.stopPropagation();
        });
    });
});

function createPieChart(selectedCriterion, scoresArray) {
    // Find the selected criterion in the dataArray
    const selectedCompetition = dataArray[0];
    const participants  = selectedCompetition.participants;
    const organizations = participants.map((participant) => participant.organization);

    // Filter the participants based on the selected criterion
    const filteredParticipants = participants.filter(
        (participant) => participant.scores !== null
    );

    // Extract the scores for the selected criterion and convert them to numbers
    const scoresArrayForCriterion = filteredParticipants.map((participant) =>
        participant.scores[selectedCriterion]
    );

    const overallScores = filteredParticipants.map((participant) => participant.overall_score);
    const labels = filteredParticipants.map((participant) => participant.participant_name);

    // Define an object to map organizations to colors
    const organizationColors = {
        'ACAP': 'rgba(148, 116, 207)',
        'AECES': 'rgba(168, 68, 68)',
        'ELITE': 'rgba(223, 133, 27)',
        'GIVE': 'rgba(115, 169, 204)',
        'JEHRA': 'rgba(211, 182, 146)',
        'JMAP': 'rgba(255, 189, 68)',
        'JPIA': 'rgba(207, 22, 89)',
        'PIIE': 'rgba(22, 186, 157)',
      };

    // Use the organizations array to set colors for the participants in the pie chart
    const backgroundColors = organizations.map((org) => organizationColors[org]);

    var pieChartCanvas = document.getElementById('pieChartCanvas').getContext('2d');

    var pieChart = new Chart(pieChartCanvas, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: overallScores,
                backgroundColor: backgroundColors,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });
}


function updatePieChartByCriterion(criterion, scoresArray) {
    // Find the selected criterion in the dataArray
    const selectedCompetition = dataArray[0];
    const { participants, header: { criterias } } = selectedCompetition;

    // Filter the participants based on the selected criterion
    const filteredParticipants = participants.filter(
        (participant) => participant.scores[criterion] !== null
    );

    // Output participant data and criterion for debugging
    console.log("Selected Criterion: " + criterion);
    console.log("Filtered Participants: ", filteredParticipants);

    // Extract the scores for the selected criterion from the scoresArray
    const scoresArrayForCriterionNumeric = [];

    for (let i = 0; i < filteredParticipants.length; i++) {
        const participant = filteredParticipants[i];
        console.log("Participant: ", participant);
        const scoresForParticipant = scoresArray[i]; // Get the scores array for the participant
        const criterionIndex = criterias.indexOf(criterion); // Get the index of the selected criterion in the criterias array
        const scoreForCriterion = scoresForParticipant[criterionIndex]; // Get the score for the selected criterion using the criterion index
        console.log("Score for Criterion: ", scoreForCriterion);
        scoresArrayForCriterionNumeric.push(parseFloat(scoreForCriterion));
    }

    console.log("Scores Array (after parsing): ", scoresArrayForCriterionNumeric);

    console.log("Selected Criterion: " + criterion);
    console.log("Participants Data: ", participants);

    var labels = filteredParticipants.map(
        (participant) => participant.participant_name
    );

    var pieChart = Chart.instances[0]; // Get the existing pie chart instance
    pieChart.data.labels = labels;
    pieChart.data.datasets[0].data = scoresArrayForCriterionNumeric; // Use the scoresArrayForCriterionNumeric here
    pieChart.update();
}

function updatePieChartOverall(overallScores, participants) {
    // Output participant data and criterion for debugging
    console.log("Selected Criterion: Overall");
    console.log("Participants Data: ", participants);
  
    var labels = participants.map(
      (participant) => participant.participant_name
    );
  
    var pieChart = Chart.instances[0]; // Get the existing pie chart instance
    pieChart.data.labels = labels;
    pieChart.data.datasets[0].data = overallScores; // Use the overall scores array here
    pieChart.update();
  }