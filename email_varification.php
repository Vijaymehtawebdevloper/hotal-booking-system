<?php
    include "admin/inc/config.php";
    include "admin/inc/essencials.php";

    if(isset($_GET['email_confirmation'])){
        $frm_data = filteration($_GET);

        $query = select("SELECT * FROM user_register WHERE `email` = ? AND `token` = ? LIMIT 1", [$frm_data['email'], $frm_data['token']], 'ss');
        if(mysqli_num_rows($query) == 1){
            $fetch = mysqli_fetch_assoc($query);
            if($fetch['is_wefired'] == 1){
                echo "<script>alert('Email already verified')</script>";
                
            }else{
                $update = update("UPDATE user_register SET `is_wefired` = ? WHERE `id` =?", [1,$fetch['id']], 'ii');
                if($update){
                    echo "<script>alert('Emial verification successfully')</script>";
                }else{
                    echo "<script>alert('Emial verification faild! server down')</script>";
                }
            }
            redirect('index.php');
        }else{
            echo "<script>alert('Invailid Link')</script>";
            redirect('index.php');
        }
    }
?>

