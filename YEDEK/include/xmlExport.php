<?
@set_time_limit(0);
$_POST['kar'] = $_GET['kar'] = str_replace(',', '.', $_POST['kar']);
class SimpleXMLElementExtended extends SimpleXMLElement
{
	public function addChildWithCDATA($name, $value = null)
	{
		$new_child = $this->addChild($name);
		if ($new_child !== null) {
			$node = dom_import_simplexml($new_child);
			$no = $node->ownerDocument;
			$node->appendChild($no->createCDATASection($value));
		}
		return $new_child;
	}
}

function buildShopphpBasketXMLFile($randStr, $msg)
{
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><Sepet></Sepet>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	$xml->addChild('Mesaj', $msg);
	$xml->addChild('basketID', $randStr);

	$detay = $xml->addChild('Detay', '');
	$q = my_mysql_query("select * from sepet where randStr = '$randStr'");
	while ($d = my_mysql_fetch_array($q)) {
		$channel = $detay->addChild('Satir', '');
		foreach ($d as $k => $v) {
			if (!is_int($k))
				$channel->addChild($k, $v);
		}
	}
	return $xml->asXML();
}

function buildentegrasiparislerXMLFile()
{
	global $mcode;
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><SIPARISLER></SIPARISLER>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	if ($_GET['start-date'])
		$f = ' AND tarih >= \'' . $_GET['start-date'] . '\' AND tarih <= \'' . $_GET['finish-date'] . '\'';

		$q = my_mysql_query("select * from siparis where durum >= 2 AND durum < 90  $f order by ID desc limit 0,500");
	while ($d = my_mysql_fetch_array($q)) {
		$channel = $xml->addChild('SIPARIS', '');
		list($tarih, $zaman) = explode(' ', $d['tarih']);
		$channel->addChild('SIPARIS_NO', $mcode . ($d['randStr']));
		$channel->addChild('PAZARYERI_KARGOKODU', (str_replace('&prime;', '', $d['kKampanyaKodu'])));
		if ($d['userID'])
			$channel->addChild('CariHesapKodu', $mcode . ($d['userID']));
		else
			if ($d['userID'])
			$channel->addChild('CariHesapKodu', $mcode . ($d['ID']));
		$channel->addChild('CariHesapOzelKodu', $mcode . $d['userID']);
		$channel->addChild('POSTA', ($d['email']));
		$channel->addChild('TARIH', ($tarih));
		$channel->addChild('sipariszaman', ($zaman));
		$channel->addChild('ISKONTO', $d['degisimYuzde']);
		$channel->addChild('PROMOSYON', $d['promotionUsed']);
		if($d['promotionUsed'])
			$d['notAlici'].=' Promosyon : '.$d['promotionUsed'].' TL';
		$channel->addChild('NET_TOPLAM', my_money_format('', $d['toplamKDVDahil']));
		$channel->addChild('ODENEN_TOPLAM', my_money_format('', $d['toplamTutarTL']));
		$d['address'] = str_replace(array('&prime;'), '', $d['address']);
		$d['address'] = str_replace(array('&reg;'), '', $d['address']);

		$channel->addChild('TeslimAlici', cleanStr(str_replace('&', '&amp;', $d['name']) . ' ' . $d['lastname']));
		$channel->addChild('TeslimAdresi', ($d['address']));
		$channel->addChild('TeslimTelefon', ($d['ceptel']));
		$channel->addChild('teslimsekli', (hq("select kod from teslimat where ID='" . $d['teslimatID'] . "'")));
		$channel->addChild('tasiyicifirma', (hq("select kod from kargofirma where ID='" . $d['kargoFirmaID'] . "'")));
		$channel->addChild('teslimkod1', (hq("select data1 from user where ID='" . $d['userID'] . "'")));
		$channel->addChild('teslimkod4', (hq("select data2 from user where ID='" . $d['userID'] . "'")));
		$channel->addChild('teslimil', (hq("select name from iller where plakaID='" . $d['city'] . "'")));
		$channel->addChild('teslimilce', (hq("select name from ilceler where ID='" . $d['semt'] . "'")));
		$channel->addChild('faturaalici', ($d['firmaUnvani']));
		$channel->addChild('faturaAdresi', cleanStr($d['address2']));
		$channel->addChild('faturaTelefon', ($d['ceptel']));
		$channel->addChild('faturavergino', ($d['vergiNo']));
		$channel->addChild('faturavergidairesi', ($d['vergiDaire']));
		$channel->addChild('faturail', (hq("select name from iller where plakaID='" . $d['city2'] . "'")));
		$channel->addChild('faturailce', (hq("select name from ilceler where ID='" . $d['semt2'] . "'")));
		$channel->addChild('kargokodu', $mcode . ($d['randStr']));
		$d['notAlici'] = str_replace(array('&prime;'), '', $d['notAlici']);
		$d['notAlici'] = str_replace(array('&reg;'), '', $d['notAlici']);
		$channel->addChild('siparisnotu', ($d['notAlici']));


		$kod = tr2eu(strtoupper(str_replace(' ', '', hq("select name from kargofirma where ID='" . $d['kargoFirmaID'] . "'"))));
		$kod = str_replace('i', 'I', $kod);
		//$channel->addChild('tasiyicifirma', $kod);


		$channel->addChild('kargo_odemesi', $d['ekargoID']);


		list($pre, $x) = explode('-', $d['randStr']);
		switch (strtolower($pre)) {
			case 'n11':
				$d['eodemeID'] = 4;
				break;
			case 'ty':
				$d['eodemeID'] = 15;
				break;
			case 'gg':
				$d['eodemeID'] = 5;
				break;
			case 'az':
				$d['eodemeID'] = 16;
				break;
			case 'hb':
				$d['eodemeID'] = 7;
				break;
		}

		if(!(stristr(strtolower($d['odemeTipi']),'havale') === false))
		{
			$d['eodemeID'] = 3;
		}

		if(hq("select ID from banka where ID='".$d['odemeID']."' AND taksitOrani = 1"))
		{
			$d['eodemeID'] = 2;
		}

		$channel->addChild('ODEME_SEKLI', ($d['eodemeID']));
		$trans = $channel->addChild('SATIRLAR', '');
		$q2 = my_mysql_query("select * from sepet where randStr like '" . $d['randStr'] . "'");
		while ($d2 = my_mysql_fetch_array($q2)) {
			$urunBirim = hq("select urunBirim from urun where ID='" . $d2['urunID'] . "'");
			$urunKod = hq("select tedarikciCode from urun where ID='" . $d2['urunID'] . "'");
			if (!$urunBirim)
				$urunBirim = 'Ad.';
			$transs = $trans->addChild('SATIR', '');
			$varkod = hq("select kod from urunvarstok where up=1 AND urunID='" . $d2['urunID'] . "' AND var1='" . $d2['ozellik1'] . "'AND var2='" . $d2['ozellik2'] . "'");
			$transs->addChild('VARKOD', $varkod ? $varkod : $d2['ID']);
			$transs->addChild('KOD', ($urunKod ? $urunKod : $d2['urunID']));
			$transs->addChild('MIKTAR', ($d2['adet']));
			$transs->addChild('BIRIM', $urunBirim);
			$transs->addChild('FIYAT', (my_money_format('', ($d2['ytlFiyat'] * 1))));
			$transs->addChild('KDV', (hq("select kdv from urun where ID='" . $d2['urunID'] . "'") * 100));
		}
		if ($d['kargoTutar']) {
			$transs = $trans->addChild('SATIR', '');
			$transs->addChild('KOD', $kod);
			$transs->addChild('MIKTAR', 1);
			$transs->addChild('BIRIM', 'Ad.');
			$transs->addChild('FIYAT', my_money_format('', $d['kargoTutar']));
			$transs->addChild('KDV', 18);
		}
		if ($d['degisimYTL']) {
			$kod2 = tr2eu(strtoupper(str_replace(' ', '', hq("select bankaAdi from banka where ID='" . $d['odemeID'] . "'"))));
			$kod2 = str_replace('i', 'I', $kod2);
			$transs = $trans->addChild('SATIR', '');
			$transs->addChild('KOD', $kod2);
			$transs->addChild('MIKTAR', 1);
			$transs->addChild('BIRIM', 'Ad.');
			$transs->addChild('FIYAT', my_money_format('', $d['degisimYTL']));
			$transs->addChild('KDV', 18);
		}
	}
	return $xml->asXML();
}
function buildpttavmXMLFile()
{
	global $siteDizini;
	$kar = hq("select data1 from xmlexport where code like '" . $_GET['c'] . "'");
	switch ($_GET['type']) {
		case 'kategori':
			$defaultXML = '<?xml version="1.0" encoding="utf-8"?><kategoriler></kategoriler>';
			$xml = new SimpleXMLElementExtended($defaultXML);
			$order = 'order by level,seq,name';
			if ($_GET['order']) $order = 'order by ' . $_GET['order'];
			$filter = ($_GET['catID'] ? ' AND ID=\'' . $_GET['catID'] . '\'' : '');
			$filter .= ($_GET['level'] ? ' AND level<=\'' . $_GET['level'] . '\'' : '');
			$q = my_mysql_query("select * from kategori where active=1 $filter $order");
			while ($d = my_mysql_fetch_array($q)) {
				$channel = $xml->addChild('kategori', '');
				$channel->addChild('kategori_aktif', ($d['active']));
				$channel->addChild('kategori_kod', ($d['ID']));
				$channel->addChild('ust_kategori_kod', ($d['parentID']));
				$channel->addChild('kategori_ad', (cleanstr($d['name'])));
				$channel->addChild('kategori_path', (cleanstr($d['namePath'])));
				$channel->addChild('toplam_urun', (hq("select count(*) from urun where showCatIDs like '%|" . $d['ID'] . "|%' AND fiyat > 0 AND bakiyeOdeme = 0 AND active = 1")));
			}
			break;
		default:
			$defaultXML = '<?xml version="1.0" encoding="utf-8"?><Response><Products></Products></Response>';
			$xml = new SimpleXMLElementExtended($defaultXML);
			$order = 'order by catID';
			$start = ($_GET['start'] ? $_GET['start'] : 0);
			if ($_SESSION['userGroupID']) {
				$userID = $_SESSION['userID'];
				$xmlCat = hq("select xmlcat from userGroups where ID='" . $_SESSION['userGroupID'] . "'");
				$xmlMarka = hq("select xmlmarka from userGroups where ID='" . $_SESSION['userGroupID'] . "'");
			}
			$filter = '';
			if ($_GET['limit']) $limit = 'limit ' . $start . ',' . (int) $_GET['limit'];
			if ($_GET['markaID']) $filter .= 'AND urun.markaID= ' . (int) $_GET['markaID'];
			//if ($_GET['filter']) $filter = 'AND urun.'.$_GET['filter'].' = 1';
			//if ($_GET['order']) $order = 'order by urun.'.$_GET['order'];
			if ($_GET['tID']) $filter .= 'AND urun.tedarikciID= ' . (int) $_GET['tID'];
			if ($_GET['catID']) $filter .= "AND (showCatIDs like '%|" . $_GET['catID'] . "|%' OR catID='" . $_GET['catID'] . "' OR kategori.idPath like '%/" . $_GET['catID'] . "/%' OR kategori.idPath like '" . $_GET['catID'] . "/%')";
			if ($_GET['tIDs']) {
				$filter = 'AND (';
				$tIDs = explode(',', $_GET['tIDs']);
				foreach ($tIDs as $tID) {
					$tID = (int) $tID;
					if ($tID)
						$filter .= 'urun.tedarikciID = \'' . $tID . '\' OR ';
				}
				$filter .= ' 1 = 2) ';
			}

			$q = my_mysql_query("select urun.*,kategori.ckar,kategori.pttkar,kategori.pttcode,marka.name markaName from urun,kategori,marka where kategori.noxml != 1 AND urun.noxml != 1 AND urun.markaID = marka.ID AND urun.catID=kategori.ID AND catID!=0 AND markaID!=0 AND bakiyeOdeme=0 AND urun.active=1 AND kategori.active = 1  $filter $order $limit");
			while ($d = my_mysql_fetch_array($q)) {
				if ($d['noxml']) continue;
				if ($xmlCat && (stristr($xmlCat, ',' . $d['catID'] . ',') === false))
					continue;
				if ($xmlMarka && (stristr($xmlMarka, ',' . $d['markaID'] . ',') === false))
					continue;

				$barkod = ($d['gtin'] ? $d['gtin'] : $d['ID']);
				$d['fiyat'] = fixFiyat($d['fiyat'], 0, $d);
				if (!$_GET['facebook'])
					$d['fiyat'] = ($d['fiyat'] * (1 + $d['ckar']));
				$d['fiyat'] = ($d['fiyat'] * (1 + $d['pttkar']));
				if ($kar)
					$d['fiyat'] = ((1 + (float)$kar) * $d['fiyat']);
				if (!$d['gtin'])
					$d['gtin'] = $d['tedarikciCode'];
				$channel = $xml->addChild('StokUrun', '');
				$channel->addChild('Barkod', $barkod);
				$channel->addChild('UrunID', ($d['ID']));
				$channel->addChild('kategoriid', ($d['pttcode']));


				$channel->addChild('UrunAdi', (cleanstr($d['name'])));
				$fiyatYTL = YTLfiyat($d['fiyat'], $d['fiyatBirim']);
				$fiyatkdvli = $fiyatYTL;
				$fiyat2 = (float) str_replace(',', '', my_money_format('', ((float) $fiyatkdvli / (1 + (float) $d['kdv']))));
				$channel->addChild('KDVsiz', $fiyat2);
				$kdvset = str_replace(array('0.18', '0.08'), array('18', '8'), $d['kdv']);
				$channel->addChild('KDVOran', ($kdvset));
				$channel->addChild('KDVli', $fiyatkdvli);
				$channel->addChild('para_cinsi', 'TL');
				$channel->addChild('Aciklama', cleanstr($d['onDetay']));
				$channel->addChild('UzunAciklama', cleanstr($d['detay']));
				$channel->addChild('Miktar', ($d['stok']));
				$channel->addChild('Iskonto', ($d['sigorta']));
				$channel->addChild('Desi', ($d['sigorta']));
				if ($d['varID1'] || $d['varID2']) {
					$urunvar = $channel->addChild('VariantListesi');
					$var1 = (cleanstr(hq("select ozellik from var where ID='" . $d['varID1'] . "'")));
					$var2 = (cleanstr(hq("select ozellik from var where ID='" . $d['varID2'] . "'")));
					$vq = my_mysql_query("select * from urunvarstok where urunID='" . $d['ID'] . "'");
					while ($vd = my_mysql_fetch_array($vq)) {
						$vBarkod = ($vd['kod'] ? $vd['kod'] : $vd['ID']);
						$var = $urunvar->addChild('Variant');
						$var->addChild('AnaUrunKodu', $barkod);
						$var->addChild('VariantBarkod', $vBarkod);
						$attr = $var->addChild('Attributes');
						$price = YTLfiyat($vd['fark'], $d['fiyatBirim']);
						$vAttr = $attr->addChild('VariantAttr');
						$vAttr->addChild('Deger', $var1.($var2?' - ':'').$var2);
						$vAttr->addChild('Tanim', cleanstr($vd['var1'].($vd['var2']?' - ':'').$vd['var2']));
						$vAttr->addChild('FiyatFarkiMi', (bool)$price);
						$vAttr->addChild('Fiyat', $price);
					}
				}
				for ($j = 1; $j <= 5; $j++) {
					$resimStr = 'resim' . ($j == 1 ? '' : $j);
					if ($d[$resimStr])
						$channel->addChild('UrunResim', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d[$resimStr]));
				}
			}

			break;
	}
	if ($_GET['username'] && $_GET['password'])
		$_SESSION['userID'] = $_SESSION['username'] = $_SESSION['password'] = $_SESSION['loginStatus'] = $_SESSION['siparisID'] = $_SESSION['bayi'] = '';
	$xml->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}

function insertXMLData($string, $value, $charset = 'UTF-8',$c = false)
{
	$value = str_replace('&Yacute;', 'İ', $value);
	$value = str_replace('&yacute;', 'i', $value);
	if($c)
		return "\t\t\t<$string><![CDATA[" . str_replace(array('&#39;'),array("'"),$value) . "]]></$string>\n";
	return "\t\t\t<$string>" . xml_entities($value, $charset) . "</$string>\n";
}
function xml_entities($text, $charset = 'UTF-8')
{
	$text = htmlspecialchars($text, ENT_COMPAT, $charset, true);
	$arr_xml_special_char = array("&quot;", "&amp;", "&apos;", "&lt;", "&gt;");
	$arr_xml_special_char_regex = "(?";
	foreach ($arr_xml_special_char as $key => $value) {
		$arr_xml_special_char_regex .= "(?!$value)";
	}
	$arr_xml_special_char_regex .= ")";
	$pattern = "/$arr_xml_special_char_regex&([a-zA-Z0-9]+;)/";
	$replacement = '&amp;${1}';
	return preg_replace($pattern, $replacement, $text);
}
function xmlDosyaYaz($dosyaadi, $data)
{
	$out = "";
	$data = str_replace('&#39;', "'", $data);
	//if (!file_exists($dosyaadi)) $dosyaadi = str_replace('../','',$dosyaadi);
	$dosyaadi = str_replace('../', $_SERVER['DOCUMENT_ROOT'] . '/', $dosyaadi);
	if (!$dene = fopen($dosyaadi, 'w+')) {
		$out = "Dosya açılamadı";
	} else {
		$data = stripslashes($data);
		if (fwrite($dene, $data) === false) {
			$out = "Dosyaya Yazılamıyor";
		} else $out = "Dosya kaydedildi.";
	}
	return $out;
}
function getCodeFromName2($name)
{
	return substr(md5(utf8fix($name)), 0, 5);
}
function seofix2($str)
{
	$str = strtolower(trim(tr2eu($str)));
	$str = preg_replace('/[^a-z0-9-]/', '-', $str);
	$str = preg_replace('/-+/', "-", $str);
	return $str;
}

function buildautomSiparisLogoXMLFile()
{
	global $serialx;
	if ($_GET['xmlc'] != substr(md5($_GET['c'] . $serialx), 0, 10))
		exit();
	global $mcode;
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><SIPARISLER></SIPARISLER>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	if ($_GET['start-date'])
		$f = ' AND tarih >= \'' . $_GET['start-date'] . '\' AND tarih <= \'' . $_GET['finish-date'] . '\'';
	$q = my_mysql_query("select * from siparis where durum > 1 AND durum < 90 $f");
	while ($d = my_mysql_fetch_array($q)) {
		$channel = $xml->addChild('SIPARIS', '');
		list($tarih, $zaman) = explode(' ', $d['tarih']);
		list($saat, $dk, $sn) = explode(':', $zaman);
		$channel->addChild('SIPARIS_NO', $mcode . ($d['randStr']));
		$channel->addChild('PAZARYERI_KARGOKODU', (str_replace('&prime;', '', $d['kKampanyaKodu'])));
		if ($d['userID'])
			$channel->addChild('CariHesapKodu', $mcode . ($d['userID']));
		else
			if ($d['userID'])
			$channel->addChild('CariHesapKodu', $mcode . ($d['ID']));
		$channel->addChild('CariHesapOzelKodu', $mcode . $d['randStr']);
		$channel->addChild('POSTA', ($d['email']));
		$channel->addChild('TARIH', ($tarih));
		$channel->addChild('sipariszaman', ($zaman));
		$channel->addChild('ISKONTO', 0);
		$channel->addChild('NET_TOPLAM', my_money_format('', $d['toplamKDVDahil']));
		$channel->addChild('ODENEN_TOPLAM', my_money_format('', $d['toplamTutarTL']));
		$d['address'] = str_replace(array('&prime;'), '', $d['address']);
		$d['address'] = str_replace(array('&reg;'), '', $d['address']);

		$channel->addChild('TeslimAlici', ($d['name'] . ' ' . $d['lastname']));
		$channel->addChild('TeslimAdresi', ($d['address']));
		$channel->addChild('TeslimTelefon', ($d['ceptel']));

		$channel->addChild('teslimsekli', (hq("select kod from teslimat where ID='" . $d['teslimatID'] . "'")));
		$channel->addChild('tasiyicifirma', (hq("select kod from kargofirma where ID='" . $d['kargoFirmaID'] . "'")));
		$channel->addChild('teslimkod1', (hq("select data1 from user where ID='" . $d['userID'] . "'")));
		$channel->addChild('teslimkod4', (hq("select data2 from user where ID='" . $d['userID'] . "'")));
		$channel->addChild('teslimil', (hq("select name from iller where plakaID='" . $d['city'] . "'")));
		$channel->addChild('teslimilce', (hq("select name from ilceler where ID='" . $d['semt'] . "'")));
		$channel->addChild('faturaalici', ($d['firmaUnvani']));
		$channel->addChild('faturaAdresi', ($d['address2']));
		$channel->addChild('faturaTelefon', ($d['ceptel']));
		$channel->addChild('faturavergino', ($d['vergiNo']));
		$channel->addChild('faturavergidairesi', ($d['vergiDaire']));
		$channel->addChild('faturail', (hq("select name from iller where plakaID='" . $d['city2'] . "'")));
		$channel->addChild('faturailce', (hq("select name from ilceler where ID='" . $d['semt2'] . "'")));
		$channel->addChild('kargokodu', $mcode . ($d['randStr']));

		$trans = $channel->addChild('ODEME_SEKLI', ($d['odemeTipi']));
		$trans = $channel->addChild('SATIRLAR', '');
		$q2 = my_mysql_query("select * from sepet where randStr like '" . $d['randStr'] . "'");
		while ($d2 = my_mysql_fetch_array($q2)) {
			$transs = $trans->addChild('SATIR', '');
			$transs->addChild('VARKOD', hq("select kod from urunvarstok where up=1 AND urunID='" . $d2['urunID'] . "' AND var1='" . $d2['ozellik1'] . "' AND var2='" . $d2['ozellik2'] . "'"));
			$transs->addChild('KOD', (hq("select tedarikciCode from urun where ID='" . $d2['urunID'] . "'")));
			$transs->addChild('MIKTAR', ($d2['adet']));
			$transs->addChild('BIRIM', (hq("select urunBirim from urun where ID='" . $d2['urunID'] . "'")));
			$transs->addChild('FIYAT', (my_money_format('', ($d2['ytlFiyat'] * 1))));
			$transs->addChild('KDV', (hq("select kdv from urun where ID='" . $d2['urunID'] . "'") * 100));
		}

		/*
			$transs = $trans->addChild('SATIR','');
		$kod = tr2eu(strtoupper(str_replace(' ','',hq("select name from kargofirma where ID='".$d['kargoFirmaID']."'"))));
		$kod = str_replace('i','I',$kod);
		$transs->addChild('KOD',$kod);
		$transs->addChild('MIKTAR',1);
		$transs->addChild('BIRIM','Ad.');			
		$transs->addChild('FIYAT',my_money_format('',$d['kargoTutar']));
        $transs->addChild('KDV',18);
		 */
	}
	return $xml->asXML();
}
function buildYksXMLFile()
{
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><document></document>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	$q = my_mysql_query("SELECT * FROM siparis WHERE siparis.durum =  '3' GROUP BY siparis.randStr ORDER BY siparis.ID DESC, siparis.randStr DESC");
	while ($d = my_mysql_fetch_array($q)) {
		$channel = $xml->addChild('cargo', '');
		$telefon = $d['ceptel'];
		$telefonfix = str_replace(array('-', 'YEN'), array('', 'JPY'), $telefon);
		if (strlen($telefonfix) > 10) $tel = substr($telefonfix, 1, 10);
		$telhome = '';
		$fatura_num = $d['randStr'];
		$fatura_seri = '000';
		$fatura_no = $fatura_seri . $fatura_num;
		$invocie = $d['toplamTutarTL'];
		$invfixxx = str_replace('.', ',', $invocie);
		$paymentfix = (int) (!(stristr(strtolower($d['odemeTipi']), 'kapida') === false) || !(stristr(strtolower($d['odemeTipi']), 'kapıda') === false) || !(stristr(strtoupper($d['odemeTipi']), 'KAPI') === false));
		$channel->addChild('receiver_name', cleanStr($d['name'] . ' ' . $d['lastname']));
		$channel->addChild('receiver_address', cleanStr(htmlentities($d['address']) . ' ' . hq("select name from ilceler where ID='" . $d['semt'] . "'") . ' ' . hq("select name from iller where plakaID='" . $d['city'] . "'")));
		$channel->addChild('city', cleanStr(hq("select name from iller where plakaID='" . $d['city'] . "'")));
		$channel->addChild('town', cleanStr(hq("select name from ilceler where ID='" . $d['semt'] . "'")));
		$channel->addChild('phone_work', ($telhome));
		$channel->addChild('phone_gsm', ($tel));
		$channel->addChild('email_address', ($d['email']));
		$channel->addChild('tax_number', ($d['tckNo']));
		$channel->addChild('cargo_type', ('2'));
		$channel->addChild('payment_type', ($paymentfix));
		$channel->addChild('dispatch_number', ($fatura_no));
		$channel->addChild('referans_number', ($d['randStr']));
		$channel->addChild('cargo_count', ('1'));
		$channel->addChild('cargo_content', ('Ürün'));
		$channel->addChild('collection_type', ('0'));
		$channel->addChild('invoice_number', ($fatura_no));
		$channel->addChild('invoice_amount', ($invfixxx));
	}
	$xml->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}
