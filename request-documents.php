<?php
include './connections.php';

session_start();

if (!isset($_SESSION['session_resident_id'])) {
    header('location: resident-login.php');
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

    <link rel="stylesheet" href="./css/request-documents.css">
</head>
<body>
    <!--Navbar-->
    <div class="login-bar" id="top-var">
        <div class="text-1">
            Document Request
        </div>
        <div class="row">
            <div class="col-9 d-flex align-items-center">
                <div class="row" id="navItemContainer">
                    <a href="#Home" class="col-3">
                        <div class="text-1" id="navItem">
                            Home
                        </div>
                    </a>
                    <a href="personal-information.php" class="col-3">
                        <div class="text-1" id="navItem">
                            Profile
                        </div>
                    </a>
                    <a href="" class="col-3">
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
    <div class="content-container">
        <div class="row m-0" id="content">
            <div class="col-8 d-flex justify-content-center align-items-center m-0">
                <div class="request-container">
                    <div class="row row-height">
                        <div class="col-4" id="document-btn-container">
                            <button class="document-btn">
                                <div class="btn-container">
                                    <i class="bx bx-fingerprint"></i>
                                    <p>Clearance</p>
                                </div>
                            </button>
                        </div>
                        <div class="col-4" id="document-btn-container">
                            <button class="document-btn">
                                <div class="btn-container">
                                    <i class="bx bx-file"></i>
                                    <p>Indigency</p>
                                </div>
                            </button>
                        </div>
                        <div class="col-4" id="document-btn-container">
                            <button class="document-btn">
                                <div class="btn-container">
                                    <i class="bx bx-building-house"></i>
                                    <p>Residency</p>
                                </div>
                            </button>
                        </div>
                    </div>
                    <div class="row row-height">
                        <div class="col-4" id="document-btn-container">
                            <button class="document-btn">
                                <div class="btn-container">
                                    <i class="bx bx-user-check"></i>
                                    <p>Good Moral</p>
                                </div>
                            </button>
                        </div>
                        <div class="col-4" id="document-btn-container">
                            <button class="document-btn">
                                <div class="btn-container">
                                    <i class="bx bx-id-card"></i>
                                    <p>Barangay ID</p>
                                </div>
                            </button>
                        </div>
                        <div class="col-4" id="document-btn-container">
                            <button class="document-btn">
                                <div class="btn-container">
                                    <i class="bx bx-user-plus"></i>
                                    <p>Late Birth</p>
                                </div>
                            </button>
                        </div>
                    </div>
                    <div class="row row-height">
                        <div class="col-4" id="document-btn-container">
                            <button class="document-btn">
                                <div class="btn-container">
                                    <i class="bx bx-briefcase"></i>
                                    <p>No Business</p>
                                </div>
                            </button>
                        </div>
                        <div class="col-4" id="document-btn-container">
                            <button class="document-btn">
                                <div class="btn-container">
                                    <i class="bx bx-receipt"></i>
                                    <p>Permit</p>
                                </div>
                            </button>
                        </div>
                        <div class="col-4" id="document-btn-container">
                            <button class="document-btn">
                                <div class="btn-container">
                                    <i class="bx bx-book-heart"></i>
                                    <p>Common Law</p>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4 d-flex justify-content-center align-items-center m-0">
                <div class="request-container">
                    <div class="row card-height" id="requested-container">
                        <div class="requested-card">
                            <!--If has request-->
                            <div class="has-document d-grid">
                                <div class="requested-documents">
                                    <ul>
                                        <li>Indigency</li>
                                        <li>Residency</li>
                                        <li>Barangay ID</li>
                                    </ul>
                                </div>
                                <div class="button-container">
                                    <button class="btn">Edit</button>
                                    <button class="btn">Clear All</button>
                                    <button class="btn" id="submitRequest" name="submitRequest">Submit Request</button>
                                </div>
                            </div>
                            <!--If has NO request-->
                            <div class="has-no-document d-none">
                                <div class="no-document">
                                    <i class='bx bxs-x-square'></i>
                                    <p>You have NO document added</p>
                                </div>
                            </div>
                            <!--If request submitted-->    
                            <div class="successful-submit-document d-none">
                                <div class="request-submitted">
                                    <p>Your request is waiting for approval.</p>
                                    <button class="btn" id="approvalBtn" name="approvalBtn">Check the status <i class='bx bx-right-arrow-alt'></i></button>
                                </div>    
                            </div>                    
                        </div>
                    </div>
                    <div class="row button-height" id="requested-container">
                        <button class="btn"><i class='bx bx-time-five'></i> Request History</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>