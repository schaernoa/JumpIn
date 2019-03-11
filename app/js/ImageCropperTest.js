
/// <reference path="../TypeScript/src/ImageCropper.ts"/>
var crop;
window.onload = function () {
    var canvas = document.getElementById("imageCanvas");
    var width = 200;
    var height = 200;
    crop = new ImageCropper(canvas, canvas.width / 2 - width / 2, canvas.height / 2 - height / 2, width, height, true);
    window.addEventListener('mouseup', preview);
    window.addEventListener('touchend', preview);
};
function preview() {
    if (crop.isImageSet()) {
        var img = crop.getCroppedImage(200, 200);
        img.onload = (function () { return previewLoaded(img); });
		img.id = "bild";
    }
}
function previewLoaded(img) {
    if (img) {
        document.getElementById("preview").appendChild(img);
		var imgsrc = document.getElementById("bild").src;
		document.getElementById("srcimg").value = imgsrc;
		document.getElementById("preview_text").style.display = "block";
    }
}
function handleFileSelect(evt) {
    var file = evt.target.files[0];
    var reader = new FileReader();
    var img = new Image();
    img.addEventListener("load", function () {
        crop.setImage(img);
        preview();
    }, false);
    reader.onload = function () {
        img.src = reader.result;
    };
    if (file) {
        reader.readAsDataURL(file);
		document.getElementById("imageCanvas").style.display = "block";
    }
}
document.getElementById('fileInput').addEventListener('change', handleFileSelect, false);
//# sourceMappingURL=ImageCropperTest.js.map