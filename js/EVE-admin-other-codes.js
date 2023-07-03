$(document).ready(function(){
  var todaysDate = new Date();
  
  var year = todaysDate.getFullYear();		
  var maxYear = year+1;
  var month = ("0" + (todaysDate.getMonth() + 1)).slice(-2); 
  var day = ("0" + todaysDate.getDate()).slice(-2);

  var dtToday = (year + "-" + month + "-" + day);
  var dtMax = (maxYear + "-" + month + "-" + day);
  
  $("#date").attr('max', dtMax);
  $("#date").attr('min', dtToday);
});

$(document).ready(function() {
    $('.selectpicker').selectpicker();
    $('.bs-searchbox input').attr('maxlength', '25');
  });
