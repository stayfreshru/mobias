<?php
$sApplicationId = '1805815853007767';
$sApplicationSecret = 'eff223831767392da00ebefc18b4ddd7';
$iLimit = 4;
?>
<!DOCTYPE html>
<html lang="en" xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
<meta charset="utf-8" />
  <title>ЗАГОЛОВОК СТРАНИЦЫ</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <script src="../js/custom-file-input.js"></script>
  <script src="../js/kinetic-v5.1.0.js"></script>
<script src="http://fabricjs.com/lib/fabric.js"></script>
</head>
<body>
<center>

<div id="container">
<div id="user-info"></div>
<img src="../images/ribbon.png" style="
margin-top: 4%">
<div>
<div id="container">
    <input type="file" id="imageLoader" name="imageLoader" />
    <canvas id="imageCanvas" width="800" height="400"></canvas> 
    <a id="imageSaver" href="#">Save image</a>
</div>




 </div>
 </div>
</center>
<div id="result_friends"></div>
<div id="fb-root"></div>
<script>
var canvas = new fabric.Canvas('imageCanvas', {
    backgroundColor: 'rgb(240,240,240)'
});

var imageLoader = document.getElementById('imageLoader');
imageLoader.addEventListener('change', handleImage, false);

function handleImage(e) {
    var reader = new FileReader();
    reader.onload = function (event) {
        var img = new Image();
        img.onload = function () {
            var imgInstance = new fabric.Image(img, {
                scaleX: 0.2,
                scaleY: 0.2
            })
            canvas.add(imgInstance);
        }
        img.src = event.target.result;
    }
    reader.readAsDataURL(e.target.files[0]);
}

var imageSaver = document.getElementById('imageSaver');
imageSaver.addEventListener('click', saveImage, false);

function saveImage(e) {
    this.href = canvas.toDataURL({
        format: 'jpeg',
        quality: 0.8
    });
    this.download = 'test.png'
}

</script>

</body>
</html>