let eventPic = document.getElementById("preview-pic");
let eventPicFile = document.getElementById("pic-event");
eventPicFile.onchange = function(){
    eventPic.src = URL.createObjectURL(eventPicFile.files[0]);
}