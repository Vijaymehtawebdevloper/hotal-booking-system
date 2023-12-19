<?php
    include "../inc/config.php";
    include "../inc/essencials.php";
    adminLogin();


    if(isset($_POST['get_users'])){
        $data = selectAll("user_register");
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

    if(isset($_POST['user_status'])){
        $frm_data = filteration($_POST);
        $q = "UPDATE user_register SET `status` = ? WHERE `id` = ?";
        $values = [$frm_data['status'],$frm_data['id']];
        if(update($q, $values, 'ii')){
            echo 1;
        }else{
            echo 0;
        }
        // echo 'hi';
    }


    if(isset($_POST['remove_users'])){
        $frm_data = filteration($_POST);
        $q1 = del("DELETE FROM user_register WHERE `id`= ? AND is_wefired = ?", [$frm_data['user_id'], 0], 'ii');
        // deleteImage($row['profile'], USER_FOLDER);
        if($q1){
            echo 1;
        }else{
            echo 0;
        }
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