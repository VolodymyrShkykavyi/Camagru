var btnDelImage = document.querySelectorAll('.btn-del-img');
var btnDelImageSidebar = document.querySelectorAll('.btn-del-img-sidebar');

function deleteImage(event, elem=false) {
    event.preventDefault();
    if (confirm('Do you really want to delete this image?')) {
        let aTag = '';
        if (elem){
            aTag = elem.parentElement.parentElement;
        }
        else{
            aTag = this.parentElement.parentElement;
        }

        let path = '/gallery/image/';
        let id = aTag.href.substr(aTag.href.indexOf(path) + path.length);
        if (!id) {
            return;
        }
        let xhr = new XMLHttpRequest();
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

        let data = new FormData();
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
