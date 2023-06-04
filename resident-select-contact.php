<?php
include './connections.php';

session_start();

if (isset($_SESSION['session_resident_id'])) {
    header('location: personal-information.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BRGY Aplaya</title>

    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/boxicons.css">
    <link rel="stylesheet" href="./css/BRGY-aplaya.css">

    <link rel="stylesheet" href="./css/login.css">
</head>
<body>
    <!--Navbar-->
    <div class="login-bar" id="top-var">
        <div class="text-1">
            Welcome to E-Playa
        </div>
        <div class="text-1">
            About
        </div>
    </div>
    <!--Content-->
    <div id="content-container">
        <div class="flex-column justify-content-center d-flex align-items-center w-100">
            <label class="form-label text-3 fw-bold" id="text-container">Select which contact detail should we use to reset your password.</label>
            <div class="form-container" id="forgot-password-container">
                <div class="form-header col-12">Select Contact</div>
                <a href="resident-forgot-password-email.php" class="text-center">
                    <button class="btn forgot-btn">
                        <span><i class='bx bx-envelope'></i></span>
                        E-mail
                    </button>
                </a>
                    <button class="btn forgot-btn">
                        <span><i class='bx bx-phone'></i></span>
                        Phone Number
                    </button>
            </div>
            <br>
            <div class="d-flex justify-content-center align-items-center flex-column">
                <a href="resident-login.php">
                    <button class="btn text-center">Cancel</button>
                </a>
            </div>
        </div>
    </div>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/jquery-3.6.4.js"></script>
</body>
</html>