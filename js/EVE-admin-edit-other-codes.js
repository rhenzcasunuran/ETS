$(document).ready(function(){
    var todaysDate = new Date();
    
    var year = todaysDate.getFullYear();		
    var maxYear = year+1;
    var month = ("0" + (todaysDate.getMonth() + 1)).slice(-2); 
    var day = ("0" + todaysDate.getDate()).slice(-2);
  
    var dtMax = (maxYear + "-" + month + "-" + day);
    
    $("#date").attr('max', dtMax);
  });
  