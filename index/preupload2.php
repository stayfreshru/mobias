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
</head>
<body>
<center>

<div id="container">
<div id="user-info"></div>
<img src="../images/ribbon.png" style="
margin-top: 4%">
<div>
 <?php
	include("config.inc.php");

	// initialization
	$photo_upload_fields = "";
	$counter = 1;

	// default number of fields
	$number_of_fields = 5; 

// If you want more fields, then the call to this page should be like, 
// preupload.php?number_of_fields=20

	if( $_GET['number_of_fields'] )
	$number_of_fields = (int)($_GET['number_of_fields']);

	// Firstly Lets build the Category List

	$result = mysql_query( "SELECT category_id,category_name FROM gallery_category" );
	while( $row = mysql_fetch_array( $result ) )
	{
$photo_category_list .=<<<__HTML_END
	<option value="$row[0]">$row[1]</option>\n
__HTML_END;
	}
	mysql_free_result( $result );	

// Lets build the Photo Uploading fields
	while( $counter <= $number_of_fields )
	{
$photo_upload_fields .=<<<__HTML_END
<tr>
	    <input id='photo{$counter}' name=' photo_filename[]' type='file' class='inputfile' data-multiple-caption='{count} files selected' multiple />
	    <label id='photo{$counter}' for='photo{$counter}'><span>Prieten {$counter}</span></label>
</tr>
<tr>
</tr>
__HTML_END;
	$counter++;
	}

// Final Output
echo <<<__HTML_END
<html>
<head>
	<title>Lets upload Photos</title>
</head>
<body>
<form enctype='multipart/form-data' id='santas' action='upload.php' method='post' name='upload_form'>
<table width='90%' border='0' align='center' style='width: 90%;'>


<!-Insert the photo fields here -->
$photo_upload_fields

</table>
<button id="fb-auth" class="uploas"><a type='submit' name='submit' value='Add Photos'>Încarcă foto</a></button> 
</form>
</body>
</html>
__HTML_END;
?>
 </div>
 </div>
</center>
<div id="result_friends"></div>
<div id="fb-root"></div>
<script>
var inputs = document.querySelectorAll( '.inputfile' );
Array.prototype.forEach.call( inputs, function( input )
{
	var label	 = input.nextElementSibling,
		labelVal = label.innerHTML;

	input.addEventListener( 'change', function( e )
	{
		var fileName = '';
		if( this.files && this.files.length > 1 )
			fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
		else
			fileName = e.target.value.split( '\\' ).pop();

		if( fileName )
			label.querySelector( 'span' ).innerHTML = fileName;
		else
			label.innerHTML = labelVal;
	});
});

function sortMethod(a, b) {
var x = a.name.toLowerCase();
var y = b.name.toLowerCase();
return ((x < y) ? -1 : ((x > y) ? 1 : 0));
}
window.fbAsyncInit = function() {
FB.init({ appId: '<?= $sApplicationId ?>', 
status: true, 
cookie: true,
xfbml: true,
oauth: true
});
function updateButton(response) {
var button = document.getElementById('fb-auth');
if (response.authResponse) { // in case if we are logged in
var userInfo = document.getElementById('user-info');
FB.api('/me', function(response) {
userInfo.innerHTML = '<img src="https://graph.facebook.com/' + response.id + '/picture">' + response.name;
});
// get friends
FB.api('me/posts/?fields=likes{id}', function(response) {
var result_holder = document.getElementById('result_friends');
var friend_data = response.data.sort(sortMethod);
var results = '';
for (var i = 0; i < friend_data.length; i++) {
results += '<div><img src="https://graph.facebook.com/' + friend_data[i].id + '/picture">' + friend_data[i].name + '</div>';
}
// and display them at our holder element
result_holder.innerHTML = '<h2>Result list of your friends:</h2>' + results;
});
button.onclick = function() {
FB.logout(function(response) {
window.location.reload();
});
};
} else { // otherwise - dispay login button
button.onclick = function() {
FB.login(function(response) {
if (response.authResponse) {
window.location.reload();
}
}, {scope:'email'});
}
}
}
// run once with current status and whenever the status changes
FB.getLoginStatus(updateButton);
FB.Event.subscribe('auth.statusChange', updateButton);    
};
(function() {
var e = document.createElement('script'); e.async = true;
e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
document.getElementById('fb-root').appendChild(e);
}());

</script>

</body>
</html>