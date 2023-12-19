function get_users() {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/users.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        document.getElementById('users-data').innerHTML = this.responseText;
        // console.log(this.responseText)
    }
    xhr.send('get_users');
}

function user_status(id, status) {
    let data = new FormData();
    data.append('id', id);
    data.append('status', status);
    data.append('user_status', '');

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/users.php', true);
    xhr.onload = function() {
        if (this.responseText == 1) {
            alert('success', 'Status togglr');
            get_users();
        } else {
            alert('error', 'Sever down');
        }
        // console.log(this.responseText)
    }
    xhr.send(data);
}


function remove_users(user_id) {
    let data = new FormData();
    data.append('user_id', user_id);
    data.append('remove_users', '');

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/users.php', true);
    xhr.onload = function() {
        if (this.responseText == 1) {
            alert('success', 'User removed');
            get_users();
        } else {
            alert('error', 'User not removed');
        }

    }
    xhr.send(data);
}

function search_users(username) {
    let data = new FormData();
    data.append('user_name', username);
    data.append('search_users', '');

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/users.php', true);
    xhr.onload = function() {
        document.getElementById('users-data').innerHTML = this.responseText;
    }
    xhr.send(data);
}


window.onload = function() {
    get_users();
}