<?
$orandStr = $_SESSION['randStr'];

function userInsiderTracker()
{
	if(!siteConfig('userInsiderTracker')) return;
	global $tamamlandi,$orandStr;;
	$out = '<script>';
	switch($_GET['act'])
	{
		case 'showPage':
				$out.='window.insider_object = {
					"page": {
						"type": "Content"
					}
				}';
			break;


		case 'login':
		case 'profile':

			if($_SESSION['userID'])
			{
				$q = my_mysql_query("select * from user where ID='".$_SESSION['userID']."'");
				$d = my_mysql_fetch_array($q);
				$out.='window.insider_object = {
					"user":{
					   "uuid":"'.$d['ID'].'",
					   "gender":"M",
					   "birthday":"'.$d['birthdate'].'",
					   "has_transacted":'.(bool)hq("select count(*) siparis where durum > 0 AND userID='".$d['ID']."'").',
					   "transaction_count":'.(int)hq("select count(*) siparis where durum > 0 AND userID='".$d['ID']."'").',
					   "gdpr_optin":true,
					   "name":"'.addslashes($d['name']).'",
					   "surname":"'.addslashes($d['lastname']).'",
					   "username":"'.addslashes($d['username']).'",
					   "email":"'.addslashes($d['email']).'",
					   "email_optin":'.(bool)$d['ebulten'].',
					   "phone_number":"'.addslashes($d['ceptel']).'",
					   "sms_optin":'.(bool)$d['ebultenSMS'].',
					   "language":"tr-tr"
					}
				 }';
			}

			break;
		case 'urunDetay':
			$d = urun();
			$out.='window.insider_object = {
				"page": {
					"type": "Product"
				}
			}';
			$out.='window.insider_object = {
				"product": '.getUserInsiderProductJson($d).'
			}';
		break;
		case 'kategoriGoster':
			$out.='window.insider_object = {
				"page": {
					"type": "Category"
				}
			}';


			$i = 1;
			$impressions = array();
			$q = my_mysql_query("select * from urun where catID='".$_GET['catID']."' OR showCatIDs like '%|".$_GET['catID']."|%' order by seq desc, ID desc",1);
			while($d = my_mysql_fetch_array($q))
			{
				$impressions[] = getDataLaterProductJson($d);
				$i++;
			}

			$out.='window.insider_object = {
				"listing": {
					"items": [
						'.implode(',',$impressions).'
					]
				}
			}';
		break;
		case 'sepet':
			$promotionCode = hq("select promotionCode from siparis where randStr = '".$_SESSION['randStr']."' limit 0,1");
			$out.='window.insider_object = {
				"basket": {
					"currency": "TRY",
					"total": '.my_money_format('%i', basketInfo('ModulFarkiIle', $_SESSION['randStr'])).',
					"promotions": [
						"'. $promotionCode.'"
					],
					"promotion_discount": '.my_money_format('%i', basketInfo('Promosyon', $_SESSION['randStr'])).',
					"promotion_discount_ratio": '.hq("select percent from promosyon where code = '$promotionCode'").',
					"shipping_cost": '.my_money_format('%i', basketInfo('Kargo', $_SESSION['randStr'])).',
					"line_items": [
						'.getUserInsiderBasket($_SESSION['randStr']).'
					]
				}
			}';
		break;
		case 'satinal':
			if($tamamlandi)
			{
				$qSiparis = my_mysql_query("select * from siparis where randStr = '" . $orandStr . "'");
				$dSiparis = my_mysql_fetch_array($qSiparis);

				$promotionCode = hq("select promotionCode from siparis where randStr = '".$orandStr."' limit 0,1");
				$out.='window.insider_object = {
					"transaction": {
						"order_id": "'.$orandStr.'",
						"currency": "TRY",
						"total": '.my_money_format('%i', basketInfo('ModulFarkiIle', $orandStr)).',
						"payment_type": "'.addslashes(hq("select odemeTipi from siparis where randStr= '$orandStr'")).'",
						"bank_name": "'.addslashes(hq("select odemeTipi from siparis where randStr= '$orandStr'")).'",
						"promotions": [
							"'. $promotionCode.'"
						],
						"promotion_discount": '.my_money_format('%i', basketInfo('Promosyon', $_SESSION['randStr'])).',
						"promotion_discount_ratio": '.hq("select percent from promosyon where code = '$promotionCode'").',
						"shipping_cost": '.my_money_format('%i', basketInfo('Kargo', $_SESSION['randStr'])).',
						"delivery": {
							"country": "TR",
							"city": "'.hq('select name from iller where plakaID=\'' . $dSiparis['city'] . '\' ').'",
							"district": "'.hq('select name from ilceler where ID=\'' . $dSiparis['semt'] . '\' ').'"
						},
						"line_items": [
							{
								'.getUserInsiderBasket($orandStr).'
							}
						]
					}
				}';
			}
		break;
	}
	$out.='</script>';
	return $out;
}

function getUserInsiderProductJson($d)
{
	global $siteDizini;
	$namePathArray = explode('/',hq("select namePath from kategori where ID='".$d['catID']."'"));
	$taxonomy = array();
	foreach($namePathArray as $namePath)
	{
		$taxonomy[] = '"'.addslashes($namePath).'"';
	}
	$out='{
        "id": "'.$d['ID'].'",
        "name": "'.addslashes($d['name']).'",
        "taxonomy": [
            '.implode(',',$taxonomy).'
        ],
        "currency": "'.$d['fiyatBirim'].'",
        "unit_price": '.($d['piyasafiyat']?$d['piyasafiyat']:$d['fiyat']).',
        "unit_sale_price": '.$d['fiyat'].',
        "url": "https://'.$_SERVER[HTTP_HOST].$siteDizini.urunLink($d).'",
        "stock": '.$d['stok'].',
        "product_image_url": "https://'.$_SERVER[HTTP_HOST].$siteDizini.'images/urunler/'.$d['resim'].'"
    }';
	 return $out;
}

function getUserInsiderBasket($randStr)
{
	$q = my_mysql_query("select * from sepet where randStr = '".$randStr."'");
	while($d = my_mysql_fetch_array($q))
	{
		$q2 = my_mysql_query("select * from urun where ID='".$d['urunID']."'");
		$d2 = my_mysql_fetch_array($q2);
		$out.='{"product": { '.getDataLaterProductJson($d2).'},"quantity": '.$d['adet'].',"subtotal": '.($d['ytlFiyat'] * $d['adet']).'}';
	}
	return $out;
}

?>