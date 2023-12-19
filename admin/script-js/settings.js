let genrel_data, contact_data;
let genrel_s_form = document.getElementById('genrel-s-form');
let site_title_inp = document.getElementById("site_title_inp");
let site_about_inp = document.getElementById("site_about_inp");
let contacts_s_form = document.getElementById("contacts-s-form");
let team_s_form = document.getElementById('team-s-form');
let member_name_inp = document.getElementById('member_name_inp');
let member_picture_inp = document.getElementById('member_picture_inp');

genrel_s_form.addEventListener('submit', function(e) {
    e.preventDefault(e);
    upd_genrel(site_title_inp.value, site_about_inp.value)
})

function get_genrel() {
    let site_title = document.getElementById("site_title");
    let site_about = document.getElementById("site_about");

    let shutdown_toggle = document.getElementById("shutdown-toggle");



    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/setting_crud.php", "true");
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    // xhr.onreadystatechange = function(){
    //     if(this.readyState ==4 && this.status == 200){

    //     }
    // }
    xhr.onload = function() {
        genrel_data = JSON.parse(this.responseText);
        site_title.innerText = genrel_data.site_title;
        site_about.innerText = genrel_data.site_about;

        site_title_inp.value = genrel_data.site_title;
        site_about_inp.value = genrel_data.site_about;

        if (genrel_data.shutdown == 0) {
            shutdown_toggle.checked = false;
            shutdown_toggle.value = 0
        } else {
            shutdown_toggle.checked = true;
            shutdown_toggle.value = 1
        }
    }

    xhr.send('get_genral');
}

function upd_genrel(site_title_val, site_about_val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/setting_crud.php", "true");
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    // xhr.onreadystatechange = function(){
    //     if(this.readyState ==4 && this.status == 200){

    //     }
    // }
    xhr.onload = function() {
        let myModals = document.getElementById('genrel-s');
        let modal = bootstrap.Modal.getInstance(myModals);
        modal.hide();
        if (this.responseText == 1) {
            alert('success', 'Changes saved');
            get_genrel();

        } else {
            alert('danger', ' No changes saved');
        }
    }
    xhr.send('site_title=' + site_title_val + '&site_about=' + site_about_val + '&upd_genrel');
}



function upd_shutdown(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/setting_crud.php", "true");
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.responseText == 1 && genrel_data.shutdown == 0) {
            alert('success', 'Site has been shutdown');
        } else {
            alert('success', 'shutdown mode off!');
        }
        get_genrel();
    }
    xhr.send('upd_shutdown=' + val);
}

function get_contacts() {
    let genrel_p_id = ['address', 'map', 'pn1', 'pn2', 'email', 'fb', 'insta', 'tw'];
    let i_fram = document.getElementById('i-frame')

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/setting_crud.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        contact_data = JSON.parse(this.responseText)
            // console.log(contact_data)
        contact_data = Object.values(contact_data);
        for (i = 0; i < genrel_p_id.length; i++) {
            document.getElementById(genrel_p_id[i]).innerText = contact_data[i + 1]
        }
        i_fram.src = contact_data[9]
        contacts_inp(contact_data);
    }
    xhr.send('get_contacts');


}

function contacts_inp(data) {
    let contacts_inp_id = ['address_inp', 'gmap_inp', 'ph1_inp', 'ph2_inp', 'email_inp', 'fb_inp', 'insta_inp', 'tw_inp', 'iframe_inp'];
    for (i = 0; i < contacts_inp_id.length; i++) {
        document.getElementById(contacts_inp_id[i]).value = data[i + 1];
        // console.log((contacts_inp_id[i]))
    }
}

contacts_s_form.addEventListener('submit', function(e) {
    e.preventDefault();
    upd_contacts();
})

function upd_contacts() {
    let index = ['address', 'gmap', 'pn1', 'pn2', 'email', 'facebook', 'instagram', 'twitter', 'iframe'];
    let contacts_inp_id = ['address_inp', 'gmap_inp', 'ph1_inp', 'ph2_inp', 'email_inp', 'fb_inp', 'insta_inp', 'tw_inp', 'iframe_inp']
    let data_str = ""
    for (i = 0; i < index.length; i++) {
        data_str += index[i] + '=' + document.getElementById(contacts_inp_id[i]).value + '&';
    }
    data_str += 'upd_contacts';
    console.log(data_str)
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/setting_crud.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        let myModals = document.getElementById('contacts-s');
        let modal = bootstrap.Modal.getInstance(myModals);
        modal.hide();
        if (this.responseText == 1) {
            alert('success', 'Changes saved');
            get_contacts();

        } else {
            alert('danger', ' No changes saved');
        }
    }
    xhr.send(data_str);
}

team_s_form.addEventListener('submit', function(e) {
    e.preventDefault();
    add_member();
})

function add_member() {
    let data = new FormData();
    data.append('name', member_name_inp.value);
    data.append('picture', member_picture_inp.files[0]);
    data.append('add_member', '');

    let xhr = new XMLHttpRequest;
    xhr.open('POST', 'ajax/setting_crud.php', true);

    xhr.onload = function() {
        let myModals = document.getElementById('team-s');
        let modal = bootstrap.Modal.getInstance(myModals);
        modal.hide();

        if (this.responseText == 'inv_img') {

            alert('error', 'only jpg and png image are allowed')
        } else if (this.responseText == 'inv_size') {

            alert('error', 'Image should be less tehan 2mb')
        } else if (this.responseText == 'upd_faild') {

            alert('error', 'Image upload faild. Server down')
        } else {
            alert('success', 'New member added')
            member_name_inp.value = '';
            member_picture_inp.value = '';
            get_members()
        }
        // console.log(this.responseText)
    }
    xhr.send(data);

}

function get_members() {
    let xhr = new XMLHttpRequest;
    xhr.open('POST', 'ajax/setting_crud.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        document.getElementById('team-data').innerHTML = this.responseText;
        // console.log(this.responseText)
    }
    xhr.send('get_members');
}


function rem_member(val) {
    let xhr = new XMLHttpRequest;
    xhr.open('POST', 'ajax/setting_crud.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {

        if (this.responseText == 1) {
            alert('success', 'Member removed!');
            get_members()
        } else {
            alert('error', 'Server down!')
        }
        console.log(this.responseText)
    }
    xhr.send('rem_member=' + val);
}
window.onload = function() {
    get_genrel();
    get_contacts();
    get_members();
}