<?php
include './connections.php';

session_start();

if (isset($_SESSION['session_resident_id'])) {
    header('location: personal-information.php');
}

if(isset($_POST['login-btn'])) {
    
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);

    $select = "SELECT * FROM resident_users WHERE resident_username = ? AND resident_password = ? ";
    
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $select)) {
        echo "SQL connection failed";

    } else {
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) > 0) {
        
            $row = mysqli_fetch_array($result);
    
            $_SESSION['session_resident_id'] = $row['resident_id'];
            header('location: personal-information.php');

        } else {
            $error[] = "Username & Password doesn't match.";
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
            <form action="" method="POST" class="form-container needs-validation" id="login-container">
                <div class="form-header col-12">Resident</div>
                <div class="form-group col-12 has-feedback">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control form-field username" id="username" name="username" required>
                </div>
                <div class="form-group col-12 has-feedback">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control form-field" id="password" name="password" required>
                </div>
                <a href="resident-select-contact.php" class="form-label text-2 text-center text-decoration-none" id="forgot">Forgot Password?</a>
                <?php
                    if(isset($error)) {
                        foreach($error as $error) {
                            echo '<p class="form-label text-3 text-center text-decoration-none" style=color:red>'.$error.'</p>';
                        };
                    };
                ?> 
                <div class="form-group col-12 justify-content-center align-items-end d-flex">
                    <input class="btn text-center" type="submit" value="Login" name="login-btn">
                </div>
            </form>
            <br>
            <div class="d-flex justify-content-center align-items-center flex-column">
                <label class="form-label text-3 fw-bold">Don't have an account?</label>
                <a href="./resident-registration.php">
                    <button class="btn">Register</button>
                </a>
            </div>
        </div>
    </div>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/jquery-3.6.4.js"></script>

    <script>
        //Alphanumeric Validation
        $('.username').keypress(function (e) {
          var txt = String.fromCharCode(e.which);
          if (!txt.match(/[A-Za-z0-9_]/)) {
              return false;
          }
        });
    </script>
</body>
</html>