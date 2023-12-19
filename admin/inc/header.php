<?php
    include("inc/essencials.php");
    include("inc/config.php");
    adminLogin();
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - dashbord</title>
    <?php include("inc/links.php"); ?>
</head>
<body class="bg-light">
    <div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">
        <h3 class="mb-0 h-font">Admin panel</h3>
        <a href="logout.php" class="btn btn-primary btn-sm">Log out</a>
    </div>
    <div class="col-lg-2 bg-dark border-top border-3 border-secondary" id="dashbord-menu">
        <nav class="navbar navbar-expand-lg navbar-dark" id="dashbord">
            <div class="container-fluid flex-lg-column align-items-stretch">
                <h4 class="mt-2 text-light">ADMIN PANEL</h4>
                <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#adminDropDown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="adminDropDown">
                    <ul class="nav nav-pills  flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="dashbord.php">Dashbord</a>
                        </li>
                        <li class="nav-item">
                            <button class="btn text-white  w-100 px-3 shadow-none text-end d-flex align-items-center justify-content-between" data-bs-toggle="collapse" data-bs-target="#bookingLinks" type = "button">
                                <span>Booking</span>
                                <span><i class="bi bi-caret-down-fill"></i></span>
                            </button>
                            <div class="collapse px-3 small mb-1" id="bookingLinks">
                                <ul class="nav nav-pills flex-column rounded border border-secondary">
                                    <li class="nav-item">
                                        <a href="new_bookings.php" class="nav-link text-white">New bookings</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="refund_bookings.php" class="nav-link text-white">Refund bookings</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="booking_records.php" class="nav-link text-white">Booking records</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="users.php">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="user_queries.php">User queries</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="rate_review.php">Rating & review</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="carousel.php">Carousel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white " href="settings.php">Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="fetures_facilities.php">Feture & facilities</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="rooms.php">Rooms</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
