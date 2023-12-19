<?php 
    include("inc/header.php");
    // include("inc/config.php");
   
?>
    <div class="container-fluid " id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h4 class="mb-4">New booking</h4>
                <!-- feture section -->
                <div class="card border shadow mb-4 mt-2">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">New booking</h5>
                            <input type="text" oninput="get_bookings(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Search users">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover border" style="min-width: 200px;">
                                <thead class="">
                                    <tr class="bg-info text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">User Details</th>
                                        <th scope="col">Room Fetails</th>
                                        <th scope="col">Booking Details</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>

    <!-- Assign room modal-->
    <div class="modal fade" id="assign-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="assign-room-form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Assign Room</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Room number</label>
                            <input type="text" name="room_number" class="form-control shadow-none"  required>
                        </div>
                        <span class="badge bg-light text-dark mb-3 text-wrap lh-base">
                            Note: Sddign room number only User has been arrived.
                        </span>
                        <input type="hidden" name="booking_id">
                    </div>
                    <div class="modal-footer">
                        <button type="reset"  class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">Assign</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <?php include("inc/script.php"); ?>
    <?php include("inc/footer.php"); ?> 
    <script src="script-js/new_bookings.js"></script>
</body>
</html>