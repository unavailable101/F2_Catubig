let profilePic = document.getElementById("profile-pic");
let imageFile = document.getElementById("update-image");

imageFile.onchange = function(){
    profilePic.src = URL.createObjectURL(imageFile.files[0]);
}