var comment_form = document.getElementsByClassName("form_comment");

function encodeHTML(str) {
    var buf = [];
    for (var i = str.length - 1; i >= 0; i--) {
        buf.unshift(['&#', str[i].charCodeAt(), ';'].join(''));
    }
    return buf.join('');
};

function sendComment(form) {
    form.comment.value = form.comment.value.trim();
    if (form.comment.value) {
        if (form.comment.value.length <= 120) {
            var data = new FormData();
            var xhr = new XMLHttpRequest();

            data.append('comment', form.comment.value);
            data.append('imageId', form.imageId.value);
            xhr.open('POST', '/gallery/comment/add', true);

            xhr.onreadystatechange = function () {
                if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                    if (this.response != 'ERROR') {
                        var commentsContainer = form.previousElementSibling;
                        var newComment = document.createElement('div');
                        var hrElem = document.createElement('hr');

                        if (commentsContainer.childElementCount / 2 === 3) {
                            commentsContainer.firstElementChild.remove();
                            commentsContainer.firstElementChild.remove();
                        }
                        hrElem.classList.add('gradient-line');

                        newComment.classList.add('row');
                        newComment.innerHTML = '<div class="col-2 text-success">' +
                            document.getElementById('user_login').innerText + '</div>' +
                            '<div class="col-10 pb-2"><span>' +
                            encodeHTML(form.comment.value) + '</span></div>';

                        commentsContainer.appendChild(hrElem);
                        commentsContainer.appendChild(newComment);
                        commentsContainer.appendChild(hrElem);

                        form.comment.value = "";
                    }
                    else {
                        //TODO: err msg
                    }

                }
            };

            xhr.send(data);
        }
        else {

        }
    }
}

[].forEach.call(comment_form, function (el) {
    el.btn_submit.addEventListener('click', function () {
        sendComment(el);
    });
});

