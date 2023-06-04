<?php
include './connections.php';

session_start();

if (!isset($_SESSION['session_resident_id'])) {
    header('location: resident-login.php');
}

$resident_id = $_SESSION['session_resident_id'];

// Initialize a prepared statement
$stmt = mysqli_stmt_init($conn);

// Accouny Info
$query = "SELECT ru.*, rpd.*, rac.email_address 
FROM `resident_users` AS ru 
INNER JOIN resident_personal_details AS rpd ON ru.resident_id = rpd.resident_id 
INNER JOIN resident_address_contact AS rac ON ru.resident_id = rac.resident_id 
WHERE ru.resident_id = ?;";
// Prepare the statement
mysqli_stmt_prepare($stmt, $query);
// Bind the parameter
mysqli_stmt_bind_param($stmt, "i", $resident_id);
// Execute the statement
mysqli_stmt_execute($stmt);
// Get the result set
$result = mysqli_stmt_get_result($stmt);
// Check if the query was successful
if ($result) {
    // Fetch the row results
    $row = mysqli_fetch_assoc($result);
    $first_name = $row['first_name'];
    $middle_name = $row['middle_name'];
    $last_name = $row['last_name'];
    // Concatenate the first name, middle name, and last name
    $full_name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
    $username = $row['resident_username'];
    $email_address = $row['email_address'];
    $old_password = $row['resident_password'];
} else {
    // Handle the case where the query failed
    echo "Error executing the query: " . mysqli_error($conn);
}

// Password Reset
if (isset($_POST['submitNewPassword'])) {
    // Retrieve the form data
    $newPassword = md5($_POST['newPassword']); 
    $confirmPassword = md5($_POST['confirmPassword']);
    $oldPassword = md5($_POST['oldPassword']);

    if ($newPassword != $confirmPassword) {
        echo "Password doesn't match.";
    } else if (($newPassword === $confirmPassword)) {
        if ($old_password === $oldPassword) {
            $change_password = "UPDATE resident_users SET resident_password = ? WHERE resident_id = ?";
            // Prepare the statement
            mysqli_stmt_prepare($stmt, $change_password);
            // Bind the parameter
            mysqli_stmt_bind_param($stmt, "si", $newPassword, $resident_id);
            // Execute the statement
            mysqli_stmt_execute($stmt);
            echo "Password updated successfully.";
        } else{
            echo "Old Password didn't match our records.";
        }
    } else {
        echo "Password failed to update.";
    }
}

// Close the prepared statement
mysqli_stmt_close($stmt);

// Remember to close the database connection when you're done
mysqli_close($conn);
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

    <link rel="stylesheet" href="./css/personal-info.css">
    <link rel="stylesheet" href="./css/additional-account-security.css">
