var btnBrowse = document.getElementById("btn_browse");
var originalUpload = btnBrowse.children[1];
var filename = document.getElementById("filename");
var errMsg = document.getElementById("error_msg");

btnBrowse.addEventListener('click', function () {
    originalUpload.click();
});

btnBrowse.addEventListener('change', function () {
    filename.value = originalUpload.files[0].name;
    if (!errMsg.classList.contains('d-none')) {
        errMsg.classList.add('d-none');
    }
});

document.getElementById('btn_upload').addEventListener('click', function (ev) {
    if (!filename.value) {
        ev.preventDefault();
        errMsg.classList.remove('d-none');
    }
    else {
        if (!errMsg.classList.contains('d-none')) {
            errMsg.classList.add('d-none');
        }
    }
});
