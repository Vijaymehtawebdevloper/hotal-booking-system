<?php include "inc/header.php"?>
<div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">OUR FACILITIES</h2>
    <div class="h-line bg-dark"></div>
    <p class="mt-3 text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla deserunt quisquam, quo saepe dolores quasi vitae eligendi laboriosam consequatur reprehenderit ut recusandae, iste blanditiis non odio, dolor cumque est aut.</p>

</div>
<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 mb-5 px-4">
            <div class="bg-white rounded shadow p-4">
                <iframe class="w-100 rounden mb-4" src="<?php echo $contact_d['iframe']?>" height="400"  loading="lazy"></iframe>
                <h5>Address</h5>
                <a href="<?php echo $contact_d['address']?>" target="blank" class="d-inline-block text-decoration-none text-dark mb-2">
                    <i class="bi bi-geo-alt-fill"></i>
                    <?php echo $contact_d['address']?>
                </a>
                <h5 class="mt-3">Call us</h5>
                <a href="tel:+<?php echo $contact_d['pn1']?>" class="d-block mb-2 text-decoration-none text-dark">
                    <i class="bi bi-telephone-fill"></i>+<?php echo $contact_d['pn1']?>
                </a>
                <a href="tel:+<?php echo $contact_d['pn2']?>" class="d-block mb-2 text-decoration-none text-dark">
                    <i class="bi bi-telephone-fill"></i>+<?php echo $contact_d['pn2']?>
                </a>
                <h5 class="mt-3">Email</h5>
                <a href="<?php echo $contact_d['email']?>" class="text-decoration-none text-dark">
                    <i class="bi bi-envelope-fill"></i> <?php echo $contact_d['email']?>
                </a>
                <h5 class="mt-3">Follow us</h5>
                <a href="<?php echo $contact_d['twitter']?>" class="mb-2 text-decoration-none text-dark">
                    <span class="badge bg-light text-dark fd-6 p-2 fs-5 me-2">
                        <i class="bi bi-twitter"></i> 
                    </span>
                </a>
                <a href="<?php echo $contact_d['facebook']?>" class="mb-2 text-decoration-none fs-5 me-2 text-dark">
                    <span class="badge bg-light text-dark fd-6 p-2 fs-5 me-2">
                        <i class="bi bi-facebook"></i> 
                    </span>
                </a>
                <a href="<?php echo $contact_d['instagram']?>" class="mb-2  me-2 text-decoration-none text-dark">
                    <span class="badge bg-light text-dark fd-6 p-2 fs-5 me-2">
                        <i class="bi bi-instagram"></i> 
                    </span>
                </a>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 px-4">
            <div class="bg-white rounded shadow p-4">
                <form method="POST">
                    <h5>Send a massage</h5>
                    <div class="mt-3">
                        <label class="form-label" style="font-weight: 500">Name</label>
                        <input name="name" required type="text" class="form-control shadow-none" placeholder="Your name">
                    </div>
                    <div class="mt-3">
                        <label class="form-label" style="font-weight: 500">Email</label>
                        <input name="email" required type="email" class="form-control shadow-none" placeholder="Your email">
                    </div>
                    <div class="mt-3">
                        <label class="form-label" style="font-weight: 500">Subject</label>
                        <input name="subject" required type="text" class="form-control shadow-none" placeholder="Your subject">
                    </div>
                    <div class="mt-3">
                        <label class="form-label" style="font-weight: 500">Message</label>
                        <textarea name="message" required class="form-control shadow-none" rows="1" style="max-height: 150px; min-height: 150px;"></textarea>
                    </div>
                    <div class="col-lg-12 mt-3">
                        <button type="submit" name="send" class="btn custom-bg shadow-none fw-bold text-white ">SEND</button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>

<?php
    if(isset($_POST['send'])){
        $frm_data = filteration($_POST);
        $q = "INSERT INTO `user_queries` (`name`,  `email`, `subject`, `message`)VALUES (?, ?, ?, ?)";
        $values = [$frm_data['name'], $frm_data['email'], $frm_data['subject'], $frm_data['message']];
        $res = insert($q, $values, 'ssss');
        print_r($res);
        if($res ==1){
            alert('success', 'Mail sent');
        }else{
            alert('danger', 'Server doen try again');
        }
    }
?>
<?php include "inc/footer.php"?>