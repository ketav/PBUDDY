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
  <title>Profile</title>
<script type="text/javascript" src="/pbuddy/resources/js/jquery-1.8.2.min.js"></script>  
 </head>
 <body>
 <?php
		echo "<script>\n";
		echo "var userID='".$user_id."'";
		echo  "</script>\n";
?>
    <div class="container">	
		<form action="insert.php?task=updateUserDetails" method="post">
		Name: <input type="text" id="name" name="name"><br>
		Gender: <input type="text" id="gender" name="gender"><br>
		Address: <input type="text" id="address" name="address"><br>
		<input type="submit">
		</form>
		<div class="photos">
		</div>
	</div><!-- container -->
	<script type="text/javascript">	
	$( document ).ready(function() {
	//window.location='http://localhost/pbuddy/insert.php?task=getUserDetails&userId='+userID;
				$.ajax({
						url: '/pbuddy/insert.php?task=getUserDetails&userId='+userID,						
						type: "GET",
						dataType: "html",
						success: function(data)
						{
						   var userDetails = $.parseJSON(data);
						   for( x=0;x<5;x++)
						   {								
								if( typeof userDetails[x] != 'undefined')
								{
									$('#name').val(userDetails[x].name);
									$('#gender').val(userDetails[x].sex);
									$('#address').val(userDetails[x].geography);
									$(document.createElement('img')).attr("width","400px").attr("height","400px").attr("id","photo"+x).attr("src",userDetails[x].photo_url).attr("data-photoID",userDetails[x].photo_id).appendTo('div.container div.photos');	
								}
						   }						  
						}						
						});				
						 
	});
	</script>
 </body>
</html>

