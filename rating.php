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
  <title>Photo Rating</title>
<script type="text/javascript" src="/pbuddy/resources/js/jquery-1.8.2.min.js"></script>  
<script type="text/javascript" src="/pbuddy/resources/js/barrating.js"></script>
<script type="text/javascript" src="http://malsup.github.com/jquery.cycle.all.js"></script>
  <link href="/pbuddy/resources/css/ratingslider.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
        $(function () {
            $('.rating-enable').click(function () {               
                $('#example-e').barrating('show', {
                    showValues:true,
                    showSelectedRating:false,
                    onSelect:function(value, text) {
                        $.ajax({
						url: '/pbuddy/insert.php?task=updateRating&rating='+value+'&pid='+$(".slideshow").children('img:visible').attr("data-photoid"),						
						type: "GET",
						dataType: "html",
						success: function(data)
						{
						alert(data);
						}
						});
                    }
                });
				
				$(this).addClass('deactivated');
                $('.rating-disable').removeClass('deactivated');
            });
			$('.rating-enable').trigger('click');
        });
    </script>
 </head>
 <body>
    <div class="container">
		<div class="slideshow">
		
		</div>		
		<a href="#" class="next">skip</a>
		<div class="input select rating-e blue-pill deactivated rating-enable">
            <select style="display: none;" id="example-e" name="rating">
                <option selected="selected" value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
            </select>
        </div>
	</div><!-- container -->
	<script type="text/javascript">	
	$( document ).ready(function() {
				$.ajax({
						url: '/pbuddy/insert.php?task=getDetails',						
						type: "GET",
						dataType: "html",
						success: function(data)
						{
						   var photoDetails = $.parseJSON(data);
						   for( x=0;x<5;x++)
						   {
								
								if( typeof photoDetails[x] != 'undefined')
								{
										$(document.createElement('img')).attr("id","photo"+x).attr("src",photoDetails[x].photo_url).attr("data-photoID",photoDetails[x].photo_id).appendTo('div.slideshow');
	
								}
						   }
						   $('.slideshow').cycle({
						   	fx: 'shuffle' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
							});
								$('.slideshow').cycle('pause');
							$('.slideshow').click(function(){
						   $('.slideshow').cycle('next');
							});
							$('.next').click(function(){
						   $('.slideshow').cycle('next');
							});
						}						
						});						
						 
	});

	</script>
<style type="text/css">
.slideshow img { padding: 15px; border: 1px solid #ccc; background-color: #eee; }
</style>
 </body>
</html>

