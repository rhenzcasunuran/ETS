var storedValue;

  $(document).ready(function() {
    // Retrieve the stored value from local storage
    storedValue = localStorage.getItem('itemsPerPage');
  
    // Set the stored value as the selected option
    if (storedValue) {
      $('#itemsPerPageSelect').val(storedValue);
    }
  
    // Attach the change event listener
    $('#itemsPerPageSelect').on('change', function() {
      // Get the selected value
      selectedValue = $(this).val();
  
      // Store the selected value in local storage
      localStorage.setItem('itemsPerPage', selectedValue);
  
      // Reset the current page and load logs
      currentPage = 1;
  
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
    }
  });  