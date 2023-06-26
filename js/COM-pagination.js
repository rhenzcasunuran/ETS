$(document).ready(function() {
    var itemsPerPage = parseInt($('.pagination-left select').val());
    var pageID = document.querySelector('meta[name="page-id"]').getAttribute('content');
    var item;
    switch (pageID) {
        case "topublish":
            item = ".result_container";
            break;
        case "published":
            item = ".result_container";
            break;
        case "archive":
            item = ".result_container";
            break;
        case "comstudent":
            item = ".draggableDiv";
            break;
        case "manageresult":
            item = ".draggableDiv";
            break;
    }
    var totalItems = $(item).length;
    var totalPages = Math.ceil(totalItems / itemsPerPage);
    var currentPage = 1;
  
    showItems(currentPage);
  
    function showItems(page) {
      var startIndex = (page - 1) * itemsPerPage;
      var endIndex = startIndex + itemsPerPage;
  
      $(item).hide().slice(startIndex, endIndex).show();
    }
  
    $('.pagination-left select').on('change', function() {
      itemsPerPage = parseInt($(this).val());
      totalItems = $(item).length;
      totalPages = Math.ceil(totalItems / itemsPerPage);
      currentPage = 1;
      showItems(currentPage);
  
      var paginationButtons = generatePaginationButtons(currentPage);
      $('.pagination-center').html(paginationButtons);
    });
  
    $('.pagination-center').on('click', '.pageBtn', function() {
      currentPage = parseInt($(this).text());
      showItems(currentPage);
  
      var paginationButtons = generatePaginationButtons(currentPage);
      $('.pagination-center').html(paginationButtons);
    });
  
    $('.pagination-center').on('click', '#prevBtn', function() {
      if (currentPage > 1) {
        currentPage--;
        showItems(currentPage);
  
        var paginationButtons = generatePaginationButtons(currentPage);
        $('.pagination-center').html(paginationButtons);
      }
    });
  
    $('.pagination-center').on('click', '#nextBtn', function() {
      if (currentPage < totalPages) {
        currentPage++;
        showItems(currentPage);
  
        var paginationButtons = generatePaginationButtons(currentPage);
        $('.pagination-center').html(paginationButtons);
      }
    });
  
    $('.pagination-right button').on('click', function() {
      var targetPage = parseInt($('#jump-to-page').val());
  
      if (targetPage >= 1 && targetPage <= totalPages) {
        currentPage = targetPage;
        showItems(currentPage);
  
        var paginationButtons = generatePaginationButtons(currentPage);
        $('.pagination-center').html(paginationButtons);
      } else {
        // Display an error message or handle invalid page number
      }
    });

    function jump() {
      var targetPage = parseInt($('#jump-to-page').val());
  
      if (targetPage >= 1 && targetPage <= totalPages) {
        currentPage = targetPage;
        showItems(currentPage);
        var paginationButtons = generatePaginationButtons(currentPage);
        $('.pagination-center').html(paginationButtons);
      } else {
        // Display an error message or handle invalid page number
      }
    }

    var inputElement = document.getElementById('jump-to-page');
    inputElement.addEventListener("keypress", function(event) {
      if (event.key === 'Enter') {
        event.preventDefault();
        jump();
      }
    })

    inputElement.oninput = function () {
      var max = parseInt(this.max);

      if (parseInt(this.value) > max) {
          this.value = max; 
      }
    }
  
    function generatePaginationButtons(currentPage) {
        var paginationButtons = '';
      
        var startPage;
        var endPage;
      
        if (totalPages <= 5) {
          // If the total number of pages is 5 or less, display all pages
          startPage = 1;
          endPage = totalPages;
        } else {
          // If the total number of pages is more than 5
          if (currentPage <= 3) {
            // If current page is within the first 3 pages
            startPage = 1;
            endPage = 5;
          } else if (currentPage >= totalPages - 2) {
            // If current page is within the last 3 pages
            startPage = totalPages - 4;
            endPage = totalPages;
          } else {
            // If current page is in the middle
            startPage = currentPage - 2;
            endPage = currentPage + 2;
          }
        }
      
        if (startPage > 1) {
            if (currentPage >= 4 && totalPages > 5) {
                console.log("hide page button 1");
            } else {
                paginationButtons += '<button class="pageBtn">' + 1 + '</button>';
            }
        }
      
        if (currentPage > 1) {
          paginationButtons += '<button id="prevBtn" class="prevBtn"><i class="bx bx-chevron-left" ></i></button>';
        }
      
        for (var i = startPage; i <= endPage; i++) {
          var activeClass = (i === currentPage) ? 'active' : '';
          paginationButtons += '<button class="pageBtn ' + activeClass + '">' + i + '</button>';
        }
      
        if (currentPage < totalPages) {
          paginationButtons += '<button id="nextBtn" class="nextBtn"><i class="bx bx-chevron-right" ></i></button>';
        }
        var pagesMoreThan5 = totalPages - 5;
        if (totalPages <= 5) {
            pagesMoreThan5 = 0;
        }
        if (endPage < totalPages - pagesMoreThan5) {
          paginationButtons += '<button class="pageBtn">' + totalPages + '</button>';
        }
        updateJumpToPageMax(endPage);
        return paginationButtons;
      }

      function updateJumpToPageMax(maxValue) {
        $('#jump-to-page').attr('max', maxValue);
      }
  
    var paginationButtons = generatePaginationButtons(currentPage);
    $('.pagination-center').html(paginationButtons);
  });

  

  var empty = document.getElementById('empty');
  var searchbar = document.querySelector('.inputAndDeleteDiv');
  var pagini = document.querySelector('.pagination');
  if (empty.style.display != 'none'){
    searchbar.style.display = 'none';
    pagini.style.display = 'none';
}