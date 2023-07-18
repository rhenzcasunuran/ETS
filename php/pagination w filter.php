<!--Instructions
    Put this in your home-section.

    <php
      $list_table_query = "SELECT * FROM table_name";           // Your DB table with the said list
      $your_php_location = "EVE-admin-list-of-events.php";      // Your module with the said list

      require './php/pagination.php';                           // include the pagination

      $list_table_query_with_limit = "SELECT * FROM table_name LIMIT $start_from, $numberOfItems;";     // Your table with the said list but with LIMIT. DO NOT CHANGE THE LIMIT!
      $listedItems = mysqli_query($conn, $list_table_query_with_limit);                                 // DO NOT CHANGE!
    ?>


    How to fetch?
        On your "while ($row = mysqli_fetch_array(variable))" or your loop to get the lists.
        Change the variable to $listedItems.
        Example: while ($row = mysqli_fetch_array($listedItems))
-->

<!--Pagination-->
<link rel="stylesheet" href="./css/pagination.css">
<script src="./js/noOfEntriesCached.js"></script>

<script>
    var selectedValue;

    // Retrieve the stored value from local storage
    var storedValue = localStorage.getItem('itemsPerPage');

    // Set the stored value as the selected option
    if (storedValue) {
        selectedValue = storedValue;
        if (window.location.search === "" || window.location.search === "?=") {
            window.location.href = `?items=${selectedValue}`;
        } 
    }

</script>

<?php
  $query_mo = mysqli_query($conn, $list_table_query);
  $total_records = mysqli_num_rows($query_mo);

  if(isset($_GET['page'])) {
    $page = $_GET['page'];
  }
  else {
    $page = 1;
  }

  $searchValue = isset($_GET['search']) ? $_GET['search'] : '';
  $selectedFilters = isset($_GET['filterValue']) ? (array)$_GET['filterValue'] : array();
  $sortValue = isset($_GET['sortValue']) ? $_GET['sortValue'] : 'datetime';
  $sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'ascending';
  $numberOfItems = isset($_GET['items']) ? $_GET['items'] : 15;

  $filterConditions = array();

  if (in_array('tournament', $selectedFilters)) {
    $filterConditions[] = "et.event_type = 'Tournament'";
  }

  if (in_array('competition', $selectedFilters)) {
    $filterConditions[] = "et.event_type = 'Competition'";
  }

  if (in_array('standard', $selectedFilters)) {
    $filterConditions[] = "et.event_type = 'Standard'";
  }

  // Combine the filter conditions with OR logic
  if (!empty($filterConditions)) {
    $filterQuery = "(" . implode(" OR ", $filterConditions) . ")";
  } else {
    $filterQuery = ""; // Empty filter query if no filters selected
  }

  if ($numberOfItems != 5 && $numberOfItems != 10 && $numberOfItems != 15 && $numberOfItems != 20 && $numberOfItems != 25) {
    $numberOfItems = 5;
  }

  $numberOfPages = ceil($total_records / $numberOfItems);

  if($page > $numberOfPages) {
    $page = 1;
  }

  $start_from = ($page - 1) * $numberOfItems;
?>

