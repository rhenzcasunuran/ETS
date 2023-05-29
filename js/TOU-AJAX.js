$(document).ready(function() {
    // Button click event
    $("#nextButton").click(function() {
        $.ajax({
            url: "./js/TOU-getData.php",
            type: "GET",
            success: function(data) {
                $("#text").text(data);
            },
            error: function() {
                console.log("Error occurred while retrieving data.");
            }
        });
    });
});