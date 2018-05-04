let statusArr = [
    'fa-check',
    'fa-close',
    'preloader'
];


function showElem(elem) {
    if (elem.classList.contains('d-none')) {
        elem.classList.remove('d-none');
    }
    else if (elem.style.display === 'none') {
        elem.style.display = 'inline-block';
    }
}

function changeElemStatus(elem, status) {
    for (let el in statusArr) {
        elem.classList.remove(statusArr[el]);
    }
    elem.classList.add(status);
    if (status === 'fa-check') {
        elem.style.color = 'green';
    }
    else if (status === 'fa-close') {
        elem.style.color = 'red';
    }
    elem.innerText = '';
    showElem(elem);
}

//change login
{
    let form = document.getElementById('change-login');
    let pswStatus = document.getElementById('change-login-psw-status');

    form.newLogin.addEventListener('blur', function () {
        let xhr = new XMLHttpRequest();
        let loginStatus = document.getElementById('change-login-login-status');
        let data = new FormData();

        if (form.newLogin.value.trim().length < 3) {
            changeElemStatus(loginStatus, statusArr[1]);
            loginStatus.innerText = ' Too short. Min length 3 characters';
            return;
        }
        xhr.open('POST', '/register/validate', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == XMLHttpRequest.LOADING) {
                changeElemStatus(loginStatus, statusArr[2]);
            }

            if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                if (this.response === 'OK') {
                    changeElemStatus(loginStatus, statusArr[0]);
                }
                else if (this.response === 'ERROR') {
                    changeElemStatus(loginStatus, statusArr[1]);
                    loginStatus.innerText = ' User already exists';
                }
                else {
                    changeElemStatus(loginStatus, statusArr[1]);
                    loginStatus.innerText = ' We have some problems. Please try again later';
                }
            }
        };

        data.append('login', form.newLogin.value);
        xhr.send(data);
    });

    form.submit.addEventListener('click', function () {
        let xhr = new XMLHttpRequest();
        let pswStatus = document.getElementById('change-login-psw-status');
        let data = new FormData();

        data.append('action', 'changeLogin');
        data.append('newLogin', form.newLogin.value.trim());
        data.append('password', form.password.value);
        xhr.open('POST', '/account/modify', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == XMLHttpRequest.LOADING) {
                changeElemStatus(pswStatus, statusArr[2]);
            }
            if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                if (this.response === 'OK') {
                    document.getElementById('user_login').innerText = form.newLogin.value;
                    alert('Login has been changed');
                    pswStatus.classList.add('d-none');
                }
                else {
                    changeElemStatus(pswStatus, statusArr[1]);
                    pswStatus.innerText = ' Wrong password';
                }
            }
            else if (xhr.readyState == XMLHttpRequest.DONE && xhr.status != 200) {
                changeElemStatus(pswStatus, statusArr[1]);
                pswStatus.innerText = ' We have some problems. Please try again later';
            }
        };
        xhr.send(data);
    });
}

//change email
{
    let form = document.getElementById('change-email');
    let emailStatus = document.getElementById('change-email-email-status');

    form.newEmail.addEventListener('blur', function () {
        let pattern_email = /^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*\@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;

        if (pattern_email.test(form.newEmail.value.trim())) {
            let xhr = new XMLHttpRequest();

            xhr.open('POST', '/register/validate', true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == XMLHttpRequest.LOADING) {
                    changeElemStatus(emailStatus, statusArr[2]);
                }
                if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                    if (this.response == 'OK') {
                        changeElemStatus(emailStatus, statusArr[0]);
                    }
                    else if (this.response === 'ERROR') {
                        changeElemStatus(emailStatus, statusArr[1]);
                        emailStatus.innerText = ' E-mail address already registered';
                    }
                    else {
                        changeElemStatus(login_status, statusArr[1]);
                        emailStatus.innerText = ' We have some problems. Please try again later';
                        console.log(this.response);
                    }
                }
            };

            let data = new FormData();
            data.append('email', form.newEmail.value.trim());
            xhr.send(data);
        }
        else {
            changeElemStatus(emailStatus, statusArr[1]);
            emailStatus.innerText = ' Wrong e-mail format';
        }
    });

    form.submit.addEventListener('click', function () {
        let xhr = new XMLHttpRequest();
        let pswStatus = document.getElementById('change-email-psw-status');
        let data = new FormData();

        data.append('action', 'changeEmail');
        data.append('newEmail', form.newEmail.value.trim());
        data.append('password', form.password.value);
        xhr.open('POST', '/account/modify', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == XMLHttpRequest.LOADING) {
                changeElemStatus(pswStatus, statusArr[2]);
            }
            if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                if (this.response === 'OK') {
                    form.newEmail.value = '';
                    form.password.value = '';
                    emailStatus.style.display = 'none';
                    alert('E-Mail has been changed');
                    pswStatus.classList.add('d-none');
                }
                else {
                    changeElemStatus(pswStatus, statusArr[1]);
                    pswStatus.innerText = ' Wrong password';
                }
            }
            else if (xhr.readyState == XMLHttpRequest.DONE && xhr.status != 200) {
                changeElemStatus(pswStatus, statusArr[1]);
                pswStatus.innerText = ' We have some problems. Please try again later';
            }
        };
        xhr.send(data);
    });
}

//change password
{
    let form = document.getElementById('change-password');
    let pswCurrStatus = document.getElementById('change-psw-current-status');
    let pswNewStatus = document.getElementById('change-psw-new-status');
    let pswRepeatStatus = document.getElementById('change-psw-repeat-status');

    function checkConfirmPassword() {
        if (form.RepeatPassword.value && form.RepeatPassword.value === form.NewPassword.value) {
            changeElemStatus(pswRepeatStatus, statusArr[0]);
        }
        else {
            changeElemStatus(pswRepeatStatus, statusArr[1]);
            pswRepeatStatus.innerText = ' Passwords don\'t match';
        }
    }

    form.RepeatPassword.addEventListener('keyup', checkConfirmPassword);

    form.NewPassword.addEventListener('blur', function () {
        if (form.NewPassword.value.length < 6) {
            changeElemStatus(pswNewStatus, statusArr[1]);
            pswNewStatus.innerText = ' Too short password. Min length 6 characters';
        }
        else {
            changeElemStatus(pswNewStatus, statusArr[0]);
        }
    });

    form.submit.addEventListener('click', function () {
        checkConfirmPassword();
        form.NewPassword.focus();
        form.NewPassword.blur();

        if (!form.CurrPassword.value) {
            changeElemStatus(pswCurrStatus, statusArr[1]);
            pswCurrStatus.innerText = ' Empty filed';
            return;
        }

        let xhr = new XMLHttpRequest();
        let data = new FormData();

        data.append('action', 'changePassword');
        data.append('currentPassword', form.CurrPassword.value);
        data.append('newPassword', form.NewPassword.value);
        data.append('confirmPassword', form.RepeatPassword.value);
        xhr.open('POST', '/account/modify', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                //form.reset();
                if (this.response === 'OK') {
                    pswCurrStatus.style.display = 'none';
                    pswRepeatStatus.style.display = 'none';
                    pswNewStatus.style.display = 'none';
                    alert('Password has been changed')
                }
                else if (this.response === 'ERROR') {
                    changeElemStatus(pswCurrStatus, statusArr[1]);
                    pswCurrStatus.innerText = ' Wrong password';
                }
                else {
                    alert('We have some problems. Please try again later');
                }
            }
        };
        xhr.send(data);
    });
}