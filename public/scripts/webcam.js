var webcam = document.getElementById('video');
var canvas = document.getElementById('image-main');
var decoration = document.getElementById('image-decoration');
var canvas_context = canvas.getContext('2d');
var decoration_context = decoration.getContext('2d');
var decoration_settings = document.getElementById('decoration-settings');
var isWebCam = false;
var btnBrowse = document.getElementById("btn_browse");
var originalUpload = btnBrowse.children[1];
var btnPhoto = document.getElementById("btn_photo");

// check available of camera and get access to it
if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices.getUserMedia({video: true})
        .then(function (stream) {
            if (typeof (webcam.srcObject !== 'undefined')) {
                webcam.srcObject = stream;
            }
            else {
                webcam.src = window.URL.createObjectURL(stream);
            }
            isWebCam = true;
            webcam.play();
        })
        .catch(function () {
            document.getElementById('image-main-upload').style.display = 'block';
        });
}

webcam.addEventListener('play', function () {
    drawMain(this, canvas_context);
}, false);

//display first layer(camera/uploaded image)
function drawMain(img, context) {
    if (img && (img.src || isWebCam)) {
        context.drawImage(img, 0, 0, canvas.width, canvas.height);
    }
    if (isWebCam) {
        setTimeout(drawMain, 10, img, context);
    }
}

function blockUploadBtn() {
    if (btnPhoto.classList.contains('btn-success')) {
        btnPhoto.classList.add('btn-danger');
        btnPhoto.classList.remove('btn-success');
        btnPhoto.innerText = 'Select one effect';

        document.getElementById('btn_photo').removeEventListener('click', uploadImage);
    }
}

function unblockUploadBtn() {
    if (btnPhoto.classList.contains('btn-danger')) {
        btnPhoto.classList.remove('btn-danger');
        btnPhoto.classList.add('btn-success');
        btnPhoto.innerText = 'Make Photo!';

        document.getElementById("btn_photo").addEventListener("click", uploadImage);
    }
}

function drawDecoration(elem) {
    decoration_context.clearRect(0, 0, decoration.width, decoration.height);
    var img = elem.getElementsByTagName('img')[0];

    if (img && img.src) {
        var offsetX = decoration_settings.setOX.value;
        var offsetY = decoration_settings.setOY.value;
        var scaleWidth = decoration_settings.setWidth.value / 100;
        var scaleHeight = decoration_settings.setHeight.value / 100;

        decoration_context.drawImage(img, offsetX, offsetY,
            decoration.width * scaleWidth, decoration.height * scaleHeight);

        //unblock button for uploading image on server
        if (!isCanvasBlank(canvas)) {
            unblockUploadBtn();
        }
    }
    else {
        blockUploadBtn();
    }
}

//change size of both layers(webcam and decoration)
function changeSize() {
    var divContainer = document.getElementById('image-preview');
    canvas.height = canvas.offsetWidth * 0.75;
    canvas.width = canvas.offsetWidth;
    decoration.height = canvas.height;
    decoration.width = canvas.width;
    divContainer.style.height = decoration.height + 'px';
}

//if any decoration settings change - redraw decoration layer
function changeSettings() {
    var allDecorations = Array.from(document.getElementById('decoration').getElementsByClassName('decoration-thumbnail'));
    for (var el in allDecorations) {
        if ((allDecorations[el].getElementsByTagName('input'))[0].checked) {
            drawDecoration(allDecorations[el]);
        }
    }
}

function resetSettings() {
    var event = new Event('input', {bubbles: true});
    decoration_settings.reset();
    decoration_settings.setWidth.dispatchEvent(event);
    decoration_settings.setHeight.dispatchEvent(event);
    decoration_settings.setOX.dispatchEvent(event);
    decoration_settings.setOY.dispatchEvent(event);
}

//upload image on server
function uploadImage() {
    if (isCanvasBlank(canvas) || isCanvasBlank(decoration)) {
        return;
    }
    var xhr = new XMLHttpRequest();
    var data = new FormData();
    var btnLoader = document.getElementById('btn_loader');
    var btnSubmit = document.getElementById('btn_photo');

    data.append('layer1', canvas.toDataURL("image/png"));
    data.append('layer2', decoration.toDataURL("image/png"));
    xhr.open('POST', '/montage/upload', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState = XMLHttpRequest.LOADING) {
            btnLoader.style.display = 'block';
            btnSubmit.style.display = 'none';
        }
        if (xhr.readyState == XMLHttpRequest.DONE) {
            btnLoader.style.display = 'none';
            btnSubmit.style.display = 'block';
            if (xhr.status == 200 && this.response && this.response != 'ERROR') {
                decoration_context.clearRect(0, 0, decoration.width, decoration.height);
                if (!isWebCam){
                    canvas_context.clearRect(0, 0, canvas.width, canvas.height);
                }
                blockUploadBtn();
                originalUpload.value = '';
                document.getElementById('filename').value = '';

                //add thumbnail to sidebar
                let sidebarThumbnail = document.getElementById('sidebar-thumbnails');
                if (sidebarThumbnail){
                    let response = JSON.parse(this.response);
                    let img = document.createElement('div');
                    img.classList.add('col-6', 'p-0', 'm-0', 'vertical-center');
                    img.innerHTML = '<a href="/gallery/image/'+ response.id +'" class="d-block position-relative">' +
                        '<img src="' + response.src + '" class="img-fluid"><div class="overlay">' +
                        '<button type="button" onclick="deleteImage(event, this);" class="btn btn-danger rounded-circle btn-del-img-sidebar shadow-none btn-sm">' +
                        '<i class="fa fa-trash fa-sm text-light"></i></button>' +
                        '<i class="fa fa-comments fa-lg text-light"></i></div></a>';
                    sidebarThumbnail.insertBefore(img, sidebarThumbnail.firstElementChild);

                }
            }
        }
    };

    xhr.send(data);
}

function isCanvasBlank(canvas) {
    var blank = document.createElement('canvas');
    blank.width = canvas.width;
    blank.height = canvas.height;

    return canvas.toDataURL() == blank.toDataURL();
}


decoration_settings.setWidth.addEventListener('input', function () {
    changeSettings();
    this.nextElementSibling.textContent = this.value + "%";
});

decoration_settings.setHeight.addEventListener('input', function () {
    changeSettings();
    this.nextElementSibling.textContent = this.value + "%";
});

decoration_settings.btn_reset.addEventListener('click', resetSettings);

decoration_settings.setOX.addEventListener('input', changeSettings);
decoration_settings.setOY.addEventListener('input', changeSettings);

document.addEventListener('DOMContentLoaded', changeSize);
window.addEventListener("resize", changeSize);

btnBrowse.addEventListener('change', function () {
    if (originalUpload.files && originalUpload.files[0]) {
        var reader = new FileReader();
        var img = new Image();

        reader.readAsDataURL(originalUpload.files[0]);
        reader.onload = function (e) {
            img.src = e.target.result;
            img.width = canvas.width;
            img.height = canvas.height;
            img.onload = function () {
                drawMain(img, canvas_context);
            }
        };
    }
});

