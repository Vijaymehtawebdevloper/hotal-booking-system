<?php
    require "admin/inc/config.php";
    require "admin/inc/essencials.php";
    $settings_d = "SELECT * FROM `settings` WHERE `sr_no`=?";
    $values = [1];
    $settings_d = mysqli_fetch_assoc(select($settings_d, $values, 'i'));

    $contact_d = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
    $values1 = [1];
    $contact_d = mysqli_fetch_assoc(select($contact_d, $values1, 'i'));
    date_default_timezone_set('Asia/Kolkata');

    if($settings_d['shutdown']){
        echo <<<alertbar
            <div class = 'bg-danger text-center text-white p-2 fw-bold'>
                <i class="bi bi-exclamation-triangle-fill"></i>
                Booking are temprarily closed!
            </div>
        alertbar;
    }

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title><?php echo $settings_d['site_title']?></title>
</head>
<body class="bg-light">
    <nav id="nav-bar" class="navbar navbar-expand-lg navbar-light bg-white px-lg-2 py-lg-2 shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="#"><?php echo $settings_d['site_title']?></a>
            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link  me-2" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a id="a" class="nav-link me-2" href="room.php">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="facilities.php">Facilities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="contect_us.php">Contact us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                </ul>
                <?php
                    session_start();
                    // print_r($_SESSION);
                    if(isset($_SESSION['login']) && $_SESSION['login'] == true){
                        $path = USER_IMG_PATH;
                        echo <<<data
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-info shadow-none dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                <img src = "$path$_SESSION[uPic]" style = "width:25px; height:25px;" class = "me-1">
                                $_SESSION[uName]
                            </button>
                            <ul class="dropdown-menu dropdown-menu-lg-end">
                                <li><a href="profile.php" class="dropdown-item" type="button">Profile</a></li>
                                <li><a href="bookings.php" class="dropdown-item" type="button">Bookings</a></li>
                                <li><a href="logout.php" class="dropdown-item" type="button">Logout</a></li>
                            </ul>
                        </div>
                        data;
                    }else{
                        echo <<<data
                        <form class="d-flex">
                            <button type="button" class="btn btn-outline-success shadow-none me-lg-3 me-2" data-bs-toggle="modal" data-bs-target="#loginmodal">
                                Log in
                            </button>
                            <button type="button" class="btn btn-success shadow-none" data-bs-toggle="modal" data-bs-target="#registermodal">
                                Register
                            </button>
                        </form>
                        data;
                    }
                ?>
                
            </div>
        </div>
    </nav>

    <!-- login mnodel -->
    <div class="modal fade" id="loginmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="login_form">
                    <div class="modal-header d-flex align-items-center">
                        <h5 class="modal-title"><i class="bi bi-person-circle ms-3 me-2"></i> User Login</h5>
                        <button type="reset " class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Email / Mobile</label>
                            <input type="text" name="email_mob" class="form-control shadow-none" placeholder="name@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="pass" class="form-control shadow-none" placeholder="password">
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-outline-success shadow-none">Login</button>
                            <button class="btn text-success text-decoration-none shadow-none p-0" data-bs-toggle="modal" data-bs-target="#forgotmodal" data-bs-dismiss="modal">Forgot Password</button>
                        </div>
                    </div>
                </form>
            
            </div>
        </div>
    </div>

    <!-- forgot model -->
    <div class="modal fade" id="forgotmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="forgot_form">
                    <div class="modal-header d-flex align-items-center">
                        <h5 class="modal-title"><i class="bi bi-person-circle ms-3 me-2"></i> Forgot password</h5>
                        <button type="reset " class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span class="badge bg-light text-dark mb-3 text-wrap lh-base">
                           Note :A link will be sent to your email to reset password!
                        </span>
                        <div class="mb-3">
                            <label class="form-label">Email / Mobile</label>
                            <input type="text" name="email" class="form-control shadow-none" placeholder="name@example.com" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn ext-secondary text-decoration-none shadow-none" data-bs-toggle="modal" data-bs-target="#loginmodal" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-outline-success shadow-none">Send link</button>
                        </div>
                    </div>
                </form>
            
            </div>
        </div>
    </div>

    <!-- register model -->
    <div class="modal fade" id="registermodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="register-form">
                    <div class="modal-header d-flex align-items-center">
                        <h5 class="modal-title"><i class="bi bi-person-lines-fill ms-3 me-2"></i>
                            User Register
                        </h5>
                        <button type="reset " class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span class="badge bg-light text-dark mb-3 text-wrap lh-base">
                            Note: Your detail must match with your ID (Adhar card, Passport, Driving license, etc.)
                            that will be required during check-in.
                        </span>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6  ps-0">
                                    <label class="form-label">Name</label>
                                    <input name="name" type="text" class="form-control shadow-none" placeholder="Your name" required>
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Email address</label>
                                    <input name="email" type="email" class="form-control shadow-none" placeholder="name@example.com" required>
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Phone number</label>
                                    <input name="phnumber" type="text" class="form-control shadow-none" placeholder="Phone number" required>
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Picturcture</label>
                                    <input name="picture" type="file" class="form-control shadow-none" placeholder="Phone number" required>
                                </div>
                                <div class="col-md-12 ps-0 mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" class="form-control shadow-none" rows="1" required></textarea>
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Pincode></label>
                                    <input name="pcode" type="number" class="form-control shadow-none" placeholder="Pin code" required>
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Date of birth></label>
                                    <input name="dob" type="date" class="form-control shadow-none" placeholder="Date of birth" required>
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Password></label>
                                    <input name="password" type="password" class="form-control shadow-none" placeholder="Password" required>
                                </div>
                                <div class="col-md-6 ps-0 mb-3">
                                    <label class="form-label">Conform password</label>
                                    <input name="cpassword" type="password" class="form-control shadow-none" placeholder="Conform password" required>
                                </div>
                            </div>
                        </div>
                        <div class="text-center ">
                            <button class="btn btn-primary shadow-none">Register</button>
                        </div>
                        <!-- <div class="mb-3">
                            <label class="form-label">Email address</label>
                            <input type="email" class="form-control shadow-none" placeholder="name@example.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control shadow-none" placeholder="password">
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-primary">Login</button>
                            <a href="javascript:void(0)" class="text-secondary text-decoration-none">Forgot Password</a>
                        </div> -->
                    </div>
                </form>
            
            </div>
        </div>
    </div>