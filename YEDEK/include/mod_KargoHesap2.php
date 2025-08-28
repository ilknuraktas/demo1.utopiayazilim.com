<?
if($_GET['kargoHesapla'])
{
	$str = my_money_format('',kargoTutarHesapla($_GET['kargoFirmaID'],$_GET['desi'],$_GET['city'],$_GET['semt'])).' '.fiyatBirim('TL');
	$out = str_replace('{%TUTAR%}',$str,_lang_kargo_tutar);	
	$Sehir = $_GET['city'];
	if (!$Sehir)
		$Sehir = hq('select city from siparis where randStr = \''.$_SESSION['randStr'].'\' limit 0,1');
	$sure = hq("select sure from kargoSehir,kargoBolge where plakaID = '$Sehir' AND bolgeID=kargoBolge.ID limit 0,1");
	if($sure)
		$out.= str_replace('{%SURE%}',$sure,_lang_kargo_sure);
	exit($out);
}
function mykargoHesap()
{
	$form[] = array(_lang_form_sehir,"city","CITY",1,'',1,4);
	$form[] = array(_lang_form_semt,"semt","TOWN",1,'',1,3);
	$form[] = array('Desi Değeri',"desi","TEXTBOX",1,'',1,0);
	$form[] = array(_lang_form_kargo,"kargoHesapFirmaID","KARGO",1,'',1,0);
	disableCaptcha();
	$out.= '<div id="modKargo">'.generateForm($form,$d,'siparis','').'</div><style>#modKargo .button { display:none; }</style>';
	enableCaptcha();
	$out.="	
		<script>
		$('#gf_kargoHesapFirmaID,#gf_city,#gf_semt').change(kargoHesapla);
		$('#gf_desi').keyup(kargoHesapla);
		function kargoHesapla() 
		{
			if($('#gf_kargoHesapFirmaID').val() != '')
			{
				$.ajax({
				  url: 'index.php?act=kargoHesap&kargoHesapla=1&kargoFirmaID='+$('#gf_kargoHesapFirmaID').val()+'&city='+$('#gf_city').val()+'&semt='+$('#gf_semt').val() + '&desi=' + $('#gf_desi').val(),
				  success: function(data) 
						   {
								$('#gf_info_kargoHesapFirmaID').html(data);	
						   }
				});
			}
			else
				$('#gf_info_kargoHesapFirmaID').html('');
		}
		</script>";
	
	return generateTableBox('Kargo Tutar Hesaplama',$out,tempConfig('formlar'));
}

function kargoTutarHesapla($firmaID,$desi,$city,$semt) {
	$Sehir = $city;
	$Semt = $semt;	
	$ToplamDesi = (int)$desi;
	if ($Sehir) {
		$out = (hq('select kargoDesi.fiyat from kargoDesi,kargofirma,kargoBolge where kargoBolge.ID = kargoDesi.bolgeID AND kargofirma.ID = kargoDesi.firmaID AND  kargoDesi.firmaID=\''.$firmaID.'\' AND kargoDesi.bolgeID = \''.hq('select kargoSehir.bolgeID from kargoSehir,kargoBolge where kargoBolge.ID = kargoSehir.bolgeID AND plakaID = \''.$Sehir.'\'').'\' AND desiBaslangic <= '.$ToplamDesi.' AND desiBitis >= '.$ToplamDesi.' order by fiyat desc limit 0,1'));
		if (!$out)  (hq('select kargoDesi.fiyat from kargoDesi,kargofirma,kargoBolge where kargoBolge.ID = kargoDesi.bolgeID AND kargofirma.ID = kargoDesi.firmaID AND  kargoDesi.firmaID=0 AND kargoDesi.bolgeID = \''.hq('select kargoSehir.bolgeID from kargoSehir,kargoBolge where kargoBolge.ID = kargoSehir.bolgeID AND plakaID = \''.$Sehir.'\'').'\' AND desiBaslangic <= '.$ToplamDesi.' AND desiBitis >= '.$ToplamDesi.' order by fiyat desc limit 0,1'));
		$SemtFiyat = hq("select fiyatFarki from ilceler where ID='".$Semt."' limit 0,1");
		return $out + $SemtFiyat;
	}
	else return 0;
}
?>