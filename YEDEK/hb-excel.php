<?php

include_once('include/all.php');

include_once('include/mod_HepsiBurada.php');

if (!$_SESSION['admin_isAdmin'])

	exit('no-access');

function generateEAN($hex_str)

{

	$arr = str_split($hex_str, 4);

	foreach ($arr as $grp) {

		$dec[] = str_pad(hexdec($grp), 5, '0', STR_PAD_LEFT);

	}

	$out = implode('', $dec);

	return substr($out, 0, 13);

}







/* EDIT */

$viewArray = array(

	'UniqueIdentifier' => 'ID',

	'MerchantSku' => 'tedarikciCode',

	'HepsiburadaSku' => 'gtin',

	'ProductName' => 'name',

	'VaryantGrupID' => 'xID',

	'ProductSubDetail' => 'onDetay',

	'ProductDetail' => 'detay',

	'Brand' => 'markaName',

	'CategoryPath' => 'catNamePath',

	'Desi' => 'desi',

	'Tax' => 'kdv',

	'Warranty' => 'garanti',

	'AvailableStock' => 'stok',

	'Varyasyon1' => 'renk',

	'Varyasyon2' => 'beden',

	'Price' => 'fiyat',

	'DispatchTime' => 'kargoGun',

	'CargoCompany1' => 'CargoCompany1',

	'MaximumPurchasableQuantity' => 'maxSatis',

	'CustomizationTextType' => 'CustomizationTextType',

	'CustomizationTextLength' => 'CustomizationTextLength',

	'Gorsel1' => 'resim',

	'Gorsel2' => 'resim2',

	'Gorsel3' => 'resim3',

	'Gorsel4' => 'resim4',

	'Gorsel5' => 'resim5',

	'ShippingAddressLabel' => 'ShippingAddressLabel',

	'ClaimAddressLabel' => 'ClaimAddressLabel'

);

/* EDIT */

$harfArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ');



// Hata Gösterimi - Yazılım Geliştirme

//error_reporting(E_ALL);



@ini_set('memory_limit', '1024M');

@set_time_limit(0);

require_once 'include/3rdparty/PHPExcel.php';



$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Utopia Yazılım")

	->setLastModifiedBy("Utopia ")

	->setTitle("Utopia Yazılım Excel Veri Çıktısı")

	->setSubject("Utopia Yazılım Excel Veri Çıktısı")

	->setDescription("Utopia Yazılım Excel Veri Çıktısı")

	->setKeywords("Utopia Yazılım, E-Ticaret Yazılımı")

	->setCategory("Utopia Yazılım Excel Veri Çıktısı");



$i = 0;

foreach ($viewArray as $k => $v) {

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($harfArray[$i] . '1', iconv('iso-8859-9', 'utf-8', $k));

	$i++;

}







my_mysql_query("SET NAMES 'utf8'");

my_mysql_query("set SESSION character_set_client = utf8");

my_mysql_query("set SESSION character_set_connection = utf8");

my_mysql_query("set SESSION character_set_results = utf8");

$i = 2;



$cArray = explode(',', $_GET['catIDs']);

$cs = array();

foreach ($cArray as $c) {

	$c = (int)$c;

	if (!$c)

		continue;

	$cs[] = "(showCatIDs like '%|" . $c . "|%' OR catID='" . $c . "' OR kategori.idPath like '" . $c . "/%')";

}

if (count($cs) > 1) {

	$filter .= " AND (" . implode(' OR ', $cs) . ")";

}



if ($_GET['catID'])

	$filter .= "AND (showCatIDs like '%|" . $_GET['catID'] . "|%' OR catID='" . $_GET['catID'] . "' OR kategori.idPath like '" . $catPatern . "/%')";



if ($_GET['catIDstart'])

	$filter .= "AND (catID >= " . (int)$_GET['catIDstart'] . " AND catID <= " . (int)$_GET['catIDfinish'] . ")";



$CargoCompany1 = hq("select name from kargofirma order by ID limit 0,1");

$ShippingAddressLabel = $ClaimAddressLabel = siteConfig('firma_adres');



$q = my_mysql_query("select urun.*,kategori.name as catName,kategori.namePath as catNamePath,marka.name as markaName from urun,kategori,marka where kategori.noxml != 1 AND urun.noxml != 1 AND urun.markaID = marka.ID AND urun.catID=kategori.ID AND urun.active =1 AND stok >0 AND kategori.active = 1 AND fiyat > 0 $filter  order by urun.seq,kategori.seq");



