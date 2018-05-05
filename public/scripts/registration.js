var login_status = document.getElementById("login_status");
var login_input = document.getElementById("login_input");
var psw_status = document.getElementById("psw_status");
var psw_input = document.getElementById("psw_input");
var psw_confirm = document.getElementById("psw_input_confirm");
var psw_confirm_status = document.getElementById("psw_status_confirm");
var email_status = document.getElementById("email_status");
var email_input = document.getElementById("email_input");
var btn_submit = document.getElementById("btn_register");
var statusArr = [
    'fa-check',
    'fa-close',
    'preloader'
];

function showElem(elem){
    if (elem.classList.contains('d-none')){
        elem.classList.remove('d-none');
    }
    else if (elem.style.display === 'none'){
        elem.style.display = 'inline-block';
    }
}

function changeElemStatus(elem, status){
    for (var el in statusArr){
        elem.classList.remove(statusArr[el]);
    }
    elem.classList.add(status);
    if (status === 'fa-check'){
        elem.style.color = 'green';
    }
    else if (status === 'fa-close'){
        elem.style.color = 'red';
    }
    elem.innerText = '';
    showElem(elem);
}

login_input.addEventListener('blur', function () {
    if (login_input.value.trim().length < 3){
        changeElemStatus(login_status, statusArr[1]);
        login_status.innerText = ' Too short. Min length 3 characters';
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/register/validate', true);
    xhr.onreadystatechange = function (){
        if (xhr.readyState == XMLHttpRequest.LOADING){
            changeElemStatus(login_status, statusArr[2]);
        }

        if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
            if (this.response === 'OK') {
                changeElemStatus(login_status, statusArr[0]);
            }
            else if (this.response === 'ERROR'){
                changeElemStatus(login_status, statusArr[1]);
                login_status.innerText = ' User already exists';
            }
            else{
                changeElemStatus(login_status, statusArr[1]);
                login_status.innerText = ' We have some problems. Please try again later';
            }
        }
    };

    var data = new FormData();
    data.append('login', login_input.value);
    xhr.send(data);
});

psw_input.addEventListener('blur', function () {
    if (psw_input.value.length < 6){
        changeElemStatus(psw_status, statusArr[1]);
        psw_status.innerText = ' Too short password. Min length 6 characters';
    }
    else{
        changeElemStatus(psw_status, statusArr[0]);
    }
});

email_input.addEventListener('blur', function () {
    var pattern_email = /^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*\@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
    if (pattern_email.test(email_input.value.trim())){
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/register/validate', true);
        xhr.onreadystatechange = function () {
          if (xhr.readyState == XMLHttpRequest.LOADING){
              changeElemStatus(email_status, statusArr[2]);
          }
          if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200){
              if (this.response == 'OK'){
                  changeElemStatus(email_status, statusArr[0]);
              }
              else if (this.response === 'ERROR'){
                  changeElemStatus(email_status, statusArr[1]);
                  email_status.innerText = ' E-mail address already registered';
              }
              else{
                  changeElemStatus(login_status, statusArr[1]);
                  email_status.innerText = ' We have some problems. Please try again later';
              }
          }
        };

        var data = new FormData();
        data.append('email', email_input.value.trim());
        xhr.send(data);
    }
    else {
        changeElemStatus(email_status, statusArr[1]);
        email_status.innerText = ' Wrong e-mail format';
    }
});

function confirmPassword() {
    if (psw_input.value === psw_confirm.value && psw_confirm.value){
        changeElemStatus(psw_confirm_status, statusArr[0]);
    }
    else {
        changeElemStatus(psw_confirm_status, statusArr[1]);
        psw_confirm_status.innerText = ' Passwords don\'t match';
    }
}

psw_confirm.addEventListener('keyup', confirmPassword);

btn_submit.addEventListener('click', function (ev) {
    if (login_status.classList.contains('d-none')) {
        login_input.focus();
        login_input.blur();
    }
    if (psw_status.classList.contains('d-none')) {
        psw_input.focus();
        psw_input.blur();
    }
    if (email_status.classList.contains('d-none')) {
        email_input.focus();
        email_input.blur();
    }
    if (psw_confirm_status.classList.contains('d-none')){
        confirmPassword();
    }
    if (login_status.classList.contains(statusArr[0]) &&
        psw_status.classList.contains(statusArr[0]) &&
        email_status.classList.contains(statusArr[0]) &&
        psw_confirm_status.classList.contains(statusArr[0])){
        return (true);
    }
    ev.preventDefault();
});