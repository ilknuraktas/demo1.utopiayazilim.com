<?

	if($_SESSION["postData"]['taksit'] && !$_POST['taksit']) 
		$_POST['taksit'] = $_SESSION["postData"]['taksit'];

	if(!$_POST['taksit'])
		$_POST['taksit'] = $_POST['INSTALLMENTS_NO'];
    if (!($_POST['taksit'] > 1)) $_POST['taksit'] = '';
	if ($_POST['cc1']) 
		$_POST['cardno'] = $_POST['cc1'].$_POST['cc2'].$_POST['cc3'].$_POST['cc4'];

	if (!$_GET['paytype'] && $_GET['type']) $_GET['paytype'] = $_GET['type'];
	$suAnkiToplamOdeme = basketInfo('ModulFarkiIle',$_SESSION['randStr']);
	$total = my_money_format('%i',taksitliOdemeHesalpa($suAnkiToplamOdeme,$_POST['taksit'],$_GET['paytype']));
	//echo 't : '.$total;
	$total = str_replace(',','',$total);
	if($_POST['taksit']) 
		$taksit = $_POST['taksit'];
	else if($_SESSION["postData"]['taksit']) 
		$taksit = $_SESSION["postData"]['taksit'];
		
	$taksitString = ($taksit ? $taksit.' Taksit':'Peşin');
	$odemeTipi 			=  dbInfo('banka','bankaAdi',$_GET['paytype']).' ('.$taksitString.' - '.$total.' TL)';	
	
	if($_SESSION['cache_setfiyatBirim'] && 1==2)
	{
		$odemeTipi 			=  dbInfo('banka','bankaAdi',$_GET['paytype']).' ('.$taksitString.' - '.fiyatCevir($total,'TL',$_SESSION['cache_setfiyatBirim']).' '. $_SESSION['cache_setfiyatBirim'].')';	
	}
	$odemeDurum = 2;
	
	$okUrl = $_SESSION['payu_DS']['okUrl'] = ($siteConfig['httpsAktif'] ?'https://':'https://').$_SERVER['HTTP_HOST'].$siteDizini.'page.php?act=posOK&sRequest='.$_GET['sRequest'];	
	$failUrl =  $_SESSION['payu_DS']['failUrl'] = ($siteConfig['httpsAktif'] ?'https://':'https://').$_SERVER['HTTP_HOST'].$siteDizini.'page.php?act=posFail&sRequest='.$_GET['sRequest'];

	if ($_GET['paytype'])
	{
		$_SESSION["postData"] = $_POST;
		$_SESSION["postData"]['paytype'] = $_GET['paytype'];
		$_SESSION['paytype'] = $_GET['paytype'];
	}
