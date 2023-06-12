$(document).ready(function() {

  // Array to store the checkbox values
  var checkboxValues = [];

  // Function to dynamically generate admin checkboxes
  function generateAdminCheckboxes(adminUsers) {
    const adminCheckboxesContainer = $('#adminCheckboxes');
    adminCheckboxesContainer.empty(); // Clear previous checkboxes

    for (const adminUser of adminUsers) {
      const checkbox = $('<div>').addClass('form-check');

      const input = $('<input>').addClass('form-check-input admin-checkbox')
        .attr('type', 'checkbox')
        .val(adminUser.username)
        .attr('id', `check-admin-${adminUser.id}`);

      const label = $('<label>').addClass('form-check-label')
        .attr('for', `check-admin-${adminUser.id}`)
        .text(adminUser.username);

      checkbox.append(input);
      checkbox.append(label);

      adminCheckboxesContainer.append(checkbox);
    }

    // Check all admin checkboxes initially
    $('.form-check-input.admin-checkbox').prop('checked', true);

    // Update checkboxValues array when checkboxes are checked or unchecked
    $('.form-check-input.admin-checkbox').on('change', function() {
      const value = $(this).val();
      if ($(this).prop('checked')) {
        // Checkbox is checked, add value to the array
        checkboxValues.push(value);
      } else {
        // Checkbox is unchecked, remove value from the array
        const index = checkboxValues.indexOf(value);
        if (index > -1) {
          checkboxValues.splice(index, 1);
        }
      }

      loadLogs();
    });

    // Add all initial checkbox values to the array
    $('.form-check-input.admin-checkbox').each(function() {
      const value = $(this).val();
      checkboxValues.push(value);
    });

    loadLogs();
  }

  // Fetch admin data from the server
  $.ajax({
    url: './php/CAL-log-adminfetch.php',
    method: 'GET',
    dataType: 'json',
    success: function(response) {
      // Generate the admin checkboxes and check all initially
      generateAdminCheckboxes(response.adminUsers);
    },
    error: function(xhr, error) {
      console.error('Error fetching admin data:', error);
      console.log('Response:', xhr.responseText); // Log the response text for debugging
    }
  });

  var tbody = $('#log-table-body');
  var currentPage = 1;
  var pageSize = 10;
  var totalEntries = 0;
  var totalPages = 0;
  var sortColumn = 'log_id';
  var sortOrder = 'DESC';
  
  function updatePaginationInfo() {
    var startIndex = (currentPage - 1) * pageSize + 1;
    var endIndex = Math.min(startIndex + pageSize - 1, totalEntries);
    var paginationText = startIndex + '-' + endIndex + ' of ' + totalEntries;
    $('#pagination-info').text(paginationText);
  }
  
  function displayLogs(logs) {
    tbody.empty();
  
    if (logs.length === 0) {
      var noResultsRow = $('<tr></tr>').addClass('no-results-row');
      var noResultsCell = $('<td></td>').attr('colspan', '5').text('No results to display');
      noResultsCell.appendTo(noResultsRow);
      noResultsRow.appendTo(tbody);
    } else {
      logs.forEach(function (log) {
        var logDate = new Date(log.log_date);
        var formattedDate = formatDate(logDate);
        var formattedTime = formatTime(logDate, log.log_time);
  
        var row = $('<tr></tr>');
  
        $('<td></td>').text(log.log_id).appendTo(row);
        $('<td></td>').text(formattedDate).appendTo(row);
        $('<td></td>').text(formattedTime).appendTo(row);
        $('<td></td>').text(log.admin).appendTo(row);
        $('<td></td>').text(log.activity_description).appendTo(row);
  
        row.appendTo(tbody);
      });
    }
  }
  
  // Function to format the date
  function formatDate(date) {
    var day = date.getDate();
    var month = date.getMonth() + 1; // Months are zero-based
    var year = date.getFullYear();
  
    // Ensure leading zeros for day and month if necessary
    day = day < 10 ? '0' + day : day;
    month = month < 10 ? '0' + month : month;
  
    return month + '/' + day + '/' + year;
  }
  
  // Function to format the time
  function formatTime(date, time) {
    var logDateTime = new Date(date.toISOString().split('T')[0] + 'T' + time + 'Z');
    var timezoneOffset = date.getTimezoneOffset() / 60; // Get the local time zone offset in hours
    logDateTime.setHours(logDateTime.getHours() + timezoneOffset); // Adjust the hours based on the time zone offset
    var formattedTime = logDateTime.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });

    return formattedTime;
  }

  document.getElementById("calendar-icon").addEventListener("click", function() {
    const miniCalendar = document.getElementById("miniCalendar");
    miniCalendar.style.display = miniCalendar.style.display === "none" ? "block" : "none";
  });

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
            currentPage = 1; // Reset to the first page
            loadLogs();            
          });
          miniDate++;
        }
        miniRow.appendChild(miniTd);
      }
    }
  }

  // Function to select a date
  function selectMiniDate(miniDateCell) {
    if (miniSelectedDate) {
      miniSelectedDate.classList.remove("selected-day");
    }
    miniSelectedDate = miniDateCell;
    miniSelectedDate.classList.add("selected-day");

    updateInputText(miniSelectedDate.innerText);
  }

  // Function to update the input text field
  function updateInputText(date) {
    const dateInput = document.getElementById("dateInput");

    // Format the selected date as "mm/dd/yyyy"
    const formattedMonth = (miniCurrentMonth + 1).toString().padStart(2, '0');
    const formattedDay = date.toString().padStart(2, '0');
    const formattedDate = `${formattedMonth}/${formattedDay}/${miniCurrentYear}`;

    dateInput.value = formattedDate;
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

  // Generate initial mini calendar
  updateMiniCalendar();

  // Add event listeners to the previous and next buttons
  const miniPreviousButton = document.getElementById("miniPreviousButton");
  const miniNextButton = document.getElementById("miniNextButton");
  miniPreviousButton.addEventListener("click", goToMiniPreviousMonth);
  miniNextButton.addEventListener("click", goToMiniNextMonth);

  function loadLogs() { 
    
    var searchTerm = $('#search-input').val();
    var searchDate = $('#dateInput').val();

    $.ajax({
      url: './php/CAL-show-logs.php',
      type: 'GET',
      dataType: 'json',
      data: {
        sortColumn: sortColumn,
        sortOrder: sortOrder,
        searchTerm: searchTerm,
        searchDate: searchDate,
        searchAdmin: checkboxValues
      },
      success: function(response) {
        var logs = response.logs;
        totalEntries = logs.length;
        totalPages = Math.ceil(totalEntries / pageSize);
        var startIndex = (currentPage - 1) * pageSize;
        var endIndex = Math.min(startIndex + pageSize, totalEntries);
        var paginatedLogs = logs.slice(startIndex, endIndex);
  
        displayLogs(paginatedLogs);
        updatePaginationInfo();
  
        $('#btn-prev').prop('disabled', currentPage === 1);
        $('#btn-next').prop('disabled', currentPage === totalPages);
  
        // Disable both buttons if there are no search results
        if (totalEntries === 0) {
          $('#btn-prev').prop('disabled', true);
          $('#btn-next').prop('disabled', true);
        }
  
        // Reset sort indicators
        $('.sortable span').removeClass('bx bxs-chevron-up bx bxs-chevron-down');
  
        // Set sort indicator for current column
        var sortIndicator = sortOrder === 'ASC' ? 'bxs-chevron-up' : 'bxs-chevron-down';
        $('#sort-indicator-' + sortColumn).addClass('bx ' + sortIndicator);
      },
      error: function(error) {
        console.log('AJAX request error:', error);
      }
    });
  }
  
  function setSortColumn(column) {
    if (sortColumn === column) {
      sortOrder = sortOrder === 'ASC' ? 'DESC' : 'ASC';
    } else {
      sortColumn = column;
      sortOrder = 'ASC';
    }
  
    loadLogs();
  }
  
  $('#btn-prev').click(function() {
    if (currentPage > 1) {
      currentPage--;
      loadLogs();
    }
  });
  
  $('#btn-next').click(function() {
    if (currentPage < totalPages) {
      currentPage++;
      loadLogs();
    }
  });
  
  $('.sortable').click(function() {
    var column = $(this).data('column');
    setSortColumn(column);
  });
  
  $('#search-input').on('input', function() {
    currentPage = 1; // Reset to first page when searching
    loadLogs();
  });

  $('#dateInput').on('input', function() {
    if ($('#dateInput').val() !== '') {
      currentPage = 1; // Reset to first page when date is entered
      loadLogs();
    }
  });
  
  loadLogs();

  const dateInput = document.getElementById('dateInput');
  const dateError = document.getElementById('dateError');

  dateInput.addEventListener('input', formatAndValidateDate);
  dateInput.addEventListener('keypress', restrictNonNumericInput);
  dateInput.addEventListener('blur', resetInputIfInvalid);

  function formatAndValidateDate() {
    let dateValue = dateInput.value;

    // Remove any non-numeric characters
    dateValue = dateValue.replace(/\D/g, '');

    // Apply the format mm/dd/yyyy
    if (dateValue.length > 2 && dateValue.charAt(2) !== '/') {
      dateValue = `${dateValue.slice(0, 2)}/${dateValue.slice(2)}`;
    }
    if (dateValue.length > 5 && dateValue.charAt(5) !== '/') {
      dateValue = `${dateValue.slice(0, 5)}/${dateValue.slice(5)}`;
    }

    // Update the input value
    dateInput.value = dateValue;

    // Validate the date
    validateDate();
    loadLogs();
  }

  function restrictNonNumericInput(event) {
    const key = event.which || event.keyCode;
    const char = String.fromCharCode(key);

    // Allow only numeric characters and backspace/delete
    if (!/[\d\b]/.test(char)) {
      event.preventDefault();
    }
  }

  function resetInputIfInvalid() {
    if (!dateInput.checkValidity()) {
      loadLogs();
      dateInput.value = '';
    }
    loadLogs();
  }

  function validateDate() {
    const dateValue = dateInput.value;
    const dateError = document.getElementById('date-error'); // Get the date error element
  
    // Regular expression pattern for mm/dd/yyyy format
    const datePattern = /^(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])\/\d{4}$/;
  
    if (datePattern.test(dateValue)) {
      const [month, day, year] = dateValue.split('/');
  
      // Validate the month (mm)
      const monthInt = parseInt(month, 10);
      if (monthInt < 1 || monthInt > 12) {
        // Invalid month
        dateInput.setCustomValidity('Invalid month');
        if (dateError) {
          dateError.textContent = 'Invalid month';
        }
        return;
      }
  
      // Validate the day (dd) based on the month
      const dayInt = parseInt(day, 10);
      if (dayInt < 1 || dayInt > getDaysInMonth(monthInt, year)) {
        // Invalid day
        dateInput.setCustomValidity('Invalid day');
        if (dateError) {
          dateError.textContent = 'Invalid day';
        }
        return;
      }
  
      // Create a Date object to validate the input as a valid date
      const inputDate = new Date(`${year}-${month}-${day}`);
  
      if (
        inputDate.getFullYear().toString() === year &&
        (inputDate.getMonth() + 1).toString().padStart(2, '0') === month &&
        inputDate.getDate().toString().padStart(2, '0') === day
      ) {
        // Valid date
        dateInput.setCustomValidity('');
        if (dateError) {
          dateError.textContent = '';
        }
      } else {
        // Invalid date
        dateInput.setCustomValidity('Invalid date');
        if (dateError) {
          dateError.textContent = 'Invalid date';
        }
      }
    } else {
      // Date format doesn't match mm/dd/yyyy
      dateInput.setCustomValidity('Invalid date format');
      if (dateError) {
        dateError.textContent = 'Invalid date format';
      }
    }
    loadLogs();
  }  

  function getDaysInMonth(month, year) {
    // Returns the number of days in a month (accounts for leap years)
    return new Date(year, month, 0).getDate();
  }
});