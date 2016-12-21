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
<script src="../js/kinetic-v5.1.0.js"></script>
<script src="http://fabricjs.com/lib/fabric.js"></script>


</head>
<body>
<center>

<div id="container">
<img src="../images/ura.png" style="
margin-top: 4%">
 <a id="imageSaver" href="#">Save image</a>
<div id="user-info"></div>
<div id="santasupload">
    <canvas id="imageCanvas" width="400" height="200"></canvas> 
 <?php
	include("config.inc.php");

	// initialization
	$result_final = "";
	$counter = 0;

	// List of our known photo types
	$known_photo_types = array( 
						'image/pjpeg' => 'jpg',
						'image/jpeg' => 'jpg',
						'image/gif' => 'gif',
						'image/bmp' => 'bmp',
						'image/x-png' => 'png'
					);
	
	// GD Function List
	$gd_function_suffix = array( 
						'image/pjpeg' => 'JPEG',
						'image/jpeg' => 'JPEG',
						'image/gif' => 'GIF',
						'image/bmp' => 'WBMP',
						'image/x-png' => 'PNG'
					);

	// Fetch the photo array sent by preupload.php
	$photos_uploaded = $_FILES['photo_filename'];

	// Fetch the photo caption array
	$photo_caption = $_POST['photo_caption'];

	while( $counter <= count($photos_uploaded) )
	{
		if($photos_uploaded['size'][$counter] > 0)
		{
			if(!array_key_exists($photos_uploaded['type'][$counter], $known_photo_types))
			{
				$result_final .= "File ".($counter+1)." is not a photo<br />";
			}
			else
			{
				mysql_query( "INSERT INTO gallery_photos(`photo_filename`, `photo_caption`, `photo_category`) VALUES('0', '".addslashes($photo_caption[$counter])."', '".addslashes($_POST['category'])."')" );
				$new_id = mysql_insert_id();
				$filetype = $photos_uploaded['type'][$counter];
				$extention = $known_photo_types[$filetype];
				$filename = $new_id.".".$extention;

				mysql_query( "UPDATE gallery_photos SET photo_filename='".addslashes($filename)."' WHERE photo_id='".addslashes($new_id)."'" );

				// Store the orignal file
				copy($photos_uploaded['tmp_name'][$counter], $images_dir."/".$filename);

				// Let's get the Thumbnail size
				$size = GetImageSize( $images_dir."/".$filename );
				if($size[0] > $size[1])
				{
					$thumbnail_width = 100;
					$thumbnail_height = (int)(100 * $size[1] / $size[0]);
				}
				else
				{
					$thumbnail_width = (int)(100 * $size[0] / $size[1]);
					$thumbnail_height = 100;
				}
			
				// Build Thumbnail with GD 1.x.x, you can use the other described methods too
				$function_suffix = $gd_function_suffix[$filetype];
				$function_to_read = "ImageCreateFrom".$function_suffix;
				$function_to_write = "Image".$function_suffix;

				// Read the source file
				$source_handle = $function_to_read ( $images_dir."/".$filename ); 
				
				if($source_handle)
				{
					// Let's create an blank image for the thumbnail
				     	$destination_handle = ImageCreate ( $thumbnail_width, $thumbnail_height );
				
					// Now we resize it
			      	ImageCopyResized( $destination_handle, $source_handle, 0, 0, 0, 0, $thumbnail_width, $thumbnail_height, $size[0], $size[1] );
				}

				// Let's save the thumbnail
				$function_to_write( $destination_handle, $images_dir."/tb_".$filename );
				ImageDestroy($destination_handle );
				//

				$result_final .= "<canvas id='c'></canvas><img id='pic' src='".$images_dir. "/tb_".$filename."' /> <br />";
			}
		}
	$counter++;
	}

	// Print Result
echo <<<__HTML_END

<html>
<head>

	<title>Photos uploaded</title>
</head>
<body>

	$result_final
</body>
</html>

__HTML_END;
?>

  </div>
  <a id="imageSaver" href="#">Save image</a>
  <button id="fb-auth"><a href="/facebook/index/preupload.php">START</a></button>
        <br>
 </div>
</center>
<div id="result_friends"></div>
<div id="fb-root"></div>
<script>

var canvas = new fabric.Canvas('imageCanvas', {
    backgroundColor: 'rgb(240,240,240)'
});

var imageLoader = document.getElementById('pic');
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

//SAVE IMAGE
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

