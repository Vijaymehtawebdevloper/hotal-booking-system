<?php
    include "../admin/inc/config.php";
    include "../admin/inc/essencials.php";
    date_default_timezone_set('Asia/Kolkata');

    session_start();

    if(!isset($_SESSION['login']) && $_SESSION['login'] == true){
        redirect('rooms.php');
    }
    

    if(isset($_POST['cancel_booking'])){
        $frm_data = filteration($_POST);
        // print_r($_POST);

        $query = "UPDATE `booking_order` SET `booking_status` = ?, `refund` = ? WHERE `booking_id` = ? AND `user_id` = ?";
        $result = update($query, ['cancel', 0, $frm_data['id'], $_SESSION['uID']], 'siii');

        echo $result;

    }
?>