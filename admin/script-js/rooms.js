let add_room_form = document.getElementById("room-s-form");

add_room_form.addEventListener('submit', function(e) {
    e.preventDefault();
    add_rooms();
})

function add_rooms() {
    let data = new FormData();
    data.append('name', add_room_form.elements['name'].value);
    data.append('area', add_room_form.elements['area'].value);
    data.append('price', add_room_form.elements['price'].value);
    data.append('quantity', add_room_form.elements['quantity'].value);
    data.append('adults', add_room_form.elements['adults'].value);
    data.append('children', add_room_form.elements['children'].value);
    data.append('discription', add_room_form.elements['discription'].value);

    let fetures = [];
    add_room_form.elements['fetures'].forEach(el => {
        if (el.checked) {
            fetures.push(el.value);
        }

    });

    let facilities = [];
    add_room_form.elements['facilities'].forEach(el => {
        if (el.checked) {
            facilities.push(el.value);
        }

    });

    data.append('fetures', JSON.stringify(fetures));
    data.append('facilities', JSON.stringify(facilities));
    data.append('add_rooms', '');

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/rooms_crud.php', true);
    // xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.responseText == 1) {
            let myModals = document.getElementById('room-s');
            let modal = bootstrap.Modal.getInstance(myModals);
            modal.hide();
            alert('success', 'Rooms added', 'massage-alert');
            get_rooms();
            add_room_form.reset();
        } else {
            alert('error', 'Server down', 'massage-alert');
        }
        console.log(this.responseText)
    }

    xhr.send(data);

}



function get_rooms() {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/rooms_crud.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        document.getElementById('room-data').innerHTML = this.responseText;
        // console.log(this.responseText)
    }
    xhr.send('get_rooms');
}

function room_status(id, status) {
    let data = new FormData();
    data.append('id', id);
    data.append('status', status);
    data.append('room_status', '');

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/rooms_crud.php', true);
    xhr.onload = function() {
        if (this.responseText == 1) {
            alert('success', 'Room availabel', 'massage-alert');
            get_rooms();
        } else {
            alert('error', 'Sever down', 'massage-alert');
        }
        // console.log(this.responseText)
    }
    xhr.send(data);
}


let edit_room_s_form = document.getElementById("edit-room-s-form");

function edit_rooms(id) {

    let data = new FormData();
    data.append('room_edit', id);

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/rooms_crud.php', true);
    xhr.onload = function() {
        let myModals = document.getElementById('edit-room-s');
        let modal = bootstrap.Modal.getInstance(myModals);
        modal.hide();
        let room_data = JSON.parse(this.responseText);
        edit_room_s_form.elements['name'].value = room_data.roomdata.name;
        edit_room_s_form.elements['area'].value = room_data.roomdata.area;
        edit_room_s_form.elements['price'].value = room_data.roomdata.price;
        edit_room_s_form.elements['quantity'].value = room_data.roomdata.quantity;
        edit_room_s_form.elements['adults'].value = room_data.roomdata.adult;
        edit_room_s_form.elements['children'].value = room_data.roomdata.children;
        edit_room_s_form.elements['discription'].value = room_data.roomdata.discription;
        edit_room_s_form.elements['room_id'].value = room_data.roomdata.id;

        edit_room_s_form.elements['fetures'].forEach(el => {
            if (room_data.fetures.includes(Number(el.value))) {
                el.checked = true;
            } else {
                el.checked = false;
            }
        });

        edit_room_s_form.elements['facilities'].forEach(el => {
            if (room_data.facilities.includes(Number(el.value))) {
                el.checked = true;
            } else {
                el.checked = false;
            }
        })
    }
    xhr.send(data);
}

