<?php
    include "../admin/inc/config.php";
    include "../admin/inc/essencials.php";
    date_default_timezone_set('Asia/Kolkata');

    session_start();

    if(isset($_GET['fetch_room'])){
        $chk_avail = json_decode($_GET['chk_avail'], true); 
        $guests = json_decode($_GET['guests'], true); 
        $facility_list = json_decode($_GET['facilities_list'], true); 
        // print_r($_GET['facilities_list']);

        $audults = ($guests['audults'] != "") ? $guests['audults'] : 0;
        $childrens = ($guests['childrens'] != "") ? $guests['childrens'] : 0;

        $today_date = new DateTime(date('Y-m-d'));
        $checkin_date = new DateTime($chk_avail['checkin']);
        $checkout_date = new DateTime($chk_avail['checkout']);

        // chekin and checkout filter validation
        if($chk_avail['checkin'] != "" && $chk_avail['checkout'] != ""){
            if($checkin_date == $checkout_date){
                echo "<h3 class = 'text-center text-danger'>Invailid Dates!</h3>";
                exit;
            }else if($checkin_date > $checkout_date){
                echo "<h3 class = 'text-center text-danger'>Invailid Dates!</h3>";
                exit;
            }else if($checkin_date < $today_date){
                echo "<h3 class = 'text-center text-danger'>Invailid Dates!</h3>";
                exit;
            }
        }
        
        // count no of rooms
        $count_rooms = 0;
        $output = '';

        // fetching setting table to check website is shutdown or not
        $settings_d = "SELECT * FROM `settings` WHERE `sr_no`=?";
        $values = [1];
        $settings_d = mysqli_fetch_assoc(select($settings_d, $values, 'i'));

        // query for room cards
        $q1 = select("SELECT * FROM rooms WHERE adult >= ? AND children >=? AND `status` = ? AND `removed` = ? ORDER BY `id` DESC", [$audults, $childrens,1, 0], 'iiii');

        
        while($row = mysqli_fetch_assoc($q1)){
            // check availability logic

            if($chk_avail['checkin'] != "" && $chk_avail['checkout'] != ""){
                $tb_query = "SELECT COUNT(*) AS total_booking FROM booking_order WHERE booking_status = ? AND room_id = ? AND check_out > ? AND check_in < ?";

                $values  = ['bookid', $row['id'], $chk_avail['checkin'], $chk_avail['checkout']];
                $tb_fetch = mysqli_fetch_assoc(select($tb_query, $values, 'siss'));

        
                if(($row['quantity'] - $tb_fetch['total_booking']) ==0){
                   continue;
                }
            }

            // get facilities of room

            $fac_count = 0;

            $q3 =  mysqli_query($con, "SELECT f.name, f.id FROM `facilities` f INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id WHERE rfac.room_id = '$row[id]'");
            $facilities_data = '';
            while($fac_row = mysqli_fetch_assoc($q3)){
                if(in_array($fac_row['id'], $facility_list['facilities'])){
                    $fac_count++;
                }
                $facilities_data .="<span class='badge bg-light text-dark text-wrap rounded-pill'>
                $fac_row[name]
                </span>";
            }

            if(count($facility_list['facilities']) != $fac_count){
                continue;
            }

            // get feture of room
            $q2 = mysqli_query($con, "SELECT f.name FROM `fetures` f INNER JOIN `room_fetures` rfea ON f.sr_no = rfea.fetures_id WHERE rfea.room_id = '$row[id]'");

            $feture_data = '';
            while($fea_row = mysqli_fetch_assoc($q2)){
                $feture_data .="<span class='badge bg-light text-dark text-wrap rounded-pill'>
                $fea_row[name]
                </span>";
            }

            

            // get thumbnail of image

            $room_thumb = ROOM_IMG_PATH.'thumbnail.jpg';
            $thumb_q = mysqli_query($con, "SELECT * FROM room_image WHERE `room_id` = $row[id] AND `thumb` = 1");
            if(mysqli_num_rows($thumb_q)>0){
                $thumb_res = mysqli_fetch_assoc($thumb_q);
                $room_thumb = ROOM_IMG_PATH.$thumb_res['image'];
            }
            $book_r = "";
            if(!$settings_d['shutdown']){
                $login = 0;
                if(isset($_SESSION['login']) && $_SESSION['login'] == true){
                    $login = 1;
                }
                $book_r = "<button onclick = 'checkLoginToBook($login, $row[id])' class='btn btn-sm w-100 mb-2 custom-bg shadow-none text-white '>Book Now</button>";
            }

            $output .=  "<div class='card mb-4 border-0 shadow'>
                            <div class='row g-0 p-3 align-items-center'>
                                <div class='col-md-5 mb-lg-0 mb-md-0 mb-3'>
                                    <img src='$room_thumb' class='img-fluid rounded'>
                                </div>
                                <div class='col-md-5 px-lg-3 px-md-3 px-0'>
                                    <h5 class='mb-3'>$row[name]</h5>
                                    <div class='features mb-3'>
                                        <h6>Feature</h6>
                                        $feture_data
                                        
                                    </div>
                                    <div class='facilities mb-3'>
                                        <h6>Facilities</h6>
                                        $facilities_data
                                    </div>
                                    <div class='guests mb-3'>
                                        <h6>Guests</h6>
                                        <span class='badge bg-light text-dark text-wrap rounded-pill'>
                                            $row[adult]
                                        </span>
                                        <span class='badge bg-light text-dark text-wrap rounded-pill'>
                                            $row[children]
                                        </span>
                                    </div>
                                </div>
                                <div class='col-md-2 text-align-center'>
                                    <h6 class='mb-4'>n $row[price] per night</h6>
                                    $book_r
                                    <a href = 'room_details.php?id=$row[id]' class='btn btn-sm w-100 custom-bg shadow-none text-white '>More Detail</a>
                                </div>
                            </div>
                        </div>";
  
        }
        echo $output;
    }
?>