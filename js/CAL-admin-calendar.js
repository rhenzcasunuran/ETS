// Global variables
var currentMonth = new Date().getMonth();
var currentYear = new Date().getFullYear();
var months = [
  "January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

var adminCalendarComputer = {
  initialize: function() {
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
    let filters = [];
    let filtersOrg = [];

    function generateEventTypeCheckboxes(eventTypes) {
      const eventTypeCheckboxesContainer = $('#eventTypeCheckboxes');
      eventTypeCheckboxesContainer.empty(); // Clear previous checkboxes
    
      const allCheckbox = $('<div>').addClass('form-check');
    
      const allInput = $('<input>').addClass('form-check-input event-type-checkbox')
        .attr('type', 'checkbox')
        .attr('id', 'check-event-type-all');
    
      const allLabel = $('<label>').addClass('form-check-label')
        .attr('for', 'check-event-type-all')
        .text('All');
    
      allCheckbox.append(allInput);
      allCheckbox.append(allLabel);
    
      eventTypeCheckboxesContainer.append(allCheckbox);
    
      for (const eventType of eventTypes) {
        const checkbox = $('<div>').addClass('form-check');
    
        const input = $('<input>').addClass('form-check-input event-type-checkbox')
          .attr('type', 'checkbox')
          .val(eventType.event_type)
          .attr('id', `${eventType.event_type}`);
    
        const label = $('<label>').addClass('form-check-label')
          .attr('for', `${eventType.event_type}`)
          .text(eventType.event_type);
    
        checkbox.append(input);
        checkbox.append(label);
    
        eventTypeCheckboxesContainer.append(checkbox);
      }
    
      // Check all event type checkboxes initially
      $('.form-check-input.event-type-checkbox').prop('checked', true);
    
      // Update filters array when checkboxes are checked or unchecked
      $('.form-check-input.event-type-checkbox').change(function() {
        if ($(this).attr('id') === 'check-event-type-all') {
          // Check/uncheck all checkboxes
          const isChecked = $(this).prop('checked');
          $('.form-check-input.event-type-checkbox').not(this).prop('checked', isChecked);
        } else {
          // Uncheck "All" checkbox if any individual checkbox is unchecked
          if (!$(this).prop('checked')) {
            $('#check-event-type-all').prop('checked', false);
          } else {
            // Check "All" checkbox if all individual checkboxes (except "All") are checked
            const allCheckboxChecked = $('.form-check-input.event-type-checkbox:not(#check-event-type-all)').length === $('.form-check-input.event-type-checkbox:not(#check-event-type-all):checked').length;
            $('#check-event-type-all').prop('checked', allCheckboxChecked);
          }
        }
    
        filters = $('.form-check-input.event-type-checkbox:checked').map(function() {
          return $(this).val();
        }).get();
        updateCalendar();
      });
    
      // "All" checkbox functionality
      $('#check-event-type-all').change(function() {
        const isChecked = $(this).prop('checked');
        $('.form-check-input.event-type-checkbox').prop('checked', isChecked);
    
        filters = isChecked ? eventTypes.map(eventType => eventType.event_type) : [];
      });
    
      // Add initial checkbox values to the array
      filters = $('.form-check-input.event-type-checkbox:checked').map(function() {
        return $(this).val();
      }).get();
      updateCalendar();
    }
    
    // Fetch event type data from the server
    $.ajax({
      url: './php/CAL-get-event-types.php',
      method: 'GET',
      dataType: 'json',
      success: function(response) {
        // Generate the event type checkboxes and check all initially
        generateEventTypeCheckboxes(response.eventTypes);
        // Add initial checkbox values to the array
        filters = response.eventTypes.map(eventType => eventType.event_type);
      },
      error: function(xhr, error) {
        console.error('Error fetching event type data:', error);
        console.log('Response:', xhr.responseText); // Log the response text for debugging
      }
    });   
    
    function generateOrgCheckboxes(orgNames) {
      const orgCheckboxesContainer = $('#orgCheckboxes');
      orgCheckboxesContainer.empty(); // Clear previous checkboxes
    
      const allCheckbox = $('<div>').addClass('form-check');
    
      const allInput = $('<input>').addClass('form-check-input org-checkbox')
        .attr('type', 'checkbox')
        .attr('id', 'check-org-all');
    
      const allLabel = $('<label>').addClass('form-check-label')
        .attr('for', 'check-org-all');
      
      const span = $('<span>').addClass('pill-all')
        .text('All');
      
      allLabel.append(span);
      allCheckbox.append(allInput);
      allCheckbox.append(allLabel);
    
      orgCheckboxesContainer.append(allCheckbox);
    
      for (const orgName of orgNames) {
        const checkbox = $('<div>').addClass('form-check');
    
        const input = $('<input>').addClass('form-check-input org-checkbox')
          .attr('type', 'checkbox')
          .val(orgName.organization_name)
          .attr('id', `check-org-${orgName.organization_name}`);
    
        const label = $('<label>').addClass('form-check-label')
        .attr('for', `check-org-${orgName.organization_name}`);
        
        const span = $('<span>').addClass(`pill-${orgName.organization_name.toLowerCase()}`)
          .text(orgName.organization_name);
        
        label.append(span);
    
        checkbox.append(input);
        checkbox.append(label);
    
        orgCheckboxesContainer.append(checkbox);
      }
    
      // Check all organization checkboxes initially
      $('.form-check-input.org-checkbox').prop('checked', true);
    
      // Update filtersOrg array when checkboxes are checked or unchecked
      $('.form-check-input.org-checkbox').change(function() {
        if ($(this).attr('id') === 'check-org-all') {
          // Check/uncheck all checkboxes
          const isChecked = $(this).prop('checked');
          $('.form-check-input.org-checkbox').not(this).prop('checked', isChecked);
        } else {
          // Uncheck "All" checkbox if any individual checkbox is unchecked
          if (!$(this).prop('checked')) {
            $('#check-org-all').prop('checked', false);
          } else {
            // Check "All" checkbox if all individual checkboxes (except "All") are checked
            const allCheckboxChecked = $('.form-check-input.org-checkbox:not(#check-org-all)').length === $('.form-check-input.org-checkbox:not(#check-org-all):checked').length;
            $('#check-org-all').prop('checked', allCheckboxChecked);
          }
        }
    
        filtersOrg = $('.form-check-input.org-checkbox:checked').map(function() {
          return $(this).val();
        }).get();
        updateCalendarOrg();
      });
    
      // "All" checkbox functionality
      $('#check-org-all').change(function() {
        const isChecked = $(this).prop('checked');
        $('.form-check-input.org-checkbox').prop('checked', isChecked);
    
        filtersOrg = isChecked ? orgNames.map(orgName => orgName.organization_name) : [];
      });
    
      // Add initial checkbox values to the array
      filtersOrg = $('.form-check-input.org-checkbox:checked').map(function() {
        return $(this).val();
      }).get();
      updateCalendarOrg();
    }
    
    // Fetch organization data from the server
    $.ajax({
      url: './php/CAL-get-orgs.php',
      method: 'GET',
      dataType: 'json',
      success: function(response) {
        // Generate the organization checkboxes and check all initially
        generateOrgCheckboxes(response.orgNames);
        // Add initial checkbox values to the array
        filtersOrg = response.orgNames.map(orgName => orgName.organization_name);
      },
      error: function(xhr, error) {
        console.error('Error fetching organization data:', error);
        console.log('Response:', xhr.responseText); // Log the response text for debugging
      }
    }); 

    function updateCalendar() {
      generateCalendar(currentMonth, currentYear, filters, filtersOrg);
    }

    function updateCalendarOrg() {
      generateCalendar(currentMonth, currentYear, filters, filtersOrg);
    }   

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
                  var popoverContent = $('<div class="popover-content" id="remaining-popover-body"></div>');

                  for(var i = 0; i < currentEventNum; i++) {

                    if (i <= 1) {

                      // Create button for the event
                      var button = $('<button type="button" class="btn btn-primary btn-sm calendar-smaller-btn shown-event">')
                        .text(events[eventsCounting].category_name.length > 10 ? events[eventsCounting].category_name.substring(0, 10) + '...' : events[eventsCounting].category_name);

                      // Set data attributes for popper
                      button.attr('data-bs-toggle', 'popover');
                      button.attr('data-bs-content', '<div class="sec-paragraph shown-event-popover">' +
                          '<div class="p4">' +
                          '<a href="javascript:void(0)" class="d-flex justify-content-end close-popover no-underline-link" aria-label="Close">X</a>' +
                          '<h4 class="mb-0"><b>' + events[eventsCounting].category_name + '</b></h4>' +
                          '<p class="mb-0">' + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' }) + '</p>' +
                          '<p>' + events[eventsCounting].event_time + '</p>' +
                          '<div class="d-flex justify-content-between align-items-center">' +
                          '<div class="icon-container">' +
                          (events[eventsCounting].event_type === 'Standard' && events[eventsCounting].event_id.includes('Post') ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-news bx-sm"></i>' : '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-sm"></i>') +
                          '</div>' +
                          '<a href="#event-modal-' + events[eventsCounting].event_id + '" class="d-flex justify-content-end show-more-details-popover no-underline-link" aria-label="showMoreDetails">Show more details</a>' +
                          '</div>' +
                          '</div>');
                      button.attr('data-bs-html', 'true');

                      $(document).on('click', '.bx-news', function() {
                        var eventId = $(this).attr('id');
                        var postId = eventId.replace('Post_', '');
                        window.location.href = 'HOM-post.php?eec=' + postId;
                      });                      

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
                          (events[eventsCounting].event_type === 'Standard' && events[eventsCounting].event_id.includes('Post') ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-news bx-lg"></i>' : '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-lg"></i>') +
                          '<button type="button" class="outline-button ms-auto" id="back-button" data-bs-dismiss="modal">Back</button></div></div></div>');
                      
                      // Append modal to body
                      $('body').append(modal);

                      // Delegate click event for "Show more details" text within the popover
                      $(document).on("click", ".show-more-details-popover", function() {
                        var modalId = $(this).attr('href');
                        $(modalId).modal('show');
                        $(this).closest('.popover').popover('hide');
                      });

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
                          '<a href="javascript:void(0)" class="d-flex justify-content-end close-popover no-underline-link" aria-label="Close">X</a>' +
                          '<h4 class="mb-0"><b>' + events[eventsCounting].category_name + '</b></h4>' +
                          '<p class="mb-0">' + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' }) + '</p>' +
                          '<p>' + events[eventsCounting].event_time + '</p>' +
                          '<div class="d-flex justify-content-between align-items-center">' +
                          '<div class="icon-container">' +
                          (events[eventsCounting].event_type === 'Standard' && events[eventsCounting].event_id.includes('Post') ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-news bx-sm"></i>' : '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-sm"></i>') +
                          '</div>' +
                          '<a href="#event-modal-' + events[eventsCounting].event_id + '" class="d-flex justify-content-end show-more-details-popover no-underline-link" aria-label="showMoreDetails">Show more details</a>' +
                          '</div>' +
                          '</div>');
                      button.attr('data-bs-html', 'true');

                      $(document).on('click', '.bx-news', function() {
                        var eventId = $(this).attr('id');
                        var postId = eventId.replace('Post_', '');
                        window.location.href = 'HOM-post.php?eec=' + postId;
                      });                      

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
                          (events[eventsCounting].event_type === 'Standard' && events[eventsCounting].event_id.includes('Post') ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-news bx-lg"></i>' : '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-lg"></i>') +
                          '<button type="button" class="outline-button ms-auto" id="back-button" data-bs-dismiss="modal">Back</button></div></div></div>');
                      
                      // Append modal to body
                      $('body').append(modal);

                      // Delegate click event for "Show more details" text within the popover
                      $(document).on("click", ".show-more-details-popover", function() {
                      var modalId = $(this).attr('href');
                        $(modalId).modal('show');
                        $(this).closest('.popover').popover('hide');
                      });

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
                      '<a href="javascript:void(0)" class="d-flex justify-content-end close-popover no-underline-link" aria-label="Close">X</a>' +
                      '<h4 class="mb-0"><b>' + events[eventsCounting].category_name + '</b></h4>' +
                      '<p class="mb-0">' + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' }) + '</p>' +
                      '<p>' + events[eventsCounting].event_time + '</p>' +
                      '<div class="d-flex justify-content-between align-items-center">' +
                      '<div class="icon-container">' +
                      (events[eventsCounting].event_type === 'Standard' && events[eventsCounting].event_id.includes('Post') ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-news bx-sm"></i>' : '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-sm"></i>') +
                      '</div>' +
                      '<a href="#event-modal-' + events[eventsCounting].event_id + '" class="d-flex justify-content-end show-more-details-popover no-underline-link" aria-label="showMoreDetails">Show more details</a>' +
                      '</div>' +
                      '</div>');
                  button.attr('data-bs-html', 'true');

                  $(document).on('click', '.bx-news', function() {
                    var eventId = $(this).attr('id');
                    var postId = eventId.replace('Post_', '');
                    window.location.href = 'HOM-post.php?eec=' + postId;
                  });                  

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
                          (events[eventsCounting].event_type === 'Standard' && events[eventsCounting].event_id.includes('Post') ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-news bx-lg"></i>' : '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-lg"></i>') +
                          '<button type="button" class="outline-button ms-auto" id="back-button" data-bs-dismiss="modal">Back</button></div></div></div>');
                      
                  // Append modal to body
                  $('body').append(modal);

                  // Delegate click event for "Show more details" text within the popover
                  $(document).on("click", ".show-more-details-popover", function() {
                    var modalId = $(this).attr('href');
                    $(modalId).modal('show');
                    $(this).closest('.popover').popover('hide');
                  });

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

                  var popoverContent = $('<div class="popover-content" id="remaining-popover-body"></div>');

                  for(var i = 0; i < currentEventNum; i++) {

                    if (i <= 1) {

                      // Create button for the event
                      var button = $('<button type="button" class="btn btn-primary btn-sm calendar-smaller-btn shown-event">')
                        .text(events[eventsCounting].category_name.length > 10 ? events[eventsCounting].category_name.substring(0, 10) + '...' : events[eventsCounting].category_name);

                      // Set data attributes for popper
                      button.attr('data-bs-toggle', 'popover');
                      button.attr('data-bs-content', '<div class="sec-paragraph shown-event-popover">' +
                          '<div class="p4">' +
                          '<a href="javascript:void(0)" class="d-flex justify-content-end close-popover no-underline-link" aria-label="Close">X</a>' +
                          '<h4 class="mb-0"><b>' + events[eventsCounting].category_name + '</b></h4>' +
                          '<p class="mb-0">' + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' }) + '</p>' +
                          '<p>' + events[eventsCounting].event_time + '</p>' +
                          '<div class="d-flex justify-content-between align-items-center">' +
                          '<div class="icon-container">' +
                          (events[eventsCounting].event_type === 'Standard' && events[eventsCounting].event_id.includes('Post') ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-news bx-sm"></i>' : '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-sm"></i>') +
                          '</div>' +
                          '<a href="#event-modal-' + events[eventsCounting].event_id + '" class="d-flex justify-content-end show-more-details-popover no-underline-link" aria-label="showMoreDetails">Show more details</a>' +
                          '</div>' +
                          '</div>');
                      button.attr('data-bs-html', 'true');

                      $(document).on('click', '.bx-news', function() {
                        var eventId = $(this).attr('id');
                        var postId = eventId.replace('Post_', '');
                        window.location.href = 'HOM-post.php?eec=' + postId;
                      });                      

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
                          (events[eventsCounting].event_type === 'Standard' && events[eventsCounting].event_id.includes('Post') ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-news bx-lg"></i>' : '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-lg"></i>') +
                          '<button type="button" class="outline-button ms-auto" id="back-button" data-bs-dismiss="modal">Back</button></div></div></div>');
                      
                      // Append modal to body
                      $('body').append(modal);

                      // Delegate click event for "Show more details" text within the popover
                      $(document).on("click", ".show-more-details-popover", function() {
                        var modalId = $(this).attr('href');
                        $(modalId).modal('show');
                        $(this).closest('.popover').popover('hide');
                      });

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
                          '<a href="javascript:void(0)" class="d-flex justify-content-end close-popover no-underline-link" aria-label="Close">X</a>' +
                          '<h4 class="mb-0"><b>' + events[eventsCounting].category_name + '</b></h4>' +
                          '<p class="mb-0">' + new Date(events[eventsCounting].event_date).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' }) + '</p>' +
                          '<p>' + events[eventsCounting].event_time + '</p>' +
                          '<div class="d-flex justify-content-between align-items-center">' +
                          '<div class="icon-container">' +
                          (events[eventsCounting].event_type === 'Standard' && events[eventsCounting].event_id.includes('Post') ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-news bx-sm"></i>' : '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-sm"></i>') +
                          '</div>' +
                          '<a href="#event-modal-' + events[eventsCounting].event_id + '" class="d-flex justify-content-end show-more-details-popover no-underline-link" aria-label="showMoreDetails">Show more details</a>' +
                          '</div>' +
                          '</div>');
                      button.attr('data-bs-html', 'true');

                      $(document).on('click', '.bx-news', function() {
                        var eventId = $(this).attr('id');
                        var postId = eventId.replace('Post_', '');
                        window.location.href = 'HOM-post.php?eec=' + postId;
                      });                      

                      // Initialize popover
                      var popoverOptions = {
                        container: 'body',
                        placement: 'auto',
                        trigger: 'click'
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
                          (events[eventsCounting].event_type === 'Standard' && events[eventsCounting].event_id.includes('Post') ? '<i id="' + events[eventsCounting].event_id + '" class="bx bx-news bx-lg"></i>' : '<i id="' + events[eventsCounting].event_id + '" class="bx bx-calendar-plus bx-lg"></i>') +
                          '<button type="button" class="outline-button ms-auto" id="back-button" data-bs-dismiss="modal">Back</button></div></div></div>');
                      
                      // Append modal to body
                      $('body').append(modal);

                      // Delegate click event for "Show more details" text within the popover
                      $(document).on("click", ".show-more-details-popover", function() {
                      var modalId = $(this).attr('href');
                      $(modalId).modal('show');
                      $(this).closest('.popover').popover('hide');
                      });

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

              // Check if the date is today or a future date
              if (
                year > currentYear ||
                (year === currentYear && month > currentMonth) ||
                (year === currentYear && month === currentMonth && date >= currentDay)
              ) {

                // Add a light-colored circle for the current date
                if (year === currentYear && month === currentMonth && date === currentDay) {
                  dateText.addClass('current-date');

                  // Check if the date is between today and the same date of the next year
                  var nextYear = currentYear + 1;
                  var sameDateNextYear = new Date(nextYear, currentMonth, currentDay).getTime();
                  var currentDate = new Date(year, month - 1, date).getTime();

                  if (currentDate <= sameDateNextYear) {
                    var plusIcon = $('<span>').addClass('calendar-day-plus').text('+').hide();
                    div.append(plusIcon);
                  }
                } else {
                  // For other future dates
                  var plusIcon = $('<span>').addClass('calendar-day-plus').text('+').hide();
                  div.append(plusIcon);
                }
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
                            <button type="submit" id="createAnnouncementButton" class="outline-button" value="createAnnouncement">Create Post</button>
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
    generateCalendar(currentMonth, currentYear, filters, filtersOrg); 
    generateMiniCalendar(currentMonth, currentYear, filters, filtersOrg);    

    $("#prev-month").mousedown(function() {
      $('[data-bs-toggle="popover"]').not(this).popover('hide');
      currentMonth--;
      if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
      }
      generateCalendar(currentMonth, currentYear, filters, filtersOrg);
      generateMiniCalendar(currentMonth, currentYear, filters, filtersOrg);
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

            // Highlight the current year
            if (year === currentYear) {
              cell.classList.add("mini-active-year");
            }

            // Add a click event listener to the cell
            cell.addEventListener("click", function() {
              // Remove the "mini-selected-year" class from the previously selected cell
              let previouslySelectedCell = document.querySelector(".mini-selected-year");
              if (previouslySelectedCell) {
                previouslySelectedCell.classList.remove("mini-selected-year");
              }

              // Set the currentYear to the clicked year
              currentYear = year;

              // Hide/show necessary elements
              miniCalendarYearsTable.style.display = "none";
              miniCalendarTable.style.display = "";
              miniCalendarThead.style.display = "";
              miniButtonYearsContainer.style.display = "none"; // Hide the miniButtonYearsContainer
              miniButtonContainer.style.display = ""; // Show the miniButtonContainer

              // Add the "mini-selected-year" class to the clicked cell
              cell.classList.add("mini-selected-year");

              // Generate the calendar based on the selected month and year
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
  }
};

var adminCalendarPhone = {
  initialize: function() {
    var filters = [];
    var filtersOrg = [];
    var selectedDate;

    function generateEventTypeCheckboxes(eventTypes) {
      const eventTypeCheckboxesContainer = $('#mobileEventTypeCheckboxes');
      eventTypeCheckboxesContainer.empty(); // Clear previous checkboxes
  
      const allCheckbox = $('<div>').addClass('form-check');
  
      const allInput = $('<input>').addClass('form-check-input mobile-event-type-checkbox')
        .attr('type', 'checkbox')
        .attr('id', 'mobile-check-event-type-all');
  
      const allLabel = $('<label>').addClass('form-check-label')
        .attr('for', 'mobile-check-event-type-all')
        .text('All');
  
      allCheckbox.append(allInput);
      allCheckbox.append(allLabel);
  
      eventTypeCheckboxesContainer.append(allCheckbox);
  
      for (const eventType of eventTypes) {
        const checkbox = $('<div>').addClass('form-check');
  
        const input = $('<input>').addClass('form-check-input mobile-event-type-checkbox')
          .attr('type', 'checkbox')
          .val(eventType.event_type)
          .attr('id', `mobile-check-event-type-${eventType.event_type}`);
  
        const label = $('<label>').addClass('form-check-label')
          .attr('for', `mobile-check-event-type-${eventType.event_type}`)
          .text(eventType.event_type);
  
        checkbox.append(input);
        checkbox.append(label);
  
        eventTypeCheckboxesContainer.append(checkbox);
      }
  
      // Check all event type checkboxes initially
      $('.form-check-input.mobile-event-type-checkbox').prop('checked', true);
  
      // Update filters array when checkboxes are checked or unchecked
      $('.form-check-input.mobile-event-type-checkbox').change(function() {
        if ($(this).attr('id') === 'mobile-check-event-type-all') {
          // Check/uncheck all checkboxes
          const isChecked = $(this).prop('checked');
          $('.form-check-input.mobile-event-type-checkbox').not(this).prop('checked', isChecked);
        } else {
          // Uncheck "All" checkbox if any individual checkbox is unchecked
          if (!$(this).prop('checked')) {
            $('#mobile-check-event-type-all').prop('checked', false);
          } else {
            // Check "All" checkbox if all individual checkboxes (except "All") are checked
            const allCheckboxChecked = $('.form-check-input.mobile-event-type-checkbox:not(#mobile-check-event-type-all)').length === $('.form-check-input.mobile-event-type-checkbox:not(#mobile-check-event-type-all):checked').length;
            $('#mobile-check-event-type-all').prop('checked', allCheckboxChecked);
          }
        }
      
        filters = $('.form-check-input.mobile-event-type-checkbox:checked').map(function() {
          return $(this).val();
        }).get();
        
        // Call the function to update the calendar based on the selected filters
        updateCalendar();
      });

      // "All" checkbox functionality
      $('#mobile-check-event-type-all').change(function() {
        const isChecked = $(this).prop('checked');
        $('.form-check-input.mobile-event-type-checkbox').prop('checked', isChecked);
      
        filters = isChecked ? eventTypes.map(eventType => eventType.event_type) : [];
        
        // Call the function to update the calendar based on the selected filters
        updateCalendar();
      });
    }
  
    function generateOrgCheckboxes(orgNames) {
      const orgCheckboxesContainer = $('#mobileOrgCheckboxes');
      orgCheckboxesContainer.empty(); // Clear previous checkboxes
  
      const allCheckbox = $('<div>').addClass('form-check');
  
      const allInput = $('<input>').addClass('form-check-input mobile-org-checkbox')
        .attr('type', 'checkbox')
        .attr('id', 'mobile-check-org-all');
  
      const allLabel = $('<label>').addClass('form-check-label')
        .attr('for', 'mobile-check-org-all');
  
      const span = $('<span>').addClass('pill-all')
        .text('All');
  
      allLabel.append(span);
      allCheckbox.append(allInput);
      allCheckbox.append(allLabel);
  
      orgCheckboxesContainer.append(allCheckbox);
  
      for (const orgName of orgNames) {
        const checkbox = $('<div>').addClass('form-check');
  
        const input = $('<input>').addClass('form-check-input mobile-org-checkbox')
          .attr('type', 'checkbox')
          .val(orgName.organization_name)
          .attr('id', `mobile-check-org-${orgName.organization_name}`);
  
        const label = $('<label>').addClass('form-check-label')
          .attr('for', `mobile-check-org-${orgName.organization_name}`);
  
        const span = $('<span>').addClass(`pill-${orgName.organization_name.toLowerCase()}`)
          .text(orgName.organization_name);
  
        label.append(span);
  
        checkbox.append(input);
        checkbox.append(label);
  
        orgCheckboxesContainer.append(checkbox);
      }
  
      // Check all organization checkboxes initially
      $('.form-check-input.mobile-org-checkbox').prop('checked', true);
  
      // Update filtersOrg array when checkboxes are checked or unchecked
      $('.form-check-input.mobile-org-checkbox').change(function() {
        if ($(this).attr('id') === 'mobile-check-org-all') {
          // Check/uncheck all checkboxes
          const isChecked = $(this).prop('checked');
          $('.form-check-input.mobile-org-checkbox').not(this).prop('checked', isChecked);
        } else {
          // Uncheck "All" checkbox if any individual checkbox is unchecked
          if (!$(this).prop('checked')) {
            $('#mobile-check-org-all').prop('checked', false);
          } else {
            // Check "All" checkbox if all individual checkboxes (except "All") are checked
            const allCheckboxChecked = $('.form-check-input.mobile-org-checkbox:not(#mobile-check-org-all)').length === $('.form-check-input.mobile-org-checkbox:not(#mobile-check-org-all):checked').length;
            $('#mobile-check-org-all').prop('checked', allCheckboxChecked);
          }
        }
      
        filtersOrg = $('.form-check-input.mobile-org-checkbox:checked').map(function() {
          return $(this).val();
        }).get();
        
        // Call the function to update the calendar based on the selected filters
        updateCalendar();
      });

      // "All" checkbox functionality
      $('#mobile-check-org-all').change(function() {
        const isChecked = $(this).prop('checked');
        $('.form-check-input.mobile-org-checkbox').prop('checked', isChecked);
      
        filtersOrg = isChecked ? orgNames.map(orgName => orgName.organization_name) : [];
        
        // Call the function to update the calendar based on the selected filters
        updateCalendar();
      });
    }
  
    // Fetch event type data from the server
    $.ajax({
      url: './php/CAL-get-event-types.php',
      method: 'GET',
      dataType: 'json',
      success: function(response) {
        // Generate the event type checkboxes and check all initially
        generateEventTypeCheckboxes(response.eventTypes);
        // Add initial checkbox values to the array
        filters = response.eventTypes.map(eventType => eventType.event_type);
        // Call the function to update the calendar based on the selected filters
        updateCalendar();
      },
      error: function(xhr, error) {
        console.error('Error fetching event type data:', error);
        console.log('Response:', xhr.responseText); // Log the response text for debugging
      }
    });

    // Fetch organization data from the server
    $.ajax({
      url: './php/CAL-get-orgs.php',
      method: 'GET',
      dataType: 'json',
      success: function(response) {
        // Generate the organization checkboxes and check all initially
        generateOrgCheckboxes(response.orgNames);
        // Add initial checkbox values to the array
        filtersOrg = response.orgNames.map(orgName => orgName.organization_name);
        // Call the function to update the calendar based on the selected filters
        updateCalendar();
      },
      error: function(xhr, error) {
        console.error('Error fetching organization data:', error);
        console.log('Response:', xhr.responseText); // Log the response text for debugging
      }
    });

    function updateCalendar() {
      // Code to update the calendar based on the selected filters
      generateCalendar(currentMonth, currentYear, filters, filtersOrg);
      generateCalendarSelected(currentMonth, currentYear, filters, selectedDate, filtersOrg)
    }

    // Select DOM elements
    const showModalBtn = document.querySelector(".show-modal");
    const showModalBtn2 = document.querySelector(".show-modal-2");
    const bottomSheet = document.querySelector(".bottom-sheet");
    const sheetOverlay = bottomSheet.querySelector(".sheet-overlay");
    const sheetContent = bottomSheet.querySelector(".content");
    const dragIcon = bottomSheet.querySelector(".drag-icon");

    // Global variables for tracking drag events
    let isDragging = false,
      startY,
      startHeight;

    // Show the bottom sheet, hide body vertical scrollbar, and call updateSheetHeight
    const showBottomSheet = () => {
      bottomSheet.classList.add("show");
      document.body.style.overflowY = "hidden";
      updateSheetHeight(50);
      const addItemContent = document.querySelector("#add-item-content");
      const searchDateContent = document.querySelector("#search-date-content");
      addItemContent.style.display = "none";
      searchDateContent.style.display = "block";
    };

    const showBottomSheet2 = () => {
      bottomSheet.classList.add("show");
      document.body.style.overflowY = "hidden";
      updateSheetHeight(50);
      const addItemContent = document.querySelector("#add-item-content");
      const searchDateContent = document.querySelector("#search-date-content");
      addItemContent.style.display = "block";
      searchDateContent.style.display = "none";
    };

    const updateSheetHeight = (height) => {
      sheetContent.style.height = `${height}vh`; //updates the height of the sheet content
      // Toggles the fullscreen class to bottomSheet if the height is equal to 100
      bottomSheet.classList.toggle("fullscreen", height === 100);
    };

    // Hide the bottom sheet and show body vertical scrollbar
    const hideBottomSheet = () => {
      bottomSheet.classList.remove("show");
      document.body.style.overflowY = "auto";
    };

    // Sets initial drag position, sheetContent height and add dragging class to the bottom sheet
    const dragStart = (e) => {
      isDragging = true;
      startY = e.pageY || e.touches?.[0].pageY;
      startHeight = parseInt(sheetContent.style.height);
      bottomSheet.classList.add("dragging");
    };

    // Calculates the new height for the sheet content and call the updateSheetHeight function
    const dragging = (e) => {
      if (!isDragging) return;
      const delta = startY - (e.pageY || e.touches?.[0].pageY);
      const newHeight = startHeight + (delta / window.innerHeight) * 100;
      updateSheetHeight(newHeight);
    };

    // Determines whether to hide, set to fullscreen, or set to default
    // height based on the current height of the sheet content
    const dragStop = () => {
      isDragging = false;
      bottomSheet.classList.remove("dragging");
      const sheetHeight = parseInt(sheetContent.style.height);
      sheetHeight < 25
        ? hideBottomSheet()
        : sheetHeight > 75
        ? updateSheetHeight(100)
        : updateSheetHeight(50);
    };

    dragIcon.addEventListener("mousedown", dragStart);
    document.addEventListener("mousemove", dragging);
    document.addEventListener("mouseup", dragStop);

    dragIcon.addEventListener("touchstart", dragStart);
    document.addEventListener("touchmove", dragging);
    document.addEventListener("touchend", dragStop);

    sheetOverlay.addEventListener("click", hideBottomSheet);
    showModalBtn.addEventListener("click", showBottomSheet);
    showModalBtn2.addEventListener("click", showBottomSheet2);

    // Select the calendar and plus icons directly
    const calendarIcon = document.querySelector(".bx-calendar");
    const plusIcon = document.querySelector(".bx-plus");

    // Event listener for plus icon click
    plusIcon.addEventListener("click", () => {
      // Update the content of the bottom sheet for the plus icon
      const searchDateContent = document.querySelector("#search-date-content");
      const addItemContent = document.querySelector("#add-item-content");
      searchDateContent.style.display = "none";
      addItemContent.style.display = "block";
    });

    // Event listener for calendar icon click
    calendarIcon.addEventListener("click", () => {
      // Update the content of the bottom sheet for the calendar
      const searchDateContent = document.querySelector("#search-date-content");
      const addItemContent = document.querySelector("#add-item-content");
      searchDateContent.style.display = "block";
      addItemContent.style.display = "none";
    });

    // Attach click event listeners to the buttons
    $('#createEventButtonMobile').click(function() {
      $('#dateTimeSubmitFormMobile').attr('action', './EVE-admin-create-event.php');
    });

    $('#createAnnouncementButtonMobile').click(function() {
      $('#dateTimeSubmitFormMobile').attr('action', './HOM-create-post.php');
    });

    const dateInput = document.getElementById("date_mobile");
    const timeInput = document.getElementById("time_mobile");

    // Get the current date and time
    const currentDate = new Date();

    // Set the minimum date value for the input
    dateInput.min = currentDate.toISOString().split("T")[0];

    // Event listener for date input change
    dateInput.addEventListener("change", () => {
      const selectedDate = new Date(dateInput.value);
      const selectedTime = new Date(timeInput.value);

      // Check if the selected time is in the past
      if (
        selectedDate.toDateString() === currentDate.toDateString() &&
        selectedTime < currentDate
      ) {
        timeInput.value = ""; // Clear the input value
        alert("Please select a future time.");
      }
    });

    // Event listener for time input change
    timeInput.addEventListener("change", () => {
      const selectedDate = new Date(dateInput.value);
      const selectedTime = new Date(timeInput.value);

      // Check if the selected time is in the past
      if (
        selectedDate.toDateString() === currentDate.toDateString() &&
        selectedTime < currentDate
      ) {
        timeInput.value = ""; // Clear the input value
        alert("Please select a future time.");
      }
    });

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

          // Get a reference to the <div> element
          const divElement = document.getElementById("noShowUpcomingEvents");

          if (events.length === 0) {
            // Set the display property to "block" to make it visible
            divElement.style.display = "flex";
          } else {
            // Iterate over events data and populate details for upcoming events
            for (var i = 0; i < events.length; i++) {
              const event = events[i];

              // Create a new Date object from the event date string
              const eventDate = new Date(event.event_date);

              // Check if the event date is tomorrow or later
              if (eventDate >= tomorrow) {
                // Set the display property to "block" to make it visible
                divElement.style.display = "none";

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
              } else {
                // Set the display property to "block" to make it visible
                divElement.style.display = "flex";
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

                if (eventType === 'Standard' && eventId.includes('Post_')) {
                  var modalButtons = '<i id="mobile-post-' + eventId + '" class="bx bx-news bx-lg mobile-icons"></i>';
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

                if (eventType === 'Standard' && eventId.includes('Post_')) {
                  $(document).on('click', '.bx-news', function() {
                    var eventId = $(this).attr('id');
                    var postId = eventId.replace('mobile-post-Post_', '');
                    window.location.href = 'HOM-post.php?eec=' + postId;
                  });  
                } else {
                  const calendarIcon = modal.querySelector("#mobile-add-calendar-" + eventId);
                  calendarIcon.addEventListener("click", function(event) {
                    const buttonId = event.target.id;
                    addToCalendarUpcoming(buttonId, eventDate, categoryName, eventTime, eventDesc)
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
        currentEventsTitle.innerHTML = "Events on " + months[month] + " " + selectedDate + ", " + year;
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

          // Get a reference to the <div> element
          const divElement = document.getElementById("noShowSelectedEvents");

          if (events.length === 0) {
            // Set the display property to "block" to make it visible
            divElement.style.display = "flex";
          } else {
            // Set the display property to "none" to make it invisible
            divElement.style.display = "none";
            // Iterate over events data and populate details
            for (var i = 0; i < events.length; i++) {
              const event = events[i];

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

                if (eventType === 'Standard' && eventId.includes('Post_')) {
                  var modalButtons = '<i id="mobile-post-' + eventId + '" class="bx bx-news bx-lg mobile-icons"></i>';
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

                if (eventType === 'Standard' && eventId.includes('Post_')) {
                  $(document).on('click', '.bx-news', function() {
                    var eventId = $(this).attr('id');
                    var postId = eventId.replace('mobile-post-Post_', '');
                    window.location.href = 'HOM-post.php?eec=' + postId;
                  });   
                } else {
                  const calendarIcon = modal.querySelector("#mobile-add-calendar-" + eventId);
                  calendarIcon.addEventListener("click", function(event) {
                    const buttonId = event.target.id;
                    addToCalendarSelected(buttonId, eventDate, categoryName, eventTime, eventDesc)
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
          }
        },
        error: function(error) {
          console.error('Error: ' + error.message);
        }
      });
    }

    $(document).ready(function() {
      $('#date_mobile_search').on('change', function() {
        let dateValue = $(this).val();
        selectedDate = new Date(dateValue);
        currentYear = selectedDate.getFullYear();
        currentMonth = selectedDate.getMonth();
        selectedDate = selectedDate.getDate();
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