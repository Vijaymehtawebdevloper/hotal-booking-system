function booking_analytics(period = 1) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/dashbord.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        let data = JSON.parse(this.responseText)
        document.getElementById('total_bookings').textContent = data.total_bookings;
        document.getElementById('total_amt').textContent = data.total_amt;
        document.getElementById('active_bookings').textContent = data.active_bookings;
        document.getElementById('active_amt').textContent = data.active_amt;
        document.getElementById('cancelled_bookings').textContent = data.cancelled_bookings;
        document.getElementById('cancelled_amt').textContent = data.cancelled_amt;

    }
    xhr.send('booking_analytics&period=' + period);
}

function users_analytics(period = 1) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/dashbord.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        let data = JSON.parse(this.responseText)
        document.getElementById('total_users').textContent = data.total_users;
        document.getElementById('total_queries').textContent = data.total_queries;
        document.getElementById('total_review').textContent = data.total_review;

    }
    xhr.send('users_analytics&period=' + period);
}

window.onload = function() {
    booking_analytics(1);
    users_analytics(1);
}