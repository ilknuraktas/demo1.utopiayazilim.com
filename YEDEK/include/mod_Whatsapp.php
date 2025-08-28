<?

function cepsiparisMod($d){
	global $shopphp_demo;
	$out = '
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<div id="tel-birakin"><div class="whatsapp_tabela" style="cursor:pointer;">
		<div class="wrap">
		<div class="icon"><i class="fa fa-phone"></i></div>
		<div class="right">
		<p class="title">TELEFONDA SİPARİŞ VER</p>
		<p class="number">'.siteConfig('firma_tel').'</p>
		<p class="slogan">Tıklayın, telefonunuzu bırakın. Sizi arayalım.</p>
		</div>
		</div>
		</div>
	</div>
	<script type="text/javascript">
	var hizliAramaIsim = "";
	var hizliAramaTel = "";
	$("#tel-birakin").click(function() {
		Swal.fire({
		  title: "Telefonda Sipariş Verin (1/2)",
  		  text: "Adınız Soyadınız : ",
		  input: "text",
		  confirmButtonText: "Gönder",
		  customClass: {
			confirmButton: "custom-class" 
			},
		  content: "input",

		})
		.then((value) => {
			console.log(value);
			hizliAramaIsim = value.value;
			if(!hizliAramaIsim)
			{
				myalert("Eksik / hatalı giriş. Numara kaydedilmedi.","error");
				return;
			}
			Swal.fire({
			  title: "Telefonda Sipariş Verin (2/2)",
			  input: "text",
			  text: "Telefon Numaranız : ",
				content: "input",
				customClass: {
					confirmButton: "custom-class" 
					},
				confirmButtonText: "Gönder",
	
			})
			.then((value) => {
			  hizliAramaTel = value.value;
			  if(!hizliAramaTel)
				{
					myalert("Eksik / hatalı giriş. Numara kaydedilmedi.","error");
					return;
				}
				Swal.fire({
					title: "Mesajınız gönderiliyor...",
					html: ajaxLoaderDiv(),
					allowOutsideClick: false,
					allowEscapeKey: false,
					allowEnterKey: false,
					showConfirmButton: false,
					onOpen: () => {
						Swal.showLoading();
					}
				})
				'."	   $.ajax({
						  url: 'include/ajaxLib.php?act=quickContact&urunID=".$d['ID']."&namelastname='+ hizliAramaIsim +'&ceptel=' + hizliAramaTel + '&email=' + 'hizli-arama-talebi',
						  success: function(data) 
								   { 
										Swal.hideLoading();

										Swal.fire({
											title: 'Telefonda Sipariş Verin',
											text: 'Sn. '+ hizliAramaIsim +', Telefon numaranız '+ hizliAramaTel +' olarak kaydedildi. En kısa sürede sizi arıyoruz.".($shopphp_demo?'*** Demo Amaçlıdır ***':'')."',
											confirmButtonText: 'Tamam'	,
											customClass: {
												confirmButton: 'custom-class' 
												},
											icon: 'success',							  
										  });			
								   }
						});".'	
			  
			});
		});
	});
	</script>
	
	'; 
	 return $out;
}

function whatsapptxt($d)
{

	global $siteDizini;
	$wno = str_replace(array(' ','(',')','-'), array(''), siteConfig('whatsappNumber'));
	$text = ($_GET['act'] == 'urunDetay'?'Stok Kodu:'.$d['ID'].' - Adı: '.$d['name'].' adlı üründen sipariş vermek istiyorum. http://'.$_SERVER['HTTP_HOST'].$siteDizini.urunLink($d):'Telefon üzerinden sipariş vermek istiyorum.');
	
	//if($_GET['act'] != 'urunDetay' || $shopphp_demo)
	$out='<a href="https://api.whatsapp.com/send?phone=9'.$wno.'&text='.$text.'" id="spWhatsAppFooter" target="_blank">
        <img src="images/whatsApp.png" alt="">
    </a>';
	
		$out = '
	<div class="whatsapp_tabela">
	<a href="https://api.whatsapp.com/send?phone=9'.$wno.'&text='.$text.'" target="_blank">
	<div class="wrap">
	<div class="icon"><i class="fa fa-whatsapp"></i></div>
	<div class="right">
	<p class="title">TIKLA WHATSAPP İLE SİPARİŞ VER</p>
	<p class="number">'.siteConfig('whatsappNumber').'</p>
	<p class="slogan">7x24 Whatsapp Üzerinden de Sipariş Verebilirsiniz.</p>
	</div>
	</div>
	</a>
	</div>
	'; 
	 return $out;
}

