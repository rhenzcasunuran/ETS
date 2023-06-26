// Global variables
var currentMonth = new Date().getMonth();
var currentYear = new Date().getFullYear();
var months = [
  "January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

var adminCalendarComputer = {
  initialize: function() {
    var filters = ["Tournament", "Competition", "Standard"];
    var filtersOrg = [];

    function generateCalendar(month, year, filters) {
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
              filters: filters
          },
          success: function(data) {
            console.log(data)
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
                            (events[eventsCounting].event_type !== 'Standard' && events[eventsCounting].event_type === 'Tournament' ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-sm"></i>' : '') +
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
                            "<br><b>" + events[eventsCounting].category_name + "</b><br>" + "<b>When: </b>" + events[eventsCounting].event_time + "<br>" + "<b>Description: </b>" + events[eventsCounting].event_description + "<br><br>" +
                            '</div><div class="modal-footer border-0">' +
                            (events[eventsCounting].event_type !== 'Standard' ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-lg"></i>' : '') +
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

                        if (events[eventsCounting].event_type !== "Standard" && events[eventsCounting].event_type === "Tournament") {

                          // Create the tournament modal
                          var tournamentModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                          tournamentModal.attr('id', 'tournament-modal-' + events[eventsCounting].event_id);
                          tournamentModal.attr('aria-hidden', 'true');
                          tournamentModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Tournament Modal Title</h3></div><div class="modal-body text-center"><img src="../pictures/sampleTournamentBraket.png" alt="TournamentBracket"></div><div class="modal-footer border-0"><button type="button" class="outline-button ms-auto" id="back-button" data-bs-dismiss="modal">Back</button></div></div></div>');
                          
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
                        addToCalendarModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Add Event To Date</h3></div><div class="modal-body text-center"><p>Do you wish to add the event to your calendar</p><br><pre id="content"></pre><div class="d-flex justify-content-evenly"><button class="outline-button" id="authorize_button" onclick="handleAuthClick(\'' + events[eventsCounting].event_date + '\', \'' + events[eventsCounting].category_name.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_description.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_time + '\')">Yes</button><button type="button" class="outline-button" id="no-button" data-bs-dismiss="modal">No</button></div></div>');
                        
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
                            (events[eventsCounting].event_type !== 'Standard' && events[eventsCounting].event_type === 'Tournament' ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-sm"></i>' : '') +
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
                            "<br><b>" + events[eventsCounting].category_name + "</b><br>" + "<b>When: </b>" + events[eventsCounting].event_time + "<br>" + "<b>Description: </b>" + events[eventsCounting].event_description + "<br><br>" +
                            '</div><div class="modal-footer border-0">' +
                            (events[eventsCounting].event_type !== 'Standard' ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-lg"></i>' : '') +
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

                        if (events[eventsCounting].event_type !== "Standard" && events[eventsCounting].event_type === "Tournament") {

                          // Create the tournament modal
                          var tournamentModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                          tournamentModal.attr('id', 'tournament-modal-' + events[eventsCounting].event_id);
                          tournamentModal.attr('aria-hidden', 'true');
                          tournamentModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Tournament Modal Title</h3></div><div class="modal-body text-center"><img src="../pictures/sampleTournamentBraket.png" alt="TournamentBracket"></div><div class="modal-footer border-0"><button type="button" class="outline-button ms-auto" id="back-button" data-bs-dismiss="modal">Back</button></div></div></div>');
                        
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
                        addToCalendarModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Add Event To Date</h3></div><div class="modal-body text-center"><p>Do you wish to add the event to your calendar</p><br><pre id="content"></pre><div class="d-flex justify-content-evenly"><button class="outline-button" id="authorize_button" onclick="handleAuthClick(\'' + events[eventsCounting].event_date + '\', \'' + events[eventsCounting].category_name.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_description.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_time + '\')">Yes</button><button type="button" class="outline-button" id="no-button" data-bs-dismiss="modal">No</button></div></div>');
                        
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
                        (events[eventsCounting].event_type !== 'Standard' && events[eventsCounting].event_type === 'Tournament' ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-sm"></i>' : '') +
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
                        "<br><b>" + events[eventsCounting].category_name + "</b><br>" + "<b>When: </b>" + events[eventsCounting].event_time + "<br>" + "<b>Description: </b>" + events[eventsCounting].event_description + "<br><br>" +
                        '</div><div class="modal-footer border-0">' +
                        (events[eventsCounting].event_type !== 'Standard' ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-lg"></i>' : '') +
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

                    if (events[eventsCounting].event_type !== "Standard" && events[eventsCounting].event_type === "Tournament") {
                      // Create the tournament modal
                      var tournamentModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                      tournamentModal.attr('id', 'tournament-modal-' + events[eventsCounting].event_id);
                      tournamentModal.attr('aria-hidden', 'true');
                      tournamentModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Tournament Modal Title</h3></div><div class="modal-body text-center"><img src="../pictures/sampleTournamentBraket.png" alt="TournamentBracket"></div><div class="modal-footer border-0"><button type="button" class="outline-button ms-auto" id="back-button" data-bs-dismiss="modal">Back</button></div></div></div>');
                    
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
                    addToCalendarModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Add Event To Date</h3></div><div class="modal-body text-center"><p>Do you wish to add the event to your calendar</p><br><pre id="content"></pre><div class="d-flex justify-content-evenly"><button class="outline-button" id="authorize_button" onclick="handleAuthClick(\'' + events[eventsCounting].event_date + '\', \'' + events[eventsCounting].category_name.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_description.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_time + '\')">Yes</button><button type="button" class="outline-button" id="no-button" data-bs-dismiss="modal">No</button></div></div>');
                   
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
                            (events[eventsCounting].event_type !== 'Standard' && events[eventsCounting].event_type === 'Tournament' ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-sm"></i>' : '') +
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
                            "<br><b>" + events[eventsCounting].category_name + "</b><br>" + "<b>When: </b>" + events[eventsCounting].event_time + "<br>" + "<b>Description: </b>" + events[eventsCounting].event_description + "<br><br>" +
                            '</div><div class="modal-footer border-0">' +
                            (events[eventsCounting].event_type !== 'Standard' ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-lg"></i>' : '') +
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

                        if (events[eventsCounting].event_type !== "Standard" && events[eventsCounting].event_type === "Tournament") {
                          // Create the tournament modal
                          var tournamentModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                          tournamentModal.attr('id', 'tournament-modal-' + events[eventsCounting].event_id);
                          tournamentModal.attr('aria-hidden', 'true');
                          tournamentModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Tournament Modal Title</h3></div><div class="modal-body text-center"><img src="../pictures/sampleTournamentBraket.png" alt="TournamentBracket"></div><div class="modal-footer border-0"><button type="button" class="outline-button ms-auto" id="back-button" data-bs-dismiss="modal">Back</button></div></div></div>');
                        
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
                        addToCalendarModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Add Event To Date</h3></div><div class="modal-body text-center"><p>Do you wish to add the event to your calendar</p><br><pre id="content"></pre><div class="d-flex justify-content-evenly"><button class="outline-button" id="authorize_button" onclick="handleAuthClick(\'' + events[eventsCounting].event_date + '\', \'' + events[eventsCounting].category_name.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_description.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_time + '\')">Yes</button><button type="button" class="outline-button" id="no-button" data-bs-dismiss="modal">No</button></div></div>');
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
                            (events[eventsCounting].event_type !== 'Standard' && events[eventsCounting].event_type === 'Tournament' ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-sm"></i>' : '') +
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
                            "<br><b>" + events[eventsCounting].category_name + "</b><br>" + "<b>When: </b>" + events[eventsCounting].event_time + "<br>" + "<b>Description: </b>" + events[eventsCounting].event_description + "<br><br>" +
                            '</div><div class="modal-footer border-0">' +
                            (events[eventsCounting].event_type !== 'Standard' ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-lg"></i>' : '') +
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

                        if (events[eventsCounting].event_type !== "Standard" && events[eventsCounting].event_type === "Tournament") {
                          // Create the tournament modal
                          var tournamentModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                          tournamentModal.attr('id', 'tournament-modal-' + events[eventsCounting].event_id);
                          tournamentModal.attr('aria-hidden', 'true');
                          tournamentModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Tournament Modal Title</h3></div><div class="modal-body text-center"><img src="../pictures/sampleTournamentBraket.png" alt="TournamentBracket"></div><div class="modal-footer border-0"><button type="button" class="outline-button ms-auto" id="back-button" data-bs-dismiss="modal">Back</button></div></div></div>');
                        
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
                        addToCalendarModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Add Event To Date</h3></div><div class="modal-body text-center"><p>Do you wish to add the event to your calendar</p><br><pre id="content"></pre><div class="d-flex justify-content-evenly"><button class="outline-button" id="authorize_button" onclick="handleAuthClick(\'' + events[eventsCounting].event_date + '\', \'' + events[eventsCounting].category_name.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_description.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_time + '\')">Yes</button><button type="button" class="outline-button" id="no-button" data-bs-dismiss="modal">No</button></div></div>');

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

              // Check if the date is today or a future date
              if (
                year > currentYear ||
                (year === currentYear && month > currentMonth) ||
                (year === currentYear && month === currentMonth && date >= currentDay)
              ) {

                // Add a light-colored circle for the current date
                if (year === currentYear && month === currentMonth && date === currentDay) {
                  dateText.addClass('current-date');
                }

                var plusIcon = $('<span>').addClass('calendar-day-plus').text('+').hide();
                div.append(plusIcon);
              }

              cell.append(div);
              date++;
              cell.on('mouseover', function() {
                $(this).find('.calendar-day-plus').show();
              }).on('mouseout', function() {
                $(this).find('.calendar-day-plus').hide();
              }).on('click', function(e) {
                // Only show modal if the '+' icon was clicked
                if ($(e.target).hasClass('calendar-day-plus')) {
                  // Hide all other popovers
                  $('[data-bs-toggle="popover"]').not(this).popover('hide');

                  // Get the date from the cell's text
                  var selectedDate = $(this).find('span:first-child').text();

                  // Create the modal HTML
                  var modalHtml = `
                  <div class="modal fade" id="createEventModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" data-bs-animation="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable custom-modal-width">
                      <div class="modal-content form-modal-content">
                        <div class="modal-header invisible-header">
                          <button type="button" class="btn btn-lg close-btn" data-bs-dismiss="modal" aria-label="Close">X</button>
                        </div>
                        <form id="dateTimeSubmitForm" method="POST">
                          <div class="modal-body">
                            <input type="hidden" id="date" name="date">
                            <input type="hidden" id="time" name="time">
                            <div class="mb-4 row justify-content-md-center align-items-stretch" id="dateTextLabel">
                              <label for="selectedDate" class="col-lg-1 g-1 col-form-label">Date</label>
                              <div class="col-sm-10">
                                <input type="text" id="selectedDate" class="form-control text-center" disabled readonly>
                              </div>
                            </div>   
                            <div class="d-flex" id="addChevronContainer">
                              <i id="addHour" class='bx bxs-up-arrow bx-sm'></i>
                              <i id="addMin" class='bx bxs-up-arrow bx-sm'></i>   
                            </div>
                            <div class="row justify-content-md-center align-items-stretch g-2" id="timeInputFields">
                              <div class="col-auto">
                                <label class="col-form-label" id="timeTextLabel">Time</label>
                              </div>
                              <div class="col-sm-3 align-self-center">
                                <input type="number" id="hourInput" class="form-control text-center" required>
                              </div>
                              <div class="col-auto">
                                <label class="col-form-label mb-0" id="colonTime"><b>:</b></label>
                              </div>
                              <div class="col-sm-3 align-self-center">
                                <input type="number" id="minsInput" class="form-control text-center" min="0" max="59" required>
                              </div>
                              <div class="col-auto flex-fill d-flex align-items-stretch">
                                <button type="button" id="amButton" class="btn btn-primary w-100" value="AM">AM</button>
                              </div>
                              <div class="col-auto flex-fill d-flex align-items-stretch">
                                <button type="button" id="pmButton" class="btn btn-outline-primary w-100" value="PM">PM</button>
                              </div>
                            </div>
                            <div class="d-flex" id="subChevronContainer">
                              <i id="subHour" class='bx bxs-down-arrow bx-sm'></i>
                              <i id="subMin" class='bx bxs-down-arrow bx-sm'></i>
                            </div>
                            <div class="errorDateTimeInput">
                            </div>
                          </div>
                          <div class="modal-footer d-flex justify-content-evenly invisible-footer">
                            <button type="submit" id="createEventButton" class="outline-button" value="createEvent">Create Event</button>
                            <button type="submit" id="createAnnouncementButton" class="outline-button" value="createAnnouncement">Create Announcement</button>
                          </div>
                        </form>
                        <br>
                      </div>
                    </div>
                  </div>
                  `;

                  // Append modal HTML to the document body
                  document.body.insertAdjacentHTML('beforeend', modalHtml);

                  // Attach event listener to hourInput
                  var hourInput = document.getElementById('hourInput');
                  hourInput.addEventListener('blur', function () {
                    var value = hourInput.value.trim();
                    var intValue = parseInt(value, 10);

                    if (isNaN(intValue) || intValue <= 0) {
                      hourInput.value = '12';
                    } else if (intValue > 12) {
                      hourInput.value = '12';
                    } else if (value.length === 1) {
                      hourInput.value = '0' + value;
                    } else {
                      hourInput.value = value;
                    }

                    updateHiddenDateInput(year, month, selectedDate);
                    updateHiddenTimeInput();

                    // If the hour input is left blank, default to 12
                    if (hourInput.value === '') {
                      hourInput.value = '12';
                    }
                  });

                  // Attach event listener to minsInput
                  var minsInput = document.getElementById('minsInput');
                  minsInput.addEventListener('blur', function () {
                    var value = minsInput.value.trim();
                    var intValue = parseInt(value, 10);

                    if (isNaN(intValue) || intValue < 0 || intValue > 59) {
                      minsInput.value = '00';
                    } else if (value.length === 1) {
                      minsInput.value = '0' + value;
                    } else {
                      minsInput.value = value;
                    }

                    updateHiddenDateInput(year, month, selectedDate);
                    updateHiddenTimeInput();

                    // If the minute input is left blank, default to 00
                    if (minsInput.value === '') {
                      minsInput.value = '00';
                    }
                  });
                  
                  // Remove event listeners from addHour and subHour icons
                  var addHourIcon = document.getElementById('addHour');
                  var subHourIcon = document.getElementById('subHour');
                  var addHourIconClone = addHourIcon.cloneNode(true);
                  var subHourIconClone = subHourIcon.cloneNode(true);
                  addHourIcon.parentNode.replaceChild(addHourIconClone, addHourIcon);
                  subHourIcon.parentNode.replaceChild(subHourIconClone, subHourIcon);

                  // Remove event listeners from addMin and subMin icons
                  var addMinIcon = document.getElementById('addMin');
                  var subMinIcon = document.getElementById('subMin');
                  var addMinIconClone = addMinIcon.cloneNode(true);
                  var subMinIconClone = subMinIcon.cloneNode(true);
                  addMinIcon.parentNode.replaceChild(addMinIconClone, addMinIcon);
                  subMinIcon.parentNode.replaceChild(subMinIconClone, subMinIcon);

                  // Event listener for adding an hour
                  addHourIconClone.addEventListener('click', function () {
                    var currentHour = parseInt(hourInput.value);
                    if (currentHour < 12) {
                      hourInput.value = (currentHour + 1).toString().padStart(2, '0');
                    } else {
                      hourInput.value = '12'; // Set default to maximum value
                    }

                    updateHiddenTimeInput();

                    // Disable addHour icon if hour value reaches maximum
                    if (hourInput.value === '12') {
                      addHourIconClone.classList.add('disabled');
                    }

                    // Enable subHour icon when addHour is clicked
                    subHourIconClone.classList.remove('disabled');
                  });

                  // Event listener for adding a minute
                  addMinIconClone.addEventListener('click', function () {
                    var currentMins = parseInt(minsInput.value);
                    if (currentMins < 59) {
                      minsInput.value = (currentMins + 1).toString().padStart(2, '0');
                    } else {
                      minsInput.value = '59'; // Set default to maximum value
                    }

                    updateHiddenTimeInput();

                    // Disable addMin icon if minute value reaches maximum
                    if (minsInput.value === '59') {
                      addMinIconClone.classList.add('disabled');
                    }

                    // Enable subMin icon when addMin is clicked
                    subMinIconClone.classList.remove('disabled');
                  });

                  // Event listener for subtracting an hour
                  subHourIconClone.addEventListener('click', function () {
                    var currentHour = parseInt(hourInput.value);
                    if (currentHour > 1) {
                      hourInput.value = (currentHour - 1).toString().padStart(2, '0');
                    } else {
                      hourInput.value = '01'; // Set default to minimum value
                    }

                    updateHiddenTimeInput();

                    // Disable subHour icon if hour value reaches minimum
                    if (hourInput.value === '01') {
                      subHourIconClone.classList.add('disabled');
                    }

                    // Enable addHour icon when subHour is clicked
                    addHourIconClone.classList.remove('disabled');
                  });

                  // Event listener for subtracting a minute
                  subMinIconClone.addEventListener('click', function () {
                    var currentMins = parseInt(minsInput.value);
                    if (currentMins > 0) {
                      minsInput.value = (currentMins - 1).toString().padStart(2, '0');
                    } else {
                      minsInput.value = '00'; // Set default to minimum value
                    }

                    updateHiddenTimeInput();

                    // Disable subMin icon if minute value reaches minimum
                    if (minsInput.value === '00') {
                      subMinIconClone.classList.add('disabled');
                    }

                    // Enable addMin icon when subMin is clicked
                    addMinIconClone.classList.remove('disabled');
                  });

                  // Define a variable to store the interval ID
                  var intervalId;

                  // Function to handle continuous value update
                  function updateValue(valueElement, step, maxValue) {
                    var value = parseInt(valueElement.value);

                    // Increase or decrease the value by the step amount
                    value += step;

                    // Make sure the value stays within the valid range
                    value = Math.max(0, Math.min(maxValue, value));

                    // Update the input value
                    valueElement.value = value.toString().padStart(2, '0');

                    // Update the hidden inputs
                    updateHiddenDateInput(year, month, selectedDate);
                    updateHiddenTimeInput();
                  }

                  // Event listener for adding an hour
                  addHourIconClone.addEventListener('mousedown', function () {
                    intervalId = setInterval(function () {
                      updateValue(hourInput, 2, 12);
                    }, 100); // Adjust the interval time as needed
                  });

                  // Event listener for adding a minute
                  addMinIconClone.addEventListener('mousedown', function () {
                    intervalId = setInterval(function () {
                      updateValue(minsInput, 2, 59);
                    }, 100); // Adjust the interval time as needed
                  });

                  // Event listener for subtracting an hour
                  subHourIconClone.addEventListener('mousedown', function () {
                    intervalId = setInterval(function () {
                      updateValue(hourInput, -2, 12);
                    }, 100); // Adjust the interval time as needed
                  });

                  // Event listener for subtracting a minute
                  subMinIconClone.addEventListener('mousedown', function () {
                    intervalId = setInterval(function () {
                      updateValue(minsInput, -2, 59);
                    }, 100); // Adjust the interval time as needed
                  });

                  // Event listener for mouseup event to clear the interval
                  document.addEventListener('mouseup', function () {
                    clearInterval(intervalId);
                  });

                  // Function to update the hidden time input
                  function updateHiddenTimeInput() {
                    var hour = hourInput.value;
                    var mins = minsInput.value;
                    var period = '';

                    if (amButton.classList.contains('btn-primary')) {
                      period = 'AM';
                    } else if (pmButton.classList.contains('btn-primary')) {
                      period = 'PM';
                    }

                    var formattedTime = hour + ':' + mins + ' ' + period;

                    var timeParts = formattedTime.split(' ');
                    var time = timeParts[0];
                    var period = timeParts[1];

                    var [hour, mins] = time.split(':');
                    hour = parseInt(hour);

                    if (period === 'PM' && hour !== 12) {
                      hour += 12;
                    } else if (period === 'AM' && hour === 12) {
                      hour = 0;
                    }

                    var formattedTime24Hour = hour.toString().padStart(2, '0') + ':' + mins;

                    var hiddenTimeInput = document.getElementById('time');
                    hiddenTimeInput.value = formattedTime24Hour;

                    // Update the time-related variables
                    originalTime = formattedTime24Hour;
                    currentTime = hiddenTimeInput.value;

                    // Enable all icons
                    document.getElementById('addHour').classList.remove('disabled');
                    document.getElementById('addMin').classList.remove('disabled');
                    document.getElementById('subHour').classList.remove('disabled');
                    document.getElementById('subMin').classList.remove('disabled');
                  }

                  // Get the buttons for AM and PM
                  var amButton = document.querySelector('#createEventModal .modal-body button[value="AM"]');
                  var pmButton = document.querySelector('#createEventModal .modal-body button[value="PM"]');

                  // Function to handle button selection
                  function handleButtonSelection(selectedButton, deselectedButton) {
                    selectedButton.classList.remove('btn-outline-primary');
                    selectedButton.classList.add('btn-primary');

                    deselectedButton.classList.remove('btn-primary');
                    deselectedButton.classList.add('btn-outline-primary');
                  }

                  // Select the AM button by default
                  handleButtonSelection(amButton, pmButton);

                  // Event listener for AM button
                  amButton.addEventListener('click', function () {
                    handleButtonSelection(amButton, pmButton);
                    updateHiddenDateInput(year, month, selectedDate);
                    updateHiddenTimeInput();
                  });

                  // Event listener for PM button
                  pmButton.addEventListener('click', function () {
                    handleButtonSelection(pmButton, amButton);
                    updateHiddenDateInput(year, month, selectedDate);
                    updateHiddenTimeInput();
                  });

                  var originalDate = '';

                  function updateHiddenDateInput(year, month, selectedDate) {
                    var formattedDate = new Date(year, month, selectedDate);
                    var selectedDateToSubmit = formattedDate.toLocaleDateString();
                    // Split the date string using "/"
                    var dateComponents = selectedDateToSubmit.split('/');
                    // Reformat the date components to "yyyy-mm-dd" format
                    var formattedDateToSubmit = dateComponents[2] + '-' + dateComponents[0].padStart(2, '0') + '-' + dateComponents[1].padStart(2, '0');
                    // Convert the date string to a Date object
                    var dateObj = new Date(formattedDateToSubmit);
                    // Define the options for formatting the date
                    var options = { year: 'numeric', month: 'long', day: 'numeric' };
                    // Format the date using the options
                    var dateToShow = dateObj.toLocaleDateString('en-US', options);
                    // Set the value of selectedDate input field
                    var selectedDateInput = document.getElementById('selectedDate');
                    selectedDateInput.value = dateToShow;
                    // Set the value of the hidden input field
                    var hiddenDateInput = document.getElementById('date');
                    hiddenDateInput.value = formattedDateToSubmit;

                    // Update the time-related variables
                    originalDate = formattedDateToSubmit;
                    currentDate = hiddenDateInput.value;
                  }

                  updateHiddenDateInput(year, month, selectedDate);
                  
                  // Attach click event listeners to the buttons
                  $('#createEventButton').click(function() {
                    $('#dateTimeSubmitForm').attr('action', './EVE-admin-create-event.php');
                  });

                  $('#createAnnouncementButton').click(function() {
                    $('#dateTimeSubmitForm').attr('action', './HOM-create-post.php');
                  });

                  // Open the modal
                  var createEventModal = new bootstrap.Modal(document.getElementById('createEventModal'));
                  createEventModal.show();

                  // Attach submit event listener to the form
                  var dateTimeSubmitForm = document.getElementById('dateTimeSubmitForm');
                  dateTimeSubmitForm.addEventListener('submit', function (event) {
                    event.preventDefault(); // Prevent the default form submission behavior

                    // Get the current time and date values
                    var currentTime = document.getElementById('time').value;
                    var currentDate = document.getElementById('date').value;

                    // Check if the modal is open and compare the values with the original time and date
                    if (createEventModal._isShown && (currentTime !== originalTime || currentDate !== originalDate)) {
                      // Values don't match, display error message and prevent form submission
                      var errorDateTimeInput = document.querySelector('.errorDateTimeInput');
                      errorDateTimeInput.textContent = 'Error! Something went wrong please try to click again!';
                      document.getElementById('time').value = originalTime; // Set original time as the input value
                      document.getElementById('date').value = originalDate; // Set original date as the input value
                      return; // Stop further execution of the code
                    }
                    dateTimeSubmitForm.submit();
                  });

                  // Event listener for modal close event
                  createEventModal._element.addEventListener('hidden.bs.modal', function () {
                    // Reset the values of hidden inputs
                    document.getElementById('date').value = '';
                    document.getElementById('time').value = '';

                    // Reset hours, minutes, and AM/PM selection
                    document.getElementById('hourInput').value = '';
                    document.getElementById('minsInput').value = '';
                    handleButtonSelection(amButton, pmButton);
                  });
                }
              });         
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
    generateCalendar(currentMonth, currentYear, filters); 
    generateMiniCalendar(currentMonth, currentYear, filters);

    var prevMonthInterval;
    var nextMonthInterval;

    $("#prev-month").mousedown(function() {
      $('[data-bs-toggle="popover"]').not(this).popover('hide');
      currentMonth--;
      if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
      }
      generateCalendar(currentMonth, currentYear, filters);
      generateMiniCalendar(currentMonth, currentYear, filters);

      prevMonthInterval = setInterval(function() {
        currentMonth--;
        if (currentMonth < 0) {
          currentMonth = 11;
          currentYear--;
        }
        generateCalendar(currentMonth, currentYear, filters);
        generateMiniCalendar(currentMonth, currentYear, filters);
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
      generateCalendar(currentMonth, currentYear, filters);
      generateMiniCalendar(currentMonth, currentYear, filters);

      nextMonthInterval = setInterval(function() {
        currentMonth++;
        if (currentMonth > 11) {
          currentMonth = 0;
          currentYear++;
        }
        generateCalendar(currentMonth, currentYear, filters);
        generateMiniCalendar(currentMonth, currentYear, filters);
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

    function generateMiniCalendar(month, year, filters) {
      // Get number of days in the month and the first day of the month
      let numDays = new Date(year, month + 1, 0).getDate();
      let firstDay = new Date(year, month, 1).getDay();

      // Clear the calendar table
      let calendarBody = document.getElementById("miniCalendarTable");
      calendarBody.innerHTML = "";

      let currentDate = new Date();  // Get the current date
      let currentDay = currentDate.getDate();  // Get the day of the current date
      let currentMonth = currentDate.getMonth();  // Get the month of the current date
      let currentYear = currentDate.getFullYear();  // Get the year of the current date

      // Set the calendar title
      let currentMonthYear = document.getElementById("miniCalendarHeader");
      currentMonthYear.innerHTML = "<strong>" + months[month] + "</strong> " + year;

      // Generate calendar days
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
                cell.classList.add("mini-active");
              }
              cell.appendChild(div);
              date++;
            } else {
              // Cell is after the last day of the month
              cell.classList.add("mini-disabled");
            }
          }

          // Add click event listener to each cell
          cell.addEventListener('click', (event) => {
            const clickedCell = event.target.closest('td'); // Get the closest ancestor <td> element

            // Check if the clicked cell has the "disabled" class
            if (!clickedCell.classList.contains('mini-disabled')) {
              // Remove the 'active' class from all cells
              const allCells = document.querySelectorAll('#miniCalendarTable td');
              allCells.forEach((cell) => {
                cell.classList.remove('mini-active');
              });

              // Add the 'active' class to the clicked cell
              clickedCell.classList.add('mini-active');

              // Get the clicked date from the cell's text content
              const clickedDate = parseInt(clickedCell.textContent);

              // Set the calendar title
              let currentMonthYear = document.getElementById("miniCalendarHeader");
              currentMonthYear.innerHTML = "<strong>" + months[month] + "</strong> " + year;

              generateCalendar(month, year, filters);

              cellClicked = clickedDate;
            }
          });
          row.appendChild(cell);
        }
        calendarBody.appendChild(row);
      }
    } 

    $("#miniPreviousButton").mousedown(function() {
      $('[data-bs-toggle="popover"]').not(this).popover('hide');   
       
      currentMonth--;
      if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
      }
      generateCalendar(currentMonth, currentYear, filters);
      generateMiniCalendar(currentMonth, currentYear, filters);

      prevMonthInterval = setInterval(function() {
        currentMonth--;
        if (currentMonth < 0) {
          currentMonth = 11;
          currentYear--;
        }
        generateCalendar(currentMonth, currentYear, filters);
        generateMiniCalendar(currentMonth, currentYear, filters);

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
      generateCalendar(currentMonth, currentYear, filters);
      generateMiniCalendar(currentMonth, currentYear, filters);

      nextMonthInterval = setInterval(function() {
        currentMonth++;
        if (currentMonth > 11) {
          currentMonth = 0;
          currentYear++;
        }
        generateCalendar(currentMonth, currentYear, filters);
        generateMiniCalendar(currentMonth, currentYear, filters);

      }, 100); // Adjust the interval time (in milliseconds) for the desired scrolling speed
    }).mouseup(function() {
      clearInterval(nextMonthInterval);
    }).mouseleave(function() {
      clearInterval(nextMonthInterval);
    });

    // Close button click event
    $("#closeButton").click(function() {
      $("#miniCalendarContainer").hide();
    });

    // Today button click event
    $("#todayButton").click(function() {
      var currentDate = new Date();
      currentMonth = currentDate.getMonth();
      currentYear = currentDate.getFullYear();

      generateCalendar(currentMonth, currentYear, filters);
      generateMiniCalendar(currentMonth, currentYear, filters);
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
      generateCalendar(currentMonth, currentYear, filters);
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

    /*
    function updateCalendarOrg() {
      generateCalendar(currentMonth, currentYear, filtersOrg);
    }*/

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

var adminCalendarPhone = {
  initialize: function() {
    var filters = ["Tournament", "Competition", "Standard"];
    var filtersOrg = [];
    var selectedDate = null;
    var currentDate = new Date(); // Get the current date
    
    function generateCalendar(month, year, filters) {
      // Get number of days in the month and the first day of the month
      var numDays = new Date(year, month + 1, 0).getDate();
      var firstDay = new Date(year, month, 1).getDay();
    
      // Clear the calendar table
      var calendarBody = document.getElementById("mobile-calendar-days");
      calendarBody.innerHTML = "";
    
      // Set the calendar title
      var currentMonthYear = document.getElementById("current-month");
      currentMonthYear.innerHTML = "<strong>" + months[month] + "</strong> " + year;

      var currentDay = currentDate.getDate(); // Get the day of the current date
      var currentMonth = currentDate.getMonth(); // Get the month of the current date
      var currentYear = currentDate.getFullYear(); // Get the year of the current date
    
      $.ajax({
        url: './php/CAL-get-events-calendar.php',
        type: 'GET',
        data: {
          year: year,
          month: month + 1,
          filters: filters
        },
        success: function(data) {
          var events = JSON.parse(data);
          
          events.sort(function(a, b) {
            var dateA = new Date(a.event_date);
            var dateB = new Date(b.event_date);
            return dateA - dateB;
          });

          var showSelectedEventsContainer = document.getElementById("showSelectedEvents");
      
          // Clear previous event details
          showSelectedEventsContainer.innerHTML = "";
      
           // Iterate over events data and populate details
          for (var i = 0; i < events.length; i++) {
            var event = events[i];
            var eventDate = new Date(event.event_date);
            var eventYear = eventDate.getFullYear();
            var eventMonth = eventDate.getMonth();
            var eventDay = eventDate.getDate();

            // Check if the event date matches the selected date or the current date
            if ((selectedDate && eventYear === selectedDate.getFullYear() && eventMonth === selectedDate.getMonth() && eventDay === selectedDate.getDate()) || (!selectedDate && eventYear === currentYear && eventMonth === currentMonth && eventDay === currentDay)) {
              // Create the necessary elements
              var div = document.createElement("div");
              div.className = "div";
              var element = document.createElement("div");
              element.className = "element";
              var row = document.createElement("div");
              row.className = "row";
              var elementGroup = document.createElement("div");
              elementGroup.className = "element-group";
              var elementLabel = document.createElement("div");
              elementLabel.className = "element-label";
              elementLabel.textContent = event.category_name;
              var elementContent = document.createElement("div");
              elementContent.className = "element-content";
              elementContent.innerHTML = event.event_description + "<br>" + event.event_date;

              // Append elements to the container
              elementGroup.appendChild(elementLabel);
              elementGroup.appendChild(elementContent);
              row.appendChild(elementGroup);
              element.appendChild(row);
              div.appendChild(element);
              showSelectedEventsContainer.appendChild(div);
            }
          }

          var showUpcomingEventsContainer = document.getElementById("showUpcomingEvents");

          // Clear previous upcoming events
          showUpcomingEventsContainer.innerHTML = "";

          // Get tomorrow's date
          var tomorrow = new Date();
          tomorrow.setDate(tomorrow.getDate() + 1);

          // Iterate over events data and populate upcoming events
          for (var i = 0; i < events.length; i++) {
            var event = events[i];
            var eventDate = new Date(event.event_date);

            // Check if the event date is tomorrow or later
            if (eventDate > currentDate && eventDate.getMonth() === month) {
              // Create the necessary elements
              var div = document.createElement("div");
              div.className = "div";
              var element = document.createElement("div");
              element.className = "element";
              var row = document.createElement("div");
              row.className = "row";
              var elementGroup = document.createElement("div");
              elementGroup.className = "element-group";
              var elementLabel = document.createElement("div");
              elementLabel.className = "element-label";
              elementLabel.textContent = event.category_name;
              var elementContent = document.createElement("div");
              elementContent.className = "element-content";
              elementContent.innerHTML = event.event_description + "<br>" + event.event_date;

              // Append elements to the container
              elementGroup.appendChild(elementLabel);
              elementGroup.appendChild(elementContent);
              row.appendChild(elementGroup);
              element.appendChild(row);
              div.appendChild(element);
              showUpcomingEventsContainer.appendChild(div);
            }
          }

        },
        error: function(error) {
          console.error('Error: ' + error.message);
        }
      });     
    
        var date = 1;
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
                var dateText = createClickableDateElement(year, month, date);

                div.appendChild(dateText);

                // Add a light-colored circle for the current date
                if (year === currentYear && month === currentMonth && date === currentDay) {
                  dateText.classList.add("current-day");
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
      updateTitle();
    }

    // Create the clickable span elements
    function createClickableDateElement(year, month, day) {
      var dateText = document.createElement("span");
      dateText.innerHTML = day;
      dateText.id = "clickable-date"; // Set the ID of the span element

      dateText.addEventListener("click", function () {
        // Remove 'current-day' class from previously clicked date
        var previouslyClicked = document.querySelector(".current-day");
        if (previouslyClicked) {
          previouslyClicked.classList.remove("current-day");
        }

        // Add 'current-day' class to the clicked date
        this.classList.add("current-day");

        // Update selectedDate and title
        selectedDate = new Date(year, month, parseInt(this.innerHTML));
        updateTitle();
        generateCalendar(month, year, filters);
      });

      return dateText;
    }
    
    function updateTitle() {
      var currentEventsTitle = document.getElementById("currentEventsTitle");
      if (selectedDate) {
        var formattedDate = selectedDate.toLocaleDateString(undefined, {
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        });
        currentEventsTitle.innerHTML = "Events on " + formattedDate;
      } else {
        var formattedCurrentDate = currentDate.toLocaleDateString(undefined, {
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        });
        currentEventsTitle.innerHTML = "Events on " + formattedCurrentDate;
      }
    }
    
    // Event listener for the previous month button
    document.getElementById("mobile-prev-month").addEventListener("click", function () {
      currentMonth--;
      if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
      }
      generateCalendar(currentMonth, currentYear, filters);
    });

    // Event listener for the next month button
    document.getElementById("mobile-next-month").addEventListener("click", function () {
      currentMonth++;
      if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
      }
      generateCalendar(currentMonth, currentYear, filters);
    });

    // Generate calendar for current month and year
    generateCalendar(currentMonth, currentYear, filters);

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
      generateCalendar(currentMonth, currentYear, filters);
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

    /*
    function updateCalendarOrg() {
      generateCalendar(currentMonth, currentYear, filtersOrg);
    }*/

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
      adminCalendarPhone.initialize();
    } else {
      adminCalendarComputer.initialize();
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