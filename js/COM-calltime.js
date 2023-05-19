var calen = document.getElementById('calendar-pp-wrap');

      buttons.forEach((button) => {
        button.addEventListener("click", (e) => {
          const h2 = e.target.closest('.parent');
          const input = h2.querySelector('.sched_output');
          const simplepicker = new SimplePicker ({
            zIndex: 10
          });
          if (button.textContent === "Edit Schedule") {
            var edit_wrap = document.getElementById('edit-pp-wrap');
            var edit_popup = document.getElementById('edit-pp');
            var yahbtn = document.getElementById('yaahbtn');
            var nahbtn = document.getElementById('naahbtn');
            edit_wrap.style.display = "block";
            edit_popup.style.display = "block";
            edit_wrap.addEventListener("click", function(){
              edit_wrap.style.display = "none";
              edit_popup.style.display = "none";
            });
            yahbtn.addEventListener("click", function(){
              edit_wrap.style.display = "none";
              edit_popup.style.display = "none";
            });
            nahbtn.addEventListener("click", function(){
              edit_wrap.style.display = "none";
              edit_popup.style.display = "none";
              calendar_wrap.remove();
            });
          }
          if (button.textContent === "Unavailable") { 
            var cant_wrap = document.getElementById('cant-pp-wrap');
            var cant_popup = document.getElementById('cant-pp');
            var cantbtn = document.getElementById('cant-btn');
            cant_wrap.style.display = "block";
            cant_popup.style.display = "block";
            cant_wrap.addEventListener("click", function(){
              cant_wrap.style.display = "none";
              cant_popup.style.display = "none";
              calendar_wrap.remove();
            });
            cantbtn.addEventListener("click", function(){
              cant_wrap.style.display = "none";
              cant_popup.style.display = "none";
              calendar_wrap.remove();
            });
          }
          simplepicker.open();
          var parentElement = button.parentElement;
          var id = parentElement.id;
          var competitionName = id;
          var calendar_wrap = document.getElementById('calendar-wrapper');
          if (calendar_wrap = document.getElementById('calendar-wrapper')) {
            var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            // Check the response from the PHP file and change the color of the button
            console.log(this.responseText);
            var response = JSON.parse(this.responseText);
            var time = response.time;
            var options = { timeZone: 'Asia/Manila', hour12: true, hour: 'numeric', minute: 'numeric' };
            var formattedTime = time.toLocaleString('en-US', options);
            var day = response.day;
            var month = response.month;
            var year = response.year;
            var day_header = document.getElementById("day-headerID");
            var month_year = document.getElementById("month-yearID");
            var date_current = document.getElementById("dateID");
            var time_current = document.getElementById("timeID");
            if (month == '01'){
              month = 'January';
            }
            if (month == '02'){
              month = 'February';
            }
            if (month == '03'){
              month = 'March';
            }
            if (month == '04'){
              month = 'April';
            }
            if (month == '05'){
              month = 'May';
            }
            if (month == '06'){
              month = 'June';
            }
            if (month == '07'){
              month = 'July';
            }
            if (month == '08'){
              month = 'August';
            }
            if (month == '09'){
              month = 'September';
            }
            if (month == '10'){
              month = 'October';
            }
            if (month == '11'){
              month = 'November';
            }
            if (month == '12'){
              month = 'December';
            }
            var green = 'rgb(102, 232, 90)';
            var btnColor = button.style.backgroundColor;
            if (btnColor == green){
              day_header.textContent = 'Current Scheduled Time';
            }
            
            month_year.textContent = month +' ' +year;
            date_current.textContent = day;
            time_current.textContent = formattedTime;
          }else {
            var time_current = document.getElementById("timeID");
            var time_value = document.getElementById('inputboxTime');
            if (time_value) {
              time_current.textContent = time_value.value;
            console.log("eto ay else time_value: "+time_value.value);
            }
          }
        };
          }
          
      });
    });