var btnDelImage = document.querySelectorAll('.btn-del-img');

function deleteImage(event) {
    event.preventDefault();
    if (confirm('Do you really want to delete this image?')) {
        var aTag = this.parentElement.parentElement;
        var id = aTag.href.substr(aTag.href.indexOf('id=') + 3);
        if (!id) {
            return;
        }
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/gallery/delete', true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                if (this.response === 'OK') {
                    aTag.parentElement.remove();
                }
                else if (this.response === 'ERROR') {
                    alert('Error. Can`t delete this image.');
                }
            }
        };

        var data = new FormData();
        data.append('delId', id);
        xhr.send(data);
    }
}
if (btnDelImage) {
    [].forEach.call(btnDelImage, function (el) {
        el.addEventListener('click', deleteImage);
    });
}