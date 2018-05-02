var webcam = document.getElementById('video');
var canvas = document.getElementById('image-main');
var decoration = document.getElementById('image-decoration');
var context = canvas.getContext('2d');


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
    drawMain(this, context);
}, false);

function drawMain(video, context){
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    //TODO: del this
    canvas.style.transform = 'scale(-1, 1)';
    drawDecoration();

    setTimeout(drawMain, 10, video, context);
}

function drawDecoration() {
    var img = new Image;
    img.src = ('/public/img/border1.png');

    var cont = decoration.getContext('2d');
    cont.drawImage(img, 0,0, decoration.width + 10, decoration.height);
    console.log(decoration.offsetWidth + ", " + decoration.width);
    //cont.drawImage(webcam, 0, 0, canvas.width/2, canvas.height/2);
}

function changeSize(){
    var divContainer = document.getElementById('image-preview');
    canvas.height = canvas.offsetWidth * 0.75;
    canvas.width = canvas.offsetWidth;
    decoration.height = canvas.height;
    decoration.width = canvas.width;
    divContainer.style.height = decoration.height + 'px';
}

document.addEventListener('DOMContentLoaded', changeSize);

window.addEventListener("resize", changeSize);

// make a photo
document.getElementById("btn_photo").addEventListener("click", function () {
    var dataURL = canvas.toDataURL("image/jpeg");
    console.log(dataURL);

});

//save photo on server

