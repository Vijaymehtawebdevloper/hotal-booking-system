<?php
    include "../inc/config.php";
    include "../inc/essencials.php";
    adminLogin();
if(isset($_POST['add_feture'])){
    $frm_data = filteration($_POST);

    $q = 'INSERT INTO `fetures` (`name`) VALUES (?)';
    $values = [$frm_data['name']];
    $res = insert($q, $values, 's');
    echo $res;
}

if(isset($_POST['get_feture'])){
    $res = selectAll('fetures');
    $i = 0;
    while($row = mysqli_fetch_assoc($res)){
        $i++;
        echo <<<data
            <tr>
                <td>$i</td>
                <td>$row[name]</td>
                <td>
                    <button type="button" onclick = "rem_feture($row[sr_no])" class="btn btn-danger btn-sm shadow-none ">Delete</button>
                </td>
            </tr>
        data;
    }
}

if(isset($_POST['rem_feture'])){
    // echo 'hello';
    $frm_data = filteration($_POST);
    $values = [$frm_data['rem_feture']];

    $chek_del = select("SELECT * FROM room_fetures WHERE `fetures_id` = ?", $values, 'i');
    if(mysqli_num_rows($chek_del)==0){
        $q1 = "DELETE FROM `fetures` WHERE `sr_no`=?"; 
        $res = del($q1, $values, 'i');
        echo 1;

    }
    
    // echo 1;
}

if(isset($_POST['add_facilities'])){
    $frm_data = filteration($_POST);
    $img_r = upload_SVG_image($_FILES['icon'], FACILITIES_FOLDER);
    if($img_r == 'inv_img'){
        echo $img_r;
    }else if($img_r == 'inv_size'){
        echo $img_r;
    }else if($img_r == 'upd_faild'){
        echo $img_r;
    }else{
        $q = "INSERT INTO facilities (`name`, `icon`, `discription`) VALUES  (?, ?, ?)";
        $values = [$_POST['name'], $img_r, $_POST['discription']];
        $res = insert($q, $values, 'sss');
        echo $res;
    }
}

if(isset($_POST['get_facilities'])){
    $q = selectAll("facilities");
    $path = FACILITIES_IMG_PATH;
    $i= 0;
    while($row = mysqli_fetch_assoc($q)){
        $i++;
        echo <<< data
            <tr>
                <td>$i</td>
                <td><img src="$path$row[icon]" class="img-fluid" width = '100px'; alt="..."></td>
                <td>$row[name]</td>
                <td>$row[discription]</td>
                <td>
                    <button type="button" onclick = "rem_facilities($row[id])" class="btn btn-danger btn-sm shadow-none ">Delete</button>
                </td>
            </tr>
        data;
    }
}

if(isset($_POST['rem_facilities'])){
    $frm_data = filteration($_POST);
    $values = [$frm_data['rem_facilities']];
    
    $chek_query = select("SELECT * FROM room_facilities WHERE facilities_id = ?", $values, 'i');
    if(mysqli_num_rows($chek_query)==0){
        $pre_q = "SELECT * FROM `facilities` WHERE `id`=?";
        $res = select($pre_q, $values, 'i');
        $img = mysqli_fetch_assoc($res);
        if(deleteImage($img['icon'], FACILITIES_FOLDER)){
            $q1 = "DELETE FROM `facilities` WHERE `id`=?"; 
            $res = del($q1, $values, 'i');
            echo 1;
        }else{
            echo 0;
        }

    }
    
}
?>