while ($d = my_mysql_fetch_array($q)) {

	if ($d['noxml']) continue;

	//if (!$d['gtin'])

	//	$d['gtin'] = generateEAN($d['ID']);

	if(!$d['tedarikciCode'])

		$d['tedarikciCode'] = $d['barkodNo_HB'];

	if(!$d['tedarikciCode'])

		$d['tedarikciCode'] = $d['ID'];



	$d['xID'] = $d['tedarikciCode'];

	$d['detay'] = siteConfig('hb_header').$d['detay'].siteConfig('hb_footer');

	if(!siteConfig('telif-footer'))

		$d['detay'] .= '<hr />Bu ürün <a href="https://utopiayazilim.com" target="_blank"><strong>Utopia Yazılım</strong></a> e-ticaret yazılımı ile listelenmiştir';

	$d['kargoGun'] = (int)$d['kargoGun'];

	$d['CargoCompany1'] = $CargoCompany1;

	$d['ShippingAddressLabel'] = $ShippingAddressLabel;

	$d['ClaimAddressLabel'] = $ClaimAddressLabel;



	if (function_exists('fixStok'))

		$d['stok'] = fixStok($d);





	if (function_exists('getHBPrice'))

		$d['fiyat'] = getHBPrice($d);

	else {

		$d['fiyat'] = YTLfiyat($d['fiyat'], $d['fiyatBirim']);

		$d['fiyat'] = ($d['fiyat'] / (1 + $d['kdv']));

		$d['fiyat'] = my_money_format('', $d['fiyat']);

		$d['fiyat'] = str_replace(',', '', $d['fiyat']);

	}

	$d['kdv'] = ((float)$d['kdv'] * 100);





	for ($j = 1; $j <= 10; $j++) {

		$resimStr = 'resim' . ($j == 1 ? '' : $j);

		if ($d[$resimStr])

			$d[$resimStr] = 'https://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d[$resimStr];

		else

			unset($d[$resimStr]);

	}

	$dORG = $d;

	$j = 0;

	foreach ($viewArray as $k => $v) {

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($harfArray[$j] . $i, $d[$v]);

		$objPHPExcel->getActiveSheet()->getColumnDimension($harfArray[$j])->setAutoSize(true);

		$j++;

	}





	if ($d['varID1'] || $d['varID2']) {

		$var1 = (hq("select ozellik from var where ID='" . $d['varID1'] . "'"));

		$var2 = (hq("select ozellik from var where ID='" . $d['varID2'] . "'"));

		$xc = $d['tedarikciCode'];

		$vq = my_mysql_query("select * from urunvarstok where up = 1 AND urunID='" . $d['ID'] . "'");

		while ($vd = my_mysql_fetch_array($vq)) {

			$i++;

			$vd['stok'] = min($vd['stok'], $d['stok']);

			$price = (hq("select fark from urunvars where urunID='" . $d['ID'] . "' AND varID='" . $d['varID1'] . "' AND var like '" . $vd['var1'] . "'") + hq("select fark from urunvars where urunID='" . $d['ID'] . "' AND varID='" . $d['varID2'] . "' AND var like '" . $vd['var2'] . "'"));

			//$new = $var->addChild('var1');



			$varyantName = str_replace(array('SEÇINIZ'), array(''), $var1);

			$varyantName2 = str_replace(array('SEÇINIZ'), array(''), $var2);



			$d['gtin'] = $vd['gtin'];

			$d['stok'] = $vd['stok'];

			$d['renk'] = $vd['var1'];

			$d['beden'] = $vd['var2'];

			$d['tedarikciCode'] = $d['barkodNo_HB'];

			if(!$d['tedarikciCode'])

				$d['tedarikciCode'] = $vd['ID'].'-'.$xc;

			$d['fiyat'] = ($d['fiyat'] + $price + $vd['fark']);

			$j = 0;

			foreach ($viewArray as $k => $v) {

				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($harfArray[$j] . $i, $d[$v]);

				$objPHPExcel->getActiveSheet()->getColumnDimension($harfArray[$j])->setAutoSize(true);

				$j++;

			}

			$d = $dORG;

		}

		//break;

	}

	$i++;

}

$objPHPExcel->setActiveSheetIndex(0);

header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="hb.xls"');

header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('php://output');

exit;

 