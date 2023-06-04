<?php

include './connections.php'; 

session_start();

if (isset($_SESSION['session_resident_id'])) {
    header('location: personal-information.php');
}

$token = $_GET['token'];
$otp = $_GET['otp'];
$resident_id = $_GET['id'];

// Check if the required variables are present
if (isset($token, $otp, $resident_id)) {
    // Initialize connection
    $stmt = mysqli_stmt_init($conn);

    // Prepare the SELECT statement to check if the entry is valid
    $select = "SELECT * FROM forgot_password_users WHERE token = ? AND otp = ? AND resident_id = ? AND is_used = 0;";
    mysqli_stmt_prepare($stmt, $select);
    mysqli_stmt_bind_param($stmt, 'ssi', $token, $otp, $resident_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if a valid entry exists in the database
    if (mysqli_num_rows($result) > 0) {
   
        // Fetch the row from the result set
        $row = mysqli_fetch_assoc($result);

        // Retrieve the expiration time from the row
        $expirationTime = $row['expiration_time'];
        $is_used = $row['is_used'];
        
        // Check if the expiration time has passed
        if ((strtotime($expirationTime) >= time()) && ($is_used === 0)) {

            // Valid entry exists and has not expired, proceed with further logic
            if(isset($_POST['confirm-new-password-btn'])) {
                $new_password = md5($_POST['newPassword']);
                $confirm_password = md5($_POST['confirmNewPassword']);
            
                $select = "SELECT ru.*, rac.* FROM resident_users AS ru
                INNER JOIN resident_address_contact AS rac 
                ON ru.resident_id = rac.resident_id WHERE ru.resident_id = ?;";
                
                if(!mysqli_stmt_prepare($stmt, $select)){
                    echo "SQL connection error";
                } else {
                    mysqli_stmt_bind_param($stmt, 'i', $resident_id);
                    mysqli_stmt_execute($stmt,);
                    $result = $stmt->get_result();
            
                    if(mysqli_num_rows($result) > 0) {
                        
                        if($new_password == $confirm_password) {
                            // passwords match, update user's password in the database
                            $update = "UPDATE resident_users SET resident_password = ? WHERE resident_id = ?";
                            if(!mysqli_stmt_prepare($stmt, $update)){
                                echo "SQL connection error";
                            } else {
                                mysqli_stmt_bind_param($stmt, 'si', $new_password, $resident_id);
                                mysqli_stmt_execute($stmt);

                                // Set is_used to 1
                                $update_flags = "UPDATE forgot_password_users SET is_used = 1 WHERE token = ? AND otp = ? AND resident_id = ?";
                                if (!mysqli_stmt_prepare($stmt, $update_flags)) {
                                    echo "SQL connection error";
                                } else {
                                    mysqli_stmt_bind_param($stmt, 'ssi', $token, $otp, $resident_id);
                                    mysqli_stmt_execute($stmt);
                                    header("Location: resident-login.php");
                                }
                            }
                        } else {
                            // passwords don't match, display error message
                            $error[] =  "Passwords don't match";
                        }
                    } else {
                        // resident_id not found, display error message
                        $error[] = "Something went wrong";
                        header("Location: resident-forgot-password-email.php");
                    }        
                }
            }
        } else {
            // Entry has expired or is no longer active
            // Redirect the user back to resident-forgot-password-email.php
            $error[] = "Token has expired or is no longer active";
            header("Location: resident-forgot-password-email.php");
        }
    } else {
        // Entry has expired or is no longer active
        // Redirect the user back to resident-forgot-password-email.php
        $error[] = "Token has expired or is no longer active";
        header("Location: resident-forgot-password-email.php");
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
            <form action="" method="POST" class="form-container needs-validation" id="forgot-password-container" oninput='confirmNewPassword.setCustomValidity(confirmNewPassword.value != newPassword.value ? "Passwords do not match." : "")' novalidate>
                <div class="form-header col-12">Set your NEW Password</div>
                <div class="form-group">
                    <label for="new-password" class="form-label">New Password <span id="required">*</span></label>
                    <div class="input-group" id="show-hide-password">
                        <input type="password" class="form-control form-field" id="new-password" name="newPassword" required>
                        <div class="input-group-text">
                            <i class="bx bx-hide" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm-new-password" class="form-label">Confirm Password <span id="required">*</span></label>
                    <div class="input-group" id="show-hide-confirm-password">
                        <input type="password" class="form-control form-field" id="confirm-new-password" name="confirmNewPassword" required>
                        <div class="input-group-text">
                            <i class="bx bx-hide" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <?php
                    if(isset($error)) {
                        foreach($error as $error) {
                            echo '<p class="form-label text-3 text-center text-decoration-none" style=color:red>'.$error.'</p>';
                        };
                    };
                ?> 
                <div class="form-group col-12 justify-content-center align-items-end d-flex">
                    <input class="btn text-center" type="submit" value="Submit" name="confirm-new-password-btn">
                </div>
            </form>

            <br>
            <div class="d-flex justify-content-center align-items-center flex-column">
                <a href="./resident-login.php">
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

        $("#show-hide-password .input-group-text").on('click', function(e) {
            e.preventDefault();
            if($('#show-hide-password input').attr("type") === "text"){
                $('#show-hide-password input').attr('type', 'password');
                $('#show-hide-password i').addClass( "bx-hide" );
                $('#show-hide-password i').removeClass( "bx-show" );
            }else if($('#show-hide-password input').attr("type") === "password"){
                $('#show-hide-password input').attr('type', 'text');
                $('#show-hide-password i').removeClass( "bx-hide" );
                $('#show-hide-password i').addClass( "bx-show" );
            }
        });

        $("#show-hide-confirm-password .input-group-text").on('click', function(e) {
            e.preventDefault();
            if($('#show-hide-confirm-password input').attr("type") === "text"){
                $('#show-hide-confirm-password input').attr('type', 'password');
                $('#show-hide-confirm-password i').addClass( "bx-hide" );
                $('#show-hide-confirm-password i').removeClass( "bx-show" );
            }else if($('#show-hide-confirm-password input').attr("type") === "password"){
                $('#show-hide-confirm-password input').attr('type', 'text');
                $('#show-hide-confirm-password i').removeClass( "bx-hide" );
                $('#show-hide-confirm-password i').addClass( "bx-show" );
            }
        });
    </script>
</body>
</html>