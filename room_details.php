<?php include "inc/header.php"?>

<?php
    if(!isset($_GET['id'])){
        redirect('rooms.php');
    }

    $frm_data = filteration($_GET);

    $room_res = select("SELECT * FROM rooms WHERE `id` = ? AND `status` = ? AND `removed` = ?", [$frm_data['id'], 1, 0], 'iii');
    if(mysqli_num_rows($room_res)==0){
        redirect('rooms.php');
    }
    $room_data = mysqli_fetch_assoc($room_res);

?>

<div class="container">
    <div class="row">
        <div class="col-12 my-5 mb-4 px-4">
            <h2 class="fw-bold"><?php echo $room_data['name']?></h2>
            <div style="font-size: 14px;">
                <a href="index.php" class="text-secondary">Home</a>
                <span class="text-secondary"> > </span>
                <a href="rooms.php" class="text-secondary">Rooms</a>
            </div>
        </div>
        <div class="col-lg-7 col-md-12 px-4">
            <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">

                    <?php
                        $room_img = ROOM_IMG_PATH.'thumbnail.jpg';
                        $img_q = mysqli_query($con, "SELECT * FROM room_image WHERE `room_id` = '$room_data[id]'");
                        if(mysqli_num_rows($img_q)>0){
                            $active_class = 'active';
                            while($img_res = mysqli_fetch_assoc($img_q)){
                                echo    "<div class='carousel-item $active_class'>
                                            <img src='".ROOM_IMG_PATH.$img_res['image']."' class='d-block w-100 rounded'>
                                        </div>";
                                $active_class = '';
                            }
                            
                            
                        }else{
                            echo    "<div class='carousel-item active'>
                                        <img src='$room_img' class='d-block w-100' alt='...'>
                                    </div>";
                        }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        
        <div class="col-lg-5 col-md-12 px-4">
            <div class="card mb-4 border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <?php
                        echo <<< price
                            <h6>n $room_data[price] per night</h6>
                        price;

                        $q = "SELECT rr.*, ur.name AS uname, ur.profile, r.name FROM `rating_review` rr INNER JOIN `user_register` ur ON rr.user_id = ur.id INNER JOIN `rooms` r ON rr.user_id = r.id WHERE rr.room_id = '$room_data[id]' ORDER BY `sr_no` DESC";
                        $data = mysqli_query($con, $q);
                        $img_path = USER_IMG_PATH;
                        if(mysqli_num_rows($data) == 0){
                            echo 'No reviews yet!';
                        }else{
                            while($row = mysqli_fetch_assoc($data)){
                                $stars = "<i class='bi bi-star-fill text-warning'></i> ";
                                for($i = 1; $i < $row['rating']; $i++){
                                    $stars .= " <i class='bi bi-star-fill text-warning'></i>";
                                }
                                echo <<< rating
                                    <div class="rating mt-2 mb-3">
                                        $stars
                                    </div>
                                rating;
                            }
                        }

                        

                        $q2 = mysqli_query($con, "SELECT f.name FROM `fetures` f INNER JOIN `room_fetures` rfea ON f.sr_no = rfea.fetures_id WHERE rfea.room_id = '$room_data[id]'");

                        $feture_data = '';
                        while($fea_row = mysqli_fetch_assoc($q2)){
                            $feture_data .="<span class='badge bg-light text-dark text-wrap'>
                            $fea_row[name]
                            </span>";
                        }

                        echo <<<fetures
                            <div class=" mb-4">
                                <h6>Feature</h6>
                                $feture_data
                            </div>
                        fetures;

                        $q3 =  mysqli_query($con, "SELECT f.name FROM `facilities` f INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id WHERE rfac.room_id = '$room_data[id]'");
                        $facilities_data = '';
                        while($fea_row = mysqli_fetch_assoc($q3)){
                            $facilities_data .="<span class='badge bg-light text-dark text-wrap rounded-pill'>
                            $fea_row[name]
                            </span>";
                        }

                        $book_r = "";
                        if(!$settings_d['shutdown']){
                            $login = 0;
                            if(isset($_SESSION['login']) && $_SESSION['login'] == true){
                                $login = 1;
                            }
                            $book_r = "<button onclick = 'checkLoginToBook($login, $room_data[id])' href = '' class='btn w-100 custom-bg shadow-none text-white '>Book Now</button>";
                        }
                        echo <<<facilities
                            <div mb-4">
                                <h6>Facilities</h6>
                                $facilities_data
                            </div>
                        facilities;

                        echo <<<guests
                            <div class="guests mb-3">
                                <h6>Guests</h6>
                                <span class="badge bg-light text-dark text-wrap rounded-pill">
                                    $room_data[adult] Adulted
                                </span>
                                <span class="badge bg-light text-dark text-wrap rounded-pill">
                                    $room_data[children] Children
                                </span>
                            </div>
                        guests;

                        echo <<<area
                            <div class=" mb-3">
                                <h6>Area</h6>
                                <span class="badge bg-light text-dark text-wrap rounded-pill">
                                $room_data[area] sq .ft
                                </span>
                                
                            </div>
                        area;

                        echo <<<book
                            $book_r
                        book;

                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-12 px-4">
            <div class="mb-4">
                <h5>Description</h5>
                <p>
                    <?php echo $room_data['discription']?>
                </p>
            </div>
            <div class="mb-3">
                <h5 class="mb-3">Review & Rating</h5>
                <?php
                    $q = "SELECT rr.*, ur.name AS uname, ur.profile, r.name FROM `rating_review` rr INNER JOIN `user_register` ur ON rr.user_id = ur.id INNER JOIN `rooms` r ON rr.user_id = r.id WHERE rr.room_id = '$room_data[id]' ORDER BY `sr_no` DESC";
                    $data = mysqli_query($con, $q);
                    $img_path = USER_IMG_PATH;
                    if(mysqli_num_rows($data) == 0){
                        echo 'No reviews yet!';
                    }else{
                        while($row = mysqli_fetch_assoc($data)){
                            $stars = "<i class='bi bi-star-fill text-warning'></i> ";
                            for($i = 1; $i < $row['rating']; $i++){
                                $stars .= " <i class='bi bi-star-fill text-warning'></i>";
                            }
                            echo <<<review
                                <div>
                                    <div class=" d-flex align-items-center">
                                        <img src="$img_path$row[profile]" width="30px"/>
                                        <h6 class="m-0 ms-2">$row[uname]</h6>
                                    </div>
                                    <p>$row[review]</p>
                                    <div class="rating">
                                        $stars
                                    </div>
                                </div>
                            review;
                        }
                    }
                    ?>
                <div>
            </div>
        </div>
    </div>
</div>

<?php include "inc/footer.php"?>
<script src="script/pay_now.js"></script>
<script>
    function checkLoginToBook(status, room_id){
        if(status){
            window.location.href = 'confirm_booking.php?id='+room_id;
        }else{
            alert("error", 'Please loginn to book room!')
        }
    }
</script>