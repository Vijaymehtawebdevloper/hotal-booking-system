<?php
    include "../inc/config.php";
    include "../inc/essencials.php";
    adminLogin();

    if(isset($_GET['seen'])){
        $frm_data = filteration($_GET);
        if($frm_data['seen'] == 'all'){
            $q = "UPDATE `user_queries` SET `seen`=?";
            $values = [1,];
            if(update($q, $values, 'i')){
                alert('success', 'Mark all as read');
            }else{
                alert('error', 'Opration faild');
            }
        }else{
            $q = "UPDATE `user_queries` SET `seen`=?   WHERE `sr_no`=?";
            $values = [1, $frm_data['seen']];
            if(update($q, $values, 'ii')){
                alert('success', 'Mark as read');
            }else{
                alert('error', 'Opration faild');
            }
        }
    }
    if(isset($_GET['del'])){
        $frm_data = filteration($_GET);
        if($frm_data['del'] == 'all'){
            $q = "DELETE FROM `user_queries`";
            if(mysqli_query($con, $q)){
                alert('success', 'Data Deleted');
            }else{
                alert('error', 'Opration faild');
            }
        }else{
            $q = "DELETE FROM `user_queries` WHERE `sr_no`=?";
            $values = [$frm_data['del']];
            if(del($q, $values, 'i')){
                alert('success', 'Data Deleted');
            }else{
                alert('error', 'Opration faild');
            }
        }
    }
?>