</head>
<body>
    <div class="popup-background" id="changePassword">
        <div class="row popup-container">
            <form action="" method="POST" id="resetPasswordForm" class="needs-validation" novalidate  oninput='confirmPassword.setCustomValidity(confirmPassword.value != newPassword.value ? "Passwords do not match." : "")' >
                <h3>Reset Password</h3>
                <div class="form-group text-start">
                    <label for="oldPassword">Old Password <span id="required">*</span></label>
                    <div class="input-group" id="show-hide-old-password">
                        <input type="password" class="form-control" id="oldPassword" name="oldPassword" required>
                        <div class="input-group-text">
                            <i class="bx bx-hide" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group text-start">
                    <label for="newPassword">New Password <span id="required">*</span></label>
                    <div class="input-group" id="show-hide-new-password">
                    <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                        <div class="input-group-text">
                            <i class="bx bx-hide" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group text-start">
                    <label for="confirmPassword">Confirm Password <span id="required">*</span></label>
                    <div class="input-group" id="show-hide-confirm-password">
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                        <div class="input-group-text">
                            <i class="bx bx-hide" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="button-container">
                    <div class="btn" onclick="closeBtn()">Close</div>
                    <input type="submit" value="Done" class="btn" name="submitNewPassword">
                </div>
            </form>
        </div>
    </div>
    <!--Navbar-->
    <div class="login-bar" id="top-var">
        <div class="text-1">
            My Profile
        </div>
        <div class="row">
            <div class="col-9 d-flex align-items-center">
                <div class="row" id="navItemContainer">
                    <a href="#Home" class="col-3">
                        <div class="text-1" id="navItem">
                            Home
                        </div>
                    </a>
                    <a href="" class="col-3">
                        <div class="text-1" id="navItem">
                            Profile
                        </div>
                    </a>
                    <a href="request-documents.php" class="col-3">
                        <div class="text-1" id="navItem">
                            Request
                        </div>
                    </a>
                    <a href="#About" class="col-3">
                        <div class="text-1" id="navItem">
                            About
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-3 p-0">
                <div class="flex-column justify-content-end d-flex align-items-end w-100 logout-container">
                    <button class="btn" id="logoutBtn" name="logout-btn" onclick="location.href = 'logout.php';">Logout</button>
                </div> 
            </div>
        </div>
    </div>
    <!--Content-->
    <div class="row d-flex justify-content-center align-items-start m-0 content-container">
            <div class="col-3">
                <div id="person-config">
                    <div class="row">
                        <i class='bx bxs-user-circle user-icon'></i>
                    </div>
                    <div class="row text-start">
                        <a href="personal-information.php"><i class='bx bxs-user-detail' ></i>Personal Information</a>
                        <a href="address-book.php"><i class='bx bxs-book'></i>Address Book</a>
                        <a href="" class="active"><i class='bx bx-lock-alt'></i>Account Security</a>
                    </div>
                </div>
            </div>
            <div class="col-9 mt-5">
                <div id="information-container">
                    <div class="row info text-center">
                        <div class="col-12 fw-bold fs-1">Account & Security Settings</div>
                    </div>
                    <div class="row info">
                        <label for="" class="col-3">Account Holder: </label>
                        <?php echo '<p class="col-9">' . $full_name . '</p>' ?>
                    </div>
                    <div class="row info">
                        <label for="" class="col-3">Username: </label>
                        <?php echo '<p class="col-9">' . $username . '</p>' ?>
                    </div>
                    <div class="row info">
                        <label for="" class="col-3">Email Address </label>
                        <?php echo '<p class="col-9">' . $email_address . '</p>' ?>
                    </div>
                    <div class="row info">
                        <label for="" class="col-3">Password: </label>
                        <div class="btn" id="resetPasswordBtn" onclick="openBtn()"><i class='bx bx-reset'></i> Reset your Password</div>
                    </div>
                </div>
            </div>
    </div>

    <script>
        popup = document.getElementById('changePassword');
      
        var openBtn = function() {
            popup.style.display ='flex';
        }
        var closeBtn = function() {
            popup.style.display ='none';
        }
    </script>

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

        $("#show-hide-old-password .input-group-text").on('click', function(e) {
            e.preventDefault();
            if($('#show-hide-old-password input').attr("type") === "text"){
                $('#show-hide-old-password input').attr('type', 'password');
                $('#show-hide-old-password i').addClass( "bx-hide" );
                $('#show-hide-old-password i').removeClass( "bx-show" );
            }else if($('#show-hide-old-password input').attr("type") === "password"){
                $('#show-hide-old-password input').attr('type', 'text');
                $('#show-hide-old-password i').removeClass( "bx-hide" );
                $('#show-hide-old-password i').addClass( "bx-show" );
            }
        });

        $("#show-hide-new-password .input-group-text").on('click', function(e) {
            e.preventDefault();
            if($('#show-hide-new-password input').attr("type") === "text"){
                $('#show-hide-new-password input').attr('type', 'password');
                $('#show-hide-new-password i').addClass( "bx-hide" );
                $('#show-hide-new-password i').removeClass( "bx-show" );
            }else if($('#show-hide-new-password input').attr("type") === "password"){
                $('#show-hide-new-password input').attr('type', 'text');
                $('#show-hide-new-password i').removeClass( "bx-hide" );
                $('#show-hide-new-password i').addClass( "bx-show" );
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