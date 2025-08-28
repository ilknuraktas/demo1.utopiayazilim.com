<?
function yuvarlaOrg()
{
	$q = my_mysql_query("select ID from banka where paymentModulURL like 'auto_yuvarla'");
	if(!my_mysql_num_rows($q))
		return;
	return '
	<div style="clear:both;">&nbsp;</div>

	<div class="form-element">
		<label style="font-size:10px; color:#555;">
		<input type="checkbox" name="yuvarla" class="yuvarla" value="1" /> Ödememi 1 TL üst tutara yuvarlayıp, kalan kuruş tutarını yuvarla.org üzerinden ilgili kuruluşuna bağışlamak istiyorum.<div class="clear-space">&nbsp;</div> <select name="yMerchant">'.yuvarlaMerchant().'</select></label>
		<div style="clear:both;"></div>
	</div>';

}

function yuvarlaMerchant()
{
	$list = array(
		'yuvarlatema'=>'TEMA',
		'yuvarlaakut'=>'Arama Kurtarma Derneği',
		'yuvarlawwf'=>'Doğal Hayatı Koruma Vakfı',
		'yuvarlatog'=>'Toplum Gönüllüleri Vakfı',
		'yuvarlatohum01'=>'Tohum Otizm Vakfı',
		'yuvarlaunicef'=>'UNICEF Türkiye',
		'yuvarlaacev01'=>'Anne Çocuk Eğitim Vakfı',
		'yuvarlakacuv'=>'Kanserli Çocuklara Umut Vakfı',
		'yuvarlakoruncuk'=>'Türkiye Korunmaya Muhtaç Çocuklar Vakfı',
		'yuvarlatocev'=>'Tüvana Okuma İstekli Çocuk Eğitim Vakfı',
		'yuvarlaorav'=>'Öğretmen Akademisi Vakfı',
		'yuvarlakizilay'=>'Türk Kızılayı',
		'yuvarlategv'=>'Türkiye Eğitim Gönüllüleri Vakfı',
		'yuvarlatev'=>'Türk Eğitim Vakfı',
		'yuvarlayesilay'=>'Yeşilay Cemiyeti'
	);
	foreach($list as $k=>$v)
	{
		$out.='<option value="'.$k.'">'.$v.'</option>'."\n";	
	}
	return $out;
}

function yuvarlaOrgOdeme($paid)
{
	global $odemeTipi;
	$q = my_mysql_query("select * from banka where paymentModulURL like 'auto_yuvarla'");
	$d = my_mysql_fetch_array($q);	
	
	$amount = (float)(ceil($paid) - (float)$paid);
	if(!$amount)
		return;
	
	$ccName = searchForPost(array('kart_isim'));
	$ccNum = searchForPost(array('cardnumber','pan','Pan','cardno'));
	$ccMonth = searchForPost(array('cardexpiredatemonth','Ecom_Payment_Card_ExpDate_Month','Expiry','expmonth'));
	$ccYear = searchForPost(array('cardexpiredateyear','Ecom_Payment_Card_ExpDate_Year','expyear'));
	$ccCVV2 = searchForPost(array('cardcvv2','cv2','Cvv2'));
	
	if(strlen($ccMonth) == 4)
	{
		$ccYear = substr($ccMonth,2,2);
		$ccMonth = substr($ccMonth,0,2);
	}
	if(strlen($ccYear) == 2)
		$ccYear = '20'.$ccYear;
	
	$url = 'https://entegrasyon.asseco-see.com.tr/msu/api/v2';
	$data = array('ACTION' => 'SALE',
	'AMOUNT' => $amount,
	'CURRENCY' => 'TRY',
	'MERCHANTPAYMENTID' => $_SESSION['randStr'],
	'MERCHANT' => $d['clientID'],
	'MERCHANTUSER' => $d['username'],
	'MERCHANTPASSWORD' => $d['password'],
	'CUSTOMER' => hq("select concat('name',' ',lastname,'-',email) from siparis where randStr = '".$_SESSION['randStr']."'"),
	'NAMEONCARD' => $ccName,
	'CARDPAN' => $ccNum,
	'CARDEXPIRY' => $ccMonth.'.'.$ccYear,
	'CARDCVV' =>$ccCVV2);
	
	$options = array(
	'http' => array(
	'header' => "Content-type: application/x-www-form-urlencoded\r\n",
	'method' => 'POST',
	'content' => http_build_query($data),
	),
	);
	$context = stream_context_create($options);	
	$odemeTipi.=' | Yuvarla.org ('.$amount.' TL)';
}

?>