<div id="paginationContainer">
    <div class="paginationContainerContainer">
        <div class="items-page">
        <p>No. of Items:</p>
        <select name="items" class="page-control" id="itemsPerPageSelect">
            <option value="5" <?php if ($numberOfItems == 5) echo 'selected'; ?>>5</option>
            <option value="10" <?php if ($numberOfItems == 10) echo 'selected'; ?>>10</option>
            <option value="15" <?php if ($numberOfItems == 15) echo 'selected'; ?>>15</option>
            <option value="20" <?php if ($numberOfItems == 20) echo 'selected'; ?>>20</option>
            <option value="25" <?php if ($numberOfItems == 25) echo 'selected'; ?>>25</option>
        </select>
        </div>
        <div id="pagination">
            <?php
            $maxVisiblePages = 10;
            $itemsPerPage = $numberOfItems;
            
            $visibleItems = $maxVisiblePages * $itemsPerPage;
            $startPage = max(1, ceil($page / $maxVisiblePages) * $maxVisiblePages - ($maxVisiblePages - 1));
            $endPage = min($startPage + $maxVisiblePages - 1, $numberOfPages);
            
            if ($endPage - $startPage < $maxVisiblePages - 1) {
                $startPage = max(1, $endPage - $maxVisiblePages + 1);
            }

            if ($startPage > 1) {
                $filterParams = implode('&', array_map(function ($value) {
                    return 'filterValue[]=' . urlencode($value);
                }, $selectedFilters));
                echo "<a href='$your_php_location?page=1&items=$numberOfItems' class='page'><i class='bx bx-chevrons-left'></i></a>";
                echo "<a href='$your_php_location?page=".($startPage - 1)."&items=".$numberOfItems."&$filterParams&sortValue=".$sortValue."&sortOrder=".$sortOrder."&search=".$searchValue."' class='page'><i class='bx bx-chevron-left'></i></a>";
            }

            for ($i = $startPage; $i <= $endPage; $i++) {
                $filterParams = implode('&', array_map(function ($value) {
                    return 'filterValue[]=' . urlencode($value);
                }, $selectedFilters));
                $selectedClass = ($i == $page) ? 'selected' : '';
                echo "<a href='$your_php_location?page=$i&items=".$numberOfItems."&$filterParams&sortValue=".$sortValue."&sortOrder=".$sortOrder."&search=".$searchValue."' class='page $selectedClass' id='pageNmbr$i'>$i</a>";
            }

            if ($endPage < $numberOfPages) {
                $filterParams = implode('&', array_map(function ($value) {
                    return 'filterValue[]=' . urlencode($value);
                }, $selectedFilters));
                echo "<a href='$your_php_location?page=".($endPage + 1)."&items=".$numberOfItems."&$filterParams&sortValue=".$sortValue."&sortOrder=".$sortOrder."&search=".$searchValue."' class='page'><i class='bx bx-chevron-right'></i></a>";
                echo "<a href='$your_php_location?page=$numberOfPages&items=".$numberOfItems."&$filterParams&sortValue=".$sortValue."&sortOrder=".$sortOrder."&search=".$searchValue."' class='page'><i class='bx bx-chevrons-right'></i></a>";
            }
            ?>
        </div>

        <div class="goto-page">
            <p>Go to Page:</p>
            <input type="text" class="page-control" id="goToPageInput" maxlength="4" autocomplete="off">
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
    const itemsPerPageSelect = $('#itemsPerPageSelect');
    var selectedFilters = $('input[name="filterValue"]:checked').map(function() {
            return this.value;
        }).get();
    var filterValue = selectedFilters.length > 0 ? selectedFilters : 'all';
    var sortValue = $('input[name="sortValue"]:checked').val();
    var sortOrder = $('input[name="sortOrder"]:checked').val();
    var searchValue = $('#searchInput').val().trim();

    $('#searchInput').on('keyup', function(e) {
            if (e.keyCode === 13) {
              e.preventDefault();
              searchValue = $(this).val().trim();
              filterResults();
            }
    });

    // Retrieve the stored array from localStorage
    var storedArray = JSON.parse(localStorage.getItem('selectedEvents')) || [];

    // Check if each event is selected and update the stored array accordingly
    $('input[name="deleteEvent[]"]').each(function() {
    var eventId = $(this).val();
    var storedValue = storedArray.includes(eventId);
    if (storedValue) {
        $(this).prop('checked', true);
    }
    });

    $('input[name="deleteEvent[]"]').on('change', function() {
    var eventId = $(this).val();
    if ($(this).is(':checked')) {
        // Add the eventId to the array
        storedArray.push(eventId);
    } else {
        // Remove the eventId from the array
        var index = storedArray.indexOf(eventId);
        if (index > -1) {
        storedArray.splice(index, 1);
        }
    }
    // Update the array in localStorage
    localStorage.setItem('selectedEvents', JSON.stringify(storedArray));
    });


    const your_page = '<?php echo $your_php_location; ?>';
    $('#searchInput').val('<?php echo isset($_GET["search"]) ? $_GET["search"] : ""; ?>');
    searchValue = $('#searchInput').val();

    itemsPerPageSelect.on('change', function() {
        selectedValue = itemsPerPageSelect.val();
        var currentPage = '<?php echo $page; ?>';
        window.location.href = `${your_page}?page=${currentPage}&items=${selectedValue}&filterValue[]=${filterValue.join('&filterValue[]=')}&sortValue=${sortValue}&sortOrder=${sortOrder}&search=${searchValue}`;
    });

    $('input[name="sortValue"]').on('change', function() {
        sortValue = $(this).val();
        var currentPage = '<?php echo $page; ?>';
        window.location.href = `${your_page}?page=${currentPage}&items=${selectedValue}&filterValue[]=${filterValue.join('&filterValue[]=')}&sortValue=${sortValue}&sortOrder=${sortOrder}&search=${searchValue}`;
    });

    $('input[name="sortOrder"]').on('change', function() {
        sortOrder = $(this).val();
        var currentPage = '<?php echo $page; ?>';
        window.location.href = `${your_page}?page=${currentPage}&items=${selectedValue}&filterValue[]=${filterValue.join('&filterValue[]=')}&sortValue=${sortValue}&sortOrder=${sortOrder}&search=${searchValue}`;
    });

    $('input[name="filterValue"]').on('click', function() {
        selectedFilters = $('input[name="filterValue"]:checked').map(function() {
            return this.value;
        }).get();
        
        var currentPage = '<?php echo $page; ?>';
        filterValue = selectedFilters.length > 0 ? selectedFilters : 'all';
        var url = `${your_page}?page=${currentPage}&items=${selectedValue}&filterValue[]=${filterValue.join('&filterValue[]=')}&sortValue=${sortValue}&sortOrder=${sortOrder}&search=${searchValue}`;
        
        window.location.href = url;
    });

    // Function to filter results
    function filterResults() {
      var currentPage = '<?php echo $page; ?>';
      var url = `${your_page}?page=${currentPage}&items=${selectedValue}&filterValue[]=${filterValue.join('&filterValue[]=')}&sortValue=${sortValue}&sortOrder=${sortOrder}&search=${searchValue}`;

      window.location.href = url;
    }

    // Highlight selected page number
    const currentPage = '<?php echo $page; ?>';
    const selectedPage = $('#pageNmbr' + currentPage);
    selectedPage.addClass('selected');

    // Go to page functionality
    const goToPageBtn = $('#goToPageBtn');
    const goToPageInput = $('#goToPageInput');

    // Go to page functionality
    goToPageInput.on('keyup', function(event) {
        if (event.keyCode === 13) {
        const goToPage = parseInt(goToPageInput.val());
        if (goToPage >= 1 && goToPage <= <?php echo $numberOfPages; ?>) {
            const selectedValue = itemsPerPageSelect.val();
            window.location.href = `${your_page}?page=${goToPage}&items=${selectedValue}&filterValue[]=${filterValue.join('&filterValue[]=')}&sortValue=${sortValue}&sortOrder=${sortOrder}&search=${searchValue}`;
        }
        }
    });
});

    $('input').keypress(function (e) {
        var txt = String.fromCharCode(e.which);
        if (!txt.match(/[0-9]/)) {
            return false;
        }
    });
</script>