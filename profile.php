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


    $u_exist = select("SELECT * FROM `user_register` WHERE id = ? LIMIT 1", [$_SESSION['uID']], 's');
    if(mysqli_num_rows($u_exist) == 0){

    }

    $u_fetch = mysqli_fetch_assoc($u_exist);
?>

<div class="container">
    <div class="row">
        <div class="col-12 my-5 mb-4 px-4">
            <h2 class="fw-bold"> PROFILE </h2>
            <div style="font-size: 14px;">
                <a href="index.php" class="text-secondary">Home</a>
                <span class="text-secondary"> > </span>
                <a href="#" class="text-secondary">Profile</a>
            </div>
        </div>
        <div class="col-12 mb-5 px-4">
            <div class="bg-white p-3 p-mb-6 rounded shadow-sm">
                <form id="info-form">
                    <h5 class="mb-3 fw-bold">Basic Information</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="<?php echo $u_fetch['name']?>" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone number</label>
                            <input type="number" name="phoneNumber" value="<?php echo $u_fetch['phnumber']?>" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date of birth</label>
                            <input type="date" name="dob" value="<?php echo $u_fetch['dob']?>" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pincode</label>
                            <input type="number" name="pincode" value="<?php echo $u_fetch['pcode']?>" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-8 mb-5">
                            <label class="form-label">Address</label>
                            <textarea type="text" name="address" rows="5" class="form-control shadow-none" required><?php echo $u_fetch['address']?></textarea>
                        </div>
                    </div>
                    <button class="btn btn-success shadow-none" type="submit">Save changes</button>
                </form>
            </div>
        </div>

        <div class="col-md-4 mb-5 px-4">
            <div class="bg-white p-3 p-mb-6 rounded shadow-sm">
                <form id="profile_form">
                    <h5 class="mb-3 fw-bold">Picture</h5>
                    <img src="<?php echo USER_IMG_PATH.$u_fetch['profile']?>" class="img-fluid rounded-circle">
                    <label class="form-label">New picture</label>
                    <input type="file" name="picture" accept=".jpg, .jpeg, .png, .webp" class="form-control shadow-none mb-4" required>
                    <button class="btn btn-success shadow-none" type="submit">Save changes</button>
                </form>
            </div>
        </div>


        <div class="col-md-8 mb-5 px-4">
            <div class="bg-white p-3 p-mb-6 rounded shadow-sm">
                <form id="password_form">
                    <h5 class="mb-3 fw-bold">Change password</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">New password</label>
                            <input type="password" name="new_password" class="form-control shadow-none" required>
                        </div>
                        <div class="col-md-6 mb-3">
                        <label class="form-label">Confirm password</label>
                            <input type="password" name="Confirm_password" class="form-control shadow-none" required>
                        </div>
                    </div>
                    <button class="btn btn-success shadow-none" type="submit">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include "inc/footer.php"?>
<script>
    let info_form = document.getElementById('info-form');
    let profile_form = document.getElementById('profile_form');
    let password_form = document.getElementById('password_form');

    info_form.addEventListener('submit', function(e){
        e.preventDefault();

        let data = new FormData();
        data.append('info_form', '');
        data.append('name', info_form.elements['name'].value);
        data.append('phoneNumber', info_form.elements['phoneNumber'].value);
        data.append('dob', info_form.elements['dob'].value);
        data.append('pincode', info_form.elements['pincode'].value);
        data.append('address', info_form.elements['address'].value);

        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'ajax/profile.php');

        xhr.onload = function(){
            if(this.responseText == 'phone_aleready'){
                alert('error', 'Phone number is already register!');

            }else if(this.responseText == 0){
                alert('error', 'No changes mode!');

            }else{
                alert('success', 'Change saved!');

            }
        }
        xhr.send(data);
    })


    profile_form.addEventListener('submit', function(e){
        e.preventDefault();

        let data = new FormData();
        data.append('profile_form', '');
        data.append('picture', profile_form.elements['picture'].files[0]);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'ajax/profile.php');

        xhr.onload = function(){
            if(this.responseText == 'phone_aleready'){
                alert('error', 'only JPG, WEBP, & PNG images are allowed!');

            }else if(this.responseText == 'inv_img'){
                alert('error', 'Image upload failed!');

            }else if(this.responseText == 'upd_failed'){
                alert('error', 'Updation failed!');

            }else{
                window.location.href = window.location.pathname;
                // console.log(this.responseText)
            }
        }
        xhr.send(data);
    })



    password_form.addEventListener('submit', function(e){
        e.preventDefault();

        let new_pass = password_form.elements['new_password'].value;
        let Confirm_pass = password_form.elements['Confirm_password'].value;

        if(new_pass != Confirm_pass){
            alert('error', 'Password do not match!');
            return false;
        }


        let data = new FormData();
        data.append('password_form', '');
        data.append('new_password', password_form.elements['new_password'].value);
        data.append('Confirm_password', password_form.elements['Confirm_password'].value);

        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'ajax/profile.php');

        xhr.onload = function(){
            if(this.responseText == 'missmatch'){
                alert('error', 'Password do not match!');

            }else if(this.responseText == 0){
                alert('error', 'No changes mode!');

            }else{
                alert('success', 'Change saved!');
                password_form.reset();
            }
        }
        xhr.send(data);
    })

</script>
