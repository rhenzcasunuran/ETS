$(document).ready(function() {
  // Define current month, year, and month names
  var currentMonth = new Date().getMonth();
  var currentYear = new Date().getFullYear();
  var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

  const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
  const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

  var filters = ["Tournament", "Competition", "Standard"];

  function generateCalendar(month, year, filters) {
    // Get number of days in the month and the first day of the month
    var numDays = new Date(year, month + 1, 0).getDate();
    var firstDay = new Date(year, month, 1).getDay();
  
    // Clear the calendar table
    $("#calendar tbody").empty();
  
    // Set the calendar title
    $("#calendar-title").html("<strong>" + months[month] + "</strong> " + year);

    $.ajax({
        url: 'http://localhost/ETS/php/CAL-get-events-calendar.php',
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
                      var button = $('<button type="button" class="btn btn-primary btn-sm calendar-smaller-btn">')
                        .addClass(events[eventsCounting].event_type)
                        .text(events[eventsCounting].event_name.length > 10 ? events[eventsCounting].event_name.substring(0, 10) + '...' : events[eventsCounting].event_name);

                      // Set data attributes for popper
                      button.attr('data-bs-toggle', 'popover');
                      button.attr('data-bs-content', '<div class="sec-paragraph">' +
                        '<div class="p4">' +
                        '<a href="javascript:void(0)" class="d-flex justify-content-end close-popover" aria-label="Close">X</a>' +
                        '<p><b>' + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + '</b></p>' +
                        '<p>' + events[eventsCounting].event_name + '</p>' +
                        '<p><b>When: </b>' + events[eventsCounting].event_time + '</p>' +
                        '<p><b>Description: </b>' + events[eventsCounting].event_description + '</p>' +
                        '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-lg"></i>' +
                        '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-lg"></i>' + 
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
                        "<br><b>" + events[eventsCounting].event_name + "</b><br>" + "<b>When: </b>" + events[eventsCounting].event_time + "<br>" + "<b>Description: </b>" + events[eventsCounting].event_description + "<br><br>" +
                        '</div><div class="modal-footer border-0">'+ '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-lg"></i>' +
                        '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-lg"></i>'+'<button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Back</button></div></div></div>');

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
                      tournamentModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Tournament Modal Title</h3></div><div class="modal-body text-center"><img src="../pictures/sampleTournamentBraket.png" alt="TournamentBracket"></div><div class="modal-footer border-0"><button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Back</button></div></div></div>');
                      
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
                      addToCalendarModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Add Event To Date</h3></div><div class="modal-body text-center"><p>Do you wish to add the event/s to your calendar</p><br><button type="button" class="btn btn-outline-secondary rounded-pill">Yes</button><button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">No</button></div>');

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
                      var button = $('<button type="button" class="btn btn-primary btn-sm calendar-smaller-btn">').addClass(events[eventsCounting].event_type).text(
                      events[eventsCounting].event_name.length > 10 ? events[eventsCounting].event_name.substring(0, 10) + '...' : events[eventsCounting].event_name);
                      // Set data attributes for event details
                      button.attr('data-bs-toggle', 'modal');
                      button.attr('data-bs-target', '#event-modal-' + events[eventsCounting].event_id);
                      cell.find('.d-grid').append(button);
                      // Create modal for the event
                      var modal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                      modal.attr('id', 'event-modal-' + events[eventsCounting].event_id);
                      modal.attr('aria-hidden', 'true');
                      modal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">' +
                      "<b>" + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + "</b>" + '</h3></div><div class="modal-body text-center">' +
                      "<br><b>" + events[eventsCounting].event_name + "</b><br>" + "<b>When: </b>" + events[eventsCounting].event_time + "<br>" + "<b>Description: </b>" + events[eventsCounting].event_description + "<br><br>" +
                      '</div><div class="modal-footer border-0">'+ '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-lg"></i>' +
                      '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-lg"></i>'+'<button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Back</button></div></div></div>');
                      
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
                      tournamentModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Tournament Modal Title</h3></div><div class="modal-body text-center"><img src="../pictures/sampleTournamentBraket.png" alt="TournamentBracket"></div><div class="modal-footer border-0"><button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Back</button></div></div></div>');
                      
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
                      addToCalendarModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Add Event To Date</h3></div><div class="modal-body text-center"><p>Do you wish to add the event/s to your calendar</p><br><button type="button" class="btn btn-outline-secondary rounded-pill">Yes</button><button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">No</button></div>');

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
                  var button = $('<button type="button" class="btn btn-primary btn-sm calendar-smaller-btn">')
                    .addClass(events[eventsCounting].event_type)
                    .text(events[eventsCounting].event_name.length > 10 ? events[eventsCounting].event_name.substring(0, 10) + '...' : events[eventsCounting].event_name);

                  // Set data attributes for popper
                  button.attr('data-bs-toggle', 'popover');
                  button.attr('data-bs-content', '<div class="sec-paragraph">' +
                    '<div class="p4">' +
                    '<a href="javascript:void(0)" class="d-flex justify-content-end close-popover" aria-label="Close">X</a>' +
                    '<p><b>' + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + '</b></p>' +
                    '<p>' + events[eventsCounting].event_name + '</p>' +
                    '<p><b>When: </b>' + events[eventsCounting].event_time + '</p>' +
                    '<p><b>Description: </b>' + events[eventsCounting].event_description + '</p>' +
                    '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-lg"></i>' +
                    '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-lg"></i>' + 
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
                  "<br><b>" + events[eventsCounting].event_name + "</b><br>" + "<b>When: </b>" + events[eventsCounting].event_time + "<br>" + "<b>Description: </b>" + events[eventsCounting].event_description + "<br><br>" +
                  '</div><div class="modal-footer border-0">'+ '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-lg"></i>' +
                  '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-lg"></i>'+'<button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Back</button></div></div></div>');

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
                  tournamentModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Tournament Modal Title</h3></div><div class="modal-body text-center"><img src="../pictures/sampleTournamentBraket.png" alt="TournamentBracket"></div><div class="modal-footer border-0"><button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Back</button></div></div></div>');
                  
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
                  addToCalendarModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Add Event To Date</h3></div><div class="modal-body text-center"><p>Do you wish to add the event/s to your calendar</p><br><button type="button" class="btn btn-outline-secondary rounded-pill">Yes</button><button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">No</button></div>');

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
                      var button = $('<button type="button" class="btn btn-primary btn-sm calendar-smaller-btn">')
                        .addClass(events[eventsCounting].event_type)
                        .text(events[eventsCounting].event_name.length > 10 ? events[eventsCounting].event_name.substring(0, 10) + '...' : events[eventsCounting].event_name);

                      // Set data attributes for popper
                      button.attr('data-bs-toggle', 'popover');
                      button.attr('data-bs-content', '<div class="sec-paragraph">' +
                        '<div class="p4">' +
                        '<a href="javascript:void(0)" class="d-flex justify-content-end close-popover" aria-label="Close">X</a>' +
                        '<p><b>' + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + '</b></p>' +
                        '<p>' + events[eventsCounting].event_name + '</p>' +
                        '<p><b>When: </b>' + events[eventsCounting].event_time + '</p>' +
                        '<p><b>Description: </b>' + events[eventsCounting].event_description + '</p>' +
                        '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-lg"></i>' +
                        '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-lg"></i>' + 
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
                        "<br><b>" + events[eventsCounting].event_name + "</b><br>" + "<b>When: </b>" + events[eventsCounting].event_time + "<br>" + "<b>Description: </b>" + events[eventsCounting].event_description + "<br><br>" +
                        '</div><div class="modal-footer border-0">'+ '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-lg"></i>' +
                        '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-lg"></i>'+'<button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Back</button></div></div></div>');

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
                      tournamentModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Tournament Modal Title</h3></div><div class="modal-body text-center"><img src="../pictures/sampleTournamentBraket.png" alt="TournamentBracket"></div><div class="modal-footer border-0"><button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Back</button></div></div></div>');
                      
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
                      addToCalendarModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Add Event To Date</h3></div><div class="modal-body text-center"><p>Do you wish to add the event/s to your calendar</p><br><button type="button" class="btn btn-outline-secondary rounded-pill">Yes</button><button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">No</button></div>');

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
                      var button = $('<button type="button" class="btn btn-primary btn-sm calendar-smaller-btn">').addClass(events[eventsCounting].event_type).text(
                      events[eventsCounting].event_name.length > 10 ? events[eventsCounting].event_name.substring(0, 10) + '...' : events[eventsCounting].event_name);
                      // Set data attributes for event details
                      button.attr('data-bs-toggle', 'modal');
                      button.attr('data-bs-target', '#event-modal-' + events[eventsCounting].event_id);
                      cell.find('.d-grid').append(button);
                      // Create modal for the event
                      var modal = $('<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog">');
                      modal.attr('id', 'event-modal-' + events[eventsCounting].event_id);
                      modal.attr('aria-hidden', 'true');
                      modal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">' +
                      "<b>" + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + "</b>" + '</h3></div><div class="modal-body text-center">' +
                      "<br><b>" + events[eventsCounting].event_name + "</b><br>" + "<b>When: </b>" + events[eventsCounting].event_time + "<br>" + "<b>Description: </b>" + events[eventsCounting].event_description + "<br><br>" +
                      '</div><div class="modal-footer border-0">'+ '<i id="' + events[eventsCounting].event_id + '" class="bx bx-group bx-lg"></i>' +
                      '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-lg"></i>'+'<button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Back</button></div></div></div>');
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
                      tournamentModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Tournament Modal Title</h3></div><div class="modal-body text-center"><img src="../pictures/sampleTournamentBraket.png" alt="TournamentBracket"></div><div class="modal-footer border-0"><button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Back</button></div></div></div>');
                      
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
                      addToCalendarModal.append('<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header"><h3 class="modal-title w-100 text-center" style="font-size: 24px;">Add Event To Date</h3></div><div class="modal-body text-center"><p>Do you wish to add the event/s to your calendar</p><br><button type="button" class="btn btn-outline-secondary rounded-pill">Yes</button><button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">No</button></div>');

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

                // Create the modal content with the date
                var modalContent = $('<div>').addClass('modal-body')

                // Create the modal header
                var modalHeader = $('<div>').addClass('modal-header').append(
                  $('<h5>').addClass('modal-title').text('Create Event/Announcement'),
                  $('<button>').addClass('btn-close').attr({
                    'type': 'button',
                    'data-bs-dismiss': 'modal',
                    'aria-label': 'Close'
                  })
                );

                // Create the form element
                var form = $('<form>').attr('action', 'another-page.html').attr('method', 'post');

                // Create the modal body
                var modalBody = $('<div>');

                var selectedDateToSubmit = new Date(year, month, selectedDate);

                // Create a hidden input field
                var hiddenInput = $('<input>').attr({
                  'type': 'hidden',
                  'name': 'selectedDateToSubmit',
                  'value': selectedDateToSubmit 
                });

                console.log(selectedDateToSubmit)

                // Create the selected date input field
                var selectedDateInput = $('<br><input>').attr({
                  'type': 'text',
                  'readonly': 'readonly',
                }).val(months[month] + ' ' + selectedDate + ', ' + year);

                // Create the hour input field
                var hourInput = $('<input>').attr({
                  'type': 'number',
                  'min': '1',
                  'max': '12',
                }).on('input', function() {
                  var value = $(this).val();

                  // Limit the input to two digits
                  if (value.length > 2) {
                    value = value.slice(0, 1);
                  }

                  // Update the input field value
                  $(this).val(value);
                });

                // Create the minutes input field
                var minsInput = $('<input>').attr({
                  'type': 'number',
                  'min': '0',
                  'max': '59',
                }).on('input', function() {
                  var value = $(this).val();

                  // Limit the input to two digits
                  if (value.length > 2) {
                    value = value.slice(0, 1);
                  }

                  // Add leading zero if the value is less than 10
                  if (value < 10) {
                    value = '0' + value;
                  }

                  // Update the input field value
                  $(this).val(value);
                });

                // Create the select element for AM/PM
                var ampmInput = $('<div>').addClass('d-flex mb-3');

                // Create the AM button
                var amButton = $('<button>')
                  .addClass('btn btn-link')
                  .attr({
                    'type': 'button',
                    'value': 'AM'
                  })
                  .text('AM')
                  .on('click', function() {
                    amButton.addClass('fw-bold');
                    pmButton.removeClass('fw-bold');
                  });

                // Create the PM button
                var pmButton = $('<button>')
                  .addClass('btn btn-link')
                  .attr({
                    'type': 'button',
                    'value': 'PM'
                  })
                  .text('PM')
                  .on('click', function() {
                    pmButton.addClass('fw-bold');
                    amButton.removeClass('fw-bold');
                  });

                  // Initialize the default selection as AM
                  amButton.addClass('fw-bold');

                  // Append the buttons to the AM/PM container
                  ampmInput.append(amButton, pmButton);

                  // Create the submit button
                  var createEventButton = $('<button type="submit" class="btn btn-outline-secondary">Create Event</button>');

                  // Create the cancel button
                  var createAnnouncementButton = $('<button type="submit" class="btn btn-outline-secondary">Create Announcement</button>');

                  // Append the selected date text, hour input field, and minutes input field to the modal body
                  modalBody.append(selectedDateInput, hourInput, minsInput, ampmInput, hiddenInput);

                  // Append the buttons to the modal body
                  modalBody.append(createEventButton, createAnnouncementButton);

                  // Append the modal body to the form
                  form.append(modalBody);

                  // Append the form to the modal content
                  modalContent.append(form);

                  // Create the modal content by combining the header, body, and footer
                  var modalContent = $('<div>').addClass('modal-content').append(
                    modalHeader,
                    modalBody
                  );

                  // Create the modal
                  var modal = $('<div>').addClass('modal fade').attr({
                    'data-bs-backdrop': 'static',
                    'data-bs-keyboard': 'false',
                    'tabindex': '-1'
                  }).append(
                    $('<div>').addClass('modal-dialog modal-dialog-centered').append(
                      modalContent
                    )
                  );

                  // Show the modal
                  modal.modal('show');
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

  $("#prev-month").click(function() {
    $('[data-bs-toggle="popover"]').not(this).popover('hide');
    currentMonth--;
    if (currentMonth < 0) {
      currentMonth = 11;
      currentYear--;
    }
    generateCalendar(currentMonth, currentYear, filters);
  });

  $("#next-month").click(function() {
    $('[data-bs-toggle="popover"]').not(this).popover('hide');
    currentMonth++;
    if (currentMonth > 11) {
      currentMonth = 0;
      currentYear++;
    }
    generateCalendar(currentMonth, currentYear, filters);
  });    

  $(document).on('click', 'button', function () {
    // Hide all other popovers
    $('[data-bs-toggle="popover"]').not(this).popover('hide');
  });

  $(document).on('click', '[data-bs-toggle="popover"]', function () {
    // Hide all other popovers
    $('[data-bs-toggle="popover"]').not(this).popover('hide');
  });

  // Initialize popovers
  $('[data-bs-toggle="popover"]').popover();  

  $(document).on("click", ".popover .close-popover" , function(){
    $(this).closest(".popover").popover('hide');
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
});