function buildstockmountXMLFile()
{
	global $siteDizini;
	switch ($_GET['type']) {
		case 'kategori':
			$defaultXML = '<?xml version="1.0" encoding="utf-8"?><kategoriler></kategoriler>';
			$xml = new SimpleXMLElementExtended($defaultXML);
			$order = 'order by level,seq,name';
			if ($_GET['order']) $order = 'order by ' . $_GET['order'];
			$filter = ($_GET['catID'] ? ' AND ID=\'' . $_GET['catID'] . '\'' : '');
			$filter .= ($_GET['level'] ? ' AND level<=\'' . $_GET['level'] . '\'' : '');
			$q = my_mysql_query("select * from kategori where active=1 $filter $order");
			while ($d = my_mysql_fetch_array($q)) {
				$channel = $xml->addChild('kategori', '');
				$channel->addChild('kategori_aktif', ($d['active']));
				$channel->addChild('kategori_kod', ($d['ID']));
				$channel->addChild('ust_kategori_kod', ($d['parentID']));
				$channel->addChild('kategori_ad', (cleanstr($d['name'])));
				$channel->addChild('kategori_path', (cleanstr($d['namePath'])));
				$channel->addChild('toplam_urun', (hq("select count(*) from urun where showCatIDs like '%|" . $d['ID'] . "|%' AND fiyat > 0 AND bakiyeOdeme = 0 AND active = 1")));
			}
			break;
		default:
			$defaultXML = '<?xml version="1.0" encoding="utf-8"?><urunler></urunler>';
			$xml = new SimpleXMLElementExtended($defaultXML);
			$order = 'order by catID';
			$start = ($_GET['start'] ? $_GET['start'] : 0);
			if ($_SESSION['userGroupID']) {
				$xmlCat = hq("select xmlcat from userGroups where ID='" . $_SESSION['userGroupID'] . "'");
				$xmlMarka = hq("select xmlmarka from userGroups where ID='" . $_SESSION['userGroupID'] . "'");
			}
			
			$userID = $_SESSION['userID'];
			$srg="DB".$userID;
			
			if ($_GET['limit']) $limit = 'limit ' . $start . ',' . (int) $_GET['limit'];
			if ($_GET['markaID']) $filter = 'AND urun.markaID= ' . (int) $_GET['markaID'];
			if ($_GET['tID']) $filter = 'AND urun.tedarikciID= ' . (int) $_GET['tID'];
			if ($_GET['order']) $order = 'order by urun.' . $_GET['order'];
			if ($_GET['catID']) $filter .= "AND (showCatIDs like '%|" . $_GET['catID'] . "|%' OR catID='" . $_GET['catID'] . "' OR kategori.idPath like '%/" . $_GET['catID'] . "/%' OR kategori.idPath like '" . $_GET['catID'] . "/%')";
			$q = my_mysql_query("select urun.*,kategori.ckar,marka.name markaName from urun,kategori,marka where urun.noxml != 1 AND kategori.noxml != 1 AND urun.markaID = marka.ID AND urun.catID=kategori.ID AND catID!=0 AND markaID!=0 AND bakiyeOdeme=0 AND urun.active=1 AND kategori.active = 1  $filter $order $limit");
			while ($d = my_mysql_fetch_array($q)) {
				if ($d['noxml']) continue;
				$gercekFiyat = $d['fiyat'];
				$d['fiyat'] = fixFiyat($d['fiyat'], 0, $d);
				if (!$_GET['facebook'])
					$d['fiyat'] = ($d['fiyat'] * (1 + $d['ckar']));
				if ($xmlCat && (stristr($xmlCat, ',' . $d['catID'] . ',') === false))
					continue;
				if ($xmlMarka && (stristr($xmlMarka, ',' . $d['markaID'] . ',') === false))
					continue;
				$channel = $xml->addChild('Product', '');
				$channel->addChild('ProductCode', ($d['ID']));
				$channel->addChild('ProductName', (cleanstr($d['name'])));
				$channel->addChild('Quantity', ($d['stok']));
				$channel->addChild('Price', ($d['fiyat']));
				$channel->addChild('Barcode', ($d['gtin']));

				$channel->addChild('Currency', ($d['fiyatBirim']));
				$getkdv = $d['kdv'];
				$kdvreplacer = str_replace(array('0.18', '0.08', '0.01'), array('18', '8', '1'), $getkdv);
				$channel->addChild('TaxRate', ($kdvreplacer));
				$getCatName = hq("select namePath from kategori where ID='" . $d['catID'] . "'");
				$replaceCatName = str_replace(array('/'), array(' > '), $getCatName);
				$channel->addChild('Category', ($replaceCatName));
				$parentID = $d['catID'];
				$catname = cleanstr(hq("select name from kategori where ID='" . $parentID . "'"));
				$parentID2 = hq("select parentID from kategori where ID='" . $parentID . "'");
				$catname2 = cleanstr(hq("select name from kategori where ID='" . $parentID2 . "'"));
				$parentID3 = hq("select parentID from kategori where ID='" . $parentID2 . "'");
				$catname3 = cleanstr(hq("select name from kategori where ID='" . $parentID3 . "'"));
				$parentID4 = hq("select parentID from kategori where ID='" . $parentID3 . "'");
				$catname4 = cleanstr(hq("select name from kategori where ID='" . $parentID4 . "'"));
				$parentID5 = hq("select parentID from kategori where ID='" . $parentID4 . "'");
				$catname5 = cleanstr(hq("select name from kategori where ID='" . $parentID5 . "'"));
				//$catname = str_replace('&','&amp;',$catname);
				$channel->addChild('cat5code', ($parentID5));
				$channel->addChild('cat5name', ($catname5));
				$channel->addChild('cat4code', ($parentID4));
				$channel->addChild('cat4name', ($catname4));
				$channel->addChild('cat35code', ($parentID3));
				$channel->addChild('cat3name', ($catname3));
				$channel->addChild('cat2code', ($parentID2));
				$channel->addChild('cat2name', ($catname2));
				$channel->addChild('cat1code', ($parentID));
				$channel->addChild('cat1name', ($catname));
				$siteMainURL = 'http://' . $_SERVER[HTTP_HOST] . '/images/urunler/';
				$emptybas = '';
				$VolumeData = '2';
				if ($d['resim']) {
					$channel->addChild('Image1', ($siteMainURL . $d['resim']));
				}
				if ($d['resim2']) {
					$channel->addChild('resim2', ($siteMainURL . $d['resim2']));
				}
				if ($d['resim3']) {
					$channel->addChild('resim3', ($siteMainURL . $d['resim3']));
				}
				if ($d['resim4']) {
					$channel->addChild('resim4', ($siteMainURL . $d['resim4']));
				}

				$channel->addChild('Brand', (cleanstr($d['markaName'])));
				$channel->addChild('Model', (cleanstr($emptybas)));
				$channel->addChild('Volume', (cleanstr($VolumeData)));
				$channel->addChild('Description', htmlspecialchars($d['detay']));
				$channel->addChild('DBbarkod', $srg.($d['gtin']));
				if ($d['varID1'] || $d['varID2']) {
					$urunvar = $channel->addChild('Variants');
					$var1 = (cleanstr(hq("select ozellik from var where ID='" . $d['varID1'] . "'")));
					$var2 = (cleanstr(hq("select ozellik from var where ID='" . $d['varID2'] . "'")));
					$vq = my_mysql_query("select kod,stok,var1,var2,gtin from urunvarstok where urunID='" . $d['ID'] . "'");
					while ($vd = my_mysql_fetch_array($vq)) {
						$var = $urunvar->addChild('Variant');
						$price = (hq("select fark from urunvars where urunID='" . $d['ID'] . "' AND varID='" . $d['varID1'] . "' AND var like '" . $vd['var1'] . "'") + hq("select fark from urunvars where urunID='" . $d['ID'] . "' AND varID='" . $d['varID2'] . "' AND var like '" . $vd['var2'] . "'"));
						//$new = $var->addChild('var1');
						
						$f1=$d['fiyat'];
						
						$varyantName = str_replace(array('SEÇINIZ'), array(''), $var1);
						$varyantName2 = str_replace(array('SEÇINIZ'), array(''), $var2);
						$var->addChild('VariantCode', $vd['kod']);
						$var->addChild('VariantBarcode', $vd['gtin']);

						$var->addChild('VariantQuantity', $vd['stok']);
						$var->addChild('VariantPrice', $price+$f1);
						$var->addChild('VariantName1', $varyantName);
						$var->addChild('VariantValue1', (cleanstr($vd['var1'])));
						$var->addChild('VariantName2', $varyantName2);
						$var->addChild('VariantValue2', (cleanstr($vd['var2'])));
					}
				}
				$channel->addChild('urun_ozellikler', (filterSpecs($d['ID'])));
				for ($j = 1; $j <= 5; $j++) {
					$resimStr = 'resim' . ($j == 1 ? '' : $j);
					if ($d[$resimStr])
						$channel->addChild('urun_resim' . $j, ('http' . (siteConfig('httpsAktif')  ? 's' : '') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d[$resimStr]));
				}
				$fiyat1 = $d['piyasafiyat'];
				$fiyat2 = $d['fiyat'];
				$fiyat3 = $gercekFiyat;
				$fiyat1 = (float) str_replace(',', '', my_money_format('', ((float) $fiyat1 / (1 + (float) $d['kdv']))));
				$fiyat2 = (float) str_replace(',', '', my_money_format('', ((float) $fiyat2 / (1 + (float) $d['kdv']))));
				$fiyat3 = (float) str_replace(',', '', my_money_format('', ((float) $fiyat3 / (1 + (float) $d['kdv']))));
				$fiyatYTL = YTLfiyat($d['fiyat'], $d['fiyatBirim']);
				$fiyatYTL = ($fiyatYTL / (1 + $d['kdv']));
				$fiyatYTL = str_replace(',', '', $fiyatYTL);
				$channel->addChild('urun_fiyat', $fiyat2);
				$channel->addChild('urun_fiyat_TL', $fiyatYTL);
				
				
				$channel->addChild('urun_fiyat_son_kullanici', $fiyat1);
				$channel->addChild('urun_fiyat_site', $fiyat3);
				$channel->addChild('urun_fiyat_bayi_ozel', $fiyat2);
				$channel->addChild('urun_doviz', ($d['fiyatBirim']));
				$channel->addChild('urun_kdv', ($d['kdv']));
				$channel->addChild('urun_stok', ($d['stok']));
				$channel->addChild('urun_garanti', ($d['garanti']));
				if ($d['desi']) $channel->addChild('urun_kargo_desi', ($d['desi']));
				if ($d['fixKargoFiyat']) $channel->addChild('urun_kargo_fix_fiyat', ($d['fixKargoFiyat']));
			}
			break;
	}
	if ($_GET['username'] && $_GET['password'])
		$_SESSION['userID'] = $_SESSION['username'] = $_SESSION['password'] = $_SESSION['loginStatus'] = $_SESSION['siparisID'] = $_SESSION['bayi'] = '';
	$xml->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}
