<?php include("inc/header.php"); ?>
    <div class="container-fluid " id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h4 class="mb-4">SETTINGS</h4>

                <!-- genrel setting -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Generel setting</h5>
                            <button type="button" class="btn btn-primary shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#genrel-s">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                        </div>
                        <h6 class="card-subtitle mb-1 fw-bold">Side Title</h6>
                        <p class="card-text" id="site_title"> </p>
                        <h6 class="card-subtitle mb-1 fw-bold">About Us</h6>
                        <p class="card-text" id="site_about"> content.</p>
                    </div>
                </div>

                <!-- genrel setting modal-->
                <div class="modal fade" id="genrel-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="genrel-s-form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" >Generel Setting</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Site Title</label>
                                        <input type="text" name="site_title" id="site_title_inp" class="form-control shadow-none" placeholder="Your name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control shadow-none" id="site_about_inp" name="site_about" rows="6" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="site_title.value = genrel_data.site_title, site_about.value = genrel_data.site_about" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn custom-bg text-white shadow-none">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- shutdown section -->
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="modal-title" >Generel Setting</h5>
                            <div class="form-check form-switch">
                                <form>
                                    <input onchange="upd_shutdown(this.value)" class="form-check-input" type="checkbox" id="shutdown-toggle">
                                </form>
                                
                            </div>
                        </div>
                        <p class="card-text">
                            No customers will be allowed to book hotal room when sutdown is turned on.
                        </p>
                    </div>
                </div>

                <!-- contact detail setting -->
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Contect setting</h5>
                            <button type="button" class="btn btn-primary shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#contacts-s">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Address</h6>
                                    <p class="card-text" id="address"> </p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Google map</h6>
                                    <p class="card-text" id="map"> </p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Phonne number</h6>
                                    <p class="card-text" > <i class="bi bi-telephone-fill"></i>
                                        <span id="pn1"></span>
                                    </p>
                                    <p class="card-text" > <i class="bi bi-telephone-fill"></i>
                                        <span id="pn2"></span>
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">E-mail</h6>
                                    <p class="card-text" id="email"> </p>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <h6 class="card-subtitle mb-1 fw-bold">Social icon</h6>
                                <p class="card-text" > <i class="bi bi-facebook me-1"></i>
                                    <span id="fb"></span>
                                </p>
                                <p class="card-text" > <i class="bi bi-instagram me-1"></i>
                                    <span id="insta"></span>
                                </p>
                                <p class="card-text" > <i class="bi bi-twitter me-1"></i>
                                    <span id="tw"></span>
                                </p>
                                
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">I frame</h6>
                                    <iframe id="i-frame" class="border p-2 w-100" src="" frameborder="0"></iframe>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>

                 <!-- Contact setting modal-->
                 <div class="modal fade" id="contacts-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="contacts-s-form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" >Contact Setting</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="container p-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Address</label>
                                                    <input type="text" name="address" id="address_inp" class="form-control shadow-none"  required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Google map links</label>
                                                    <input type="text" name="gmap" id="gmap_inp" class="form-control shadow-none"  required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Phonne number (with contry code)</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                                        <input type="text" id="ph1_inp" name="ph1" class="form-control shadow-none"  aria-label="Username" aria-describedby="basic-addon1" required>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                                        <input type="text" id="ph2_inp" name="ph1" class="form-control shadow-none"  aria-label="Username" aria-describedby="basic-addon1" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="text" name="email" id="email_inp" class="form-control shadow-none"  required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Social icons</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-facebook me-1"></i></span>
                                                        <input type="text" id="fb_inp" name="fb" class="form-control shadow-none"  aria-label="Username" aria-describedby="basic-addon1" required>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-instagram me-1"></i></span>
                                                        <input type="text" id="insta_inp" name="insta" class="form-control shadow-none"  aria-label="Username" aria-describedby="basic-addon1" required>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-twitter me-1"></i></span>
                                                        <input type="text" id="tw_inp" name="tw" class="form-control shadow-none"  aria-label="Username" aria-describedby="basic-addon1" required>
                                                    </div>
                                                    <div class="mb-3">
                                                    <label class="form-label">I frame src</label>
                                                    <input type="text" name="iframe" id="iframe_inp" class="form-control shadow-none"  required>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="contacts_inp(contact_data)" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn custom-bg text-white shadow-none">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- management team -->
                <div class="card border shadow mb-4 mt-2">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Management Team</h5>
                            <button type="button" class="btn btn-primary shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#team-s">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>
                        <div class="row" id="team-data">
                            
                        </div>
                    </div>
                </div>
                <!-- management team modal-->
                <div class="modal fade" id="team-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="team-s-form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" >Add team member </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="member_name" id="member_name_inp" class="form-control shadow-none" placeholder="Your name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Picture</label>
                                        <input type="file" name="member_picture" id="member_picture_inp" accept=".jpg, .png, .webp, .jpeg" class="form-control shadow-none" placeholder="Your name" required>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="member_name.value = '', member_picture.value = ''" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn custom-bg text-white shadow-none">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include("inc/script.php"); ?>
    <?php include("inc/footer.php"); ?>
    <script src="script-js/settings.js"></script> 
</body>
</html>