//	echo debugArray($_POST);
//	echo $_SESSION['randStr'].'_'.$_SESSION['PAYU_ORDER_HASH'];
	if ($_GET['result'] == 'success' && $_POST['STATUS'] == 'SUCCESS' && $_POST['RETURN_CODE'] == 'AUTHORIZED')
	{
		if((float)$_POST['AMOUNT'] >= (float)$total)
		{
			$odemeDurum = 2;
		}
		else
			$odemeDurum = 1;
					
		$tamamlandi = true;
		$sepetTemizle = true;
	}
	else
		$errmsg = $_POST['return_message'].$_POST['RETURN_MESSAGE'];
	
	if ($_POST['cardno']) 
	{
		$birim = 'TRY';
		
		if($_SESSION['cache_setfiyatBirim'] && 1==2)
		{
			$birim = $_SESSION['cache_setfiyatBirim'];
			$total = fiyatCevir($total,'TL',$_SESSION['cache_setfiyatBirim']);			
		}

		$url = "https://secure.payu.com.tr/order/alu.php";
		 
		$secretKey = hq("select password from banka where ID='".$_GET['paytype']."'");
		$arParams = array(
		 	"LANGUAGE" => "TR", 
			//The Merchant's ID
			"MERCHANT" => hq("select username from banka where ID='".$_GET['paytype']."'"),
			//order external reference number in Merchant's system
			"ORDER_REF" => rand(10000,99999).'000'.$_SESSION['randStr'],
			"ORDER_DATE" => gmdate('Y-m-d H:i:s'),
			 
			//First product details begin
			"ORDER_PNAME[0]" => $_SESSION['randStr']." nolu siparis odemesi",
			"ORDER_PCODE[0]" => $_SESSION['randStr'],
			"ORDER_PINFO[0]" => $_SESSION['randStr']." nolu siparis odemesi",
			"ORDER_PRICE[0]" => $total,
			"ORDER_QTY[0]" => "1",
			//First product details end
			 
		 
			"PRICES_CURRENCY" => $birim,
			"PAY_METHOD" => "CCVISAMC",//to remove
			"SELECTED_INSTALLMENTS_NUMBER" => ($_POST['taksit']?$_POST['taksit']:1),
			"CC_NUMBER" => $_POST['cardno'],
			"EXP_MONTH" =>  $_POST['expmonth'],
			"EXP_YEAR" => '20'.$_POST['expyear'],
			"CC_CVV" => $_POST['cv2'],
			"CC_OWNER" => $_POST['kart_isim'],
			 
			//Return URL on the Merchant webshop side that will be used in case of 3DS enrolled cards authorizations.
			"BACK_REF" => $okUrl,
			"CLIENT_IP" => $_SERVER['REMOTE_ADDR'],
			"BILL_LNAME" => tr2eu(hq("select lastname from siparis where randStr like '".$_SESSION['randStr']."'")),
			"BILL_FNAME" => tr2eu(hq("select name from siparis where randStr like '".$_SESSION['randStr']."'")),
			"BILL_EMAIL" => tr2eu(str_replace(' ','',hq("select email from siparis where randStr like '".$_SESSION['randStr']."'"))),
			"BILL_PHONE" => str_replace('-','',tr2eu(hq("select ceptel from siparis where randStr like '".$_SESSION['randStr']."'"))),
			"BILL_COUNTRYCODE" => "TR",
			 
			//Delivery information
			"DELIVERY_FNAME" => tr2eu(hq("select name from siparis where randStr like '".$_SESSION['randStr']."'")),
			"DELIVERY_LNAME" => tr2eu(hq("select lastname from siparis where randStr like '".$_SESSION['randStr']."'")),
			"DELIVERY_PHONE" => tr2eu(hq("select ceptel from siparis where randStr like '".$_SESSION['randStr']."'")),
			"DELIVERY_ADDRESS" => tr2eu(hq("select address from siparis where randStr like '".$_SESSION['randStr']."'")),
			"DELIVERY_ZIPCODE" => "00000",
			"DELIVERY_CITY" => tr2eu(hq("select name from iller where plakaID= '".hq("select city from siparis where randStr like '".$_SESSION['randStr']."'")."' limit 0,1")),
			"DELIVERY_STATE" => tr2eu(hq("select name from ilceler where ID= '".hq("select semt from siparis where randStr like '".$_SESSION['randStr']."'")."' limit 0,1")),
			"DELIVERY_COUNTRYCODE" => "TR",
		);
		

		//echo $_SERVER['REQUEST_URI'];
		//echo "<pre>".print_r($arParams,1)."</pre>";
		//begin HASH calculation
		ksort($arParams);
		 
		$hashString = "";
		 
		foreach ($arParams as $key=>$val) {
			$hashString .= strlen($val) . $val;
		}



		 
		$arParams["ORDER_HASH"] = $_SESSION['PAYU_ORDER_HASH'] = hash_hmac("md5", $hashString, $secretKey);
		//end HASH calculation
		 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSLVERSION , 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($arParams));
		$response = curl_exec($ch);
		 
		$curlerrcode = curl_errno($ch);
		$curlerr = curl_error($ch);
		
		if (empty($curlerr) && empty($curlerrcode)) {
			$parsedXML = @simplexml_load_string($response);
			if ($parsedXML !== FALSE) {
		 
				//Get PayU Transaction reference.
				//Can be stored in your system DB, linked with your current order, for match order in case of 3DSecure enrolled cards
				//Can be empty in case of invalid parameters errors
				$payuTranReference = $parsedXML->REFNO;
		 
				if ($parsedXML->STATUS == "SUCCESS") {
		 
					//In case of 3DS enrolled cards, PayU will return the extra XML tag URL_3DS that contains a unique url for each 
					//transaction. For example https://secure.payu.com.tr/order/alu_return_3ds.php?request_id=2Xrl85eakbSBr3WtcbixYQ%3D%3D.
					//The merchant must redirect the browser to this url to allow user to authenticate. 
					//After the authentification process ends the user will be redirected to BACK_REF url
					//with payment result in a HTTP POST request - see 3ds return sample. 
					if (($parsedXML->RETURN_CODE == "3DS_ENROLLED") && (!empty($parsedXML->URL_3DS))) {
						header("Location:" . $parsedXML->URL_3DS);
						//redirect($parsedXML->URL_3D);
						die(redirectShr($parsedXML->URL_3DS));
					}
		 			$tamamlandi = true;
					$sepetTemizle = true;
					$bankaMesaj.= "ODEME BASARILI [PayU ref no: " . $payuTranReference . "]";
				} else {
					$hata = array();
					$hata['GW_ERROR_GENERIC']= 'İşlem sırasında tanımlanamayan teknik bir hata meydana geldi. İşlemi tekrar deneyiniz. Bir süre beklemeniz tavsiye olunur.';
					$hata['GW_ERROR_GENERIC_3D']= '3D doğrulama sırasında bir hata meydana geldi. Bir süre sonra tekrar deneyiniz. Sorun devam ederse, kartın 3D kullanımına uygun olduğunu bankadan teyit ediniz.';
					$hata['GWERROR_-9']= 'Kartın son kullanma tarihi hatalı girilmiştir.';
					$hata['GWERROR_-3']= 'Bilinmeyen hata. Sanal pos bankası destek hizmetleri ile iletişime geçiniz.';
					$hata['GWERROR_-2']= 'İşlem sırasında tanımlanamayan teknik bir hata meydana geldi. İşlemi tekrar deneyiniz. Bir süre beklemeniz tavsiye olunur.';
					$hata['GWERROR_05']= 'Otorizasyon reddedildi. Genel red. Bu hata kart ve banka kaynaklı birçok nedenden dolayı meydana gelir. Kart sahibi bankası ile görüşmelidir.';
					$hata['GWERROR_08']= 'Geçersiz tutar.';
					$hata['GWERROR_13']= 'Göndermiş olduğunuz tutar hatalı ya da taksitli işlem için belirtilen alt limitin altında.';
					$hata['GWERROR_14']= 'Böyle bir kart yok';
					$hata['GWERROR_15']= 'Böyle bir kart sağlayan banka yok.';
					$hata['GWERROR_19']= 'İşlemi tekrar deneyiniz.';
					$hata['GWERROR_34']= 'Kredi kartı numarası fraud kontrolünü geçemedi.';
					$hata['GWERROR_41']= 'Kayıp kart';
					$hata['GWERROR_43']= 'Çalıntı kart';
					$hata['GWERROR_51']= 'Limit yetersiz. Kartın bu işlem için yeterli limiti yok.';
					$hata['GWERROR_54']= 'Süresi dolmuş kart. Kartın son kullanma tarihi geçmiş.';
					$hata['GWERROR_57']= 'Kartın bu işlem için yetkisi yok. Kart sahibi bankası ile görüşerek, işlem yetkilerini kontrol ettirmelidir.';
					$hata['GWERROR_58']= 'Sanal pos kullanan üye işyerinin bu işlem için izni yok. Destek hattı ile iletişime geçmeniz gerekmektedir.';
					$hata['GWERROR_61']= 'Miktar sınırı aşıyor. Kart için belirlenen günlük işlem limiti ya da iptal limiti aşılıyor olabilir. Banka destek ekibi ile iletişime geçiniz.';
					$hata['GWERROR_62']= 'Sınırlı kart. İlgili kart banka tarafından sınırlandırılmış. Örneğin sadece yurtiçi işlemlerde kullanılabilmesi gibi.';
					$hata['GWERROR_65']= 'Miktar sınırı aşıyor. Günlük limitlerinizi kontrol ettiriniz.';
					$hata['GWERROR_75']= 'İzin verilen pin girme sayısı aşıldı. Destek ekibi ile iletişime geçiniz.';
					$hata['GWERROR_82']= 'İssuer (kart sağlayan) banka cevap vermiyor. İşlemi tekrar deneyiniz.';
					$hata['GWERROR_84']= 'Geçersiz cvv numarası';
					$hata['GWERROR_91']= 'Bir teknik sorun oluştu. Issuer işlem yapamıyor. İşlemi tekrar deneyiniz.';
					$hata['GWERROR_96']= 'Sistem arızası. Banka tarafında teknik bir sıkıntı meydana geldi. Bir süre sonra tekrar işlem deneyebilirsiniz.';
					$hata['GWERROR_105']= '3D kimlik doğrulama başarısız oldu. İşlem yaptığınız kartın 3D doğrulama için kayıt edilmiş olduğundan emin olunuz.';
					$hata['GWERROR_2204']= 'Kartın taksitli işlem izni yok.';
					$hata['GWERROR_2304']= 'Devam eden bir işlem var.';
					$hata['GWERROR_5007']= 'Banka kartları sadece 3D işlem destekler.';
					$hata['ALREADY_AUTHORIZED']= 'İşlemi tekrar deneyiniz.';
					$hata['NEW_ERROR']= 'Mesaj akış hatası. Sistemde tanımlanmayan yeni bir hata mesajı alındı. Destek ekibi ile iletişime geçiniz.';
					$hata['WRONG_ERROR']= 'İşlemi tekrar deneyin.';
					$hata['-9999']= 'Yasaklı işlem. Göndermiş olduğunuz alanlardan biri ya da birkaçı sistemde yasaklanmıştır. Sabit bir bilgi gönderiyor iseniz, lütfen güncelleyiniz.';
					$hata['1']= 'Sanal pos bankası destek hattını arayınız.';
					$hata['HASH_MISTMATCH']= 'Hash uyuşmazlığı. Bu hata entegrasyonla ilgili ciddi bir hatadır. Yazılımcınızla görüşmeniz gerekmektedir.';
					$hata['INVALID_CUSTOMER_INFO']= 'Geçersiz müşteri bilgisi. Zorunlu bilgilerden bazıları (isim, soyisim, e-posta) gibi eksik ya da geçersiz gönderilmektedir. Alanları kontrol ediniz.';
					$hata['INVALID_PAYMENT_INFO']= 'Geçersiz kart bilgileri. Girmiş olduğunuz kart bilgilerini kontrol ediniz.';
					$hata['INVALID_ACCOUNT']= 'Merchant ID (İşyeri entegrasyon ismi) hatalı ya da eksik gönderilmektedir. Kontol ediniz.';
					$hata['INVALID_PAYMENT_METHOD_CODE']= 'Geçersiz ödeme metodu. “PAYMETHOD” parametresini kontrol ediniz.';
					$hata['INVALID_CURRENCY']= 'Geçersiz para birimi ya da işlem yapmak istediğiniz para birimi hesabınız için aktif edilmemiş.';
					$hata['REQUEST_EXPIRED']= 'Sipariş tarihi (ORDER_DATE) parametresi hatalı gönderilmektedir. Bu parametre UTC standartına göre gönderilmiş olmalıdır.';
					$hata['ORDER_TIMEOUT']= 'Sipariş zaman aşımına uğradı. Tekrar deneyiniz.';
					$hata['WRONG_VERSION']= 'Geçersiz alu versiyonu';
					$hata['INVALID_CC_TOKEN']= 'Geçersiz token bilgisi. Token numarası doğru değil ya da bu token aktif değil.';
					$hata['AUTHORIZATION_FAILED']= 'Otorizasyon reddedildi.';
					$hata['ALREADY_AUTHORIZED']= 'Bu işlemde otorizasyon yapılmış. Aynı ORDER_REF ve aynı Hash ile işlem gönderildi. Mükerrer işlem.';
					$hata['3DS_ENROLLED']= 'İşlemin tamamlanabilmesi için 3D doğrulaması yapılması gerekmektedir.';
					$hata['AUTHORIZED']= 'Otorizasyon başarılı.';				


					$errmsg.= "HATA: . ".$hata[(string)$parsedXML->RETURN_CODE] .' ('. $parsedXML->RETURN_MESSAGE.')';
					if (!empty($payuTranReference)) {
						//the transaction was register to PayU system, but some error occured during the bank authorization.
						//See $parsedXML->RETURN_MESSAGE and $parsedXML->RETURN_CODE for details                
						$bankaMesaj.= " [PayU ref no: " . $payuTranReference . "]";
					}
				}
			}
		} else {
			//Was an error comunication between servers
			$errmsg.="cURL error: " . $curlerr;
		}
		//$errmsg.=$_SERVER['REQUEST_URI'].print_r($_POST,1);
	}

