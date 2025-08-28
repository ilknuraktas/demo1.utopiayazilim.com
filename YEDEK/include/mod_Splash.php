<?php
function splashScreen()
{
  if (!siteConfig('splash_active') || $_SESSION['splash_loaded'])
    return;

  global $siteConfig, $shopphp_demo, $tempCanChange;
  if ($shopphp_demo || $tempCanChange)
    $siteConfig['splash_padding'] = 40;
  $style = '
		<style>
			.open_splash {display: none;}
			.splash { width: 642px; overflow:hidden;}			
			.splash a {color: #000; text-decoration:none;}
			.splash a:hover {text-decoration:underline;}
			.splash .img {float: left; width: 100%; text-align: center; margin: 15px 0 30px 0;}	
			.splash .img img,#splash_body { max-width:592px; max-height:266px; }
			@media (max-width: 800px) {
				.splash  { width:100%; height:auto; }
				.splash img,#splash_body { max-width:calc(100% - 48px); float:left; height:auto; }
			}
			.fancybox-skin {
  padding: 0px !important
}

.splash {
  padding: ' . (int)siteConfig('splash_padding') . 'px !important;
}

.splash .img {
  margin: 0px !important;
}
.splash .img img, #splash_body {
    max-width: 100% !important;
    max-height: 100% !important;
    width: 100% !important;
    height: 100% !important;
    display: block;
}
		</style>
	';
  $js = '<script type="text/javascript">
			 //  $(window).load(function(){
				//	$.fancybox("#shopphp-auto-splash");
			  //}); 
			   $(function(){
                setTimeout( function(){
                    $.fancybox("#shopphp-auto-splash");
    },2000);

             
					
			  });
			  
			  
			  
	     </script>';
  $out = '<div class="open_splash"><div id="shopphp-auto-splash" class="splash">';
  if (siteConfig('splash_resim'))
    $out .= '<a href="' . siteConfig('splash_url') . '" class="img" style="height:auto;"><img src="images/' . siteConfig('splash_resim') . '" alt="Size bir kampanya haberimiz var!" /></a>';
  else
    $out .= '<div id="splash_body">' . siteConfig('splash_body') . '</div>';
  $out .= '</div></div><!-- #splash -->';
  $_SESSION['splash_loaded'] = 1;
  return $style . $js . $out;
}


echo splashScreen();
