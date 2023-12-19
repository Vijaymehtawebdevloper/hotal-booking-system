function get_bookings(search = '') {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/new_bookings.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        document.getElementById('table-data').innerHTML = this.responseText;
        // console.log(this.responseText)
    }
    xhr.send('get_bookings&search=' + search);
}


let assign_room_form = document.getElementById('assign-room-form');

function assign_room(id) {
    assign_room_form.elements['booking_id'].value = id;

}

assign_room_form.addEventListener('submit', function(e) {
    e.preventDefault();
    let data = new FormData();
    data.append('room_number', assign_room_form.elements['room_number'].value);
    data.append('booking_id', assign_room_form.elements['booking_id'].value);
    data.append('assign_room', '');

    let xhr = new XMLHttpRequest;
    xhr.open('POST', 'ajax/new_bookings.php', true);

    xhr.onload = function() {
        let myModals = document.getElementById('assign-room');
        let modal = bootstrap.Modal.getInstance(myModals);
        modal.hide();

        if (this.responseText == 1) {

            alert('success', 'Room number alloted!finalixed!')
            assign_room_form.reset();
            get_bookings();
        } else {

            alert('error', 'Server Down')
        }
    }
    xhr.send(data);
})


function cancle_booking(id) {
    if (confirm('Are you sure, you want to cancel this booking')) {
        let data = new FormData();
        data.append('booking_id', id);
        data.append('cancle_booking', '');

        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'ajax/new_bookings.php', true);
        xhr.onload = function() {
            if (this.responseText == 1) {
                alert('success', 'Booking canceled');
                get_bookings();
            } else {
                alert('error', 'User not removed');
            }
        }
        xhr.send(data);

    }
}


window.onload = function() {
    get_bookings();
}