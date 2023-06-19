<div class="pagination">
  <div class="pagination-left">
    <label for="items-per-page">Item(s) shown:</label>
    <select id="items-per-page" class="itemDD">
      <option value="1">1</option>
      <option value="2" selected>2</option>
      <option value="3">3</option>
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