function generateESTTaksitSelection($bankaID,$total,$clickAmount = 1) {
		$q = my_mysql_query("select * from banka where ID='$bankaID'");
		$d = my_mysql_fetch_array($q);
		$d['taksitSayisi'] = (my_mysql_num_rows(my_mysql_query("select ay from bankaVade where bankaID='$bankaID'")) + 1);
		
		$du['fiyat'] = $total;

		$out.='<select name="taksit" onchange="var deger = $(this).find(\'option:selected\').attr(\'deger\'); $(\'#amount\').val(deger); ">';
		$qVade = my_mysql_query("select * from bankaVade where bankaID='$bankaID' order by ay,minfiyat desc");
		$taksitArray = array();		
		while ($dVade = my_mysql_fetch_array($qVade)) {
			if(function_exists('pesinTaksitFix'))
				$dVade = pesinTaksitFix($dVade);
			$i = $dVade['ay'];
			$p = $dVade['plus'];
			$goster = ($p?$i.' (+'.$p.')':$i);					
			if($dVade['minfiyat'] > $du['fiyat'] || (azamiTaksit() < $dVade['ay'])) continue;		
			if($taksitArray[$i]) continue;	
			$taksitArray[$i] = true;			
			$toplamFaiz = $dVade['vade'];
			if(hq("select urun.ID from urun,sepet where sepet.urunID = urun.ID AND urun.data5 = 1 AND sepet.randStr like '".$_SESSION['randStr']."'"))
				$toplamFaiz = 0;
			$rx[$i] = $dVade['vade'];			
			$toplamOdenecek = ($i<=$pesinFiyatinaTaksitSayisi?$du['fiyat']:(($toplamFaiz + 1) * $du['fiyat']));
			$toplamOdenecek = $toplamOdenecek - sepetKapmanyaIndirimleri($dVade);
			$taksit = ($i==1?'':($toplamOdenecek / $i));
			$pesinFiyatina = ($toplamOdenecek <= $du['fiyat']?true:false);
			if ($i > 1 && $rx[($i - 1)] >= $rx[$i]) $pesinFiyatina = 1;
			$taksitStr = ($i==1?_lang_pesin:$i.' '._lang_taksit);	
			$out.="<option deger='".($toplamOdenecek)."' value='".$i."'>$taksitStr : ".($taksit?'('.my_money_format('%i',$taksit).') TL x '.$goster.' = ':'')."".my_money_format('%i',$toplamOdenecek)." TL</option>\n";			 
		}
		$out.='</select>';	
		
		if (($d['taksitSayisi'] - 1)) 
			$out.='<script>$(document).ready(function() { var obj = $(\'select#taksit\'); var deger = $(obj).find(\'option:selected\').attr(\'deger\'); $(\'#amount\').val(deger);});</script>';	
	return $out;
}
	
