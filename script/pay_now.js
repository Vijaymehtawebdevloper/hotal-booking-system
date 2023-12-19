let booking_form = document.getElementById('booking-form');
let pay_now = document.getElementById('pay_now');
let info_loader = document.getElementById('info-loader');
let pay_info = document.getElementById('pay-info');
let amount = document.getElementById('amt');

function checkAvailability() {
    let checkin_val = booking_form.elements['checkin'].value;
    let checkout_val = booking_form.elements['checkout'].value;
    booking_form.elements['pay_now'].setAttribute('disabled', true);

    if (checkin_val != '' && checkout_val != '') {
        pay_info.classList.add('d-none');
        pay_info.classList.replace('text-dark', 'text-danger');
        info_loader.classList.remove('d-none');
        let data = new FormData();
        data.append('check_availability', '');
        data.append('check_in', checkin_val);
        data.append('check_out', checkout_val);

        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'ajax/confirm_booking.php');

        xhr.onload = function() {
            let data = JSON.parse(this.responseText);
            if (data.status == 'check_in_out_equel') {
                pay_info.innerHTML = 'You cannot check-out on the same day!';

            } else if (data.status == 'check_out_earlier') {
                pay_info.innerHTML = 'Check-out date is earlier than ceck-in date!';

            } else if (data.status == 'check_in_earlier') {
                pay_info.innerHTML = 'Check-in date is earlier than today date!';

            } else if (data.status == 'unavailable') {
                pay_info.innerHTML = 'Room not available for this check-in date!';

            } else {
                pay_info.innerHTML = 'No of days :' + data.days + '<br>Total amount to pay.' + data.payment;
                pay_info.classList.replace('text-danger', 'text-dark');
                booking_form.elements['pay_now'].removeAttribute('disabled');
                amount.value = data.payment;
            }
            pay_info.classList.remove('d-none');
            info_loader.classList.add('d-none');
        }
        xhr.send(data);
    }
};



$("#booking-form").on("submit", function(e) {
    e.preventDefault();
    var amt = $("#amt").val();
    let name = $("#name").val();
    let phonenumber = $("#phonenumber").val();
    let address = $("#address").val();
    let checkin = $("#checkin").val();
    let checkout = $("#checkout").val();
    let data = new FormData()
    data.append('name', name);
    data.append('phonenumber', phonenumber);
    data.append('address', address);
    data.append('checkin', checkin);
    data.append('checkout', checkout);
    data.append('pay_now', '');


    jQuery.ajax({
        type: 'post',
        url: 'pay_now.php',
        data: data,
        cache: false,
        processData: false,
        contentType: false,
        success: function(result) {
            var options = {
                "key": "rzp_test_ZvWW1ofhLGqTMS",
                "amount": amt * 100,
                "currency": "INR",
                "name": "Acme Corp",
                "description": "Test Transaction",
                "image": "https://image.freepik.com/free-vector/logo-sample-text_355-558.jpg",
                "handler": function(response) {
                    console.log(response)
                    jQuery.ajax({
                        type: 'post',
                        url: 'pay_response.php',
                        data: "payment_id=" + response.razorpay_payment_id + '&amt=' + amt,
                        success: function(result) {
                            window.location.href = result;
                        }
                    });
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
        }
    });
})