<?
$orandStr = $_SESSION['randStr'];

function googlePurchasesSepetList()
{
	global $orandStr;
	$out = array();
	$q = my_mysql_query("select sepet.*,marka.name markaName,kategori.namePath kategoriNamePath from sepet,urun,marka,kategori where sepet.urunID = urun.ID AND marka.ID = urun.markaID AND urun.catID = kategori.ID AND sepet.randStr like '" . $orandStr . "'");
	while ($d = my_mysql_fetch_array($q)) {
		$out[] = '{

			"id": "' . $d['urunID'] . '", 
			"name": "' . str_replace('"', "'", $d['urunName']) . '",	   
			"brand": "' . $d['markaName'] . '", 	   
			"category": "' . $d['kategoriNamePath'] . '",	   
			"variant": "' . $d['ozellik1'] . '-' . $d['ozellik2'] . '",   //sepetteki ürüne göre dinamik olarak değişmelidir	   
			"quantity": ' . $d['adet'] . ', // kullanıcının aldığı ürün adetine göre dinamik olarak değişmelidir	   
			"price": \'' . $d['ytlFiyat'] . '\' // ürün fiayatı seçilen ürüne göre dinamik olarak değişmelidir. 	   
		  }';
	}
	return implode(',', $out);
}

function googlePurchases()
{
	global $siteConfig, $orandStr, $tamamlandi;
	if (!siteConfig('google_purchases'))
		return $out;
	switch ($_GET['act']) {
		case 'sepet':
			$out = 'gtag(\'event\',\'begin_checkout\', {
				"items": [  //items arrayin içinde sepette bulunan ürünleri tek tek belirtmeliyiz.
				  
					  ' . googlePurchasesSepetList() . '
				  		   
			   ],
				 "checkout_step": 1
			   });';
			break;
		case 'satinal':
			if (!$tamamlandi) {
				switch($_GET['op'])
				{
					case 'adres':
						$out = 'gtag(\'event\',\'checkout_progress\', {
							"items": [  //items arrayin içinde sepette bulunan ürünleri tek tek belirtmeliyiz.
							
								' . googlePurchasesSepetList() . '
									   
						],
							"checkout_step": '.(int)($_POST['data_lastname']?3:2).'
						});';
					break;
					case 'odeme':
						$out = 'gtag(\'event\',\'checkout_progress\', {
							"items": [  //items arrayin içinde sepette bulunan ürünleri tek tek belirtmeliyiz.
							
								' . googlePurchasesSepetList() . '
									   
						],
							"checkout_step": 3
						});';
					break;
				}
			}
			else
			{
				$out = 'gtag(\'event\', \'purchase\', {
					"transaction_id": "'.$orandStr.'",					
					"value": '.basketInfo('toplamKDVHaric', $orandStr).',					
					"currency": "TRY",				
					"tax": '.basketInfo('toplamKDV', $orandStr).',					
					"shipping": '.basketInfo('kargo', $orandStr).',					
					"items": [
						'.googlePurchasesSepetList().'	
						]				
					});
					';
			}
			break;
	}
	if($out)
		$out = '<script type="text/javascript">'.$out.'</script>';
	return $out;
}
?>