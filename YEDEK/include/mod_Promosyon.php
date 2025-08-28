<?php
require_once('session.php');
require_once('lib-db.php');
require_once('conf.php');
require_once('sec.php');
require_once('start.php');
require_once('lib.php');

// AYARLAR
// $promosyonIndirimTutari ve $promosyonIndirimOrani değerlerinden sadece biri set edilebilir. Bir tanesi mutlaka 0 olmalıdır.
$promosyonSuresi = siteConfig('promosyonTeklifSuresi'); // Saniye
$promosyonIndirimTutari = siteConfig('promosyonTeklifTutari'); // TL
$promosyonIndirimOrani = siteConfig('promosyonTeklifOrani');  // Yüzde oran. Örneği %10 için 0.1.
$promosyonKoduHarfSayisi = siteConfig('promosyonTeklifHarfSayisi'); 
$promosyonAsgari = siteConfig('promosyonAsgari'); 
// AYARLAR
$promosyonStr = ($promosyonIndirimTutari?$promosyonIndirimTutari.' TL':'%'.($promosyonIndirimOrani * 100));
$promosyonStrLong = ($promosyonIndirimTutari?$promosyonIndirimTutari.' TL\'lik ':'%'.($promosyonIndirimOrani * 100).' indirim');
	
if ($_GET['act']=='promosyon')
{
	usleep(1000000);
	$code = RandomString($promosyonKoduHarfSayisi);
	my_mysql_query("insert into promosyon (code,percent,ammount,min,tarih) values('$code','$promosyonIndirimOrani','$promosyonIndirimTutari','$promosyonAsgari','2030-01-01')");
	$_SESSION['p-code'] = $code;
	exit($code);
}
if ($_GET['act']=='updateMp_show')
{
	$_SESSION['mp_show']=1;
	exit('OK');
}

if (!$_SESSION['mp_start']) $_SESSION['mp_start'] = time();
$finish = $_SESSION['mp_start'] + $promosyonSuresi;
if (!$_SESSION['mp_show'] && time() >= $finish)
{
	echo mpShowMpSplashScreen();
}

function RandomString($len){
    $randstr = '';
    srand((double)microtime()*1000000);
    for($i=0;$i<$len;$i++){
        $n = rand(48,120);
        while (($n >= 58 && $n <= 64) || ($n >= 91 && $n <= 96)){
            $n = rand(48,120);
        }
        $randstr .= chr($n);
    }
    return strtoupper($randstr);
}

function mpShowMpSplashScreen()
{
	global $footerJS;
	if(!siteConfig('promosyonTeklifAktif')) return;
	// AYARLAR
	// $promosyonIndirimTutari ve $promosyonIndirimOrani değerlerinden sadece biri set edilebilir. Bir tanesi mutlaka 0 olmalıdır.
	$promosyonSuresi = siteConfig('promosyonTeklifSuresi'); // Saniye
	$promosyonIndirimTutari = siteConfig('promosyonTeklifTutari'); // TL
	$promosyonIndirimOrani = siteConfig('promosyonTeklifOrani');  // Yüzde oran. Örneği %10 için 0.1.
	$promosyonKoduHarfSayisi = siteConfig('promosyonTeklifHarfSayisi'); 
	$promosyonAsgari = siteConfig('promosyonAsgari'); 
	$promosyonUye = siteConfig('promosyonUye');
	if($promosyonUye && $_SESSION['userID'])
		return;
	
	// AYARLAR
	$promosyonStr = ($promosyonIndirimTutari?$promosyonIndirimTutari.' TL':'%'.($promosyonIndirimOrani * 100));
	$promosyonStrLong = ($promosyonIndirimTutari?$promosyonIndirimTutari.' TL\'lik ':'%'.($promosyonIndirimOrani * 100).' indirim');
	$finish = $_SESSION['mp_start'] + $promosyonSuresi;
	
	$out ="<style>
			#question,.question { padding:20px; background-color:red; cursor:default;  }
			#question h1,.question h1 { font-size:16px; font-weight:bold; color:white; }
			#yes { background-color:green; color:white; border:2px solid white; padding:5px; font-weight:bold; cursor:pointer; }
			#no,.no { background-color:red; color:white; border:2px solid white; padding:5px; font-weight:bold; cursor:pointer; }
		   </style>";
	$footerJS.="<script type='text/javascript' src='js/jquery.blockUI.js'></script>";
	$out.="
		<script>
		var time = '".time()."';
		var finish = '".$finish."';
		var qurl = '".slink('qregister')."';
		//alert('f t:'+time+' f:'+finish);	
		function unblock()
		{
			$.unblockUI(); 
			$('body').css({'overflowX':'visible'});
			return false; 
		}
		function checktime()
		{
			// alert('t:'+time+' f:'+finish);
			if (finish <= time) showPromoScreen();
			else 
			{
				time++;
				setTimeout('checktime()', 1000);
			}
		}
		function showPromoScreen() { 
			$.ajax({ 
				url: 'include/mod_Promosyon.php?act=updateMp_show', 
				cache: false, 
				success: function(data) {
					$.blockUI({ message: $('#question'), css: { width: '300px'".(isReallyMobile()?",'left':'10px'":"")." } });
				}	 
			}); 		
		}
		window.addEventListener('load', (event) => { 		 
			$('#yes').click(function() { 
				
				// update the block message 
					$.blockUI({ message: \"<div class='question'><h1>Size özel promosyon kodu hazırlanıyor... Lütfen Bekleyin ...</h1></div>\" , css: { width: '300px'".(isReallyMobile()?",'left':'10px'":"")."}});	
				$.ajax({ 
					url: 'include/mod_Promosyon.php?act=promosyon', 
					cache: false, 
					".($promosyonUye?
							"success: function(data) {  $.blockUI({ message: \"<div class='question'><h1>Promosyon kodunuz hazırlandı. <a href='".slink('qregister')."'>Buraya tıkladıktan</a> sonra, kısa formu doldurup, promosyon kodunuzu alabilir, ilk alışverişisinizde hemen kullanabilirsiniz. Promosyon kodunu kullanabilmek için asgari sepet tutarı ".my_money_format('',$promosyonAsgari)." TL olmalıdır. </h1><input type='button' class='no' onclick='unblock(); return false;' 'window.location.href= qurl; ' value='TAMAM' /> </div>\""
							:
							"success: function(data) { $.blockUI({ message: \"<div class='question'><h1>Lütfen Kaydedin. İlk alışverişinizde hemen kullanabilirsiniz.<br>Promosyon Kodu (".$promosyonStr.") : \"+data+\" . Promosyon kodunu kullanabilmek için asgari sepet tutarı ".my_money_format('',$promosyonAsgari)." TL olmalıdır.</h1><input type='button' class='no' onclick='unblock(); return false;'  value='TAMAM' /> </div>\"")." 
					, css: { width: '300px'".(isReallyMobile()?",'left':'10px'":"")."}
					}); } 
				}); 
			}); 
			$('#no,.no').click(unblock); 
		});
		if (finish > time) 
			window.addEventListener('load', (event) => { setTimeout('checktime()', 1000) });
		else 
			window.addEventListener('load', (event) => {showPromoScreen() });
 		</script>
		<div id='question' style='display:none;'> 
			<h1>Hemen ".$promosyonStrLong." Promosyon kodu kazanmak ister misiniz?</h1> 
			<input type='button' id='yes' value='EVET' /> 
			<input type='button' id='no' value='HAYIR' /> 
		</div> 

	";
	$_SESSION['mp_show'] = true;
	return $out;
} 
?>