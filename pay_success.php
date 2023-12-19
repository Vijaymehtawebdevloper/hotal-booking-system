<?php include "inc/header.php"?>


<div class="container">
    <div class="row">
        <div class="col-12 my-5 mb-4 px-4">
            <h2 class="fw-bold"> BOOKING STATUS</h2>
            <?php
                $frm_data = filteration($_GET);

                if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)){
                    redirect('room.php');
                }
                $booking_q = "SELECT bo.*, bd.* FROM `booking_order` bo INNER JOIN `booking_details` bd ON bo.booking_id=bd.booking_id WHERE bo.order_id=? AND bo.user_id=? AND bo.booking_status!=?";
                $booking_res = select($booking_q, [$frm_data['order'], $_SESSION['uID'], 'pending'], 'sis');
                if(mysqli_num_rows($booking_res) == 0){
                    redirect('index.php');
                    // echo 'error';
                }

                $booking_fetch = mysqli_fetch_assoc($booking_res);
                if($booking_fetch['trans_status'] == 'TXN_SUCCESS'){
                    echo <<<data
                        <div class = "col-12 px-4> 
                            <p class = "fw-bold alert alert-success">
                                <i class = "bi bi-check-circle-fill"></i>
                                payment done! Booking successfull.
                                <br><br>
                                <a href = "bookings.php"> Go to bookings</a>
                            </p>
                        </div>
                    data;
                }else{
                    echo <<<data
                        <div class = "col-12 px-4> 
                            <p class = "fw-bold alert alert-danger">
                                <i class = "bi bi-check-circle-fill"></i>
                                payment failed!.
                                <br><br>
                                <a href = "bookings.php"> Go to bookings</a>
                            </p>
                        </div>
                    data;
                }
            ?>
        </div>
    </div>
</div>

<?php include "inc/footer.php"?>
