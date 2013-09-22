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
?>
<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php
    if($user_id) {

      // We have a user ID, so probably a logged in user.
      // If not, we'll get an exception, which we handle below.
      try {
		$accessToken = $facebook->getAccessToken();
        $albums = $facebook->api('/me/albums?fields=id,cover_photo,name','GET');
		$pictures = array();
		foreach ($albums['data'] as $album) {
			$pictures[$album['id']] = $album['cover_photo'];
			echo '<a href="/pbuddy/albums.php?id='.$album['id'].'"><img src="https://graph.facebook.com/'.$album['cover_photo'].'/picture?access_token='.$accessToken.'" title="'.$album['id'].'"/><div>'.$album['name'].'</div></a>';
		}
		
		
		/*$pictures = array();
		foreach ($albums['data'] as $album) {
		$pics = $facebook->api('/'.$album['cover_photo'].'?fields=source,picture');
		$pictures[$album['id']] = $pics['data'];
		}

  //display the pictures url
  foreach ($pictures as $album) {
    //Inside each album
    foreach ($album as $image) {
      $output .= $image['source'] . '<br />';
    }
  }*/		
        //echo "Name: " . $user_profile['name'];

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
 </body>
</html>

