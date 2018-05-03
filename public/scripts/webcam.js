var webcam = document.getElementById('video');
var canvas = document.getElementById('image-main');
var decoration = document.getElementById('image-decoration');
var canvas_context = canvas.getContext('2d');
var decoration_context = decoration.getContext('2d');
var decoration_settings = document.getElementById('decoration-settings');

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
            webcam.play();

        })
        .catch(function (err) {
            //TODO: display btn for load img
            canvas.innerText = err;
        });
}

webcam.addEventListener('play', function () {
    drawMain(this, canvas_context);
}, false);

//display first layer(camera/uploaded image)
function drawMain(video, context){
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    setTimeout(drawMain, 10, video, context);
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
    var allDecorations = Array.from(document.getElementById('decoration').getElementsByClassName('custom-radio'));
    for(var el in allDecorations) {
        if ((allDecorations[el].getElementsByTagName('input'))[0].checked) {
            drawDecoration(allDecorations[el]);
        }
    }
}

function uploadImage(){
    var dataURL = canvas.toDataURL("image/jpeg");
    console.log(dataURL);
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
        if (btnPhoto.classList.contains('btn-danger')) {
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

decoration_settings.setWidth.addEventListener('input', function () {
    changeSettings();
    this.nextElementSibling.textContent = this.value + "%";
});

decoration_settings.setHeight.addEventListener('input', function () {
    changeSettings();
    this.nextElementSibling.textContent = this.value + "%";
});

decoration_settings.setOX.addEventListener('input', changeSettings);
decoration_settings.setOY.addEventListener('input', changeSettings);

document.addEventListener('DOMContentLoaded', changeSize);
window.addEventListener("resize", changeSize);

