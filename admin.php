<?php
  include './php/database_connect.php';
  include './php/admin-signin.php';
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Tabulation System</title>
    <!-- Theme Mode -->
    <link rel="stylesheet" href="./css/theme-mode.css">
    <script src="./js/default-theme.js"></script>
    <!-- Link Styles -->
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/responsive.css">
    <link rel="stylesheet" href="./css/system-wide.css">
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/admin-login.css">
  </head>

  <body>
      <div id="section">
        <form method="post">
          <div id="logo">
            <img src="./pictures/logo.png" alt="student council logo" class="icon logo">
            <div id="logo_name">Events<br>Management<br>System</div>
          </div>
          <div id="loginContainer">
            <div id="containerPadding">
              <div id="header">Administrator</div>
              <div id="label">Username</div>
              <input type="text" name="user_username" maxlength="20" required/>
              <div id="label">Password</div>
              <input type="password" name="user_password" maxlength="128" required/>
              <button input type="submit" name="sign-in-button" id="loginButton">Log in</button>
            </div>
          </div>
        </form>
      </div>
    <!--SCRIPT -->
    <script src="./js/script.js"></script>
    <script src="./js/jquery-3.6.4.js"></script>
  </body>
</html>