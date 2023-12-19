<?php


    include ('admin/inc/config.php');
    include ('admin/inc/essencials.php');

    date_default_timezone_set("Asia/Kolkata");

    session_start();
    if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)){
        redirect('index.php');
    }

    if(isset($_POST['pay_now'])){


        // $checkSum = "";
        // $paramList = array();

        $ORDER_ID = 'ORD_'.$_SESSION['uID'].random_int(11111, 999999);
        $CUST_ID = $_SESSION['uID'];
        $TXN_AMOUNT = $_SESSION['room']['payment'];
        $_SESSION['orderid'] = $ORDER_ID;

        // insert payment-data into dabase
        $frm_data = filteration($_POST);
        $q1 = "INSERT INTO `booking_order`( `user_id`, `room_id`, `check_in`, `check_out`, `order_id`) VALUES (?,?,?,?,?)";
        insert($q1,[$CUST_ID, $_SESSION['room']['id'], $frm_data['checkin'], $frm_data['checkout'], $ORDER_ID],  'issss');

        $booking_id = mysqli_insert_id($con);

        $q2 = "INSERT INTO `booking_details`( `booking_id`, `room_name`, `price`, `total_pay`,`user_name`, `phonenumber`, `address`) VALUES (?,?,?,?,?,?,?)";
        insert($q2, [$booking_id, $_SESSION['room']['name'], $_SESSION['room']['price'],$TXN_AMOUNT, $frm_data['name'], $frm_data['phonenumber'], $frm_data['address']], 'issssss');
        
    }
?>