edit_room_s_form.addEventListener('submit', function(e) {
    e.preventDefault();

    let data = new FormData();
    data.append('name', edit_room_s_form.elements['name'].value);
    data.append('area', edit_room_s_form.elements['area'].value);
    data.append('price', edit_room_s_form.elements['price'].value);
    data.append('quantity', edit_room_s_form.elements['quantity'].value);
    data.append('adults', edit_room_s_form.elements['adults'].value);
    data.append('children', edit_room_s_form.elements['children'].value);
    data.append('discription', edit_room_s_form.elements['discription'].value);
    data.append('room_id', edit_room_s_form.elements['room_id'].value);

    let fetures = [];
    edit_room_s_form.elements['fetures'].forEach(el => {
        if (el.checked) {
            fetures.push(el.value);
        }

    });

    let facilities = [];
    edit_room_s_form.elements['facilities'].forEach(el => {
        if (el.checked) {
            facilities.push(el.value);
        }

    });

    data.append('fetures', JSON.stringify(fetures));
    data.append('facilities', JSON.stringify(facilities));
    data.append('submit_edit_room', '');

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/rooms_crud.php', true);
    xhr.onload = function() {
        if (this.responseText == 1) {
            alert('success', 'Edit rooms', 'massage-alert');
            get_rooms();
        } else {
            alert('error', 'Sever down', 'massage-alert');
        }
        // console.log(this.responseText)
    }
    xhr.send(data);

})

let room_images_form = document.getElementById("room_images_form");
room_images_form.addEventListener('submit', function(e) {
    e.preventDefault();
    let data = new FormData();
    data.append('room_images', room_images_form.elements['image'].files[0]);
    data.append('room_id', room_images_form.elements['room_id'].value);
    data.append('add_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/rooms_crud.php', true);
    xhr.onload = function() {
        if (this.responseText == 'inv_img') {

            alert('error', 'only jpg and png image are allowed', 'massage-alert')
        } else if (this.responseText == 'inv_size') {

            alert('error', 'Image should be less tehan 2mb', 'massage-alert')
        } else if (this.responseText == 'upd_faild') {

            alert('error', 'Image upload faild. Server down', 'massage-alert')
        } else {
            alert('success', 'New Image added', 'massage-alert');
            room_images(room_images_form.elements['room_id'].value, document.querySelector('#room_images .modal-title').innerText)
            room_images_form.reset();
        }
        // console.log(this.responseText)
        //     // console.log(room_images_form.elements['image'].files[0])
    }
    xhr.send(data);


})

function room_images(id, rname) {
    room_images_form.elements['room_id'].value = id;
    document.querySelector('#room_images .modal-title').innerText = rname;
    room_images_form.elements['image'].value = '';
    //

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/rooms_crud.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        document.getElementById('room-image-data').innerHTML = this.responseText;
        // console.log(this.responseText)
    }
    xhr.send('room_images=' + id);

}

function rem_img(img_id, room_id) {
    let data = new FormData();
    data.append('img_id', img_id);
    data.append('room_id', room_id);
    data.append('rem_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/rooms_crud.php', true);
    xhr.onload = function() {
        if (this.responseText == 1) {
            alert('success', 'Image deleted', 'massage-alert');
            room_images(room_images_form.elements['room_id'].value, document.querySelector('#room_images .modal-title').innerText)
            room_images_form.reset();
        } else {
            alert('error', 'Image deleted failed', 'massage-alert');
        }

    }
    xhr.send(data);
}

function thumb_img(img_id, room_id) {
    let data = new FormData();
    data.append('img_id', img_id);
    data.append('room_id', room_id);
    data.append('thumb_img', '');

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/rooms_crud.php', true);
    xhr.onload = function() {
        if (this.responseText == 1) {
            alert('success', 'Image thumbnail changed', 'massage-alert');
            room_images(room_images_form.elements['room_id'].value, document.querySelector('#room_images .modal-title').innerText)
            room_images_form.reset();
        } else {
            alert('error', 'Image thumbnaild failed', 'massage-alert');
        }

    }
    xhr.send(data);
}


function remove_room(room_id) {
    let data = new FormData();
    data.append('room_id', room_id);
    data.append('remove_room', '');

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/rooms_crud.php', true);
    xhr.onload = function() {
        if (this.responseText == 1) {
            alert('success', 'Room removed');
            get_rooms();
        } else {
            alert('error', 'Room not removed');
        }

    }
    xhr.send(data);
}



window.onload = function() {
    get_rooms();
}