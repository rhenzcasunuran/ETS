<?php

include 'connections.php';

session_start();

if (isset($_SESSION['session_resident_id'])) {
    header('location: personal-information.php');
}

if(isset($_POST['email-confirmation-btn'])) {
    // Check if the required query parameters are present
    $otp = $_POST['code'];

    if(isset($_GET['token'], $_GET['id'])) {
        $token = $_GET['token'];
        $resident_id = $_GET['id'];

        // Prepare the SELECT statement to check if the entry exists in the database
        $select = "SELECT * FROM forgot_password_users WHERE token = ? AND otp = ? AND resident_id = ? AND is_used = 0";
        $stmt = mysqli_prepare($conn, $select);
        mysqli_stmt_bind_param($stmt, 'ssi', $token, $otp, $resident_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) > 0) {
            // Entry exists in the database, proceed with further logic
            
            // Fetch the row from the result set
            $row = mysqli_fetch_assoc($result);

            // Retrieve the expiration time from the row
            $expirationTime = $row['expiration_time'];

            // Check if the expiration time has passed
            if(strtotime($expirationTime) >= time()) {
                // Entry has not expired, continue with password reset or other actions
                header("Location: ./resident-new-password.php?token=$token&otp=$otp&id=$resident_id");
            } else {
                // Entry has expired
                $error[] =  "The link has expired. Please request a new password reset link.";
            }
        } else {
            // Entry not found in the database
            $error[] =  "Invalid or expired code.";
        }
    } else {
        // Missing query parameters
        $error[] =  "Invalid request. Please try again.";
    }
};
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
            <label class="form-label text-3 fw-bold" id="text-container">Enter the code that was sent to (email).</label>
            <form action="" method="POST" class="form-container needs-validation" id="forgot-password-container" novalidate>
                <div class="form-header col-12">CODE</div>
                <small class="text-center">Verification</small>
                <input type="text" class="form-control form-field code" name="code" oninput="validateNumberInput(this)" required>
                <?php
                    if(isset($error)) {
                        foreach($error as $error) {
                            echo '<p class="form-label text-3 text-center text-decoration-none" style=color:red>'.$error.'</p>';
                        };
                    };
                ?> 
                <div class="form-group col-12 justify-content-center align-items-end d-flex">
                    <input class="btn text-center" type="submit" valid="Submit" name="email-confirmation-btn">
                </div>
            </form>

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

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
            }, false)
        })
        })()

        function validateNumberInput(input) {
            // Remove any non-digit characters
            var number = input.value.replace(/\D/g, '');

            // Restrict the input to a maximum of 6 digits
            if (number.length > 6) {
                number = number.slice(0, 6);
            }

            // Update the input value
            input.value = number;
        }
    </script>
</body>
</html>
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
    <div id="content-container">
        <div class="flex-column justify-content-center d-flex align-items-center w-100">
            <label class="form-label text-3 fw-bold" id="text-container">Enter the code that was sent to (email).</label>
            <form action="" method="POST" class="form-container needs-validation" id="forgot-password-container" novalidate>
                <div class="form-header col-12">CODE</div>
                <small class="text-center">Verification</small>
                <input type="text" class="form-control form-field code" name="code" oninput="validateNumberInput(this)" required>
                <div class="form-group col-12 justify-content-center align-items-end d-flex">
                    <input class="btn text-center" type="submit" valid="Submit" name="email-confirmation-btn">
                </div>
            </form>

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

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
            }, false)
        })
        })()

        function validateNumberInput(input) {
            // Remove any non-digit characters
            var number = input.value.replace(/\D/g, '');

            // Restrict the input to a maximum of 6 digits
            if (number.length > 6) {
                number = number.slice(0, 6);
            }

            // Update the input value
            input.value = number;
        }
    </script>
</body>
</html>