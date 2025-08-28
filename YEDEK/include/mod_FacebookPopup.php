<?
function facebookFloating()
{
	if(isReallyMobile()) return;	
	return '
		<script type="text/javascript"> 
			/*<![CDATA[*/ jQuery(document).ready(function() {jQuery(".theblogwidgets").hover(function() {jQuery(this).stop().animate({right: "0"}, "medium");}, function() {jQuery(this).stop().animate({right: "-250"}, "medium");}, 500);}); /*]]>*/ 
		</script> 
			<style type="text/css"> 
				.theblogwidgets{background: url("https://3.bp.blogspot.com/-TaZRLv66f8g/UoMnTyTbF6I/AAAAAAAAAGY/U4qcf-SP6d0/TheBlogWidgets_facebook_widget.png") no-repeat scroll left center transparent !important; 
				float: right;height: 270px;padding: 0 5px 0 46px;width: 245px;z-index:  99999;position:fixed;right:-250px;top:20%;} 
				.theblogwidgets div{ padding: 0; margin-right:-8px; border:4px solid  #3b5998; background:#fafafa;} 
				.theblogwidgets span{bottom: 4px;font: 8px "lucida grande",tahoma,verdana,arial,sans-serif;position: absolute;right: 6px;text-align: right;z-index: 99999;} 
				.theblogwidgets span a{color: gray;text-decoration:none;} .theblogwidgets span a:hover{text-decoration:underline;} } 
			</style>
			<div class="theblogwidgets">
				<div>
					<iframe src="https://www.facebook.com/plugins/likebox.php?href='.urlencode(siteConfig('facebook_url')).'&width=245&colorscheme=light&show_faces=true&border_color=white&connections=9&stream=false&header=false&height=270" scrolling="no" frameborder="0" scrolling="no" style="border: white; overflow: hidden; height: 270px; width: 245px;background:#fafafa;color:000;"></iframe>
				</div>
			</div>
';
}

function facebookPopupMobile()
{
	
				$out = '
<style>
	#fbox-background {
		display: none;
		background: rgba(0,0,0,0.8);
		width: 100%;
		height: 100%;
		position: fixed;
		top: 0;
		left: 0;
		z-index: 99999;
	}
	#fbox-close {
		width: 100%;
		height: 100%;
	}
	#fbox-display {
		background: #eaeaea;
		border: 5px solid #828282;
		width: 350px;
		height: 210px;
		position: absolute;
		top: 32%;
		left: 50%;
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
		transform: translate(-50%, -50%);
	}
	#fbox-button {
		float: right;
		cursor: pointer;
		position: absolute;
		right: 0px;
		top: 0px;
	}
	#fbox-button:before {
		content: "KAPAT";
		padding: 5px 8px;
		background: #828282;
		color: #eaeaea;
		font-weight: bold;
		font-size: 10px;
		font-family: Tahoma;
	}
	#fbox-link, #fbox-link a.visited, #fbox-link a, #fbox-link a:hover {
		color: #aaaaaa;
		font-size: 9px;
		text-decoration: none;
		text-align: center;
		padding: 5px;
	}
	</style>
	<script type="text/javascript">
	jQuery(document).ready(function($){
	{
	$("#fbox-background").delay(1000).fadeIn("medium");
	$("#fbox-button, #fbox-close").click(function(){
	$("#fbox-background").stop().fadeOut("medium");
	});
	}
	});
	</script>
	<div id="fbox-background">
	  <div id="fbox-close"> </div>
	  <div id="fbox-display">
		<div id="fbox-button"> </div>
		<iframe allowtransparency="true" frameborder="0" scrolling="no" src="//www.facebook.com/plugins/likebox.php?
	href='.siteConfig('facebook_url').'&width=350&height=255&colorscheme=light&show_faces=true&show_border=false&stream=false&header=false"
	style="border: none; overflow: hidden; background: #fff; width: 350px; height: 200px; margin:auto;"></iframe>
	  </div>
	</div>';
	return $out;	
}

function facebookPopup()
{
	if(isReallyMobile()) return facebookPopupMobile();		
				$out = '
<style>
	#fbox-background {
		display: none;
		background: rgba(0,0,0,0.8);
		width: 100%;
		height: 100%;
		position: fixed;
		top: 0;
		left: 0;
		z-index: 99999;
	}
	#fbox-close {
		width: 100%;
		height: 100%;
	}
	#fbox-display {
		background: #eaeaea;
		border: 5px solid #828282;
		width: 500px;
		height: 210px;
		position: absolute;
		top: 32%;
		left: 37%;
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
	}
	#fbox-button {
		float: right;
		cursor: pointer;
		position: absolute;
		right: 0px;
		top: 0px;
	}
	#fbox-button:before {
		content: "KAPAT";
		padding: 5px 8px;
		background: #828282;
		color: #eaeaea;
		font-weight: bold;
		font-size: 10px;
		font-family: Tahoma;
	}
	#fbox-link, #fbox-link a.visited, #fbox-link a, #fbox-link a:hover {
		color: #aaaaaa;
		font-size: 9px;
		text-decoration: none;
		text-align: center;
		padding: 5px;
	}
	</style>
	<script type="text/javascript">
	jQuery(document).ready(function($){
	{
	$("#fbox-background").delay(1000).fadeIn("medium");
	$("#fbox-button, #fbox-close").click(function(){
	$("#fbox-background").stop().fadeOut("medium");
	});
	}
	});
	</script>
	<div id="fbox-background">
	  <div id="fbox-close"> </div>
	  <div id="fbox-display">
		<div id="fbox-button"> </div>
		<iframe allowtransparency="true" frameborder="0" scrolling="no" src="//www.facebook.com/plugins/likebox.php?
	href='.siteConfig('facebook_url').'&width=502&height=255&colorscheme=light&show_faces=true&show_border=false&stream=false&header=false"
	style="border: none; overflow: hidden; background: #fff; width: 500px; height: 200px;"></iframe>
	  </div>
	</div>';
	return $out;	
}
?>