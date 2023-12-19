let feture_s_form = document.getElementById('feture-s-form');
let facilities_s_form = document.getElementById('facilities-s-form');


feture_s_form.addEventListener('submit', function(e) {
    e.preventDefault();
    add_feture();
})

function add_feture() {
    let data = new FormData();
    data.append('name', feture_s_form.elements['feture_name'].value);
    data.append('add_feture', '');

    let xhr = new XMLHttpRequest;
    xhr.open('POST', 'ajax/feture_crud.php', true);

    xhr.onload = function() {
        let myModals = document.getElementById('feture-s');
        let modal = bootstrap.Modal.getInstance(myModals);
        modal.hide();

        if (this.responseText == 1) {
            alert('success', 'New feture added')
            feture_s_form.elements['feture_name'].value = '';
            get_feture();

        } else {

            alert('error', 'Server down')
        }
        // console.log(this.responseText)
    }
    xhr.send(data);
}


function get_feture() {
    let data = new FormData();
    data.append('name', feture_s_form.elements['feture_name'].value);
    data.append('get_feture', '');

    let xhr = new XMLHttpRequest;
    xhr.open('POST', 'ajax/feture_crud.php', true);

    xhr.onload = function() {
        document.getElementById('feture-data').innerHTML = this.responseText
    }
    xhr.send(data);
}



function rem_feture(val) {
    let xhr = new XMLHttpRequest;
    xhr.open('POST', 'ajax/feture_crud.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {

        if (this.responseText == 1) {
            alert('success', 'Feture removed!');
            get_feture()
        } else if (this.responseText == 'room_added') {
            alert('error', 'Server down!')
        } else {
            alert('error', 'Feture is added in room!')
        }
        console.log(this.responseText)
    }
    xhr.send('rem_feture=' + val);
}

// facilities ajax script
facilities_s_form.addEventListener('submit', function(e) {
    e.preventDefault();
    add_facilities();
})

function add_facilities() {
    let data = new FormData();
    data.append('name', facilities_s_form.elements['facilities_name'].value);
    data.append('icon', facilities_s_form.elements['facilities_icon'].files[0]);
    data.append('discription', facilities_s_form.elements['facilities_description'].value);
    data.append('add_facilities', '');

    let xhr = new XMLHttpRequest;
    xhr.open('POST', 'ajax/feture_crud.php', true);

    xhr.onload = function() {
        let myModals = document.getElementById('facilities-s');
        let modal = bootstrap.Modal.getInstance(myModals);
        modal.hide();

        if (this.responseText == 'inv_img') {

            alert('error', 'Only svg image are allowed')
        } else if (this.responseText == 'inv_size') {

            alert('error', 'Image should be less tehan 2mb')
        } else if (this.responseText == 'upd_faild') {

            alert('error', 'Image upload faild. Server down')
        } else {
            alert('success', 'New facilities added')
            facilities_s_form.elements['facilities_name'].value = '';
            facilities_s_form.elements['facilities_description'].value = '';
            facilities_s_form.elements['facilities_icon'].value = ''
            get_facilities();
        }
        // console.log(this.responseText)
    }
    xhr.send(data);

}

function get_facilities() {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/feture_crud.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        document.getElementById('facilities-data').innerHTML = this.responseText;
    }
    xhr.send('get_facilities');
}

function rem_facilities(val) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/feture_crud.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        // console.log(this.responseText)
        if (this.responseText == 1) {
            alert('success', 'Facilities removed!');
            get_facilities();
        } else {
            alert('error', 'Facilities added in room');

        }
    }
    xhr.send('rem_facilities=' + val);
}

window.onload = function() {
    get_feture();
    get_facilities();
}