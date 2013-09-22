<?php
  // Remember to copy files from the SDK's src/ directory to a
  // directory in your application on the server, such as php-sdk/
  require_once('php-sdk/src/facebook.php');

  $config = array(
    'appId' => '188647124563048',
    'secret' => 'dd9e0b9c9ee31990f0f12744fe88892d',
	'cookie' => true
  );

  $facebook = new Facebook($config);
  $user_id = $facebook->getUser(); 
  $params = array('scope' => 'user_status,publish_stream,user_photos');
  parse_str($_SERVER['QUERY_STRING']);  
?>
<html>
 <head>
  <title>Album Details</title>
  <script type="text/javascript" src="/pbuddy/resources/js/jquery-1.8.2.min.js"></script>
  <link rel="stylesheet" type="text/css" href="/pbuddy/resources/css/demo.css" />
		<link rel="stylesheet" type="text/css" href="/pbuddy/resources/css/style.css" />
		<link rel="stylesheet" type="text/css" href="/pbuddy/resources/css/elastislide.css" />
  <noscript>
			<style>
				.es-carousel ul{
					display:block;
				}
			</style>
		</noscript>
		<script id="img-wrapper-tmpl" type="text/x-jquery-tmpl">	
			<div class="rg-image-wrapper">
				{{if itemsCount > 1}}
					<div class="rg-image-nav">
						<a href="#" class="rg-image-nav-prev">Previous Image</a>
						<a href="#" class="rg-image-nav-next">Next Image</a>
					</div>
				{{/if}}
				<div class="rg-image"></div>
				<div class="rg-loading"></div>
				<div class="rg-caption-wrapper">
					<div class="rg-caption" style="display:none;">
						<p></p>
					</div>
				</div>
			</div>
		</script>
 </head>
 <body>
 <?php
    if($user_id) {
      // We have a user ID, so probably a logged in user.
      // If not, we'll get an exception, which we handle below.
      try {

        $photos = $facebook->api('/'.$id.'?fields=photos.fields(source)&limit=0 ','GET');
		echo "<script>\n";
		echo "var photos='".json_encode($photos)."';\n";
		echo  "</script>\n";
		/*foreach ($photos['photos']['data'] as $photo) {
			echo '<img src="'.$photo['source'].'"/>';
		}*/
	
      } catch(FacebookApiException $e) {
        // If the user is logged out, you can have a 
        // user ID even though the access token is invalid.
        // In this case, we'll get an exception, so we'll
        // just ask the user to login again here.
        $login_url = $facebook->getLoginUrl($params); 
        echo 'Please <a href="' . $login_url . '">login.</a>';
        error_log($e->getType());
        error_log($e->getMessage());
      }   
    } else {
      // No user, print a link for the user to login
      $login_url = $facebook->getLoginUrl($params);
      echo 'Please <a href="' . $login_url . '">login.</a>';
    }
  ?>
  	
  <div class="container">
  <div class="content">
				<h1>Image Gallery <span>- Choose Your Image</span></h1>
				<div id="rg-gallery" class="rg-gallery">
					<div class="rg-thumbs">
						<!-- Elastislide Carousel Thumbnail Viewer -->
						<div class="es-carousel-wrapper">
							<div class="es-nav">
								<span class="es-nav-prev">Previous</span>
								<span class="es-nav-next">Next</span>
							</div>
							<div class="es-carousel">
								<ul>
								</ul>
							</div>
						</div>
						<!-- End Elastislide Carousel Thumbnail Viewer -->
					</div><!-- rg-thumbs -->
				</div><!-- rg-gallery -->
		</div><!-- content -->
		</div><!-- container -->		
		<script type="text/javascript">	
	$( document ).ready(function() {
		var raw_data = $.parseJSON(photos).photos.data;
		for ( item in raw_data)
		{
		   if(typeof raw_data[item].source === 'undefined')
		   {
			raw_data.splice(item,1);
		   }
		} 	
		for ( x=0; x<raw_data.length;x++)
			{
				  var HTML = "<a href='#'><img src='"+raw_data[x].source+"'data-large='"+raw_data[x].source+"'/></a>";
				  $( document.createElement('li') ).html( HTML ).appendTo('div.es-carousel ul');
			}
			
});
		</script>
		<script type="text/javascript" src="/pbuddy/resources/js/jquery.tmpl.min.js"></script>
		<script type="text/javascript" src="/pbuddy/resources/js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="/pbuddy/resources/js/jquery.elastislide.js"></script>
		<script type="text/javascript" src="/pbuddy/resources/js/gallery.js"></script>
 </body>
</html>

