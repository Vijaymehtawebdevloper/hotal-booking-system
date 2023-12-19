<?php
    include "../inc/config.php";
    include "../inc/essencials.php";
    adminLogin();

    if(isset($_POST['add_rooms'])){
        $frm_data = filteration($_POST);
        $facilities = filteration(json_decode($_POST['facilities']));
        // $facilities = filteration(($_POST['facilities']));
        $fetures = filteration(json_decode($_POST['fetures']));
        $flag = 0;
        // print_r($_POST);

        $q = "INSERT INTO rooms(`name`, `area`, `price`, `quantity`, `adult`, `children`, `discription`) VALUES (?,?,?,?,?,?,?)";
        $values = [$frm_data['name'],$frm_data['area'],$frm_data['price'],$frm_data['quantity'],$frm_data['adults'],$frm_data['children'],$frm_data['discription']];
        $res = insert($q, $values, 'siiiiis');


        if($res){
            $flag =1;
        }
        $room_id = mysqli_insert_id($con);
        // echo $room_id;

        $q1 = "INSERT INTO `room_facilities` (`room_id`, `facilities_id`)VALUES(?, ?)";
        if($stmt = mysqli_prepare($con, $q1)){
            foreach($facilities as $f){
                mysqli_stmt_bind_param($stmt , 'ii', $room_id, $f);
                mysqli_stmt_execute($stmt);

            }
            mysqli_stmt_close($stmt);
        }else{
            $flag = 0;
            die('Query can not be prepared - innsert');
        }


        $q2 = "INSERT INTO `room_fetures` (`room_id`, `fetures_id`)VALUES(?, ?)";
        if($stmt = mysqli_prepare($con, $q2)){
            foreach($fetures as $f){
                mysqli_stmt_bind_param($stmt , 'ii', $room_id, $f);
                mysqli_stmt_execute($stmt);

            }
            mysqli_stmt_close($stmt);
        }else{
            $flag = 0;
            die('Query can not be prepared - innsert');
        }
        if($flag){
            echo 1;
        }else{
            echo 0;
        }
    }

    if(isset($_POST['get_rooms'])){
        $data = select('SELECT * FROM rooms WHERE removed = ?', [0], 'i');
        $i = 0;
        while($res = mysqli_fetch_assoc($data)){
            $i++;
            
            if($res['status'] == 1){
                $status =   "<button type='button' onclick = 'room_status($res[id], 0)' class='btn btn-primary shadow-none btn-sm'>Active
                            </button>";
            }else{
                $status =   "<button type='button' onclick = 'room_status($res[id], 1)' class='btn btn-warning shadow-none btn-sm text-white'>Inactive
                            </button>";
            }
            
            echo <<<data
                <tr>
                    <td>$i</td>
                    <td>$res[name]</td>
                    <td>$res[area]</td>
                    <td>
                        <span>Adults : $res[adult]</span></br>
                        <span>Childrens : $res[children]</span>
                    </td>
                    <td>$res[price]</td>
                    <td>$res[quantity]</td>
                    <td>$status</td>
                    <td>
                        <button type="button" onclick = 'edit_rooms($res[id])' class="btn btn-primary shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#edit-room-s">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button type="button" onclick = "room_images($res[id], '$res[name]')" class="btn btn-info shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#room_images">
                            <i class="bi bi-images"></i>
                        </button>
                        <button type="button" onclick = "remove_room($res[id])" class="btn btn-danger shadow-none btn-sm">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            data;
        }
        // echo "hello";
        
    }

    if(isset($_POST['room_status'])){
        $q = "UPDATE rooms SET `status` = ? WHERE `id` = ?";
        $values = [$_POST['status'],$_POST['id']];
        $res = update($q, $values, 'ii');
        echo $res;
        // echo 'hi';
    }

    if(isset($_POST['room_edit'])){
        $frm_data = filteration($_POST);
        $q1 = select("SELECT * FROM rooms WHERE `id` = ?",[$frm_data['room_edit']], 'i') ;
        $q2 = select("SELECT * FROM room_fetures WHERE `room_id` = ?",[$frm_data['room_edit']], 'i') ;
        $q3 = select("SELECT * FROM room_facilities WHERE `room_id` = ?",[$frm_data['room_edit']], 'i') ;

        $room_data = mysqli_fetch_assoc($q1);
        $fetures = [];
        $facilities = [];
        if(mysqli_num_rows($q2) > 0){
            while($row = mysqli_fetch_assoc($q2)){
                array_push($fetures, $row['fetures_id']);
            }
        }

        if(mysqli_num_rows($q3) > 0){
            while($row = mysqli_fetch_assoc($q3)){
                array_push($facilities, $row['facilities_id']);
            }
        }

        $data = ['roomdata' => $room_data, 'fetures' => $fetures, 'facilities' => $facilities];
        $data = json_encode($data);
        echo $data;
        
    }

    if(isset($_POST['submit_edit_room'])){
        $frm_data = filteration($_POST);
        $facilities = filteration(json_decode($_POST['facilities']));
        $fetures = filteration(json_decode($_POST['fetures']));
        $flag = 0;

        // print_r($facilities);

        $q1 = ("UPDATE rooms SET `name` = ?, `area` = ?, `price` = ?, `quantity` = ?, `adult` = ?, `children` = ?, `discription` = ? WHERE `id` = ?");
        $values = [$frm_data['name'],$frm_data['area'],$frm_data['price'],$frm_data['quantity'],$frm_data['adults'],$frm_data['children'],$frm_data['discription'], $frm_data['room_id']];
        $res = update($q1, $values, 'siiiiisi');
        if($res){
            $flag = 0;
        }

        $q2 = del("DELETE FROM room_fetures WHERE `room_id` = ?", [$frm_data['room_id']], 'i');
        $q3 = del("DELETE FROM room_facilities WHERE `room_id` = ?", [$frm_data['room_id']], 'i');
        if($q2 && $q3){
            $flag = 1;
        }

        $q4 = "INSERT INTO room_fetures (`room_id`, `fetures_id`)VALUES (?, ?)";

        if($stmt = mysqli_prepare($con, $q4)){
            foreach($fetures as $f){
                mysqli_stmt_bind_param($stmt, 'ii', $frm_data['room_id'], $f);
                mysqli_stmt_execute($stmt);
                $flag = 1;
            }
            mysqli_stmt_close($stmt);
        }else{
            mysqli_stmt_close($stmt);
            $flag = 0;
        }

        $q5 = "INSERT INTO room_facilities (`room_id`, `facilities_id`)VALUES (?, ?)";
        if($stmt = mysqli_prepare($con, $q5)){
            foreach($facilities as $f){
                mysqli_stmt_bind_param($stmt, 'ii', $frm_data['room_id'], $f);
                mysqli_stmt_execute($stmt);
                $flag = 1;
            }
            
            mysqli_stmt_close($stmt);
            
        }else{
            mysqli_stmt_close($stmt);
            $flag = 0;
        }

        if($flag){
            echo 1;
        }else{
            echo 0;
        }

    }

    if(isset($_POST['add_image'])){
        $frm_data = filteration($_POST);
        $img = upload_image($_FILES['room_images'], ROOM_FOLDER);
        if($img == 'inv_img'){
            echo $img;
        }else if($img == 'inv_size'){
            echo $img;
        }else if($img== 'upd_faild'){
            echo $img;
        }else{
            $q1 = "INSERT INTO room_image (`room_id`, `image`) VALUES (?, ?)";
            $values = [$frm_data['room_id'], $img];
            $res = insert($q1, $values, 'is');
            echo $res;

        }
    }

    if(isset($_POST['room_images'])){
        $frm_data = filteration($_POST);
        $path = ROOM_IMG_PATH;
        $res = select("SELECT * FROM room_image WHERE `room_id`=?", [$frm_data['room_images']], 'i');
        while($row = mysqli_fetch_assoc($res)){

            if($row['thumb'] == 1){
                $thumb_btn = "<i class = 'bi bi-check-lg text-light bg-success px-2 py-1 rounded fs-5'></i>";
            }else{
                $thumb_btn = "<button type='button' onclick = 'thumb_img($row[sr_no], $row[room_id])' class='btn btn-secondary shadow-none btn-sm text-white'><i class = 'bi bi-check-lg '></i></button>";
            }
            echo <<<data
                </tr>
                    <td><img src="$path$row[image]" class = "form-controll img-fluid" alt=""></td>
                    <td>$thumb_btn</td>
                    <td>
                        <button type='button' onclick = 'rem_img($row[sr_no], $row[room_id])' class='btn btn-danger shadow-none btn-sm text-white'><i class = 'bi bi-trash'></i>
                        </button>
                    </td>
                <tr>
            data;
        }

    }

    if(isset($_POST['rem_image'])){
        $frm_data = filteration($_POST);
        $q1 = select("SELECT * FROM room_image WHERE `room_id`= ? AND `sr_no` = ?", [$frm_data['room_id'], $frm_data['img_id']], 'ii');

        $img = mysqli_fetch_assoc($q1);
        if(deleteImage($img['image'], ROOM_FOLDER)){
            $res = del("DELETE FROM room_image WHERE `room_id`= ? AND `sr_no` = ?", [$frm_data['room_id'], $frm_data['img_id']], 'ii');
            echo 1;
        }else{
            echo 0;
        }

    }

    if(isset($_POST['thumb_img'])){
        $frm_data = filteration($_POST);
        $q1 = "UPDATE room_image SET `thumb` = ? WHERE `room_id` = ?";
        $values = [0, $frm_data['room_id']];
        $res_pre = update($q1,$values, 'ii');

        $q2 = "UPDATE room_image SET `thumb` = ? WHERE `room_id` = ? AND `sr_no` = ?";
        $values = [1, $frm_data['room_id'], $frm_data['img_id']];
        $res = update($q2,$values, 'iii');
        echo $res;


    }

    if(isset($_POST['remove_room'])){
        $frm_data = filteration($_POST);
        $q1 = select("SELECT * FROM room_image WHERE `room_id`= ?", [$frm_data['room_id']], 'i');

        while($row = mysqli_fetch_assoc($q1)){
            deleteImage($row['image'], ROOM_FOLDER);
        }

        $q2 = del("DELETE FROM room_image WHERE `room_id`= ?", [$frm_data['room_id']], 'i');
        $q3 = del("DELETE FROM room_fetures WHERE `room_id`= ?", [$frm_data['room_id']], 'i');
        $q4 = del("DELETE FROM room_facilities WHERE `room_id`= ?", [$frm_data['room_id']], 'i');
        $q5 = update("UPDATE rooms SET `removed` = ? WHERE `id` = ?",[1, $frm_data['room_id']], 'ii' );

        if($q2 || $q3 || $q4 || $q5 ){
            echo 1;
        }else{
            echo 0;
        }


    }



?>