function payment() {
	global $siteConfig,$stop,$tamamlandi,$msg,$errmsg,$suAnkiToplamOdeme,$bankaMesaj,$numpad;
	$out.=finishShared($tamamlandi,$errmsg,$bankaMesaj);
	if (!$tamamlandi) {
		$action = ($siteConfig['seoURL'] ? 'satinal_sp__op-odeme,paytype-'.$_GET['paytype'].'.html' : 'page.php?act=satinal&op=odeme&paytype='.$_GET['paytype']);			
		if ($errmsg) 
		{
			spPayment::sendPaymentError(utf8fix($errmsg).' '.utf8fix($bankaMesaj));
			if ($errmsg) $out.='<br><br><span style="color:red; font-weight:bold;">'.utf8fix($errmsg).'<br>'.utf8fix($bankaMesaj).'</span>';
		}
		$out.='<br><br><div class="payment">
				  <form action="'.$action.'" method="post">	
				  <input type="hidden" name="act" value="'.$_GET['act'].'">	
				  <input type="hidden" name="op" value="'.$_GET['op'].'">	
				  <input type="hidden" name="paytype" value="'.$_GET['paytype'].'">	
				  '.ccForm($_GET['paytype']).'
				</form>
				</div>';
		$out = str_replace('{%TAKSIT%}',generateESTTaksitSelection($_GET["paytype"],$suAnkiToplamOdeme),$out);
			
	}
	else {
		
		$out  = 'Durum : Ödeme onaylandı.<br>';
		$out.= spPayment::finalizePayment();
	}
	return $out;
}
?>