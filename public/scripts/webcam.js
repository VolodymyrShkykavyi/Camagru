var webcam = document.getElementById('video');
var webcamStyles = getComputedStyle(webcam);
var canvas = document.getElementById('canvas');
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
            //some error
        });
}

// make a photo
document.getElementById("btn_photo").addEventListener("click", function () {
    var photoWidth = parseFloat(webcamStyles.width);
    var photoHeight = parseFloat(webcamStyles.height);
    canvas.width = photoWidth;
    canvas.height = photoHeight;
    context.drawImage(webcam, 0, 0, photoWidth, photoHeight);
});

//save photo on server

var dataURL = canvas.toDataURL("image/png");
console.log(dataURL);
