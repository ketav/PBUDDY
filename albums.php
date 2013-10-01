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
		<link rel="stylesheet" href="/pbuddy/resources/css/styleimg.css" type="text/css" />
			<link rel="stylesheet" href="/pbuddy/resources/css/avgrund.css">

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
		<style>
            *{
                margin:0;
                padding:0;
            }
            body{
                font-family:Georgia,Times,serif;
                background:#f0f0f0;
            }
            #content{
                background-color:#f6f6f6;
                width:750px;
                padding:40px 40px 80px 40px;
                margin:0 auto 40px auto;
				color:#fff;
                border-left:10px solid #0968A0;
                border-right:1px solid #444;
				-moz-box-shadow:0px 0px 10px #000;
				-webkit-box-shadow:0px 0px 10px #000;
				box-shadow:0px 0px 10px #000;
				-moz-border-radius:0px 0px 20px 20px;
				-webkit-border-bottom-left-radius:20px;
				-webkit-border-bottom-right-radius:20px;
				border-bottom-left-radius:20px;
				border-bottom-right-radius:20px;

            }
            .head, .meta a{
                font-family:Helvetica,Arial,Verdana;
                text-transform:uppercase;
                font-weight:bold;
                font-size:12px;
                letter-spacing:3px;
                color:#ccc;
                padding-bottom:10px;
                margin-bottom:10px;
				text-shadow:1px 1px 1px #fff;
				text-decoration: none;
            }
			.line{
				background-color:#ddd;
				border-bottom:1px solid #fff;
				height:1px;
				margin:0px 0px 15px 0px;
			}
            #content h1{
                color:#0968A0;
                font-weight:normal;
                font-size:56px;
                text-shadow:1px 1px 1px #fff;
            }
            .subline{
                font-size:22px;
                margin:20px 0px;
                color:#999;
				text-shadow:1px 1px 1px #fff;
            }
			.meta{
				text-align:right;
			}

			.meta a:hover{
				color:#aaa;
				
			}
            .article p{
                margin:20px 0px;
                line-height:26px;
                text-align:justify;
				color:#666;
				text-shadow:1px 1px 1px #fff;
            }
			.article a{
				color:#aaa;
				text-transform: uppercase;
				text-decoration: none;
				font-weight: bold;
			}
			.article a:hover{
				color:#0968A0;
			}

			.article p img.left{
				float:left;
				margin-right:20px;
			}
			.article p img.right{
				float:right;
				margin-left:20px;
			}

		</style>
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
		echo "var userID='".$user_id."'";
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
<div style="display:none;" class="ih_overlay" id="ih_overlay"></div>		
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
				  var HTML = "<a href='#'><img src='"+raw_data[x].source+"'data-large='"+raw_data[x].source+"' alt='" +raw_data[x].id+ "'/></a>";
				  $( document.createElement('li') ).html( HTML ).appendTo('div.es-carousel ul');
			}
			
});
		</script>
		<script type="text/javascript">
           
			
			function executeIframe()
			{
				$(function() {
				/**
				* timeout to control the display of the overlay/highlight
				*/
				var highlight_timeout;

				/**
				* user hovers one image:
				* create a absolute div with the same image inside,
				* and append it to the body
				*/
				$('img.ih_image').bind('mouseenter',function () {
						var $thumb = $(this);
						
						var $clone = $('<div />',{
							'id'		: 'ih_clone',
							'class': 'ih_image_clone_wrap',
							'html'     	: '<img src="'+$thumb.attr('src')+'" alt="'+$thumb.attr('alt')+'"/><span class="ih_zoom"></span>',
							'style'		: 'top:'+$thumb.offset().top+'px;left:'+$thumb.offset().left+'px; position:absolute;'
						});
						
						var highlight = function (){
							$('#ih_overlay').show();
							$('BODY').append($clone);
						}
						//show it after some time ... 
						highlight_timeout = setTimeout(highlight,700);

						/**
						* when we click on the zoom, 
						* we display the image in the center of the window,
						* and enlarge it to the size of the real image, 
						* fading this one in, after the animation is over.
						*/
						$clone.find('.ih_zoom').bind('click',function()
						{
						var imgsrc = $('.rg-image').find("img").attr("src");
						var imgid = $('.rg-image').find("img").attr("alt");
						//window.location='http://localhost/pbuddy/insert.php?task=insertPhoto&imgid='+imgid+'&src='+imgsrc+'&id='+userID;
						$.ajax({
						url: '/pbuddy/insert.php?task=insertPhoto&imgid='+imgid+'&src='+imgsrc+'&id='+userID,
						type: "GET",
						dataType: "html",
						success: function(data)
						{
						   //alert(data); // alert on success
						}
						});
						// Ajax call here
						/*
							var $zoom = $(this);
							$zoom.addClass('ih_loading').removeClass('ih_zoom');
							var imgL_source = $thumb.attr('alt');
							
							$('<img class="ih_preview" style="display:none;"/>').load(function(){
								var $imgL = $(this);
								$zoom.hide();
								var windowW = $(window).width();
								var windowH = $(window).height();
								var windowS = $(window).scrollTop();
								
								$clone.append($imgL).animate({
									'top'			: windowH/2 + windowS + 'px',
									'left'			: windowW/2  + 'px',
									'margin-left'	: -$thumb.width()/2 + 'px',
									'margin-top'	: -$thumb.height()/2 + 'px'
								},400,function(){
									var $clone = $(this);
									var largeW = $imgL.width();
									var largeH = $imgL.height();
									$clone.animate({
										'top'			: windowH/2 + windowS + 'px',
										'left'			: windowW/2  + 'px',
										'margin-left'	: -largeW/2 + 'px',
										'margin-top'	: -largeH/2 + 'px',
										'width'			: largeW + 'px',
										'height'		: largeH + 'px'
									},400).find('img:first').animate({
										'width'			: largeW + 'px',
										'height'		: largeH + 'px'
									},400,function(){
										var $thumb = $(this);
										/**
										* fade in the large image. Replace the zoom with a cross,
										* so the user can close the preview mode
										*//*
										$imgL.fadeIn(function(){
											$zoom.addClass('ih_close').removeClass('ih_loading').fadeIn(function(){
												$(this).bind('click',function(){
													$clone.remove();
													clearTimeout(highlight_timeout);
													$('#ih_overlay').hide();
												});
											});
											$thumb.remove();
										});
									});
								});
							}).error(function(){
								/**
								* error loading image. Maybe show a message : 'no preview available'?
								*//*
								$zoom.fadeOut();
							}).attr('src',imgL_source);
						*/});		
				}).bind('mouseleave',function(){
					/**
					* the user moves the mouse out of an image.
					* if there's no clone yet, clear the timeout
					* (user was probably scolling through the article, and 
					* doesn't want to view the image)
					*/
					if($('#ih_clone').length) return;
					clearTimeout(highlight_timeout);
				});
				
				/**
				* the user moves the mouse out of the clone.
				* if we don't have yet the cross option to close the preview, then
				* clear the timeout
				*/
				$('#ih_clone').live('mouseleave',function() 
			{
					var $clone = $('#ih_clone');
					if(!$clone.find('.ih_preview').length){
						$clone.remove();
						clearTimeout(highlight_timeout);
						$('#ih_overlay').hide();
					}
				}
			);
            });
			}
			
			
			
        </script>
		<script src="/pbuddy/resources/js/jquery.avgrund.js"></script>
		<script type="text/javascript" src="/pbuddy/resources/js/jquery.tmpl.min.js"></script>
		<script type="text/javascript" src="/pbuddy/resources/js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="/pbuddy/resources/js/jquery.elastislide.js"></script>
		<script type="text/javascript" src="/pbuddy/resources/js/gallery.js"></script>
 </body>
</html>

