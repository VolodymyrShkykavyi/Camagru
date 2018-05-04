let btnDelImage = document.querySelectorAll('.btn-del-img');
let btnDelImageSidebar = document.querySelectorAll('.btn-del-img-sidebar');

function deleteImage(event, elem=false) {
    event.preventDefault();
    if (confirm('Do you really want to delete this image?')) {
        var aTag = '';
        if (elem){
            aTag = elem.parentElement.parentElement;
        }
        else{
            aTag = this.parentElement.parentElement;
        }

        var path = '/gallery/image/';
        var id = aTag.href.substr(aTag.href.indexOf(path) + path.length);
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

if (btnDelImageSidebar) {
    [].forEach.call(btnDelImageSidebar, function (el) {
        el.addEventListener('click', deleteImage);
    });
}
if (btnDelImage) {
    [].forEach.call(btnDelImage, function (el) {
        el.addEventListener('click', deleteImage);
    });
}
