<?
if(!$JSSources['jquery-ui'])
{
	$modHizliIletisim = '
		<script type="text/javascript" src="js/jquery-ui.js"></script> 
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-lightness/jquery-ui.css" type="text/css" media="all" />';
	$JSSources['jquery-ui'] = 1;
}
$modHizliIletisim.='
<style>
#mod-telefon { cursor:pointer; }
.dform { z-index:10000; }
.dform label, .dform input { display:block; }
		.dform input.text { margin-bottom:12px; width:95%; padding: .4em; }
		.dform fieldset { padding:0; border:0; margin-top:25px; }
		.dform h1 { font-size: 1.2em; margin: .6em 0; }

</style>
<div id="dialog-form" title="Sizi Arayalım">
	<form class="dform">
	<fieldset>
		<label for="name">Adınız</label>
		<input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all" />
        <div style="clear:both"></div>
		<label for="email">E-Posta Adresiniz</label>
		<input type="text" name="email" id="xemail" value="" class="text ui-widget-content ui-corner-all" />
        <div style="clear:both"></div>
		<label for="password">Telefon Numaranız</label>
		<input type="text" name="tel" id="tel" value="" class="text ui-widget-content ui-corner-all" />
		<input type="hidden" name="xurunID" id="xurunID" value="'.$_GET['urunID'].'" />
        <div style="clear:both"></div>
	</fieldset>
	</form>
</div>



<script>
$( "#dialog:ui-dialog" ).dialog( "destroy" );

$( "#dialog-form" ).dialog({
			autoOpen: false,
			height: 380,
			width: 350,
			modal: true,
			buttons: {
				"Gönder": function() {
				   if($( "#name" ).val().length < 5)
						alert(\'Lütfen Adınızı Girin.\');
				   else if (!Validate_Email_Address($( "#xemail" ).val()))
				   		alert(\'Hatalı E-posta Adresi.\');
				   else if($( "#tel" ).val().length < 5)
						alert(\'Hatalı Telefon Numarası.\');
				   else
				   { 					
					   $.ajax({
						  url: \'include/ajaxLib.php?act=quickContact&urunID=\'+$(\'#xurunID\').val()+\'&namelastname=\'+$( "#name" ).val()+\'&ceptel=\'+$( "#tel" ).val() + \'&email=\' + $( "#xemail" ).val(),
						  success: function(data) 
								   { 
										alert(\'Sizinle ek kısa sürede iletişime geçeceğiz. Teşekkürler.\');
										$( "#dialog-form" ).dialog( "close" );					
								   }
						});
				   }
				}
			},
			close: function() {
				// allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});

		$( "#mod-telefon" ).click(function() {
				$( "#dialog-form" ).dialog( "open" );
			});


</script>';

/*
Şablon library'e eklenecek.
function modTelefon()
{
	global $modHizliIletisim;
	include('include/mod_HizliIletisim.php');
	return $modHizliIletisim;
}
*/
?>