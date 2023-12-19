// show massage function
function alert(type, msg, position = 'body') {
    let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
    let element = document.createElement('div');
    element.innerHTML = `
        <div class="alert ${bs_class} alert-dismissible fade show " role="alert">
            <strong class = "me-3">${msg}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    if (position == 'body') {
        document.body.append(element);
        element.classList.add('custom-alert');

    } else {
        document.getElementById(position).appendChild(element);
    }
    // setTimeout(remAlert, 5000);
}

function remAlert() {
    document.getElementsByClassName('alert')[0].remove();
}

// register ajax
let register_form = document.getElementById("register-form");

register_form.addEventListener('submit', function(e) {
    e.preventDefault();
    let data = new FormData();
    data.append('name', register_form.elements['name'].value);
    data.append('email', register_form.elements['email'].value);
    data.append('phnumber', register_form.elements['phnumber'].value);
    data.append('profile', register_form.elements['picture'].files[0]);
    data.append('address', register_form.elements['address'].value);
    data.append('pcode', register_form.elements['pcode'].value);
    data.append('dob', register_form.elements['dob'].value);
    data.append('password', register_form.elements['password'].value);
    data.append('cpassword', register_form.elements['cpassword'].value);
    data.append('register', '');

    let myModals = document.getElementById('registermodal');
    let modal = bootstrap.Modal.getInstance(myModals);
    modal.hide();

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/login_register.php', true);
    xhr.onload = function() {
        if (this.responseText == 'password_missmatch') {
            alert('error', 'password missmatch');

        } else if (this.responseText == 'email_alredy') {
            alert('error', ' Email is already register');

        } else if (this.responseText == 'phone_alredy') {
            alert('error', ' Phone is already register');

        } else if (this.responseText == 'inv_img') {
            alert('error', ' Invalid image');

        } else if (this.responseText == 'inv_size') {
            alert('error', ' Invalid image size');

        } else if (this.responseText == 'upd_faild') {
            alert('error', ' Image upload failed');

        } else if (this.responseText == 'mail_failed') {
            alert('error', ' Cannot send confirmation email server doawn');

        } else if (this.responseText == 'ins_faild') {
            alert('error', ' Refistration failed');

        } else {
            alert('success', ' Refistration successfully. confermation send to email ');
        }
    }
    xhr.send(data);
})

// login ajax
let login_form = document.getElementById("login_form");

login_form.addEventListener('submit', function(e) {
    e.preventDefault();
    let data = new FormData();
    data.append('pass', login_form.elements['pass'].value);
    data.append('email_mob', login_form.elements['email_mob'].value);
    data.append('login', '');

    let myModals = document.getElementById('loginmodal');
    let modal = bootstrap.Modal.getInstance(myModals);
    modal.hide();

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/login_register.php', true);
    xhr.onload = function() {
        if (this.responseText == 'inv_email_mob') {
            alert('error', 'Envalid email or mobile');

        } else if (this.responseText == 'not_verified') {
            alert('error', ' Email is not verified');

        } else if (this.responseText == 'inactive') {
            alert('error', 'Account suspended! please contant admin');

        } else if (this.responseText == 'invailid_pass') {
            alert('error', ' Invalid password');

        } else {
            let fileurl = window.location.href.split('/').pop().split('?').shift();
            if (fileurl == 'room_details.php') {
                window.location = window.location.href;
            } else {
                window.location = window.location.pathname;

            }
        }
    }
    xhr.send(data);
})

// forgot ajax
let forgot_form = document.getElementById("forgot_form");
forgot_form.addEventListener('submit', function(e) {
    e.preventDefault();
    let data = new FormData();
    data.append('email', forgot_form.elements['email'].value);
    data.append('forgot_pass', '');

    let myModals = document.getElementById('forgotmodal');
    let modal = bootstrap.Modal.getInstance(myModals);
    modal.hide();

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/login_register.php', true);
    xhr.onload = function() {
        if (this.responseText == 'inv_email') {
            alert('error', 'Envalid email');

        } else if (this.responseText == 'not_verified') {
            alert('error', ' Email is not verified');

        } else if (this.responseText == 'inactive') {
            alert('error', 'Account suspended! please contant admin');

        } else if (this.responseText == 'mail_failed') {
            alert('error', ' Can not send mail. Server down');

        } else if (this.responseText == 'upd_failed') {
            alert('error', 'Account recovery failed. server down');

        } else {
            alert('success', 'Reset link send to emails');
            forgot_form.reset();
            window.location = window.location.pathname;
            // console.log(this.responseText)
        }
        // console.log(this.responseText)
    }
    xhr.send(data);
})