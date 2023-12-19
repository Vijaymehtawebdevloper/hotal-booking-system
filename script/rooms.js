function checkLoginToBook(status, room_id) {
    if (status) {
        window.location.href = 'confirm_booking.php?id=' + room_id;
    } else {
        alert("error", 'Please loginn to book room!');
    }
}

let room_data = document.getElementById('room_data');
let checkin = document.getElementById('check-in');
let checkout = document.getElementById('check-out');
let chk_avail_btn = document.getElementById("chk_avail_btn");
let guest_btn = document.getElementById("guest_btn");
let facilities_btn = document.getElementById("facilities_btn");
let adults = document.getElementById("adults");
let childrens = document.getElementById("childrens");

function fetch_rooms() {
    let chk_avail = JSON.stringify({
        checkin: checkin.value,
        checkout: checkout.value
    });

    let guests = JSON.stringify({
        audults: adults.value,
        childrens: childrens.value
    });

    let facilities_list = { 'facilities': [] };

    // select all facilities 
    let get_facilities = document.querySelectorAll("[name = 'facilities']:checked");

    if (get_facilities.length > 0) {
        get_facilities.forEach((facility) => {
            facilities_list.facilities.push(facility.value);
        })
        facilities_btn.classList.remove('d-none');
    } else {

    }

    facilities_list = JSON.stringify(facilities_list);

    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'ajax/rooms.php?fetch_room&chk_avail=' + chk_avail + '&guests=' + guests + '&facilities_list=' + facilities_list, true);
    xhr.onprogress = function() {
        room_data.innerHTML = `<div class="spinner-border mb-3 text-info mx-auto d-block" id="info-loader" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>`;
    }
    xhr.onload = function() {
        room_data.innerHTML = this.responseText;
    }

    xhr.send();
}

function chk_avail_filter() {
    if ((checkin.value != "") && (checkout.value != "")) {
        fetch_rooms();
        chk_avail_btn.classList.remove('d-none');
    }
}

function chk_avail_clear() {
    checkin.value = "";
    checkout.value = "";
    fetch_rooms();
    chk_avail_btn.classList.add('d-none');

}

function guest_filter() {
    if (adults.value > 0 || childrens.vallue > 0) {
        guest_btn.classList.remove("d-none");
        fetch_rooms();
    }
}

function guest_clear() {
    adults.value = "";
    childrens.value = "";
    fetch_rooms();
    guest_btn.classList.add("d-none")
}

function facilities_clear() {
    let get_facilities = document.querySelectorAll("[name = 'facilities']:checked");
    get_facilities.forEach((facility) => {
        facility.checked = false;
    })
    fetch_rooms();
    facilities_btn.classList.add('d-none');
}

fetch_rooms();