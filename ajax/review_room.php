<?php
    include "../admin/inc/config.php";
    include "../admin/inc/essencials.php";
    date_default_timezone_set('Asia/Kolkata');

    session_start();

    if(!isset($_SESSION['login']) && $_SESSION['login'] == true){
        redirect('rooms.php');
    }

    if(isset($_POST['review_form'])){
        $frm_data = filteration($_POST);
        // print_r($_POST);

        $query = "UPDATE `booking_order` SET `rate_review` = ? WHERE `booking_id` = ? AND `user_id` = ?";
        $result = update($query, ['1', $frm_data['booking_id'], $_SESSION['uID']], 'iii');

        $ins_query = "INSERT INTO `rating_review`(`booking_id`, `room_id`, `user_id`, `rating`, `review`) VALUES (?, ?, ?, ?, ?)";
        $ins_value = [$frm_data['booking_id'], $frm_data['room_id'], $_SESSION['uID'], $frm_data['rating'], $frm_data['review']];
        $ins_result = insert($ins_query, $ins_value, 'iiiis');
        

        echo $ins_result;
        // echo 'valkd';
    }
?>