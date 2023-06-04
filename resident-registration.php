<?php
include './connections.php';

session_start();

if (isset($_SESSION['session_resident_id'])) {
    header('location: personal-information.php');
}

if (isset($_POST['register-btn'])) {
    
    // Account Details
    $stmt = mysqli_stmt_init($conn);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);
    $confirm_password = md5($_POST['confirmPassword']);
    $email_address = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone']);
    $current_date_time = date('Y-m-d H:i:s');

    // Check if password matches
    if ($password != $confirm_password) {
        $error[] = 'Passwords did not match!';
    } 

    // Check if username, email, and phone number already exist
    $checkQuery = "SELECT ru.resident_username, rac.phone_number, rac.email_address 
    FROM resident_users AS ru
    INNER JOIN resident_address_contact AS rac 
    ON ru.resident_id = rac.resident_id
    WHERE ru.resident_username = ? OR rac.email_address = ? OR rac.phone_number = ?";

    if (!mysqli_stmt_prepare($stmt, $checkQuery)) {
        echo "SQL connection error";
    } else {
        mysqli_stmt_bind_param($stmt, 'sss', $username, $email_address, $phone_number);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            $error[] = "Username, email address, or phone number already used!";
        } else {
            $insert = "INSERT INTO resident_users (resident_username, resident_password,
            account_creation_date)
            VALUES (?, ?, ?)";
        
            if (!mysqli_stmt_prepare($stmt, $insert)) {
                echo "SQL connection error";
            } else {
                // Insert to resident_users table
                mysqli_stmt_bind_param($stmt, 'sss', $username, $password, $current_date_time);        
                mysqli_stmt_execute($stmt);
                $resident_id = mysqli_insert_id($conn); // Retrieve the inserted resident_id
        
                // Personal Details
                $first_name = mysqli_real_escape_string($conn, $_POST['first-name']);
                $middle_name = mysqli_real_escape_string($conn, $_POST['middle-name']);
                $last_name = mysqli_real_escape_string($conn, $_POST['last-name']);
                $suffix = mysqli_real_escape_string($conn, $_POST['suffix-name']);
                $birth_month = mysqli_real_escape_string($conn, $_POST['month']);
                $birth_day = mysqli_real_escape_string($conn, $_POST['day']);
                $birth_year = mysqli_real_escape_string($conn, $_POST['year']);
                // Adjust the month value to have leading zeros if necessary
                $adjusted_birth_month = str_pad($birth_month, 2, "0", STR_PAD_LEFT);
                // Concatenate the birthdate values into the desired format
                $birthdate = $birth_year . "-" . $adjusted_birth_month . "-" . $birth_day;
                $place_of_birth = mysqli_real_escape_string($conn, $_POST['birthplace']);
                $sex = mysqli_real_escape_string($conn, $_POST['sex']);
                $civil_status = mysqli_real_escape_string($conn, $_POST['civil-status']);
        
                $insert2 = "INSERT INTO resident_personal_details (resident_id, first_name,
                middle_name, last_name, suffix, birth_date, birth_place, sex, civil_status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
                if (!mysqli_stmt_prepare($stmt, $insert2)) {
                    echo "SQL connection error";
                } else {
                    mysqli_stmt_bind_param($stmt, 'sssssssss', $resident_id, $first_name, $middle_name,
                    $last_name, $suffix, $birthdate, $place_of_birth, $sex, $civil_status);        
        
                    mysqli_stmt_execute($stmt);
                }
        
                // Contact and Address Details
                $street_building_house = mysqli_real_escape_string($conn, $_POST['address']);
                $province = mysqli_real_escape_string($conn, $_POST['province']);
                $city = mysqli_real_escape_string($conn, $_POST['city']);
                $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
                $zipcode = mysqli_real_escape_string($conn, $_POST['zipcode']);
        
                $insert3 = "INSERT INTO resident_address_contact (resident_id, street_building_house,
                province, city, barangay, zipcode, phone_number, email_address)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
                if (!mysqli_stmt_prepare($stmt, $insert3)) {
                    echo "SQL connection error";
                } else {
                    mysqli_stmt_bind_param($stmt, 'ssssssss', $resident_id, $street_building_house,
                    $province, $city, $barangay, $zipcode, $phone_number, $email_address);        
        
                    mysqli_stmt_execute($stmt);
                }
        
                // ID Verification
                $valid_id_type = mysqli_real_escape_string($conn, $_POST['id-type']);
                $valid_id_number = mysqli_real_escape_string($conn, $_POST['id-number']);
                $valid_id_issued = mysqli_real_escape_string($conn, $_POST['id-issued-date']);
        
                $insert4 = "INSERT INTO resident_id_verification (resident_id, valid_id_type,
                valid_id_number, id_issued_date)
                VALUES (?, ?, ?, ?)";
        
                if (!mysqli_stmt_prepare($stmt, $insert4)) {
                    echo "SQL connection error";
                } else {
                    mysqli_stmt_bind_param($stmt, 'ssss', $resident_id, $valid_id_type,
                    $valid_id_number, $valid_id_issued);        
        
                    mysqli_stmt_execute($stmt);
                }
                
                header('location: resident-login.php');
        
                // Close the statement and database connection
                $stmt->close();
                $conn->close();
            }
        }
    }
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
    <!--Registration CSS-->
    <link rel="stylesheet" href="./css/registration.css">
