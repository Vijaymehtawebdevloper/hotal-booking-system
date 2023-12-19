<?php
    include "../inc/config.php";
    include "../inc/essencials.php";
    adminLogin();


    if(isset($_POST['get_bookings'])){
        $frm_data = filteration($_POST);
        $query = "SELECT bo.*, bd.* FROM `booking_order` bo INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id WHERE (bo.order_id LIKE ? OR bd.phonenumber LIKE ? OR bd.user_name LIKE ?) AND (bo.booking_status = ? AND bo.refund = ?) ORDER BY bo.booking_id ASC";  
        $res = select($query, ["%$frm_data[search]%", "%$frm_data[search]%","%$frm_data[search]%","cancel", 0], 'ssssi');
        $i = 1;
        $table_data = "";

        if(mysqli_num_rows($res) == 0){
            echo 'No data found';
            exit;
        }

        while($data = mysqli_fetch_assoc($res)){
            $date = date("d-m-Y", strtotime($data['datetime']));
            $checkin = date("d-m-Y", strtotime($data['check_in']));
            $checkout = date("d-m-Y", strtotime($data['check_out']));

            $table_data .= "
                <tr>
                    <td>$i</td>
                    <td>
                        <span class = 'badge bg-primary'>
                            Order ID: $data[order_id]
                        </span><br>
                        <b>Name : </b> $data[user_name]
                        <br>
                        <b>Phone number : </b> $data[phonenumber]
                        
                    </td>
                    <td>
                    <b>Room : </b> $data[room_name]
                        <br>
                        <b>Check-in : </b> $checkin
                        <br>
                        <b>Check-out : </b> $checkout
                        <br>
                        <b>Date : </b> $date
                    </td>
                    <td>
                        <b></b> $data[trans_amt]
                    </td>
                    <td>
                        <button onclick = 'refund_booking($data[booking_id])' class='btn btn-sm shadow-none btn-success type = 'button'>
                        <i class='bi bi-cash-stack'></i> Cancel booking
                    </button>
                    </td>
                </tr>
            ";
            $i++;
        }

        echo $table_data;
    }



    if(isset($_POST['refund_booking'])){
        $frm_data = filteration($_POST);
        $q1 = "UPDATE `booking_order` SET refund = ? WHERE booking_id = ?";
        $value = [1, $frm_data['booking_id']];
        $res = update($q1, $value, 'ii');

        echo $res;
    }

    if(isset($_POST['search_users'])){
        $frm_data = filteration($_POST);
        $data = select("SELECT * FROM user_register WHERE `name` LIKE ?", ["%$frm_data[user_name]%"], 'i');
        $i = 0;
        while($res = mysqli_fetch_assoc($data)){
            $i++;
            $path = USER_IMG_PATH;
            $verified = "<span class = 'badge bg-warning '><i class='bi bi-x-lg'></i></span>";
            if($res['is_wefired']){
                $verified = "<span class = 'badge bg-success '><i class='bi bi-check-lg'></i></span>";
                $del_btn = '';
            }

            $status = "<button type='button' onclick = 'user_status($res[id], 0)' class='btn btn-info shadow-none btn-sm text-white'>Active</button>";

            if(!$res['status']){
                $status = "<button type='button' onclick = 'user_status($res[id], 1)' class='btn btn-warning shadow-none btn-sm text-white'>Inactive</button>";
            }

            $date = date('m-d-Y', strtotime($res['datetime']));

            $del_btn  = "<button type='button' onclick = 'remove_users($res[id])' class='btn btn-danger shadow-none btn-sm'>
                            <i class='bi bi-trash'></i>
                        </button>";
            echo <<<data
                <tr>
                    <td>$i</td>
                    <td>
                        <img src = '$path$res[profile]' width = '55px'><br>
                        $res[name]
                    </td>
                    <td>$res[email]</td>
                    <td>$res[phnumber]</td>
                    <td>$res[address]</td>
                    <td>$res[dob]</td>
                    <td>$verified</td>
                    <td>$status</td>
                    <td>$date</td>
                    <td>$del_btn</td>
                </tr>
            data;
        }
        // echo "hello";
        
    }

?>