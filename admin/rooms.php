<?php 
    include("inc/header.php");
    // include("inc/config.php");
   
?>
    <div class="container-fluid " id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h4 class="mb-4">Rooms</h4>
                <!-- feture section -->
                <div class="card border shadow mb-4 mt-2">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Rooms</h5>
                            <button type="button" class="btn btn-primary shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#room-s">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>
                        <div class="table-responsive-md" style="height: 450px; overflow-y: scroll">
                            <table class="table table-hover border">
                                <thead class="">
                                    <tr class="bg-info text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Area</th>
                                        <th scope="col">Guest</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="room-data">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>

    <!-- room modal-->
    <div class="modal fade" id="room-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" style =  "max-width: 550px ;">
            <form id="room-s-form" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Add feture </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control shadow-none"  required>
                            </div>
    
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Area</label>
                                <input type="number" min="1" name="area" class="form-control shadow-none"  required>
                            </div>
    
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Price</label>
                                <input type="number" min="1" name="price" class="form-control shadow-none"  required>
                            </div>
    
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Quantity</label>
                                <input type="number" min="1" name="quantity" class="form-control shadow-none"  required>
                            </div>
    
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Adults (Max.)</label>
                                <input type="number" min="1" name="adults" class="form-control shadow-none"  required>
                            </div>
    
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Children (Max.)</label>
                                <input type="number" min="1" name="children" class="form-control shadow-none"  required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Fetures</label>
                                <div class="row">
                                    <?php
                                        $res = selectAll('fetures');
                                        while($row = mysqli_fetch_assoc($res)){
                                            echo"
                                                <div class = 'col-md-3'>
                                                    <label>
                                                        <input type = 'checkbox' name='fetures' value = '$row[sr_no]' class='form-check-input shadow-none'>
                                                        $row[name]
                                                    </label>
                                                </div>
                                            ";
                                        }
                                    ?>
                                </div>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Facilities</label>
                                <div class="row">
                                    <?php
                                        $res = selectAll('facilities');
                                        while($row = mysqli_fetch_assoc($res)){
                                            echo"
                                                <div class = 'col-md-3'>
                                                    <label>
                                                        <input type = 'checkbox' name='facilities' value = '$row[id]' class='form-check-input shadow-none'>
                                                        $row[name]
                                                    </label>
                                                </div>
                                            ";
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Discription</label>
                                <textarea name="discription" rows="4" required class="form-control shadow-none"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- edit rooms modal -->
    <div class="modal fade" id="edit-room-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" style =  "max-width: 550px ;">
            <form id="edit-room-s-form" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Edit room </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control shadow-none"  required>
                            </div>
    
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Area</label>
                                <input type="number" min="1" name="area" class="form-control shadow-none"  required>
                            </div>
    
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Price</label>
                                <input type="number" min="1" name="price" class="form-control shadow-none"  required>
                            </div>
    
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Quantity</label>
                                <input type="number" min="1" name="quantity" class="form-control shadow-none"  required>
                            </div>
    
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Adults (Max.)</label>
                                <input type="number" min="1" name="adults" class="form-control shadow-none"  required>
                            </div>
    
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Children (Max.)</label>
                                <input type="number" min="1" name="children" class="form-control shadow-none"  required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Fetures</label>
                                <div class="row">
                                    <?php
                                        $res = selectAll('fetures');
                                        while($row = mysqli_fetch_assoc($res)){
                                            echo"
                                                <div class = 'col-md-3'>
                                                    <label>
                                                        <input type = 'checkbox' name='fetures' value = '$row[sr_no]' class='form-check-input shadow-none'>
                                                        $row[name]
                                                    </label>
                                                </div>
                                            ";
                                        }
                                    ?>
                                </div>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label">Facilities</label>
                                <div class="row">
                                    <?php
                                        $res = selectAll('facilities');
                                        while($row = mysqli_fetch_assoc($res)){
                                            echo"
                                                <div class = 'col-md-3'>
                                                    <label>
                                                        <input type = 'checkbox' name='facilities' value = '$row[id]' class='form-check-input shadow-none'>
                                                        $row[name]
                                                    </label>
                                                </div>
                                            ";
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Discription</label>
                                <textarea name="discription" rows="4" required class="form-control shadow-none"></textarea>
                            </div>
                            <input type="hidden" name="room_id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!--  rooms images modal -->
    <div class="modal fade" id="room_images" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" style =  "max-width: 450px ;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Room name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="massage-alert"></div>
                    <div class="bottom-border border-3 pb-3 mb-3">
                        <form id="room_images_form" autocomplete="off">
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label">Add image</label>
                                    <input type="file" name="image" class="form-control shadow-none" accept="jpg, png, webp, jpeg" required>
                                </div>
                                <input type="hidden" name="room_id">
                            </div>
                            <button type="submit" class="btn custom-bg text-white shadow-none">Add</button>
                        </form>
                    </div>
                    <div class="table-responsive-md" style="height: 350px; overflow-y: scroll">
                        <table class="table table-hover border">
                            <thead class="">
                                <tr class="bg-info text-light">
                                    <th scope="col" width = "60%">Images</th>
                                    <th scope="col">Thumb</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody id="room-image-data">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <?php include("inc/script.php"); ?>
    <?php include("inc/footer.php"); ?> 
    <script src="script-js/rooms.js"></script>
</body>
</html>