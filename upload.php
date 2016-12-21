<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:fb="https://www.facebook.com/2008/fbml">
 
 <head> 
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>ЗАГОЛОВОК СТРАНИЦЫ</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
 </head>

<body>
 <div id="fb-root">
 <script src="https://connect.facebook.net/ru_RU/all.js#xfbml=1"></script>
 </div>
  <script>
   window.fbAsyncInit = function() {
    FB.init({
             appId: '1805815853007767', //вставьте ID своего приложения
             status: true, //проверка статуса логина
             cookie: true, //разрешает куки для доступа серверу к сессии
             xfbml: true,  //парсинг XFBML
             oauth: true   //разрешает аутентификацию по стандарту OAuth 2.0
            });
    FB.Canvas.setAutoGrow(91);
   };
   (function() {
   var e = document.createElement('script'); e.async = true;
   e.src = document.location.protocol +
   '//connect.facebook.net/ru_RU/all.js';
   document.getElementById('fb-root').appendChild(e);
   }());
 </script>

 <div id="container">
        <br>
   <div> <a href="/facebook/upload.php">Incarca FOTO</div>
 
 </div>

</body>
</html>