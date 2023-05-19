
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Score Tabulation</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="./css/theme-mode.css">
    <script src="./js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="./css/P&J-participantsandjudges.css">
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/sidebar-style.css">
    <link rel="stylesheet" href="./css/home-sidebar-style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400&amp;display=swap">
    <link rel="stylesheet" href="css/bootstrap.min.css">
  </head>

  <body style="background: rgb(25,20,36);">
    <nav class="navbar navbar-light navbar-expand-md" style="background: #282135;">
        <div class="container">
                        <h1 class="text-start" style="color: rgb(255,255,255); font-weight: 1000; margin-top: 20px;margin-left:400px;">Score Tabulation</h1>
            </div>
        </div>
    </nav>
    <div class="container" style="margin:auto;">
        <div class="row" style="margin-top: 16px;">
            <div class="col-xl-3 col-xxl-2 offset-xxl-0"><label class="form-label" style="color: rgb(255,255,255);margin-left:30px;">Event</label><br>
            <input type='text' class='inputpname' style='border-radius:10px; margin-left:20px;' placeholder='Event Code' name='event_code_temp' id="event_code_temp" minlength="10" maxlength="20" style="margin-left:30px;width: 180px; height: 40px;" Required/>
            </div>
            <div class="col"><label class="form-label" style="color: rgb(255,255,255);margin-left:30px;">Group</label><br>
                <select style="border-radius: 10px;width: 180.031px;height: 40px;margin-left: 19px;background: var(--bs-light);color: var(--bs-body-color); text-align: center;">IT Week
                    <option>ITDS</option>
                    <option>Group 2</option>
                    <option>Group 3</option>
                </select>
            </div>
        </div>
        <div class="row" style="margin-top: 20px; margin-bottom:20px;">
            <div class="col-lg-6 col-xl-6 col-xxl-4 offset-lg-0 offset-xxl-2">
            

