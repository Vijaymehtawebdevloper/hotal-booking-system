<?php include "inc/header.php"?>

<?php

/*
    check room id frim url is present or not
    shutdown mode is active or not
    user is logged in or not
*/ 
    if(!isset($_SESSION['login']) && $_SESSION['login'] == true){
        redirect('index.php');
    }

?>

<div class="container">
    <div class="row">
        <div class="col-12 my-5 mb-4 px-4">
            <h2 class="fw-bold"> BOOKINGS </h2>
            <div style="font-size: 14px;">
                <a href="index.php" class="text-secondary">Home</a>
                <span class="text-secondary"> > </span>
                <a href="#" class="text-secondary">Bookings</a>
            </div>
        </div>
        <?php
            $query = "SELECT bo.*, bd.* FROM `booking_order` bo INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id WHERE ((bo.booking_status = 'booked') OR (bo.booking_status = 'cancel') OR (bo.booking_status = 'payment failed')) AND (bo.user_id = ?)  ORDER BY bo.booking_id DESC";  
            $res = select($query, [$_SESSION['uID']], 'i');

            while($data = mysqli_fetch_assoc($res)){
                $date = date("d-m-Y", strtotime($data['datetime']));
                $checkin = date("d-m-Y", strtotime($data['check_in']));
                $checkout = date("d-m-Y", strtotime($data['check_out']));

                $status_bg = '';
                $btn = '';

                if($data['booking_status'] == 'booked'){
                    $status_bg = 'bg-success';

                    if($data['arivel'] == 1){
                        $btn = "<a href = 'genrate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-success btn-sm  shadow-none'>Download PDF</a>";

                        if($data['rate_review'] == 0){
                            $btn .= "<button onclick = 'review_room($data[booking_id], $data[room_id])' class='btn btn-sm  shadow-none btn-primary ms-2' type = 'button' data-bs-toggle = 'modal' data-bs-target = '#rate-review-modal'>Rate & Review</button>";
                        }
                    }else{
                        $btn = "<button onclick = 'cancel_booking($data[booking_id])' class='btn btn-sm  shadow-none btn-danger' type = 'button'>Cancel</button>";
                    }
                }else if($data['booking_status'] == 'cancel'){
                    $status_bg = 'bg-danger';
                    if($data['refund'] == 0){
                        $btn = "<span class = 'badge bg-primary'>Refund in process!</span>";
                    }else{
                        $btn = "<a href = 'genrate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-sm btn-success shadow-none'>Download PDF</a>";
                    }
                }else{
                    $status_bg = 'bg-warning';
                    $btn = "<a href = 'genrate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-sm btn-success  shadow-none'>Download PDF</a>";
                }

                echo <<<bookings
                        <div class = 'col-md-4 px-4 mb-4'>
                            <div class = 'bg-white p-3 rounded shadow-sm'>
                                <h5 class = 'fw-bbold'>$data[room_name]</h5>
                                <p>$data[price] Per night</p>
                                <p>
                                    <b>Check in :</b> $checkin<br>
                                    <b>Check out :</b> $checkout<br>
                                </p>
                                <p>
                                    <b>Amount :</b> $data[price]<br>
                                    <b>Check out :</b> $data[order_id]<br>
                                    <b>Check out :</b> $date
                                </p>
                                <p>
                                    <span class = 'badge $status_bg'>$data[booking_status]</span>
                                </p>
                                $btn
                            </div>
                        </div>
                    bookings;
            }
        ?>
    </div>
</div>


<!-- login mnodel -->
<div class="modal fade" id="rate-review-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="review_form">
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title"><i class="bi bi-chat-square-heart ms-3 me-2"></i> Rate & Review</h5>
                    <button type="reset " class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                            <select class="form-select shadow-none" name = "rating">
                                <option value="5" >Excelent</option>
                                <option value="4">Good</option>
                                <option value="3">Ok</option>
                                <option value="2">Poor</option>
                                <option value="1">Bad</option>
                            </select>
                       </div>
                    <div class="mb-3">
                        <label class="form-label">Review</label>
                        <textarea type="text" name="review" class="form-control shadow-none" rows="3" placeholder="Review"></textarea>
                    </div>
                    <input type="hidden" name="booking_id">
                    <input type="hidden" name="room_id">
                    <div class="text-end">
                        <button type="submit" class="btn btn-outline-success shadow-none">Submit</button>
                    </div>
                </div>
            </form>
        
        </div>
    </div>
</div>

<?php
    if(isset($_GET['cancel_status'] )){
        alert('success', 'Booking canceled!');
        // print_r($_GET);
    }

    if(isset($_GET['review_status'] )){
        alert('success', 'Thank you for rating and review!');
    }
?>

<?php include "inc/footer.php"?>
<script>
    function cancel_booking(id){
        if(confirm('Are you sure you want to cancel booking?')){
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'ajax/cancel_booking.php', true);
            xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if(this.responseText == 1){
                    window.location.href = 'bookings.php?cancel_status=true';
                }else{
                    alert('error', 'Cncellation Failed!');
                }
            }
            xhr.send('cancel_booking&id='+id);
        }
    }

    

    // review and rating
    let review_form = document.getElementById('review_form');
    function review_room(bid, rid){
        review_form.elements['booking_id'].value = bid;
        review_form.elements['room_id'].value = rid;
    }

    review_form.addEventListener('submit', function(e){
        e.preventDefault();

        let data = new FormData();
        data.append('review_form', '');
        data.append('rating', review_form.elements['rating'].value);
        data.append('review', review_form.elements['review'].value);
        data.append('booking_id', review_form.elements['booking_id'].value);
        data.append('room_id', review_form.elements['room_id'].value);

        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'ajax/review_room.php', true);
        xhr.onload = function() {
            if(this.responseText == 1){
                
                window.location.href = 'bookings.php?review_status=true';
            }else{
                let myModals = document.getElementById('rate-review-modal');
                let modal = bootstrap.Modal.getInstance(myModals);
                modal.hide();
                alert('error', 'Ratinng & Review Failed!');
            }
        }
        xhr.send(data);

    })
</script>
