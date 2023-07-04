$(document).ready(function() {

  // Array to store the checkbox values
  var checkboxValues = [];

  function generateAdminCheckboxes(adminUsers) {
    const adminCheckboxesContainer = $('#adminCheckboxes');
    adminCheckboxesContainer.empty(); // Clear previous checkboxes

    const allCheckbox = $('<div>').addClass('form-check');

    const allInput = $('<input>').addClass('form-check-input admin-checkbox')
      .attr('type', 'checkbox')
      .attr('id', 'check-admin-all');

    const allLabel = $('<label>').addClass('form-check-label')
      .attr('for', 'check-admin-all')
      .text('All');

    allCheckbox.append(allInput);
    allCheckbox.append(allLabel);

    adminCheckboxesContainer.append(allCheckbox);

    for (const adminUser of adminUsers) {
      const checkbox = $('<div>').addClass('form-check');

      const input = $('<input>').addClass('form-check-input admin-checkbox')
        .attr('type', 'checkbox')
        .val(adminUser.id)
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
      if ($(this).attr('id') === 'check-admin-all') {
        // Check/uncheck all checkboxes
        const isChecked = $(this).prop('checked');
        $('.form-check-input.admin-checkbox').not(this).prop('checked', isChecked);
      } else {
        // Uncheck "All" checkbox if any individual checkbox is unchecked
        if (!$(this).prop('checked')) {
          $('#check-admin-all').prop('checked', false);
        } else {
          // Check "All" checkbox if all individual checkboxes (except "All") are checked
          const allCheckboxChecked = $('.form-check-input.admin-checkbox:not(#check-admin-all)').length === $('.form-check-input.admin-checkbox:not(#check-admin-all):checked').length;
          $('#check-admin-all').prop('checked', allCheckboxChecked);
        }
      }

      checkboxValues = $('.form-check-input.admin-checkbox:checked').map(function() {
        return $(this).val();
      }).get();

      currentPage = 1;
      loadLogs();
    });

    // "All" checkbox functionality
    $('#check-admin-all').on('change', function() {
      const isChecked = $(this).prop('checked');
      $('.form-check-input.admin-checkbox').prop('checked', isChecked);

      checkboxValues = isChecked ? adminUsers.map(adminUser => adminUser.id) : [];

      currentPage = 1;
      loadLogs();
    });

    // Add initial checkbox values to the array
    checkboxValues = $('.form-check-input.admin-checkbox:checked').map(function() {
      return $(this).val();
    }).get();

    currentPage = 1;
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

  $(document).ready(function() {
    // Retrieve the stored value from local storage
    var storedValue = localStorage.getItem('itemsPerPage');
  
    // Set the stored value as the selected option
    if (storedValue) {
      $('#itemsPerPageSelect').val(storedValue);
    }
  
    // Attach the change event listener
    $('#itemsPerPageSelect').on('change', function() {
      // Get the selected value
      var selectedValue = $(this).val();
  
      // Store the selected value in local storage
      localStorage.setItem('itemsPerPage', selectedValue);
  
      // Reset the current page and load logs
      currentPage = 1;
      loadLogs();
  
      // Reset the go to page input value
      $('#goToPageInput').val('');
    });
  });  

  $('#goToPageInput').on('input', function() {
    var inputValue = $(this).val().trim();
    var validPageNumber = parseInt(inputValue);
  
    if (isNaN(validPageNumber) || validPageNumber <= 0 || !Number.isInteger(validPageNumber)) {
      $(this).val(''); // Reset the input value
    } else {
      if (validPageNumber > totalPages) {
        validPageNumber = totalPages; // Set the value to totalPages if it exceeds
        $(this).val(totalPages); // Update the input field value
      }
      currentPage = validPageNumber; // Assign the valid page number to currentPage
      loadLogs();
    }
  });  
  
  var tbody = $('#log-table-body');
  var currentPage = 1;
  var pageSize;
  var totalEntries;
  var totalPages;
  var sortColumn = 'log_id';
  var sortOrder = 'DESC';
  
  function loadLogs() {
    var searchTerm = $('#search-input').val();
    var searchDate = $('#dateInput').val();
    var itemsPerPage = $('#itemsPerPageSelect').val();
  
    $.ajax({
      url: './php/CAL-show-logs.php',
      type: 'GET',
      dataType: 'json',
      data: {
        sortColumn: sortColumn,
        sortOrder: sortOrder,
        searchTerm: searchTerm,
        searchDate: searchDate,
        searchAdmin: checkboxValues,
        currentPage: currentPage,
        itemsPerPage: itemsPerPage
      },
      success: function(response) {
        var logs = response.logs;
        totalEntries = response.totalEntries;
        totalPages = response.totalPages;
        pageSize = response.pageSize;
  
        // Calculate startIndex and endIndex
        var startIndex = (currentPage - 1) * pageSize + 1;
        var endIndex = Math.min(startIndex + pageSize - 1, totalEntries);
        var paginationContainer = $('.pagination');
  
        if (isNaN(startIndex) || isNaN(endIndex) || totalEntries === undefined) {
          $('#pagination-info').text('0-0 of 0');
        } else {
          $('#pagination-info').text(startIndex + '-' + endIndex + ' of ' + totalEntries);
        }
  
        tbody.empty();
  
        if (logs.length === 0) {
          paginationContainer.empty();
          var noResultsRow = $('<tr></tr>').addClass('no-results-row');
          var noResultsCell = $('<td></td>').attr('colspan', '5').text('No results to display');
          noResultsCell.appendTo(noResultsRow);
          noResultsRow.appendTo(tbody);
  
          // Disable both buttons when there are no results
          $('#btn-first').prop('disabled', true);
          $('#btn-prev').prop('disabled', true);
          $('#btn-next').prop('disabled', true);
          $('#btn-last').prop('disabled', true);
        } else {
          paginationContainer.empty();
          logs.forEach(function(log) {
            var logDate = new Date(log.log_date);
            var formattedDate = formatDate(logDate);
            var formattedTime = formatTime(logDate, log.log_time);
  
            var row = $('<tr></tr>');
  
            $('<td></td>').text(log.log_id).appendTo(row);
            $('<td></td>').text(formattedDate).appendTo(row);
            $('<td></td>').text(formattedTime).appendTo(row);
            $('<td></td>').text(log.user_username).appendTo(row);
            $('<td></td>').text(log.activity_description).appendTo(row);
  
            row.appendTo(tbody);
          });
  
          // Enable/disable pagination buttons based on current page
          $('#btn-first').prop('disabled', currentPage === 1);
          $('#btn-prev').prop('disabled', currentPage === 1);
          $('#btn-next').prop('disabled', currentPage === totalPages);
          $('#btn-last').prop('disabled', currentPage === totalPages);
  
          // Create the page links
          var pageLinks = $('<div></div>').addClass('pagination');
  
          var startPage = Math.max(1, currentPage - 5);
          var endPage = Math.min(startPage + 9, totalPages);
  
          for (var i = startPage; i <= endPage; i++) {
            var pageAnchor = $('<a></a>').addClass('page').attr('href', 'javascript:void(0)').attr('id', 'page-' + i).on('click', function() {
              currentPage = parseInt($(this).attr('id').split('-')[1]);
              loadLogs();
            }).text(i);
            if (i === currentPage) {
              pageAnchor.addClass('selected');
            }
            pageLinks.append(pageAnchor);
          }
  
          // Update the pagination container
          $('#pagination').empty().append(pageLinks);
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
  
  function setSortColumn(column) {
    currentPage = 1; // Reset to first page
    if (sortColumn === column) {
      sortOrder = sortOrder === 'ASC' ? 'DESC' : 'ASC';
    } else {
      sortColumn = column;
      sortOrder = 'ASC';
    }
  
    loadLogs();
  }  
  
  $('#btn-prev').on('mousedown', function() {
    if (currentPage > 1) {
      currentPage--;
    }
    loadLogs();
  });
  
  $('#btn-next').on('mousedown', function() {
    if (currentPage < totalPages) {
      currentPage++;
    }
    loadLogs();
  });

  $('#btn-first').on('mousedown', function() {
    if (currentPage > 1) {
      currentPage = 1;
    }
    loadLogs();
  });
  
  $('#btn-last').on('mousedown', function() {
    if (currentPage < totalPages) {
      currentPage = totalPages;
    }
    loadLogs();
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
    currentPage = 1; // Reset to first page when date is entered
    loadLogs();
  });
  
  loadLogs();

  // Mini Calendar
  // Global variables
  var currentMonth = new Date().getMonth();
  var currentYear = new Date().getFullYear();
  var months = [
  "January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
  ];
  // Get the miniCalendarToggle and miniCalendarContainer elements
  const miniCalendarToggle = document.getElementById('calendar-icon');
  const miniCalendarContainer = document.getElementById('miniCalendarContainer');

  generateMiniCalendar(currentMonth, currentYear);

  // Event handler for the "Clear" button
  $('#clearButton').on('click', function() {
    $('#dateInput').val(''); // Clear the input field
    loadLogs();
  });

  // Event handler for the "Today" button
  $('#todayButton').on('click', function() {
    const today = new Date();
    const currentMonth = today.getMonth();
    const currentYear = today.getFullYear();

    // Generate mini calendar for the current month and year
    generateMiniCalendar(currentMonth, currentYear);

    // Set today's date in the input field
    const formattedDate = today.toLocaleDateString('en-US', { 
      month: '2-digit',
      day: '2-digit',
      year: 'numeric'
    });
    $('#dateInput').val(formattedDate);

    // Trigger the input event manually to update the logs
    $(dateInput).trigger('input');
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
  
  // Add click event listener to the miniCalendarToggle element
  miniCalendarToggle.addEventListener('click', (event) => {
    event.stopPropagation(); // Prevent the click event from bubbling up to the document
    toggleMiniCalendar();
  });

  function toggleMiniCalendar() {
    if (miniCalendarContainer.style.display === 'none' || miniCalendarContainer.style.display === '') {
      miniCalendarContainer.style.display = 'block';
  
      // Position the container below the input field
      const inputRect = dateInput.getBoundingClientRect();
      miniCalendarContainer.style.bottom = inputRect.bottom - 'px'; // Adjust the vertical position as needed
      miniCalendarContainer.style.left = inputRect.left - 85 + 'px'; // Adjust the horizontal position as needed
    } else {
      miniCalendarContainer.style.display = 'none';
    }
  }  

  // Close the calendar if the user clicks outside the input field or calendar container
  document.addEventListener('click', (event) => {
    if (!dateInput.contains(event.target) && !miniCalendarContainer.contains(event.target)) {
      miniCalendarContainer.style.display = 'none';
    }
  });
  
  dateInput.addEventListener('input', formatAndValidateDate);
  dateInput.addEventListener('keypress', restrictNonNumericInput);

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
  }

  function restrictNonNumericInput(event) {
      const key = event.which || event.keyCode;
      const char = String.fromCharCode(key);

      // Allow only numeric characters and backspace/delete
      if (!/[\d\b]/.test(char)) {
      event.preventDefault();
      }
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
  }  

  function getDaysInMonth(month, year) {
      // Returns the number of days in a month (accounts for leap years)
      return new Date(year, month, 0).getDate();
  }

  function generateMiniCalendar(month, year) {
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
                  // Set the clicked date in the input field using jQuery
                  const formattedMonth = (month + 1).toString().padStart(2, '0');
                  const formattedDate = clickedDate.toString().padStart(2, '0');
                  const formattedYear = year.toString();
                  const formattedDateStr = `${formattedMonth}/${formattedDate}/${formattedYear}`;
                  $('#dateInput').val(formattedDateStr);
                  // Trigger the input event manually to update the logs
                  $(dateInput).trigger('input');   
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
          generateMiniCalendar(currentMonth, currentYear);

          prevMonthInterval = setInterval(function() {
              currentMonth--;
              if (currentMonth < 0) {
              currentMonth = 11;
              currentYear--;
              }
              generateMiniCalendar(currentMonth, currentYear);

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
  generateMiniCalendar(currentMonth, currentYear);

  nextMonthInterval = setInterval(function() {
      currentMonth++;
      if (currentMonth > 11) {
      currentMonth = 0;
      currentYear++;
      }
      generateMiniCalendar(currentMonth, currentYear);

  }, 100); // Adjust the interval time (in milliseconds) for the desired scrolling speed
  }).mouseup(function() {
  clearInterval(nextMonthInterval);
  }).mouseleave(function() {
  clearInterval(nextMonthInterval);
  });
});