$(function(){
  $('.selectpicker').selectpicker();
});

function eventNameSearch() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("eventNameData");
    filter = input.value.toUpperCase();
    table = document.getElementById("eventNameTable");
    tr = table.getElementsByTagName("tr");
    noResult = document.getElementById("noResultEve");
    noData = document.querySelectorAll("#noDataEve");

    var rows=tr.length;
    var rows2=noData.length;

    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[0];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } 
        else {
          tr[i].style.display = "none";
          rows--;
        }
      }
    }
    if (rows === 0  && rows2 != 1){
      noResult.style.display = "block";
    }
    else{
      noResult.style.display = "none";
    }
    
  }

  function categoryNameSearch() {
    var input, filter, table, tr, td, i, alltables;
    input = document.getElementById("categoryNameData");
    filter = input.value.toUpperCase();
    alltables= document.querySelectorAll("table[data-name=categoryNameTable]");
    noResult = document.getElementById("noResultCat");
    noData = document.querySelectorAll("#noDataCat");

    var rows=0;
    var rows2=noData.length;

    alltables.forEach(function(table){
      tr = table.getElementsByTagName("tr");
      rows=tr.length;

      for (i = 0; i < tr.length; i++) {
        if (tr[i].innerText.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
          rows--;
        }
      }
    
    });
    if (rows === 0 && rows2 != 1){
      noResult.style.display = "block";
    }
    else{
      noResult.style.display = "none";
    }
  } 