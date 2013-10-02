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
<link rel="stylesheet" href="/PBUDDY/Resources/CSS/main.css" />
<link rel="stylesheet" href="/PBUDDY/Resources/CSS/reset.css" />
<!-- bxSlider Javascript file -->
<script src="/pbuddy/resources/js/jquery.profilebxslider.js"></script>
<!-- bxSlider CSS file -->
<link href="/pbuddy/resources/css/jquery.profilebxslider.css" rel="stylesheet" /> 
 </head>
 <body id="homePageDesign">
 <?php
include 'header.php';
?>
 <?php
		echo "<script>\n";
		echo "var userID='".$user_id."'";
		echo  "</script>\n";
?>
    <div class="profilecontainer">	
		<div class="profilePhotoWrp">
		<div class="photos">
		<ul class="bxslider">
		</ul>
		</div>
		</div>
		<div class="profileForm">
		<form name="profileForm" id="profileForm" method="post">
		<h4>Edit Your Information</h4>
		<ul>
		<li><label>Name:</label><span><input type="text" id="name" name="name"></span></li>
		<li><label>Gender:</label><span><input type="text" id="gender" name="gender"></span></li>
		<li><label>Address:</label><span><input type="text" id="address" name="address"></span></li>
		<li><input type="button" id="edit" value="Edit"/><input type="button" id="submit" value="Submit"/></li>
		</ul>
		</form>
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
									$('#name').attr('disabled', true)
									$('#gender').val(userDetails[x].sex);
									$('#gender').attr('disabled', true)
									$('#address').val(userDetails[x].geography);
									$('#address').attr('disabled', true)
									var HTML = "<img id='photo"+x+"' src='"+userDetails[x].photo_url+"'/><span>Current Photo Rating:"+userDetails[x].avg_rating+"/10</span>";	
									$(document.createElement('li')).html(HTML).appendTo('div.photos ul.bxslider');
								}
						   }
						$('.bxslider').bxSlider();						   
						}						
						});		
$('#edit').click(function(){
$('#name').attr('disabled',false);
$('#gender').attr('disabled',false);
$('#address').attr('disabled',false);
});					
$('#submit').click(function(){
var name=$('#name').val();
var gender=$('#gender').val();
var address=$('#address').val();
$.ajax({
						url: '/pbuddy/insert.php?task=updateUserDetails&userId='+userID+'&name='+name+'&gender='+gender+'&address='+address,						
						type: "GET",
						dataType: "html",
						success: function(data)
						{
						$('#name').attr('disabled',true);
						$('#gender').attr('disabled',true);
						$('#address').attr('disabled',true);
						alert('Info Update');						
						}
		});	
	});
});
</script>
<?php
include 'footer.php';
?>
 </body>
</html>

