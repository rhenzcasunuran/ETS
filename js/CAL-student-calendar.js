var studentCalendarComputer = {
  initialize: function() {

    // Define current month, year, and month names
    var currentMonth = new Date().getMonth();
    var currentYear = new Date().getFullYear();
    var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

    var filters = ["Tournament", "Competition", "Standard"];
    var filtersOrg = []; // Array to store selected checkbox values
    
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
                          '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-sm"></i>' +
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

                        // Create modal for the event
                        var modal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                        modal.attr('id', 'event-modal-' + events[eventsCounting].event_id);
                        modal.attr('aria-hidden', 'true');
                        modal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">' +
                          "<b>" + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + "</b>" + '</h3></div><div class="modal-body text-center">' +
                          "<br><b>" + events[eventsCounting].category_name + "</b><br>" + "<b>When: </b>" + events[eventsCounting].event_time + "<br>" + "<b>Description: </b>" + events[eventsCounting].event_description + "<br><br>" +
                          '</div><div class="modal-footer border-0">'+ '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-lg"></i>' +
                          '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-lg"></i>'+'<button type="button" class="btn btn-outline-secondary rounded-pill ms-auto" data-bs-dismiss="modal">Back</button></div></div></div>');

                        // Append modal to body
                        $('body').append(modal);

                        // Delegate click event for "Show more details" text within the popover
                        $(document).on("click", ".show-more-details-popover", function() {
                          var modalId = $(this).attr('href');
                          $(modalId).modal('show');
                          $(this).closest('.popover').popover('hide');
                        });

                        // Create the tournament modal
                        var tournamentModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                        tournamentModal.attr('id', 'tournament-modal-' + events[eventsCounting].event_id);
                        tournamentModal.attr('aria-hidden', 'true');
                        tournamentModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Tournament Modal Title</h3></div><div class="modal-body text-center"><img src="../pictures/sampleTournamentBraket.png" alt="TournamentBracket"></div><div class="modal-footer border-0"><button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Back</button></div></div></div>');
                        
                        // Append the tournament modal to the body
                        $('body').append(tournamentModal);

                        // Event handler for the unique icon click event
                        $(document).on("click", '.bx-group', function() {
                          var eventId = $(this).attr('id');
                          $('#tournament-modal-' + eventId).modal('show');
                          $(this).closest('.popover').popover('hide');
                        });

                        // Create the addToCalendar modal
                        var addToCalendarModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                        addToCalendarModal.attr('id', 'add-to-calendar-modal-' + events[eventsCounting].event_id);
                        addToCalendarModal.attr('aria-hidden', 'true');
                        addToCalendarModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Add Event To Date</h3></div><div class="modal-body text-center"><p>Do you wish to add the event to your calendar</p><br><pre id="content"></pre><button class="btn btn-outline-secondary rounded-pill" id="authorize_button" onclick="handleAuthClick(\'' + events[eventsCounting].event_date + '\', \'' + events[eventsCounting].category_name.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_description.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_time + '\')">Yes</button><button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">No</button></div>');

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
                          '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-sm"></i>' +
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

                        // Create modal for the event
                        var modal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                        modal.attr('id', 'event-modal-' + events[eventsCounting].event_id);
                        modal.attr('aria-hidden', 'true');
                        modal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">' +
                        "<b>" + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + "</b>" + '</h3></div><div class="modal-body text-center">' +
                        "<br><b>" + events[eventsCounting].category_name + "</b><br>" + "<b>When: </b>" + events[eventsCounting].event_time + "<br>" + "<b>Description: </b>" + events[eventsCounting].event_description + "<br><br>" +
                        '</div><div class="modal-footer border-0">'+ '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-lg"></i>' +
                        '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-lg"></i>'+'<button type="button" class="btn btn-outline-secondary rounded-pill ms-auto" data-bs-dismiss="modal">Back</button></div></div></div>');

                        // Append modal to body
                        $('body').append(modal);

                        // Delegate click event for "Show more details" text within the popover
                        $(document).on("click", ".show-more-details-popover", function() {
                        var modalId = $(this).attr('href');
                          $(modalId).modal('show');
                          $(this).closest('.popover').popover('hide');
                        });

                        // Create the tournament modal
                        var tournamentModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                        tournamentModal.attr('id', 'tournament-modal-' + events[eventsCounting].event_id);
                        tournamentModal.attr('aria-hidden', 'true');
                        tournamentModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Tournament Modal Title</h3></div><div class="modal-body text-center"><img src="../pictures/sampleTournamentBraket.png" alt="TournamentBracket"></div><div class="modal-footer border-0"><button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Back</button></div></div></div>');

                        // Append the tournament modal to the body
                        $('body').append(tournamentModal);

                        // Event handler for the unique icon click event
                        $(document).on("click", '.bx-group', function() {
                        var eventId = $(this).attr('id');
                        $('#tournament-modal-' + eventId).modal('show');
                        $(this).closest('.popover').popover('hide');
                        });

                        // Create the addToCalendar modal
                        var addToCalendarModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                        addToCalendarModal.attr('id', 'add-to-calendar-modal-' + events[eventsCounting].event_id);
                        addToCalendarModal.attr('aria-hidden', 'true');
                        addToCalendarModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Add Event To Date</h3></div><div class="modal-body text-center"><p>Do you wish to add the event to your calendar</p><br><pre id="content"></pre><button class="btn btn-outline-secondary rounded-pill" id="authorize_button" onclick="handleAuthClick(\'' + events[eventsCounting].event_date + '\', \'' + events[eventsCounting].category_name.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_description.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_time + '\')">Yes</button><button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">No</button></div>');

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
                      '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-sm"></i>' +
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

                    // Create modal for the event
                    var modal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                    modal.attr('id', 'event-modal-' + events[eventsCounting].event_id);
                    modal.attr('aria-hidden', 'true');
                    modal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">' +
                    "<b>" + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + "</b>" + '</h3></div><div class="modal-body text-center">' +
                    "<br><b>" + events[eventsCounting].category_name + "</b><br>" + "<b>When: </b>" + events[eventsCounting].event_time + "<br>" + "<b>Description: </b>" + events[eventsCounting].event_description + "<br><br>" +
                    '</div><div class="modal-footer border-0">'+ '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-lg"></i>' +
                    '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-lg"></i>'+'<button type="button" class="btn btn-outline-secondary rounded-pill ms-auto" data-bs-dismiss="modal">Back</button></div></div></div>');

                    // Append modal to body
                    $('body').append(modal);

                    // Delegate click event for "Show more details" text within the popover
                    $(document).on("click", ".show-more-details-popover", function() {
                      var modalId = $(this).attr('href');
                      $(modalId).modal('show');
                      $(this).closest('.popover').popover('hide');
                    });

                    // Create the tournament modal
                    var tournamentModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                    tournamentModal.attr('id', 'tournament-modal-' + events[eventsCounting].event_id);
                    tournamentModal.attr('aria-hidden', 'true');
                    tournamentModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Tournament Modal Title</h3></div><div class="modal-body text-center"><img src="../pictures/sampleTournamentBraket.png" alt="TournamentBracket"></div><div class="modal-footer border-0"><button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Back</button></div></div></div>');
                    
                    // Append the tournament modal to the body
                    $('body').append(tournamentModal);

                    // Event handler for the unique icon click event
                    $(document).on("click", '.bx-group', function() {
                      var eventId = $(this).attr('id');
                      $('#tournament-modal-' + eventId).modal('show');
                      $(this).closest('.popover').popover('hide');
                    });

                    // Create the addToCalendar modal
                    var addToCalendarModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                    addToCalendarModal.attr('id', 'add-to-calendar-modal-' + events[eventsCounting].event_id);
                    addToCalendarModal.attr('aria-hidden', 'true');
                    addToCalendarModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Add Event To Date</h3></div><div class="modal-body text-center"><p>Do you wish to add the event to your calendar</p><br><pre id="content"></pre><button class="btn btn-outline-secondary rounded-pill" id="authorize_button" onclick="handleAuthClick(\'' + events[eventsCounting].event_date + '\', \'' + events[eventsCounting].category_name.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_description.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_time + '\')">Yes</button><button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">No</button></div>');

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
                          '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-sm"></i>' +
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

                        // Create modal for the event
                        var modal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                        modal.attr('id', 'event-modal-' + events[eventsCounting].event_id);
                        modal.attr('aria-hidden', 'true');
                        modal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">' +
                          "<b>" + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + "</b>" + '</h3></div><div class="modal-body text-center">' +
                          "<br><b>" + events[eventsCounting].category_name + "</b><br>" + "<b>When: </b>" + events[eventsCounting].event_time + "<br>" + "<b>Description: </b>" + events[eventsCounting].event_description + "<br><br>" +
                          '</div><div class="modal-footer border-0">'+ '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-lg"></i>' +
                          '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-lg"></i>'+'<button type="button" class="btn btn-outline-secondary rounded-pill ms-auto" data-bs-dismiss="modal">Back</button></div></div></div>');

                        // Append modal to body
                        $('body').append(modal);

                        // Delegate click event for "Show more details" text within the popover
                        $(document).on("click", ".show-more-details-popover", function() {
                          var modalId = $(this).attr('href');
                          $(modalId).modal('show');
                          $(this).closest('.popover').popover('hide');
                        });

                        // Create the tournament modal
                        var tournamentModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                        tournamentModal.attr('id', 'tournament-modal-' + events[eventsCounting].event_id);
                        tournamentModal.attr('aria-hidden', 'true');
                        tournamentModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Tournament Modal Title</h3></div><div class="modal-body text-center"><img src="../pictures/sampleTournamentBraket.png" alt="TournamentBracket"></div><div class="modal-footer border-0"><button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Back</button></div></div></div>');
                        
                        // Append the tournament modal to the body
                        $('body').append(tournamentModal);

                        // Event handler for the unique icon click event
                        $(document).on("click", '.bx-group', function() {
                          var eventId = $(this).attr('id');
                          $('#tournament-modal-' + eventId).modal('show');
                          $(this).closest('.popover').popover('hide');
                        });

                        // Create the addToCalendar modal
                        var addToCalendarModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                        addToCalendarModal.attr('id', 'add-to-calendar-modal-' + events[eventsCounting].event_id);
                        addToCalendarModal.attr('aria-hidden', 'true');
                        addToCalendarModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Add Event To Date</h3></div><div class="modal-body text-center"><p>Do you wish to add the event to your calendar</p><br><pre id="content"></pre><button class="btn btn-outline-secondary rounded-pill" id="authorize_button" onclick="handleAuthClick(\'' + events[eventsCounting].event_date + '\', \'' + events[eventsCounting].category_name.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_description.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_time + '\')">Yes</button><button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">No</button></div>');

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
                          '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-sm"></i>' +
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

                        // Create modal for the event
                        var modal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                        modal.attr('id', 'event-modal-' + events[eventsCounting].event_id);
                        modal.attr('aria-hidden', 'true');
                        modal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">' +
                        "<b>" + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + "</b>" + '</h3></div><div class="modal-body text-center">' +
                        "<br><b>" + events[eventsCounting].category_name + "</b><br>" + "<b>When: </b>" + events[eventsCounting].event_time + "<br>" + "<b>Description: </b>" + events[eventsCounting].event_description + "<br><br>" +
                        '</div><div class="modal-footer border-0">'+ '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-lg"></i>' +
                        '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-lg"></i>'+'<button type="button" class="btn btn-outline-secondary rounded-pill ms-auto" data-bs-dismiss="modal">Back</button></div></div></div>');

                        // Append modal to body
                        $('body').append(modal);

                        // Delegate click event for "Show more details" text within the popover
                        $(document).on("click", ".show-more-details-popover", function() {
                        var modalId = $(this).attr('href');
                        $(modalId).modal('show');
                        $(this).closest('.popover').popover('hide');
                        });

                        // Create the tournament modal
                        var tournamentModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                        tournamentModal.attr('id', 'tournament-modal-' + events[eventsCounting].event_id);
                        tournamentModal.attr('aria-hidden', 'true');
                        tournamentModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Tournament Modal Title</h3></div><div class="modal-body text-center"><img src="../pictures/sampleTournamentBraket.png" alt="TournamentBracket"></div><div class="modal-footer border-0"><button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Back</button></div></div></div>');

                        // Append the tournament modal to the body
                        $('body').append(tournamentModal);

                        // Event handler for the unique icon click event
                        $(document).on("click", '.bx-group', function() {
                        var eventId = $(this).attr('id');
                        $('#tournament-modal-' + eventId).modal('show');
                        $(this).closest('.popover').popover('hide');
                        });

                        // Create the addToCalendar modal
                        var addToCalendarModal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                        addToCalendarModal.attr('id', 'add-to-calendar-modal-' + events[eventsCounting].event_id);
                        addToCalendarModal.attr('aria-hidden', 'true');
                        addToCalendarModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header invisible-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Add Event To Date</h3></div><div class="modal-body text-center"><p>Do you wish to add the event to your calendar</p><br><pre id="content"></pre><button class="btn btn-outline-secondary rounded-pill" id="authorize_button" onclick="handleAuthClick(\'' + events[eventsCounting].event_date + '\', \'' + events[eventsCounting].category_name.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_description.replace(/'/g, "\\'") + '\', \'' + events[eventsCounting].event_time + '\')">Yes</button><button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">No</button></div>');

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
    generateCalendar(currentMonth, currentYear, filters); 

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

      prevMonthInterval = setInterval(function() {
        currentMonth--;
        if (currentMonth < 0) {
          currentMonth = 11;
          currentYear--;
        }
        generateCalendar(currentMonth, currentYear, filters);
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

      nextMonthInterval = setInterval(function() {
        currentMonth++;
        if (currentMonth > 11) {
          currentMonth = 0;
          currentYear++;
        }
        generateCalendar(currentMonth, currentYear, filters);
      }, 100); // Adjust the interval time (in milliseconds) for the desired scrolling speed
    }).mouseup(function() {
      clearInterval(nextMonthInterval);
    }).mouseleave(function() {
      clearInterval(nextMonthInterval);
    });

    const miniCalendarContainer = document.getElementById("miniCalendar");
    const miniCurrentDate = new Date();
    let miniCurrentMonth = miniCurrentDate.getMonth();
    let miniCurrentYear = miniCurrentDate.getFullYear();
    let miniSelectedDate = null;

    // Array of month names
    const miniMonthNames = [
      "January", "February", "March",
      "April", "May", "June",
      "July", "August", "September",
      "October", "November", "December"
    ];

    // Update the calendar based on the selected month and year
    function updateMiniCalendar() {
      // Get the calendar elements
      const miniCalendarHeader = document.getElementById("miniCalendarHeader");
      const miniPreviousButton = document.getElementById("miniPreviousButton");
      const miniNextButton = document.getElementById("miniNextButton");
      const miniCalendarTable = document.getElementById("miniCalendarTable");

      // Set the calendar header
      miniCalendarHeader.innerText = miniMonthNames[miniCurrentMonth] + " " + miniCurrentYear;

      // Add event listeners to the buttons
      miniPreviousButton.addEventListener("click", goToMiniPreviousMonth);
      miniNextButton.addEventListener("click", goToMiniNextMonth);

      // Clear the calendar table
      miniCalendarTable.innerHTML = "";

      // Generate calendar table headers (weekdays)
      const miniWeekdays = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
      const miniWeekdaysRow = document.createElement("tr");
      miniCalendarTable.appendChild(miniWeekdaysRow);
      miniWeekdays.forEach(function (weekday) {
        const miniTh = document.createElement("th");
        miniTh.innerText = weekday;
        miniWeekdaysRow.appendChild(miniTh);
      });

      // Get the first day of the month
      const miniFirstDay = new Date(miniCurrentYear, miniCurrentMonth, 1);
      const miniStartingDay = miniFirstDay.getDay();

      // Get the number of days in the month
      const miniLastDay = new Date(miniCurrentYear, miniCurrentMonth + 1, 0);
      const miniNumDays = miniLastDay.getDate();

      // Calculate the total number of rows needed
      const miniTotalRows = Math.ceil((miniNumDays + miniStartingDay) / 7);

      // Generate calendar days
      let miniDate = 1;
      for (let i = 0; i < miniTotalRows; i++) {
        const miniRow = document.createElement("tr");
        miniCalendarTable.appendChild(miniRow);
        for (let j = 0; j < 7; j++) {
          const miniCellIndex = i * 7 + j;
          const miniTd = document.createElement("td");
          if (miniCellIndex >= miniStartingDay && miniDate <= miniNumDays) {
            miniTd.innerText = miniDate;
            if (
              miniDate === miniCurrentDate.getDate() &&
              miniCurrentMonth === miniCurrentDate.getMonth() &&
              miniCurrentYear === miniCurrentDate.getFullYear()
            ) {
              miniTd.classList.add("current-day");
            }
            miniTd.addEventListener("click", function() {
              selectMiniDate(this);
            });
            miniDate++;
          }
          miniRow.appendChild(miniTd);
        }
      }
    }

    // Function to go to the next month
    function goToMiniNextMonth() {
      miniCurrentMonth++;
      if (miniCurrentMonth > 11) {
        miniCurrentMonth = 0;
        miniCurrentYear++;
      }
      updateMiniCalendar();
    }

    // Function to go to the previous month
    function goToMiniPreviousMonth() {
      miniCurrentMonth--;
      if (miniCurrentMonth < 0) {
        miniCurrentMonth = 11;
        miniCurrentYear--;
      }
      updateMiniCalendar();
    }

    // Function to select a date
    function selectMiniDate(miniDateCell) {
      if (miniSelectedDate) {
        miniSelectedDate.classList.remove("selected-day");
      }
      miniSelectedDate = miniDateCell;
      miniSelectedDate.classList.add("selected-day");

      // Remove current-day style from the previous current day
      const miniCurrentDay = document.querySelector(".current-day");
      if (miniCurrentDay) {
        miniCurrentDay.classList.remove("current-day");
      }

      // Add current-day style to the selected date
      miniSelectedDate.classList.add("current-day");

      displayMiniSelectedDate();
    }

    // Function to display the selected date below the calendar
    function displayMiniSelectedDate() {
      if (miniSelectedDate) {
        currentMonth = miniCurrentMonth;
        currentYear = miniCurrentYear;
        generateCalendar(miniCurrentMonth, miniCurrentYear, filters);
      }
    }

    // Generate initial mini calendar
    updateMiniCalendar();

    const miniCalendarToggle = document.getElementById("calendarToggle");
    const miniCalendar = document.getElementById("miniCalendar");

    miniCalendarToggle.addEventListener("click", function() {
      miniCalendar.style.display = miniCalendar.style.display === "none" ? "block" : "none";
    });

    displayMiniSelectedDate();

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

    /*
    function updateCalendarOrg() {
      generateCalendar(currentMonth, currentYear, filtersOrg);
    }*/

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
  }
}

