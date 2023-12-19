<?php 
    include("inc/header.php"); 
    $is_shutdown = mysqli_fetch_assoc(mysqli_query($con, "SELECT `shutdown` FROM `settings`"));

    $current_booking = mysqli_fetch_assoc(mysqli_query($con, "SELECT 
        COUNT(CASE WHEN booking_status = 'booked' AND arivel = 0 THEN 1 END) AS `new_bookings`,
        COUNT(CASE WHEN booking_status = 'cancel' AND refund = 0 THEN 1 END) AS `refund_bookings`
        FROM `booking_order`"));

    $unread_queries = mysqli_fetch_assoc(mysqli_query($con, "SELECT
        COUNT(sr_no) AS `count` FROM `user_queries` WHERE `seen` = 0"));

    $unread_review = mysqli_fetch_assoc(mysqli_query($con, "SELECT
        COUNT(sr_no) AS `count` FROM `rating_review` WHERE `seen` = 0"));

    $current_users = mysqli_fetch_assoc(mysqli_query($con, "SELECT 
        COUNT(id) AS `total`,
        COUNT(CASE WHEN `status` = 1 THEN 1 END) AS `active`,
        COUNT(CASE WHEN `status` = 0 THEN 1 END) AS `inactive`,
        COUNT(CASE WHEN `is_wefired` = 0 THEN 1 END) AS `unverified`
        FROM `user_register`"));
        // print_r($current_users);
?>
    <div class="container-fluid " id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3>DASHBORD</h3>
                    <?php
                        if($is_shutdown['shutdown']){
                            echo <<<data
                                <h6 class="badge bg-danger py-2 px-3 rounded">Shutdown mode is active</h6>
                            data;
                        }
                    ?>
                </div>
                <div class="row mb-4">
                    <div class="col-md-3 mb-4">
                        <a href="new_bookings.php" class="text-decoration-none">
                            <div class="card text-center text-success">
                                <h6>New Booking</h6>
                                <h1><?php echo $current_booking['new_bookings']?></h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="refund_bookings.php" class="text-decoration-none">
                            <div class="card text-center text-warning">
                                <h6>Refund Booking</h6>
                                <h1><?php echo $current_booking['refund_bookings']?></h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="user_queries.php" class="text-decoration-none">
                            <div class="card text-center text-info">
                                <h6>user Queries</h6>
                                <h1><?php echo $unread_queries['count']?></h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="rate_review.php" class="text-decoration-none">
                            <div class="card text-center">
                                <h6>Rate & Review</h6>
                                <h1><?php echo $unread_review['count']?></h1>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5>Boooking Analytics</h5>
                    <select class="form-select shadow-none bg-light w-auto" onchange="booking_analytics(this.value)">
                        <option value="1">Past 30 Days</option>
                        <option value="2">Past 90 Days</option>
                        <option value="3">Past 1 Year</option>
                        <option value="4">All Time</option>
                    </select>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 mb-3">
                        <div class="card text-center text-primary">
                            <h6>Total Bookings</h6>
                            <h1 class="mt-2 mb-0" id="total_bookings">5</h1>
                            <h4 class="mt-2 mb-0" id="total_amt">0</h4>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card text-center text-success">
                            <h6>Active Booking</h6>
                            <h1 class="mt-2 mb-0" id="active_bookings">5</h1>
                            <h4 class="mt-2 mb-0" id="active_amt">0</h4>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card text-center text-warning">
                            <h6>Cancelled Booking</h6>
                            <h1 class="mt-2 mb-0" id="cancelled_bookings">5</h1>
                            <h4 class="mt-2 mb-0" id="cancelled_amt">0</h4>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5>User, Queries, Reviews Analytics</h5>
                    <select class="form-select shadow-none bg-light w-auto" onchange="users_analytics(this.value)">
                        <option value="1">Past 30 Days</option>
                        <option value="2">Past 90 Days</option>
                        <option value="3">Past 1 Year</option>
                        <option value="4">All Time</option>
                    </select>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 mb-3">
                        <div class="card text-center text-primary">
                            <h6>New Rigistration</h6>
                            <h1 class="mt-2 mb-0" id="total_users">5</h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card text-center text-success">
                            <h6>Queries</h6>
                            <h1 class="mt-2 mb-0" id="total_queries">5</h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card text-center text-warning">
                            <h6>Reviews</h6>
                            <h1 class="mt-2 mb-0" id="total_review">5</h1>
                        </div>
                    </div>
                </div>
                <h5>Users</h5>
                <div class="row mb-3">
                    <div class="col-md-3 mb-3">
                        <div class="card text-center text-primary">
                            <h6>Total Users</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['total']?></h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card text-center text-success">
                            <h6>Active Users</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['active']?></h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card text-center text-warning">
                            <h6>Inactive Users</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['inactive']?></h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card text-center text-danger">
                            <h6>Unverified Users</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['unverified']?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include("inc/script.php"); ?>
<?php include("inc/footer.php"); ?>
<script src="script-js/dashbord.js"></script>
</body>
</html>