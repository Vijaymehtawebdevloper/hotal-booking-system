<?php include "inc/header.php"?>

<?php

/*
    check room id frim url is present or not
    shutdown mode is active or not
    user is logged in or not
*/ 
    if(!isset($_GET['id']) || $settings_d['shutdown'] == true){
        redirect('room.php');
    }else if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)){
        redirect('room.php');
    }

    // filter and ger room data and user data
    // print_r($_GET['id']);

    $frm_data = filteration($_GET);

    $room_res = select("SELECT * FROM rooms WHERE `id` = ? AND `status` = ? AND `removed` = ?", [$frm_data['id'], 1, 0], 'iii');
    if(mysqli_num_rows($room_res)==0){
        redirect('room.php');
    }
    $room_data = mysqli_fetch_assoc($room_res);


    $_SESSION['room'] = [
        'id' => $room_data['id'],
        'name' => $room_data['name'],
        'price' => $room_data['price'],
        'payment' => null,
        'availabel' => false,
    ];
    
    $user_res = select("SELECT * FROM user_register WHERE `id` = ? LIMIT 1", [$_SESSION['uID']], 'i');
    $user_data = mysqli_fetch_assoc($user_res);
?>

<div class="container">
    <div class="row">
        <div class="col-12 my-5 mb-4 px-4">
            <h2 class="fw-bold">CONFIRM BOOKING </h2>
            <div style="font-size: 14px;">
                <a href="index.php" class="text-secondary">Home</a>
                <span class="text-secondary"> > </span>
                <a href="rooms.php" class="text-secondary">Rooms</a>
                <span class="text-secondary"> > </span>
                <a href="#" class="text-secondary">Confirm</a>
            </div>
        </div>
        <div class="col-lg-7 col-md-12 px-4">
            <?php
                $room_thumb = ROOM_IMG_PATH.'thumbnail.jpg';
                $thumb_q = mysqli_query($con, "SELECT * FROM room_image WHERE `room_id` = $room_data[id] AND `thumb` = 1");

                if(mysqli_num_rows($thumb_q)>0){
                    $thumb_res = mysqli_fetch_assoc($thumb_q);
                    $room_thumb = ROOM_IMG_PATH.$thumb_res['image'];
                }
                echo <<<data
                    <div class = 'card p-3 shadow-sm rounded'>
                        <img src="$room_thumb" class="img-fluid mb-2 rounded">
                        <h5>$room_data[name]</h5>
                        <h6>$room_data[price] per night</h5>
                    </div>
                data;
            ?>
        </div>
        
        <div class="col-lg-5 col-md-12 px-4">
            <div class="card mb-4 border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <form id="booking-form">
                        <h6 class="mb-3">BOOKING DETAILS</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" id="name" name="name" value="<?php echo $user_data['name']?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone number</label>
                                <input type="number" id="phonenumber" name="phonenumber" value="<?php echo $user_data['phnumber']?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" id="address" class="form-control shadow-none" rows="1" required><?php echo $user_data['address']?></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Check in</label>
                                <input type="date" onchange="checkAvailability()" id="checkin" name="checkin" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Check out</label>
                                <input type="date" onchange="checkAvailability()" id="checkout" name="checkout" class="form-control shadow-none" required>
                                <input type="hidden" id="amt">
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="spinner-border mb-3 text-info d-none" id="info-loader" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <h6 class="mb-3 text-danger" id="pay-info">Provide check-inn & check-out date !</h6>
                                <button id="pay_now" name="pay_now" class="btn btn w-100 text-white custom-bg shadow-none mb-1" disabled>Pay Now</button>
                                <!-- <button id="pay_now" onclick="razor_pay_now()" name="pay_now" class="btn btn w-100 text-white custom-bg shadow-none mb-1" disabled>Pay Now</button> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div>

<?php include "inc/footer.php"?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="script/pay_now.js"></script>