<?php 
    include("inc/header.php");
    // include("inc/config.php");
   
?>
    <div class="container-fluid " id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h4 class="mb-4">Feture & facilities</h4>
                <!-- feture section -->
                <div class="card border shadow mb-4 mt-2">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Feture</h5>
                            <button type="button" class="btn btn-primary shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#feture-s">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                        </div>
                        <div class="table-responsive-md" style="height: 350px; overflow-y: scroll">
                            <table class="table table-hover border">
                                <thead class="">
                                    <tr class="bg-info text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="feture-data">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- facilities section -->
                <div class="card border shadow mb-4 mt-2">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Facilities</h5>
                            <button type="button" class="btn btn-primary shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#facilities-s">
                                <i class="bi bi-pencil-square"></i> Add
                            </button>
                        </div>
                        <div class="table-responsive-md" style="height: 350px; overflow-y: scroll">
                            <table class="table table-hover border">
                                <thead class="">
                                    <tr class="bg-info text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Icons</th>
                                        <th scope="col">Discription</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="facilities-data">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- feture modal-->
    <div class="modal fade" id="feture-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="feture-s-form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Add feture </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="feture_name" class="form-control shadow-none"  required>
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

    <!-- facilities modal-->
    <div class="modal fade" id="facilities-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="facilities-s-form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Add facilities </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="facilities_name" class="form-control shadow-none"  required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Icons</label>
                            <input type="file" name="facilities_icon" accept=".svg" class="form-control shadow-none"  required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Desctiption</label>
                            <textarea class="form-control shadow-none" name="facilities_description" rows="3" required></textarea>
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
    <?php include("inc/script.php"); ?>
    <?php include("inc/footer.php"); ?> 
    <script src="script-js/feture.js"></script>
</body>
</html>