var btnBrowse = document.getElementById("btn_browse");
var originalUpload = btnBrowse.children[1];
var filename = document.getElementById("filename");
var errMsg = document.getElementById("error_msg");
var btnDelImage = document.querySelectorAll('.btn-del-img');

btnBrowse.addEventListener('click', function () {
    originalUpload.click();
});

btnBrowse.addEventListener('change', function () {
    filename.value = originalUpload.files[0].name;
    if (!errMsg.classList.contains('d-none')){
        errMsg.classList.add('d-none');
    }
});

document.getElementById('btn_upload').addEventListener('click', function (ev) {
    if (!filename.value){
        ev.preventDefault();
        errMsg.classList.remove('d-none');
    }
    else {
        if (!errMsg.classList.contains('d-none')){
            errMsg.classList.add('d-none');
        }
    }
});


function deleteImage(event) {
    event.preventDefault();
    if (confirm('Do you really want to delete this image?')){
        var aTag = this.parentElement.parentElement;
        var id = aTag.href.substr(aTag.href.indexOf('id=') + 3);
        if (!id){
            return;
        }
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/gallery/delete', true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                if (this.response === 'OK') {
                    aTag.parentElement.remove();
                }
                else if (this.response === 'ERROR'){
                    alert('Error. Can`t delete this image.');
                }
            }
        };

        var data = new FormData();
        data.append('delId', id);
        xhr.send(data);
    }
}

[].forEach.call(btnDelImage, function (el) {
    el.addEventListener('click', deleteImage);
});