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
        <label class="form-label" style="font-weight: 500">Subject</label>
        <textarea name="message" required class="form-control shadow-none" rows="1" style="max-height: 150px; min-height: 150px;"></textarea>
    </div>
    <div class="col-lg-12 mt-3">
        <button type="submit" name="send" class="btn custom-bg shadow-none fw-bold text-white ">SEND</button>
    </div>
</form>
<?php
    if(isset($_POST['send'])){
        print_r ($_POST);
    }
?>