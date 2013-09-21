<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>

<div class="fb-login-button" data-width="200"></div>
<div id="fb-root"></div>
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=188647124563048";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
 <?php echo '<p>Hello World</p>'; ?> 
 </body>
</html>

