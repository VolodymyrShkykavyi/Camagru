let loginForm = document.getElementById('login-form');

if (loginForm) {
    loginForm.submit.addEventListener('click', function (ev) {
        ev.preventDefault();
        let xhr = new XMLHttpRequest();
        let data = new FormData();

        data.append('login_username', loginForm.login_username.value);
        data.append('login_password', loginForm.login_password.value);
        data.append('actionType', 'ajax');
        xhr.open('POST', '/account/login', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                let response = JSON.parse(this.response);
                if (response.status == 'ERROR') {
                    alert('Wrong Username/Password');
                }
                else {
                    if (response.redirect) {
                        window.location.replace(response.redirect);
                    }
                    else {
                        location.reload();
                    }
                }
            }
        };
        xhr.send(data);
    });
}