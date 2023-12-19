<!-- footer -->
<div class="container bg-white mt-5 py-4">
        <div class="row">
            <div class="col-lg-4 P4">
                <h3 class="h-font fs-3 mb-2 fw-bold"><?php echo $settings_d['site_title']?></h3>
                <p><?php echo $settings_d['site_about']?></p>
            </div>
            <div class="col-lg-4 P4">
                <h5 class="mb-2">LINKS</h5>
                <a href="index.php" class="mb-2 text-dark text-decoration-none d-block">Home</a>
                <a href="room.php" class="mb-2 text-dark text-decoration-none d-block">Rooms</a>
                <a href="facilities.php" class="mb-2 text-dark text-decoration-none d-block">Facilities</a>
                <a href="contect.php" class="mb-2 text-dark text-decoration-none d-block">Contact us</a>
                <a href="about.php" class="mb-2 text-dark text-decoration-none d-block">About</a>
            </div>
            <div class="col-lg-4 P4">
                <h5 class=" mb-2 ">Follow us</h5>
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
    <h5 class="bg-dark text-center text-white">Devlopd by @vijaysinghmehta</h5>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="script/script.js"></script>
    <script src="script/register.js"></script>
</body>
</html>