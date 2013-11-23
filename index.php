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
  $params = array('scope' => 'user_status,publish_stream,user_photos,email');
?>
<html lang="en-gb">
<head>
  <meta charset="utf-8" />
  <title>2013 Photo Buddy</title>
  <!-- <meta name="apple-mobile-web-app-capable" content="yes" /> -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">  
  <script type="text/javascript" src="/pbuddy/resources/js/jquery-1.8.2.min.js"></script>
  <link rel="stylesheet" href="/PBUDDY/Resources/CSS/main.css" />
  <link rel="stylesheet" href="/PBUDDY/Resources/CSS/reset.css" />
  </head>
<body id="homePageDesign">
<?php
include 'header.php';
?>
<?php
    if($user_id) {
	 $_SESSION['userId']=$user_id;
	$user_profile = $facebook->api('/me?fields=id,name,age_range,hometown,email,gender','GET');
	$search = Array('"',"'","\r","\n","\r\n","\n\r");
	$replace =Array('\"',"\'","","","","");
	$user_profile = str_replace($search,$replace,$user_profile);
    $user_profile = json_encode($user_profile);
	
	
    } else {
      // No user, print a link for the user to login
      $login_url = $facebook->getLoginUrl($params);     
    }
  ?>
<div id="wrapper">
<div id="Body_Container">
	<div id="parentArticleBlockContainer">
	<span class="leftIcon"></span>
	<span class="rightIcon"></span>
	<span class="middleBg"></span
	<div class="articlemiddleContainer">
		<div class="content-main articleBlockContainer">
			<h1>Photo Buddy</h1>	
			<div class="mainRotator">
			<img src="http://sphotos-e.ak.fbcdn.net/hphotos-ak-frc3/s720x720/1069271_485636758195204_813076474_n.jpg"/>
			<div>		
		</div>
    </div> 
  </div>
  <div id="menu" style="display:none;">
    <ul class="site-nav clearfix">
      <li class="nav-golden">
	  <?php
	  if($user_id)
	  {
	  echo('<a href="rating.php">Rate Your Friend</a>');
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
<?php
include 'footer.php';
?>
<?php
	if(isset($user_profile))
	{
	echo "<script>\n";
	echo "var photoDetail = '".$user_profile."'";
	echo "</script>\n";
	}
?>	
<script type="text/javascript">
$(document).ready(function(){
if(typeof photoDetail !=='undefined')
{
var userDetail = $.parseJSON(photoDetail);
//window.location = '/pbuddy/insert.php?task=insertUser&name='+userDetail.name+'&sex='+userDetail.gender+'&userid='+userDetail.id+'&geo='+userDetail.location.name+'&email='+userDetail.email;
$.ajax({
url: '/pbuddy/insert.php?task=insertUser&name='+userDetail.name+'&sex='+userDetail.gender+'&userid='+userDetail.id+'&geo='+userDetail.hometown.name+'&email='+userDetail.email+'&age='+userDetail.age_range.min,
type: "GET",
						dataType: "html",
						success: function(data)
						{
						   //alert(data); // alert on success
						}
						});
}
}
);
</script>
 </body>
</html>