function buildStockmountXMLFile_()
{
	global $siteDizini, $siteConfig;
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><Products></Products>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	$order = 'order by catID';
	$start = ($_GET['start'] ? $_GET['start'] : 0);
	if ($_GET['limit']) $limit = 'limit ' . $start . ',' . (int) $_GET['limit'];
	if ($_GET['order']) $order = 'order by ' . $_GET['order'];
	$catPatern = hq("select idPath from kategori where ID='" . $_GET['catID'] . "'");
	if ($_GET['catID'])
		$filter = "AND (showCatIDs like '%|" . $_GET['catID'] . "|%' OR catID='" . $_GET['catID'] . "' OR kategori.idPath like '" . $catPatern . "/%')";
	$q = my_mysql_query("select urun.*,kategori.name as catName,kategori.ckar as ckar,marka.name as markaName,kategori.namePath as namePathx,kategori.yc_Kod as gg_Kodx from urun,kategori,marka where urun.active = 1 AND urun.catID=kategori.ID AND marka.ID = urun.markaID AND catID!=0 AND markaID!=0 AND fiyat > 0 AND urun.stok > 0 AND bakiyeOdeme=0 $filter $order $limit");
	if (!$_SESSION['userGroupID'])
		$_SESSION['userGroupID'] = userGroupID();
	if ($_SESSION['userGroupID']) {
		$xmlCat = hq("select xmlcat from userGroups where ID='" . $_SESSION['userGroupID'] . "'");
		$xmlMarka = hq("select xmlmarka from userGroups where ID='" . $_SESSION['userGroupID'] . "'");
	}
	while ($d = my_mysql_fetch_array($q)) {
		if ($xmlCat && (stristr($xmlCat, ',' . $d['catID'] . ',') === false))
			continue;
		if ($xmlMarka && (stristr($xmlMarka, ',' . $d['markaID'] . ',') === false))
			continue;
		$d['name'] = str_replace(array('&prime;'), '', $d['name']);
		$d['name'] = str_replace(array('&reg;'), '', $d['name']);
		$d['listeDetay'] = str_replace(array('&prime;'), '', $d['listeDetay']);
		$d['listeDetay'] = str_replace(array('&reg;'), '', $d['listeDetay']);
		$d['onDetay'] = str_replace(array('&prime;'), '', $d['onDetay']);
		$d['onDetay'] = str_replace(array('&reg;'), '', $d['onDetay']);
		$d['onDetay'] = str_replace(array('&nbsp;', '&nbsp'), ' ', ($d['onDetay']));
		$d['detay'] = str_replace(array('&prime;'), '', $d['detay']);
		$d['detay'] = str_replace(array('&reg;'), '', $d['detay']);
		$d['detay'] = str_replace(array('&nbsp;', '&nbsp'), ' ', ($d['detay']));
		$d['markaName'] = str_replace(array('&prime;'), '', $d['markaName']);
		$d['markaName'] = str_replace(array('&reg;'), '', $d['markaName']);
		$d['markaName'] = str_replace(array('&nbsp;', '&nbsp'), ' ', ($d['markaName']));
		$channel = $xml->addChild('Product', '');
		$channel->addChild('ProductCode', $d['data1']);
		$channel->addChild('ProductName', htmlspecialchars((substr($d['name'], 0, 65))));
		$channel->addChild('Quantity', (int) $d['stok']);
		$channel->addChild('EndUserPrice', (float) $d['piyasafiyat']);
		$channel->addChild('DealerPrice', (float) $d['fiyat']);
		$channel->addChild('Currency', $d['fiyatBirim']);
		$channel->addChild('TaxRate', ((float) $d['kdv']));
		$channel->addChild('Category', ($d['namePathx']) . '');
		$channel->addChild('Description', '' . (cleanStr($d['onDetay'] . '' . $d['detay'])) . '');
		if ($d['resim']) $channel->addChild('Image1', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim']));
		if ($d['resim2']) $channel->addChild('Image2', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim2']));
		if ($d['resim3']) $channel->addChild('Image3', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim3']));
		if ($d['resim4']) $channel->addChild('Image4', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim4']));
		if ($d['resim5']) $channel->addChild('Image5', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim5']));
		if ($d['resim6']) $channel->addChild('Image6', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim6']));
		if ($d['resim7']) $channel->addChild('Image7', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim7']));
		if ($d['resim8']) $channel->addChild('Image8', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim8']));
		if ($d['resim9']) $channel->addChild('Image9', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim9']));
		if ($d['resim10']) $channel->addChild('Image19', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim10']));
		$channel->addChild('Marka', ($d['markaName']));
		$variants = $channel->addChild('Variants', ''); {
			for ($i = 1; $i <= 3; $i++) {
				if ($d['ozellik' . $i]) {
					$vArray = explode("\n", $d['ozellik' . $i . 'detay']);
					foreach ($vArray as $v) {
						if (!$v) continue;
						$variant = $variants->addChild('Variant');
						list($name, $fark, $stok) = explode('|', $v);
						if (($stok == '' && $stok != 0 && $stok != '0'))
							$stok = $d['stok'];

						$title = seoFix(trim(tr2eu(utf8fix((cleanstr($d['ozellik' . $i]))))));
						$variant->addChild($title, (cleanstr($name)));
						$variant->addChild('VariantQuantity', (cleanstr($stok)));
					}
				}
			}
		}
	}
	$xml->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}
function buildautomNetsisStokXMLFile()
{
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><STOKLAR></STOKLAR>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	$q = my_mysql_query("select * from urun where active = 1 order by ID");
	while ($d = my_mysql_fetch_array($q)) {
		$channel = $xml->addChild('StokKarti', '');
		$channel->addChild('StokKodu', ($d['ID']));
		$channel->addChild('StokAdi', ($d['name']));
		$channel->addChild('Birim', ($d['urunBirim']));
		$channel->addChild('Fiyat', ($d['fiyat']));
		$channel->addChild('KdvOrani', ($d['kdv'] * 100));
		$channel->addChild('Aciklama', ($d['onDetay'] . $d['detay']));
	}
	$xml->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}
function buildautomNetsisSiparisXMLFile()
{
	global $serialx;
	if ($_GET['xmlc'] != substr(md5($_GET['c'] . $serialx), 0, 10))
		exit();
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><SIPARISLER></SIPARISLER>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	if ($_GET['start-date'])
		$f = ' AND tarih >= \'' . $_GET['start-date'] . '\' AND tarih <= \'' . $_GET['finish-date'] . '\'';
	$q = my_mysql_query("select * from siparis where durum >= 0 $f");
	while ($d = my_mysql_fetch_array($q)) {
		$channel = $xml->addChild('Siparis', '');
		list($tarih, $zaman) = explode(' ', $d['tarih']);
		list($saat, $dk, $sn) = explode(':', $zaman);
		$channel->addChild('Tarih', ($tarih));
		$channel->addChild('SiparisNo', ($d['randStr']));
		$channel->addChild('MusteriAdresi', ($d['name'] . ' ' . $d['lastname']));
		$channel->addChild('MusteriAdresi', (htmlentities($d['address']) . ' ' . hq("select name from ilceler where ID='" . $d['semt'] . "'") . ' ' . hq("select name from iller where plakaID='" . $d['city'] . "'")));
		$channel->addChild('Vkn', (($d['vergiNo'] ? $d['vergiNo'] : $d['tckNo'])));
		$channel->addChild('Aciklama', ($d['randStr'] . ' nolu siparis bilgileri.'));
		if (substr($d['randStr'], 0, 3) == 'GG_')
			$kanal = 'GittiGidiyor';
		else if (substr($d['randStr'], 0, 3) == 'N11_')
			$kanal = 'N11';
		else
			$kanal = 'Site Uzerinde';
		$channel->addChild('Kanal', ($kanal));
		$channel->addChild('OdemeSekli', ($d['odemeTipi']));
		$trans = $channel->addChild('SiparisKalemleri', '');
		$ix = 1;
		$q2 = my_mysql_query("select * from sepet where randStr = '" . $d['randStr'] . "'");
		while ($d2 = my_mysql_fetch_array($q2)) {
			$transs = $trans->addChild('Kalem', '');
			$transs->addChild('Sıra', $ix);
			$transs->addChild('StokKodu', $d2['urunID']);
			$transs->addChild('Miktar', ($d2['adet']));
			$transs->addChild('Fiyat', (str_replace(',', '', my_money_format('', ($d2['ytlFiyat'] * 1)))));
			$ix++;
		}
	}
	return $xml->asXML();
}

function buildKliksaXMLFile()
{
	global $siteDizini;
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><VendorProducts></VendorProducts>';
	$xmlx = new SimpleXMLElementExtended($defaultXML);
	$order = 'order by catID';
	$start = ($_GET['start'] ? $_GET['start'] : 0);
	if ($_GET['limit']) $limit = 'limit ' . $start . ',' . (int) $_GET['limit'];
	if ($_GET['order']) $order = 'order by ' . $_GET['order'];
	if ($_GET['catID']) $filter = "AND showCatIDs like '%|" . $_GET['catID'] . "|%'";
	$q = my_mysql_query("select urun.*,kategori.name as catName,marka.name as markaName,kategori.namePath as namePathx,kategori.parentID as catParentID from urun,kategori,marka where urun.noxml != 1 AND kategori.noxml != 1 AND urun.catID=kategori.ID AND marka.ID = urun.markaID AND catID!=0 AND markaID!=0 AND fiyat > 0 AND stok>0 AND bakiyeOdeme=0 $filter $order $limit");
	while ($d = my_mysql_fetch_array($q)) {
		$ozellikler = '<table class="urunSecimTable" cellpadding="0" cellspacing="0">';
		if ($d['ozellik1']) {
			$ozellikler .= '<tr><th colspan="3" class="UrunSecenekleri">' . _lang_urunSecenekleri . '</th></tr>';
		}
		for ($i = 1; $i <= 3; $i++) {
			if ($d['ozellik' . $i]) $ozellikler .= '<tr><td class="UrunSecenekleriHeader">' . $d['ozellik' . $i] . '</td><td>:</td><td class="UrunSecenekleriItems">' . spShowItemOptions($d, $i, '') . '</td></tr>';
		}
		$ozellikler .= '</table>' . "\n";
		$xml = $xmlx->addChild('Product', '');
		$xml->addChild('ProductCode', $d['ID']);
		$xml->addChild('CategoryCode', $d['catID']);
		$xml->addChild('CategoryName', (cleanStr(str_replace('/', '-', $d['catName']))));
		$xml->addChild('ProductName', cleanStr(($d['name'])));
		$xml->addChild('Description', (cleanStr($d['onDetay'] . $ozellikler) . htmlspecialchars($d['detay'], ENT_COMPAT, 'UTF-8', true)));
		$xml->addChild('Brand', (str_replace('&prime;', '', $d['markaName'])));
		$xml->addChild('Model', cleanStr(($d['onDetay'] . $d['listeDetay'])));
		$xml->addChild('TaxRate', ($d['kdv'] * 100));
		$xml->addChild('Ean', ($d['tedarikciCode']));
		$xml->addChild('Volume', (''));
		$xml->addChild('Stock', ($d['stok']));
		$xml->addChild('MainImageUrl', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim']));
		$sub = $xml->addChild('SubImages');
		for ($i = 2; $i <= 5; $i++) {
			if ($i > 1) $n = $i;
			else $n = '';
			if ($d['resim' . $n]) $sub->addChild('Image' . $i, ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim' . $n]));
		}
		$xml->addChild('PurchasePrice', YTLfiyat($d['fiyat'], $d['fiyatBirim']));
		$xml->addChild('PurchasePriceCurrency', 'TL');
		$xml->addChild('ListPrice', YTLfiyat($d['piyasafiyat'], $d['fiyatBirim']));
		$xml->addChild('ListPriceCurrency', 'TL');
	}
	$xmlx->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}
function spShowItemOptions($table, $ID, $field)
{
	global $langPrefix;
	$out = '';
	if ($table == 'urun') {
		$q = my_mysql_query("select * from $table where ID='$ID'");
		$d = my_mysql_fetch_array($q);
		$f = $d[$field . $langPrefix];
	} else {
		$d = $table;
		$field = 'ozellik' . $ID . 'detay';
		$ID = $d['ID'];
		$f = $d[$field];
	}
	$selectArray = explode("\n", $f);
	if (substr($d[0], 0, 5) == 'auto(') {
		$str = str_replace('auto(', '', $f);
		$str = str_replace(')', '', $str);
		list($start, $finish, $inc, $dir) = explode(',', $str);
		$str = str_replace('{%str1%}', $start, _lang_arasi);
		$str = str_replace('{%str2%}', $finish, $str);
		$out .= $str;
		return $out;
	} else {
		foreach ($selectArray as $opt) {
			list($opt, $price, $stok) = explode('|', $opt);
			if ($price) {
				$price = fixFiyat($price, 0, $d);
				$price = (' (<b>' . my_money_format('', ($price + fixFiyat($d['fiyat'], 0, $d))) . ' ' . dbInfo('urun', 'fiyatBirim', $ID) . '</b>)');
				$out .= "$opt$price | ";
			} else
				$price = '';
			$stok = trim($stok);
			$disabled = (($stok == '' || $stok > 0) ? '' : 'disabled="disabled"');
			if (!$disabled) $out .= "$opt | ";
			//else $out.="$stok | ";
		}
	}
	return substr($out, 0, strlen($out) - 3);
}
function buildCiceksepetiXMLFile()
{
	global $siteDizini;
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><Products></Products>';
	$xmlx = new SimpleXMLElementExtended($defaultXML);
	$order = 'order by catID';
	$start = ($_GET['start'] ? $_GET['start'] : 0);
	$filter = '';
	if ($_GET['limit']) $limit = 'limit ' . $start . ',' . (int) $_GET['limit'];
	// if ($_GET['filter']) $filter = 'AND '.$_GET['filter'].' = 1';
	if ($_GET['order']) $order = 'order by ' . $_GET['order'];
	if ($_GET['catID']) $filter .= "AND showCatIDs like '%|" . $_GET['catID'] . "|%'";
	// private_tarih >= now() AND private_start <= now() AND
	$q = my_mysql_query("select urun.*,kategori.namePath as catName,kategori.cscode as cscode,marka.name as markaName,kategori.namePath as namePathx,kategori.parentID as catParentID from urun,kategori,marka where (urun.resim like '%jpg' OR urun.resim like '%jpeg') AND urun.noxml != 1 AND kategori.noxml != 1 AND urun.catID=kategori.ID AND marka.ID = urun.markaID AND catID!=0 AND markaID!=0 AND fiyat > 0 AND stok>0 AND bakiyeOdeme=0 AND urun.active = 1 AND kategori.active =1 AND kategori.cscode != '' $filter $order $limit");
	$kar = hq("select data1 from xmlexport where code like '" . $_GET['c'] . "'");
	while ($d = my_mysql_fetch_array($q)) {
		if ($d['anindaGonderim'])
			$d['kargoGun'] = 1;
		if (!$d['kargoGun'])
			$d['kargoGun'] = siteConfig('kargoGun');
		if ($d['resimc'])
			$d['resim'] = $d['resimc'];
		$d['fiyat'] = fixFiyat($d['fiyat'], 0, $d['ID']);
		if ($kar)
			$d['fiyat'] = ((1 + (float)$kar) * $d['fiyat']);
		$xml = $xmlx->addChild('Product', '');
		$xml->addChild('Product_code', $d['tedarikciCode']);
		$xml->addChild('Product_id', $d['ID']);
		$xml->addChild('Price', YTLfiyat($d['fiyat'], $d['fiyatBirim']));
		$xml->addChild('Stock', $d['stok']);

		$xml->addChild('BuyingPrice', YTLfiyat($d['fiyat'], $d['fiyatBirim']));
		$xml->addChild('Tax', ($d['kdv'] * 100));
		$xml->addChildWithCDATA('Name', cleanStr(($d['name'])));
		$xml->addChild('CategoryID', $d['cscode']);
		$xml->addChild('Brand', $d['markaName']);
		$xml->addChildWithCDATA('Description', cleanStr(($d['onDetay'] . $d['detay'])));
		if (!hq("select ID from urunvarstok where urunID='" . $d['ID'] . "' AND up = 1")) {

			if(file_exists('images/urunler/' . $d['resim']))
				$xml->addChild('Image1', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim']));
			for ($i = 2; $i <= 5; $i++) {
				if ($d['resimc'])
					break;
				if ($d['resim' . $i] && file_exists('images/urunler/' . $d['resim'.$i]) && ($d['resim'.$i] != $d['resim'.($i - 1)]) && ($d['resim'.$i] != $d['resim']))
					$xml->addChild('Image' . ($i), ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim' . $i]));
			}
			$xarr = explode("\n", $d['cicekozellik']);
			$oi = 1;
			foreach ($xarr as $o) {
				list($ozl, $dgr) = explode(':', trim($o));
				$xml->addChild('OzellikTipi' . $oi, $ozl);
				$xml->addChild('VaryantTipi' . $oi, $dgr);
				$oi++;
			}
		} else {
			$vars = $xml->addChild('varyantlar', '');
			$q2 = my_mysql_query("select * from urunvarstok where urunID='" . $d['ID'] . "' AND up = 1");
			while ($d2 = my_mysql_fetch_array($q2)) {
				$var = $vars->addChild('varyant', '');
				$var->addChild('variantId', $d2['ID']);
				$var->addChild('productCode', $d2['kod']);
				$var->addChild('quantity', $d2['stok']);
				$var->addChild('price', ($d['fiyat'] + $d2['fark']));
				$var->addChild('firstprice', ($d['fiyat'] + $d2['fark']));
				$var->addChild('buyingprice', ($d['fiyat'] + $d2['fark']));
				$var->addChild('VaryantTipi1', hq("select tanim from var where ID='" . $d['varID1'] . "'"));
				$var->addChild('Secenekler1', $d2['var1']);
				$var->addChild('VaryantTipi2', hq("select tanim from var where ID='" . $d['varID2'] . "'"));
				$var->addChild('Secenekler2', $d2['var2']);

				$qx = my_mysql_query("select * from urunvar where urunID = '" . (int)$d['ID'] . "' AND varID = '" . (int)$d['varID1'] . "' AND varName = '" . addslashes(trim($d2['var1'])) . "'");
				while ($dx = my_mysql_fetch_array($qx)) {
					for ($xi = 1; $xi <= 5; $xi++) {
						if ($dx['resim' . $xi])
							$var->addChild('Image' . $xi, 'https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'images/urunler/var/' . $dx['resim' . $xi]);
					}
				}
				if (!mysql_num_rows($qx)) {
					$var->addChild('Image1', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim']));
					for ($i = 2; $i <= 5; $i++) {
						if ($d['resim' . $i])
							$var->addChild('Image' . ($i), ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim' . $i]));
					}
				}
			}
		}
	}
	$xmlx->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}

function buildAkakceXMLFile()
{
	global $siteDizini;
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><products></products>';
	$xmlx = new SimpleXMLElementExtended($defaultXML);
	$order = 'order by catID';
	$start = ($_GET['start'] ? $_GET['start'] : 0);
	if ($_GET['limit']) $limit = 'limit ' . $start . ',' . (int) $_GET['limit'];
	if ($_GET['order']) $order = 'order by ' . $_GET['order'];
	if ($_GET['catID']) $filter = "AND showCatIDs like '%|" . $_GET['catID'] . "|%'";
	$q = my_mysql_query("select urun.*,kategori.namePath as catName,marka.name as markaName,kategori.namePath as namePathx,kategori.parentID as catParentID from urun,kategori,marka where urun.noxml != 1 AND kategori.noxml != 1 AND urun.catID=kategori.ID AND marka.ID = urun.markaID AND catID!=0 AND markaID!=0 AND fiyat > 0 AND stok>0 AND bakiyeOdeme=0 AND urun.active = 1 AND kategori.active =1 $filter $order $limit");
	while ($d = my_mysql_fetch_array($q)) {
		if ($d['anindaGonderim'])
			$d['kargoGun'] = 1;
		if (!$d['kargoGun'])
			$d['kargoGun'] = siteConfig('kargoGun');
		$d['fiyat'] = fixFiyat($d['fiyat'], 0, $d['ID']);
		$xml = $xmlx->addChild('product', '');
		$xml->addChild('sku', $d['ID']);
		$xml->addChildWithCDATA('name', cleanStr(($d['name'])));
		$xml->addChild('url', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . urunLink($d)));
		$xml->addChild('imgUrl', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim']));
		$xml->addChildWithCDATA('description', cleanStr(($d['listeDetay'] . $d['detay'])));
		$xml->addChild('distributor', '');
		$xml->addChild('price', YTLfiyat($d['fiyat'], $d['fiyatBirim']));

		$sp = 0;
		if ($d['fixKargoFiyat']) {
			$sp = str_replace(',', '', my_money_format('', $d['fixKargoFiyat']));
		} else if ($d['ucretsizKargo']) {
			$sp = 0;
		} else if (siteConfig('kargo') && YTLfiyat($d['fiyat'], $d['fiyatBirim']) < siteConfig('minKargo')) {
			$sp = str_replace(',', '', my_money_format('', siteConfig('kargo')));
		}
		$xml->addChild('shipPrice', $sp);
		$xml->addChild('shipmentVolume', $d['desi']);
		$xml->addChild('dayOfDelivery', ($d['kargoGun'] ? $d['kargoGun'] : 3));
		$xml->addChild('quantity', $d['stok']);
		$xml->addChild('productBrand', (str_replace('&prime;', '', $d['markaName'])));
		$xml->addChildWithCDATA('productCategory', (cleanStr(str_replace('/', '-', $d['catName']))));
		$xml->addChild('barcode', $d['gtin']);
		if ($d['varID1'] || $d['varID2']) {
			$urunvar = $xml->addChild('variants');
			$var1 = (cleanstr(hq("select ozellik from var where ID='" . $d['varID1'] . "'")));
			$var2 = (cleanstr(hq("select ozellik from var where ID='" . $d['varID2'] . "'")));

			$var1 = str_ireplace(array('beden', 'renk'), array('size', 'color'), $var1);
			$var2 = str_ireplace(array('beden', 'renk'), array('size', 'color'), $var2);

			$vq = my_mysql_query("select * from urunvarstok where urunID='" . $d['ID'] . "'");
			while ($vd = my_mysql_fetch_array($vq)) {
				$var = $urunvar->addChild('variant');
				$var->addChild('sku', $vd['kod'] ? $vd['kod'] : $vd['ID']);
				$price1 = $vd['fark'];
				$var->addChild(seoFix($var1), cleanstr($vd['var1']));
				if ($var2) {
					$var->addChild(seoFix($var2), cleanstr($vd['var2']));
				}
				$var->addChild('price', YTLfiyat($d['fiyat'], $d['fiyatBirim']) + (YTLfiyat($price1, $d['fiyatBirim'])));
				$var->addChild('quantity', $vd['stok']);
			}
		}
	}
	$xmlx->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}
function buildFiyatvarXMLFile()
{
	global $siteDizini;
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><shopxml></shopxml>';
	$xmlx = new SimpleXMLElementExtended($defaultXML);
	$order = 'order by catID';
	$start = ($_GET['start'] ? $_GET['start'] : 0);
	if ($_GET['limit']) $limit = 'limit ' . $start . ',' . (int) $_GET['limit'];
	if ($_GET['order']) $order = 'order by ' . $_GET['order'];
	if ($_GET['catID']) $filter = "AND showCatIDs like '%|" . $_GET['catID'] . "|%'";

	$q = my_mysql_query("select urun.*,kategori.namePath as catName,marka.name as markaName,kategori.namePath as namePathx,kategori.parentID as catParentID from urun,kategori,marka where urun.noxml != 1 AND kategori.noxml != 1 AND urun.catID=kategori.ID AND marka.ID = urun.markaID AND catID!=0 AND markaID!=0 AND fiyat > 0 AND stok>0 AND gtin != '' AND bakiyeOdeme=0 $filter $order $limit");
	while ($d = my_mysql_fetch_array($q)) {

		$xml = $xmlx->addChild('urun', '');
		$xml->addChild('stokkodu', $d['tedarikciCode']);
		$xml->addChild('urunid', $d['ID']);
		$xml->addChild('kategori', (cleanStr(str_replace('/', '>', $d['catName']))));
		$xml->addChild('urunresim', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim']));
		$xml->addChild('urunadi', cleanStr(($d['name'])));
		$xml->addChild('marka', (str_replace('&prime;', '', $d['markaName'])));
		$xml->addChild('barkod', cleanStr(($d['gtin'])));
		$xml->addChild('stok', $d['stok']);
		$xml->addChild('fiyat', YTLfiyat($d['fiyat'], $d['fiyatBirim']));
		$xml->addChild('kargo', !$d['ucretsizKargo']);
		$xml->addChild('urunurl',  'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . urunLink($d));
	}
	$xmlx->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}
function buildExcelXMLFile()
{
	$out = '';
	$arr[] = array('Ürün ID', 'Ürün Adı', 'Kategori ID', 'Kategori Adi', 'Marka ID', 'Marka Adı', 'Piyasa Fiyatı', 'Fiyat (KDV Dahil)', 'Fiyat Birimi', 'KDV', 'Açıklama', 'Garanti', 'Desi', 'Resim 1', 'Resim 2', 'Resim 3', 'Resim 4', 'Resim 5');
	$q = my_mysql_query("select urun.*,kategori.ID as catID,kategori.name as kategoriName,marka.ID as markaID,marka.name as markaName from urun,kategori,marka where kategori.ID=urun.catID AND marka.ID=urun.markaID AND urun.bakiyeOdeme=0");
	while ($d = my_mysql_fetch_array($q)) {
		$arr[] = array($d['ID'], $d['name'], $d['catID'], $d['kategoriName'], $d['markaID'], $d['markaName'], $d['piyasafiyat'], $d['fiyat'], $d['fiyatBirim'], $d['KDV'], $d['onDetay'], $d['garanti'], $d['desi'], $d['resim'], $d['resim2'], $d['resim3'], $d['resim4'], $d['resim5']);
	}
	foreach ($arr as $line) {
		$currentLine = '';
		foreach ($line as $data) {
			$currentLine .= '"' . htmlspecialchars($data) . '";';
		}
		$out .= substr($currentLine, 0, (strlen($currentLine) - 1)) . "\r\n";
	}
	return $out;
}
$akillifiyatxmlcontent = '';
function buildAkillifiyatXMLFile()
{
	global $akillifiyatxmlcontent;
	$akillifiyatxmlcontent = '<?xml version="1.0" encoding="utf-8"?><company>';
	$q = my_mysql_query("select ID as catID from kategori where level=1 and active=1 and parentID=0 ORDER BY name");
	while ($d = my_mysql_fetch_array($q)) {
		buildAkilliFiyatXMLFile_CatChilds($d['catID'], 1);
	}
	$akillifiyatxmlcontent .= '</company>';
	return $akillifiyatxmlcontent;
}
function buildAkilliFiyatXMLFile_CatChilds($catid, $level)
{
	$q = my_mysql_query("select ID as catID from kategori where level='" . ($level + 1) . "' and active=1 and parentID='" . $catid . "' ORDER BY name");
	while ($d = my_mysql_fetch_array($q)) {
		buildAkilliFiyatXMLFile_CatProducts($d['catID']);
		buildAkilliFiyatXMLFile_CatChilds($d['catID'], ($level + 1));
	}
}
function buildAkilliFiyatXMLFile_CatProducts($catid)
{
	global $siteDizini, $akillifiyatxmlcontent;
	$xml = '';
	$q = my_mysql_query("Select urun.*,kategori.ID as catID from urun,kategori where urun.stok>0 and urun.fiyat>0 and kategori.ID=urun.catID and urun.catID='" . $catid . "' AND urun.bakiyeOdeme=0");
	while ($d = my_mysql_fetch_array($q)) {
		$d['fiyat'] = fixFiyat($d['fiyat'], 0, $d['ID']);
		$d['detay'] = cleanstr($d['detay']);
		$d['onDetay'] = cleanstr($d['onDetay']);
		$d['name'] = cleanstr($d['name']);
		$xml .= '<products>' . "\n";
		$fiyat = YTLfiyat($d['fiyat'], $d['fiyatBirim']);
		$eft = $fiyat - ($fiyat * siteConfig('havaleIndirim'));
		$tekcekim = $fiyat - ($fiyat * siteConfig('tekCekimIndirim'));
		$xml .= insertXMLData('productID', $d['ID']);
		$xml .= insertXMLData('productName', (dbInfoXML('marka', 'name', $d['markaID']) . ' ' . $d['name']));
		$xml .= insertXMLData('categoriesName', dbInfoXML('kategori', 'name', $d['catID']));
		$xml .= insertXMLData('categoriesID', $d['catID']);
		$xml .= insertXMLData('brand', (dbInfoXML('marka', 'name', $d['markaID'])));
		$xml .= insertXMLData('brandID', $d['markaID']);
		$xml .= insertXMLData('url', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . '' . seoFix($d['name']) . '-urun' . $d['ID'] . '.html');
		$xml .= insertXMLData('image', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim']);
		$xml .= insertXMLData('stock', ($d['stok'] ? 'Var' : 'Yok'));
		$xml .= insertXMLData('priceTekCekim', str_replace(',', '', my_money_format('%i', $tekcekim)));
		$xml .= insertXMLData('price', str_replace(',', '', my_money_format('%i', $eft)));
		$xml .= insertXMLData('priceTax', str_replace(',', '', my_money_format('%i', taksitliOdemeHesalpa(YTLfiyat($d['fiyat'], $d['fiyatBirim']), 6, 4))));
		$xml .= insertXMLData('priceEFT', str_replace(',', '', my_money_format('%i', $eft)));
		$xml .= insertXMLData('brandID', $d['markaID']);
		$xml .= '</products>' . "\n";
	}
	$akillifiyatxmlcontent .= $xml;
}
function buildFiltercacheXMLFile()
{
	return hq("select filterCache from kategori where ID='" . $_GET['catID'] . "'");
}
function buildCimriXMLFile()
{
	global $siteDizini;
	$filter = '';
	$xml = '<?xml version="1.0" encoding="utf-8"?>
			<MerchantItems xmlns="http://www.cimri.com/schema/merchant/upload" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">';
	$q = my_mysql_query("select urun.*,marka.name as markaName,kategori.name as catName from urun,kategori,marka where urun.stok > 0 AND urun.active =1 AND kategori.active =1 AND urun.noxml != 1 AND kategori.noxml != 1 AND bakiyeOdeme=0 AND kategori.ID=urun.catID AND marka.ID = urun.markaID");
	while ($d = my_mysql_fetch_array($q)) {
		$xml .= '<MerchantItem>' . "\n";
		$d['fiyat'] = fixFiyat($d['fiyat'], 0, $d['ID']);
		$fiyat = YTLfiyat($d['fiyat'], $d['fiyatBirim']);
		$eft = $fiyat - ($fiyat * siteConfig('havaleIndirim'));
		$xml .= insertXMLData('brand', $d['markaName']);
		$xml .= insertXMLData('merchantItemCategoryName', $d['catName'], 'UTF-8');
		$xml .= insertXMLData('merchantItemId', $d['ID']);
		$xml .= insertXMLData('merchantItemCategoryId', $d['catID']);
		$xml .= insertXMLData('merchantItemField', $d['onDetay'], 'UTF-8',1);
		$xml .= insertXMLData('itemTitle', ($d['name']), 'UTF-8',1);
		$xml .= insertXMLData('itemUrl', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . urunLink($d), 'UTF-8');
		for ($j = 3; $j <= 12; $j = $j + 3) {
			$type = '';
			$type = hq("select bankaID from bankaVade where ay='$j' order by vade limit 0,1");
			if ($type)
				$xml .= insertXMLData('price' . $j . 'T', str_replace(',', '', my_money_format('%i', taksitliOdemeHesalpa(YTLfiyat($d['fiyat'], $d['fiyatBirim']), $j, $type))));
		}
		$xml .= insertXMLData('itemImageUrl', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim'] . '');
		$type = '';
		$type = hq("select bankaID from bankaVade where ay=24 limit 0,1");
		if ($type) $xml .= insertXMLData('price24T', str_replace(',', '', my_money_format('%i', taksitliOdemeHesalpa(YTLfiyat($d['fiyat'], $d['fiyatBirim']), 24, $type))));
		// if (siteConfig('havaleIndirim')) $xml.=insertXMLData('priceEft ',str_replace(',','',my_money_format('%i',YTLfiyat($d['fiyat'] - (siteConfig('havaleIndirim') * $d['fiyat']),$d['fiyatBirim']))));
		$xml .= insertXMLData('priceEft', str_replace(',', '', my_money_format('%i', $eft)));
		$xml .= insertXMLData('pricePlusTax', str_replace(',', '', my_money_format('%i', YTLfiyat($d['fiyat'], $d['fiyatBirim']))));

		$sp = 0;
		if ($d['fixKargoFiyat']) {
			$sp = str_replace(',', '', my_money_format('', $d['fixKargoFiyat']));
		} else if ($d['ucretsizKargo']) {
			$sp = 0;
		} else if (siteConfig('kargo') && YTLfiyat($d['fiyat'], $d['fiyatBirim']) < siteConfig('minKargo')) {
			$sp = str_replace(',', '', my_money_format('', siteConfig('kargo')));
		}


		$xml .= insertXMLData('shippingFee', $sp);
		$xml .= insertXMLData('stockStatus', $d['stok']);
		$xml .= insertXMLData('shippingDay', ($d['anindaGonderim'] ? 0 : 2));
		$filter .= " AND paymentModulURL != 'include/payment_promosyon.php'";
		$filter .= " AND bakiye = 0";
		$xml .= '<installments>';
		$query = "select * from banka where minsiparis <= " . $d['fiyat'] . " AND active = 1 AND  paymentModulURL != '' $filter order by seq";
		$qx = my_mysql_query($query);
		$i = 1;
		while ($dx = my_mysql_fetch_array($qx)) {
			$list = true;
			if (($dx['cat'] && $dx['cat'] != '0') || ($dx['marka'] && $dx['marka'] != '0')) {
				if ($dx['marka'] && $dx['marka'] != '0') if ((stristr($dx['marka'], ',' . $d['markaID'] . ',') === false)) {
					$list = false;
				}
				if ($dx['cat'] && $dx['cat'] != '0') if ((stristr($dx['cat'], ',' . $d['catID'] . ',') === false)) {
					$list = false;
				}
			}
			if ($list) {
				$qn = my_mysql_query("select * from bankaVade where bankaID='" . $dx['ID'] . "'");
				while ($dn = my_mysql_fetch_array($qn)) {
					$xml .= '<installment>';
					$xml .= insertXMLData('card', ($dx['bankaAdi']), 'UTF-8');
					$xml .= insertXMLData('month', $dn['ay'], 'UTF-8');
					$xml .= insertXMLData('installmentPrice', taksitliOdemeHesalpa($d['fiyat'], $dn['ay'], $dx['ID']), 'UTF-8');
					$xml .= insertXMLData('continuance', $dn['plus'], 'UTF-8');
					$xml .= '</installment>';
				}
				$i++;
			}
		}
		$xml .= '</installments>';
		$xml .= insertXMLData('merchantItemField', $d['onDetay'], 'UTF-8');
		$xml .= '</MerchantItem>' . "\n";
	}
	$xml .= '</MerchantItems>';
	return $xml;
}
function buildHizlialXMLFile()
{
	global $siteDizini, $siteConfig;
	$xml = '<?xml version="1.0" encoding="utf-8"?><Products>';
	$q = my_mysql_query("select urun.*,kategori.ID as catID from urun,kategori where urun.noxml != 1 AND kategori.noxml != 1 AND bakiyeOdeme=0 AND kategori.ID=urun.catID");
	while ($d = my_mysql_fetch_array($q)) {
		foreach ($d as $k => $v) {
			$d[$k] = ($v);
		}
		$xml .= '<Product>' . "\n";
		$fiyat = YTLfiyat($d['fiyat'], $d['fiyatBirim']);
		$eft = $fiyat - ($fiyat * siteConfig('havaleIndirim'));
		$xml .= insertXMLData('URUNID', 'spurun_' . $d['ID']);
		$xml .= insertXMLData('ANAURUNID', 'spurun_' . $d['ID']);
		$xml .= insertXMLData('MARKA', dbInfoXML('marka', 'name', $d['markaID']));
		$xml .= insertXMLData('URUN_ADI', ($d['name']));
		$xml .= insertXMLData('ANA_KATEGORI_ID', dbInfoXML('kategori', 'parentID', $d['catID']));
		$xml .= insertXMLData('ANA_KATEGORI_ADI', (dbInfoXML('kategori', 'name', dbInfoXML('kategori', 'parentID', $d['catID']))));
		$xml .= insertXMLData('ALT_KATEGORI_ID', $d['catID']);
		$xml .= insertXMLData('ALT_KATEGORI_ADI', (dbInfoXML('kategori', 'name', $d['catID'])));
		$xml .= insertXMLData('LINK', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . urunLink($d));
		$aciklama = ($d['onDetay'] . ' ' . $d['detay']);
		$xml .= insertXMLData('ACIKLAMA', trim(utf8fix($aciklama)));
		$xml .= insertXMLData('KUCUK_RESIM', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'include/resize.php?path=images/urunler/' . $d['resim'] . '&width=100&height=500');
		$xml .= insertXMLData('BUYUK_RESIM', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim']);
		for ($i = 2; $i <= 5; $i++) {
			if ($d['resim' . $i]) $xml .= insertXMLData('BUYUK_RESIM' . $i, 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim' . $i]);
		}
		$xml .= insertXMLData('RESIM_SAYISI', 1);
		$xml .= insertXMLData('FIYAT_TIPI', $d['fiyatBirim']);
		$xml .= insertXMLData('PIYASA_FIYATI', tlformat($d['piyasafiyat'] / (1 + $d['kdv'])));
		$xml .= insertXMLData('LISTE_FIYATI', tlformat($d['fiyat'] / (1 + $d['kdv'])));
		$xml .= insertXMLData('BAYI_FIYATI_KDV_DAHIL', tlformat($d['fiyat1']));
		$xml .= insertXMLData('BAYI_FIYATI_KDV_HARIC', tlformat($d['fiyat1'] / (1 + $d['kdv'])));
		$xml .= insertXMLData('KDV_ORANI', ($d['kdv'] * 100));
		$xml .= insertXMLData('STOK_ADEDI', $d['stok']);
		$xml .= insertXMLData('BARKOD', '');
		$xml .= insertXMLData('BEDEN ', '');
		$xml .= insertXMLData('RENK', '');
		$xml .= '</Product>' . "\n";
	}
	$xml .= '</Products>';
	return $xml;
}
function buildBayiCepteXMLFile()
{
	global $siteDizini, $siteTipi;
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><urunler></urunler>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	$q = my_mysql_query("select urun.*,kategori.namePath as namePath from urun,kategori where urun.noxml != 1 AND kategori.noxml != 1 AND bakiyeOdeme=0 AND kategori.ID=urun.catID");
	while ($d = my_mysql_fetch_array($q)) {
		$d['fiyat'] = fixFiyat($d['fiyat'], 0, $d['ID']);
		$d = itemOptionFixXML($d);
		$d['detay'] = cleanstr($d['detay']);
		$d['listeDetay'] = cleanstr($d['listeDetay']);
		$d['onDetay'] = cleanstr($d['onDetay']);
		$d['name'] = cleanstr($d['name']);
		$channel = $xml->addChild('urun', '');
		$channel->addChild('urun_id', ($d['ID']));
		$channel->addChild('magaza_kodu', ($d['gtin']));
		$channel->addChild('baslik', ($d['name']));
		$channel->addChild('kisa_aciklama', ($d['listeDetay'] . $d['onDetay']));
		$channel->addChild('kategori', ($d['namePath']));
		$channel->addChild('eski_fiyat', ($d['piyasafiyat']));
		$channel->addChild('perakende_fiyat', ($d['piyasafiyat']));
		$channel->addChild('doviz', $d['fiyatBirim']);
		$channel->addChild('bayi_fiyat', ($d['fiyat']));
		$channel->addChild('bayi_doviz', ($d['fiyatBirim']));
		$channel->addChild('kargo_ucreti', ($d['fixKargoFiyat']));
		$channel->addChild('garanti_tipi', 'Distribütör Garantili');
		$channel->addChild('garanti_suresi', ($d['garanti']));
		$channel->addChild('iade_adres_id', 1);
		for ($j = 1; $j <= 10; $j++) {
			$resimStr = 'resim' . ($j == 1 ? '' : $j);
			if ($d[$resimStr])
				$channel->addChild('resim' . $j, ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d[$resimStr]));
		}
		$channel->addChild('aciklama', ($d['detay']));
		$variants = $channel->addChild('stoklar', '');
		for ($i = 1; $i <= 3; $i++) {
			if ($d['ozellik' . $i]) {
				$vArray = explode("\n", $d['ozellik' . $i . 'detay']);
				foreach ($vArray as $v) {
					if (!$v) continue;
					$variant = $variants->addChild('secenek');
					list($name, $fark, $stok) = explode('|', $v);
					if (($stok == '' && $stok != 0) || !$stok) $stok = $d['stok'];
					$variant->addChild(seoFix(cleanstr($d['ozellik' . $i])), cleanstr($name));
					$variant->addChild(seoFix(cleanstr($d['ozellik' . $i])) . '_stok', ($stok ? $stok : $d['stok']));
				}
			}
		}
	}
	$xml->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}
function buildUcuzcuXMLFile()
{
	global $siteDizini, $siteTipi;
	$filter = '';
	$order = '';
	$limit = '';
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><urunler></urunler>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	if ($siteTipi == 'OZELSATIS')
		$q = my_mysql_query("select urun.*,kategori.name as catName,marka.name as markaName,kategori.namePath as catNamePath,kategori.parentID as catParentID from urun,kategori,marka where private_tarih >= now() AND private_start <= now() AND urun.catID=kategori.ID AND marka.ID = urun.markaID AND catID!=0 AND markaID!=0 AND fiyat > 0 AND bakiyeOdeme=0 AND stok > 0 AND urun.active =1 AND kategori.active = 1  $filter $order $limit");
	else {
		$order = 'order by catID';
		$start = ($_GET['start'] ? $_GET['start'] : 0);
		if ($_GET['limit']) $limit = 'limit ' . $start . ',' . (int) $_GET['limit'];
		// if ($_GET['filter']) $filter = 'AND '.$_GET['filter'].' = 1';
		if ($_GET['order']) $order = 'order by urun.' . $_GET['order'];
		if ($_GET['catID']) $filter .= "AND showCatIDs like '%|" . $_GET['catID'] . "|%'";
		$q = my_mysql_query("select urun.*,kategori.name as catName,marka.name as markaName,kategori.namePath as catNamePath,kategori.parentID as catParentID from urun,kategori,marka where urun.noxml != 1 AND kategori.noxml != 1 AND urun.catID=kategori.ID AND urun.markaID=marka.ID AND catID!=0 AND markaID!=0 AND fiyat > 0 AND bakiyeOdeme=0 AND urun.active=1 AND kategori.active = 1 AND urun.stok > 0 $filter $order $limit");
	}
	while ($d = my_mysql_fetch_array($q)) {
		$d['fiyat'] = fixFiyat($d['fiyat'], 0, $d['ID']);
		$fiyat = $d['fiyat'];
		$d['detay'] = cleanstr($d['detay']);
		$d['onDetay'] = cleanstr($d['onDetay']);
		$d['name'] = cleanstr($d['name']);
		$channel = $xml->addChild('urun', '');
		$channel->addChild('urun_kodu', ($d['ID']));
		$channel->addChild('url', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . urunLink($d)));
		$fiyat = YTLfiyat($d['fiyat'], $d['fiyatBirim']);
		//$KDVHaricFiyat = ($fiyat / (1 + $d['kdv']));
		$channel->addChild('fiyat', (str_replace(',', '', my_money_format('%i', $fiyat))));
		$channel->addChild('birim', 'TL');
		$channel->addChild('kategori', cleanstr((str_replace('/', '>', $d['catNamePath']))));
		$channel->addChild('resim', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim']));
		$channel->addChild('isim', ($d['name']));
		//$channel->addChild('marka',(dbInfoXML('marka','name',$d['markaID'])));
		$channel->addChild('marka', (cleanstr(dbInfoXML('marka', 'name', $d['markaID']))));
		$channel->addChild('tanim', ($d['onDetay']));
		$channel->addChild('action_text', ($d['listeDetay']));
	}
	$xml->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}
function buildNekadarXMLFile()
{
	global $siteDizini, $siteConfig, $NeKadarXML_DosyaAdi, $NeKadarXML_Aktif;
	$xml = '<?xml version="1.0" encoding="iso-8859-9"?>
<shop>';
	$q = my_mysql_query("select urun.*,kategori.ID as catID,kategori.namePath as catNamePath from urun,kategori where bakiyeOdeme=0 AND kategori.ID=urun.catID");
	while ($d = my_mysql_fetch_array($q)) {
		$d['detay'] = cleanstr($d['detay']);
		$d['onDetay'] = cleanstr($d['onDetay']);
		$d['name'] = cleanstr($d['name']);
		$xml .= '<urun>' . "\n";
		$xml .= insertXMLData('urunid', $d['ID']);
		$xml .= insertXMLData('baslik', $d['name']);
		$xml .= insertXMLData('urunkodu', $d['ID']);
		$fiyat = YTLfiyat($d['fiyat'], $d['fiyatBirim']);
		$xml .= insertXMLData('ytlfiyat', str_replace(',', '', my_money_format('%i', $fiyat)));
		$eft = $fiyat - ($fiyat * siteConfig('havaleIndirim'));
		$xml .= insertXMLData('ytleftfiyat', str_replace(',', '', my_money_format('%i', $eft)));
		$euro = $d['fiyatBirim'] == 'EUR' ? $d['fiyatBirim'] : ($fiyat * siteConfig('euro'));
		$xml .= insertXMLData('eurofiyat', str_replace(',', '', my_money_format('%i', $euro)));
		$dolar = $d['fiyatBirim'] == 'USD' ? $d['fiyatBirim'] : ($fiyat * siteConfig('dolar'));
		$xml .= insertXMLData('dolarfiyat', str_replace(',', '', my_money_format('%i', $dolar)));
		$xml .= insertXMLData('ayliktaksit', $d['ID']);
		$xml .= insertXMLData('taksit', hq('select vade from bankaVade,banka where active=1 and banka.ID=bankaVade.bankaID order by vade desc limit 0,1'));
		$xml .= insertXMLData('teslimat', siteConfig('kargo'));
		$xml .= insertXMLData('garanti', $d['garanti']);
		$xml .= insertXMLData('link', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . urunLink($d));
		$xml .= insertXMLData('resim', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim']);
		$xml .= '</urun>' . "\n";
	}
	$xml .= '</shop>';
	return $xml;
}
function buildTfXMLFile()
{
	return str_replace('ref=firsatbufirsat', 'ref=tumfirsatlar', buildFbfXMLFile());
}
function buildFbfXMLFile()
{
	global $siteDizini;
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><deals></deals>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	$q = my_mysql_query('select * from urun where stok > 0 AND active = 1 order by seq desc,start asc');
	while ($d = my_mysql_fetch_array($q)) {
		$d['name'] = cleanstr($d['name']);
		$d['detay'] = cleanstr($d['detay']);
		$d['onDetay'] = cleanstr($d['onDetay']);
		$d['data1'] = cleanstr($d['data1']);
		$d['data2'] = cleanstr($d['data2']);
		$d['data3'] = cleanstr($d['data3']);
		$d['data4'] = cleanstr($d['data4']);
		$d['data5'] = cleanstr($d['data5']);

		$d['fiyat'] = YTLfiyat($d['fiyat'], $d['fiyatBirim']);
		$d['piyasafiyat'] = YTLfiyat($d['piyasafiyat'], $d['fiyatBirim']);


		$gectimi = ($d['minSatis'] <= UrunPrefixSold($d['ID']));
		$qGrup = my_mysql_query("select * from sepet where urunID='" . $d['ID'] . "' AND prefix='" . $d['prefix'] . "' AND durum > 0 order by tarih asc");
		$sold = 0;
		while ($dGrup = my_mysql_fetch_array($qGrup)) {
			$sold += $dGrup['adet'];
			if ($sold >= $d['minSatis']) {
				$onayTarih = $dGrup['tarih'];
				break;
			}
		}
		$channel = $xml->addChild('deal', '');
		$channel->addChild('id', ($d['ID']));
		$city = hq("select name from iller where plakaID= '" . $d['data4'] . "'");
		if (!$city) $city = 'İstanbul';
		$channel->addChild('city', ($city));
		$channel->addChild('title', ($d['name']));
		$channel->addChild('description ', ($d['detay']));
		$channel->addChild('detail', ($d['data3']));
		$channel->addChild('howToUse', ($d['data1']));
		$channel->addChild('startDate', ($d['start']));
		$channel->addChild('endDate', ($d['finish']));
		$channel->addChild('hasTipped', ((int) $gectimi));
		$channel->addChild('tippingPoint', ($d['minSatis']));
		$channel->addChild('tippingDate', ($onayTarih));
		$channel->addChild('hasSoldOut', ((int) ($d['stok'] == 0)));
		$channel->addChild('totalSold', (UrunPrefixSold($d['ID'])));
		$channel->addChild('realPrice', (str_replace(',', '', my_money_format('%i', $d['piyasafiyat']))));
		$channel->addChild('dealPrice', (str_replace(',', '', my_money_format('%i', $d['fiyat']))));
		$channel->addChild('discountPrice', (my_money_format('%i', ($d['piyasafiyat'] - $d['fiyat']))));
		$channel->addChild('discountPercent', ((100 - (int) ((100 * $d['fiyat']) / $d['piyasafiyat']))));
		$channel->addChild('hasLimitedQuantity', ('0'));
		$channel->addChild('initialQuantity', ('0'));
		$channel->addChild('quantityRemaining', ($d['stok']));
		$channel->addChild('minimumPurchase', ('0'));
		$channel->addChild('maximumPurchase', ('999'));
		$channel->addChild('expirationDate', (''));
		$channel->addChild('dealUrl', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'index.php?urunID=' . $d['ID'] . '&amp;ref=' . ($_GET['ref'] ? $_GET['ref'] : 'firsatbufirsat')));
		$img = 	$channel->addChild('imageUrls');
		$img->addChild('imageUrl', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim']));
		for ($i = 2; $i <= 10; $i++) {
			if ($d['resim' . $i])
				$img->addChild('imageUrl', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim' . $i]));
		}


		if ($d['varID1'] || $d['varID2']) {
			$urunvar = $channel->addChild('subDeals');
			$var1 = (cleanstr(hq("select ozellik from var where ID='" . $d['varID1'] . "'")));
			$var2 = (cleanstr(hq("select ozellik from var where ID='" . $d['varID2'] . "'")));

			$vq = my_mysql_query("select * from urunvarstok where urunID='" . $d['ID'] . "'");
			while ($vd = my_mysql_fetch_array($vq)) {
				$var = $urunvar->addChild('subDeal');

				$var->addChild('sourceKey', $vd['ID']);
				$var->addChild('title', $d['name'] . $var1 . ' ' . $var2);


				$var->addChild('realPrice', (str_replace(',', '', my_money_format('%i', $d['piyasafiyat'] + $vd['fark']))));
				$var->addChild('dealPrice', (str_replace(',', '', my_money_format('%i', $d['fiyat'] + $vd['fark']))));

				$var->addChild('quantityRemaining', ($vd['stok']));

				$opt = $var->addChild('options');
				$optx = $opt->addChild('option');
				$optx->addChild('optionLabel', $var1);
				$optx->addChild('optionValue', $vd['var1']);

				if ($vd['var2']) {
					$optx2 = $opt->addChild('option');
					$optx2->addChild('optionLabel', $var1);
					$optx2->addChild('optionValue', $vd['var1']);
				}
			}
		}


		/*
		$vendor = $channel->addChild('vendor','');
		$vendor->addChild('id',($d['ID']));
		$vendor->addChild('title',($d['name']));
		$vendor->addChild('siteUrl',(''));
		$vendor->addChild('facebookUrl',(''));
		$vendor->addChild('twitterUrl',(''));
		$vendor->addChild('friendfeedUrl',(''));
		$vendor->addChild('vendorBranches',(''));
		 */
	}
	return $xml->asXML();
}
function buildYcXMLFile()
{
	global $siteDizini;
	$defaultXML = '<Icerik xmlns:i="http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://www.w3.org/2001/XMLSchema-instance" xmlns="http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://schemas.datacontract.org/2004/07/Hurriyet.SerialAds.Library.Data.Model"></Icerik>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	$channelx = $xml->addChild('Urunler', '');
	$filter = '';
	$order = 'order by catID';
	$start = ($_GET['start'] ? $_GET['start'] : 0);
	if ($_GET['limit']) $limit = 'limit ' . $start . ',' . (int) $_GET['limit'];
	// if ($_GET['filter']) $filter = 'AND '.$_GET['filter'].' = 1';
	if ($_GET['order']) $order = 'order by ' . $_GET['order'];
	if ($_GET['catID']) $filter .= "AND showCatIDs like '%|" . $_GET['catID'] . "|%'";
	$q = my_mysql_query("select urun.*,kategori.yc_Kod from urun,kategori where urun.catID = kategori.ID AND catID!=0 AND markaID!=0 AND stok > 0 AND fiyat > 0 AND bakiyeOdeme=0 AND active=1 $filter $order $limit");
	while ($d = my_mysql_fetch_array($q)) {
		if (!hq("select gg_Kod from kategori where ID='" . $d['catID'] . "'")) continue;
		$d['name'] = cleanstr($d['name']);
		$d['detay'] = cleanstr($d['detay']);
		$d['onDetay'] = cleanstr($d['onDetay']);
		$channel = $channelx->addChild('Urun', '');
		$channel->addChild('YeniCarsimUrunKodu', '');
		$channel->addChild('MusteriUrunKodu', ($d['ID']));
		$channel->addChild('KategoriId', ($d['yc_Kod']));
		$channel->addChild('UrunBasligi', (cleanstr($d['name'])));
		$channel->addChild('UrunAltBasligi', (cleanstr($d['listeDetay'])));
		$channel->addChild('UrunMarkasi', (cleanstr(hq("select name from marka where ID='" . $d['markaID'] . "'"))));
		$channel->addChild('KisaUrunAciklamasi', (cleanstr($d['onDetay'])));
		$channel->addChild('SatisaSunulacakUrunAdedi', ($d['stok']));
		$channel->addChild('KisiBasiEnFazlaAlisMiktari', ($d['stok']));
		$fiyatYTL = YTLfiyat($d['fiyat'], $d['fiyatBirim']);
		//$fiyatYTL = ($fiyatYTL / (1 + $d['kdv']));
		$fiyatYTL = str_replace(',', '', my_money_format('', ($fiyatYTL * 1.10)));
		$channel->addChild('Fiyat', $fiyatYTL);
		$channel->addChild('EskiFiyat', '0');
		$kargo = $channel->addChild('KargoSirketleri', '');
		$kargo->addAttribute('xmlns:d4p1', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://schemas.microsoft.com/2003/10/Serialization/Arrays');
		$kargo->addChild('d4p1:int', '1');
		$kargo->addChild('d4p1:int', '2');
		$channel->addChild('KargoVerilecekSehir', '34');
		$channel->addChild('KargoNotu', ('En geç 3 iş günü içinde kargoya verilir.'));
		$channel->addChild('KargoVarisNoktasi', '1');
		$channel->addChild('UcretsizKargo:false', ((int) $d['ucretsizKargo:false']));
		$foto = $channel->addChild('UrunFotograflari', '');
		$foto->addAttribute('xmlns:d4p1', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://schemas.microsoft.com/2003/10/Serialization/Arrays');
		for ($j = 1; $j <= 5; $j++) {
			$resimStr = 'resim' . ($j == 1 ? '' : $j);
			if ($d[$resimStr])
				$foto->addChild('d4p1:string', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d[$resimStr]));
		}
	}
	$out = $xml->asXML();
	$out = str_replace('d4p1=', 'xmlns:d4p1=', $xml->asXML());
	$out = str_replace('<int>', '<d4p1:int>', $out);
	$out = str_replace('</int>', '</d4p1:int>', $out);
	$out = str_replace('<string>', '<d4p1:string>', $out);
	$out = str_replace('</string>', '</d4p1:string>', $out);
	return $out;
}
function buildautomMasterXMLFile()
{
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><BILGILER></BILGILER>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	$q = my_mysql_query("select * from siparis where durum >= 0");
	$channel = $xml->addChild('BILGI', '');
	while ($d = my_mysql_fetch_array($q)) {
		list($tarih, $zaman) = explode(' ', $d['tarih']);
		list($saat, $dk, $sn) = explode(':', $zaman);
		$channel->addChild('SIPARIS_NO', (str_pad($d['randStr'], 15, "0", STR_PAD_LEFT)));
		$channel->addChild('CARI_KODU', (str_pad($d['userID'], 35, "0", STR_PAD_LEFT)));
		$channel->addChild('TARIH', ($tarih));
		$channel->addChild('TESLIM_TARIHI', ($tarih));
		$channel->addChild('BRUT_TOPLAM', ($d['ModulFarkiIle']));
		$channel->addChild('ISKONTO', (($d['ModulFarkiIle'] - $d['toplamKDVDahil'])));
		$channel->addChild('ARATOPLAM', ($d['toplamKDVDahil']));
		$channel->addChild('KDV', ($d['toplamKDV']));
		$channel->addChild('NET_TOPLAM', ($d['toplamKDVHaric']));
	}
	$xml->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}
function buildautomDetayXMLFile()
{
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><BILGILER></BILGILER>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	$channel = $xml->addChild('BILGI', '');
	$q = my_mysql_query("select * from siparis where durum >= 0");
	while ($d = my_mysql_fetch_array($q)) {
		list($tarih, $zaman) = explode(' ', $d['tarih']);
		list($saat, $dk, $sn) = explode(':', $zaman);
		$channel->addChild('SIPARIS_NO', (str_pad($d['randStr'], 15, "0", STR_PAD_LEFT)));
		$channel->addChild('CARI_KODU', (str_pad($d['userID'], 35, "0", STR_PAD_LEFT)));
		$channel->addChild('TARIH', ($tarih));
		$channel->addChild('TESLIM_TARIHI', ($tarih));
		$trans = $channel->addChild('URUNLER', '');
		$q2 = my_mysql_query("select * from sepet where randStr = '" . $d['randStr'] . "'");
		while ($d2 = my_mysql_fetch_array($q2)) {
			$kdv = ($d2['kdv'] ? $d2['kdv'] : hq("select kdv from urun where ID='" . $d2['urunID'] . "'"));
			$transs = $trans->addChild('URUN', '');
			$transs->addChild('STOK_KODU', ($d2['urunID']));
			$transs->addChild('MIKTAR', ($d2['adet']));
			$transs->addChild('OLCUBIRIMI', (hq("select urunBirim from urun where ID='" . $d2['urunID'] . "'")));
			$transs->addChild('BRUT_FIYAT', (($d2['ytlFiyat'] * $d2['adet'])));
			$transs->addChild('NET_FIYAT', ((($d2['ytlFiyat'] * $d2['adet']) - (($d2['ytlFiyat'] * $d2['adet']) / (1 + $kdv)))));
			$transs->addChild('ISKONTO', 0);
		}
	}
	$xml->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}
function buildautomCariXMLFile()
{
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><BILGILER></BILGILER>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	$q = my_mysql_query("select * from user");
	$channel = $xml->addChild('BILGI', '');
	while ($d = my_mysql_fetch_array($q)) {
		$channel->addChild('CARI_KOD', (str_pad($d['ID'], 35, "0", STR_PAD_LEFT)));
		$channel->addChild('CARI_ISIM', (str_pad($d['name'] . ' ' . $d['lastname'], 100, "0", STR_PAD_LEFT)));
		$channel->addChild('CARI_ADRES', (str_pad($d['address'], 100, "0", STR_PAD_LEFT)));
		$channel->addChild('CARI_ILCE', (str_pad(hq("select name from ilceler where ID='" . $d['semt'] . "'"), 15, "0", STR_PAD_LEFT)));
		$channel->addChild('CARI_IL', (str_pad(hq("select name from iller where plakaID='" . $d['city'] . "'"), 15, "0", STR_PAD_LEFT)));
		$channel->addChild('ULKE_KODU', (str_pad('', 4, "0", STR_PAD_LEFT)));
		$channel->addChild('POSTAKODU', (str_pad('', 8, "0", STR_PAD_LEFT)));
		$channel->addChild('CARI_TEL', (str_pad($d['ceptel'], 20, "0", STR_PAD_LEFT)));
		$channel->addChild('FAX', (str_pad($d['istel'], 20, "0", STR_PAD_LEFT)));
		$channel->addChild('EMAIL', (str_pad($d['email'], 60, " ", STR_PAD_LEFT)));
		$channel->addChild('VERGI_DAIRESI', (str_pad($d['vergiDaire'], 15, "0", STR_PAD_LEFT)));
		$channel->addChild('VERGI_NUMARASI', (str_pad($d['vergiNo'], 15, "0", STR_PAD_LEFT)));
		$channel->addChild('ACIK1', (str_pad($d['data1'], 50, " ", STR_PAD_LEFT)));
		$channel->addChild('ACIK2', (str_pad($d['data2'], 50, " ", STR_PAD_LEFT)));
		$channel->addChild('ACIK3', (str_pad($d['data3'], 50, " ", STR_PAD_LEFT)));
	}
	$xml->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}
function updateLogXMLFile()
{
	$katalog = new SimpleXMLElementExtended(file_get_contents('LogoXML/urunler.xml'));
	$i = 0;
	foreach ($katalog->MALZEME as $urun) {
		my_mysql_query("update urun set stok = '" . $urun->MIKTAR . "' where tedarikciCode like '" . $urun->KOD . "' AND tedarikciCode != ''");
		$i += my_mysql_affected_rows();
	}
	return 'Logo XML dosyasindan, stok adeti farkli olan toplam <strong>' . $i . '</strong> ürün stok adeti guncellendi.<br />';
}
function buildautoLogoSatisXMLFile()
{
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><SALES_ORDERS></SALES_ORDERS>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	$q = my_mysql_query("select * from siparis where durum >= 2");
	while ($d = my_mysql_fetch_array($q)) {
		list($tarih, $zaman) = explode(' ', $d['tarih']);
		list($saat, $dk, $sn) = explode(':', $zaman);
		$channel = $xml->addChild('ORDER_SLIP', '');
		$channel->addAttribute('DBOP', 'INS');
		$channel->addChild('NUMBER', ($d['randStr']));
		$channel->addChild('DATE', ($tarih));
		$channel->addChild('TIME', ($saat . ':' . $dk));
		$channel->addChild('ARP_CODE', ($d['randStr']));
		$channel->addChild('TOTAL_DISCOUNTED', ('0'));
		$channel->addChild('TOTAL_VAT', ($d['toplamKDV']));
		$channel->addChild('TOTAL_GROSS', ($d['toplamKDVHaric']));
		$channel->addChild('TOTAL_NET', ($d['toplamKDVDahil']));
		$channel->addChild('RC_RATE', ('1'));
		$channel->addChild('RC_NET', ($d['toplamKDVDahil']));
		$channel->addChild('ORDER_STATUS', ('1'));
		$channel->addChild('CREATED_BY', ('1'));
		$channel->addChild('ORDER_STATUS', ('1'));
		$channel->addChild('DATE_CREATED', ($tarih));
		$channel->addChild('HOUR_CREATED', ($saat));
		$channel->addChild('MIN_CREATED', ($dk));
		$channel->addChild('CURRSEL_TOTAL', (hq("select count(*) from sepet where randStr = '" . $d['randStr'] . "'")));
		$channel->addChild('DATA_REFERENCE', ('1'));
		$trans = $channel->addChild('TRANSACTIONS', '');
		$q2 = my_mysql_query("select * from sepet where randStr = '" . $d['randStr'] . "'");
		while ($d2 = my_mysql_fetch_array($q2)) {
			$transs = $trans->addChild('TRANSACTION', '');
			$transs->addChild('TYPE', ('0'));
			$transs->addChild('MASTER_CODE', ($d2['urunID']));
			$transs->addChild('QUANTITY', ($d2['adet']));
			$transs->addChild('PRICE', ($d2['ytlFiyat']));
			$transs->addChild('TOTAL', (($d2['ytlFiyat'] * $d2['adet'])));
			$kdv = hq("select kdv from urun where ID= '" . $d2['urunID'] . "'");
			$transs->addChild('VAT_RATE', (($kdv * 100)));
			$transs->addChild('VAT_AMOUNT', ((($d2['ytlFiyat'] * $d2['adet']) - (($d2['ytlFiyat'] * $d2['adet']) / (1 + $kdv)))));
			$transs->addChild('VAT_BASE', (($d2['ytlFiyat'] * $d2['adet'])));
			$transs->addChild('UNIT_CODE', (hq("select urunBirim from urun where ID='" . $d2['urunID'] . "'")));
			$transs->addChild('UNIT_CONV1', ('1'));
			$transs->addChild('UNIT_CONV2', ('1'));
			$transs->addChild('DUE_DATE', ($tarih));
			$transs->addChild('RC_XRATE', ('1'));
			$transs->addChild('TOTAL_NET', (($d2['ytlFiyat'] * $d2['adet'])));
			$transs->addChild('DATA_REFERENCE', ('1'));
			$transs->addChild('DETAILS', (' '));
			$camp = $transs->addChild('CAMPAIGN_INFOS', '');
			$camp->addChild('CAMPAIGN_INFO', '');
			$transs->addChild('DEFNFLDS', (' '));
			$transs->addChild('EDT_PRICE', ($d2['ytlFiyat']));
			$transs->addChild('EDT_CURR', ($d2['ytlFiyat']));
			$transs->addChild('ORG_DUE_DATE', ($tarih));
			$transs->addChild('ORG_QUANTITY', ($d2['adet']));
			$transs->addChild('ORG_PRICE', ($d2['ytlFiyat']));
		}
		$channel->addChild('ITEXT', ('1'));
		$channel->addChild('ORGLOGOID', (''));
		$channel->addChild('DEFNFLDSLIST', (' '));
		$channel->addChild('AFFECT_RISK', ('0'));
		// $channel->addChild('GUID',('E10EC29D-2EED-4D45-BD4D-74EA132B759C'));
		$channel->addChild('GUID', (guid($d['randStr'])));
		$channel->addChild('DEDUCTIONPART1', ('2'));
		$channel->addChild('DEDUCTIONPART2', ('3'));
	}
	$xml->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}
function guid($str)
{
	//  mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
	$charid = strtoupper(md5($str));
	$hyphen = chr(45); // "-"
	$uuid = '' . substr($charid, 0, 8) . $hyphen
		. substr($charid, 8, 4) . $hyphen
		. substr($charid, 12, 4) . $hyphen
		. substr($charid, 16, 4) . $hyphen
		. substr($charid, 20, 12);
	// .chr(125);// "}"
	return $uuid;
}


function buildYurticikargosiparislerXMLFile()
{
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><document></document>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	if ($_GET['start-date'])
		$f = ' AND semt not in(3,11,12,15) ';
	$q = my_mysql_query("select * from siparis where durum = 2 $f");

	while ($d = my_mysql_fetch_array($q)) {
		$channel = $xml->addChild('cargo', '');
		$channel->addChild('receiver_name', cleanStr($d['name'] . ' ' . $d['lastname'] . ' '. $d['ID']));
		$channel->addChild('receiver_address',cleanStr(htmlentities($d['address']) . ' ' . hq("select name from ilceler where ID='" . $d['semt'] . "'") . ' ' . hq("select name from iller where plakaID='" . $d['city'] . "'")));
		$channel->addChild('city', hq("select name from iller where plakaID='" . $d['city'] . "'"));
		$channel->addChild('town', hq("select name from ilceler where ID='" . $d['semt'] . "'"));
    	$vowels = array("-", " ", "(", ")");
		$channel->addChild('phone_work',str_replace ($vowels,"", ($d['istel'])));
		$channel->addChild('phone_gsm', str_replace ($vowels,"" ,($d['ceptel'])));
		$channel->addChild('email_address', cleanStr($d['email']));
		$channel->addChild('tax_number', cleanStr($d['tckNo']));
		$channel->addChild('cargo_type', 2);
		$channel->addChild('payment_type', 1);
		$channel->addChild('dispatch_number', $d['randStr']);
		$channel->addChild('referans_number', $d['randStr']);
		$channel->addChild('cargo_count', 1);
		$channel->addChild('cargo_content', $d['randStr'] . ' nolu siparis icerigi');
	//	$channel->addChild('collection_type', 0);
		$channel->addChild('invoice_number', $d['kargoSeriNo']);
		$channel->addChild('invoice_amount', str_replace('.', ',', my_money_format('', $d['toplamKDVDahil'])));
	}
	return $xml->asXML();
}
function buildSiparislerXMLFile()
{
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><SIPARISLER></SIPARISLER>';
	$xml = new SimpleXMLElement($defaultXML);
	$f = '';
	if ($_GET['start-date'])
		$f .= ' AND tarih >= \'' . $_GET['start-date'] . '\' AND tarih <= \'' . $_GET['finish-date'] . '\'';
	if ($_GET['siparis_no'])
		$f .= ' AND randStr = \'' . $_GET['siparis_no'] . '\'';
	if ($_GET['siparis_durum'])
		$f .= ' AND durum = \'' . (int) $_GET['siparis_durum'] . '\'';
	if ($_GET['userID'])
		$f .= ' AND userID = \'' . (int) $_GET['userID'] . '\'';
	$q = my_mysql_query("select * from siparis where durum >= 0 AND durum < 80 AND tarih > '" . date('Y-m-d H:i:s', mktime(date('H'), date('i'), (date('s')), date('m'), (date('d') - ((int) $_GET['gun'] ? (int) $_GET['gun'] : 365)), date('Y'))) . "' $f order by ID desc");
	while ($d = my_mysql_fetch_array($q)) {
		$channel = $xml->addChild('SIPARIS', '');
		list($tarih, $zaman) = explode(' ', $d['tarih']);
		$channel->addChild('SIPARIS_NO', ($d['randStr']));
		$channel->addChild('DURUM_NO', ($d['durum']));
		$channel->addChild('KULLANICI_KODU', ($d['userID']));
		$channel->addChild('POSTA', cleanStr($d['email']));
		$channel->addChild('TARIH', ($tarih));
		$channel->addChild('ZAMAN', ($zaman));
		$channel->addChild('ISKONTO', $d['degisimYuzde']);
		$channel->addChild('SEPETINDIRIM', my_money_format('', $d['sepetIndirim']));
		$channel->addChild('PROMOSYON', my_money_format('', $d['promotionUsed']));
		$channel->addChild('NET_TOPLAM', str_replace(',', '', my_money_format('', $d['toplamKDVDahil'])));
		$channel->addChild('ODEME_TOPLAM', str_replace(',', '', my_money_format('', $d['toplamTutarTL'])));
		$channel->addChild('TeslimAliciID', cleanStr($d['userID']));
		$channel->addChild('TeslimAlici', cleanStr($d['name'] . ' ' . $d['lastname']));
		$channel->addChild('TeslimUsername', cleanStr(hq("select username from user where ID='" . $d['userID'] . "'")));
		$channel->addChild('TeslimTCKNo', cleanStr($d['tckNo']));
		$channel->addChild('TeslimIl', hq("select name from iller where plakaID='" . $d['city'] . "'"));
		$channel->addChild('TeslimIlce', hq("select name from ilceler where ID='" . $d['semt'] . "'"));
		$channel->addChild('TeslimAdresi', cleanStr(htmlentities($d['address'])));
		$channel->addChild('FaturaIl', hq("select name from iller where plakaID='" . $d['city2'] . "'"));
		$channel->addChild('FaturaIlce', hq("select name from ilceler where ID='" . $d['semt2'] . "'"));
		$channel->addChild('FaturaAdresi', cleanStr(htmlentities($d['address2'])));
		$channel->addChild('FirmaUnvani', ($d['firmaUnvani']));
		$channel->addChild('VergiDairesi', ($d['vergiDaire']));
		$channel->addChild('VergiNo', ($d['vergiNo']));
		$channel->addChild('TeslimTelefon', ($d['ceptel']));

		$channel->addChild('KargoTakipNo', ($d['kargoSeriNo']));
		$channel->addChild('Not', ($d['notAlici']));


		$trans = $channel->addChild('KARGO_UCRETI', my_money_format('', $d['kargoTutar']));
		$trans = $channel->addChild('KAPIDA_ODEME_UCRETI', my_money_format('', $d['degisimYTL']));
		$trans = $channel->addChild('ODEME_SEKLI', cleanStr($d['odemeTipi']));
		$trans = $channel->addChild('ODEME_DURUM', cleanStr(hq("select title from odemeDurum where ID='" . $d['durum'] . "'")));
		$trans = $channel->addChild('SATIRLAR', '');
		$q2 = my_mysql_query("select * from sepet where randStr = '" . $d['randStr'] . "'");
		while ($d2 = my_mysql_fetch_array($q2)) {
			$transs = $trans->addChild('SATIR', '');
			$transs->addChild('URUN_ID', $d2['urunID']);
			$transs->addChild('KOD', (hq("select tedarikciCode from urun where ID='" . $d2['urunID'] . "'")));
			$transs->addChild('UBARKOD', (hq("select gtin from urun where ID='" . $d2['urunID'] . "'")));

			$varkod = hq("select kod from urunvarstok where up=1 AND urunID='" . $d2['urunID'] . "' AND var1='" . $d2['ozellik1'] . "'AND var2='" . $d2['ozellik2'] . "'");
			$transs->addChild('VARKOD', $varkod ? $varkod : $d2['ID']);
			$varkod = hq("select gtin from urunvarstok where up=1 AND urunID='" . $d2['urunID'] . "' AND var1='" . $d2['ozellik1'] . "'AND var2='" . $d2['ozellik2'] . "'");
			$transs->addChild('VARBARKOD', $varkod ? $varkod : $d2['gtin']);

			$transs->addChild('ADI', cleanStr($d2['urunName']));
			$transs->addChild('VAR1', $d2['ozellik1']);
			$transs->addChild('VAR2', $d2['ozellik2']);
			$transs->addChild('MIKTAR', ($d2['adet']));
			$transs->addChild('BIRIM', (hq("select urunBirim from urun where ID='" . $d2['urunID'] . "'")));
			$transs->addChild('FIYAT', (str_replace(',', '', my_money_format('', ($d2['ytlFiyat'] * 1)))));
			if (!$d['kdv'])
				$d2['kdv'] = hq("select kdv from urun where ID='" . $d2['urunID'] . "'");
			$transs->addChild('KDV', ($d2['kdv'] * 100));

			for ($j = 1; $j <= 50; $j++) {
				$d2['ozellik' . $j] = varViewReplace($d2['ozellik' . $j], $d2['urunID']);
				if ($d2['ozellik' . $j] && $d2['ozellik' . $j] != '-' && $d2['ozellik' . $j] != ' ') {
					$transs->addChild('OZELLIK_'.$j, ($d2['ozellik'.$j] ));
				}
			}
		}

		if ($d['kargoTutar']) {
			$transs = $trans->addChild('KARGO', '');
			$kod = tr2eu(strtoupper(str_replace(' ', '', hq("select name from kargofirma where ID='" . $d['kargoFirmaID'] . "'"))));
			$kod = str_replace('i', 'I', $kod);
			$transs->addChild('KOD', $kod);
			$transs->addChild('MIKTAR', 1);
			$transs->addChild('BIRIM', 'Ad.');
			$transs->addChild('FIYAT', my_money_format('', $d['kargoTutar']));
			$transs->addChild('KDV', 18);
		}


		if ($d['degisimYTL']) {
			$kod2 = tr2eu(strtoupper(str_replace(' ', '', hq("select bankaAdi from banka where ID='" . $d['odemeID'] . "'"))));
			$kod2 = str_replace('i', 'I', $kod2);
			$transs = $trans->addChild('SATIR', '');
			$transs->addChild('KOD', $kod2);
			$transs->addChild('MIKTAR', 1);
			$transs->addChild('BIRIM', 'Ad.');
			$transs->addChild('FIYAT', my_money_format('', $d['degisimYTL']));
			$transs->addChild('KDV', 18);
		}
	}
	return $xml->asXML();
}
function buildBirfaturasiparislerXMLFile()
{
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><SIPARISLER></SIPARISLER>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	if ($_GET['start-date'])
		$f = ' AND tarih >= \'' . $_GET['start-date'] . '\' AND tarih <= \'' . $_GET['finish-date'] . '\'';
	$q = my_mysql_query("select * from siparis where durum > 1 AND durum < 80 AND tarih > '" . date('Y-m-d H:i:s', mktime(date('H'), date('i'), (date('s')), date('m'), (date('d') - ((int) $_GET['gun'] ? (int) $_GET['gun'] : 365)), date('Y'))) . "' $f");
	while ($d = my_mysql_fetch_array($q)) {
		$channel = $xml->addChild('SIPARIS', '');
		list($tarih, $zaman) = explode(' ', $d['tarih']);
		$channel->addChild('SIPARIS_ID', ($d['ID']));
		$channel->addChild('SIPARIS_NO', ($d['randStr']));
		$channel->addChild('POSTA', cleanStr($d['email']));
		$channel->addChild('TARIH', ($tarih));
		$channel->addChild('SAAT', ($zaman));
		$channel->addChild('KullaniciAdi', cleanStr(hq("select username from user where ID='" . $d['userID'] . "'")));
		$channel->addChild('TeslimTelefon', ($d['ceptel']));
		$channel->addChild('TeslimAlici', cleanStr($d['name'] . ' ' . $d['lastname']));
		$channel->addChild('TeslimIl', hq("select name from iller where plakaID='" . $d['city'] . "'"));
		$channel->addChild('TeslimIlce', hq("select name from ilceler where ID='" . $d['semt'] . "'"));
		$channel->addChild('TeslimAdresi', cleanStr(htmlentities(preg_replace('/[\x00-\x1f]/', '',$d['address']))));
		$channel->addChild('FirmaTel', ($d['istel']));
		$channel->addChild('FirmaUnvani', cleanStr($d['firmaUnvani']));
		$channel->addChild('FaturaAdresi', cleanStr(htmlentities($d['address2'])));
		$channel->addChild('FaturaIl', hq("select name from iller where plakaID='" . $d['city2'] . "'"));
		$channel->addChild('FaturaIlce', hq("select name from ilceler where ID='" . $d['semt2'] . "'"));
		$channel->addChild('VergiDaire', $d['vergiDaire']);
		$channel->addChild('VergiNo', $d['vergiNo']);
		$channel->addChild('TeslimTCKNo', cleanStr($d['tckNo']));
		$channel->addChild('KampanyaKodu', cleanStr($d['kargoSeriNo']));
		$channel->addChild('SiparisNotu', cleanStr($d['promotionCode']));
		$channel->addChild('ODEME_SEKLI', cleanStr($d['odemeTipi']));
		$channel->addChild('ODEME_DURUM', cleanStr(hq("select title from odemeDurum where ID='" . $d['durum'] . "'")));
		$channel->addChild('KARGO_DURUM', cleanStr(hq("select title from odemeDurum where ID='" . $d['durum'] . "'")));
		$channel->addChild('KARGO_ID', ($d['bkargoID']));
		$channel->addChild('KARGO_URL', ($d['kargoURL']));


		
		$channel->addChild('KARGO_BARKOD', ($d['kargoSeriNo']));
		$channel->addChild('KARGO_FIRMA_ID', ($d['kargoFirma'] ? $d['kargoFirma'] : $d['kargoFirmaID']));
		$channel->addChild('KARGO_FIRMA_NAME', hq("select name from kargofirma where ID='" . ($d['kargoFirma'] ? $d['kargoFirma'] : $d['kargoFirmaID']) . "'"));
		$trans = $channel->addChild('SATIRLAR', '');
		$q2 = my_mysql_query("select * from sepet where randStr = '" . $d['randStr'] . "'");
		while ($d2 = my_mysql_fetch_array($q2)) {
			$transs = $trans->addChild('SATIR', '');
			$kod = hq("select tedarikciCode from urun where ID='" . $d2['urunID'] . "'");
			$transs->addChild('KOD', ($kod ? $kod : $d2['urunID']));
			$transs->addChild('ADI', cleanStr($d2['urunName']));
			$transs->addChild('VAR1', $d2['ozellik1']);
			$transs->addChild('VAR2', $d2['ozellik2']);
			$transs->addChild('MIKTAR', ($d2['adet']));
			$transs->addChild('BIRIM', (hq("select urunBirim from urun where ID='" . $d2['urunID'] . "'")));
			$transs->addChild('FIYAT', (str_replace(',', '', my_money_format('', ($d2['ytlFiyat'] * 1)))));
			$kdv = ($d2['kdv'] * 100);
			if (!$kdv)
				$kdv = (hq("select kdv from urun where ID='" . $d2['urunID'] . "'") * 100);

			$transs->addChild('KDV', $kdv);
		}

		if ($d['degisimYTL']) {
			$kod2 = tr2eu(strtoupper(str_replace(' ', '', hq("select bankaAdi from banka where ID='" . $d['odemeID'] . "'"))));
			$kod2 = str_replace('i', 'I', $kod2);
			$transs = $trans->addChild('SATIR', '');
			$transs->addChild('KOD', $kod2);
			$transs->addChild('ADI', hq("select bankaAdi from banka where ID='" . $d['odemeID'] . "'"));
			$transs->addChild('MIKTAR', 1);
			$transs->addChild('BIRIM', 'Ad.');
			$transs->addChild('FIYAT', my_money_format('', $d['degisimYTL']));
			$transs->addChild('KDV', 0);
		}

		if ($d['teslimatID']) {
			$kod2 = tr2eu(strtoupper('Teslimat-' . str_replace(' ', '', dbInfo('teslimat', 'name', $d['teslimatID']))));
			$kod2 = str_replace('i', 'I', $kod2);
			$transs = $trans->addChild('SATIR', '');
			$transs->addChild('KOD', $kod2);
			$transs->addChild('ADI', 'Teslimat ' . dbInfo('teslimat', 'name', $d['teslimatID']));
			$transs->addChild('MIKTAR', 1);
			$transs->addChild('BIRIM', 'Ad.');
			$transs->addChild('FIYAT', my_money_format('', $d['teslimatFark']));
			$transs->addChild('KDV', 18);
		}
		$d['data4'] = ($d['toplamTutarTL'] * (1 - $d['degisimYuzde']) - ($d['toplamKDVDahil'] + $d['kargoTutar']));
		if ($d['data4']) {
			$transs = $trans->addChild('SATIR', '');
			$transs->addChild('KOD', 'VADE');
			$transs->addChild('ADI', 'VADE FARKI');
			$transs->addChild('MIKTAR', 1);
			$transs->addChild('BIRIM', 'Ad.');
			$transs->addChild('FIYAT', my_money_format('', $d['data4'] / 1.18));
			$transs->addChild('KDV', 0);
		}



		$channel->addChild('ISKONTO', (($d['toplamKDVDahil'] - $d['toplamIndirimDahil'])));
		$channel->addChild('NET_TOPLAM', str_replace(',', '', my_money_format('', $d['toplamKDVDahil'])));
		$channel->addChild('KargoUcreti', str_replace(',', '', my_money_format('', $d['kargoTutar'])));
		$channel->addChild('SiparişTutarı', str_replace(',', '', my_money_format('', $d['toplamTutarTL'] * (1 - $d['degisimYuzde']))));
	}
	return $xml->asXML();
}
function buildCityXMLFile()
{
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><SEHIRLER></SEHIRLER>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	$q = my_mysql_query("select * from iller where cID = 1 order by name");
	while ($d = my_mysql_fetch_array($q)) {
		$channel = $xml->addChild('SEHIR', '');
		$channel->addChild('SEHIR_ID', ($d['plakaID']));
		$channel->addChild('SEHIR_ADI', ($d['name']));
	}
	return $xml->asXML();
}

function buildTownXMLFile()
{
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><SEMTLER></SEMTLER>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	$q = my_mysql_query("select * from ilceler order by name");
	while ($d = my_mysql_fetch_array($q)) {
		$channel = $xml->addChild('SEMT', '');
		$channel->addChild('SEMT_ID', ($d['ID']));
		$channel->addChild('SEHIR_PLAKA_ID', ($d['parentID']));
		$channel->addChild('SEMT_ADI', ($d['name']));
		$channel->addChild('FIYAT_FARKI', ($d['fiyatFarki']));
		$channel->addChild('GONDERIM_DURUMU', ($d['disabled'] ? 'YOK' : 'VAR'));
	}
	return $xml->asXML();
}

function buildAddressXMLFile()
{
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><ADRESLER></ADRESLER>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	$q = my_mysql_query("select * from useraddress where userID= '" . (int) $_GET['userID'] . "'");
	while ($d = my_mysql_fetch_array($q)) {
		$channel = $xml->addChild('FIRMA', '');
		$channel->addChild('ADDRESS_ID', ($d['ID']));
		$channel->addChild('BASLIK', ($d['baslik']));
		$channel->addChild('ADDRESS', ($d['address']));
		$channel->addChild('SEMT_ID', ($d['semt']));
		$channel->addChild('SEHIR_PLAKA_ID', ($d['city']));
		$channel->addChild('ADI', ($d['name']));
		$channel->addChild('SOYADI', ($d['lastname']));
		$channel->addChild('CEPTEL', ($d['ceptel']));
		$channel->addChild('TCKNO', ($d['tckNo']));
		$channel->addChild('VERGINO', ($d['vergiNo']));
		$channel->addChild('VERGIDAIRE', ($d['vergiDaire']));
	}
	return $xml->asXML();
}

function buildKargoXMLFile()
{
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><FIRMALAR></FIRMALAR>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	$q = my_mysql_query("select ID,name from kargofirma order by name");
	while ($d = my_mysql_fetch_array($q)) {
		$channel = $xml->addChild('FIRMA', '');
		$channel->addChild('FIRMA_ID', ($d['ID']));
		$channel->addChild('FIRMA_ADI', ($d['name']));
	}
	return $xml->asXML();
}

function buildBannerXMLFile()
{
	global $siteDizini;
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><BANNERLAR></BANNERLAR>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	$q = my_mysql_query("select * from bannerlar order by ID", 1);
	while ($d = my_mysql_fetch_array($q)) {
		$channel = $xml->addChild('FIRMA', '');
		$channel->addChild('BANNER_ID', ($d['ID']));
		$channel->addChild('BANNER_ADI', ($d['name']));
		$channel->addChild('BANNER_PIC', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/banner/' . $d['resimJS']));
		$channel->addChild('BANNER_LINK', ($d['url']));
		$channel->addChild('BANNER_CATS_ONLY', ($d['cats']));
		$channel->addChild('BANNER_USER_GROUPS_ONLY', ($d['userGroup']));
		$channel->addChild('BANNER_ACTIVE', ($d['active']));
	}
	return $xml->asXML();
}

function buildSliderXMLFile()
{
	global $siteDizini;
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><SLIDERS></SLIDERS>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	$q = my_mysql_query("select * from kampanyaJSBanner order by seq");
	while ($d = my_mysql_fetch_array($q)) {
		$channel = $xml->addChild('slider', '');
		$channel->addChild('type', 'Default');
		$channel->addChild('title', ($d['title']));
		$channel->addChild('title2', ($d['title2']));
		$channel->addChild('info', ($d['info']));
		$channel->addChild('info2', ($d['info2']));
		$channel->addChild('resim', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/kampanya/' . $d['resimJS']));
		$channel->addChild('thumb', ($d['thumb']));
		$channel->addChild('link', ($d['link']));
		$channel->addChild('sira', ($d['seq']));
	}

	$q = my_mysql_query("select * from kampanyaBanner order by seq");
	while ($d = my_mysql_fetch_array($q)) {
		$channel = $xml->addChild('slider', '');
		$channel->addChild('type', 'Simple');
		$channel->addChild('title', ($d['title']));
		$channel->addChild('resim', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/kampanya/' . $d['resim']));
		$channel->addChild('thumb', ($d['thumb']));
		$channel->addChild('link', ($d['link']));
		$channel->addChild('sira', ($d['seq']));
	}
	return $xml->asXML();
}
function buildKullanicilarXMLFile()
{
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><KULLANICILAR></KULLANICILAR>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	if ($_GET['userID'])
		$f = ' where ID=' . (int) $_GET['userID'];
	$q = my_mysql_query("select * from user $f");
	while ($d = my_mysql_fetch_array($q)) {
		$channel = $xml->addChild('KULLANICI', '');
		$channel->addChild('CARI_KOD', ($d['ID']));
		$channel->addChild('CARI_USERNAME', ($d['username']));
		$channel->addChild('CARI_TCKNO', ($d['tckNo']));
		$channel->addChild('CARI_DOGUMTARIHI', ($d['birthdate']));
		$channel->addChild('CARI_CINSIYET', ($d['sex']));
		$channel->addChild('CARI_ISIM', (cleanStr($d['name'] . ' ' . $d['lastname'])));
		$channel->addChild('CARI_ADRES', cleanStr($d['address']));
		$channel->addChild('CARI_ILCE', (cleanStr(hq("select name from ilceler where ID='" . $d['semt'] . "'"), 15, "", STR_PAD_LEFT)));
		$channel->addChild('CARI_IL', (cleanStr(hq("select name from iller where plakaID='" . $d['city'] . "'"), 15, "", STR_PAD_LEFT)));
		$channel->addChild('ULKE_KODU', (cleanStr('', 4, "0", STR_PAD_LEFT)));
		$channel->addChild('POSTAKODU', (cleanStr('', 8, "0", STR_PAD_LEFT)));
		$channel->addChild('CARI_TEL', (cleanStr($d['ceptel'], 20, "", STR_PAD_LEFT)));
		$channel->addChild('FAX', (cleanStr($d['istel'], 20, "0", STR_PAD_LEFT)));
		$channel->addChild('EMAIL', (cleanStr($d['email'], 60, " ", STR_PAD_LEFT)));
		$channel->addChild('VERGI_DAIRESI', (cleanStr($d['vergiDaire'], 15, "", STR_PAD_LEFT)));
		$channel->addChild('VERGI_NUMARASI', (cleanStr($d['vergiNo'], 15, "", STR_PAD_LEFT)));
		$channel->addChild('ACIK1', (cleanStr($d['data1'], 50, "", STR_PAD_LEFT)));
		$channel->addChild('ACIK2', (cleanStr($d['data2'], 50, "", STR_PAD_LEFT)));
		$channel->addChild('ACIK3', (cleanStr($d['data3'], 50, "", STR_PAD_LEFT)));
		$fArray = array();
		$q2 = my_mysql_query("select * from alarmListe where userID= '" . $d['ID'] . "' AND type='AlarmListem'");
		while ($d2 = my_mysql_fetch_array($q2)) {
			$fArray[] = $d2['urunID'];
		}
		$channel->addChild('FAVORI_URUNLER', implode(',', $fArray));
	}
	return $xml->asXML();
}
function setN11Price($d)
{
	if ((int) siteConfig('n11_fiyatAlani') > 0) {
		$field = 'fiyat' . siteConfig('n11_fiyatAlani');
		if ($d[$field] > 1)
			$d['fiyat'] = $d[$field];
	}
	$d['fiyat'] = fixFiyat($d['fiyat'], 0, $d);
	$kar = hq("select nckar from kategori where ID='" . $d['catID'] . "' limit 1");
	if (!$kar)
		$kar = siteConfig('n11_oran');
	if (!siteConfig('n11_fiyatBirim'))
		$fiyat = YTLfiyat($d['fiyat'], $d['fiyatBirim']);
	else
		$fiyat = $d['fiyat'];
	$fiyat = ($fiyat * (1 + ((float) $kar)));
	if ((float) $fiyat <= (float) siteConfig('n11_azami'))
		$fiyat = ($fiyat + ((float) siteConfig('n11_fiyat')));
	$fiyat = my_money_format('', $fiyat);
	$fiyat = str_replace(',', '', $fiyat);
	if ($_GET['ckar'])
		$fiyat += ($fiyat * (float) $_GET['ckar']);
	if ($_GET['fkar'])
		$fiyat += ($fiyat * (float) $_GET['fkar']);
	return $fiyat;
}
function buildN11XMLFile()
{
	global $siteDizini;
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><Urunler></Urunler>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	$order = 'order by catID';
	$start = ($_GET['start'] ? $_GET['start'] : 0);
	if ($_GET['limit']) $limit = 'limit ' . $start . ',' . (int) $_GET['limit'];
	if ($_GET['order']) $order = 'order by ' . $_GET['order'];
	$catPatern = hq("select idPath from kategori where ID='" . $_GET['catID'] . "'");
	if ($_GET['catID'])
		$filter = "AND (showCatIDs like '%|" . $_GET['catID'] . "|%' OR catID='" . $_GET['catID'] . "' OR kategori.idPath like '" . $catPatern . "/%')";
	$q = my_mysql_query("select urun.*,kategori.name as catName,kategori.ckar as ckar,marka.name as markaName,kategori.namePath as namePathx,kategori.yc_Kod as gg_Kodx from urun,kategori,marka where urun.active = 1 AND yc_Kod != '' AND urun.catID=kategori.ID AND marka.ID = urun.markaID AND catID!=0 AND markaID!=0 AND fiyat > 0 AND bakiyeOdeme=0 $filter $order $limit");
	while ($d = my_mysql_fetch_array($q)) {
		$d = itemOptionFixXML($d);
		$d['fiyat'] = setN11Price($d);
		$forg = $d['fiyat'];
		$d['name'] = str_replace(array('&prime;'), '', $d['name']);
		$d['name'] = str_replace(array('&reg;'), '', $d['name']);
		$d['name'] = substr($d['name'], 0, 65);
		$d['name'] = iconv("utf-8", "utf-8//ignore", $d['name']);
		$d['listeDetay'] = str_replace(array('&prime;'), '', $d['listeDetay']);
		$d['listeDetay'] = str_replace(array('&reg;'), '', $d['listeDetay']);
		$d['onDetay'] = str_replace(array('&prime;'), '', $d['onDetay']);
		$d['onDetay'] = str_replace(array('&reg;'), '', $d['onDetay']);
		$d['onDetay'] = str_replace(array('&nbsp;', '&nbsp'), ' ', ($d['onDetay']));
		$d['listeDetay'] = substr($d['listeDetay'], 0, 65);
		$d['listeDetay'] = iconv("utf-8", "utf-8//ignore", $d['listeDetay']);
		$d['detay'] = str_replace(array('&prime;'), '', $d['detay']);
		$d['detay'] = str_replace(array('&reg;'), '', $d['detay']);
		$d['detay'] = str_replace(array('&nbsp;', '&nbsp'), ' ', ($d['detay']));
		$d['markaName'] = str_replace(array('&prime;'), '', $d['markaName']);
		$d['markaName'] = str_replace(array('&reg;'), '', $d['markaName']);
		$d['markaName'] = str_replace(array('&nbsp;', '&nbsp'), ' ', ($d['markaName']));
		$channel = $xml->addChild('Urun', '');
		$channel->addChild('Kod', $d['ID']);
		$channel->addChild('Baslik', htmlspecialchars(($d['name'])));
		if ($d['listeDetay'])
			$channel->addChild('AltBaslik', htmlspecialchars($d['listeDetay']));
		else
			$channel->addChild('AltBaslik', htmlspecialchars(($d['name'])));
		$channel->addChild('Aciklama', (cleanStr($d['onDetay'] . '' . $d['detay'])));
		$channel->addChild('Durum', 1);
		$channel->addChild('UrunOnayi', 1);
		// $hs = $d['data1'];
		$channel->addChild('HazirlamaSuresi', ($d['anindaGonderim'] ? 1 : 3));
		$kategori = $channel->addChild('Kategori');
		$kategori->addAttribute('no', $d['gg_Kodx']);
		$d['namePathx'] = str_replace('/', ' &gt; ', $d['namePathx']);
		$kategori->addAttribute('isim', ($d['namePathx']));
		$ozellikler = $kategori->addChild('Ozellikler');
		$ozellik = $ozellikler->addChild('Ozellik', ($d['markaName']));
		$ozellik->addAttribute('no', $d['markaID']);
		$ozellik->addAttribute('isim', 'Marka');

		$channel->addChild('GroupAttribute', '');
		$channel->addChild('GroupItemCode', '');
		$channel->addChild('ItemName', '');


		$fArray = explode('],[', $d['filitre']);
		foreach ($fArray as $f) {
			list($k, $v) = explode('::', $f);
			if (!$k) continue;
			$k = str_replace('[', '', $k);
			$v = str_replace('],', '', $v);
			$v = str_replace(']', '', $v);
			$fbaslik = hq("select baslik from filitre where ID='" . $k . "'");
			$ozellik = $ozellikler->addChild('Ozellik', cleanstr($v));
			$ozellik->addAttribute('no', hq("select n11code from filitre where ID='" . $k . "'"));
			$ozellik->addAttribute('isim', cleanstr($fbaslik));
		}
		if ($d['piyasafiyat']) $oran = (100 - (int) ((100 * $d['fiyat']) / $d['piyasafiyat']));
		$fiyat = $d['fiyat'];
		if (!$d['ckar'])
			$d['ckar'] = (float) $_GET['ckar'];
		$fiyat = fixFiyat($fiyat, 0, $d['ID']);
		$channel->addChild('Fiyat', $fiyat);
		$channel->addChild('ParaBirimi', 'TL');

		$variants = $channel->addChild('Stoklar', '');
		if (!$d['ozellik1detay']) {
			$variant = $variants->addChild('Stok');
			$miktar = $variant->addChild('Miktar', (cleanstr($d['stok'])));
		} else {
			for ($i = 1; $i <= 3; $i++) {
				if ($d['ozellik' . $i]) {
					$vArray = explode("\n", $d['ozellik' . $i . 'detay']);
					foreach ($vArray as $v) {
						if (!$v) continue;
						$variant = $variants->addChild('Stok');
						list($name, $fark, $stok) = explode('|', $v);
						if (!$name) continue;
						list($name1, $name2) = explode('-', $name);
						$stok = hq("select stok from urunvarstok where urunID='" . $d['ID'] . "' AND (var1 like '$name' OR var2 like '$name') order by stok desc limit 0,1");
						if (!$stok)
							$stok = hq("select stok from urunvarstok where urunID='" . $d['ID'] . "' AND (var1 like '$name1' AND var2 like '$name2') order by stok desc limit 0,1");
						if (($stok == '' && $stok != 0 && $stok != '0'))
							$stok = $d['stok'];
						if ($d['stok'] < $stok)
							$stok = $d['stok'];
						$ozellik = $variant->addChild('Ozellik', (cleanstr($name)));
						$ozellik->addAttribute('isim', (cleanstr($d['ozellik' . $i])));
						$miktar = $variant->addChild('Miktar', (int) $stok);
						$df['var1']  = $name1;
						$df['var2'] = $name2;
						$miktar = $variant->addChild('StokFiyati', ($fiyat + ((float) hq("select fark from urunvars where urunID = '" . $d['ID'] . "' AND var like '" . $df['var1'] . "'") + (float) hq("select fark from urunvars where urunID = '" . $d['ID'] . "' AND var like '" . $df['var2'] . "'") + (float) hq("select fark from urunvarstok where urunID = '" . $d['ID'] . "' AND var1 like '" . $df['var1'] . "' AND var2 like '" . $df['var2'] . "'"))));
					}
				}
			}
		}
		$oran = ((float) urunTopluIndirimOran($d['ID']) * 100);

		if ($d['n11BundleActive'])
			$channel->addChild('Bundle', 'true');
		$channel->addChild('IndirimTutari', 0);
		$channel->addChild('IndirimTuru', (bool) (max(0, ($oran))));
		$channel->addChild('TeslimatSablonu', ($_GET['ts'] ? $_GET['ts'] : 'Depo'));
		$resimler = $channel->addChild('Resimler');
		$resimler->addChild('Resim', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim']));
		if (strlen($d['resim2']) > 4) $resimler->addChild('Resim', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim2']));
		if (strlen($d['resim3']) > 4) $resimler->addChild('Resim', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim3']));
		if (strlen($d['resim4']) > 4) $resimler->addChild('Resim', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim4']));
		if (strlen($d['resim5']) > 4) $resimler->addChild('Resim', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim5']));
	}
	$xml->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}
function buildDogusXMLFile()
{
	global $siteDizini;
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><Urunler></Urunler>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	$order = 'order by catID';
	$start = ($_GET['start'] ? $_GET['start'] : 0);
	if ($_GET['limit']) $limit = 'limit ' . $start . ',' . (int) $_GET['limit'];
	// if ($_GET['filter']) $filter = 'AND '.$_GET['filter'].' = 1';
	if ($_GET['order']) $order = 'order by ' . $_GET['order'];
	if ($_GET['catID']) $filter = "AND showCatIDs like '%|" . $_GET['catID'] . "|%'";
	$q = my_mysql_query("select urun.*,kategori.name as catName,marka.name as markaName,kategori.namePath as namePathx from urun,kategori,marka where urun.active = 1 AND urun.catID=kategori.ID AND marka.ID = urun.markaID AND catID!=0 AND markaID!=0 AND fiyat > 0 AND bakiyeOdeme=0  $filter $order $limit");
	while ($d = my_mysql_fetch_array($q)) {
		$d['name'] = str_replace(array('&prime;'), '', $d['name']);
		$d['name'] = str_replace(array('&reg;'), '', $d['name']);
		$channel = $xml->addChild('Urun', '');
		$channel->addChild('KategoriAdi', (cleanStr($d['namePathx'])));
		$channel->addChild('UrunAdi', ($d['name']));
		$channel->addChild('UrunID', $d['ID']);
		$channel->addChild('marka', ($d['markaName']));
		$channel->addChild('resimA', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim']));
		if ($d['resim2']) $channel->addChild('resimB', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim2']));
		if ($d['resim3']) $channel->addChild('resimC', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim3']));
		if ($d['resim4']) $channel->addChild('resimD', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim4']));
		if ($d['resim5']) $channel->addChild('resimE', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim5']));
		$channel->addChild('etiketFiyati', $d['piyasafiyat']);
		$channel->addChild('ListeFiyat', $d['fiyat']);
		$channel->addChild('IndirimTuru', '0');
		$channel->addChild('fiyatbirimi', $d['fiyatBirim']);
		$channel->addChild('aciklama', (cleanStr($d['onDetay'])));
		$channel->addChild('kdv', (((float) $d['kdv']) * 100));
		$channel->addChild('StokAdedi', $d['stok']);
		$variants = $channel->addChild('Stoklar', '');
		for ($i = 1; $i <= 3; $i++) {
			if ($d['ozellik' . $i]) {
				$vArray = explode("\n", $d['ozellik' . $i . 'detay']);
				foreach ($vArray as $v) {
					if (!$v) continue;
					$variant = $variants->addChild('Stok');
					list($name, $fark, $stok) = explode('|', $v);
					if (($stok == '' && $stok != 0) || !$stok) $stok = $d['stok'];
					$variant->addChild('isim', (cleanstr($d['ozellik' . $i])));
					$variant->addChild('vcode', (cleanstr($d['ID'] . '-' . $i)));
					$variant->addChild('deger', (cleanstr($name)));
					$variant->addChild('miktar', ($stok ? $stok : $d['stok']));
				}
			}
		}
		$channel->addChild('status', $d['active']);
		$channel->addChild('Durum', $d['active']);
		if (!$d['active']) $channel->addChild('UrunOnayi', '2');
	}
	$xml->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}
function buildrssXMLFile()
{
	global $siteDizini;
	$xml = new SimpleXMLElementExtended('<rss version="2.0"></rss>');
	$xml->addChild('channel');
	$xml->channel->addChild('title', siteConfig('seo_title'));
	$xml->channel->addChild('link', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini);
	$xml->channel->addChild('description', siteConfig('seo_metaDescription'));
	$xml->channel->addChild('pubDate', date(DATE_RSS));
	switch ($_GET['type']) {
		case 'kategori':
			$order = 'order by level,seq,name';
			if ($_GET['order']) $order = 'order by ' . $_GET['order'];
			$filter = ($_GET['catID'] ? ' AND ID=\'' . $_GET['catID'] . '\'' : '');
			$filter .= ($_GET['level'] ? ' AND level<=\'' . $_GET['level'] . '\'' : '');
			$q = my_mysql_query("select * from kategori where active=1 $filter $order");
			while ($d = my_mysql_fetch_array($q)) {
				$item = $xml->channel->addChild('item');
				$item->addChild('title', (cleanstr($d['name'])));
				$item->addChild('link', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER['HTTP_HOST'] . kategoriLink($d));
				$item->addChild('description', (cleanstr($d['metaDescription'])));
				$item->addChild('pubDate', date(DATE_RSS));
			}
			break;
		default:
			$order = 'order by ID desc';
			$start = ($_GET['start'] ? $_GET['start'] : 0);
			if ($_GET['limit']) $limit = 'limit ' . $start . ',' . (int) $_GET['limit'];
			// if ($_GET['filter']) $filter = 'AND '.$_GET['filter'].' = 1';
			if ($_GET['order']) $order = 'order by urun.' . $_GET['order'];
			if ($_GET['catID']) $filter = "AND (showCatIDs like '%|" . $_GET['catID'] . "|%' OR catID='" . $_GET['catID'] . "' OR kategori.idPath like '%/" . $_GET['catID'] . "/%' OR kategori.idPath like '" . $_GET['catID'] . "/%')";
			$query = "select urun.* from urun,kategori where urun.catID=kategori.ID AND urun.active = 1 AND kategori.active=1 AND bakiyeOdeme=0  $filter $order $limit";
			$q = my_mysql_query($query);
			while ($d = my_mysql_fetch_array($q)) {
				$d['fiyat'] = fixFiyat($d['fiyat'], 0, $d['ID']);
				$item = $xml->channel->addChild('item');
				$item->addChild('title', (cleanstr($d['name']) . ' : ' . my_money_format('', $d['fiyat']) . ' ' . $d['fiyatBirim']));
				$item->addChild('image', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim']));
				$item->addChild('link', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER['HTTP_HOST'] . urunLink($d));
				$item->addChild('description', (cleanstr($d['onDetay'])));
				$item->addChild('pubDate', date(DATE_RSS));
			}
			break;
	}
	$xml->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}
function buildGoXMLFile()
{
	global $siteDizini;
	switch ($_GET['type']) {
		case 'kategori':
			$defaultXML = '<?xml version="1.0" encoding="utf-8"?><kategoriler></kategoriler>';
			$xml = new SimpleXMLElementExtended($defaultXML);
			$order = 'order by level,seq,name';
			if ($_GET['order']) $order = 'order by ' . $_GET['order'];
			$filter = ($_GET['catID'] ? ' AND ID=\'' . $_GET['catID'] . '\'' : '');
			$filter .= ($_GET['level'] ? ' AND level<=\'' . $_GET['level'] . '\'' : '');
			$q = my_mysql_query("select * from kategori where active=1 $filter $order");
			while ($d = my_mysql_fetch_array($q)) {
				$channel = $xml->addChild('kategori', '');
				$channel->addChild('kategori_aktif', ($d['active']));
				$channel->addChild('kategori_kod', ($d['ID']));
				$channel->addChild('ust_kategori_kod', ($d['parentID']));
				$channel->addChild('kategori_ad', (cleanstr($d['name'])));
				$channel->addChild('kategori_path', (cleanstr($d['namePath'])));
				$channel->addChild('toplam_urun', (hq("select count(*) from urun where showCatIDs like '%|" . $d['ID'] . "|%' AND fiyat > 0 AND bakiyeOdeme = 0 AND active = 1")));
			}
			break;
		default:
			$defaultXML = '<?xml version="1.0" encoding="utf-8"?><urunler></urunler>';
			$xml = new SimpleXMLElementExtended($defaultXML);
			$order = 'order by catID';
			$start = ($_GET['start'] ? $_GET['start'] : 0);
			if ($_SESSION['userGroupID']) {
				$userID = $_SESSION['userID'];
				$xmlCat = hq("select xmlcat from userGroups where ID='" . $_SESSION['userGroupID'] . "'");
				$xmlMarka = hq("select xmlmarka from userGroups where ID='" . $_SESSION['userGroupID'] . "'");
			}
			if ($_GET['limit']) $limit = 'limit ' . $start . ',' . (int) $_GET['limit'];
			if ($_GET['order']) $order = 'order by urun.' . $_GET['order'];
			if ($_GET['catID']) $filter = "AND (showCatIDs like '%|" . $_GET['catID'] . "|%' OR catID='" . $_GET['catID'] . "' OR kategori.idPath like '%/" . $_GET['catID'] . "/%' OR kategori.idPath like '" . $_GET['catID'] . "/%')";
			$q = my_mysql_query("select urun.*,kategori.ckar,kategori.gg_Kod from urun,kategori where urun.catID=kategori.ID AND catID!=0 AND markaID!=0 AND bakiyeOdeme=0 AND urun.active=1 AND kategori.active = 1  $filter $order $limit");
			while ($d = my_mysql_fetch_array($q)) {
				$d['name'] = cleanstr($d['name']);
				$d['detay'] = cleanstr($d['detay']);
				$d['onDetay'] = cleanstr($d['onDetay']);
				$d['fiyat'] = fixFiyat($d['fiyat'], 0, $d['ID']);
				if (!$_GET['facebook'])
					$d['fiyat'] = ($d['fiyat'] * (1 + $d['ckar']));
				if ($xmlCat && (stristr($xmlCat, ',' . $d['catID'] . ',') === false))
					continue;
				if ($xmlMarka && (stristr($xmlMarka, ',' . $d['markaID'] . ',') === false))
					continue;
				$channel = $xml->addChild('urun', '');
				$channel->addChild('urun_url', (cleanStr('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . urunlink($d))));
				$channel->addChild('urun_id', ($d['ID']));
				$channel->addChild('marka', (cleanstr(hq("select name from marka where ID='" . $d['markaID'] . "'"))));
				$channel->addChild('baslik', (cleanstr($d['name'])));
				$channel->addChild('tanim', ($d['onDetay']));
				$channel->addChild('aciklama1', '' . ($d['detay']) . '');
				$fiyatp = (float) str_replace(',', '', my_money_format('', ((float) $d['piyasafiyat'] / (1 + (float) $d['kdv']))));
				$channel->addChild('fiyat', $fiyatp);
				$fiyat = (float) str_replace(',', '', my_money_format('', ((float) $d['fiyat'] / (1 + (float) $d['kdv']))));
				$channel->addChild('indirimlifiyat', $fiyat);
				$oran = (100 - (int) ((100 * $d['fiyat']) / $d['piyasafiyat']));
				$channel->addChild('indirimorani', $oran);
				$channel->addChild('birim', ($d['fiyatBirim']));
				$parentID = hq("select parentID from kategori where ID='" . $d['catID'] . "'");
				$catname = hq("select name from kategori where ID='" . $d['catID'] . "'");
				$catname2 = hq("select name from kategori where ID='" . $parentID . "'");

				$channel->addChild('kategori', ($catname2));
				$channel->addChild('altkategori', ($catname));
				$channel->addChild('resimurl', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim']));
				$channel->addChild('stok', ($d['stok']));
			}
			break;
	}
	if ($_GET['username'] && $_GET['password'])
		$_SESSION['userID'] = $_SESSION['username'] = $_SESSION['password'] = $_SESSION['loginStatus'] = $_SESSION['siparisID'] = $_SESSION['bayi'] = '';
	$xml->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}
function xmlCacheFilename()
{
	global $siteDizini;
	if (stristr(strtolower($_GET['c']), 'siparis') === false) {
		$code = substr(md5(serialize($_GET)), 0, 10);
		return $_SERVER['DOCUMENT_ROOT'] . $siteDizini . 'files/' . $_GET['c'] . '_' . $code . '.xml';
	}
}
function checkForXmlCache()
{
	$xmlCacheFilename = xmlCacheFilename();
	if (siteConfig('xml_cache') && $xmlCacheFilename && file_exists($xmlCacheFilename) && (time() - filemtime($xmlCacheFilename) < siteConfig('xml_cache')))
		exit(file_get_contents($xmlCacheFilename));
}

function buildalter2XMLFile()
{
	global $siteDizini, $siteConfig;

	autoAddFormField('kategori', 'noxml', 'CHECKBOX');
	autoAddFormField('urun', 'noxml', 'CHECKBOX');
	switch ($_GET['type']) {
		default:
			$defaultXML = '<?xml version="1.0" encoding="utf-8"?><Root><Urunler></Urunler></Root>';
			$xml = new SimpleXMLElementExtended($defaultXML);
			$order = 'order by catID';
			$start = ($_GET['start'] ? $_GET['start'] : 0);
			if ($_SESSION['userGroupID']) {
				$userID = $_SESSION['userID'];
				$xmlCat = hq("select xmlcat from userGroups where ID='" . $_SESSION['userGroupID'] . "'");
				$xmlMarka = hq("select xmlmarka from userGroups where ID='" . $_SESSION['userGroupID'] . "'");
			}
			if ($_GET['limit']) $limit = 'limit ' . $start . ',' . (int) $_GET['limit'];
			if ($_GET['urunID']) $filter = 'AND urun.ID= ' . (int) $_GET['urunID'];
			if ($_GET['markaID']) $filter = 'AND urun.markaID= ' . (int) $_GET['markaID'];
			if ($_GET['filter']) $filter = 'AND urun.' . $_GET['filter'] . ' = 1';
			//if ($_GET['order']) $order = 'order by urun.'.$_GET['order'];
			if ($_GET['tID']) $filter = 'AND urun.tedarikciID= ' . (int) $_GET['tID'];
			if ($_GET['catID']) $filter .= "AND (showCatIDs like '%|" . $_GET['catID'] . "|%' OR catID='" . $_GET['catID'] . "' OR kategori.idPath like '%/" . $_GET['catID'] . "/%' OR kategori.idPath like '" . $_GET['catID'] . "/%')";
			if ($_GET['tIDs']) {
				$filter = 'AND (';
				$tIDs = explode(',', $_GET['tIDs']);
				foreach ($tIDs as $tID) {
					$tID = (int) $tID;
					if ($tID)
						$filter .= 'urun.tedarikciID = \'' . $tID . '\' OR ';
				}
				$filter .= ' 1 = 2) ';
			}
			$q = my_mysql_query("select urun.*,kategori.ckar,kategori.namePath,kategori.gg_Kod,marka.name markaName,kategori.name catName from urun,kategori,marka where urun.noxml != 1 AND kategori.noxml != 1 AND urun.markaID = marka.ID AND urun.catID=kategori.ID AND catID!=0 AND markaID!=0 AND bakiyeOdeme=0 AND urun.active=1 AND kategori.active = 1  $filter $order $limit");

			while ($d = my_mysql_fetch_array($q)) {
				$d['fiyat'] = fixFiyat($d['fiyat'], 0, $d);
				if (!$_GET['facebook'])


					$d['fiyat'] = ($d['fiyat'] * (1 + $d['ckar']));
				if ($xmlCat && (stristr($xmlCat, ',' . $d['catID'] . ',') === false))
					continue;
				if ($xmlMarka && (stristr($xmlMarka, ',' . $d['markaID'] . ',') === false))
					continue;
				$channel = $xml->addChild('Urun', '');

				$channel->addChild('UrunKartiID', ($d['ID']));
				$channel->addChild('StokKodu', ($d['tedarikciCode']));
				$channel->addChild('Barkod', ($d['gtin']));
				$channel->addChild('UrunAdi', cleanstr($d['name']));

				$channel->addChildWithCDATA('OnYazi', $d['onDetay']);
				$channel->addChildWithCDATA('Aciklama', $d['detay']);
				$channel->addChild('Marka', (cleanstr($d['markaName'])));
				$channel->addChild('Desi', (cleanstr($d['desi'])));

				$channel->addChild('UrunUrl', (('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . urunlink($d))));
				$channel->addChild('PiyasaFiyati', (str_replace('.', ',', $d['piyasafiyat'])));
				$channel->addChild('SatisFiyati', (str_replace('.', ',', $d['fiyat'])));
				$channel->addChild('Stok', (($d['stok'])));
				$channel->addChild('Kdv', ($d['kdv'] * 100));

				$resimler = $channel->addChild('Resimler', '');
				for ($j = 1; $j <= 5; $j++) {
					$resimStr = 'resim' . ($j == 1 ? '' : $j);
					if ($d[$resimStr])
						$resimler->addChild('Resim', ('http' . ($siteConfig['httpsAktif']  ? 's' : '') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d[$resimStr]));
				}

				if ($d['varID1'] || $d['varID2']) {
					$urunvar = $channel->addChild('Variants');
					$var1 = (cleanstr(hq("select ozellik from var where ID='" . $d['varID1'] . "'")));
					$var2 = (cleanstr(hq("select ozellik from var where ID='" . $d['varID2'] . "'")));

					$vq = my_mysql_query("select * from urunvarstok where urunID='" . $d['ID'] . "'");
					while ($vd = my_mysql_fetch_array($vq)) {
						$var = $urunvar->addChild('Variant');
						$price1 = hq("select fark from urunvars where urunID='" . $d['ID'] . "' AND varID='" . $d['varID1'] . "' AND var like '" . $vd['var1'] . "'");
						$price2 = hq("select fark from urunvars where urunID='" . $d['ID'] . "' AND varID='" . $d['varID2'] . "' AND var like '" . $vd['var2'] . "'");

						
						$var->addChild('VaryasyonID', $vd['ID']);
						$var->addChild('StokKodu', $vd['kod']);
						$var->addChild('Barkod', $vd['gtin']);
						$var->addChild('Stok', $vd['stok']);
						$var->addChild('Kdv', ($d['kdv'] * 100));
						$var->addChild('SatisFiyati', $price1 + $price2 + $d['fiyat']);

						$sec = $var->addChild('vSecenekler');
						$sec1 = $sec->addChild('vSecenek');
						$sec1->addChild('variantAdi', $var1);
						$sec1->addChild('variantDeger', cleanstr($vd['var1']));

						if($var2 && $vd['var2'])
						{
							$sec2 = $sec->addChild('vSecenek');
							$sec2->addChild('variantAdi', $var2);
							$sec2->addChild('variantDeger', cleanstr($vd['var2']));
						}
					}
				}
			}
			break;
	}
	if ($_GET['username'] && $_GET['password'])
		$_SESSION['userID'] = $_SESSION['username'] = $_SESSION['password'] = $_SESSION['loginStatus'] = $_SESSION['siparisID'] = $_SESSION['bayi'] = '';
	$xml->saveXML(xmlCacheFilename());
	return str_replace('script>', 'script_x', (file_get_contents(xmlCacheFilename())));
}

function buildalterXMLFile()
{
	global $siteDizini, $siteConfig;

	autoAddFormField('kategori', 'noxml', 'CHECKBOX');
	autoAddFormField('urun', 'noxml', 'CHECKBOX');
	switch ($_GET['type']) {
		default:
			$defaultXML = '<?xml version="1.0" encoding="utf-8"?><urunler></urunler>';
			$xml = new SimpleXMLElementExtended($defaultXML);
			$order = 'order by catID';
			$start = ($_GET['start'] ? $_GET['start'] : 0);
			if ($_SESSION['userGroupID']) {
				$userID = $_SESSION['userID'];
				$xmlCat = hq("select xmlcat from userGroups where ID='" . $_SESSION['userGroupID'] . "'");
				$xmlMarka = hq("select xmlmarka from userGroups where ID='" . $_SESSION['userGroupID'] . "'");
			}
			if ($_GET['limit']) $limit = 'limit ' . $start . ',' . (int) $_GET['limit'];
			if ($_GET['urunID']) $filter = 'AND urun.ID= ' . (int) $_GET['urunID'];
			if ($_GET['markaID']) $filter = 'AND urun.markaID= ' . (int) $_GET['markaID'];
			if ($_GET['filter']) $filter = 'AND urun.' . $_GET['filter'] . ' = 1';
			//if ($_GET['order']) $order = 'order by urun.'.$_GET['order'];
			if ($_GET['tID']) $filter = 'AND urun.tedarikciID= ' . (int) $_GET['tID'];
			if ($_GET['catID']) $filter .= "AND (showCatIDs like '%|" . $_GET['catID'] . "|%' OR catID='" . $_GET['catID'] . "' OR kategori.idPath like '%/" . $_GET['catID'] . "/%' OR kategori.idPath like '" . $_GET['catID'] . "/%')";
			if ($_GET['tIDs']) {
				$filter = 'AND (';
				$tIDs = explode(',', $_GET['tIDs']);
				foreach ($tIDs as $tID) {
					$tID = (int) $tID;
					if ($tID)
						$filter .= 'urun.tedarikciID = \'' . $tID . '\' OR ';
				}
				$filter .= ' 1 = 2) ';
			}
			$q = my_mysql_query("select urun.*,kategori.ckar,kategori.namePath,kategori.gg_Kod,marka.name markaName,kategori.name catName from urun,kategori,marka where urun.noxml != 1 AND kategori.noxml != 1 AND urun.markaID = marka.ID AND urun.catID=kategori.ID AND catID!=0 AND markaID!=0 AND bakiyeOdeme=0 AND urun.active=1 AND kategori.active = 1  $filter $order $limit");

			while ($d = my_mysql_fetch_array($q)) {
				$d['fiyat'] = fixFiyat($d['fiyat'], 0, $d);
				if (!$_GET['facebook'])


					$d['fiyat'] = ($d['fiyat'] * (1 + $d['ckar']));
				if ($xmlCat && (stristr($xmlCat, ',' . $d['catID'] . ',') === false))
					continue;
				if ($xmlMarka && (stristr($xmlMarka, ',' . $d['markaID'] . ',') === false))
					continue;
				$channel = $xml->addChild('urun', '');

				$channel->addChild('model', ($d['listeDetay']));
				$channel->addChild('adi', cleanstr($d['name']));
				$channel->addChild('marka', (cleanstr($d['markaName'])));
				$channel->addChild('barkod', ($d['gtin']));
				$channel->addChild('stok_adedi', ($d['stok']));
				$resimler = $channel->addChild('resimler', '');
				for ($j = 1; $j <= 5; $j++) {
					$resimStr = 'resim' . ($j == 1 ? '' : $j);
					if ($d[$resimStr])
						$resimler->addChild('resim' . $j, ('http' . ($siteConfig['httpsAktif']  ? 's' : '') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d[$resimStr]));
				}
				$channel->addChild('urun_kategori', (cleanstr($d['namePath'])));
				$channel->addChild('fiyat', (str_replace('.', ',', $d['piyasafiyat'])));
				$channel->addChild('fiyat_birim', (str_replace('.', ',', $d['fiyatBirim'])));

				$channel->addChild('indirimli_fiyat', (str_replace('.', ',', $d['fiyat'])));
				$channel->addChildWithCDATA('aciklama', $d['detay']);
				$channel->addChildWithCDATA('urun_durum', ($d['active'] ? 'Açık' : 'Kapalı'));

				if ($d['talepText']) {
					$urunvar = $channel->addChild('talepler');
					$arr = explode("\n", $d['talepText']);
					$i = 1;
					foreach ($arr as $a) {
						if (!$a)
							continue;
						list($a, $fark) = explode('|', $a);
						$a = trim($a);
						$fark = trim($fark);
						$var = $urunvar->addChild('talep');
						$var->addChild('talep_adi', $a);
						$var->addChild('talep_farki', $fark);
					}
				}

				if ($d['varID1'] || $d['varID2']) {
					$urunvar = $channel->addChild('secenekler');
					$var1 = (cleanstr(hq("select ozellik from var where ID='" . $d['varID1'] . "'")));
					$var2 = (cleanstr(hq("select ozellik from var where ID='" . $d['varID2'] . "'")));

					$vq = my_mysql_query("select kod,stok,var1,var2 from urunvarstok where urunID='" . $d['ID'] . "'");
					while ($vd = my_mysql_fetch_array($vq)) {
						$var = $urunvar->addChild('secenek');
						$price1 = hq("select fark from urunvars where urunID='" . $d['ID'] . "' AND varID='" . $d['varID1'] . "' AND var like '" . $vd['var1'] . "'");
						$price2 = hq("select fark from urunvars where urunID='" . $d['ID'] . "' AND varID='" . $d['varID2'] . "' AND var like '" . $vd['var2'] . "'");
						$var->addChild('secenek_adi', $var1);
						$var->addChild('secenek_deger', (cleanstr($vd['var1'])));
						$var->addChild('secenek_fiyat', $price1 + $price2 + $d['fiyat']);
						$var->addChild('secenek_stok', $vd['stok']);
					}
				}
			}
			break;
	}
	if ($_GET['username'] && $_GET['password'])
		$_SESSION['userID'] = $_SESSION['username'] = $_SESSION['password'] = $_SESSION['loginStatus'] = $_SESSION['siparisID'] = $_SESSION['bayi'] = '';
	$xml->saveXML(xmlCacheFilename());
	return str_replace('script>', 'script_x', (file_get_contents(xmlCacheFilename())));
}


function buildShopphpXMLFile()
{
	global $siteDizini;
	autoAddFormField('kategori', 'noxml', 'CHECKBOX');
	autoAddFormField('urun', 'noxml', 'CHECKBOX');
	$kar = hq("select data1 from xmlexport where code like '" . $_GET['c'] . "'");
	switch ($_GET['type']) {
		case 'kategori':
			$defaultXML = '<?xml version="1.0" encoding="utf-8"?><kategoriler></kategoriler>';
			$xml = new SimpleXMLElementExtended($defaultXML);
			$order = 'order by level,seq,name';
			$filter = ($_GET['catID'] ? ' AND ID=\'' . (int) $_GET['catID'] . '\'' : '');
			$filter .= ($_GET['parentID'] ? ' AND parentID=\'' . (int) $_GET['parentID'] . '\'' : '');
			$filter .= ($_GET['namePath'] ? ' AND namePath  like \'' . $_GET['namePath'] . '%\'' : '');
			$filter .= ($_GET['level'] ? ' AND level<=\'' . (int) $_GET['level'] . '\'' : '');
			$q = my_mysql_query("select * from kategori where active=1 $filter $order");
			while ($d = my_mysql_fetch_array($q)) {
				$channel = $xml->addChild('kategori', '');
				$channel->addChild('kategori_aktif', ($d['active']));
				$channel->addChild('kategori_kod', ($d['ID']));
				$channel->addChild('ust_kategori_kod', ($d['parentID']));
				$channel->addChild('kategori_ad', (cleanstr($d['name'])));
				$channel->addChild('kategori_path', (cleanstr($d['namePath'])));
				$channel->addChild('kategori_url', (kategoriLink($d)));
				$channel->addChild('toplam_urun', (hq("select count(*) from urun where showCatIDs like '%|" . $d['ID'] . "|%' AND fiyat > 0 AND bakiyeOdeme = 0 AND active = 1")));
			}
			break;
		case 'marka':
			$defaultXML = '<?xml version="1.0" encoding="utf-8"?><markalar></markalar>';
			$xml = new SimpleXMLElementExtended($defaultXML);
			$filter .= ($_GET['markaID'] ? ' where ID=\'' . (int) $_GET['markaID'] . '\'' : '');
			$q = my_mysql_query("select * from marka $filter order by name");
			while ($d = my_mysql_fetch_array($q)) {
				$channel = $xml->addChild('marka', '');
				$channel->addChild('marka_kod', ($d['ID']));
				$channel->addChild('marka_ad', (cleanstr($d['name'])));
				$channel->addChild('toplam_urun', (hq("select count(*) from urun where markaID='" . $d['ID'] . "' AND bakiyeOdeme = 0 AND active = 1")));
			}
			break;
		default:
			$defaultXML = '<?xml version="1.0" encoding="utf-8"?><urunler></urunler>';
			$xml = new SimpleXMLElementExtended($defaultXML);
			$order = 'order by catID';
			$start = (int)($_GET['start'] ? $_GET['start'] : 0);
			if ($_SESSION['userGroupID']) {
				$xmlCat = hq("select xmlcat from userGroups where ID='" . $_SESSION['userGroupID'] . "'");
				$xmlMarka = hq("select xmlmarka from userGroups where ID='" . $_SESSION['userGroupID'] . "'");
			}
			$filter = '';
			if ($_GET['limit']) $limit = 'limit ' . (int)$start . ',' . (int) $_GET['limit'];
			if ($_GET['urunID']) $filter .= 'AND urun.ID= ' . (int) $_GET['urunID'];
			if ($_GET['markaID']) $filter .= 'AND urun.markaID= ' . (int) $_GET['markaID'];
			if ($_GET['filter']) $filter .= 'AND urun.' . $_GET['filter'] . ' = 1';
			if ($_GET['tID']) $filter .= 'AND urun.tedarikciID= ' . (int) $_GET['tID'];
			if ($_GET['namePath']) $filter .= 'AND kategori.namePath like  \'' . $_GET['namePath'] . '%\'';

			if ($_GET['catID']) $filter .= "AND (showCatIDs like '%|" . $_GET['catID'] . "|%' OR catID='" . $_GET['catID'] . "' OR kategori.idPath like '%/" . $_GET['catID'] . "/%' OR kategori.idPath like '" . $_GET['catID'] . "/%')";
			if ($_GET['tIDs']) {
				$filter = 'AND (';
				$tIDs = explode(',', $_GET['tIDs']);
				foreach ($tIDs as $tID) {
					$tID = (int) $tID;
					if ($tID)
						$filter .= 'urun.tedarikciID = \'' . $tID . '\' OR ';
				}
				$filter .= ' 1 = 2) ';
			}
			if ($_GET['catIDs']) {
				$filter = 'AND (';
				$tIDs = explode(',', $_GET['catIDs']);
				foreach ($tIDs as $tID) {
					$tID = (int) $tID;
					if ($tID)
						$filter .= 'urun.catID = \'' . $tID . '\' OR ';
				}
				$filter .= ' 1 = 2) ';
			}
			$ui = 0;
			$urunFieldArray = array();
			$q = my_mysql_query("select * from urunField order by seq");
			while ($d = my_mysql_fetch_array($q)) {
				$urunFieldArray[$ui]['name'] = $d['fname'];
				$urunFieldArray[$ui]['title'] = $d['name'];
				$urunFieldArray[$ui]['type'] = $d['ftype'];
				$ui++;
			}

			$q = my_mysql_query("select urun.*,kategori.ckar,kategori.gg_Kod,kategori.namePath,marka.name markaName,kategori.name catName from urun,kategori,marka where urun.noxml != 1 AND kategori.noxml != 1 AND urun.markaID = marka.ID AND urun.catID=kategori.ID AND catID!=0 AND markaID!=0 AND bakiyeOdeme=0 AND urun.active=1 AND kategori.active = 1  $filter $order $limit");
			while ($d = my_mysql_fetch_array($q)) {
				$d['detay'] = str_replace('src="images/', 'src="https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'images/', $d['detay']);
				$gercekFiyat = $d['fiyat'];
				$d['fiyat'] = fixFiyat($d['fiyat'], 0, $d);
				if (!$_GET['facebook'])
					$d['fiyat'] = ($d['fiyat'] * (1 + $d['ckar']));
				if (isset($_GET['kar']))
					$d['fiyat'] = ($d['fiyat'] * (1 + $_GET['kar']));
				if ($xmlCat && (stristr($xmlCat, ',' . $d['catID'] . ',') === false))
					continue;
				if ($xmlMarka && (stristr($xmlMarka, ',' . $d['markaID'] . ',') === false))
					continue;
				if($d['userGroup'] && (stristr($d['userGroup'], ',' . $_SESSION['userGroupID'] . ',') === false))
					continue;
				if ($kar)
					$d['fiyat'] = ((1 + (float)$kar) * $d['fiyat']);
				$channel = $xml->addChild('urun', '');
				$channel->addChild('urun_aktif', ($d['active']));
				$channel->addChild('urun_metaKeywords', cleanstr($d['metaKeywords']));
				$channel->addChild('urun_metaDescription', cleanstr($d['metaDescription']));
				$channel->addChild('urun_url', (('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . urunlink($d))));
				$channel->addChild('urun_ID', ($d['ID']));
				$channel->addChild('urun_kod', ($d['tedarikciCode']));
				$channel->addChild('urun_gtin', ($d['gtin']));
				$channel->addChild('urun_xml_kod', ($d['tedarikciCode']));
				$channel->addChildWithCDATA('urun_ad', (cleanstr($d['name'])));
				$parentID = hq("select parentID from kategori where ID='" . $d['catID'] . "'");
				$catname = cleanstr(hq("select name from kategori where ID='" . $parentID . "'"));
				$parentID2 = hq("select parentID from kategori where ID='" . $parentID . "'");
				$catname2 = cleanstr(hq("select name from kategori where ID='" . $parentID2 . "'"));
				$parentID3 = hq("select parentID from kategori where ID='" . $parentID2 . "'");
				$catname3 = cleanstr(hq("select name from kategori where ID='" . $parentID3 . "'"));
				$parentID4 = hq("select parentID from kategori where ID='" . $parentID3 . "'");
				$catname4 = cleanstr(hq("select name from kategori where ID='" . $parentID4 . "'"));
				$parentID5 = hq("select parentID from kategori where ID='" . $parentID4 . "'");
				$catname5 = cleanstr(hq("select name from kategori where ID='" . $parentID5 . "'"));

				//$catname = str_replace('&','&amp;',$catname);
				$channel->addChild('urun_ana_kategori_kod_l4', ($parentID5));
				$channel->addChild('urun_ana_kategori_ad_l4', ($catname5));
				$channel->addChild('urun_ana_kategori_kod_l3', ($parentID4));
				$channel->addChild('urun_ana_kategori_ad_l3', ($catname4));
				$channel->addChild('urun_ana_kategori_kod_l2', ($parentID3));
				$channel->addChild('urun_ana_kategori_ad_l2', ($catname3));
				$channel->addChild('urun_ana_kategori_kod', ($parentID2));
				$channel->addChild('urun_ana_kategori_ad', ($catname2));
				$channel->addChild('urun_ust_kategori_kod', ($parentID));
				$channel->addChild('urun_ust_kategori_ad', ($catname));
				$catname = cleanstr($d['catName']);
				$catname = str_replace('&', '&amp;', $catname);
				$channel->addChild('urun_kategori_kod', ($d['catID']));
				$channel->addChild('urun_kategori_ggkod', ($d['gg_Kod']));
				$channel->addChild('urun_kategori_ad', ($catname));
				$channel->addChild('urun_kategori_path', ($d['namePath']));

				if(sizeof($urunFieldArray) > 0)
				{
					$new = $channel->addChild('urun_ek_field');
					
					foreach($urunFieldArray as $f)
					{
						$field = $new->addChild('field');
						$field->addAttribute('title', $f['title']);
						$field->addAttribute('type', $f['type']);
						$field->addAttribute('name', $f['name']);
						$field->addAttribute('value', $d[$f['name']]);
					}
				}

				if ($d['virtualCatIDs'])
					$channel->addChild('urun_sanal_kategori_kod', ($d['virtualCatIDs']));
				$channel->addChild('urun_marka_kod', ($d['markaID']));
				$channel->addChild('urun_marka_ad', (cleanstr($d['markaName'])));
				if ($d['varID1']) {
					$urunvar = $channel->addChild('urun_varyasyonlari');
					$var1 = (cleanstr(hq("select ozellik from var where ID='" . $d['varID1'] . "'")));
					$var2 = (cleanstr(hq("select ozellik from var where ID='" . $d['varID2'] . "'")));
					$vq = my_mysql_query("select * from urunvarstok where up=1 AND var1 != '' " . ($d['varID2'] ? ' AND var2 != \'\'' : '') . " AND urunID='" . $d['ID'] . "'");
					while ($vd = my_mysql_fetch_array($vq)) {
						$var = $urunvar->addChild('varyasyon');
						$price1 = hq("select fark from urunvars where urunID='" . $d['ID'] . "' AND varID='" . $d['varID1'] . "' AND var like '" . $vd['var1'] . "'");
						$new = $var->addChild('var1');
						$new->addAttribute('baslik', $var1);
						$new->addAttribute('varyasyon', (cleanstr($vd['var1'])));
						//$new->addAttribute('fiyat_fark', $price1);
						if ($var2) {
							$price2 = hq("select fark from urunvars where urunID='" . $d['ID'] . "' AND varID='" . $d['varID2'] . "' AND var like '" . $vd['var2'] . "'");
							$new = $var->addChild('var2');
							$new->addAttribute('baslik', $var2);
							$new->addAttribute('varyasyon', (cleanstr($vd['var2'])));
							//$new->addAttribute('fiyat_fark', $price2);
						}
						$fark = (float)hq("select fark from urunvarstok where urunID='" . $d['ID'] . "' AND (var1 like '" . str_replace(' ', '%', $vd['var1']) . "' AND var2 like '" . str_replace(' ', '%', $vd['var2']) . "') AND up=1");
						$fark = fixFiyat($fark,0,$d['ID']);
						$var->addChild('fiyat_fark', $fark);
						$var->addChild('stok', $vd['stok']);
						$var->addChild('gtin', $vd['gtin']);
						$var->addChild('stok_kod', $vd['kod'] ? $vd['kod'] : $vd['ID']);

						$qx = my_mysql_query("select * from urunvar where urunID = '" . (int)$d['ID'] . "' AND varID = '" . (int)$d['varID1'] . "' AND varName = '" . addslashes(trim($vd['var1'])) . "'");
						while ($dx = my_mysql_fetch_array($qx)) {
							for ($xi = 1; $xi <= 10; $xi++) {
								if ($dx['resim' . $xi])
									$var->addChild('resim' . $xi, 'https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'images/urunler/var/' . $dx['resim' . $xi]);
							}
						}
					}
				}
				$autoValues = array('data1', 'data2', 'data3', 'data4', 'data5');
				foreach ($autoValues as $av) {
					$channel->addChild($av, (cleanstr($d[$av])));
				}
				$channel->addChild('urun_ucretsizKargo', ($d['ucretsizKargo'] ? '1' : '0'));
				$channel->addChild('urun_tanim', htmlspecialchars($d['onDetay']));
				if ($d['talepText'])
					$channel->addChild('urun_talepText', htmlspecialchars($d['talepText']));
				if ($d['talepDosya'])
					$channel->addChild('urun_talepDosya', htmlspecialchars($d['talepDosya']));
				if ($d['talepSelect'])
					$channel->addChild('urun_talepSecim', htmlspecialchars($d['talepSelect']));
				$channel->addChildWithCDATA('urun_aciklama', $d['detay']);
				$channel->addChild('urun_ozellikler', (filterSpecs($d['ID'])));
				for ($j = 1; $j <= 5; $j++) {
					$resimStr = 'resim' . ($j == 1 ? '' : $j);
					if ($d[$resimStr])
						$channel->addChild('urun_resim' . $j, ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d[$resimStr]));
				}

				$fiyat1 = $d['piyasafiyat'];
				$fiyat2 = $d['fiyat'];
				$fiyat3 = $gercekFiyat;
				$fiyat1 = (float) str_replace(',', '', my_money_format('', ((float) $fiyat1 / (1 + (float) $d['kdv']))));
				$fiyat2 = (float) str_replace(',', '', my_money_format('', ((float) $fiyat2 / (1 + (float) $d['kdv']))));
				$fiyat3 = (float) str_replace(',', '', my_money_format('', ((float) $fiyat3 / (1 + (float) $d['kdv']))));
				$fiyatYTL = YTLfiyat($d['fiyat'], $d['fiyatBirim']);
				$fiyatYTL = ($fiyatYTL / (1 + $d['kdv']));
				$fiyatYTL = str_replace(',', '', $fiyatYTL);

				if (siteConfig('gg_desi')) {
					$desi = (hq('select kargoDesi.fiyat from kargoDesi where firmaID=\'' . siteConfig('gg_kargoID') . '\' AND desiBaslangic <= ' . $d['desi'] . ' AND desiBitis >= ' . $d['desi'] . ' order by kargoDesi.fiyat desc limit 0,1'));
					$desi = YTLfiyat($desi, hq('select kargoDesi.fiyatBirim from kargoDesi where firmaID=\'' . siteConfig('gg_kargoID') . '\' AND desiBaslangic <= ' . $d['desi'] . ' AND desiBitis >= ' . $d['desi'] . ' order by kargoDesi.fiyat desc limit 0,1'));
					$channel->addChild('urun_kargo_fiyat', ($desi));
					$channel->addChild('urun_kargodahil_fiyat', ($desi + $fiyatYTL));
				}

				$channel->addChild('urun_fiyat', $fiyat2);
				$channel->addChild('urun_fiyat_TL', $fiyatYTL);
				$channel->addChild('urun_havale_fiyat_TL', ($fiyatYTL * (1 - ((float) siteConfig('havaleIndirim')))));
				$channel->addChild('urun_fiyat_son_kullanici', $fiyat1);
				$channel->addChild('urun_fiyat_bayi_ozel', $fiyat2);
				$channel->addChild('urun_fiyat_site', $fiyat3);
				$channel->addChild('urun_fiyat_piyasa', $d['piyasafiyat']);
				$channel->addChild('urun_doviz', ($d['fiyatBirim']));
				$channel->addChild('urun_kdv', ($d['kdv']));
				$channel->addChild('urun_stok', ($d['stok']));
				$channel->addChild('urun_garanti', ($d['garanti']));
				$channel->addChild('urun_ucretsizKargo', ($d['ucretsizKargo']));
				$channel->addChild('urun_indirimde', ($d['indirimde']));


				if ($d['desi']) $channel->addChild('urun_kargo_desi', ($d['desi']));
				if ($d['minSatis']) $channel->addChild('urun_min_satis', ($d['minSatis']));
				if ($d['seq']) $channel->addChild('urun_oncelik', ($d['seq']));
				if ($d['fixKargoFiyat']) $channel->addChild('urun_kargo_fix_fiyat', ($d['fixKargoFiyat']));
			}
			break;
	}
	if ($_GET['username'] && $_GET['password'])
		$_SESSION['userID'] = $_SESSION['username'] = $_SESSION['password'] = $_SESSION['loginStatus'] = $_SESSION['siparisID'] = $_SESSION['bayi'] = '';
	$xml->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}
function cleanStr($str)
{
	//$str = cleanStr2($str);
	return htmlspecialchars($str, ENT_XML1 | ENT_QUOTES, 'UTF-8');
}

function cleanStr2($value)
{
	$ret = "";
	$current;
	if (empty($value)) {
		return $ret;
	}

	$length = strlen($value);
	for ($i = 0; $i < $length; $i++) {
		$current = ord($value{
			$i});
		if (($current == 0x9) ||
			($current == 0xA) ||
			($current == 0xD) ||
			(($current >= 0x20) && ($current <= 0xD7FF)) ||
			(($current >= 0xE000) && ($current <= 0xFFFD)) ||
			(($current >= 0x10000) && ($current <= 0x10FFFF))
		) {
			$ret .= chr($current);
		} else {
			$ret .= " ";
		}
	}
	return $ret;
}

function buildIdeasoftXMLFile()
{
	global $siteDizini;
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><root></root>';
	$xmlx = new SimpleXMLElementExtended($defaultXML);
	$filter = '';
	$order = 'order by catID';
	$start = ($_GET['start'] ? $_GET['start'] : 0);
	if ($_GET['limit']) $limit = 'limit ' . $start . ',' . (int) $_GET['limit'];
	if ($_GET['order']) $order = 'order by ' . $_GET['order'];
	if ($_GET['catID']) $filter .= "AND showCatIDs like '%|" . $_GET['catID'] . "|%'";
	$q = my_mysql_query("select urun.*,kategori.name as catName,marka.name as markaName,kategori.namePath as namePathx,kategori.parentID as catParentID from urun,kategori,marka where urun.catID=kategori.ID AND marka.ID = urun.markaID AND catID!=0 AND markaID!=0 AND fiyat > 0 AND bakiyeOdeme=0  $filter $order $limit");
	while ($d = my_mysql_fetch_array($q)) {
		$xml = $xmlx->addChild('item', '');
		$xml->addChild('stockCode', ($d['ID']));
		$xml->addChild('label', cleanStr(($d['name'])));
		$xml->addChild('status', (int) $d['active']);
		$xml->addChild('brand', ($d['markaName']));
		$xml->addChild('brandId', ($d['markaID']));
		if ($d['catParentID'] == 0) $d['catParentID'] = $d['catID'];
		$parentCatName = hq("select name from kategori where ID='" . $d['catParentID'] . "'");
		$xml->addChild('mainCategory', (cleanStr($parentCatName)));
		$xml->addChild('category', (cleanStr($d['catName'])));
		$xml->addChild('buyingPrice', $d['fiyat']);
		$xml->addChild('tax', $d['kdv'] * 100);
		$xml->addChild('currency', $d['fiyatBirim']);
		$xml->addChild('stockAmount', $d['stok']);
		$xml->addChild('stockType', $d['urunBirim']);
		$xml->addChild('warranty', $d['garanti']);


		for ($j = 1; $j <= 5; $j++) {
			$resimStr = 'resim' . ($j == 1 ? '' : $j);
			if ($d[$resimStr])
				$xml->addChild('picture' . $j . 'Path', ('https://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d[$resimStr]));
		}

		$xml->addChild('dm3', $d['desi']);
		$xml->addChild('details', (cleanStr($d['detay'])));


		if ($d['varID1'] || $d['varID2']) {
			$urunvar = $xml->addChild('variants');
			$var1 = (cleanstr(hq("select ozellik from var where ID='" . $d['varID1'] . "'")));
			if ($var1) {
				$var2 = (cleanstr(hq("select ozellik from var where ID='" . $d['varID2'] . "'")));
				$vq = my_mysql_query("select ID,kod,stok,var1,var2 from urunvarstok where urunID='" . $d['ID'] . "'");
				while ($vd = my_mysql_fetch_array($vq)) {
					$vBarkod = ($vd['kod'] ? $vd['kod'] : $vd['ID']);
					$var = $urunvar->addChild('variant');
					$var->addChild('vStockCode', $vBarkod);
					$var->addChild('vBarcode', $vBarkod);
					$var->addChild('stockAmount', $vd['stok']);


					$attr = $var->addChild('Attributes');
					$price = YTLfiyat(hq("select fark from urunvars where urunID='" . $d['ID'] . "' AND varID='" . $d['varID1'] . "' AND var like '" . $vd['var1'] . "'") + hq("select fark from urunvars where urunID='" . $d['ID'] . "' AND varID='" . $d['varID2'] . "' AND var like '" . $vd['var2'] . "'"), $d['fiyatBirim']);

					$var->addChild('vBuyingPrice', $d['fiyat'] + $price);

					$vAttrx = $attr->addChild('options');
					$vAttr = $vAttrx->addChild('option', $var1);
					$vAttr->addChild('variantName', $var1);
					$vAttr->addChild('variantValue', cleanstr($vd['var1']));

					if ($vd['var2']) {
						$vAttrx = $attr->addChild('options');
						$vAttr = $vAttrx->addChild('option', $var2);
						$vAttr->addChild('variantName', $var2);
						$vAttr->addChild('variantValue', cleanstr($vd['var2']));
					}
				}
			}
		}
	}
	$xmlx->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}


function buildAdtriplexXMLFile()
{
	global $siteDizini;
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><products></products>';
	$xmlx = new SimpleXMLElementExtended($defaultXML);
	$filter = '';
	$order = 'order by catID';
	$start = ($_GET['start'] ? $_GET['start'] : 0);
	if ($_GET['limit']) $limit = 'limit ' . $start . ',' . (int) $_GET['limit'];
	if ($_GET['order']) $order = 'order by ' . $_GET['order'];
	if ($_GET['catID']) $filter .= "AND showCatIDs like '%|" . $_GET['catID'] . "|%'";
	$q = my_mysql_query("select urun.*,kategori.name as catName,marka.name as markaName,kategori.namePath as namePathx,kategori.parentID as catParentID from urun,kategori,marka where private_tarih >= now() AND private_start <= now() AND urun.catID=kategori.ID AND marka.ID = urun.markaID AND catID!=0 AND markaID!=0 AND fiyat > 0 AND bakiyeOdeme=0  $filter $order $limit");
	while ($d = my_mysql_fetch_array($q)) {
		$xml = $xmlx->addChild('product', '');
		if ($d['catParentID'] == 0) $d['catParentID'] = $d['catID'];
		$parentCatName = hq("select name from kategori where ID='" . $d['catParentID'] . "'");
		$xml->addChild('categoryname', (cleanStr($parentCatName)));
		$xml->addChild('category_url', (cleanStr('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . kategorilink($d['catParentID']))));
		$xml->addChild('category_id', (cleanStr($d['catParentID'])));
		$xml->addChild('subcategoryname', (cleanStr($d['catName'])));
		$xml->addChild('subcategoryid', (cleanStr($d['catID'])));
		$xml->addChild('prod_number', $d['ID']);
		$xml->addChild('prod_name', cleanStr(($d['name'])));
		$xml->addChild('prod_price_old', $d['piyasafiyat']);
		$xml->addChild('prod_price', $d['fiyat']);
		$xml->addChild('prod_description', (cleanStr($d['onDetay'])));
		$xml->addChild('prod_url', (cleanStr('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . urunlink($d))));
		$xml->addChild('brand', ($d['markaName']));
		$xml->addChild('model', '');
		$xml->addChild('img_large', ('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim']));
		$xml->addChild('stok', $d['stok']);
		$variants = $xml->addChild('variants', '');
		for ($i = 1; $i <= 3; $i++) {
			if ($d['ozellik' . $i]) {
				$vArray = explode("\n", $d['ozellik' . $i . 'detay']);
				foreach ($vArray as $v) {
					$variant = $variants->addChild('variant', '');
					list($name, $fark, $stok) = explode('|', $v);
					if ($stok == '' && $stok != 0) $stok = $d['stok'];
					$variant->addChild('name', (cleanstr($d['ozellik' . $i])));
					$variant->addChild('value', (cleanstr($name)));
					$variant->addChild('stock', $stok);
				}
			}
		}
	}
	$xmlx->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}
function buildGoogleImageXMLFile()
{
	global $siteDizini;
	$file = xmlCacheFilename();
	$xml = '<?xml version="1.0" encoding="UTF-8"?>
	<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
	$q = my_mysql_query("select ID,name,seo,resim,resim2,resim3,resim4,resim5 from urun where bakiyeOdeme=0 AND active=1 AND resim!='' order by seq desc,ID desc");
	while ($d = my_mysql_fetch_array($q)) {
		$xml .= '<url>' . "\n";
		$urunDetayLink = urunLink($d);
		$xml .= insertXMLData('loc', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $urunDetayLink);
		$xml .= '<image:image>' . insertXMLData('image:loc', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim']) . insertXMLData('image:title', htmlentities($d['name'])) . '</image:image>';
		for ($i = 2; $i <= 5; $i++) {
			if ($d['resim' . $i])
				$xml .= '<image:image>' . insertXMLData('image:loc', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim' . $i]) . insertXMLData('image:title', htmlentities($d['name'])) . '</image:image>';
		}
		$xml .= '</url>' . "\n";
	}
	$xml .= '</urlset>';
	xmlDosyaYaz($file, $xml);
	return $xml;
}
function buildGoogleXMLFile()
{
	global $siteDizini;

	if (!$_GET['autolang'] && sizeof(getLangArr()) > 1) {
		$langArr = getLangArr();
		$out = '';
		foreach ($langArr as $k => $v) {
			$out .= '<sitemap>
					<loc>http' . (siteConfig('httpsAktif') ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'ln-' . $k . '/sitemap.xml</loc>
					<lastmod>' . date('Y-m-d') . '</lastmod>
				</sitemap>';
		}

		return '<?xml version="1.0" encoding="UTF-8"?>
		<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . $out . '</sitemapindex>';
	}

	$file = xmlCacheFilename();
	cleancache();
	$date = date('Y-m-d');
	$xml = '<?xml version="1.0" encoding="UTF-8"?>
	<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
	$xml .= '<url>' . "\n";
	$xml .= insertXMLData('loc', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini);
	$xml .= insertXMLData('lastmod', $date);
	$xml .= insertXMLData('changefreq', 'daily');
	$xml .= insertXMLData('priority', '1.0');
	$xml .= '</url>' . "\n";
	$xml .= '<url>' . "\n";
	$ssslink = slink('sss');
	$xml .= insertXMLData('loc', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $ssslink);
	$xml .= insertXMLData('lastmod', $date);
	$xml .= insertXMLData('changefreq', 'weekly');
	$xml .= insertXMLData('priority', '0.8');
	$xml .= '</url>' . "\n";
	$start = ($_GET['start'] ? $_GET['start'] : 0);
	if ($_GET['limit']) $limit = 'limit ' . $start . ',' . (int) $_GET['limit'];
	$q = my_mysql_query("select * from urun where bakiyeOdeme=0 AND active=1 AND catID != 0 order by anasayfa desc $limit", 1);
	while ($d = my_mysql_fetch_array($q)) {
		if ($d['noxml']) continue;
		$d = translateArr($d);
		$d['detay'] = cleanstr($d['detay']);
		$d['onDetay'] = cleanstr($d['onDetay']);
		//$d['name'] = cleanstr($d['name']);
		$xml .= '<url>' . "\n";
		$urunDetayLink = urunLink($d);
		$xml .= insertXMLData('loc', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $urunDetayLink);
		$xml .= insertXMLData('lastmod', $date);
		$xml .= insertXMLData('changefreq', 'weekly');
		$xml .= insertXMLData('priority', ($d['anasayfa'] ? '0.9' : '0.8'));
		$xml .= '</url>' . "\n";
	}

	if (!$_GET['start']) {
		$q = my_mysql_query("select * from kategori where active = 1");
		while ($d = my_mysql_fetch_array($q)) {
			$xml .= '<url>' . "\n";
			$kategoriLink = kategoriLink($d);
			$xml .= insertXMLData('loc', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $kategoriLink);
			$xml .= insertXMLData('lastmod', $date);
			$xml .= insertXMLData('changefreq', 'weekly');
			$xml .= insertXMLData('priority', '0.8');
			$xml .= '</url>' . "\n";
		}
		$q = my_mysql_query("select * from marka");
		while ($d = my_mysql_fetch_array($q)) {
			$xml .= '<url>' . "\n";
			$kategoriLink = markaLink($d);
			$xml .= insertXMLData('loc', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $kategoriLink);
			$xml .= insertXMLData('lastmod', $date);
			$xml .= insertXMLData('changefreq', 'weekly');
			$xml .= insertXMLData('priority', '0.8');
			$xml .= '</url>' . "\n";
		}
		$q = my_mysql_query("select * from seolinks where active = 1 order by seq desc,ID desc");
		while ($d = my_mysql_fetch_array($q)) {
			if ($d['redirect']) continue;
			$xml .= '<url>' . "\n";
			$href = 'page.php?act=showKeyResult&seID=' . $d['ID'] . '&name=' . seofix2($d['key']);
			if (siteConfig('seoURL') && $d['seo'])
				$href = $d['seo'];
			$xml .= insertXMLData('loc', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . $href);
			$xml .= insertXMLData('lastmod', $date);
			$xml .= insertXMLData('changefreq', 'monthly');
			$xml .= insertXMLData('priority', '0.7');
			$xml .= '</url>' . "\n";
		}
		$q = my_mysql_query("select * from haberler");
		while ($d = my_mysql_fetch_array($q)) {
			list($tarih) = explode(' ', $d['Tarih']);
			$xml .= '<url>' . "\n";
			$href = haberLink($d);
			$xml .= insertXMLData('loc', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $href);
			$xml .= insertXMLData('lastmod', $date);
			$xml .= insertXMLData('changefreq', 'monthly');
			$xml .= insertXMLData('priority', '0.7');
			$xml .= '</url>' . "\n";
		}
		$q = my_mysql_query("select * from makaleler");
		while ($d = my_mysql_fetch_array($q)) {
			$xml .= '<url>' . "\n";
			$href = makaleLink($d);
			$xml .= insertXMLData('loc', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $href);
			$xml .= insertXMLData('lastmod', $date);
			$xml .= insertXMLData('changefreq', 'monthly');
			$xml .= insertXMLData('priority', '0.7');
			$xml .= '</url>' . "\n";
		}
	}
	$xml .= '</urlset>';
	$xml = str_replace($_SERVER[HTTP_HOST] . '//', $_SERVER[HTTP_HOST] . '/', $xml);
	xmlDosyaYaz($file, $xml);
	file_get_contents('https://www.google.com/webmasters/tools/ping?sitemap=http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'sitemap.xml');
	return $xml;
}
function buildYandexmarketXMLFile()
{
	global $siteConfig, $siteDizini;
	$xmlHeader = '<?xml version="1.0" encoding="UTF-8"?>
	<!DOCTYPE yml_catalog SYSTEM "shops.dtd"><yml_catalog></yml_catalog>';
	$xml = new SimpleXMLElementExtended($xmlHeader);
	$shop = $xml->addChild('shop');
	$shop->addChild('name', $_SERVER['HTTP_HOST']); // use your shop name
	$shop->addChild('company', (siteConfig('seo_title'))); // use your company name
	$shop->addChild('url', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER['HTTP_HOST'] . $siteDizini);
	$currencies = $shop->addChild('currencies');
	$currency = $currencies->addChild('currency');
	$currency->addAttribute('id', 'TRY');
	$currency->addAttribute('rate', '1');
	$currency->addAttribute('plus', '0');
	$categories = $shop->addChild('categories');
	$q = my_mysql_query("select * from kategori where active = 1");
	while ($d = my_mysql_fetch_array($q)) {
		$category = $categories->addChild('category', ($d['name']));
		$category->addAttribute('id', $d['ID']);
		$category->addAttribute('parentId', $d['parentID']);
	}
	$offers = $shop->addChild('offers');
	$q = my_mysql_query("select urun.*,marka.name as markaname from urun,marka where urun.active =1 AND bakiyeOdeme=0 AND urun.markaID=marka.ID order by ID desc");
	while ($d = my_mysql_fetch_array($q)) {
		$d['fiyat'] = fixFiyat($d['fiyat'], 0, $d['ID']);
		$price = str_replace(',', '', my_money_format('', YTLfiyat(kdvHaricFiyat($d), $d['fiyatBirim'])));
		$priceKDV = str_replace(',', '', my_money_format('', YTLfiyat(($d['fiyat']), $d['fiyatBirim'])));
		$offer = $offers->addChild('offer');
		$offer->addAttribute('id', $d['ID']);
		$offer->addAttribute('available', ($d['active'] ? 'true' : 'false'));
		$offer->addChild('url', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . (urunLink($d)));
		$offer->addChild('price', $price);
		$offer->addChild('price_KDV', str_replace(',', '', my_money_format('', ($priceKDV - $price))));
		$offer->addChild('price_sale_KDV', $priceKDV);
		$offer->addChild('currencyId', 'TRY');
		$offer->addChild('categoryId', $d['catID']);
		$offer->addChild('picture', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d['resim']);
		$offer->addChild('store', 'false');
		$offer->addChild('pickup', 'false');
		$offer->addChild('delivery', 'true');
		$offer->addChild('name', (htmlspecialchars($d['name'])));
		$offer->addChild('vendor', (htmlspecialchars($d['markaname'])));
		$offer->addChild('description', htmlspecialchars(($d['onDetay'])));
		$offer->addChild('manufacturer_warranty', 'true');
		$offer->addChild('country_of_origin', 'TRY');
	}
	$xml->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}
function generateEAN($number)
{
	$code = '200' . str_pad($number, 9, '0');
	$weightflag = true;
	$sum = 0;
	for ($i = strlen($code) - 1; $i >= 0; $i--) {
		$sum += (int) $code[$i] * ($weightflag ? 3 : 1);
		$weightflag = !$weightflag;
	}
	$code .= (10 - ($sum % 10)) % 10;
	return $code;
}

function ucwords_tr($gelen)
{

	$sonuc = '';
	$kelimeler = explode(" ", $gelen);

	foreach ($kelimeler as $kelime_duz) {

		$kelime_uzunluk = strlen($kelime_duz);
		$ilk_karakter = mb_substr($kelime_duz, 0, 1, 'UTF-8');

		if ($ilk_karakter == 'Ç' or $ilk_karakter == 'ç') {
			$ilk_karakter = 'Ç';
		} elseif ($ilk_karakter == 'Ğ' or $ilk_karakter == 'ğ') {
			$ilk_karakter = 'Ğ';
		} elseif ($ilk_karakter == 'I' or $ilk_karakter == 'ı') {
			$ilk_karakter = 'I';
		} elseif ($ilk_karakter == 'İ' or $ilk_karakter == 'i') {
			$ilk_karakter = 'İ';
		} elseif ($ilk_karakter == 'Ö' or $ilk_karakter == 'ö') {
			$ilk_karakter = 'Ö';
		} elseif ($ilk_karakter == 'Ş' or $ilk_karakter == 'ş') {
			$ilk_karakter = 'Ş';
		} elseif ($ilk_karakter == 'Ü' or $ilk_karakter == 'ü') {
			$ilk_karakter = 'Ü';
		} else {
			$ilk_karakter = strtoupper($ilk_karakter);
		}

		$digerleri = mb_substr($kelime_duz, 1, $kelime_uzunluk, 'UTF-8');
		$sonuc .= $ilk_karakter . kucuk_yap($digerleri) . ' ';
	}

	$son = trim(str_replace('  ', ' ', $sonuc));
	return $son;
}

function kucuk_yap($gelen)
{

	$gelen = str_replace('Ç', 'ç', $gelen);
	$gelen = str_replace('Ğ', 'ğ', $gelen);
	$gelen = str_replace('I', 'ı', $gelen);
	$gelen = str_replace('İ', 'i', $gelen);
	$gelen = str_replace('Ö', 'ö', $gelen);
	$gelen = str_replace('Ş', 'ş', $gelen);
	$gelen = str_replace('Ü', 'ü', $gelen);
	$gelen = strtolower($gelen);

	return $gelen;
}
function buildGoogleMerchantXMLFile()
{

	global $siteDizini;

	autoAddFormField('kategori', 'gnoxml', 'CHECKBOX');
	autoAddFormField('kategori', 'yetiskin', 'CHECKBOX');
	autoAddFormField('urun', 'gnoxml', 'CHECKBOX');


	$nsUrl = 'http://base.google.com/ns/1.0';
	$doc = new DOMDocument('1.0', 'UTF-8');
	$doc->preserveWhiteSpace = false;
	$doc->formatOutput = true;
	$rootNode = $doc->appendChild($doc->createElement('rss'));
	$rootNode->setAttribute('version', '2.0');
	$rootNode->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:g', $nsUrl);
	$channelNode = $rootNode->appendChild($doc->createElement('channel'));
	$title = (siteConfig('seo_title'));
	$description = str_replace('&', '&amp;', siteConfig('seo_metaDescription'));

	$channelNode->appendChild($doc->createElement('title', $title));
	$channelNode->appendChild($doc->createElement('description', $description));
	$channelNode->appendChild($doc->createElement('link', 'https://' . $_SERVER['HTTP_HOST'] . $siteDizini));

	$filter = $limit = '';
	$start = (int)($_GET['start'] ? $_GET['start'] : 0);
	if ($_GET['limit']) $limit = 'limit ' . (int)$start . ',' . (int) $_GET['limit'];
	if ($_GET['markaID']) $filter .= 'AND urun.markaID= ' . (int) $_GET['markaID'];
	if ($_GET['tID']) $filter .= 'AND urun.tedarikciID= ' . (int) $_GET['tID'];
	if ($_GET['catID']) $filter .= "AND (showCatIDs like '%|" . $_GET['catID'] . "|%' OR catID='" . $_GET['catID'] . "' OR kategori.idPath like '%/" . $_GET['catID'] . "/%' OR kategori.idPath like '" . $_GET['catID'] . "/%')";
	if ($_GET['tIDs']) {
		$filter = 'AND (';
		$tIDs = explode(',', $_GET['tIDs']);
		foreach ($tIDs as $tID) {
			$tID = (int) $tID;
			if ($tID)
				$filter .= 'urun.tedarikciID = \'' . $tID . '\' OR ';
		}
		$filter .= ' 1 = 2) ';
	}

	$q = my_mysql_query("select urun.*,marka.name as markaname,kategori.namePath as namePath,kategori.name as kategoriName,kategori.yetiskin as yetiskin,kategori.googleMerchant as googleMerchant,kategori.metaKeywords as googleMetaKeywords from urun,marka,kategori where urun.gnoxml != 1 AND kategori.gnoxml != 1 AND urun.stok > 0 AND urun.noxml != 1 AND urun.catID=kategori.ID AND bakiyeOdeme=0 AND kategori.active = 1 AND urun.active=1 AND urun.markaID=marka.ID $filter order by ID desc $limit", 1);
	while ($product = my_mysql_fetch_array($q)) {
		$product = translateArr($product);
		$product['detay'] = cleanstr($product['detay']);
		//$product['detay'] = strip_tags($product['detay']);

		$product['onDetay'] = cleanstr($product['onDetay']);
		// $product['name'] = ucwords_tr(cleanstr($product['name']));
		$product['name'] = (cleanstr($product['name']));
		$product['fiyat'] = fixFiyat($product['fiyat'], 0, $product);
		if($product['piyasafiyat'] < $product['fiyat'])
		{
			$product['piyasafiyat'] = ($product['fiyat'] * 1.2);
		}
		$itemNode = $channelNode->appendChild($doc->createElement('item'));
		$itemNode->appendChild($doc->createElement('title'))->appendChild($doc->createTextNode(($product['name'])));
		if (!$product['onDetay'])
			$product['onDetay'] = $product['detay'];
		if (!$product['onDetay'])
			$product['onDetay'] = $product['name'];
		$itemNode->appendChild($doc->createElement('description'))->appendChild($doc->createTextNode(preg_replace('/[\x00-\x1f]/', '', $product['onDetay'])));
		$url = urunLink($product);
		$itemNode->appendChild($doc->createElement('link'))->appendChild($doc->createTextNode('http' . (siteConfig('httpsAktif')  ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $url));
		$itemNode->appendChild($doc->createElement('g:id'))->appendChild($doc->createTextNode($product['ID']));

		$ci = 0;
		$labelArray = explode(',', $product['metaKeywords']);
		foreach ($labelArray as $label) {
			$itemNode->appendChild($doc->createElement('g:custom_label_' . $ci))->appendChild($doc->createTextNode($label));
			$ci++;
		}
		if (!$product['gtin'] || $product['gtin'] == '0' || !(int)$product['gtin'])
			unset($product['gtin']);
		$itemNode->appendChild($doc->createElement('g:gtin'))->appendChild($doc->createTextNode($product['gtin']));
		$itemNode->appendChild($doc->createElement('g:mpn'))->appendChild($doc->createTextNode($product['tedarikciCode']));
		$mkArray = explode(',', ($product['metaKeywords']));
		foreach ($mkArray as $mk) {
			$itemNode->appendChild($doc->createElement('g:adwords_labels'))->appendChild($doc->createTextNode($mk));
		}
		$namePath = $product['kategoriName'];
		$googleMerchant = $product['googleMerchant'];
		$itemNode->appendChild($doc->createElement('g:product_type'))->appendChild($doc->createTextNode(str_replace('/', ' > ', $namePath)));
		$itemNode->appendChild($doc->createElement('g:google_product_category'))->appendChild($doc->createTextNode($googleMerchant));


		if ($_SESSION['cache_setfiyatBirim']) {
			$price = fiyatCevir($product['fiyat'], $product['fiyatBirim'], $_SESSION['cache_setfiyatBirim']);
			$price = str_replace(',', '', my_money_format('%i', $price));

			$pricePiyasa = fiyatCevir($product['piyasafiyat'], $product['fiyatBirim'], $_SESSION['cache_setfiyatBirim']);
			$pricePiyasa = str_replace(',', '', my_money_format('%i', $pricePiyasa));

			$itemNode->appendChild($doc->createElement('g:price'))->appendChild($doc->createTextNode(str_replace('.', '.', str_replace(',', '', my_money_format('%i', ($pricePiyasa ? $pricePiyasa : $price)))) . ' ' . $_SESSION['cache_setfiyatBirim']));
			$itemNode->appendChild($doc->createElement('g:sale_price'))->appendChild($doc->createTextNode(str_replace('.', '.', str_replace(',', '', my_money_format('%i', $price))) . ' ' . $_SESSION['cache_setfiyatBirim']));
		} else {
			$itemNode->appendChild($doc->createElement('g:price'))->appendChild($doc->createTextNode(str_replace('.', '.', str_replace(',', '', my_money_format('%i', YTLfiyat(($product['piyasafiyat'] ? $product['piyasafiyat'] : $product['fiyat']), $product['fiyatBirim'])))) . ' TRY'));
			$itemNode->appendChild($doc->createElement('g:sale_price'))->appendChild($doc->createTextNode(str_replace('.', '.', str_replace(',', '', my_money_format('%i', YTLfiyat($product['fiyat'], $product['fiyatBirim'])))) . ' TRY'));
		}

		$itemNode->appendChild($doc->createElement('g:brand'))->appendChild($doc->createTextNode(($product['markaname'])));
		$itemNode->appendChild($doc->createElement('g:condition'))->appendChild($doc->createTextNode('new'));
		$itemNode->appendChild($doc->createElement('g:availability'))->appendChild($doc->createTextNode('in stock'));

		$shipping = $itemNode->appendChild($doc->createElement('g:shipping'));
		$shipping->appendChild($doc->createElement('g:country'))->appendChild($doc->createTextNode('TR'));

		if ($product['fixKargoFiyat']) {
			if ($_SESSION['cache_setfiyatBirim']) {
				$sp = str_replace(',', '', my_money_format('', $product['fixKargoFiyat']));
				$sp = fiyatCevir($sp, $product['fiyatBirim'], $_SESSION['cache_setfiyatBirim']);
				$sp = str_replace(',', '', my_money_format('%i', $sp));
				$shipping->appendChild($doc->createElement('g:price'))->appendChild($doc->createTextNode($sp . ' ' . $_SESSION['cache_setfiyatBirim']));
			} else
				$shipping->appendChild($doc->createElement('g:price'))->appendChild($doc->createTextNode('0 TRY'));
		} else if ($product['ucretsizKargo']) {
			$shipping->appendChild($doc->createElement('g:price'))->appendChild($doc->createTextNode('0.00 ' . ($_SESSION['cache_setfiyatBirim'] ? $_SESSION['cache_setfiyatBirim'] : 'TRY')));
		} else if (siteConfig('kargo') && YTLfiyat($product['fiyat'], $product['fiyatBirim']) < siteConfig('minKargo')) {
			$sp = str_replace(',', '', my_money_format('', siteConfig('kargo')));
			if ($_SESSION['cache_setfiyatBirim']) {
				$sp = fiyatCevir($sp, $product['fiyatBirim'], $_SESSION['cache_setfiyatBirim']);
				$sp = str_replace(',', '', my_money_format('%i', $sp));
				$shipping->appendChild($doc->createElement('g:price'))->appendChild($doc->createTextNode($sp . ' ' . $_SESSION['cache_setfiyatBirim']));
			} else {
				$shipping->appendChild($doc->createElement('g:price'))->appendChild($doc->createTextNode($sp . ' TRY'));
			}
		} else
			$shipping->appendChild($doc->createElement('g:price'))->appendChild($doc->createTextNode('0.00 ' . ($_SESSION['cache_setfiyatBirim'] ? $_SESSION['cache_setfiyatBirim'] : 'TRY')));
		$itemNode->appendChild($doc->createElement('g:ships_from_country'))->appendChild($doc->createTextNode('TR'));
		if ($product['yetiskin'])
			$itemNode->appendChild($doc->createElement('g:adult'))->appendChild($doc->createTextNode('evet'));
		$url = preg_replace('/[\x00-\x1f]/', '', htmlspecialchars(($product['resim'])));
		if (!$url)
			$url = 'images/nopic.png';
		else
			$url = 'images/urunler/'.$url;
		$itemNode->appendChild($doc->createElement('g:image_link'))->appendChild($doc->createTextNode('http' . (siteConfig('httpsAktif')  ? 's' : '') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . $url));
	}
	$doc->save(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}

function buildFacebookproductXMLFile()
{
	global $siteDizini;
	$nsUrl = 'http://base.google.com/ns/1.0';
	$doc = new DOMDocument('1.0', 'UTF-8');
	$rootNode = $doc->appendChild($doc->createElement('rss'));
	$rootNode->setAttribute('version', '2.0');
	$rootNode->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:g', $nsUrl);
	$channelNode = $rootNode->appendChild($doc->createElement('channel'));
	$title = str_replace(array('&uuml;'), array('ü'), siteConfig('seo_title'));
	$title = str_replace(array('&Uuml;'), array('Ü'), $title);
	$title = str_replace(array('&ouml;'), array('ö'), $title);
	$title = str_replace(array('&Ouml;'), array('Ö'), $title);
	$title = str_replace('&', '&amp;', $title);


	$channelNode->appendChild($doc->createElement('title', ($title)));
	$desc = siteConfig('seo_metaDescription');
	$desc = cleanStr($desc);
	$desc = htmlentities($desc);
	$desc = str_replace(array('&uuml;'), array('ü'), $desc);
	$desc = str_replace(array('&Uuml;'), array('Ü'), $desc);
	$desc = str_replace(array('&ouml;'), array('ö'), $desc);
	$desc = str_replace(array('&Ouml;'), array('Ö'), $desc);
	$desc = str_replace('&', '&amp;', $desc);

	$channelNode->appendChild($doc->createElement('description', $desc));
	$channelNode->appendChild($doc->createElement('link', 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER['HTTP_HOST'] . $siteDizini));
	$q = my_mysql_query("select urun.*,kategori.namePath,marka.name as markaname,kategori.googleMerchant as googleMerchant from urun,marka,kategori where urun.catID=kategori.ID AND bakiyeOdeme=0 AND kategori.active = 1 AND urun.active=1 AND urun.stok > 0 AND urun.markaID=marka.ID order by ID desc");
	while ($product = my_mysql_fetch_array($q)) {
		$product = translateArr($product);
		foreach ($product as $k => $v) {
			$product[$k] = iconv("utf-8", "utf-8//ignore", $v);
		}
		$googleMerchant = $product['googleMerchant'];
		$product['fiyat'] = fixFiyat($product['fiyat'], 0, $product);
		$itemNode = $channelNode->appendChild($doc->createElement('item'));
		$itemNode->appendChild($doc->createElement('g:id'))->appendChild($doc->createTextNode($product['ID']));
		$itemNode->appendChild($doc->createElement('g:link'))->appendChild($doc->createTextNode('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER['HTTP_HOST'] . urunLink($product)));
		$itemNode->appendChild($doc->createElement('g:title'))->appendChild($doc->createTextNode(($product['name'])));
		$itemNode->appendChild($doc->createElement('g:description'))->appendChild($doc->createTextNode(strip_tags($product['onDetay'] ? $product['onDetay'] : $product['name'])."\n"));
		$itemNode->appendChild($doc->createElement('g:rich_text_description'))->appendChild($doc->createTextNode($product['detay']));
		$itemNode->appendChild($doc->createElement('g:image_link'))->appendChild($doc->createTextNode('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $product['resim']));
		for ($j = 1; $j <= 5; $j++) {
			$resimStr = 'resim' . ($j == 1 ? '' : $j);
			if ($product[$resimStr]) 
				$itemNode->appendChild($doc->createElement('g:additional_image_link'))->appendChild($doc->createTextNode('http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $product[$resimStr]));
		}
		$itemNode->appendChild($doc->createElement('g:brand'))->appendChild($doc->createTextNode(($product['markaname'])));
		$itemNode->appendChild($doc->createElement('g:condition'))->appendChild($doc->createTextNode('new'));
		$itemNode->appendChild($doc->createElement('g:availability'))->appendChild($doc->createTextNode('in stock'));

		if ($_SESSION['cache_setfiyatBirim']) {
			$price = fiyatCevir($product['fiyat'], $product['fiyatBirim'], $_SESSION['cache_setfiyatBirim']);
			$price = str_replace(',', '', my_money_format('%i', $price));

			$pricePiyasa = fiyatCevir($product['piyasafiyat'], $product['fiyatBirim'], $_SESSION['cache_setfiyatBirim']);
			$pricePiyasa = str_replace(',', '', my_money_format('%i', $pricePiyasa));

			$itemNode->appendChild($doc->createElement('g:price'))->appendChild($doc->createTextNode(str_replace('.', ',', str_replace(',', '', my_money_format('%i', ($pricePiyasa ? $pricePiyasa : $price)))) . ' ' . $_SESSION['cache_setfiyatBirim']));
			$itemNode->appendChild($doc->createElement('g:sale_price'))->appendChild($doc->createTextNode(str_replace('.', ',', str_replace(',', '', my_money_format('%i', $price))) . ' ' . $_SESSION['cache_setfiyatBirim']));
		} else {
			$itemNode->appendChild($doc->createElement('g:price'))->appendChild($doc->createTextNode(str_replace('.', ',', str_replace(',', '', my_money_format('%i', YTLfiyat(($product['piyasafiyat'] ? $product['piyasafiyat'] : $product['fiyat']), $product['fiyatBirim'])))) . ' TRY'));
			$itemNode->appendChild($doc->createElement('g:sale_price'))->appendChild($doc->createTextNode(str_replace('.', ',', str_replace(',', '', my_money_format('%i', YTLfiyat($product['fiyat'], $product['fiyatBirim'])))) . ' TRY'));
		}
		
		$shipping = $itemNode->appendChild($doc->createElement('g:shipping'));
		$shipping->appendChild($doc->createElement('g:country'))->appendChild($doc->createTextNode('TR'));
		$shipping->appendChild($doc->createElement('g:service'))->appendChild($doc->createTextNode('Standart'));
		$price = str_replace(',', '', my_money_format('%i', $product['fixKargoFiyat'] ? $product['fixKargoFiyat'] : siteConfig('kargo')));

		if (YTLfiyat($product['fiyat'], $product['fiyatBirim']) >= siteConfig('minKargo'))
			$price = 0;
		if ($_SESSION['cache_setfiyatBirim']) {
			$price = fiyatCevir($price, 'TL', $_SESSION['cache_setfiyatBirim']);
			$price = str_replace(',', '', my_money_format('%i', $price));
			$itemNode->appendChild($doc->createElement('g:price'))->appendChild($doc->createTextNode($price . ' ' . $_SESSION['cache_setfiyatBirim']));
		} else {
			$shipping->appendChild($doc->createElement('g:price'))->appendChild($doc->createTextNode($price . ' TRY'));
		}
		$itemNode->appendChild($doc->createElement('g:google_product_category'))->appendChild($doc->createTextNode($googleMerchant));
	}
	$doc->save(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}
function buildggXMLFile()
{
	global $listelemeTipi, $siteDizini, $kargoYeri, $kargoTipi, $kargoAciklama;
	$q = my_mysql_query("select * from gittiGidiyorCat");
	if (!my_mysql_num_rows($q)) return;
	$xml = '<?xml version="1.0" encoding="utf-8"?>' . "\n\t" . '<Urunler>' . "\n";
	$i = 1;
	while ($d = my_mysql_fetch_array($q)) {
		$d['detay'] = cleanstr($d['detay']);
		$d['onDetay'] = cleanstr($d['onDetay']);
		$d['name'] = cleanstr($d['name']);
		$idPath = hq('select idPath from kategori where ID=' . $d['catID']);
		$q2 = my_mysql_query("select urun.*,kategori.name as catName from urun,kategori where bakiyeOdeme=0 AND urun.catID=kategori.ID AND kategori.idPath like '$idPath/%' AND urun.stok > 0 AND urun.active=1");
		while ($d2 = my_mysql_fetch_array($q2)) {
			$xml .= "\t\t" . '<Urun' . $i . '>' . "\n";
			$xml .= insertXMLData('ListelemeTipi', $listelemeTipi);
			$xml .= insertXMLData('Title', $d2['name']);
			$xml .= insertXMLData('SubTitle', $d2['listeDetay']);
			$xml .= insertXMLData('Kategori', $d['ggCatName']);
			for ($j = 1; $j <= 5; $j++) {
				$resimStr = 'resim' . ($j == 1 ? '' : $j);
				if ($d2[$resimStr]) $xml .= insertXMLData('FotografID' . $j, 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d2[$resimStr]);
			}
			$xml .= insertXMLData('Price', str_replace(',', '', my_money_format('%i', YTLfiyat($d2['fiyat'], $d2['fiyatBirim']))));
			$xml .= insertXMLData('KargoTipi', $kargoTipi);
			$xml .= insertXMLData('KargoYeri', $kargoYeri);
			$xml .= insertXMLData('KargoAciklama', $kargoAciklama);
			$xml .= insertXMLData('ListelemeSuresi', $d['ggSure']);
			$xml .= insertXMLData('UrunAciklaması', '<![CDATA[ ' . $d2['onDetay'] . '<br><br>' . str_replace('src="/', 'src="' . 'http' . (siteConfig('httpsAktif')  ? 's' : 's') . '://' . $_SERVER[HTTP_HOST] . $siteDizini, $d2['detay']) . ']]>');
			$xml .= insertXMLData('Katalog', ($d['ggKatalog'] ? 'Y' : 'N'));
			$xml .= insertXMLData('KalinYazi', ($d['ggKalinYazi'] ? 'Y' : 'N'));
			$xml .= insertXMLData('PesinTaksit', $d['ggPesinTaksit']);
			$xml .= insertXMLData('StoreCat', $d['ggStoreCatName']);
			$xml .= insertXMLData('Adet', $d2['stok']);
			$xml .= "\t\t" . '</Urun' . $i . '>' . "\n";
			$i++;
		}
	}
	$xml .= '</Urunler>';
	return $xml;
}
function insertHBUrun($d, $varyant, $deger, $IDend)
{
	global $siteDizini, $channel, $xml;
	include_once('mod_HepsiBurada.php');
	if (function_exists('getHBPrice'))
		$d['fiyat'] = getHBPrice($d);
	$d['detay'] = cleanstr($d['detay']);
	$d['onDetay'] = cleanstr($d['onDetay']);
	$d['name'] = cleanstr($d['name']);
	$channel = $xml->addChild('Urun', '');
	$channel->addChild('KategoriAdi', (hq("select name from kategori where ID='" . $d['catID'] . "'")));
	$channel->addChild('UrunID', ($d['ID']) . $IDend);
	$channel->addChild('UrunAdi', (($d['name'])));
	$channel->addChild('KDV', ($d['kdv'] * 100));
	$channel->addChild('Garanti', '12');		//$channel->addChild('Garanti', $d['garanti']);
	$aciklama = (($d['onDetay'] . ' ' . $d['detay']));
	$channel->addChild('UrunAciklamasi', trim($aciklama));
	for ($j = 1; $j <= 5; $j++) {
		$resimStr = 'resim' . ($j == 1 ? '' : $j);
		if ($d[$resimStr])
			$channel->addChild('ImageName' . $j, ('https://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d[$resimStr]));
	}

	$indirimHesaplaKategori = hq("select ckar from kategori where ID='" . $d['catID'] . "'");
	$urunkategoriindirimhesapla = ($d['fiyat'] * $indirimHesaplaKategori); // 18 etti
	$urunkdvtutarhesapla = ($urunkategoriindirimhesapla * 0.18);
	$catDiscounter = hq("select ckar from kategori where ID='" . $d['catID'] . "'");
	$kdv_haric_fiyat = ($d['fiyat'] / 118 * 100);
	$kdv_haric_fiyat_kategori_indirimli_hesapla = ($kdv_haric_fiyat * $catDiscounter);
	$kdv_haric_fiyat_kategori_indirimli_fiyat = ($kdv_haric_fiyat - $kdv_haric_fiyat_kategori_indirimli_hesapla);

	$fiyat22 = ($d['piyasafiyat'] / ($d['KDV'] + 1));
	$channel->addChild('hb_alis_kdv_haric', str_replace(',', '', my_money_format('%i', ($kdv_haric_fiyat_kategori_indirimli_fiyat))));
	$channel->addChild('piyasa_fiyati_kdv_haric', str_replace(',', '', my_money_format('%i', ($fiyat22 - $urunkdvtutarhesapla))));
	$channel->addChild('son_kullanici_satis_kdv_haric', str_replace(',', '', my_money_format('%i', ($kdv_haric_fiyat))));
	$channel->addChild('Kur', ($d['fiyatBirim']));
	$channel->addChild('Desi', ($d['desi']));
	$channel->addChild('TedarikSuresi', '3');
	$channel->addChild('Marka', (cleanstr(hq("select name from marka where ID='" . $d['markaID'] . "'"))));
	$channel->addChild('Barcode', $d['gtin']);
	$channel->addChild('Barkod', $d['barkodNo']);		//$channel->addChild('Barkot', $d['amazon_asin']);
	$channel->addChild('StokAdedi', $d['stok']);
	$channel->addChild('HepsiburadaSKU', '' . ($d['ID']));
	$channel->addChild('HepsiburadaProductID', '' . ($d['ID']));
	$channel->addChild('HepsiburadaCatalog', (hq("select name from kategori where ID='" . $d['catID'] . "'")));
	if ($varyant) {
		$channel->addChild('VaryantGroupID', ($d['ID']));
		$varyant = tr2eu(cleanstr($varyant));
		$varyant = str_replace(' ', '_', $varyant);
		$deger = cleanstr($deger);
		$varyant = preg_replace('/[^A-Za-z0-9\-]/', '', $varyant);
		$channel->addChild(($varyant), ($deger));
	}
}
function buildHBXMLFile()
{
	global $xml;
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><Urunler></Urunler>';
	$xml = new SimpleXMLElementExtended($defaultXML);
	$q = my_mysql_query("select * from urun where catID!=0 AND markaID!=0 AND stok > 0 AND fiyat > 1 AND active=1 order by catID");
	while ($d = my_mysql_fetch_array($q)) {
		if ($d['ozellik1']) {
			$xArray = explode("\n", $d['ozellik1detay']);
			$ji = 1;
			foreach ($xArray as $v) {
				insertHBUrun($d, $d['ozellik1'], $v, '_' . $ji);
				$ji++;
			}
		} else insertHBUrun($d, '', '', '');
	}
	$out = $xml->asXML();
	$out = str_replace('<UrunAciklamasi>', '<UrunAciklamasi><![CDATA[', $out);
	$out = str_replace('</UrunAciklamasi>', ']]></UrunAciklamasi>', $out);
	$out = str_replace('&#13;', "", $out);
	return $out;
}
function kdvHaric($urunID)
{
	$KDVDahilFiyat = dbInfoXML('urun', 'fiyat', $urunID);
	$KDV = dbInfoXML('urun', 'kdv', $urunID);
	return ($KDVDahilFiyat / (1 + $KDV));
}
function dbInfoXML($table, $info, $ID)
{
	$q = my_mysql_query("select $info from $table where ID='$ID' limit 0,1");
	$d = my_mysql_fetch_array($q);
	return $d[0];
}

function buildArabulvarXMLFile()
{
	$defaultXML = '<?xml version="1.0" encoding="utf-8"?><Products></Products>';
	$sxe = new SimpleXMLElementExtended($defaultXML);
	$q = my_mysql_query("SELECT urun.*, kategori.ID AS catID, kategori.namePath AS catNamePath, marka.name AS markaName
						FROM urun, kategori, marka
						WHERE kategori.ID = urun.catID
						AND urun.active = 1
						AND urun.fiyat > 0
						AND urun.stok > 0
						AND urun.catID != 0
						AND urun.markaID = marka.ID
						");
	while ($d = my_mysql_fetch_assoc($q)) {
		$Product = $sxe->addChild('Product', '');
		$Product->addChild('Category', $d['catID']);
		$Product->addChild('artNr', $d['ID']);
		$Product->addChild('eanNr', $d['catID']);
		$Product->addChild('markaID', $d['markaID']);
		$Product->addChild('markaName', $d['markaName']);
		$Product->addChild('ShortDesc', $d['catID']);
		$Product->addChild('LongDesc', htmlspecialchars($d['detay']));
		$Product->addChild('Price', $d['fiyat']);
		$Product->addChild('Psf', $d['KDV']);
		$Product->addChild('Vat', $d['KDV']);
		$Product->addChild('Amount', $d['stok']);
		$Product->addChild('VariantName', $d['catID']);
		$Product->addChild('ShippingCost', 'user');
		$Variants = $Product->addChild('Variants', '');
		$Attributes = $Variants->addChild('Attributes', '');
		$Attribute1 = $Attributes->addChild('Attribute', '');
		$Attribute1->addChild('Name', 'Marka');
		$Attribute1->addChild('Value', $d['markaName']);
		$Attribute2 = $Attributes->addChild('Attribute', '');
		$Attribute2->addChild('Name', 'Garanti Suresi');
		$Attribute2->addChild('Value', $d['garanti'] . ' Y&#305;l');
	}

	$sxe->saveXML(xmlCacheFilename());
	return (file_get_contents(xmlCacheFilename()));
}
