<?php 
    include "inc/essencials.php";
    include "inc/config.php";
    session_start();
    if((isset($_SESSION['admin_login']) && $_SESSION['adminId'] ==true)){
        redirect('dashbord.php');
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Panel</title>
    <?php include "inc/links.php"?>
    <style>
        .login-form{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="login-form text-center rounded bg-white shadow overflow-hidden">
        <form method="POST">
            <h4 class="bg-dark text-white py-3">ADMNIN LOGIN PANEL</h4>
            <div class="p-4">
                <div class="mb-3">
                    <input name="admin_name" required type="text" class="form-control shadow-none text-center" placeholder="Admin Name">
                </div>
                <div class="mb-3">
                    <input name="admin_pass" required type="password" class="form-control shadow-none text-center" placeholder="password">
                </div>
                <button name="admin_login" type="submit" class="btn text-white custom-bg shadow-none">Submit</button>
            </div>
        </form>
    </div>


    <?php
        if(isset ($_POST['admin_login'])){
            // print_r($_POST);
            $frm_data = filteration($_POST);
            $query = "SELECT * FROM `admin_crud` WHERE `admin_name`=? AND `admin_pass`=?";
            $values = [$frm_data['admin_name'], $frm_data['admin_pass']];
            $res = select($query, $values , 'ss' );
            // print_r($res);
            if($res->num_rows ==1){
                $row = mysqli_fetch_assoc($res);
                $_SESSION['admin_login']=true;
                $_SESSION['adminId'] = $row['sr_no'];
                redirect('dashbord.php');
            }else{
                echo alert('error', 'login faild');

            }
        }
    ?>
    <?php include "inc/script.php"?> 
    <?php include "inc/footer.php"?> 
</body>
</html>