<?php
    include "../admin/inc/config.php";
    include "../admin/inc/essencials.php";
    date_default_timezone_set('Asia/Kolkata');
    
     
    if(isset($_POST['info_form'])){
        $frm_data = filteration($_POST);
        session_start();

        $u_exist = select("SELECT * FROM `user_register` WHERE `phnumber` = ? AND `id` != ? LIMIT 1", [$frm_data['phnumber'], $_SESSION['uID']], 'ss');
        if(mysqli_num_rows($u_exist) != 0){
            $u_exist_fetch = mysqli_fetch_assoc($u_exist);
            
            if ($u_exist_fetch['email'] == $frm_data['email'] ){
                echo 'phone_alredy';
                exit;
            }
        }

        $query = "UPDATE `user_register` SET `name` = ?, `address` = ?, `phnumber` = ?, `pcode` = ?, `dob` = ? WHERE `id` = ? LIMIT 1";
        $values = [$frm_data['name'], $frm_data['address'], $frm_data['phoneNumber'], $frm_data['pincode'], $frm_data['dob'], $_SESSION['uID']];

        $res = update($query, $values, 'ssssss');

        if($res){
            $_SESSION['uName'] = $frm_data['name'];
            echo 1;
        }else{
            echo 0;
        }

    }

    if(isset($_POST['profile_form'])){
        $frm_data = filteration($_POST);
        session_start();

        // upload user image to server

        $img = upload_image($_FILES['picture'], USER_FOLDER);

        if($img == 'inv_img'){
            echo 'inv_img';
            exit;
        }else if($img == 'inv_size'){
            echo 'inv_size';
            exit;
        }else if($img == 'upd_faild'){
            echo 'upd_faild';
            exit;
        }

        $u_exist = select("SELECT * FROM `user_register` WHERE `id` = ? LIMIT 1", [$_SESSION['uID']], 's');

        $u_exist_fetch = mysqli_fetch_assoc($u_exist);
        deleteImage($u_exist_fetch['profile'], USER_FOLDER);

        $query = "UPDATE `user_register` SET `profile` = ? WHERE `id` = ? LIMIT 1";
        $values = [$img, $_SESSION['uID']];

        $res = update($query, $values, 'ss');

        if($res){
            $_SESSION['uPic'] = $img;
            echo 1;
        }else{
            echo 0;
        }

    }

    if(isset($_POST['password_form'])){
        $frm_data = filteration($_POST);
        session_start();

        if($frm_data['new_password'] != $frm_data['Confirm_password']){
            echo 'missmatch';
            exit;
        }

        $enc_pass = password_hash($frm_data['new_password'], PASSWORD_BCRYPT);

        $query = update("UPDATE `user_register` SET `password` = ? WHERE `id` = ? LIMIT 1", [$enc_pass, $_SESSION['uID']], 'ss');

        if($query){
            echo 1;
        }else{
            echo 0;
        }
    }
?>

