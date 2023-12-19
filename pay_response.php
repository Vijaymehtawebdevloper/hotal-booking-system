<?php
    include ('admin/inc/config.php');
    include ('admin/inc/essencials.php');


    date_default_timezone_set("Asia/Kolkata");
    session_start();
    unset($_SESSION['room']);

    function regenrate_session($uid){
        $user_q = select("SELECT * FROM user_register WHERE `id` = ? LIMIT 1", [$uid], 'i');
        $user_fetch = mysqli_fetch_assoc($user_q);
        $_SESSION['login'] = true;
        $_SESSION['uID'] = $user_fetch['id'];
        $_SESSION['uName'] = $user_fetch['name'];
        $_SESSION['uPic'] = $user_fetch['profile'];
        $_SESSION['uPhone'] = $user_fetch['phnumber'];

    }

    if(isset($_POST['payment_id'])) {
        $sel_query = "SELECT `booking_id`, `user_id` FROM booking_order WHERE order_id = '$_SESSION[orderid]'";
        $sect_res = mysqli_query($con, $sel_query);
        if(mysqli_num_rows($sect_res) == 0){
            redirect('index.php');
        }
        $slct_fetch = mysqli_fetch_assoc($sect_res);
        if(!isset($_SESSION['login']) && $_SESSION['login']==true){
            regenrate_session($slct_fetch['user_id']);
        }
        $TXN_STATUS = 'TXN_SUCCESS';
        $TRANS_MSG = 'PAYMENT_SUCCESS';

        $upd_query = "UPDATE booking_order  SET `booking_status` = 'booked', `trans_id` = '$_POST[payment_id]', `trans_amt` = '$_POST[amt]', `trans_status` = '$TXN_STATUS', `trans_res_msg` = '$TRANS_MSG' WHERE `booking_id` = '$slct_fetch[booking_id]'";
        mysqli_query($con, $upd_query);
       
        echo "pay_success.php?order=$_SESSION[orderid]";
            
    }
    else {
        echo 0;
        // redirect('index.php');
    }

?>