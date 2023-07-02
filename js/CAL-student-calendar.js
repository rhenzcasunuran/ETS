// Global variables
var currentMonth = new Date().getMonth();
var currentYear = new Date().getFullYear();
var months = [
  "January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

var studentCalendarComputer = {
  initialize: function() {
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

    var filters = ["Tournament", "Competition", "Standard"];
    var filtersOrg = ["SC", "ACAP", "AECES", "ELITE", "GIVE", "JEHRA", "JMAP", "JPIA", "PIIE"];
    
    function generateCalendar(month, year, filters, filtersOrg) {
      // Get number of days in the month and the first day of the month
      var numDays = new Date(year, month + 1, 0).getDate();
      var firstDay = new Date(year, month, 1).getDay();

      // Clear the calendar table
      $("#calendar tbody").empty();

      // Set the calendar title
      $("#calendar-title").html("<strong>" + months[month] + "</strong> " + year);

      $.ajax({
        url: './php/CAL-get-events-calendar.php',
        type: 'GET',
        data: {
            year: year,
            month: month + 1,
            filters: filters,
            filtersOrg: filtersOrg
        },
        success: function(data) {
          var events = JSON.parse(data);
          var eventCounter = {};

          events.sort(function(a, b) {
            var dateA = new Date(a.event_date);
            var dateB = new Date(b.event_date);
            return dateA - dateB;
          });

          // count the number of events for each day
          for (var i = 0; i < events.length; i++) {
            var date = events[i].event_date;
            if (date in eventCounter) {
              eventCounter[date]++;
            } else {
              eventCounter[date] = 1;
            }
          }

          var eventsCounting = 0;

          for(var keys in eventCounter) {
            for(var i = 0; i < eventCounter[keys]; i++) {
              var date = events[eventsCounting].event_date;
              var eventDate = new Date(events[eventsCounting].event_date);
              var eventDay = eventDate.getDate();
              var eventMonth = eventDate.getMonth();
              var currentEventNum = eventCounter[keys];
              var deductedCurrentEventNum = currentEventNum - 1;

              var cell = $("td:not(.disabled)").filter(function() {
                var cellDate = parseInt($(this).text());
                var cellWeek = $(this).closest("tr").index();
                return cellDate === parseInt(eventDay) && cellWeek === Math.floor((parseInt(eventDay) + firstDay - 1) / 7);
              });

              // Check if event is in the same month as the calendar and matches the current day
              if (eventMonth === month && eventDay === parseInt(eventDay)) {
                if (eventCounter[keys] === 3) {
                  var popoverContent = $('<div class="popover-content"></div>');

                  for(var i = 0; i < currentEventNum; i++) {

                    if (i <= 1) {

                      // Create button for the event
                      var button = $('<button type="button" class="btn btn-primary btn-sm calendar-smaller-btn shown-event">')
                        .text(events[eventsCounting].category_name.length > 10 ? events[eventsCounting].category_name.substring(0, 10) + '...' : events[eventsCounting].category_name);

                      // Set data attributes for popper
                      button.attr('data-bs-toggle', 'popover');
                      button.attr('data-bs-content', '<div class="sec-paragraph shown-event-popover">' +
                          '<div class="p4">' +
                          '<a href="javascript:void(0)" class="d-flex justify-content-end close-popover" aria-label="Close">X</a>' +
                          '<h4 class="mb-0"><b>' + events[eventsCounting].category_name + '</b></h4>' +
                          '<p class="mb-0">' + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' }) + '</p>' +
                          '<p>' + events[eventsCounting].event_time + '</p>' +
                          '<div class="d-flex justify-content-between align-items-center">' +
                          '<div class="icon-container">' +
                          (events[eventsCounting].event_type !== 'Standard' && events[eventsCounting].event_type !== 'Competition' && events[eventsCounting].event_type === 'Tournament' ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-sm"></i>' : '') +
                          '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-sm"></i>' +
                          '</div>' +
                          '<a href="#event-modal-' + events[eventsCounting].event_id + '" class="d-flex justify-content-end show-more-details-popover" aria-label="showMoreDetails">Show more details</a>' +
                          '</div>' +
                          '</div>');
                      button.attr('data-bs-html', 'true');

                      // Initialize popover
                      var popoverOptions = {
                        container: 'body',
                        placement: 'auto',
                        trigger: 'click',
                      };
                      button.popover(popoverOptions);

                      // Append button to the element with class '.d-grid'
                      cell.find('.d-grid').append(button);

                      var modal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                      modal.attr('id', 'event-modal-' + events[eventsCounting].event_id);
                      modal.attr('aria-hidden', 'true');
                      modal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">' +
                          "<b>" + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + "</b>" + '</h3></div><div class="modal-body text-center">' +
                          "<br><b>" + events[eventsCounting].category_name + "</b><br>" + "<b>When: </b>" + events[eventsCounting].event_time + "<br>" +
                          (events[eventsCounting].event_org ? "<b>Who: </b>" + "<span class='pill-" + events[eventsCounting].event_org.toLowerCase() + "'>" + events[eventsCounting].event_org + "</span><br>" : "") +
                          "<b>Description: </b>" + events[eventsCounting].event_description + "<br><br>" +
                          '</div><div class="modal-footer border-0">' +
                          (events[eventsCounting].event_type !== 'Standard' && events[eventsCounting].event_type !== 'Competition' && events[eventsCounting].event_type === 'Tournament' ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-lg"></i>' : '') +
                          '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-lg"></i>' +
                          '<button type="button" class="outline-button ms-auto" id="back-button" data-bs-dismiss="modal">Back</button></div></div></div>');
                      
                      // Append modal to body
                      $('body').append(modal);

                      // Delegate click event for "Show more details" text within the popover
                      $(document).on("click", ".show-more-details-popover", function() {
                        var modalId = $(this).attr('href');
                        $(modalId).modal('show');
                        $(this).closest('.popover').popover('hide');
                      });

                      if (events[eventsCounting].event_type !== "Standard" && events[eventsCounting].event_type !== "Competition" && events[eventsCounting].event_type === "Tournament") {

                        // Create the tournament modal
                        var tournamentModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                        tournamentModal.attr('id', 'tournament-modal-' + events[eventsCounting].event_id);
                        tournamentModal.attr('aria-hidden', 'true');
                        tournamentModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Tournament Modal Title</h3></div><div class="modal-body text-center"><img src="./pictures/sampleTournamentBraket.png" alt="TournamentBracket"></div><div class="modal-footer border-0"><button type="button" class="outline-button ms-auto" id="back-button" data-bs-dismiss="modal">Back</button></div></div></div>');
                        
                        // Append the tournament modal to the body
                        $('body').append(tournamentModal);

                        // Event handler for the unique icon click event
                        $(document).on("click", '.bx-group', function() {
                          var eventId = $(this).attr('id');
                          $('#tournament-modal-' + eventId).modal('show');
                          $(this).closest('.popover').popover('hide');
                        });
                      }

                      // Create the addToCalendar modal
                      var addToCalendarModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                      addToCalendarModal.attr('id', 'add-to-calendar-modal-' + events[eventsCounting].event_id);
                      addToCalendarModal.attr('aria-hidden', 'true');
                      addToCalendarModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Add Event To Date</h3></div><div class="modal-body text-center"><p>Do you wish to add the event to your calendar</p><br><div class="d-flex justify-content-evenly"><button class="outline-button" id="authorize_button" onclick="handleAuthClick(\'' + events[eventsCounting].event_date + '\', \'' + events[eventsCounting].category_name.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_description.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_time + '\')">Yes</button><button type="button" class="outline-button" id="no-button" data-bs-dismiss="modal">No</button></div></div>');
                      
                      // Append the addToCalendarModal to the body
                      $('body').append(addToCalendarModal);

                      // Event handler for the unique icon click event
                      $(document).on("click", '.bx-calendar-plus', function() {
                        var eventId = $(this).attr('id');
                        $('#add-to-calendar-modal-' + eventId).modal('show');
                        $(this).closest('.popover').popover('hide');
                      });

                      eventsCounting++;
                    } 
                    else {

                      // Create button for the event
                      var button = $('<button type="button" class="btn btn-primary btn-sm calendar-smaller-btn remaining-event">')
                      .text(events[eventsCounting].category_name.length > 10 ? events[eventsCounting].category_name.substring(0, 10) + '...' : events[eventsCounting].category_name);

                      // Set data attributes for popper
                      button.attr('data-bs-toggle', 'popover');
                      button.attr('data-bs-content', '<div class="sec-paragraph shown-event-popover">' +
                          '<div class="p4">' +
                          '<a href="javascript:void(0)" class="d-flex justify-content-end close-popover" aria-label="Close">X</a>' +
                          '<h4 class="mb-0"><b>' + events[eventsCounting].category_name + '</b></h4>' +
                          '<p class="mb-0">' + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' }) + '</p>' +
                          '<p>' + events[eventsCounting].event_time + '</p>' +
                          '<div class="d-flex justify-content-between align-items-center">' +
                          '<div class="icon-container">' +
                          (events[eventsCounting].event_type !== 'Standard' && events[eventsCounting].event_type !== 'Competition' && events[eventsCounting].event_type === 'Tournament' ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-sm"></i>' : '') +
                          '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-sm"></i>' +
                          '</div>' +
                          '<a href="#event-modal-' + events[eventsCounting].event_id + '" class="d-flex justify-content-end show-more-details-popover" aria-label="showMoreDetails">Show more details</a>' +
                          '</div>' +
                          '</div>');
                      button.attr('data-bs-html', 'true');

                      // Initialize popover
                      var popoverOptions = {
                      container: 'body',
                      placement: 'auto',
                      trigger: 'click',
                      };
                      button.popover(popoverOptions);

                      // Append button to the element with class '.d-grid'
                      cell.find('.d-grid').append(button);

                      var modal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                      modal.attr('id', 'event-modal-' + events[eventsCounting].event_id);
                      modal.attr('aria-hidden', 'true');
                      modal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">' +
                          "<b>" + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + "</b>" + '</h3></div><div class="modal-body text-center">' +
                          "<br><b>" + events[eventsCounting].category_name + "</b><br>" + "<b>When: </b>" + events[eventsCounting].event_time + "<br>" +
                          (events[eventsCounting].event_org ? "<b>Who: </b>" + "<span class='pill-" + events[eventsCounting].event_org.toLowerCase() + "'>" + events[eventsCounting].event_org + "</span><br>" : "") +
                          "<b>Description: </b>" + events[eventsCounting].event_description + "<br><br>" +
                          '</div><div class="modal-footer border-0">' +
                          (events[eventsCounting].event_type !== 'Standard' && events[eventsCounting].event_type !== 'Competition' && events[eventsCounting].event_type === 'Tournament' ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-lg"></i>' : '') +
                          '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-lg"></i>' +
                          '<button type="button" class="outline-button ms-auto" id="back-button" data-bs-dismiss="modal">Back</button></div></div></div>');
                      
                      // Append modal to body
                      $('body').append(modal);

                      // Delegate click event for "Show more details" text within the popover
                      $(document).on("click", ".show-more-details-popover", function() {
                      var modalId = $(this).attr('href');
                        $(modalId).modal('show');
                        $(this).closest('.popover').popover('hide');
                      });

                      if (events[eventsCounting].event_type !== "Standard" && events[eventsCounting].event_type !== "Competition" && events[eventsCounting].event_type === "Tournament") {

                        // Create the tournament modal
                        var tournamentModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                        tournamentModal.attr('id', 'tournament-modal-' + events[eventsCounting].event_id);
                        tournamentModal.attr('aria-hidden', 'true');
                        tournamentModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Tournament Modal Title</h3></div><div class="modal-body text-center"><img src="./pictures/sampleTournamentBraket.png" alt="TournamentBracket"></div><div class="modal-footer border-0"><button type="button" class="outline-button ms-auto" id="back-button" data-bs-dismiss="modal">Back</button></div></div></div>');
                      
                        // Append the tournament modal to the body
                        $('body').append(tournamentModal);

                        // Event handler for the unique icon click event
                        $(document).on("click", '.bx-group', function() {
                        var eventId = $(this).attr('id');
                        $('#tournament-modal-' + eventId).modal('show');
                        $(this).closest('.popover').popover('hide');
                        });
                      }

                      // Create the addToCalendar modal
                      var addToCalendarModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                      addToCalendarModal.attr('id', 'add-to-calendar-modal-' + events[eventsCounting].event_id);
                      addToCalendarModal.attr('aria-hidden', 'true');
                      addToCalendarModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Add Event To Date</h3></div><div class="modal-body text-center"><p>Do you wish to add the event to your calendar</p><br><div class="d-flex justify-content-evenly"><button class="outline-button" id="authorize_button" onclick="handleAuthClick(\'' + events[eventsCounting].event_date + '\', \'' + events[eventsCounting].category_name.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_description.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_time + '\')">Yes</button><button type="button" class="outline-button" id="no-button" data-bs-dismiss="modal">No</button></div></div>');
                      
                      // Append the addToCalendarModal to the body
                      $('body').append(addToCalendarModal);

                      // Event handler for the unique icon click event
                      $(document).on("click", '.bx-calendar-plus', function() {
                        var eventId = $(this).attr('id');
                        $('#add-to-calendar-modal-' + eventId).modal('show');
                        $(this).closest('.popover').popover('hide');
                      });                      

                      popoverContent.append(button);

                      if (i === deductedCurrentEventNum) {
                        
                        var remainingButton = $('<a tabindex="0" class="btn btn-secondary btn-sm calendar-smaller-btn" data-bs-toggle="popover" data-bs-custom-class="custom-popover">').text('+' + (currentEventNum - 2) + ' more');
                        remainingButton.popover({
                          placement: 'auto',
                          html: true,
                          content: popoverContent.prop('outerHTML'),
                          sanitize: false
                        });
                        cell.find('.d-grid').append(remainingButton);
                      }
                      eventsCounting++;
                    }
                  }

                } else if (eventCounter[keys] <= 2) {

                  // Create button for the event
                  var button = $('<button type="button" class="btn btn-primary btn-sm calendar-smaller-btn shown-event">')
                    .text(events[eventsCounting].category_name.length > 10 ? events[eventsCounting].category_name.substring(0, 10) + '...' : events[eventsCounting].category_name);

                  // Set data attributes for popper
                  button.attr('data-bs-toggle', 'popover');
                  button.attr('data-bs-content', '<div class="sec-paragraph shown-event-popover">' +
                      '<div class="p4">' +
                      '<a href="javascript:void(0)" class="d-flex justify-content-end close-popover" aria-label="Close">X</a>' +
                      '<h4 class="mb-0"><b>' + events[eventsCounting].category_name + '</b></h4>' +
                      '<p class="mb-0">' + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' }) + '</p>' +
                      '<p>' + events[eventsCounting].event_time + '</p>' +
                      '<div class="d-flex justify-content-between align-items-center">' +
                      '<div class="icon-container">' +
                      (events[eventsCounting].event_type !== 'Standard' && events[eventsCounting].event_type !== 'Competition' && events[eventsCounting].event_type === 'Tournament' ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-sm"></i>' : '') +
                      '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-sm"></i>' +
                      '</div>' +
                      '<a href="#event-modal-' + events[eventsCounting].event_id + '" class="d-flex justify-content-end show-more-details-popover" aria-label="showMoreDetails">Show more details</a>' +
                      '</div>' +
                      '</div>');
                  button.attr('data-bs-html', 'true');

                  // Initialize popover
                  var popoverOptions = {
                    container: 'body',
                    placement: 'auto',
                    trigger: 'click',
                  };
                  button.popover(popoverOptions);

                  // Append button to the element with class '.d-grid'
                  cell.find('.d-grid').append(button);

                  var modal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                      modal.attr('id', 'event-modal-' + events[eventsCounting].event_id);
                      modal.attr('aria-hidden', 'true');
                      modal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">' +
                          "<b>" + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + "</b>" + '</h3></div><div class="modal-body text-center">' +
                          "<br><b>" + events[eventsCounting].category_name + "</b><br>" + "<b>When: </b>" + events[eventsCounting].event_time + "<br>" +
                          (events[eventsCounting].event_org ? "<b>Who: </b>" + "<span class='pill-" + events[eventsCounting].event_org.toLowerCase() + "'>" + events[eventsCounting].event_org + "</span><br>" : "") +
                          "<b>Description: </b>" + events[eventsCounting].event_description + "<br><br>" +
                          '</div><div class="modal-footer border-0">' +
                          (events[eventsCounting].event_type !== 'Standard' && events[eventsCounting].event_type !== 'Competition' && events[eventsCounting].event_type === 'Tournament' ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-lg"></i>' : '') +
                          '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-lg"></i>' +
                          '<button type="button" class="outline-button ms-auto" id="back-button" data-bs-dismiss="modal">Back</button></div></div></div>');
                      
                  // Append modal to body
                  $('body').append(modal);

                  // Delegate click event for "Show more details" text within the popover
                  $(document).on("click", ".show-more-details-popover", function() {
                    var modalId = $(this).attr('href');
                    $(modalId).modal('show');
                    $(this).closest('.popover').popover('hide');
                  });

                  if (events[eventsCounting].event_type !== "Standard" && events[eventsCounting].event_type !== "Competition" && events[eventsCounting].event_type === "Tournament") {
                    // Create the tournament modal
                    var tournamentModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                    tournamentModal.attr('id', 'tournament-modal-' + events[eventsCounting].event_id);
                    tournamentModal.attr('aria-hidden', 'true');
                    tournamentModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Tournament Modal Title</h3></div><div class="modal-body text-center"><img src="./pictures/sampleTournamentBraket.png" alt="TournamentBracket"></div><div class="modal-footer border-0"><button type="button" class="outline-button ms-auto" id="back-button" data-bs-dismiss="modal">Back</button></div></div></div>');
                  
                    // Append the tournament modal to the body
                    $('body').append(tournamentModal);

                    // Event handler for the unique icon click event
                    $(document).on("click", '.bx-group', function() {
                      var eventId = $(this).attr('id');
                      $('#tournament-modal-' + eventId).modal('show');
                      $(this).closest('.popover').popover('hide');
                    });
                  }

                  // Create the addToCalendar modal
                  var addToCalendarModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                  addToCalendarModal.attr('id', 'add-to-calendar-modal-' + events[eventsCounting].event_id);
                  addToCalendarModal.attr('aria-hidden', 'true');
                  addToCalendarModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Add Event To Date</h3></div><div class="modal-body text-center"><p>Do you wish to add the event to your calendar</p><br><div class="d-flex justify-content-evenly"><button class="outline-button" id="authorize_button" onclick="handleAuthClick(\'' + events[eventsCounting].event_date + '\', \'' + events[eventsCounting].category_name.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_description.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_time + '\')">Yes</button><button type="button" class="outline-button" id="no-button" data-bs-dismiss="modal">No</button></div></div>');
                 
                  // Append the addToCalendarModal to the body
                  $('body').append(addToCalendarModal);

                  // Event handler for the unique icon click event
                  $(document).on("click", '.bx-calendar-plus', function() {
                    var eventId = $(this).attr('id');
                    $('#add-to-calendar-modal-' + eventId).modal('show');
                    $(this).closest('.popover').popover('hide');
                  });                  

                  eventsCounting++;

                } else {

                  var popoverContent = $('<div class="popover-content"></div>');

                  for(var i = 0; i < currentEventNum; i++) {

                    if (i <= 1) {

                      // Create button for the event
                      var button = $('<button type="button" class="btn btn-primary btn-sm calendar-smaller-btn shown-event">')
                        .text(events[eventsCounting].category_name.length > 10 ? events[eventsCounting].category_name.substring(0, 10) + '...' : events[eventsCounting].category_name);

                      // Set data attributes for popper
                      button.attr('data-bs-toggle', 'popover');
                      button.attr('data-bs-content', '<div class="sec-paragraph shown-event-popover">' +
                          '<div class="p4">' +
                          '<a href="javascript:void(0)" class="d-flex justify-content-end close-popover" aria-label="Close">X</a>' +
                          '<h4 class="mb-0"><b>' + events[eventsCounting].category_name + '</b></h4>' +
                          '<p class="mb-0">' + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' }) + '</p>' +
                          '<p>' + events[eventsCounting].event_time + '</p>' +
                          '<div class="d-flex justify-content-between align-items-center">' +
                          '<div class="icon-container">' +
                          (events[eventsCounting].event_type !== 'Standard' && events[eventsCounting].event_type !== 'Competition' && events[eventsCounting].event_type === 'Tournament' ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-sm"></i>' : '') +
                          '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-sm"></i>' +
                          '</div>' +
                          '<a href="#event-modal-' + events[eventsCounting].event_id + '" class="d-flex justify-content-end show-more-details-popover" aria-label="showMoreDetails">Show more details</a>' +
                          '</div>' +
                          '</div>');
                      button.attr('data-bs-html', 'true');

                      // Initialize popover
                      var popoverOptions = {
                        container: 'body',
                        placement: 'auto',
                        trigger: 'click',
                      };
                      button.popover(popoverOptions);

                      // Append button to the element with class '.d-grid'
                      cell.find('.d-grid').append(button);

                      var modal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                      modal.attr('id', 'event-modal-' + events[eventsCounting].event_id);
                      modal.attr('aria-hidden', 'true');
                      modal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">' +
                          "<b>" + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + "</b>" + '</h3></div><div class="modal-body text-center">' +
                          "<br><b>" + events[eventsCounting].category_name + "</b><br>" + "<b>When: </b>" + events[eventsCounting].event_time + "<br>" +
                          (events[eventsCounting].event_org ? "<b>Who: </b>" + "<span class='pill-" + events[eventsCounting].event_org.toLowerCase() + "'>" + events[eventsCounting].event_org + "</span><br>" : "") +
                          "<b>Description: </b>" + events[eventsCounting].event_description + "<br><br>" +
                          '</div><div class="modal-footer border-0">' +
                          (events[eventsCounting].event_type !== 'Standard' && events[eventsCounting].event_type !== 'Competition' && events[eventsCounting].event_type === 'Tournament' ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-lg"></i>' : '') +
                          '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-lg"></i>' +
                          '<button type="button" class="outline-button ms-auto" id="back-button" data-bs-dismiss="modal">Back</button></div></div></div>');
                      
                      // Append modal to body
                      $('body').append(modal);

                      // Delegate click event for "Show more details" text within the popover
                      $(document).on("click", ".show-more-details-popover", function() {
                        var modalId = $(this).attr('href');
                        $(modalId).modal('show');
                        $(this).closest('.popover').popover('hide');
                      });

                      if (events[eventsCounting].event_type !== "Standard" && events[eventsCounting].event_type !== "Competition" && events[eventsCounting].event_type === "Tournament") {
                        // Create the tournament modal
                        var tournamentModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                        tournamentModal.attr('id', 'tournament-modal-' + events[eventsCounting].event_id);
                        tournamentModal.attr('aria-hidden', 'true');
                        tournamentModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Tournament Modal Title</h3></div><div class="modal-body text-center"><img src="./pictures/sampleTournamentBraket.png" alt="TournamentBracket"></div><div class="modal-footer border-0"><button type="button" class="outline-button ms-auto" id="back-button" data-bs-dismiss="modal">Back</button></div></div></div>');
                      
                        // Append the tournament modal to the body
                        $('body').append(tournamentModal);

                        // Event handler for the unique icon click event
                        $(document).on("click", '.bx-group', function() {
                          var eventId = $(this).attr('id');
                          $('#tournament-modal-' + eventId).modal('show');
                          $(this).closest('.popover').popover('hide');
                        });
                      }

                      // Create the addToCalendar modal
                      var addToCalendarModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                      addToCalendarModal.attr('id', 'add-to-calendar-modal-' + events[eventsCounting].event_id);
                      addToCalendarModal.attr('aria-hidden', 'true');
                      addToCalendarModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Add Event To Date</h3></div><div class="modal-body text-center"><p>Do you wish to add the event to your calendar</p><br><div class="d-flex justify-content-evenly"><button class="outline-button" id="authorize_button" onclick="handleAuthClick(\'' + events[eventsCounting].event_date + '\', \'' + events[eventsCounting].category_name.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_description.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_time + '\')">Yes</button><button type="button" class="outline-button" id="no-button" data-bs-dismiss="modal">No</button></div></div>');
                      // Append the addToCalendarModal to the body
                      $('body').append(addToCalendarModal);

                      // Event handler for the unique icon click event
                      $(document).on("click", '.bx-calendar-plus', function() {
                        var eventId = $(this).attr('id');
                        $('#add-to-calendar-modal-' + eventId).modal('show');
                        $(this).closest('.popover').popover('hide');
                      });                      

                      eventsCounting++;
                    } 
                    else {

                      // Create button for the event
                      var button = $('<button type="button" class="btn btn-primary btn-sm calendar-smaller-btn remaining-event">')
                      .text(events[eventsCounting].category_name.length > 10 ? events[eventsCounting].category_name.substring(0, 10) + '...' : events[eventsCounting].category_name);

                      // Set data attributes for popper
                      button.attr('data-bs-toggle', 'popover');
                      button.attr('data-bs-content', '<div class="sec-paragraph shown-event-popover">' +
                          '<div class="p4">' +
                          '<a href="javascript:void(0)" class="d-flex justify-content-end close-popover" aria-label="Close">X</a>' +
                          '<h4 class="mb-0"><b>' + events[eventsCounting].category_name + '</b></h4>' +
                          '<p class="mb-0">' + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' }) + '</p>' +
                          '<p>' + events[eventsCounting].event_time + '</p>' +
                          '<div class="d-flex justify-content-between align-items-center">' +
                          '<div class="icon-container">' +
                          (events[eventsCounting].event_type !== 'Standard' && events[eventsCounting].event_type !== 'Competition' && events[eventsCounting].event_type === 'Tournament' ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-sm"></i>' : '') +
                          '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-sm"></i>' +
                          '</div>' +
                          '<a href="#event-modal-' + events[eventsCounting].event_id + '" class="d-flex justify-content-end show-more-details-popover" aria-label="showMoreDetails">Show more details</a>' +
                          '</div>' +
                          '</div>');
                      button.attr('data-bs-html', 'true');

                      // Initialize popover
                      var popoverOptions = {
                      container: 'body',
                      placement: 'auto',
                      trigger: 'click',
                      };
                      button.popover(popoverOptions);

                      // Append button to the element with class '.d-grid'
                      cell.find('.d-grid').append(button);

                      var modal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                      modal.attr('id', 'event-modal-' + events[eventsCounting].event_id);
                      modal.attr('aria-hidden', 'true');
                      modal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">' +
                          "<b>" + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + "</b>" + '</h3></div><div class="modal-body text-center">' +
                          "<br><b>" + events[eventsCounting].category_name + "</b><br>" + "<b>When: </b>" + events[eventsCounting].event_time + "<br>" +
                          (events[eventsCounting].event_org ? "<b>Who: </b>" + "<span class='pill-" + events[eventsCounting].event_org.toLowerCase() + "'>" + events[eventsCounting].event_org + "</span><br>" : "") +
                          "<b>Description: </b>" + events[eventsCounting].event_description + "<br><br>" +
                          '</div><div class="modal-footer border-0">' +
                          (events[eventsCounting].event_type !== 'Standard' && events[eventsCounting].event_type !== 'Competition' && events[eventsCounting].event_type === 'Tournament' ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-lg"></i>' : '') +
                          '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-lg"></i>' +
                          '<button type="button" class="outline-button ms-auto" id="back-button" data-bs-dismiss="modal">Back</button></div></div></div>');
                      
                      // Append modal to body
                      $('body').append(modal);

                      // Delegate click event for "Show more details" text within the popover
                      $(document).on("click", ".show-more-details-popover", function() {
                      var modalId = $(this).attr('href');
                      $(modalId).modal('show');
                      $(this).closest('.popover').popover('hide');
                      });

                      if (events[eventsCounting].event_type !== "Standard" && events[eventsCounting].event_type !== "Competition" && events[eventsCounting].event_type === "Tournament") {
                        // Create the tournament modal
                        var tournamentModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                        tournamentModal.attr('id', 'tournament-modal-' + events[eventsCounting].event_id);
                        tournamentModal.attr('aria-hidden', 'true');
                        tournamentModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Tournament Modal Title</h3></div><div class="modal-body text-center"><img src="./pictures/sampleTournamentBraket.png" alt="TournamentBracket"></div><div class="modal-footer border-0"><button type="button" class="outline-button ms-auto" id="back-button" data-bs-dismiss="modal">Back</button></div></div></div>');
                      
                        // Append the tournament modal to the body
                        $('body').append(tournamentModal);

                        // Event handler for the unique icon click event
                        $(document).on("click", '.bx-group', function() {
                        var eventId = $(this).attr('id');
                        $('#tournament-modal-' + eventId).modal('show');
                        $(this).closest('.popover').popover('hide');
                        });
                      }

                      // Create the addToCalendar modal
                      var addToCalendarModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                      addToCalendarModal.attr('id', 'add-to-calendar-modal-' + events[eventsCounting].event_id);
                      addToCalendarModal.attr('aria-hidden', 'true');
                      addToCalendarModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Add Event To Date</h3></div><div class="modal-body text-center"><p>Do you wish to add the event to your calendar</p><br><div class="d-flex justify-content-evenly"><button class="outline-button" id="authorize_button" onclick="handleAuthClick(\'' + events[eventsCounting].event_date + '\', \'' + events[eventsCounting].category_name.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_description.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_time + '\')">Yes</button><button type="button" class="outline-button" id="no-button" data-bs-dismiss="modal">No</button></div></div>');

                      // Append the addToCalendarModal to the body
                      $('body').append(addToCalendarModal);

                      // Event handler for the unique icon click event
                      $(document).on("click", '.bx-calendar-plus', function() {
                        var eventId = $(this).attr('id');
                        $('#add-to-calendar-modal-' + eventId).modal('show');
                        $(this).closest('.popover').popover('hide');
                      });               

                      popoverContent.append(button);

                      if (i === deductedCurrentEventNum) {
                        
                        var remainingButton = $('<a tabindex="0" class="btn btn-secondary btn-sm calendar-smaller-btn" data-bs-toggle="popover" data-bs-custom-class="custom-popover">').text('+' + (currentEventNum - 2) + ' more');
                        remainingButton.popover({
                          placement: 'auto',
                          html: true,
                          content: popoverContent.prop('outerHTML'),
                          sanitize: false
                        });
                        cell.find('.d-grid').append(remainingButton);
                      }
                      eventsCounting++;
                    }
                  }
                }
              }
            }
          }
      },
        error: function(error) {
            console.error('Error: ' + error.message);
        }
      });

    var currentDate = new Date();  // Get the current date
    var currentDay = currentDate.getDate();  // Get the day of the current date
    var currentMonth = currentDate.getMonth();  // Get the month of the current date
    var currentYear = currentDate.getFullYear();  // Get the year of the current date

    // Generate calendar days
    var date = 1;
    for (var i = 0; i < 6; i++) {
      var row = $('<tr>').addClass("calendar-rounded-cell");
      for (var j = 0; j < 7; j++) {
        var cell = $('<td>').addClass("calendar-rounded-cell");
        if (i === 0 && j < firstDay) {
          // Cell is before the first day of the month
          cell.addClass("disabled");
        } else {
          // Cell is a valid day of the month or after the last day of the month
          if (date <= numDays) {
            // Cell is a valid day of the month
            var div = $('<div>').addClass("d-grid gap-1 mx-auto");
            var dateText = $('<span>').text(date);
            div.append(dateText);
            // Add a light-colored circle for the current date
            if (year === currentYear && month === currentMonth && date === currentDay) {
              dateText.addClass('current-date');
            }
            cell.append(div);
            date++;
          } else {
            // Cell is after the last day of the month
            cell.addClass("disabled");
          }
        }
        row.append(cell);
      }
        $("#calendar tbody").append(row);
      }
    }

    // Generate calendar for current month and year
    generateCalendar(currentMonth, currentYear, filters, filtersOrg); 
    generateMiniCalendar(currentMonth, currentYear, filters, filtersOrg);

    var prevMonthInterval;
    var nextMonthInterval;

    $("#prev-month").mousedown(function() {
      $('[data-bs-toggle="popover"]').not(this).popover('hide');
      currentMonth--;
      if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
      }
      generateCalendar(currentMonth, currentYear, filters, filtersOrg);
      generateMiniCalendar(currentMonth, currentYear, filters, filtersOrg);

      prevMonthInterval = setInterval(function() {
        currentMonth--;
        if (currentMonth < 0) {
          currentMonth = 11;
          currentYear--;
        }
        generateCalendar(currentMonth, currentYear, filters, filtersOrg);
        generateMiniCalendar(currentMonth, currentYear, filters, filtersOrg);
      }, 100); // Adjust the interval time (in milliseconds) for the desired scrolling speed
    }).mouseup(function() {
      clearInterval(prevMonthInterval);
    }).mouseleave(function() {
      clearInterval(prevMonthInterval);
    });

    $("#next-month").mousedown(function() {
      $('[data-bs-toggle="popover"]').not(this).popover('hide');
      currentMonth++;
      if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
      }
      generateCalendar(currentMonth, currentYear, filters, filtersOrg);
      generateMiniCalendar(currentMonth, currentYear, filters, filtersOrg);

      nextMonthInterval = setInterval(function() {
        currentMonth++;
        if (currentMonth > 11) {
          currentMonth = 0;
          currentYear++;
        }
        generateCalendar(currentMonth, currentYear, filters, filtersOrg);
        generateMiniCalendar(currentMonth, currentYear, filters, filtersOrg);
      }, 100); // Adjust the interval time (in milliseconds) for the desired scrolling speed
    }).mouseup(function() {
      clearInterval(nextMonthInterval);
    }).mouseleave(function() {
      clearInterval(nextMonthInterval);
    });

        // Mini Calendar
    // Get the miniCalendarToggle and miniCalendarContainer elements
    const miniCalendarToggle = document.getElementById('miniCalendarToggle');
    const miniCalendarContainer = document.getElementById('miniCalendarContainer');

    // Add click event listener to the miniCalendarToggle element
    miniCalendarToggle.addEventListener('click', (event) => {
      $('[data-bs-toggle="popover"]').not(this).popover('hide');
      event.stopPropagation(); // Prevent the click event from bubbling up to the document
      toggleMiniCalendar();
    });

    // Add a click event listener to the document object
    document.addEventListener('click', (event) => {
      const targetElement = event.target;
      const isInsideContainer = miniCalendarContainer.contains(targetElement);

      // If the clicked element is not inside the miniCalendarContainer, hide the container
      if (!isInsideContainer) {
        miniCalendarContainer.style.display = 'none';
      }
    });

    // Function to toggle the visibility of the miniCalendarContainer
    function toggleMiniCalendar() {
      if (miniCalendarContainer.style.display === 'none') {
        miniCalendarContainer.style.display = 'block';
      } else {
        miniCalendarContainer.style.display = 'none';
      }
    } 

    var cellClicked = null;

    function generateMiniCalendar(month, year, filters, filtersOrg) {
      // Get number of days in the month and the first day of the month
      let numDays = new Date(year, month + 1, 0).getDate();
      let firstDay = new Date(year, month, 1).getDay();

      // Clear the calendar table
      let calendarBody = document.getElementById("miniCalendarTable");
      calendarBody.innerHTML = "";

      let currentDate = new Date(); // Get the current date
      let currentDay = currentDate.getDate(); // Get the day of the current date
      let currentMonth = currentDate.getMonth(); // Get the month of the current date

      // Set the calendar title
      let currentMonthYear = document.getElementById("miniCalendarHeader");
      currentMonthYear.innerHTML =
        "<div class='miniCalendarMonthYear' id='place-default'>" +
        "<strong>" +
        months[month] +
        "</strong> " +
        year +
        "</div>";

      // Function to generate the calendar days
      function generateCalendarDays() {
        let date = 1;
        for (let i = 0; i < 6; i++) {
          let row = document.createElement("tr");
          for (let j = 0; j < 7; j++) {
            let cell = document.createElement("td");
            if (i === 0 && j < firstDay) {
              // Cell is before the first day of the month
              cell.classList.add("mini-disabled");
            } else {
              // Cell is a valid day of the month or after the last day of the month
              if (date <= numDays) {
                let div = document.createElement("div");
                let dateText = document.createElement("span");
                dateText.innerHTML = date;
                div.appendChild(dateText);
                // Add a light-colored circle for the current date
                if (year === currentYear && month === currentMonth && date === currentDay) {
                  cell.classList.add("mini-active-today");
                }
                if (cellClicked !== null && date === cellClicked) {
                  // Add the 'mini-active' class to the clicked cell
                  cell.classList.add("mini-active");
                }
                cell.appendChild(div);
                date++;
              } else {
                // Cell is after the last day of the month
                cell.classList.add("mini-disabled");
              }
            }
            row.appendChild(cell);
          }
          calendarBody.appendChild(row);
        }

        // Add click event listener to each cell
        const cells = document.querySelectorAll("#miniCalendarTable td");
        cells.forEach((cell) => {
          cell.addEventListener("click", function (event) {
            const clickedCell = event.target.closest("td"); // Get the closest ancestor <td> element

            // Check if the clicked cell has the "disabled" class
            if (!clickedCell.classList.contains("mini-disabled")) {
              
              // Get the clicked date from the cell's text content
              const clickedDate = parseInt(clickedCell.textContent);

              // Set the calendar title
              currentMonthYear.innerHTML =
                "<div class='miniCalendarMonthYear' id='place-default'>" +
                "<strong>" +
                months[month] +
                "</strong> " +
                year +
                "</div>";

              cellClicked = clickedDate;
              generateCalendar(month, year, filters, filtersOrg);
              generateMiniCalendar(month, year, filters, filtersOrg);
            }
          });
        });
      }

      // Generate the calendar days
      generateCalendarDays();

      // Clear the calendar table
      let miniCalendarMonthYear = document.getElementById("place-default");
      let miniCalendarTable = document.getElementById("miniCalendarTable");
      let miniCalendarThead = document.getElementById("miniCalendarThead");
      let miniCalendarYearsTable = document.getElementById("miniCalendarYearsTable");
      miniCalendarYearsTable.innerHTML = "";

      // Define the number of rows and columns for the years table
      let numRows = 4;
      let numCols = 4;

      // Get the reference to the miniCalendarYearsTable tbody element
      let yearsTableBody = document.getElementById("miniCalendarYearsTable");

      // Hide the years table tbody element
      yearsTableBody.style.display = "none";

      // Define the current start year for the years table
      let startYear = currentYear;

      // Function to generate the years table
      function generateYearsTable() {
        // Clear the years table
        yearsTableBody.innerHTML = "";

        // Loop to generate the rows and columns for the years table
        for (let i = 0; i < numRows; i++) {
          // Create a new table row
          let row = document.createElement("tr");

          for (let j = 0; j < numCols; j++) {
            // Create a new table cell (td) element
            let cell = document.createElement("td");

            // Calculate the year for the current cell
            let year = startYear + i * numCols + j;

            // Set the year as the cell content
            cell.textContent = year;

            // Add a click event listener to the cell
            cell.addEventListener("click", function() {
              currentYear = year;
              miniCalendarYearsTable.style.display = "none";
              miniCalendarTable.style.display = "";
              miniCalendarThead.style.display = "";
              miniButtonYearsContainer.style.display = "none"; // Hide the miniButtonYearsContainer
              miniButtonContainer.style.display = ""; // Show the miniButtonContainer
              generateCalendar(month, year, filters, filtersOrg);
              generateMiniCalendar(month, year, filters, filtersOrg);
            });

            // Append the cell to the current row
            row.appendChild(cell);
          }

          // Append the row to the years table body
          yearsTableBody.appendChild(row);
        }
      }

      // Generate the initial years table
      generateYearsTable();

      // Function to update the years table
      function updateYearsTable(offset) {
        // Calculate the new start year based on the offset
        startYear += offset;

        // Generate the updated years table
        generateYearsTable();
      }

      // Add a click event listener to the miniPreviousYearsButton
      document.getElementById("miniPreviousYearsButton").addEventListener("click", function() {
        updateYearsTable(-numRows * numCols);
      });

      // Add a click event listener to the miniNextYearsButton
      document.getElementById("miniNextYearsButton").addEventListener("click", function() {
        updateYearsTable(numRows * numCols);
      });

      // Add a click event listener to the miniCalendarMonthYear element
      miniCalendarMonthYear.addEventListener("click", function() {
        // Get the current ID
        let currentId = miniCalendarMonthYear.getAttribute("id");

        // Determine the new ID based on the current ID
        let newId = (currentId === "place-default") ? "place-year" : "place-default";

        // Set the new ID
        miniCalendarMonthYear.setAttribute("id", newId);

        // Show/hide elements based on the new ID
        if (newId === "place-year") {
          miniCalendarYearsTable.style.display = "";
          miniCalendarTable.style.display = "none";
          miniCalendarThead.style.display = "none";
          miniButtonYearsContainer.style.display = ""; // Show the miniButtonYearsContainer
          miniButtonContainer.style.display = "none"; // Hide the miniButtonContainer
        } else {
          miniCalendarYearsTable.style.display = "none";
          miniCalendarTable.style.display = "";
          miniCalendarThead.style.display = "";
          miniButtonYearsContainer.style.display = "none"; // Hide the miniButtonYearsContainer
          miniButtonContainer.style.display = ""; // Show the miniButtonContainer
        }
      });

      // Ensure that the table and thead are always shown by default
      miniCalendarYearsTable.style.display = "none";
      miniCalendarTable.style.display = "";
      miniCalendarThead.style.display = "";
      miniButtonYearsContainer.style.display = "none"; // Hide the miniButtonYearsContainer
      miniButtonContainer.style.display = ""; // Show the miniButtonContainer
    } 

    // Close button click event
    $("#closeButton").click(function() {
      $("#miniCalendarContainer").hide();
    });

    // Today button click event
    $("#todayButton").click(function() {
      var currentDate = new Date();
      currentMonth = currentDate.getMonth();
      currentYear = currentDate.getFullYear();
      cellClicked = null;

      generateCalendar(currentMonth, currentYear, filters, filtersOrg);
      generateMiniCalendar(currentMonth, currentYear, filters, filtersOrg);
    });

    $("#miniPreviousButton").mousedown(function() {
      $('[data-bs-toggle="popover"]').not(this).popover('hide');   
       
      currentMonth--;
      if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
      }
      generateCalendar(currentMonth, currentYear, filters, filtersOrg);
      generateMiniCalendar(currentMonth, currentYear, filters, filtersOrg);

      prevMonthInterval = setInterval(function() {
        currentMonth--;
        if (currentMonth < 0) {
          currentMonth = 11;
          currentYear--;
        }
        generateCalendar(currentMonth, currentYear, filters, filtersOrg);
        generateMiniCalendar(currentMonth, currentYear, filters, filtersOrg);

      }, 100); // Adjust the interval time (in milliseconds) for the desired scrolling speed
    }).mouseup(function() {
      clearInterval(prevMonthInterval);
    }).mouseleave(function() {
      clearInterval(prevMonthInterval);
    });

    $("#miniNextButton").mousedown(function() {
      $('[data-bs-toggle="popover"]').not(this).popover('hide');
      currentMonth++;
      if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
      }
      generateCalendar(currentMonth, currentYear, filters, filtersOrg);
      generateMiniCalendar(currentMonth, currentYear, filters, filtersOrg);

      nextMonthInterval = setInterval(function() {
        currentMonth++;
        if (currentMonth > 11) {
          currentMonth = 0;
          currentYear++;
        }
        generateCalendar(currentMonth, currentYear, filters, filtersOrg);
        generateMiniCalendar(currentMonth, currentYear, filters, filtersOrg);

      }, 100); // Adjust the interval time (in milliseconds) for the desired scrolling speed
    }).mouseup(function() {
      clearInterval(nextMonthInterval);
    }).mouseleave(function() {
      clearInterval(nextMonthInterval);
    });

    // Event handler for the remaining-event button click
    $(document).on('click', '.remaining-event', function() {
      // Hide all other remaining-event popovers
      $('.remaining-event').not(this).popover('hide');
    });

    // Event handler for all other buttons and popovers
    $(document).on('click', 'button:not(.remaining-event), [data-bs-toggle="popover"]:not(.remaining-event)', function() {
      // Hide all remaining-event popovers
      $('.remaining-event').popover('hide');
    });

    $(document).on('click', 'button:not(.remaining-event)', function () {
      // Hide all other popovers
      $('[data-bs-toggle="popover"]').not(this).popover('hide');
    });

    $(document).on('click', '[data-bs-toggle="popover"]:not(.remaining-event)', function () {
      // Hide all other popovers
      $('[data-bs-toggle="popover"]').not(this).popover('hide');
    });

    // Initialize popovers
    $('[data-bs-toggle="popover"]').popover();

    // Event handler for closing popover
    $(document).on('click', '.popover .close-popover', function() {
      $(this).closest('.popover').popover('hide');
    });

    // Event handler for the unique icon click event
    $(document).on("click", '.bx-group, .bx-calendar-plus, .show-more-details-popover', function() {
      // Hide all popovers
      $('[data-bs-toggle="popover"]').popover('hide');
    });

    // Function to update table headers
    function updateTableHeaders(mql) {
      const tableHeaders = document.getElementById('table-headers');
      const days = ['SUNDAY', 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'];

      if (mql.matches) {
        // If the viewport width is 1300px or more, use the full day names
        const headers = tableHeaders.getElementsByTagName('th');
        for (let i = 0; i < headers.length; i++) {
          headers[i].textContent = days[i];
        }
      } else {
        // If the viewport width is less than 1300px, use the abbreviated day names
        const headers = tableHeaders.getElementsByTagName('th');
        for (let i = 0; i < headers.length; i++) {
          headers[i].textContent = days[i].substring(0, 3);
        }
      }
    }

    // Create a MediaQueryList object for the specified viewport width
    const mediaQuery = window.matchMedia('(min-width: 1390px)');

    // Call the function initially to set the table headers accordingly
    updateTableHeaders(mediaQuery);

    // Add event listener to handle changes in viewport width
    mediaQuery.addEventListener('change', updateTableHeaders);

    const allCheckbox = document.getElementById('check-all-event');
    const tournamentCheckbox = document.getElementById('check-tournament');
    const competitionCheckbox = document.getElementById('check-competition');
    const standardCheckbox = document.getElementById('check-standard');

    function updateAllCheckbox() {
      if (!tournamentCheckbox.checked && !competitionCheckbox.checked && !standardCheckbox.checked) {
        allCheckbox.checked = false;
      } else if (tournamentCheckbox.checked && competitionCheckbox.checked && standardCheckbox.checked) {
        allCheckbox.checked = true;
      } else {
        allCheckbox.checked = false;
      }
      // update checkbox array
      filters.length = 0; // clear previous values
      if (tournamentCheckbox.checked) {
        filters.push(tournamentCheckbox.value);
      }
      if (competitionCheckbox.checked) {
        filters.push(competitionCheckbox.value);
      }
      if (standardCheckbox.checked) {
        filters.push(standardCheckbox.value);
      }
    }

    // Add event listeners to update "All" checkbox when other checkboxes are clicked
    tournamentCheckbox.addEventListener('click', updateAllCheckbox);
    competitionCheckbox.addEventListener('click', updateAllCheckbox);
    standardCheckbox.addEventListener('click', updateAllCheckbox);

    // Add event listener to check other checkboxes when "All" checkbox is checked
    allCheckbox.addEventListener('click', function() {
      filters.length = 0;
      if (allCheckbox.checked) {
        tournamentCheckbox.checked = true;
        competitionCheckbox.checked = true;
        standardCheckbox.checked = true;
        filters.push(tournamentCheckbox.value);
        filters.push(competitionCheckbox.value);
        filters.push(standardCheckbox.value);
      } else {
        tournamentCheckbox.checked = false;
        competitionCheckbox.checked = false;
        standardCheckbox.checked = false;
      }
      updateCalendar();
    });

    // Select all checkboxes at startup
    allCheckbox.checked = true;
    tournamentCheckbox.checked = true;
    competitionCheckbox.checked = true;
    standardCheckbox.checked = true;    

    function updateCalendar() {
      generateCalendar(currentMonth, currentYear, filters, filtersOrg);
    }

    tournamentCheckbox.addEventListener('click', updateCalendar);
    competitionCheckbox.addEventListener('click', updateCalendar);
    standardCheckbox.addEventListener('click', updateCalendar);
    const allCheckboxOrg = document.getElementById('check-all-organization');
    const scCheckbox = document.getElementById('check-sc');
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
        !scCheckbox.checked &&
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
        scCheckbox.checked &&
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
      if (scCheckbox.checked) {
        filtersOrg.push(scCheckbox.value);
      }
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
    scCheckbox.addEventListener('click', updateAllCheckboxOrg);
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
        scCheckbox.checked = true;
        acapCheckbox.checked = true;
        aecesCheckbox.checked = true;
        eliteCheckbox.checked = true;
        giveCheckbox.checked = true;
        jehraCheckbox.checked = true;
        jmapCheckbox.checked = true;
        jpiaCheckbox.checked = true;
        piieCheckbox.checked = true;
        filtersOrg.push(scCheckbox.value);
        filtersOrg.push(acapCheckbox.value);
        filtersOrg.push(aecesCheckbox.value);
        filtersOrg.push(eliteCheckbox.value);
        filtersOrg.push(giveCheckbox.value);
        filtersOrg.push(jehraCheckbox.value);
        filtersOrg.push(jmapCheckbox.value);
        filtersOrg.push(jpiaCheckbox.value);
        filtersOrg.push(piieCheckbox.value);
      } else {
        scCheckbox.checked = false;
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
    scCheckbox.checked = true;
    acapCheckbox.checked = true;
    aecesCheckbox.checked = true;
    eliteCheckbox.checked = true;
    giveCheckbox.checked = true;
    jehraCheckbox.checked = true;
    jmapCheckbox.checked = true;
    jpiaCheckbox.checked = true;
    piieCheckbox.checked = true;

    function updateCalendarOrg() {
      generateCalendar(currentMonth, currentYear, filters, filtersOrg);
    }

    scCheckbox.addEventListener('click', updateCalendarOrg);
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
        !scCheckbox.checked &&
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
        scCheckbox.checked &&
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
      if (scCheckbox.checked) {
        filtersOrg.push(scCheckbox.value);
      }
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
  }
};

var studentCalendarPhone = {
  initialize: function() {
    var filters = ["Tournament", "Competition", "Standard"];
    var filtersOrg = ["SC", "ACAP", "AECES", "ELITE", "GIVE", "JEHRA", "JMAP", "JPIA", "PIIE"];
    var selectedDate;

    // Select DOM elements
    const showModalBtn = document.querySelector(".show-modal");
    const bottomSheet = document.querySelector(".bottom-sheet");
    const sheetOverlay = bottomSheet.querySelector(".sheet-overlay");
    const sheetContent = bottomSheet.querySelector(".content");
    const dragIcon = bottomSheet.querySelector(".drag-icon");

    // Global variables for tracking drag events
    let isDragging = false, startY, startHeight;

    // Show the bottom sheet, hide body vertical scrollbar, and call updateSheetHeight
    const showBottomSheet = () => {
        bottomSheet.classList.add("show");
        document.body.style.overflowY = "hidden";
        updateSheetHeight(50);
    }

    const updateSheetHeight = (height) => {
        sheetContent.style.height = `${height}vh`; //updates the height of the sheet content
        // Toggles the fullscreen class to bottomSheet if the height is equal to 100
        bottomSheet.classList.toggle("fullscreen", height === 100);
    }

    // Hide the bottom sheet and show body vertical scrollbar
    const hideBottomSheet = () => {
        bottomSheet.classList.remove("show");
        document.body.style.overflowY = "auto";
    }

    // Sets initial drag position, sheetContent height and add dragging class to the bottom sheet
    const dragStart = (e) => {
        isDragging = true;
        startY = e.pageY || e.touches?.[0].pageY;
        startHeight = parseInt(sheetContent.style.height);
        bottomSheet.classList.add("dragging");
    }

    // Calculates the new height for the sheet content and call the updateSheetHeight function
    const dragging = (e) => {
        if(!isDragging) return;
        const delta = startY - (e.pageY || e.touches?.[0].pageY);
        const newHeight = startHeight + delta / window.innerHeight * 100;
        updateSheetHeight(newHeight);
    }

    // Determines whether to hide, set to fullscreen, or set to default 
    // height based on the current height of the sheet content
    const dragStop = () => {
        isDragging = false;
        bottomSheet.classList.remove("dragging");
        const sheetHeight = parseInt(sheetContent.style.height);
        sheetHeight < 25 ? hideBottomSheet() : sheetHeight > 75 ? updateSheetHeight(100) : updateSheetHeight(50);
    }

    dragIcon.addEventListener("mousedown", dragStart);
    document.addEventListener("mousemove", dragging);
    document.addEventListener("mouseup", dragStop);

    dragIcon.addEventListener("touchstart", dragStart);
    document.addEventListener("touchmove", dragging);
    document.addEventListener("touchend", dragStop);

    sheetOverlay.addEventListener("click", hideBottomSheet);
    showModalBtn.addEventListener("click", showBottomSheet);

    function generateCalendar(month, year, filters, filtersOrg) {
      // Get number of days in the month and the first day of the month
      const numDays = new Date(year, month + 1, 0).getDate();
      const firstDay = new Date(year, month, 1).getDay();
    
      // Clear the upcoming events container
      const showUpcomingEventsContainer = document.getElementById("showUpcomingEvents");
      showUpcomingEventsContainer.innerHTML = "";
    
      // Set the calendar title
      const currentMonthYear = document.getElementById("current-month");
      currentMonthYear.innerHTML = "<strong>" + months[month] + "</strong> " + year;
    
      $.ajax({
        url: './php/CAL-get-events-calendar.php',
        type: 'GET',
        data: {
          year: year,
          month: month + 1,
          filters: filters,
          filtersOrg: filtersOrg
        },
        success: function (data) {
          const events = JSON.parse(data);
    
          events.sort(function (a, b) {
            const dateA = new Date(a.event_date);
            const dateB = new Date(b.event_date);
            return dateA - dateB;
          });
    
          var tomorrow = new Date();
          tomorrow.setDate(tomorrow.getDate() + 1);
          tomorrow.setHours(0, 0, 0, 0);

          // Iterate over events data and populate details for upcoming events
          for (var i = 0; i < events.length; i++) {
            const event = events[i];

            // Create a new Date object from the event date string
            const eventDate = new Date(event.event_date);

            // Check if the event date is tomorrow or later
            if (eventDate >= tomorrow) {
              // Create the necessary elements
              const div = document.createElement("div");
              div.className = "div";
              const element = document.createElement("div");
              element.className = "element";
              const row = document.createElement("div");
              row.className = "row";
              const seeMoreLink = document.createElement("div");
              seeMoreLink.textContent = "See more";
              const elementGroup = document.createElement("div");
              elementGroup.className = "element-group";
              const elementLabel = document.createElement("div");
              elementLabel.className = "element-label";
              // Create a new Date object from the event date string
              const dayOfWeek = eventDate.toLocaleDateString('en-US', { weekday: 'long' });
              const formattedDate = eventDate.toLocaleDateString('en-US', {
                month: 'long',
                day: 'numeric',
                year: 'numeric'
              });
              // Get the day of the week as a string
              elementLabel.textContent = formattedDate;
              const elementContent = document.createElement("div");
              elementContent.className = "element-content";
              if (event.event_org) {
                elementContent.innerHTML = "<b>" + event.category_name + "</b>" + "<br>" + "<span class='pill-" +
                  event.event_org.toLowerCase() + "'" + ">" + event.event_org + "</span>" + "<br>" + "<div class='d-flex justify-content-between'>" + "<div>" + dayOfWeek + "</div>" + "<div>" + "<a href='javascript:void(0)' class='no-underline-link'>" + "See more" + "</a>" + "</div>" + "</div>";
              } else {
                elementContent.innerHTML = "<b>" + event.category_name + "</b>" + "<br>" + "<div class='d-flex justify-content-between'>" + "<div>" + dayOfWeek + "</div>" + "<div>" + "<a href='javascript:void(0)' class='no-underline-link'>" + "See more" + "</a>" + "</div>" + "</div>";
              }

              const eventLink = elementContent.querySelector("a");
              eventLink.addEventListener("click", createModalUpcoming(event.event_id, formattedDate, event.category_name, event.event_time, event.event_org, event.event_description, event.event_type));
              // Append elements to the container
              elementGroup.appendChild(elementLabel);
              elementGroup.appendChild(elementContent);
              row.appendChild(elementGroup);
              element.appendChild(row);
              div.appendChild(element);
              showUpcomingEventsContainer.appendChild(div);
            }
          }

          function createModalUpcoming(eventId, eventDate, categoryName, eventTime, eventOrg, eventDesc,eventType) {
            return function() {
              var modalTitleText = "<b>" + eventDate + "</b>";
              if (eventOrg) {
                var modalContentText = "<b>" + categoryName + "</b>" + "<br>" + "<b>Who: </b>" + "<span class='pill-" + eventOrg.toLowerCase() +"'>" + eventOrg + "</span>" + "<br>" + "<b>Description: </b>" + eventDesc;
              } else {
                var modalContentText = "<b>" + categoryName + "</b>" + "<br>" + "<b>When: </b>" + eventTime + "<br>" + "<b>Description: </b>" + eventDesc;
              }

              if (eventType === "Tournament") {
                var modalButtons = '<i id="mobile-tournament-' + eventId + '" class="bx bx-group bx-lg mobile-icons"></i>' + '<i id="mobile-add-calendar-' + eventId + '" class="bx bx-calendar-plus bx-lg mobile-icons"></i>';
              } else {
                var modalButtons = '<i id="mobile-add-calendar-' + eventId + '" class="bx bx-calendar-plus bx-lg mobile-icons"></i>';
              }

              const modalHTML = `
                <div class="modal fade" id="dynamicModal-${eventId}" tabindex="-1" data-bs-backdrop="static" aria-labelledby="dynamicModalLabel-${eventId}" aria-hidden="true">
                  <div class=" modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5 w-100 text-center" id="dynamicModalLabel-${eventId}">${modalTitleText}</h1>
                      </div>
                      <div class="modal-body text-center">${modalContentText}</div>
                      <div class="modal-footer invisible-footer d-flex justify-content-between">
                        <div>${modalButtons}</div>
                        <button type="button" class="outline-button" data-bs-dismiss="modal">Back</button>
                      </div>
                    </div>
                  </div>
                </div>
              `;

              const modal = document.createElement("div");
              modal.innerHTML = modalHTML.trim();
              document.body.appendChild(modal);

              const calendarIcon = modal.querySelector("#mobile-add-calendar-" + eventId);
              calendarIcon.addEventListener("click", function(event) {
                const buttonId = event.target.id;
                addToCalendarUpcoming(buttonId, eventDate, categoryName, eventTime, eventDesc)
              });

              if (eventType === "Tournament") {
                const tournementIcon = modal.querySelector("#mobile-tournament-" + eventId);
                tournementIcon.addEventListener("click", function(event) {
                  const buttonId = event.target.id;
                  tournamentUpcoming(buttonId)
                });
              }

              const bootstrapModal = new bootstrap.Modal(modal.querySelector(".modal"));
              bootstrapModal.show();
            }
          }

          function addToCalendarUpcoming(eventId, eventDate, categoryName, eventTime, eventDesc) {

            // Create a new Date object using the eventDate string
            var date = new Date(eventDate);

            // Extract the year, month, and day components from the Date object
            var year = date.getFullYear();
            var month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based, so add 1
            var day = String(date.getDate()).padStart(2, '0');

            // Concatenate the components in the desired format (yyyy-mm-dd)
            var convertedDate = year + '-' + month + '-' + day;

            const addToCalendarModal = `
              <div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog" id="${eventId}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                  <div class="modal-content">
                    <div class="modal-header invisible-header">
                      <h3 class="modal-title w-100 text-center" style="font-size: 24px;">Add Event To Date</h3>
                    </div>
                    <div class="modal-body text-center">
                      <p>Do you wish to add the event to your calendar</p>
                      <br>
                      <div class="d-flex justify-content-evenly">
                        <button class="outline-button" id="authorize_button" onclick="handleAuthClick('${convertedDate}', '${categoryName.replace(/'/g, "\\'")}', '${eventDesc.replace(/'/g, "\\'")}', '${eventTime}')">Yes</button>
                        <button type="button" class="outline-button" id="no-button" data-bs-dismiss="modal">No</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            `;
          
            const modal = document.createElement("div");
            modal.innerHTML = addToCalendarModal.trim();
            document.body.appendChild(modal);
          
            const bootstrapModal = new bootstrap.Modal(modal.querySelector(".modal"));
            bootstrapModal.show();
          }

          function tournamentUpcoming(eventId) {

            const tournamentUpcomingModal = `
              <div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog" id="tournament-modal-${eventId}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                  <div class="modal-content">
                    <div class="modal-header invisible-header">
                      <h3 class="modal-title w-100 text-center" style="font-size: 24px;">Tournament Modal Title</h3>
                    </div>
                    <div class="modal-body text-center">
                      <img src="./pictures/sampleTournamentBraket.png" alt="TournamentBracket">
                    </div>
                    <div class="modal-footer border-0">
                      <button type="button" class="outline-button ms-auto" id="back-button" data-bs-dismiss="modal">Back</button>
                    </div>
                  </div>
                </div>
              </div>
            `;
          
            const modal = document.createElement("div");
            modal.innerHTML = tournamentUpcomingModal.trim();
            document.body.appendChild(modal);
          
            const bootstrapModal = new bootstrap.Modal(modal.querySelector(".modal"));
            bootstrapModal.show();
          }
        },
        error: function(error) {
          console.error('Error: ' + error.message);
        }
      });

      var currentDate = new Date(); // Get the current date
      var currentDay = currentDate.getDate(); // Get the day of the current date
      var currentMonth = currentDate.getMonth(); // Get the month of the current date
      var currentYear = currentDate.getFullYear(); // Get the year of the current date
      // Generate calendar days
      var date = 1;
      var calendarBody = document.getElementById("mobile-calendar-days");
      calendarBody.innerHTML = ""; // Clear the calendar table

      for (var i = 0; i < 6; i++) {
        var row = document.createElement("tr");
        for (var j = 0; j < 7; j++) {
          var cell = document.createElement("td");
          if (i === 0 && j < firstDay) {
            // Cell is before the first day of the month
            cell.classList.add("disabled");
          } else {
            // Cell is a valid day of the month or after the last day of the month
            if (date <= numDays) {
              var div = document.createElement("div");
              var dateText = document.createElement("span");
              dateText.innerHTML = date;
              dateText.classList.add("clickable-date"); // Add the "clickable-date" class
              div.appendChild(dateText);
              // Add a light-colored circle for the current date if it's the current month
              if (year === currentYear && month === currentMonth) {
                if (date === currentDay) {
                  dateText.classList.add("current-day");
                  selectedDate = date;
                }
              }
              cell.appendChild(div);
              date++;
            } else {
              // Cell is after the last day of the month
              cell.classList.add("disabled");
            }
          }
          row.appendChild(cell);
        }
        calendarBody.appendChild(row);
      }
    }

    function generateCalendarSelected(month, year, filters, selectedDate, filtersOrg) {

      // Clear previous event details
      var showSelectedEventsContainer = document.getElementById("showSelectedEvents");
      showSelectedEventsContainer.innerHTML = "";

      var currentEventsTitle = document.getElementById("currentEventsTitle");
      if (selectedDate === undefined) {
        currentEventsTitle.innerHTML = "Events on " + months[month] + " " + year;
      } else {
        var formattedDate = selectedDate.toLocaleDateString("en-US", { month: "long", day: "numeric", year: "numeric" });
        currentEventsTitle.innerHTML = "Events on " + formattedDate;
      }
      
      $.ajax({
        url: './php/CAL-mobile-retrieve-events.php',
        type: 'GET',
        data: {
          year: year,
          month: month + 1,
          filters: filters,
          filtersOrg: filtersOrg,
          selectedDate: selectedDate
        },
        success: function (data) {
          const events = JSON.parse(data);
    
          events.sort(function (a, b) {
            const dateA = new Date(a.event_date);
            const dateB = new Date(b.event_date);
            return dateA - dateB;
          });
      
          // Iterate over events data and populate details
          for (var i = 0; i < events.length; i++) {
            const event = events[i];

            // Create the necessary elements
            const div = document.createElement("div");
            div.className = "div";
            const element = document.createElement("div");
            element.className = "element";
            const row = document.createElement("div");
            row.className = "row";
            const seeMoreLink = document.createElement("div");
            seeMoreLink.textContent = "See more";
            const elementGroup = document.createElement("div");
            elementGroup.className = "element-group";
            const elementLabel = document.createElement("div");
            elementLabel.className = "element-label";
            // Create a new Date object from the event date string
            const eventDate = new Date(event.event_date);
            const dayOfWeek = eventDate.toLocaleDateString('en-US', { weekday: 'long' });
            const formattedDate = eventDate.toLocaleDateString('en-US', {
              month: 'long',
              day: 'numeric',
              year: 'numeric'
            });
            // Get the day of the week as a string
            elementLabel.textContent = formattedDate;
            const elementContent = document.createElement("div");
            elementContent.className = "element-content";
            if (event.event_org) {
              elementContent.innerHTML = "<b>" + event.category_name + "</b>" + "<br>" + "<span class='pill-" +
                event.event_org.toLowerCase() + "'" + ">" + event.event_org + "</span>" + "<br>" + "<div class='d-flex justify-content-between'>" + "<div>" + dayOfWeek + "</div>" + "<div>" + "<a href='javascript:void(0)' class='no-underline-link'>" + "See more" + "</a>" + "</div>" + "</div>";
            } else {
              elementContent.innerHTML = "<b>" + event.category_name + "</b>" + "<br>" + "<div class='d-flex justify-content-between'>" + "<div>" + dayOfWeek + "</div>" + "<div>" + "<a href='javascript:void(0)' class='no-underline-link'>" + "See more" + "</a>" + "</div>" + "</div>";
            }

            const eventLink = elementContent.querySelector("a");
            eventLink.addEventListener("click", createModalSelected(event.event_id, formattedDate, event.category_name, event.event_time, event.event_org, event.event_description, event.event_type));

            // Append elements to the container
            elementGroup.appendChild(elementLabel);
            elementGroup.appendChild(elementContent);
            row.appendChild(elementGroup);
            element.appendChild(row);
            div.appendChild(element);
            showSelectedEventsContainer.appendChild(div);
          }

          function createModalSelected(eventId, eventDate, categoryName, eventTime, eventOrg, eventDesc, eventType) {
            return function() {
              var modalTitleText = "<b>" + eventDate + "</b>";
              if (eventOrg) {
                var modalContentText = "<b>" + categoryName + "</b>" + "<br>" + "<b>Who: </b>" + "<span class='pill-" + eventOrg.toLowerCase() +"'>" + eventOrg + "</span>" + "<br>" + "<b>Description: </b>" + eventDesc;
              } else {
                var modalContentText = "<b>" + categoryName + "</b>" + "<br>" + "<b>When: </b>" + eventTime + "<br>" + "<b>Description: </b>" + eventDesc;
              }

              if (eventType === "Tournament") {
                var modalButtons = '<i id="mobile-tournament-' + eventId + '" class="bx bx-group bx-lg mobile-icons"></i>' + '<i id="mobile-add-calendar-' + eventId + '" class="bx bx-calendar-plus bx-lg mobile-icons"></i>';
              } else {
                var modalButtons = '<i id="mobile-add-calendar-' + eventId + '" class="bx bx-calendar-plus bx-lg mobile-icons"></i>';
              }

              const modalHTML = `
                <div class="modal fade" id="dynamicModal-${eventId}" tabindex="-1" data-bs-backdrop="static" aria-labelledby="dynamicModalLabel-${eventId}" aria-hidden="true">
                  <div class=" modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5 w-100 text-center" id="dynamicModalLabel-${eventId}">${modalTitleText}</h1>
                      </div>
                      <div class="modal-body text-center">${modalContentText}</div>
                      <div class="modal-footer invisible-footer d-flex justify-content-between">
                        <div>${modalButtons}</div>
                        <button type="button" class="outline-button" data-bs-dismiss="modal">Back</button>
                      </div>
                    </div>
                  </div>
                </div>
              `;

              const modal = document.createElement("div");
              modal.innerHTML = modalHTML.trim();
              document.body.appendChild(modal);

              const calendarIcon = modal.querySelector("#mobile-add-calendar-" + eventId);
              calendarIcon.addEventListener("click", function(event) {
                const buttonId = event.target.id;
                addToCalendarSelected(buttonId, eventDate, categoryName, eventTime, eventDesc)
              });

              if (eventType === "Tournament") {
                const tournementIcon = modal.querySelector("#mobile-tournament-" + eventId);
                tournementIcon.addEventListener("click", function(event) {
                  const buttonId = event.target.id;
                  tournamentSelected(buttonId)
                });
              }

              const bootstrapModal = new bootstrap.Modal(modal.querySelector(".modal"));
              bootstrapModal.show();
            }
          }

          function addToCalendarSelected(eventId, eventDate, categoryName, eventTime, eventDesc) {

            // Create a new Date object using the eventDate string
            var date = new Date(eventDate);

            // Extract the year, month, and day components from the Date object
            var year = date.getFullYear();
            var month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based, so add 1
            var day = String(date.getDate()).padStart(2, '0');

            // Concatenate the components in the desired format (yyyy-mm-dd)
            var convertedDate = year + '-' + month + '-' + day;

            const addToCalendarModal = `
              <div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog" id="${eventId}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                  <div class="modal-content">
                    <div class="modal-header invisible-header">
                      <h3 class="modal-title w-100 text-center" style="font-size: 24px;">Add Event To Date</h3>
                    </div>
                    <div class="modal-body text-center">
                      <p>Do you wish to add the event to your calendar</p>
                      <br>
                      <div class="d-flex justify-content-evenly">
                        <button class="outline-button" id="authorize_button" onclick="handleAuthClick('${convertedDate}', '${categoryName.replace(/'/g, "\\'")}', '${eventDesc.replace(/'/g, "\\'")}', '${eventTime}')">Yes</button>
                        <button type="button" class="outline-button" id="no-button" data-bs-dismiss="modal">No</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            `;
          
            const modal = document.createElement("div");
            modal.innerHTML = addToCalendarModal.trim();
            document.body.appendChild(modal);
          
            const bootstrapModal = new bootstrap.Modal(modal.querySelector(".modal"));
            bootstrapModal.show();
          }

          function tournamentSelected(eventId) {

            const tournamentSelectedModal = `
              <div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog" id="tournament-modal-${eventId}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                  <div class="modal-content">
                    <div class="modal-header invisible-header">
                      <h3 class="modal-title w-100 text-center" style="font-size: 24px;">Tournament Modal Title</h3>
                    </div>
                    <div class="modal-body text-center">
                      <img src="./pictures/sampleTournamentBraket.png" alt="TournamentBracket">
                    </div>
                    <div class="modal-footer border-0">
                      <button type="button" class="outline-button ms-auto" id="back-button" data-bs-dismiss="modal">Back</button>
                    </div>
                  </div>
                </div>
              </div>
            `;
          
            const modal = document.createElement("div");
            modal.innerHTML = tournamentSelectedModal.trim();
            document.body.appendChild(modal);
          
            const bootstrapModal = new bootstrap.Modal(modal.querySelector(".modal"));
            bootstrapModal.show();
          }
        }
      });
    }

    $(document).ready(function() {
      $('#date_mobile_search').on('change', function() {
        let dateValue = $(this).val();
        let selectedDate = new Date(dateValue);
        currentYear = selectedDate.getFullYear();
        currentMonth = selectedDate.getMonth();
        generateCalendar(currentMonth, currentYear, filters, filtersOrg);
        generateCalendarSelected(currentMonth, currentYear, filters, selectedDate, filtersOrg)
      });
    });
    
    $(".floating-main").click(function() {
      $('.floating').toggleClass('float-open');
    });

    // Click event handler using event delegation
    $('#mobile-calendar-days').on('click', '.clickable-date', function() {
      // Remove the "current-day" class from the previously clicked date
      $('.current-day').removeClass('current-day');
    
      // Add the "current-day" class to the clicked date
      $(this).addClass('current-day');
    
      var clickedDate = $(this).text();
      selectedDate = clickedDate;
      generateCalendarSelected(currentMonth, currentYear, filters, selectedDate, filtersOrg)
    });   

    // Event listener for the previous month button
    document.getElementById("mobile-prev-month").addEventListener("click", function () {
      currentMonth--;
      if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
      }
      generateCalendar(currentMonth, currentYear, filters, filtersOrg);
      generateCalendarSelected(currentMonth, currentYear, filters, selectedDate, filtersOrg)
    });

    // Event listener for the next month button
    document.getElementById("mobile-next-month").addEventListener("click", function () {
      currentMonth++;
      if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
      }
      generateCalendar(currentMonth, currentYear, filters, filtersOrg);
      generateCalendarSelected(currentMonth, currentYear, filters, selectedDate, filtersOrg)
    });

    // Generate calendar for current month and year
    generateCalendar(currentMonth, currentYear, filters, filtersOrg);
    generateCalendarSelected(currentMonth, currentYear, filters, selectedDate, filtersOrg)

    const allCheckbox = document.getElementById('mobile-check-all-event');
    const tournamentCheckbox = document.getElementById('mobile-check-tournament');
    const competitionCheckbox = document.getElementById('mobile-check-competition');
    const standardCheckbox = document.getElementById('mobile-check-standard');

    function updateAllCheckbox() {
      if (!tournamentCheckbox.checked && !competitionCheckbox.checked && !standardCheckbox.checked) {
        allCheckbox.checked = false;
      } else if (tournamentCheckbox.checked && competitionCheckbox.checked && standardCheckbox.checked) {
        allCheckbox.checked = true;
      } else {
        allCheckbox.checked = false;
      }
      // update checkbox array
      filters.length = 0; // clear previous values
      if (tournamentCheckbox.checked) {
        filters.push(tournamentCheckbox.value);
      }
      if (competitionCheckbox.checked) {
        filters.push(competitionCheckbox.value);
      }
      if (standardCheckbox.checked) {
        filters.push(standardCheckbox.value);
      }
    }

    // Add event listeners to update "All" checkbox when other checkboxes are clicked
    tournamentCheckbox.addEventListener('click', updateAllCheckbox);
    competitionCheckbox.addEventListener('click', updateAllCheckbox);
    standardCheckbox.addEventListener('click', updateAllCheckbox);

    // Add event listener to check other checkboxes when "All" checkbox is checked
    allCheckbox.addEventListener('click', function() {
      filters.length = 0;
      if (allCheckbox.checked) {
        tournamentCheckbox.checked = true;
        competitionCheckbox.checked = true;
        standardCheckbox.checked = true;
        filters.push(tournamentCheckbox.value);
        filters.push(competitionCheckbox.value);
        filters.push(standardCheckbox.value);
      } else {
        tournamentCheckbox.checked = false;
        competitionCheckbox.checked = false;
        standardCheckbox.checked = false;
      }
      updateCalendar();
    });

    // Select all checkboxes at startup
    allCheckbox.checked = true;
    tournamentCheckbox.checked = true;
    competitionCheckbox.checked = true;
    standardCheckbox.checked = true;    

    function updateCalendar() {
      generateCalendar(currentMonth, currentYear, filters, filtersOrg);
      generateCalendarSelected(currentMonth, currentYear, filters, selectedDate, filtersOrg)
    }

    tournamentCheckbox.addEventListener('click', updateCalendar);
    competitionCheckbox.addEventListener('click', updateCalendar);
    standardCheckbox.addEventListener('click', updateCalendar);

    const allCheckboxOrg = document.getElementById('mobile-check-all-organization');
    const scCheckbox = document.getElementById('mobile-check-sc');
    const acapCheckbox = document.getElementById('mobile-check-acap');
    const aecesCheckbox = document.getElementById('mobile-check-aeces');
    const eliteCheckbox = document.getElementById('mobile-check-elite');
    const giveCheckbox = document.getElementById('mobile-check-give');
    const jehraCheckbox = document.getElementById('mobile-check-jehra');
    const jmapCheckbox = document.getElementById('mobile-check-jmap');
    const jpiaCheckbox = document.getElementById('mobile-check-jpia');
    const piieCheckbox = document.getElementById('mobile-check-piie');

    function updateAllCheckboxOrg() {
      if (
        !scCheckbox.checked &&
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
        scCheckbox.checked &&
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
      if (scCheckbox.checked) {
        filtersOrg.push(scCheckbox.value);
      }
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
    scCheckbox.addEventListener('click', updateAllCheckboxOrg);
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
        scCheckbox.checked = true;
        acapCheckbox.checked = true;
        aecesCheckbox.checked = true;
        eliteCheckbox.checked = true;
        giveCheckbox.checked = true;
        jehraCheckbox.checked = true;
        jmapCheckbox.checked = true;
        jpiaCheckbox.checked = true;
        piieCheckbox.checked = true;
        filtersOrg.push(scCheckbox.value);
        filtersOrg.push(acapCheckbox.value);
        filtersOrg.push(aecesCheckbox.value);
        filtersOrg.push(eliteCheckbox.value);
        filtersOrg.push(giveCheckbox.value);
        filtersOrg.push(jehraCheckbox.value);
        filtersOrg.push(jmapCheckbox.value);
        filtersOrg.push(jpiaCheckbox.value);
        filtersOrg.push(piieCheckbox.value);
      } else {
        scCheckbox.checked = false;
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
    scCheckbox.checked = true;
    acapCheckbox.checked = true;
    aecesCheckbox.checked = true;
    eliteCheckbox.checked = true;
    giveCheckbox.checked = true;
    jehraCheckbox.checked = true;
    jmapCheckbox.checked = true;
    jpiaCheckbox.checked = true;
    piieCheckbox.checked = true;

    function updateCalendarOrg() {
      generateCalendar(currentMonth, currentYear, filters, filtersOrg);
      generateCalendarSelected(currentMonth, currentYear, filters, selectedDate, filtersOrg)
    }

    scCheckbox.addEventListener('click', updateCalendarOrg);
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
        !scCheckbox.checked &&
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
        scCheckbox.checked &&
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
      if (scCheckbox.checked) {
        filtersOrg.push(scCheckbox.value);
      }
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
  }
};

var currentDeviceType = null;
var previousDeviceType = null;

function initializeGlobalVariables() {
  if (sessionStorage.getItem('globalVariablesSet')) {
    currentMonth = parseInt(sessionStorage.getItem('currentMonth'));
    currentYear = parseInt(sessionStorage.getItem('currentYear'));
  } else {
    currentMonth = new Date().getMonth();
    currentYear = new Date().getFullYear();
    sessionStorage.setItem('globalVariablesSet', 'true');
    updateSessionStorage();
  }
}

function updateSessionStorage() {
  sessionStorage.setItem('currentMonth', currentMonth);
  sessionStorage.setItem('currentYear', currentYear);
}

function checkWindowSize() {
  var deviceType = window.innerWidth <= 1080 ? "Phone" : "Computer";

  // Check if device type has changed
  if (deviceType !== currentDeviceType) {
    previousDeviceType = currentDeviceType;
    currentDeviceType = deviceType;

    // Check if the device type transition occurred
    var isTransition = previousDeviceType !== null;

    // Reload the page if there was a device type transition
    if (isTransition) {
      location.reload();
    }

    // Initialize the appropriate calendar
    if (deviceType === "Phone") {
      studentCalendarPhone.initialize();
    } else {
      studentCalendarComputer.initialize();
    }
  }
}

// Call the checkWindowSize function when the window is resized
window.addEventListener('resize', function() {
  checkWindowSize();
});

// Wrap the load event listener inside setTimeout to ensure the elements are loaded
setTimeout(function() {
  window.addEventListener('load', function() {
    initializeGlobalVariables();
    checkWindowSize();
  });
}, 0);

// Save the global variables to sessionStorage before page reload or unload
window.addEventListener('beforeunload', function() {
  updateSessionStorage();
});


function updateSidebarState() {
  const isWindowLarge = window.innerWidth >= 799;

  if (isWindowLarge) {
    sidebar.classList.add("open");
    openNav();
  } else {
    sidebar.classList.remove("open");
    closeNav();
  }

  menuBtnChange();
}

window.addEventListener("resize", updateSidebarState);

window.addEventListener("load", function () {
  if (typeof Storage !== "undefined") {
    const storedState = localStorage.getItem("sidebar");

    if (storedState === "open") {
      sidebar.classList.add("open");
    } else if (storedState === "closed") {
      sidebar.classList.remove("open");
    }
  }
  
  updateSidebarState();
});

// Open the sidebar if the window size is initially large
window.addEventListener("DOMContentLoaded", function () {
  const isWindowLarge = window.innerWidth >= 1081;

  if (isWindowLarge) {
    sidebar.classList.add("open");
    openNav();
    menuBtnChange();
  }
});