<!doctype html>
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
<html lang="en-gb">
<head>
  <meta charset="utf-8" />
  <title>2013 Photo Buddy</title>
  <!-- <meta name="apple-mobile-web-app-capable" content="yes" /> -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">  
    <link rel="stylesheet" href="/PBUDDY/Resources/CSS/main.css" />
  </head>
<body class="landing-page en-gb">
<?php
    if($user_id) {
    } else {
      // No user, print a link for the user to login
      $login_url = $facebook->getLoginUrl($params);     
    }
  ?>
  <div id="splash-content">
<div class="splash-focus">
  <div class="splash-header">
    <div class="brand">
      <img src="/PBUDDY/Resources/images/splash-logo.png" width="148" height="148" alt="">
      <h1>Photo Buddy</h1>
      <h2>Rate your buddies</h2>
    </div> 
  </div>
  <div id="menu">
    <ul class="site-nav clearfix">
      <li class="nav-golden">
	  <?php
	  if($user_id)
	  {
	  echo('<a href="en-gb/golden-tweets.html">Rate Your Friend</a>');
	  }
	  else
	  {
	  echo('<a href="'.$login_url.'">Rate Your Friend</a>');
	  }
	  ?>
	  </li>
      <li class="nav-pulse">
	  <?php
	  if($user_id)
	  {
	  echo('<a href="en-gb/global-town-square.html">People From Your Area</a>');
	  }
	  else
	  {
	  echo('<a href="'.$login_url.'">People From Your Area</a>');
	  }
	  ?>
	  </li>
      <li class="nav-only">
	  <?php
	  if($user_id)
	  {
	  echo('<a href="en-gb/only-on-twitter.html">Top Photos Of Month</a>');
	  }
	  else
	  {
	  echo('<a href="'.$login_url.'">Top Photos Of Month</a>');
	  }
	  ?>
	  </li>
      <li class="nav-my">
	  <?php
	  if($user_id)
	  {
	  echo('<a href="en-gb/your-year.html?section=index">Overall Leaders</a>');
	  }
	  else
	  {
	  echo('<a href="'.$login_url.'">Overall Leaders</a>');
	  }
	  ?>
	  </li>
	  <li class="nav-upload">
	   <?php
	  if($user_id)
	  {
	  echo('<a href="/pbuddy/home.php">Upload Photo</a>');
	  }
	  else
	  {
	  echo('<a href="'.$login_url.'">Upload Photo</a>');
	  }
	  ?>
	  </li>
    </ul>
  </div>
</div> 
</div> 
 </body>
</html>

