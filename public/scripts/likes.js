
function changeLike(el, id) {
    var data = new FormData();
    var xhr = new XMLHttpRequest();
    var type = 0;

    //if post liked
    if (el.classList.contains('fa-heart-o')){
        data.append('addLike', '1');
        type = 1;
    }
    else{
        data.append('delLike', '1');
        type = -1;
    }
    if (!id){
        return;
    }
    data.append('imageId', id);
    xhr.open('POST', '/gallery/change/like', true);
    xhr.onreadystatechange = function(){
        var localType = type;
        if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200){
          if (this.response == "OK"){
              var numLikes = el.previousElementSibling;
              numLikes.innerHTML = (parseInt(numLikes.innerHTML) + localType).toString();
              el.classList.toggle("fa-heart-o");
          }
      }
    };
    xhr.send(data);
}
