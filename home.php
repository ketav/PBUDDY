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
		<!-- 
			This carousel example is created with jQuery and the carouFredSel-plugin.
			http://jquery.com
			http://caroufredsel.dev7studios.com
		-->

		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1" />
		<meta name="description" value="This examples creates a grid of 9 images centered in the viewport. Each of the 9 images is animated separately to create an amazing effect. It can scroll both horizontal and vertical, try clikcing the left, right, up and down buttons." />
		<meta name="keywords" value="grid, images, slideshow, carousel, left, right, up, down" />
		<title>Slideshow with grid of 9 separately animated images</title>
        <link rel="stylesheet" href="/PBUDDY/Resources/CSS/albumCarousel.css" />
		<link rel="stylesheet" href="/PBUDDY/Resources/CSS/main.css" />
		<link rel="stylesheet" href="/PBUDDY/Resources/CSS/reset.css" /> 
		<script src="Resources/js/jquery-1.8.2.min.js" type="text/javascript"></script>
		<script src="Resources/js/jquery.carouFredSel-6.2.0-packed.js" type="text/javascript"></script>
		
</head>
<body>
<?php
include 'header.php';
?>

 <?php
    if($user_id) {
      // We have a user ID, so probably a logged in user.
      // If not, we'll get an exception, which we handle below.
      try {
		$accessToken = $facebook->getAccessToken();
        $albums = $facebook->api('/me/albums?fields=id,cover_photo,name','GET');
		$pictures = array();
		echo "<script>\n";
		echo "var cover_photo='".json_encode($albums)."';\n";
		echo "var access_token='".$accessToken."';\n";
		echo  "</script>\n";
		/*foreach ($albums['data'] as $album) {
			//$pictures[$album['id']] = $album['cover_photo'];
			//echo '<a href="/pbuddy/albums.php?id='.$album['id'].'"><img src="https://graph.facebook.com/'.$album['cover_photo'].'/picture?access_token='.$accessToken.'" title="'.$album['id'].'"/><div>'.$album['name'].'</div></a>';
		}*/
		
		
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
  <div id="Cwrapper">
			<div id="inner" class="horizontal">
				<div id="carousel">
					
				</div>
			</div>
			<a href="#" id="left"></a>
			<a href="#" id="right"></a>
			<!--<a href="#" id="up"></a>
			<a href="#" id="down"></a> -->
		</div>
		<?php include 'footer.php'?>
 		<script type="text/javascript" language="javascript">
		$( document ).ready(function() {		
		var raw_data = $.parseJSON(cover_photo).data;
		for ( item in raw_data)
		{
		   if(typeof raw_data[item].cover_photo === 'undefined')
		   {
			
			raw_data.splice(item,1);
		   }		   
		} 	
		for ( x=0; x<raw_data.length;x++)
			{
			      if((x==0)||(x%9 ==0))
				  {
				  $( document.createElement('div') ).attr( "class", "divc"+parseInt((x+1)/9).toString()).appendTo('div#carousel');
				  if(x===0)
				  {
				  $("div.divc0").attr("style","margin-right : 0px;");
				  }
				  else
				  {
					$("div.divc"+parseInt((x+1)/9).toString()).attr("style","margin-right : 0px;");
				  }
				  }	
				  
				  var HTML = "<a href='/pbuddy/albums.php?id="+raw_data[x].id+"'><img src='https://graph.facebook.com/"+raw_data[x].cover_photo+"/picture?access_token="+access_token+"'><span>"+raw_data[x].name+"</span></a>";
				  $( document.createElement('div')).attr("class","t"+((x%9)+1)).html( HTML ).appendTo('div.divc'+parseInt(x/9).toString());
	
			}
});
		</script>
<script type="text/javascript">
		var currentDisplayed = 'first';
		var currentIndex = 0;
			$(function() {

				function animateThumbs( direction, $item, val, opacity ) {
					var ani = {
						opacity: opacity
					};
					ani[ getMarginProperty() ] = val;

					if ( direction == 'next' ) {
						var x1 = '.t1',
							x2 = '.t2, .t4',
							x3 = '.t3, .t5, .t7',
							x4 = '.t6, .t8',
							x5 = '.t9';
					} else {
						var x1 = '.t9',
							x2 = '.t6, .t8',
							x3 = '.t3, .t5, .t7',
							x4 = '.t2, .t4',
							x5 = '.t1';
					}

					$(x1, $item).delay( _duration * 0    ).animate( ani, _duration );
					$(x2, $item).delay( _duration * 0.25 ).animate( ani, _duration );
					$(x3, $item).delay( _duration * 0.5  ).animate( ani, _duration );
					$(x4, $item).delay( _duration * 0.75 ).animate( ani, _duration );
					$(x5, $item).delay( _duration * 1    ).animate( ani, _duration );
				}
				function getMarginProperty() {
					return ( _orientation == 'horizontal' ) ? 'marginLeft' : 'marginTop';
				}
				function getMargin( direction ) {
					var margin = ( $window[ ( _orientation == 'horizontal' ) ? 'width' : 'height' ]() / 2 ) + 210
					if ( direction == 'next' )
					{
						margin = -margin;
					}
					return margin;
				}

				var $window = $(window),
					$inner = $('#inner'),
					$carousel = $('#carousel');

				var _orientation = 'horizontal',
					_duration = 600,
					_animating = false;

				$inner.show();
				$carousel.carouFredSel({
					width: '100%',
					height: '100%',
					direction: 'left',
					items: 1,
					auto: false,
					scroll: {
						fx: 'none',
						timeoutDuration: 3000,
						conditions: function( direction ) {

							_animating = true;

							if ( $carousel.hasClass( 'prepared' ) )
							{
								$carousel.removeClass( 'prepared' );
								return true;
							}

							$carousel.addClass( 'prepared' );

							animateThumbs( direction, $carousel.children().first(), getMargin( direction ), 0 );

							setTimeout(
								function() {
									$carousel.trigger( direction );
								}, _duration + 800
							);

							return false;
						},
						onBefore: function( data ) {
							var direction = data.scroll.direction;

							var css = {
								opacity: 0
							};
							css[ getMarginProperty() ] = -getMargin( direction );

							$('div', data.items.visible).css( css );
							animateThumbs( direction, data.items.visible, 0, 1 );
						},
						onAfter: function( data ) {
							data.items.old.children().css({
								'marginLeft': 0,
								'marginTop': 0
							});

							setTimeout(
								function() {
									_animating = false;
								}, _duration + 800
							);
						}
					}
				});

				$('#left, #right, #up, #down').click(function() {
					if ( _animating ) {
						return false;
					}

					var direction = this.id,
						scroll = ( direction == 'up' || direction == 'left' ) ? 'next' : 'prev',
						newOrientation = ( direction == 'up' || direction == 'down' ) ? 'vertical' : 'horizontal';
					
					if ( _orientation != newOrientation ) {
						_orientation = newOrientation;
						$inner.toggleClass( 'horizontal' ).toggleClass( 'vertical' );
						$carousel.trigger( 'configuration', [ 'direction', direction ] );
					}
					$carousel.trigger( scroll );
					
					return false;
				});
			});
		</script>
 </body>
</html>