function whatsappFooterSupport()
{
	if(!siteConfig('whatsappSupportShow') || !siteConfig('whatsappNumber'))
		return;
	$css = '<style>
	.trwpwhatsappballon {
		font-size: 14px;
		border-radius: 5px; 
		border: 1px solid #fff;
		max-width: 300px;
		display:none;
		}
		
		.trwpwhatsapptitle {
		background-color: #22c15e; 
		color: white; 
		padding: 14px; 
		border-radius: 5px 5px 0px 0px;
		text-align: center;
		}
		
		.trwpwhatsappmessage {
		padding: 16px 12px;
		background-color: white;
		}
		
		.trwpwhatsappinput {
		background-color: white;
		border-radius: 0px 0px 5px 5px;
		position:relative;
		}
		
		.trwpwhatsappinput input {
		width: 250px;
		border-radius: 5px;
		margin: 1px 1px 10px 10px;
		padding:10px;
		font-family: "Raleway", Arial, sans-serif;
		font-weight: 300;
		font-size: 13px;
		border: 1px solid #22c15e;
		}
		
		.trwpwhatsappbutton {
		background-color: #22c15e; 
		border-radius: 5px; 
		padding: 8px 15px; 
		cursor: pointer; 
		color: #fff;
		max-width: 220px;
		margin-top: 10px;
		margin-bottom: 10px;
		-webkit-touch-callout: none;
		-webkit-user-select: none;
		-khtml-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
		float:right;
		}
		
		.trwpwhatsappall {
		position: fixed; 
		z-index: 10000; 
		bottom: 50px; 
		right: 10px;
		font-family: "Raleway", Arial, sans-serif;
		font-weight: 300;
		font-size: 15px;
		}
		
		
		#trwpwhatsappform i {
		color: #22c15e;
		cursor:pointer;
		float: right;
		position: absolute;
		z-index: 10000;
		right: 0;
		top:0;
		font-size: 30px !important;
		}
		
		.kapat {
		position: absolute;
		right: 8px;
		top: 6px;
		font-size: 13px;
		border: 1px solid #fff;
		border-radius: 99px;
		padding: 2px 5px 2px 5px;
		color: white;
		font-size: 10px;
		cursor: pointer;
		}
	</style>';
	$html = '<div class="trwpwhatsappall">
	<div class="trwpwhatsappballon">
	 <span id="kapatac" class="kapat">X</span>
	  <div class="trwpwhatsapptitle">
		 '.(siteConfig('whatsappSupportTitle')?siteConfig('whatsappSupportTitle'):'WhatsApp destek ekibimiz sorularınızı cevaplıyor.').'
	  </div>
	  <div class="trwpwhatsappmessage">
	  '.(siteConfig('whatsappSupportSubTitle')?siteConfig('whatsappSupportSubTitle'):'Merhaba, nasıl yardımcı olabilirim?').'
	  </div>
	  <div class="trwpwhatsappinput">
		<form action="https://api.whatsapp.com/send?" id="trwpwhatsappform" method="get" target="_blank">
		  <input type="hidden" name="phone" value="9'.siteConfig('whatsappNumber').'" >
			<input type="text" name="text" placeholder="Buradan cevap verebilirsiniz." autocomplete="off">
			<i class="fa fa-whatsapp" onclick="$(\'#trwpwhatsappform\').submit();"></i>
		</form>
	  </div>
	</div>	
	<div id="ackapa" class="trwpwhatsappbutton">
	<i class="fa fa-whatsapp"></i> <span>WhatsApp Destek Hattı</span>
	</div>';
	$js = '<script type="text/javascript">
	$(document).ready(function() {
		$("#ackapa").click(function() {
		$(".trwpwhatsappballon").slideToggle(\'fast\');
		});
		$("#kapatac").click(function() {
		$(".trwpwhatsappballon").slideToggle(\'fast\');
		});
		});
	</script>';
	return $css.$html.$js;
}

?>