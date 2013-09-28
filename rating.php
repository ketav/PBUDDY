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
<script type="text/javascript" src="/pbuddy/resources/js/jquery.cycle.all.js"></script>
  <link href="/pbuddy/resources/css/ratingslider.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
		var ajaxCallBack = 0;
		var photoDetails;
		var photoIndex=0;
		var range = 5;
		var start = 1;
function getandInsertPhotosData()
				{
				$.ajax({
						url: '/pbuddy/insert.php?task=getDetails&userId="<?php echo $_SESSION['userId']; ?>"&start='+start+'&range='+range,						
						type: "GET",
						dataType: "html",
						success: function(data)
						{
						
						   photoDetails = $.parseJSON(data);
						   console.log(' Calling from first time');
						   insertPhotoData();
						   ajaxCallBack = 0;
						   $('.slideshow').cycle({
						   	fx: 'shuffle', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
							after:removePhotoData
							});
							$('.slideshow').cycle('pause');
							$('.slideshow').click(function(){
						   $('.slideshow').cycle('next');
						  updatephotoIndex();
							});
							$('.next').click(function(){
						   $('.slideshow').cycle('next');
						   updatephotoIndex();
							});
						}						
						});	}
			  function insertPhotoData()
			  {
			  /*src = $(".slideshow>img").attr('src');
			  pid = $(".slideshow>img").attr('data-photoID');
			  $('#slideshow').cycle('destroy');
			  $(".slideshow>img").remove();*/
			  if(typeof src!=='undefined')
			  $(document.createElement('img')).attr("width","400px").attr("height","400px").attr("src",src).attr("data-photoID",pid).appendTo('div.slideshow');	
				for( x=0;x<photoDetails.length;x++)
						   {
								if( typeof photoDetails[x] != 'undefined')
								{
										$(document.createElement('img')).attr("width","400px").attr("height","400px").attr("src",photoDetails[x].photo_url).attr("data-photoID",photoDetails[x].photo_id).appendTo('div.slideshow');
										console.log(photoDetails[x].photo_url);
								}
						   }
			  }		
		function removePhotoData()
		{
		if(ajaxCallBack!=0)
		{
			
			
	
			if(photoIndex==range-3)
			{
						photoIndex++;

			$('img.viewed').remove();
			start = start + 5;
			getandInsertPhotosData();
			console.log(photoIndex);
			return;
			}
			
			photoIndex++;
			if(photoIndex==5)
			{
				photoIndex=0;
			}
			console.log(photoIndex);
		}
		ajaxCallBack = 1;
		}
		function updatephotoIndex()
		{	
	}
        $(function () {
		
            $('.rating-enable').click(function () {               
                $('#example-e').barrating('show', {
                    showValues:true,
                    showSelectedRating:false,
                    onSelect:function(value, text) {
                        $.ajax({
						url: '/pbuddy/insert.php?task=updateRating&rating='+value+'&pid='+photoDetails[photoIndex].photo_id,						
						type: "GET",
						dataType: "html",
						success: function(data)
						{
							if(data!==1)
							{	
								updatephotoIndex();
							}
							if(data==1)
							{
							$('.slideshow').cycle('next');
							}
						},
						error: function()
						{
							
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
		<div class="slideshow" style="position: absolute; margin: 30px 370px;">
		
		</div>			
		<a href="#" class="next">skip</a>
		<div class="input select rating-e blue-pill deactivated rating-enable" style="margin: 510px 360px; position:absolute; background: none repeat scroll 0% 0% activeborder; width: 460px;">
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
				
						getandInsertPhotosData();
						
						 
	});

	</script>
<style type="text/css">
.slideshow img { padding: 15px; border: 1px solid #ccc; background-color: #eee; }
.rating-e .br-widget a {padding:20px !important;}
a.next{position: absolute; margin: 475px 565px;}
</style>
 </body>
</html>