</div>
</div>

        <div class="row" style="margin-top: 20px; margin-bottom:20px;">
            <div class="col-lg-6 col-xl-6 col-xxl-4 offset-lg-0 offset-xxl-2"><label class="form-label" style="margin-left:20px;color: rgb(255,255,255);">Criteria</label>
                <div class="d-table" style="background: #423c4e;margin-left: 10px;min-height: auto;padding-top: 33px;padding-left: 31px;padding-right: 39px;padding-bottom: 20px;min-width: auto;width: 100%;border-radius: 10px;box-shadow: 7px 5px 13px;">
                    <div class="row">
                        <div class="col" style="text-align: center;">
                            <div class="row">
                                <div class="col"><label class="col-form-label" style="color: rgb(255,255,255);font-weight:1000;">ITDS</label></div>
                                <div class="col"><label class="col-form-label" style="color: rgb(255,255,255);">Scores</label></div>
                            </div>
                            <form action="#" method="POST" id="add_form">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col"><label class="col-form-label" style="color: rgb(255,255,255);">Criteria 1</label></div>
                                        <div class="col"><input type="number" style="text-align: center;color: rgb(255,255,255);background: rgba(0,0,0,0.22);" min="1" max="10" placeholder="10" Required></div>
                                    </div>
                                    <div class="row">
                                        <div class="col"><label class="col-form-label" style="color: rgb(255,255,255);">Criteria 2</label></div>
                                        <div class="col"><input type="number" style="text-align: center;color: rgb(255,255,255);background: rgba(0,0,0,0.22);" min="1" max="10" placeholder="10" Required></div>
                                    </div>
                                    <div class="row">
                                        <div class="col"><label class="col-form-label" style="color: rgb(255,255,255);">Criteria 3</label></div>
                                        <div class="col"><input type="number" style="text-align: center;color: rgb(255,255,255);background: rgba(0,0,0,0.22);" min="1" max="10" placeholder="10" required></div>
                                    </div>
                                    <div class="row">
                                        <div class="col"><label class="col-form-label" style="color: rgb(255,255,255);">Criteria 4</label></div>
                                        <div class="col"><input type="number" style="text-align: center;color: rgb(255,255,255);background: rgba(0,0,0,0.22);" min="1" max="10" placeholder="10" required></div>
                                    </div>
                                    <div class="row">
                                        <div class="col"><label class="col-form-label" style="color: rgb(255,255,255);">Total:</label></div>
                                        <div class="col"><label class="col-form-label" style="color: rgb(255,255,255);">100</label></div>
                                    </div>
                                    <div class="row text-center" style="text-align: center;">

                    <div class="col offset-xl-2 offset-xxl-1" style="text-align: center;">
                        <div class="btn-toolbar" style="text-align: center;">
                            <div class="btn-group" role="group" style="text-align: center;margin-top: 10px;">
                                <button class="buttonsubmit" value="Add" id="add_btnS" type="submit" style="text-align: center;margin-left: 20px;width: 76px;height: 38px;border-radius: 15px;color:white;">Save</button>
                                <button class="buttonsave" type="button" style="text-align: center;margin-left: 7px;width: 103px;height: 38px;border-radius: 15px;">Submit</button>
                                <button class="buttoncancel" type="button" style="text-align: center;margin-left: 7px;width: 73px;height: 38px;border-radius: 15px;">Cancel</button></div>
                        </div>
                    </div>
                </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                
            </div>
            <div class="col-lg-5 col-xxl-4 offset-lg-1 offset-xl-1 offset-xxl-1" style="padding: 0px;">
                <div style="background: #282135;margin-top: 27px;height: 226px;border-radius: 10px;box-shadow: 3px 3px 8px;">
                    <div class="container">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="color: rgb(255,255,255);">Group/Participants</th>
                                        <th style="color: rgb(255,255,255);">Scores</th>
                                        <th style="color: rgb(255,255,255);">Edit</th>
                                    </tr>
                                </thead>
                                <tbody style="color: rgb(255,255,255);">
                                    <tr style="color: rgb(255,255,255);">
                                        <td style="color: rgb(255,255,255);">ITDS</td>
                                        <td style="color: rgb(255,255,255);">100%</td>
                                        <td style="color: rgb(255,255,255);"><button class="buttonsave" type="button" style="background: rgb(255,181,70);">Edit</button></td>
                                    </tr>
                                    <tr style="color: rgb(255,255,255);">
                                        <td style="color: rgb(255,255,255);">JPIA</td>
                                        <td style="color: rgb(255,255,255);">94%</td>
                                        <td style="color: rgb(255,255,255);"><button class="buttonsave" type="button" style="background: rgb(255,181,70);">Edit</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="./js/script.js"></script>
    <script src="./js/change-theme.js"></script>
    <script src="./js/jquery-3.6.4.js"></script>
    <script src="./js/jqueryPJ.min"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jqueryPJ.min"></script>
    <script type="text/javascript">
      $('.menu_btn').click(function (e) {
        e.preventDefault();
        var $this = $(this).parent().find('.sub_list');
        $('.sub_list').not($this).slideUp(function () {
          var $icon = $(this).parent().find('.change-icon');
          $icon.removeClass('bx-chevron-down').addClass('bx-chevron-right');
        });

        $this.slideToggle(function () {
          var $icon = $(this).parent().find('.change-icon');
          $icon.toggleClass('bx-chevron-right bx-chevron-down')
        });
      });


    </script>
    <script>
        // ajax request
        $("#add_form3").submit(function(e){
                e.preventDefault();
                $("#add_btn").val('Adding...');
                $.ajax({
                    url:'php/P&J-admin-action-temp.php',
                    method:'POST',
                    data: $(this).serialize(),
                    success:function(response){
                        console.log(response);
                        $("#add_btnS").val('Add');
                        
                    }
                })
            });
    </script>
</body>

</html>