var studentCalendarPhone = {
  initialize: function() {

    // Global variables
    var currentDate = new Date();
    var currentMonth = currentDate.getMonth();
    var currentYear = currentDate.getFullYear();

    // Function to generate the calendar for a specific month and year
    function generateCalendar(month, year) {
      var calendarBody = document.getElementById("mobile-calendar-days");
      calendarBody.innerHTML = ""; // Clear previous calendar

      // Get the first day of the month
      var firstDay = new Date(year, month, 1).getDay();

      // Get the number of days in the month
      var totalDays = new Date(year, month + 1, 0).getDate();

      // Create calendar cells
      var date = 1;
      for (var row = 0; row < 6; row++) {
        var newRow = calendarBody.insertRow(row);

        for (var col = 0; col < 7; col++) {
          if (row === 0 && col < firstDay) {
            // Leave cells before the first day empty
            var newCell = newRow.insertCell(col);
            newCell.innerHTML = "";
          } else if (date > totalDays) {
            // Leave cells empty
            var newCell = newRow.insertCell(col);
            newCell.innerHTML = "";
          } else {
            var newCell = newRow.insertCell(col);
            newCell.innerHTML = date;
            date++;

            // Highlight the current day
            if (date === currentDate.getDate() && month === currentMonth && year === currentYear) {
              newCell.classList.add("current-day");
            }
          }
        }
      }

      // Update the month and year in the calendar header
      document.getElementById("current-month").innerHTML = getMonthName(month) + " " + year;
    }

    // Helper function to get the month name
    function getMonthName(month) {
      var monthNames = [
        "January", "February", "March", "April", "May", "June", "July",
        "August", "September", "October", "November", "December"
      ];
      return monthNames[month];
    }

    // Event listener for the previous month button
    document.getElementById("mobile-prev-month").addEventListener("click", function () {
      currentMonth--;
      if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
      }
      generateCalendar(currentMonth, currentYear);
    });

    // Event listener for the next month button
    document.getElementById("mobile-next-month").addEventListener("click", function () {
      currentMonth++;
      if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
      }
      generateCalendar(currentMonth, currentYear);
    });

    // Generate the initial calendar
    generateCalendar(currentMonth, currentYear);
  }
}

var currentDeviceType = null;
var previousDeviceType = null;

function checkWindowSize() {
  var deviceType = window.innerWidth <= 1390 ? "Phone" : "Computer";

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
    checkWindowSize();
  });
}, 0);
