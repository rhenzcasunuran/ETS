<!--Instructions
    Put this in your head

    <script src="./js/noOfEntriesCached.js"></script>

    
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
<script>
    var selectedValue;

    // Retrieve the stored value from local storage
    var storedValue = localStorage.getItem('itemsPerPage');

    // Set the stored value as the selected option
    if (storedValue) {
        selectedValue = storedValue;
        if (window.location.search === "") {
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

  $numberOfItems = isset($_GET['items']) ? $_GET['items'] : 15;

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
                echo "<a href='$your_php_location?page=1&items=$numberOfItems' class='page'><i class='bx bx-chevrons-left'></i></a>";
                echo "<a href='$your_php_location?page=".($startPage - 1)."&items=$numberOfItems' class='page'><i class='bx bx-chevron-left'></i></a>";
            }

            for ($i = $startPage; $i <= $endPage; $i++) {
                $selectedClass = ($i == $page) ? 'selected' : '';
                echo "<a href='$your_php_location?page=$i&items=$numberOfItems' class='page $selectedClass' id='pageNmbr$i'>$i</a>";
            }

            if ($endPage < $numberOfPages) {
                echo "<a href='$your_php_location?page=".($endPage + 1)."&items=$numberOfItems' class='page'><i class='bx bx-chevron-right'></i></a>";
                echo "<a href='$your_php_location?page=$numberOfPages&items=$numberOfItems' class='page'><i class='bx bx-chevrons-right'></i></a>";
            }
            ?>
        </div>

        <div class="goto-page">
            <p>Go to Page:</p>
            <input type="text" class="page-control" id="goToPageInput">
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
    const itemsPerPageSelect = $('#itemsPerPageSelect');
    const your_page = '<?php echo $your_php_location; ?>';

    itemsPerPageSelect.on('change', function() {
        selectedValue = itemsPerPageSelect.val();
        var currentPage = '<?php echo $page; ?>';
        window.location.href = `${your_page}?page=${currentPage}&items=${selectedValue}`;
    });

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
            window.location.href = `${your_page}?page=${goToPage}&items=${selectedValue}`;
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