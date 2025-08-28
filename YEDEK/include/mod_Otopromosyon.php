<?php
function otoPromosyon($randStr)
{
	$numuneTutar = hq("select sum(sepet.ytlFiyat * sepet.adet) from sepet,urun where urun.numune = 1 AND sepet.urunID= urun.ID AND sepet.randStr = '$randStr' AND sepet.adet = 1");
	$q = my_mysql_query("select * from otopromosyon order by minTutar desc");
	while($d = my_mysql_fetch_array($q))
	{
		$qs = my_mysql_query("select * from sepet where randStr like '".$randStr."'");
		$min = $d['minTutar'];
		$toplam = 0;
		while($ds = my_mysql_fetch_array($qs))
		{
			$uq = my_mysql_query("select * from urun where ID='".$ds['urunID']."'");
			$ud = my_mysql_fetch_array($uq);
			
			
			if((!(stristr($d['kategori'],','.$ud['catID'].',') === false)) || !$d['kategori'])
			{
				$toplam+= ($ds['adet'] * $ds['ytlFiyat']);
			}
			else if((!(stristr($d['marka'],','.$ud['markaID'].',') === false)) || !$d['marka'])
			{
				$toplam+= ($ds['adet'] * $ds['ytlFiyat']);
			}
		}
		if($min <= $toplam)
		{
			$d['indirimTutar'] += $numuneTutar;
			return otoPromosyonGonder($d,$randStr);	
		}
	}
	if($numuneTutar)
	{
		$d['indirimTutar'] = $numuneTutar;
		return otoPromosyonGonder($d,$randStr);	
	}
	return false;
}

function otoPromosyonGonder($d,$randStr)
{
	global $siteConfig;
	$promosyonKoduHarfSayisi = 5;
	$code = promosyonEkle($d['indirimOran'],$d['indirimTutar'],$promosyonKoduHarfSayisi);
	//my_mysql_query("insert into promosyon (code,percent,ammount) values('$code','".$d['indirimOran']."','".$d['indirimTutar']."')");
	$promosyonIndirimOrani = $d['indirimOran'];
	$promosyonIndirimTutari = $d['indirimTutar'];
	$promosyonStr = ($promosyonIndirimTutari?$promosyonIndirimTutari.' TL':'%'.($promosyonIndirimOrani * 100));
	$promosyonStrLong = ($promosyonIndirimTutari?$promosyonIndirimTutari.' TL\'lik ':'%'.($promosyonIndirimOrani * 100).' indirim');
	
	$str ='<div style="clear:both">&nbsp;</div>Tebrikler. "'.$d['baslik'].'" promosyonu kazandınız. Lütfen promosyon kodunuzu saklayın.<br><br><b>Promosyon Kodu : '.$code.'</b><br><br>Bu promosyon kodu size ilk alışverişinizde '.$promosyonStrLong.' sağlayacaktır.';
	
		$header = getHeaders(siteConfig('adminMail'));
		$mail = new spEmail();
		$mail->headers = $header;
		$mail->to = hq("select email from siparis where randStr like '".$randStr."'");
		$mail->subject = 'Hediye Promosyon Kodunuz';
		$mail->body = $str;			
		$mail->send();
		
	return $str;
}

function promosyonEkle($indirimOran,$indirimTutar,$promosyonKoduHarfSayisi)
{
	$code = RandomStringOtoPromosyon($promosyonKoduHarfSayisi);
	if(!hq("select ID from promosyon where code like '$code'"))
		my_mysql_query("insert into promosyon (code,percent,ammount) values('$code','".$indirimOran."','".$indirimTutar."')");
	return $code;	
}

function RandomStringOtoPromosyon($len){
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
?>