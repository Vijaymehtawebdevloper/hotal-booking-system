<?php
    include "../inc/config.php";
    include "../inc/essencials.php";
    adminLogin();

    // get genrel setting
    if(isset($_POST['get_genral'])){
        $q = "SELECT * FROM `settings` WHERE `sr_no`=? ";
        $values = [1];
        $res = select($q, $values, "i");
        $data = mysqli_fetch_assoc($res);
        $json_data = json_encode($data);
        echo $json_data;
    }

    // update genrel setting
    if(isset($_POST['upd_genrel'])){
        $frm_data = filteration($_POST);
        $q= "UPDATE `settings` SET `site_title`=?, `site_about`=? WHERE `sr_no` = ?";
        $values = [$frm_data['site_title'], $frm_data['site_about'], 1];
        $res = update($q, $values, 'ssi');
        echo $res;
    }

    // update shutdown
    if(isset($_POST['upd_shutdown'])){
        $frm_data = ($_POST['upd_shutdown'] == 0) ? 1 : 0;
        $q= "UPDATE `settings` SET `shutdown`=? WHERE `sr_no` = ?";
        $values = [$frm_data, 1];
        $res = update($q, $values, 'ii');
        echo $res;
    }

    // get contact detail

    if(isset($_POST['get_contacts'])){
        $q = "SELECT * FROM `contact_details` WHERE `sr_no`=? ";
        $values = [1];
        $res = select($q, $values, "i");
        $data = mysqli_fetch_assoc($res);
        $json_data = json_encode($data);
        echo $json_data;
    }

    // update contact detail
    if(isset($_POST['upd_contacts'])){
        $frm_data = filteration($_POST);
        $q = "UPDATE `contact_details` SET `address`=?,`gmap`=?,`pn1`=?,`pn2`=?,`email`=?,`facebook`=?,`instagram`=?,`twitter`=?,`iframe`=? WHERE `sr_no`=?";
        $values = [$frm_data['address'], $frm_data['gmap'], $frm_data['pn1'],$frm_data['pn2'],$frm_data['email'],$frm_data['facebook'],$frm_data['instagram'],$frm_data['twitter'],$frm_data['iframe'],1];
        $res = update($q, $values, 'sssssssssi');
        echo $res;
    }

    if(isset($_POST['add_member'])){
        $frm_data = filteration($_POST);
        $img_r = upload_image($_FILES['picture'],ABOUT_FOLDER);
        if($img_r == 'inv_img'){
            echo $img_r;

        }else if($img_r == 'inv_size'){
            echo $img_r;

        }else if($img_r == 'upd_faild'){
            echo $img_r;

        }else{
            $q = 'INSERT INTO `team_detail` (`name`, `picture`) VALUES  (?, ?)';
            $values = [$frm_data['name'], $img_r];
            $res = insert($q, $values, 'ss');
            echo $res;
        }


        // echo "vijay";
    }

    if(isset($_POST['get_members'])){
        $res = selectAll('team_detail');
        $path = ABOUT_IMG_PATH;
        while($row = mysqli_fetch_assoc($res)){
            echo <<<data
                <div class="col-md-2 mb-3">
                    <div class="card bg-dark text-white">
                        <img src="$path$row[picture]" class="card-img" alt="...">
                        <div class="card-img-overlay text-end">
                            <button type="button" onclick = "rem_member($row[sr_no])" class="btn btn-danger btn-sm shadow-none ">
                            <i class="bi bi-trash"></i>Delete</button>
                        </div>
                        <p class="card-text">$row[name]</p>
                    </div>
                </div>
            data;
        }

    // echo "vijay";
    }

    if(isset($_POST['rem_member'])){
        // echo 'hello';
        $frm_data = filteration($_POST);
        $values = [$frm_data['rem_member']];
        $pre_q = "SELECT * FROM `team_detail` WHERE `sr_no`=?";
        $res = select($pre_q, $values, 'i');
        $img = mysqli_fetch_assoc($res);
        
        if(deleteImage($img['picture'], ABOUT_FOLDER)){
            $q1 = "DELETE FROM `team_detail` WHERE `sr_no`=?"; 
            $res = del($q1, $values, 'i');
            echo 1;
        }else{
            echo 0;
        }
        // echo 1;
    }
?>