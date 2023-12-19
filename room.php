<?php include "inc/header.php";
$checkin_default = "";
$checkout_default = "";
$adult_default = "";
$children_default = "";
if(isset($_GET['check_availbility'])){
    $frm_data = filteration($_GET);
    $checkin_default = $frm_data['checkin'];
    $checkout_default = $frm_data['checkout'];
    $adult_default = $frm_data['adult'];
    $children_default = $frm_data['children'];
}


?>
<div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">OUR ROOMS</h2>
    <div class="h-line bg-dark"></div>
    <p class="mt-3 text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla deserunt quisquam, quo saepe dolores quasi vitae eligendi laboriosam consequatur reprehenderit ut recusandae, iste blanditiis non odio, dolor cumque est aut.</p>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-md-12 mb-lg-0 mb-4  ps-4">
            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                <div class="container-fluid flex-lg-column align-items-stretch">
                    <h4 class="mt-2">FILTER</h4>
                    <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropDown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropDown">

                    <!-- check AVAILIBILITY -->
                        <div class="border bg-light p-3 rounded mb-3">
                            <h5 class="mb-2 d-flex justify-content-betweeen align-items-center" style="font-size: 18px;">
                               <span>CHECK AVAILIBILITY</span> 
                               <button class="btn text-secondary d-none shadow-none" id="chk_avail_btn" onclick="chk_avail_clear()">Reset</button>
                            </h5>
                            <label class="form-label">Check in</label>
                            <input type="date" class="form-control shadow-none mb-3" id="check-in" value="<?php echo $checkin_default?>" onchange="chk_avail_filter()">
                            <label class="form-label">Check out</label>
                            <input type="date" class="form-control shadow-none" id="check-out" value="<?php echo $checkout_default?>" onchange="chk_avail_filter()">
                        </div>

                        <!-- facilities -->
                        <div class="border bg-light p-3 rounded mb-3">
                            <h5 class="mb-2 d-flex justify-content-betweeen align-items-center" style="font-size: 18px;">
                               <span>FACILITIES</span> 
                               <button class="btn text-secondary d-none shadow-none" id="facilities_btn" onclick="facilities_clear()">Reset</button>
                            </h5>
                            <?php
                                $fcl_q = selectAll('facilities');
                                while ($row = mysqli_fetch_assoc($fcl_q)){
                                    echo <<<facilities
                                    <div class="mb-2">
                                        <input type="checkbox" name = "facilities" value = "$row[id]" class="form-check-input shadow-none mb-3 me-1" onclick = "fetch_rooms()">
                                        <label class="form-label" for="$row[id]">$row[name]</label>
                                    </div>
                                    facilities;
                                }
                            ?>
                            
                        </div>

                        <!-- guests -->
                        <div class="border bg-light p-3 rounded mb-3">
                            <h5 class="mb-2 d-flex justify-content-betweeen align-items-center" style="font-size: 18px;">
                               <span>GUESTS</span> 
                               <button class="btn text-secondary d-none shadow-none" id="guest_btn" onclick="guest_clear()">Reset</button>
                            </h5>
                            <div class="d-flex">
                                <div class="me-2">
                                    <label class="form-label">Adult</label>
                                    <input type="number" class="form-control shadow-none" id="adults" value="<?php echo $adult_default?>" oninput="guest_filter()">
                                </div>
                                <div>
                                    <label class="form-label">Childran</label>
                                    <input type="number" class="form-control shadow-none mb-3" id="childrens" value="<?php echo $children_default?>" oninput="guest_filter()">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div class="col-lg-9 col-md-12 px-4 px-0" id="room_data">
            
        </div>
    </div>
</div>
<?php include "inc/footer.php"?>
<script src="script/pay_now.js"></script>
<script src="script/rooms.js"></script>