</head>
<body>
    <!--Terms & Conditions
    <div class="container-fluid" id="terms-and-conditions-popup">
        <div class="form-container flex-column align-items-start justify-content-start" id="terms-and-conditions">
            <div class="form-header col-12 border-bottom">Terms & Conditions</div>
            <div class="flex-column d-grid w-100 h-100">
                <div class="content">
                    <p>Hello World</p>
                </div>
                <div class="text-center d-flex align-items-end justify-content-center h-100">
                    <div class="btn">Close</div>
                </div>
            </div>
        </div>
    </div>
    -->
    <!--Navbar-->
    <div id="top-var">
        <div class="text-1">
            Already have an account?
            <span>
                <a href="resident-login.php">
                    <button class="btn text-1">Login</button>
                </a>
            </span> 
        </div>
    </div>
    <!--Content-->
    <div id="content-container">
            <form action="resident-registration.php" method="POST" autocomplete="off" class="form-container needs-validation" id="form-container" oninput='confirmPassword.setCustomValidity(confirmPassword.value != password.value ? "Passwords do not match." : "")' novalidate>
                <div class="row h-100 form-section" id="tab-1">
                    <div class="form-header col-12">Personal Details</div>
                    <div class="form-group col-sm-7 has-feedback">
                        <label for="first-name" class="form-label">First Name <span id="required">*</span></label>
                        <input type="text" class="form-control form-field letters-only" id="first-name" name="first-name" required>
                    </div>
                    <div class="form-group col-sm-5 has-feedback">
                        <label for="middle-name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control letters-only" id="middle-name" name="middle-name">
                    </div>
                    <div class="form-group col-sm-9 has-feedback">
                        <label for="last-name" class="form-label">Last Name <span id="required">*</span></label>
                        <input type="text" class="form-control form-field letters-only" id="last-name" name="last-name" required>
                    </div>
                    <div class="form-group col-sm-3 has-feedback">
                        <label for="suffix-name" class="form-label">Suffix</label>
                        <input type="text" class="form-control" id="suffix-name" name="suffix-name">
                    </div>
                    <div class="form-group col-sm-5 has-feedback">
                        <label class="form-label">Date of Birth <span id="required">*</span></label>
                        <select id="month" class="form-select form-field" id="suffix-name" name="month" title="Birthmonth" onchange="change_month(this)"  required></select>
                    </div>
                    <div class="form-group col-sm-3 has-feedback">
                        <label class="form-label"><span id="required">*</span></label>
                        <select id="day" class="form-select form-field" id="suffix-name" name="day" title="Birthday"  required></select>
                    </div>
                    <div class="form-group col-sm-4 has-feedback">
                        <label class="form-label"><span id="required">*</span></label>
                        <select id="year" class="form-select form-field" id="suffix-name" name="year" title="Birthyear" onchange="change_year(this)"  required></select>
                    </div>
                    <div class="form-group col-sm-5 has-feedback">
                        <label for="birthplace" class="form-label">Place of Birth <span id="required">*</span></label>
                        <input type="text" class="form-control form-field letters-only" id="birthplace" name="birthplace"  required>
                    </div>
                    <div class="form-group col-sm-3 has-feedback">
                        <label for="sex" class="form-label">Sex <span id="required">*</span></label>
                        <select class="form-select form-field" id="sex" name="sex"  required>
                            <option hidden value=""></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4 has-feedback">
                        <label for="civil-status" class="form-label">Civil Status <span id="required">*</span></label>
                        <select class="form-select form-field" id="civil-status" name="civil-status"  required>
                            <option hidden value=""></option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Live in">Live in</option>
                            <option value="Divorce">Divorce</option>
                            <option value="Seperated">Seperated</option>
                            <option value="Widowed">Widowed</option>
                        </select>
                    </div>
                    <?php
                        if(isset($error)) {
                            foreach($error as $error) {
                                echo '<p class="form-label text-3 text-center text-decoration-none" style=color:red>'.$error.'</p>';
                            };
                        };
                    ?> 
                </div>
                <div class="row h-100 form-section" id="tab-2">
                    <div class="form-header col-12">Address & Contact Details</div>
                    <div class="form-group col-12">
                        <label for="address" class="form-label">Street/Building/House No. <span id="required">*</span></label>
                        <input type="text" class="form-control form-field" id="address" name="address" required>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="province" class="form-label">Province <span id="required">*</span></label>
                        <select class="form-select form-field" id="province" name="province" required>
                            <option value="Laguna" selected>Laguna</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="city" class="form-label">City/Municipality <span id="required">*</span></label>
                        <select class="form-select form-field" id="city" name="city" required>
                            <option value="Santa Rosa" selected>Santa Rosa</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="barangay" class="form-label">Barangay <span id="required">*</span></label>
                        <select class="form-select form-field" id="barangay" name="barangay" required>
                            <option value="Aplaya" selected>Aplaya</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="zipcode" class="form-label">Zipcode <span id="required">*</span></label>
                        <input type="text" class="form-control form-field numeric-only" id="zipcode" name="zipcode" minlength="4" maxlength="4" required>
                    </div>
                    <div class="form-group col-sm-9">
                        <label for="phone" class="form-label">Mobile Number <small>(09123456789)</small> <span id="required">*</span></label>
                        <input type="tel" class="form-control form-field numeric-only" id="phone" name="phone" pattern="[0-9]{11}" maxlength="11" required>
                    </div>
                    <div class="form-group col-12">
                        <label for="email" class="form-label">Email <span id="required">*</span> <span id="valid"></span></label>
                        <input type="email" class="form-control form-field" id="email" name="email" required>
                    </div>
                </div>

                <div class="row h-100 form-section" id="tab-3">
                    <div class="form-header col-12">ID Verification</div>
                    <div class="form-group col-12">
                        <label for="id" class="form-label">Type of ID <span id="required">*</span></label>
                        <select class="form-select form-field" id="id" name="id-type" required>
                            <option hidden value=""></option>
                            <option value="afp-beneficiary-id">AFP Beneficiary ID</option>
                            <option value="afpslai-id">AFPSLAI ID</option>
                            <option value="barangay-id">Barangay ID</option>
                            <option value="bir-tin">BIR (TIN)</option>
                            <option value="voters-id">COMELEC / Voter’s ID / COMELEC Registration Form</option>
                            <option value="drivers-license">Driver’s License</option>
                            <option value="e-card">e-Card / UMID</option>
                            <option value="employee-id">Employee’s ID / Office Id</option>
                            <option value="firearms-license">Firearms License</option>
                            <option value="ibp-id">Integrated Bar of the Philippines (IBP) ID</option>
                            <option value="nbi-clearance">NBI Clearance</option>
                            <option value="pag-ibig-id">Pag-ibig ID</option>
                            <option value="4ps-id">Pantawid Pamilya Pilipino Program (4Ps) ID</option>
                            <option value="passport">Passport</option>
                            <option value="pwd-id">Person’s With Disability (PWD) ID</option>
                            <option value="phil-health-id">Phil-health ID</option>
                            <option value="phil-id">Philippine Identification (PhilID / ePhilID)</option>
                            <option value="ph-postal-id">Philippine Postal ID</option>
                            <option value="prc-id">Professional Regulation Commission (PRC) ID</option>
                            <option value="pvao-id">PVAO ID</option>
                            <option value="school-id">School ID</option>
                            <option value="senior-citizen-id">Senior Citizen ID</option>
                            <option value="solo-parent-id">Solo Parent ID</option>
                            <option value="sss-id">SSS ID</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="id" class="form-label">ID Number <span id="required">*</span></label>
                        <input type="text" class="form-control form-field numeric-w-hyphen" id="id" name="id-number" required maxlength="36">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="id" class="form-label">ID Issued Date <span id="required">*</span></label>
                        <input type="date" class="form-control form-field" id="id" name="id-issued-date" required>
                    </div>
                    <div class="form-group row">
                        <div class="col-4" id="icon-container">
                            <i class='bx bxs-camera' id="icon"></i>
                        </div>
                        <div class="col-8">
                            <label for="selfie-id" class="form-label">Take a selfie with the selected ID <span id="required">*</span></label>
                            <input type="file" class="form-control" id="selfie-id" name="selfie-id" accept="image/png, image/jpeg">
                        </div>
                    </div>
                </div>

                <div class="row h-100 form-section" id="tab-4">
                    <div class="form-header col-12">Account</div>
                    <div class="form-group col-12">
                        <label for="username" class="form-label">Username <span id="required">*</span></label>
                        <input type="text" class="form-control form-field username" id="username" name="username" required>
                    </div>
                    <div class="form-group col-12">
                        <label for="password" class="form-label">Password <span id="required">*</span></label>
                        <div class="input-group" id="show-hide-password">
                            <input type="password" class="form-control form-field password" id="password" name="password" required>
                            <div class="input-group-text">
                                <i class="bx bx-hide" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label for="confirm-password" class="form-label">Confirm Password <span id="required">*</span></label>
                        <div class="input-group" id="show-hide-confirm-password">
                            <input type="password" class="form-control form-field" id="confirm-password" name="confirmPassword" required>
                            <div class="input-group-text">
                                <i class="bx bx-hide" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12" id="terms-conditions-container">
                        <input id="terms-conditions" type="checkbox" class="form-field" required>
                        <label for="terms-conditions" name="terms-conditions" class="form-label"> I Agree with <span class="popup-button">Terms & Conditions</span>.</label>
                    </div>
                </div>

                <div class="form-navigation d-flex justify-content-center align-self-end">
                    <button type="button" class="previous btn pull-left">&lt; Previous</button>
                    <button type="button" class="next btn pull-right">Next &gt;</button>
                    <input class="btn btn-default pull-right" type="submit" value="Submit" name="register-btn">
                    <span class="clearfix"></span>
                </div>
            </form>
    </div>

    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/jquery-3.6.4.js"></script>
    <script src="./js/parsley.min.js"></script>

    <!--Registration JS-->
    <script src="./js/date-picker.js"></script>
    <script src="./js/form-validation.js"></script>

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

        //Paste Validation
        $('.letters-only').on('input', function(e) {
          $(this).val(function(i, v) {
            return v.replace(/[^a-zA-Z\s]/g, '');
          });
        });

        $('.numeric-only').on('input', function(e) {
          $(this).val(function(i, v) {
            return v.replace(/[^0-9]/g, '');
          });
        });

        $('.numeric-w-hyphen').on('input', function(e) {
          $(this).val(function(i, v) {
            return v.replace(/[^0-9\-]/g, '');
          });
        });


        //Letter Validation
        $('.letters-only').keypress(function (e) {
          var txt = String.fromCharCode(e.which);
          if (!txt.match(/[A-Za-z ]/)) {
              return false;
          }
        });

        //Numeric Validation
        $('.numeric-only').keypress(function (e) {
          var txt = String.fromCharCode(e.which);
          if (!txt.match(/[0-9]/)) {
              return false;
          }
        });

        //Numeric Validation
        $('.numeric-w-hyphen').keypress(function (e) {
          var txt = String.fromCharCode(e.which);
          if (!txt.match(/[0-9-]/)) {
              return false;
          }
        });

        //Alphanumeric Validation
        $('.username').keypress(function (e) {
          var txt = String.fromCharCode(e.which);
          if (!txt.match(/[A-Za-z0-9_]/)) {
              return false;
          }
        });

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