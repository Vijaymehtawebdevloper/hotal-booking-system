<?php

// constants backend process needs this data
define('UPLOAD_IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'].'/hotal-booking-system/images/');
define('ABOUT_FOLDER', 'about/');
define('CAROUSEL_FOLDER', 'carousel/');
define('FACILITIES_FOLDER', 'facilities/');
define('ROOM_FOLDER', 'rooms/');
define('USER_FOLDER', 'user/');

// phpmailer purpose data
define('PHPMAILER_EMAIL', 'vijaymehtasupi25@gmail.com');
define('PHPMAILER_NAME', 'HP WEBDEV');

// frontend purpose data

define('SITE_PATH', 'http://127.0.0.1/hotal-booking-system/');
define('ABOUT_IMG_PATH', SITE_PATH.'images/about/');
define('CAROUSEL_IMG_PATH', SITE_PATH.'images/carousel/');
define('FACILITIES_IMG_PATH', SITE_PATH.'images/facilities/');
define('USER_IMG_PATH', SITE_PATH.'images/user/');
define('ROOM_IMG_PATH', SITE_PATH.'images/rooms/');

function adminLogin(){
    session_start();
    if(!(isset($_SESSION['admin_login']) && $_SESSION['adminId'] ==true)){
        echo "
            <script>
                window.location.href ='index.php';
            </script>
        ";
        exit;
    }
}
function redirect($url){
    echo "
        <script>
            window.location.href ='$url';
        </script>
    ";
    exit;
}
    function alert($type, $msg){
        $bs_class = ($type =='success') ? "alert-success" : "alert-danger";
        echo <<< alert
            <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
                <strong class = "me-3">$msg</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        alert;
    }

    function upload_image($image, $folder){
        $valid_mime = ['image/jpeg', 'image/png', 'image/webp'];
        $img_mime = $image['type'];
        if(!in_array($img_mime, $valid_mime)){
            return 'inv_img'; //invalid img error
        }else if($image['size']/(1024*1024)> 2){
            return 'inv_size'; //invalid size error
        }else{
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $rname = 'IMG_'.random_int(11111, 99999).".$ext";
            $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
            if(move_uploaded_file($image['tmp_name'], $img_path)){
                return $rname;
            }else{
                return 'upd_faild';
            }
        }
    }

    function upload_SVG_image($image, $folder){
        $valid_mime = ['image/svg+xml'];
        $img_mime = $image['type'];
        if(!in_array($img_mime, $valid_mime)){
            return 'inv_img';
        }else if($image['size'] / (1024*1024) > 2){
            return 'inv_size';
        }else{
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $rname = "IMG_".random_int(11111, 99999).".$ext";
            $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
            if(move_uploaded_file($image['tmp_name'], $img_path)){
                return $rname;
            }else{
                return 'upd_faild';
            }

        }
    }

    function deleteImage($image, $folder){
        if(unlink(UPLOAD_IMAGE_PATH.$folder.$image)){
            return true;
        }else{
            return false;
        }
    }


    // function uploadUserImage($usrimg){
    //     $valid_mime = ['image/jpeg', 'image/png', 'webp'];
    //     $img_mime = $usrimg['type'];
        
    //     if(!in_array($img_mime, $valid_mime)){
    //         return 'inv_img';
    //     }else{
    //         $ext = pathinfo($usrimg['name'], PATHINFO_EXTENSION);
    //         $rname = "IMG_".random_int(11111, 99999).".jpeg";
    //         $path = UPLOAD_IMAGE_PATH.USER_FOLDER.$rname;

    //         if($ext == 'png' || $ext == 'PNG'){
    //             $img = imagecreatefrompng($usrimg['tmp_name']);

    //         }else  if($ext == 'webp' || $ext == 'WEBP'){
    //             $img = imagecreatefromwebp($usrimg['tmp_name']);

    //         }else{
    //             $img = imagecreatefromjpeg($usrimg['tmp_name']);

    //         }

    //         if(imagejpeg($img, $path, 75)){
    //             return $rname;
    //         }else{
    //             return 'upd_faild';
    //         }
            
    //     }
    // }

    

?>