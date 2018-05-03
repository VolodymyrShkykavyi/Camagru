var webcam = document.getElementById('video');
var canvas = document.getElementById('image-main');
var decoration = document.getElementById('image-decoration');
var canvas_context = canvas.getContext('2d');
var decoration_context = decoration.getContext('2d');
var decoration_settings = document.getElementById('decoration-settings');
var isWebCam = false;

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
function drawMain(img, context){
    if (img && img.src) {
        context.drawImage(img, 0, 0, canvas.width, canvas.height);
    }
    if (isWebCam){
        setTimeout(drawMain, 10, img, context);
    }
}

function drawDecoration(elem){
    decoration_context.clearRect(0, 0, decoration.width, decoration.height);
    var img = elem.getElementsByTagName('img')[0];
    var btnPhoto = document.getElementById("btn_photo");

    if (img && img.src) {
        var offsetX = decoration_settings.setOX.value;
        var offsetY = decoration_settings.setOY.value;
        var scaleWidth = decoration_settings.setWidth.value / 100;
        var scaleHeight = decoration_settings.setHeight.value / 100;

        decoration_context.drawImage(img, offsetX, offsetY,
            decoration.width * scaleWidth, decoration.height * scaleHeight);

        //unblock button for uploading image on server
        if (btnPhoto.classList.contains('btn-danger') && !isCanvasBlank(canvas)) {
            btnPhoto.classList.remove('btn-danger');
            btnPhoto.classList.add('btn-success');
            btnPhoto.innerText = 'Make Photo!';

            document.getElementById("btn_photo").addEventListener("click", uploadImage);
        }
    }
    else {
        //block button for uploading image on server
        if (btnPhoto.classList.contains('btn-success')){
            btnPhoto.classList.add('btn-danger');
            btnPhoto.classList.remove('btn-success');
            btnPhoto.innerText = 'Select one effect';

            document.getElementById('btn_photo').removeEventListener('click', uploadImage);
        }
    }
}

//change size of both layers(webcam and decoration)
function changeSize(){
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
    for(var el in allDecorations) {
        if ((allDecorations[el].getElementsByTagName('input'))[0].checked) {
            drawDecoration(allDecorations[el]);
        }
    }
}

function resetSettings() {
    var event = new Event('input', {bubbles:true});
    decoration_settings.reset();
    decoration_settings.setWidth.dispatchEvent(event);
    decoration_settings.setHeight.dispatchEvent(event);
    decoration_settings.setOX.dispatchEvent(event);
    decoration_settings.setOY.dispatchEvent(event);
}

//upload image on server
function uploadImage(){
    if (isCanvasBlank(canvas) || isCanvasBlank(decoration)){
        return;
    }
    var xhr = new XMLHttpRequest();
    var data = new FormData();
    var btnLoader = document.getElementById('btn_loader');
    var btnSubmit = document.getElementById('btn_photo');

    data.append('layer1', canvas.toDataURL("image/png"));
    data.append('layer2', decoration.toDataURL("image/png"));
    xhr.open('POST', '/montage/upload', true);
    xhr.onreadystatechange = function(){
        if (xhr.readyState = XMLHttpRequest.LOADING){
            btnLoader.style.display = 'block';
            btnSubmit.style.display = 'none';
        }
        if (xhr.readyState == XMLHttpRequest.DONE){
          btnLoader.style.display = 'none';
          btnSubmit.style.display = 'block';
          if (xhr.status == 200 && this.response && this.response != 'ERROR'){
              //TODO: show btn, add img
              console.log(this.response);
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

if (document.getElementById('btn_load')){
    var btnBrowse = document.getElementById("btn_browse");
    var originalUpload = btnBrowse.children[1];

    document.getElementById('btn_load').addEventListener('click', function () {
        if (originalUpload.files && originalUpload.files[0]){
            var reader = new FileReader();
            var img = new Image();

            reader.readAsDataURL(originalUpload.files[0]);
            reader.onload = function (e) {
                img.src = e.target.result;
                img.width = canvas.width;
                img.height = canvas.height;
                img.onload = function() {
                    drawMain(img, canvas_context);
                }
            };

        }
    });
}
