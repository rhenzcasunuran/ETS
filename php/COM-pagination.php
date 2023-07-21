<div class="paginations">
  <div class="pagination-left">
    <label for="items-per-page">Item(s) shown:</label>
    <select id="items-per-page" class="itemDD">
      <option value="1">1</option>
      <option value="5" selected>5</option>
      <option value="10">10</option>
      <option value="15">15</option>
      <option value="20">20</option>
      <option value="25">25</option>
    </select>
  </div>

  <div class="pagination-center">
    <!-- Pagination buttons will be generated dynamically using JavaScript -->
  </div>

  <div class="pagination-right">
    <button id="jump-button" class="jump-button">Go to</button>
    <input type="number" id="jump-to-page" class="jump-input" min="1" max="10">
  </div>
</div>

<script>
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
    if (totalItems <= 0) {
      var paginations = document.querySelector('.paginations');
      paginations.style.display = "none";
    }
</script>