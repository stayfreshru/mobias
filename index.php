<?php
$sApplicationId = '1805815853007767';
$sApplicationSecret = 'eff223831767392da00ebefc18b4ddd7';
?>
<!DOCTYPE html>
<html lang="en" xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
<meta charset="utf-8" />
  <title>ЗАГОЛОВОК СТРАНИЦЫ</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>


<div id="user-info"></div>
 <div id="container">
<img src="./images/start.png" style="
margin-top: 4%">
<button id="fb-auth" class="nybutton"><a href="/facebook/index/preupload.php">START</a></button>
 <br>
 
 </div>

<!--div id="result_friends"></div-->
<div id="fb-root"></div>
<script>
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