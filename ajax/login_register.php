<?php
    include "../admin/inc/config.php";
    include "../admin/inc/essencials.php";
    date_default_timezone_set('Asia/Kolkata');
    
    function send_mail($email, $token, $type){

        if($type == 'email_confirmation'){
            $page = 'email_varification.php';
            $subject = 'Account verification link';
            $content = 'Thanks for registration Click the link below to verify the email address.';
        }else{
            $page = 'index.php';
            $subject = 'Account reset link';
            $content = 'Reset your account.';
        }
        //Load Composer's autoloader
        include('../PHPMailer/smtp/PHPMailerAutoload.php');
    
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
    
        try {
            // $mail->SMTPDebug = 2;              //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'vijaymehtasupi25@gmail.com';                     //SMTP username
            $mail->Password   = 'hmrwstzxcvizbstx';                               //SMTP password
            $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
            $mail->Port       = 587;    
            $mail->CharSet = 'UTF-8';                                //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
            //Recipients
            $mail->setFrom('vijaymehtasupi25@gmail.com', 'vijay');
            $mail->addAddress($email);
    
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = "$content 
            <a href = '".SITE_PATH."$page?$type&email=$email&token=$token"."'>verify</a>";
            $mail->SMTPOptions=array('ssl'=>array(
                'verify_peer'=>false,
                'verify_peer_name'=>false,
                'allow_self_signed'=>false
            ));
    
            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    
        
    if(isset($_POST['register'])){
        $frm_data = filteration($_POST);
        if($frm_data['password'] !== $frm_data['cpassword']){
            echo 'password_missmatch';
            exit;
        }

        $u_exist = select("SELECT * FROM user_register WHERE `phnumber` = ? AND `email` = ? LIMIT 1", [$frm_data['phnumber'], $frm_data['email']], 'ss');
        if(mysqli_num_rows($u_exist) != 0){
            $u_exist_fetch = mysqli_fetch_assoc($u_exist);
            
            echo ($u_exist_fetch['email'] == $frm_data['email'] ? 'email_alredy':'phone_alredy' );
        }

        // upload user image to server
        $img = upload_image($_FILES['profile'], USER_FOLDER);
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

        // send confirmation link to user email

        $token = bin2hex(random_bytes(6));
        if(!send_mail($frm_data['email'], $token, 'email_confirmation')){
            echo 'mail_failed';
            exit;
        }

        $enc_pass = password_hash($frm_data['password'], PASSWORD_BCRYPT);

        $query = "INSERT INTO user_register (`name`, `email`, `phnumber`, `address`, `pcode`, `dob`, `profile`, `password`, `token`) VALUES (?,?,?,?,?,?,?,?,?)";
        $values = [$frm_data['name'], $frm_data['email'], $frm_data['phnumber'], $frm_data['address'], $frm_data['pcode'], $frm_data['dob'],$img, $enc_pass, $token];
        if(insert($query, $values, 'sssssssss')){
            echo 1;
        }else{
            echo 'ins_faild'; 
            exit;
        }
    }


    // login crud
    if(isset($_POST['login'])){
        $frm_data = filteration($_POST);

        $q1 = select("SELECT * FROM user_register WHERE `email` = ? OR `phnumber` = ? LIMIT 1", [$frm_data['email_mob'], $frm_data['email_mob']], 'ss');
        if(mysqli_num_rows($q1) == 0){
            echo 'inv_email_mob';
            exit;
        }else{
            $fetch = mysqli_fetch_assoc($q1);
            if($fetch['is_wefired'] == 0){
                echo 'not_verified';
                exit;
            }else if($fetch['status'] == 0){
                echo 'inactive';
            }else{
                if(!password_verify($frm_data['pass'], $fetch['password'])){
                    echo 'invailid_pass';
                    exit;
                }else{
                    session_start();
                    $_SESSION['login'] = true;
                    $_SESSION['uID'] = $fetch['id'];
                    $_SESSION['uName'] = $fetch['name'];
                    $_SESSION['uPic'] = $fetch['profile'];
                    $_SESSION['uPhone'] = $fetch['phnumber'];
                    echo 1;
                }
            }
        }
    }

    // forgot crud
    if(isset($_POST['forgot_pass'])){
        $frm_data = filteration($_POST);
        // echo $frm_data['email'];
        $q1 = select("SELECT * FROM user_register WHERE `email` = ?", [$frm_data['email']], 's');
        // $q1= "SELECT * FROM user_register WHERE 'email' = $frm_data[email]";
        // $data = mysqli_query($con, $q1);
        if(mysqli_num_rows($q1) == 0){
            echo 'inv_email';
            exit;
        }else {
            $fetch = mysqli_fetch_assoc($q1);
            // print_r ($fetch);
            if($fetch['is_wefired'] == 0){
                echo 'not_verified';
                exit;
            }else if($fetch['status'] == 0){
                echo 'inactive';
                exit;
            }else{
                $token = bin2hex(random_bytes(16));
                if(!send_mail($frm_data['email'], $token, 'account_recover')){
                    echo 'mail_failed';
                    exit;
                }else{
                    $data = date('d-m-y');
                    echo $data;
                    $query = update("UPDATE user_register SET `token` = ?, `t_expire` = ? WHERE `id` = ?", [$token, $data, $fetch['id']], 'sss');
                    if($query){
                        echo 1;
                    }else{
                        echo 'upd_failed';
                        exit;
                    }
                }
            }
        }
    }


    // recovery password
    if(isset($_POST['recovery_pass'])){
        $frm_data = filteration($_POST);
        $enc_pass = password_hash($frm_data['password'], PASSWORD_BCRYPT);

        $query = update("UPDATE user_register SET `password` = ?, `token` = ?, `t_expire` = ? WHERE `email` = ? AND `token` = ?", [$enc_pass, null, null, $frm_data['email'], $frm_data['token']], 'sssss');
        if($query){
            echo 1;
        }else{
            echo 0;
        }
    }
?>

