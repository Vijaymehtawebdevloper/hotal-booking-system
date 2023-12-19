<?php 
    include "inc/header.php";
?>
    <!-- carouser -->
    <div class="container-fluid">
        <div class="swiper slider-container px-lg-2 mt-2">
            <div class="swiper-wrapper">
                <?php
                    $res = selectAll('carousel');
                    while($row = mysqli_fetch_assoc($res)){
                        $path = CAROUSEL_IMG_PATH;
                        echo <<<data
                        <div class="swiper-slide">
                            <img src="$path$row[image]" class="w-100 d-block" />
                        </div>
                    data;
                    }
                ?>
            </div>
        </div>
    </div>
    <!-- check availability form -->
    <div class="container availability-form">
        <div class="row">
            <div class="col-lg-12 bg-white shadow p-4 rounded">
                <h5 class="mb-4">Check Booking Availability</h5>
                <form action="room.php">
                    <div class="row align-items-end">
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight: 5000;">Check-in</label>
                            <input type="date" class="form-control shadow-none" required name="checkin">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight: 5000;">Check-out</label>
                            <input type="date" class="form-control shadow-none" name="checkout" required>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight: 5000;">Adult</label>
                            <select class="form-select shadow-none" name="adult">
                                <?php
                                    $guest_q = mysqli_query($con, "SELECT MAX(adult) AS `max_adult`, MAX(children) AS `max_children` FROM `rooms` WHERE `status` = 1 AND `removed` = '0'");
                                    $guest_res = mysqli_fetch_assoc($guest_q);
                                    for($i = 1; $i<=$guest_res['max_adult']; $i++){
                                        echo "<option value='$i'>$i</option>";
                                    }
                                ?>
                                
                            </select>
                        </div>
                        <div class="col-lg-2 mb-3">
                            <label class="form-label" style="font-weight: 5000;">Childran</label>
                            <select class="form-select shadow-none" name="children">
                                <?php
                                    for($i = 1; $i<=$guest_res['max_children']; $i++){
                                        echo "<option value='$i'>$i</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <input type="hidden" name="check_availbility">
                        <div class="col-lg-1  mb-lg-3 mt-2">
                            <button type="submit" class="btn text-white shadow-none custom-bg">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- room cards -->
    
    <h2 class="mt-5 pt-4 text-center fw-bold h-font">OUR ROOMS</h2>
    <div class="container">
        <div class="row">
            <?php 
                $q1 = select("SELECT * FROM rooms WHERE `status` = ? AND `removed` = ? ORDER BY `id` DESC LIMIT 3", [1, 0], 'ii');
                while($row = mysqli_fetch_assoc($q1)){

                    $q2 = mysqli_query($con, "SELECT f.name FROM `fetures` f INNER JOIN `room_fetures` rfea ON f.sr_no = rfea.fetures_id WHERE rfea.room_id = '$row[id]'");

                    $feture_data = '';
                    while($fea_row = mysqli_fetch_assoc($q2)){
                        $feture_data .="<span class='badge bg-light text-dark text-wrap rounded-pill'>
                        $fea_row[name]
                        </span>";
                    }

                    $q3 =  mysqli_query($con, "SELECT f.name FROM `facilities` f INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id WHERE rfac.room_id = '$row[id]'");
                    $facilities_data = '';
                    while($fac_row = mysqli_fetch_assoc($q3)){
                        $facilities_data .="<span class='badge bg-light text-dark text-wrap rounded-pill'>
                        $fac_row[name]
                        </span>";
                    }

                    $room_thumb = ROOM_IMG_PATH.'thumbnail.jpg';
                    $thumb_q = mysqli_query($con, "SELECT * FROM room_image WHERE `room_id` = $row[id] AND `thumb` = 1");
                    if(mysqli_num_rows($thumb_q)>0){
                        $thumb_res = mysqli_fetch_assoc($thumb_q);
                        $room_thumb = ROOM_IMG_PATH.$thumb_res['image'];
                    }

                    $book_r = "";
                    if(!$settings_d['shutdown']){
                        $login = 0;
                        if(isset($_SESSION['login']) && $_SESSION['login'] == true){
                            $login = 1;
                        }
                        // $book_r = "<button onclick = 'checkLoginToBook($login, $row[id])' class='btn btn-ms text-white shadow-none custom-bg'>Book now</button>";
                        $book_r = "<a href = 'confirm_booking.php?id=$row[id]' class='btn btn-ms text-white shadow-none custom-bg'>Book now</a>";
                    }


                    $rating_q = "SELECT AVG(rating) AS `avg_rating` FROM `rating_review` WHERE room_id = $row[id] ORDER BY `sr_no` DESC LIMIT 20";
                    $rating_res = mysqli_query($con, $rating_q);

                    $rating_fetch = mysqli_fetch_assoc($rating_res);
                    $rating_data = "";

                    if($rating_fetch['avg_rating'] != null){
                        $rating_data = "<div class='Ratinnng mb-2'>
                        <h6>Ratinnng</h6>
                        <span class='badge bg-light rounded-pill'>
                            ";

                            for($i = 0; $i < $rating_fetch['avg_rating']; $i++){
                                $rating_data .= " <i class='bi bi-star-fill text-warning'></i>";
                            }

                            $rating_data .= "</span>
                                </div>
                            ";
                    }

                    echo <<<data
                        
                        <div class="col-lg-4 col-md-6 py-3">
                            <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                                <img src="$room_thumb" class="card-img-top">
                                <div class="card-body">
                                    <h6 class="card-title">$row[name]</h6>
                                    <h6 class="mb-3">$row[price] per night</h6>
                                    <h6>Fetures</h6>
                                    <div class="features mb-3">
                                        $feture_data
                                    </div>
                                    <div class="facilities mb-3">
                                        <h6>Facilities</h6>
                                        $facilities_data
                                    </div>
                                    <div class="guests mb-3">
                                        <h6>Guest</h6>
                                        <span class="badge bg-light text-dark text-wrap rounded-pill">
                                            $row[adult] Adults
                                        </span>
                                        <span class="badge bg-light text-dark text-wrap rounded-pill">
                                            $row[children] Childrens
                                        </span>
                                    </div>
                                    $rating_data
                                    <div class="d-flex justify-content-between">
                                        $book_r
                                        <a href="room_details.php?id=$row[id]" class='btn btn-ms text-white shadow-none custom-bg' ">More Option</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    data; 
                }
            ?>
            <div class="col-lg-12 text-center mt-3">
                <a href="room.php" class="btn btn-sm custom-bg shadow-none text-white ">More Rooms >>></a>
            </div>
        </div>
    </div>
<!-- OUR FACILITIES -->
    <h2 class="mt-5 pt-4 text-center fw-bold h-font">OUR FACILITIES</h2>

    <div class="container">
        <div class="row justify-content-between px-lg-0 px-md-0 px-sm-5">
            <?php
                $res = selectAll('facilities');
                $path = FACILITIES_IMG_PATH;
                while($row = mysqli_fetch_assoc($res)){
                    echo <<< data
                    <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
                        <img src="$path$row[icon]" width="80px">
                        <h5>$row[name]</h5>
                    </div>
                    data;
                }
            ?>
            
        </div>
        <div class="col-lg-12 text-center mt-3">
            <a href="facilities.php" class="btn btn-sm custom-bg shadow-none text-white ">More Facilities >>></a>
        </div>
    </div>

    <!-- testimonials -->
    <h2 class="mt-5 pt-4 text-center fw-bold h-font">TESTIMONIALS</h2>
    <div class="container">
        <div class="swiper SwiperTestimonial">
            <div class="swiper-wrapper mb-5">
                <?php
                    $q = "SELECT rr.*, ur.name AS uname, ur.profile, r.name FROM `rating_review` rr INNER JOIN `user_register` ur ON rr.user_id = ur.id INNER JOIN `rooms` r ON rr.user_id = r.id ORDER BY `sr_no` DESC";
                    $data = mysqli_query($con, $q);
                    $img_path = USER_IMG_PATH;
                    if(mysqli_num_rows($data) == 0){
                        echo "<h5 class = 'text-center'>No reviews yet!</h5>";
                    }else{
                        while($row = mysqli_fetch_assoc($data)){
                            $stars = "<i class='bi bi-star-fill text-warning'></i> ";
                            for($i = 1; $i < $row['rating']; $i++){
                                $stars .= " <i class='bi bi-star-fill text-warning'></i>";
                            }
                            echo <<<stars
                                <div class="swiper-slide bg-white p-4">
                                    <div class="profile d-flex align-items-center">
                                        <img class = 'rounded circle' src="$img_path$row[profile]" width="30px"/>
                                        <h6 class="m-0 ms-2">$row[uname]</h6>
                                    </div>
                                    <p>$row[review]</p>
                                    <div class="rating">
                                        $stars
                                    </div>
                                </div>
                            stars;
                        }
                    }
                
                ?>
                
            </div>
            <div class="swiper-pagination mt-5"></div>
        </div>
        <div class="col-lg-12 text-center mt-3">
            <a class="btn btn-sm custom-bg shadow-none fw-bold text-white ">Know More &gt;&gt;&gt;</a>
        </div>
    </div>

    <!-- Reach us -->
    <h2 class="mt-5 pt-4 text-center fw-bold h-font">REACH US</h2>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
                <iframe class="w-100" src="<?php echo $contact_d['iframe']?>" height="400"  loading="lazy"></iframe>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="bg-white p-4 mb-4 rounded">
                    <h5>Call us</h5>
                    <a href="tel:+<?php echo $contact_d['pn1']?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i>+<?php echo $contact_d['pn1']?>
                    </a>
                    <a href="tel:+<?php echo $contact_d['pn2']?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i>+<?php echo $contact_d['pn2']?>
                    </a>
                </div>
                <div class="bg-white p-4 mb-4 rounded ">
                    <h5>Follow us</h5>
                    <a href="<?php echo $contact_d['twitter']?>" class="d-block mb-2 text-decoration-none text-dark">
                        <span class="badge bg-light text-dark fd-6 p-2">
                            <i class="bi bi-twitter"></i> <?php echo $contact_d['twitter']?>
                        </span>
                    </a>
                    <a href="<?php echo $contact_d['facebook']?>" class="d-block mb-2 text-decoration-none text-dark">
                        <span class="badge bg-light text-dark fd-6 p-2">
                            <i class="bi bi-facebook"></i> <?php echo $contact_d['facebook']?>
                        </span>
                    </a>
                    <a href="<?php echo $contact_d['instagram']?>" class="d-block mb-2 text-decoration-none text-dark">
                        <span class="badge bg-light text-dark fd-6 p-2">
                            <i class="bi bi-instagram"></i> <?php echo $contact_d['instagram']?>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- password reset model -->
    <div class="modal fade" id="recoverymodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="recovery_form">
                    <div class="modal-header d-flex align-items-center">
                        <h5 class="modal-title"><i class="bi bi-shield-lock fs-3 me-2"></i> Set up new password</h5>
                        <button type="reset " class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">New password</label>
                            <input type="text" name="password" class="form-control shadow-none"required>
                            <input type="hidden" name="email">
                            <input type="hidden" name="token">
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn ext-secondary text-decoration-none shadow-none" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-outline-success shadow-none">Submit</button>
                        </div>
                    </div>
                </form>
            
            </div>
        </div>
    </div>

    <?php include "inc/footer.php"?>
    <?php
        if(isset($_GET['account_recover'])){
            $frm_data = filteration($_GET);

            $t_date = date('Y-m-d');
            $query = select("SELECT * FROM user_register WHERE `email` = ? AND `token` = ? AND `t_expire` = ? LIMIT 1", [$frm_data['email'], $frm_data['token'], $t_date], 'sss');
            if(mysqli_num_rows($query) == 0){
                echo <<<shodowModel
                    <script>
                        let myModals = document.getElementById('recoverymodal');
                        let modal = bootstrap.Modal.getOrCreateInstance(myModals);
                        myModals.querySelector("input[name = 'email']").value = '$frm_data[email]';
                        myModals.querySelector("input[name = 'token']").value = '$frm_data[token]';
                        modal.show();
                    </script>
                shodowModel;
            }else{
                alert('error', 'Invailid or Expired link');
            }
        }
    ?>

    <script>
        let recovery_form = document.getElementById("recovery_form");
        recovery_form.addEventListener('submit', function(e) {
            e.preventDefault();
            let data = new FormData();
            data.append('email', recovery_form.elements['email'].value);
            data.append('password', recovery_form.elements['password'].value);
            data.append('token', recovery_form.elements['token'].value);
            data.append('recovery_pass', '');

            let myModals = document.getElementById('recoverymodal');
            let modal = bootstrap.Modal.getInstance(myModals);
            modal.hide();

            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'ajax/login_register.php', true);
            xhr.onload = function() {
                if (this.responseText == 'failed') {
                    alert('error', 'Account reset failed');

                }else {
                    alert('success', 'Account reset successfully');
                    recovery_form.reset();
                }
                console.log(this.responseText)
            }
            xhr.send(data);
        })


        function checkLoginToBook(status, room_id){
            if(status){
                window.location.href = 'confirm_booking.php?id='+room_id;
            }else{
                alert("error", 'Please loginn to book room!')
            }
        }
    </script>