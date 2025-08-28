<?
$orandStr = $_SESSION['randStr'];

function pinterestTracker()
{
	if(!siteConfig('pinterestTracker')) return;
	global $tamamlandi,$orandStr,$seo;
	$promotionCode = addslashes(hq("select promotionCode from siparis where randStr = '".$_SESSION['randStr']."' limit 0,1"));
	$out = '<script>';
	switch($_GET['act'])
	{
		case 'showPage':
				$out.= "pintrk('track', 'pagevisit', {
					promo_code: '".$promotionCode."',
					lead_type: '".hq("select title from pages where ID='" . (int)$_GET['ID'] . "'")."',
				  });";
			break;


		case 'login':

			if($_SESSION['userID'])
			{
				$out.= "pintrk('track', 'signup', {
					lead_type: 'Login Page'
				  });";
			}

			break;
		case 'urunDetay':
			$d = urun();
			$out .= "pintrk('track', 'ViewProduct', ".getPinterestProductJson($d).");";
		break;
		case 'kategoriGoster':

			$i = 1;
			$impressions = array();
			$q = my_mysql_query("select * from urun where catID='".$_GET['catID']."' OR showCatIDs like '%|".$_GET['catID']."|%' order by seq desc, ID desc",1);
			while($d = my_mysql_fetch_array($q))
			{
				$impressions[] = getDataLaterProductJson($d);
				$i++;
			}

			$out .= "pintrk('track', 'ViewCategory', {
				value: ".(int)$_GET['catID'].",
				line_items: [
					".implode(',',$impressions)."
				]
			  });";
		break;
		case 'sepet':
			$promotionCode = hq("select promotionCode from siparis where randStr = '".$_SESSION['randStr']."' limit 0,1");

			$out.="pintrk('track', 'basket', {
				promo_code: '".$promotionCode."',
				value: ".$_SESSION['randStr'].",
				order_quantity: ".basketInfo('toplamUrun', $_SESSION['randStr']).",
				currency: 'TRY',
				line_items: [
				  ".getPinterestBasket($_SESSION['randStr'])."
				]
			  });";
		break;
		case 'satinal':
			if($tamamlandi)
			{
				$promotionCode = hq("select promotionCode from siparis where randStr = '".$orandStr."' limit 0,1");

				$out.="pintrk('track', 'basket', {
					promo_code: '".$promotionCode."',
					value: ".$orandStr.",
					order_quantity: ".basketInfo('toplamUrun', $orandStr).",
					currency: 'TRY',
					line_items: [
					  ".getPinterestBasket($orandStr)."
					]
				  });";
			}
		break;
	}
	$out.='</script>';
	return $out;
}

function getPinterestProductJson($d,$addValues = '')
{
	global $siteDizini;

	$out = "{
		product_name: '".addslashes($d['name'])."',
		product_id: '".$d['ID']."',
		product_price: ".(float)$d['fiyat'].",
		currency: '".$d['fiyatBirim']."'
		".$addValues."
	  }";
	 return $out;
}

function getPinterestBasket($randStr)
{
	$q = my_mysql_query("select * from sepet where randStr = '".$randStr."'");
	while($d = my_mysql_fetch_array($q))
	{
		$q2 = my_mysql_query("select * from urun where ID='".$d['urunID']."'");
		$d2 = my_mysql_fetch_array($q2);
		$out.=getPinteretstProductJson($d2 ,",order_quantity: ".$d2['adet']);
	}
	return $out;
}

?>