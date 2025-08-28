<?php

@set_time_limit(0);

$title = 'Teknik İşlemler';

$apiNumber = 'ONyfrW1w72FrdveY0n9Yyip/MwMA2UG2GZr0eWx/Qj0=';

$editUTF8OK = $editUTF8Skip = 0;



function changeFileToUTF8($v)

{

	global $editUTF8OK, $editUTF8Skip;

	if (!is_file($v))

		return;

	$file = file_get_contents($v);

	if (!isUTF8($file)) {

		file_put_contents($v, iconv('iso-8859-9', 'utf-8', $file));

		$editUTF8OK++;

	} else

		$editUTF8Skip++;

}

function changeDirToUTF8($v)

{

	$dirArray = scandir($v);

	foreach ($dirArray as $vn) {

		$vx = $v . '/' . $vn;

		changeFileToUTF8($vx);

	}

}

function updateUrunResim($url, $ID, $field, $name = '')

{

	global $siteDizini;

	if (!$name) {

		$name = hq("select name from urun where ID='$ID' limit 0,1");

	}

	$resimLocation = seoFix($name) . (str_replace('resim', '', $field)) . '-' . $ID . '.jpg';

	XMLdownloadFile($url, '../images/urunler/', $resimLocation);

	my_mysql_query("update urun set $field = '$resimLocation' where ID='$ID' limit 1");

	return adminInfov5('<strong>' . $name . ' (' . $ID . ')</strong> ürün ' . $field . ' <strong>' . $resimLocation . '</strong> (' . $url . ') ile güncellendi.');

}



function buildAutoBreadCrumb($ID)

{

	$idPath = hq("select idPath from kategori where ID='" . $ID . "'");

	$q = my_mysql_query('select ID from kategori where idPath like \'%' . $idPath . '%\' order by namePath');

	while ($d = my_mysql_fetch_array($q)) {

		$breadCrumb = generateBreadCrumb('', $d['ID']);

		unset($breadCrumbFixed);

		for ($i = (sizeof($breadCrumb) - 1); $i >= 0; $i--) {

			$breadCrumbFixed[] = $breadCrumb[$i];

		}

		$breadCrumb = $breadCrumbFixed;

		$idPath = implode("/", $breadCrumb);

		for ($i = 0; $i < sizeof($breadCrumb); $i++) $breadCrumb[$i] = hq("select name from kategori where ID='" . $breadCrumb[$i] . "'");

		$namePath = implode("/", $breadCrumb);

		$level = count(explode("/", $idPath));

		my_mysql_query("update kategori set level = '" . $level . "' , idPath = '" . $idPath . "' , namePath = '" . addslashes($namePath) . "' where ID='" . $d['ID'] . "'");

		//echo $namePath.':'.$d['ID'].'<br />';

	}

}



if ($shopphp_demo && $_GET['act']) {

	echo v5Admin::adminHeader();

	echo v5Admin::fullBlock('Teknik İşlemler', '<div style="padding:15px;">Güvenlik nedeniyle teknik işlemler devredışıdır.</div>');

} else {

	$tempInfo = adminWarnv5('Teknik işlemlerden yapılan işlemler geri alınamaz. Emin olmadığınız işlemlerde mutlaka <a href="s.php?f=yedekdosya.php" target="_blank">site</a> ve <a href="s.php?f=yedek.php" target="_blank">veri tabanı</a> yedeğini alın.');

	switch ($_GET['act']) {

		case 'remove-empty-cats':

		case 'breadcrumb':

			//my_mysql_query("update urun set showCatIDs = ''");

			@set_time_limit(0);

			//error_reporting(E_ALL);

			$cat = 0;

			$q = my_mysql_query("select ID from kategori order by namePath");

			while ($d = my_mysql_fetch_array($q)) {

				buildAutoBreadCrumb($d['ID']);

				$cat++;

			}

			$urun = 0;

			$q = my_mysql_query("select ID from urun order by showCatIDs");

			while ($d = my_mysql_fetch_array($q)) {

				updateUrunShowCatIDs($d['ID']);

				$urun++;

			}

			$tempInfo .= adminInfov5("Toplam <strong>$urun</strong> ürün ve <strong>$cat</strong> kategori güncellendi.");

			if ($_GET['act'] == 'remove-empty-cats') {

				$q = my_mysql_query("select * from kategori where active = 1");

				while ($d = my_mysql_fetch_array($q)) {

					if (!hq("select count(*) from urun where catID='" . $d['ID'] . "' OR showCatIDs like '%|" . $d['ID'] . "|%'"))

						my_mysql_query("update kategori set active = 0 where ID='" . $d['ID'] . "' limit 1");

				}

				$q = my_mysql_query("select * from kategori where active = 0");

				while ($d = my_mysql_fetch_array($q)) {

					if (!hq("select count(*) from urun where catID='" . $d['ID'] . "' OR showCatIDs like '%|" . $d['ID'] . "|%'"))

						my_mysql_query("update kategori set active = 1 where ID='" . $d['ID'] . "' limit 1");

				}

			}

			break;

		case 'updatepics-bingall':

			$q = my_mysql_query("select ID,name from urun where active = 1 AND resim = ''");

			while ($d = my_mysql_fetch_array($q)) {

				$url = 'http://api.bing.net/json.aspx?AppId=' . $apiNumber . '&Query=' . urlencode($d['name']) . '&Sources=Image&Version=2.2&Market=en-us&Adult=Strict&Image.Count=1&Image.Offset=0&JsonType=raw';

				$json = file_get_contents($url);

				$data = json_decode($json);

				$first = $data->SearchResponse->Image->Results;

				$firstURL = $first[0];

				$tempInfo .= updateUrunResim($firstURL->Url, $d['ID'], 'resim', $d['name']);

			}

		case 'updatepics-bing':

			if ($_POST['catID']) {

				if ($_POST['catID'] == $_POST['pcatID']) {

					foreach ($_POST as $k => $v) {

						if (substr($k, 0, 7) == 'picarr_') {

							list($a, $ID) = explode('_', $k);

							$i = 1;

							foreach ($v as $url) {

								$tempInfo .= updateUrunResim($url, $ID, 'resim' . ($i > 1 ? $i : ''));

								$i++;

							}

						}

					}

				} else {

					$pout .= '<input type="hidden" name="pcatID" value="' . $_POST['catID'] . '">';

					$q = my_mysql_query("select ID,name from urun where active = 1 AND (catID='" . $_POST['catID'] . "' OR showCatIDs like '%|" . $_POST['catID'] . "|%') AND resim = ''");

					while ($d = my_mysql_fetch_array($q)) {

						$pout .= '<span class="st-labeltext" style="white-space:nowrap; font-weight:bold;">' . $d['name'] . ' : </span><br /><br />';

						$url = 'http://api.bing.net/json.aspx?AppId=' . $apiNumber . '&Query=' . urlencode($d['name']) . '&Sources=Image&Version=2.2&Market=en-us&Adult=Strict&Image.Count=5&Image.Offset=0&JsonType=raw';

						$json = file_get_contents('http://ajax.googleapis.com/ajax/services/search/images?imgsz=medium|large|xlarge&v=1.0&q=' . urlencode($d['name']));

						$data = json_decode($json);

						$i = 0;

						$pout .= '<table style="width:100%;"><tr>';

						foreach ($data->SearchResponse->Image->Results as $result) {

							if ($i >= 5) break;

							if ($result->url)

								$pout .= '<td style="width:25%;" valign="top"><input type="checkbox" name="picarr_' . $d['ID'] . '[]" value="' . $result->Url . '" id="pic_' . $d['ID'] . '_' . $i . '"><br /><label for="pic_' . $d['ID'] . '_' . $i . '"><a href="' . $result->Url . '" target="_blank" title="' . strip_tags(utf8fix($result->title)) . '"><img src="' . $result->Url . '" style="width:80%;" alt=""/></label></td>';

							$i++;

						}

						$pout .= '</tr></table><div style="clear:both">&nbsp;</div><hr size="1" color="#eee"><div style="clear:both">&nbsp;</div>' . "\n";

					}

				}

			}

			break;

		case 'updatepics-googleall':

			$q = my_mysql_query("select ID,name from urun where active = 1 AND resim = ''");

			while ($d = my_mysql_fetch_array($q)) {

				$url = 'https://www.googleapis.com/customsearch/v1?cx=005819046430719673548:qzahlnoxtdu&key=AIzaSyAV4mEd1tcYNgKgCCr2XdUDKKDkJYPnLRk&imgsz=large|xlarge&v=1.0&q=' . urlencode($d['name']);

				$json = file_get_contents($url);

				$data = json_decode($json);

				$first = $data->items;

				$firstURL = $first[0];

				$tempInfo .= updateUrunResim($firstURL->pagemap->cse_image[0]->src, $d['ID'], 'resim', $d['name']);

			}

		case 'updatepics-google':

			if ($_POST['catID']) {

				if ($_POST['catID'] == $_POST['pcatID']) {

					foreach ($_POST as $k => $v) {

						if (substr($k, 0, 7) == 'picarr_') {

							list($a, $ID) = explode('_', $k);

							$i = 1;

							foreach ($v as $url) {

								$tempInfo .= updateUrunResim($url, $ID, 'resim' . ($i > 1 ? $i : ''));

								$i++;

							}

						}

					}

				} else {

					$pout .= '<input type="hidden" name="pcatID" value="' . $_POST['catID'] . '">';

					$q = my_mysql_query("select ID,name from urun where active = 1 AND (catID='" . $_POST['catID'] . "' OR showCatIDs like '%|" . $_POST['catID'] . "|%') AND resim = ''");

					while ($d = my_mysql_fetch_array($q)) {

						$pout .= '<span class="st-labeltext" style="white-space:nowrap; font-weight:bold;">' . $d['name'] . ' : </span><br /><br />';



						$url = 'https://www.googleapis.com/customsearch/v1?cx=005819046430719673548:qzahlnoxtdu&key=AIzaSyAV4mEd1tcYNgKgCCr2XdUDKKDkJYPnLRk&imgsz=large|xlarge&v=1.0&q=' . urlencode($d['name']);

						$json = file_get_contents($url);



						$data = json_decode($json);

						$i = 0;

						$pout .= '<table style="width:100%;"><tr>';

						foreach ($data->items as $result) {



							$resim = $result->pagemap->cse_image[0]->src;

							if ($i >= 5) break;

							if ($resim)

								$pout .= '<td style="width:25%;" valign="top"><input type="checkbox" name="picarr_' . $d['ID'] . '[]" value="' . $resim . '" id="pic_' . $d['ID'] . '_' . $i . '"><br /><label for="pic_' . $d['ID'] . '_' . $i . '"><a href="' . $resim . '" target="_blank" title="' . strip_tags(utf8fix($result->title)) . '"><img src="' . $resim . '" style="width:80%;" alt=""/></label></td>';

							$i++;

						}

						$pout .= '</tr></table><div style="clear:both">&nbsp;</div><hr size="1" color="#eee"><div style="clear:both">&nbsp;</div>' . "\n";

					}

				}

			}

			break;

		case 'repairdb':

			$rs2 = my_mysql_query("show tables");

			while ($arr2 = my_mysql_fetch_array($rs2)) {

				$q = my_mysql_query("repair table $arr2[0]");

				my_mysql_query("ALTER TABLE $arr2[0] DROP PRIMARY KEY,ADD PRIMARY KEY(`ID`)");

				my_mysql_query("ALTER TABLE $arr2[0] ADD PRIMARY KEY (`ID`)");

				my_mysql_query("ALTER TABLE $arr2[0] CHANGE `ID` `ID` INT(11) NOT NULL AUTO_INCREMENT");

				my_mysql_query("ALTER TABLE $arr2[0] MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT");



				$d = my_mysql_fetch_array($q);

				$tempInfo .= adminInfov5('<strong>' . $arr2[0] . '</strong> tablosuna tamir konutu gönderildi. <strong>(' . $d['Msg_text'] . ')</strong>');

			}

			break;

		case 'repair-basket':

			$q = my_mysql_query("select siparis.durum,siparis.randStr from siparis,sepet where siparis.randStr = sepet.randStr AND siparis.durum != sepet.durum group by siparis.randStr");

			while ($d = my_mysql_fetch_array($q)) {

				my_mysql_query("update sepet set durum = '" . $d['durum'] . "' where randStr = '" . $d['randStr'] . "'");

			}

			$tempInfo .= adminInfov5('Sepet sipariş durum değerleri güncellendi.');

			break;

		case 'optimizedb':

			$rs2 = my_mysql_query("show tables");

			while ($arr2 = my_mysql_fetch_array($rs2)) {

				$q = my_mysql_query("optimize table `$arr2[0]`");

				$d = my_mysql_fetch_array($q);

				$tempInfo .= adminInfov5('<strong>' . $arr2[0] . '</strong> tablosuna optimize konutu gönderildi. <strong>(' . $d['Msg_text'] . ')</strong>');

			}

			break;

		case 'cleanbrand':

			$mi = 0;

			$q = my_mysql_query("select * from marka group by name");

			while ($d = my_mysql_fetch_array($q)) {

				$markaID = $d['ID'];

				$markaName = trim($d['name']);

				$q2 = my_mysql_query("select * from marka where name like '$markaName' AND ID != '$markaID'");

				//$tempInfo.=adminInfov5($markaName.' Kontrol.');

				while ($d2 = my_mysql_fetch_array($q2)) {

					my_mysql_query("update urun set markaID='" . $markaID . "' where markaID='" . $d2['ID'] . "'");

					my_mysql_query("delete from marka where ID='" . $d2['ID'] . "'");

					$tempInfo .= adminInfov5('<strong>' . $d2['name'] . ' (' . $d2['ID'] . ')</strong> markasından birden fazla olduğundan silindi.');

					$mi++;

				}

			}

			$tempInfo .= adminInfov5('Toplam <strong>' . $mi . '</strong> marka ismi benzer olduğu için silindi ve ürünleri güncellendi.');

			break;

		case 'fixgtin':

			$mi = 0;

			$q = my_mysql_query("select ID from urun where gtin = '' OR gtin = '0'");

			while ($d = my_mysql_fetch_array($q)) {

				my_mysql_query("update urun set gtin='" . generateRandomEANCode() . "' where ID='" . $d['ID'] . "' limit 1");

				$mi++;

			}

			$q = my_mysql_query("select ID from urunvarstok where gtin = '' OR gtin = '0'");

			while ($d = my_mysql_fetch_array($q)) {

				my_mysql_query("update urunvarstok set gtin='" . generateRandomEANCode() . "' where ID='" . $d['ID'] . "' limit 1");

				$mi++;

			}

			$tempInfo .= adminInfov5('Toplam <strong>' . $mi . '</strong> ürün / varyasyon GTIN değeri güncellendi.');

			break;

		case 'fixgtin2':

			$mi = 0;

			$q = my_mysql_query("select ID from urun");

			while ($d = my_mysql_fetch_array($q)) {

				my_mysql_query("update urun set gtin='" . generateRandomEANCode() . "' where ID='" . $d['ID'] . "' limit 1");

				$mi++;

			}

			$q = my_mysql_query("select ID from urunvarstok");

			while ($d = my_mysql_fetch_array($q)) {

				my_mysql_query("update urunvarstok set gtin='" . generateRandomEANCode() . "' where ID='" . $d['ID'] . "' limit 1");

				$mi++;

			}

			$tempInfo .= adminInfov5('Toplam <strong>' . $mi . '</strong> ürün / varyasyon GTIN değeri eklendi.');

			break;

		case 'fixbrand':

			$mID = hq("select ID from marka where name like 'diger' OR name like 'diğer' OR name like 'DİĞER'");

			$mi = 0;

			$q = my_mysql_query("select * from urun");

			while ($d = my_mysql_fetch_array($q)) {

				if (!hq("select ID from marka where ID='" . $d['markaID'] . "' limit 0,1")) {

					$mi++;

					my_mysql_query("update urun set markaID='$mID' where ID='" . $d['ID'] . "' limit 1");

				}

			}

			$tempInfo .= adminInfov5('Toplam <strong>' . $mi . '</strong> ürün marka seçilmediği için güncellendi.');

			break;

		case 'updateproductIDs':

			$id = 1;

			$q2 = my_mysql_query("select ID from urun");

			while ($d2 = my_mysql_fetch_array($q2)) {

				my_mysql_query("update urun set ID='" . $id . "' where ID='" . $d2['ID'] . "'");

				my_mysql_query("update urunvar set urunID='" . $id . "' where urunID='" . $d2['ID'] . "'");

				my_mysql_query("update urunvars set urunID='" . $id . "' where urunID='" . $d2['ID'] . "'");

				my_mysql_query("update urunvarstok set urunID='" . $id . "' where urunID='" . $d2['ID'] . "'");

				my_mysql_query("update sepet set urunID='" . $id . "' where urunID='" . $d2['ID'] . "'");

				$id++;

			}

			my_mysql_query("ALTER TABLE urun AUTO_INCREMENT = " . hq("select (ID + 1) from urun order by ID desc limit 0,1"));

			$tempInfo .= adminInfov5('Toplam <strong>' . $id . '</strong> ürün ID güncellendi.');

			break;

		case 'updateproductnames':

			$id = 1;

			$q2 = my_mysql_query("select ID,name from urun");

			while ($d2 = my_mysql_fetch_array($q2)) {

				$name = str_replace('-', '', mb_convert_case($d2['name'], MB_CASE_TITLE, "UTF-8"));

				if (!$name)

					continue;

				my_mysql_query("update urun set name='" . $name . "' where ID='" . $d2['ID'] . "'");

				$id++;

			}

			$tempInfo .= adminInfov5('Toplam <strong>' . $id . '</strong> ürün adı güncellendi.');

			break;

		case 'updateproductprices':

			$id = 1;

			$q2 = my_mysql_query("select ID,name,fiyat,fiyat1,fiyat2,fiyat3,fiyat4,fiyat5 from urun");

			while ($d2 = my_mysql_fetch_array($q2)) {

				my_mysql_query("update urun set fiyat=ROUND(fiyat,0),fiyat1=ROUND(fiyat1,0),fiyat2=ROUND(fiyat2,0),fiyat3=ROUND(fiyat3,0),fiyat4=ROUND(fiyat4,0),fiyat5=ROUND(fiyat5,0) where ID='" . $d2['ID'] . "'", 1);

				$id++;

			}

			$tempInfo .= adminInfov5('Toplam <strong>' . $id . '</strong> ürün adı güncellendi.');

			break;

		case 'updateproductsales':

			$id = 1;

			$q2 = my_mysql_query("select ID from urun");

			while ($d2 = my_mysql_fetch_array($q2)) {

				my_mysql_query("update urun set sold = '" . (int) hq("select sum(adet) from sepet where urunID='" . $d2['ID'] . "' AND durum > 0 AND durum < 90") . "' where ID='" . $d2['ID'] . "' limit 1");

				$id++;

			}

			$tempInfo .= adminInfov5('Toplam <strong>' . $id . '</strong> ürün satış adet kolonu güncellendi.');

			break;

		case 'cleanproduct':

			$mi = 0;

			$q = my_mysql_query("select ID,name,catID from urun where active = 1 group by name order by tedarikciID desc,ID desc");

			while ($d = my_mysql_fetch_array($q)) {

				$urunID = $d['ID'];

				$urunName = addslashes($d['name']);

				$q2 = my_mysql_query("select ID,name from urun where name like '$urunName' AND catID='" . $d['catID'] . "' AND ID != '$urunID' AND active = 1");

				while ($d2 = my_mysql_fetch_array($q2)) {

					my_mysql_query("update urun set active = 0 where ID = '" . $d2['ID'] . "'");

					$tempInfo .= adminInfov5('<strong>' . $d2['name'] . ' (' . $d2['ID'] . ')</strong> ürününden birden fazla olduğundan, pahalı olan ürün pasif yapıldı.');

					$mi++;

				}

			}

			$tempInfo .= adminInfov5('Toplam <strong>' . $mi . '</strong> ürün, ismi benzer olduğu için pasif edildi.');

			break;

		case 'cleanvars':

			$mi = 0;

			$q = my_mysql_query("select ID,urunID from urunvars");

			while ($d = my_mysql_fetch_array($q)) {

				if (!hq("select ID from urun where ID='" . $d['urunID'] . "'")) {

					my_mysql_query("delete from urunvars where ID='" . $d['ID'] . "'");

					$mi++;

				}

			}

			$tempInfo .= adminInfov5('Toplam <strong>' . $mi . '</strong> varyasyon, silindi.');

			$mi = 0;

			$q = my_mysql_query("select ID,urunID from urunvarstok");

			while ($d = my_mysql_fetch_array($q)) {

				if (!hq("select ID from urun where ID='" . $d['urunID'] . "'")) {

					my_mysql_query("delete from urunvarstok where ID='" . $d['ID'] . "'");

					$mi++;

				}

			}

			$tempInfo .= adminInfov5('Toplam <strong>' . $mi . '</strong> varyasyon stoğu, silindi.');



			$mi = 0;

			$q = my_mysql_query("select ID from urun where varID1 ='' AND varID2=''");

			while ($d = my_mysql_fetch_array($q)) {

				my_mysql_query("delete from urunvarstok where urunID='" . $d['ID'] . "'");

				my_mysql_query("delete from urunvars where urunID='" . $d['ID'] . "'");



				$mi++;

			}

			$tempInfo .= adminInfov5('Toplam <strong>' . $mi . '</strong> ürün varyasyon kontrolü yapıldı.');



			break;

		case 'cleancat':

			$mi = 0;

			$q = my_mysql_query("select * from kategori group by name  order by tedarikciID desc");

			while ($d = my_mysql_fetch_array($q)) {

				$catID = $d['ID'];

				$catName = $d['name'];

				$catParentID = $d['parentID'];

				//echo ("select * from kategori where name like '$catName' AND parentID='$catParentID' AND ID != '$catID'").'<br />';

				$q2 = my_mysql_query("select * from kategori where name like '$catName' AND parentID='$catParentID' AND ID != '$catID'");

				while ($d2 = my_mysql_fetch_array($q2)) {

					my_mysql_query("update urun set catID='" . $catID . "' where catID='" . $d2['ID'] . "'");

					my_mysql_query("delete from kategori where ID='" . $d2['ID'] . "'");

					$tempInfo .= adminInfov5('<strong>' . $d2['name'] . ' (' . $d2['ID'] . ')</strong> kategorisinden birden fazla olduğundan silindi.');

					$mi++;

				}

			}

			$tempInfo .= adminInfov5('Toplam <strong>' . $mi . '</strong> kategori ismi benzer olduğu için silindi ve ürünleri güncellendi.');

			break;



		case 'updatev3stocks':

			$mi = 0;

			$q = my_mysql_query("select ID,varID1,varID2,ozellik1,ozellik2,ozellik1detay,ozellik2detay,stok from urun where ozellik1 != ''");

			while ($d = my_mysql_fetch_array($q)) {



				if ($d['varID1']) {

					$d['ozellik1'] = hq("select ozellik from var where ID='" . $d['varID1'] . "'");

					$d['ozellik1detay'] = hq("select ozellikdetay from var where ID='" . $d['varID1'] . "'");

				}

				if ($d['varID2']) {

					$d['ozellik2'] = hq("select ozellik from var where ID='" . $d['varID2'] . "'");

					$d['ozellik2detay'] = hq("select ozellikdetay from var where ID='" . $d['varID2'] . "'");

				}

				updateItemOptions($d);

				$mi++;

			}

			$tempInfo .= adminInfov5('Toplam <strong>' . $mi . '</strong> ürün varyasyon kontrolü yapıldı ve güncellendi.');

			break;



		case 'updatevarstocks':

			$q = my_mysql_query("select * from urunvars");

			$mi = $mx = 0;

			while ($d = my_mysql_fetch_array($q)) {

				list($name, $fark) = explode('|', $d['var']);

				if (!hq("select ID from urunvarstok where urunID='" . $d['urunID'] . "' AND (var1 like '" . $name . "' OR var2 like'" . $name . "') ")) {

					$stok = hq("select stok from urun where ID='" . $d['urunID'] . "'");

					my_mysql_query("update urunvars set var ='$name' where ID='" . $d['ID'] . "'");

					my_mysql_query("insert into urunvarstok (ID,urunID,var1,fark,stok,up) VALUES (null,'" . $d['urunID'] . "','$name','$fark','" . $stok . "',1)");

					my_mysql_query("update var set ozellikdetay = concat(ozellikdetay,'" . addslashes($name) . "\n') where ozellikdetay not like '%" . addslashes($name) . "%' AND ID='" . $d['varID'] . "'");

					$mx++;

				}

				$mi++;

			}

			$tempInfo .= adminInfov5('Toplam <strong>' . $mi . '</strong> ürün varyasyon kontrolü yapıldı ve <strong>' . $mx . '</strong> kayıt güncellendi.');

			break;



		case 'updatestocks':

			$mi = 0;

			$q = my_mysql_query("select * from urun where varID1 != ''");

			while ($d = my_mysql_fetch_array($q)) {

				$toplamVarStok = hq("select sum(stok) from urunvarstok where urunID='" . $d['ID'] . "' AND up=1");

				if ($toplamVarStok && hq("select count(*) from urunvarstok where urunID='" . $d['ID'] . "' AND up=1")) {

					my_mysql_query("update urun set stok = '$toplamVarStok' where ID='" . $d['ID'] . "' limit 1");

					$mi++;

				}

			}

			$q = my_mysql_query("select * from urun where varID1 = ''");

			while ($d = my_mysql_fetch_array($q)) {

				my_mysql_query("delete from urunvarstok where urunID='" . $d['ID'] . "'");

				my_mysql_query("delete from urunvars where urunID='" . $d['ID'] . "'");

			}

			$tempInfo .= adminInfov5('Toplam <strong>' . $mi . '</strong> ürün stok sayısı, varyasyon stok sayısı ile eşitlendi.');

			break;

		case 'resizepics':

			include('resizeFile.php');

			$mi = 0;

			$q = my_mysql_query("select * from urun where " . ($_GET['catID'] ? 'catID= \'' . (int) $_GET['catID'] . '\' AND ' : '') . " resim != ''");

			while ($d = my_mysql_fetch_array($q)) {

				for ($i = 1; $i <= 10; $i++) {

					if ($d['resim' . ($i > 1 ? $i : '')]) {

						if (is_array(getimagesize('../images/urunler/' . $d['resim' . ($i > 1 ? $i : '')]))) {

							resize(1000, '../images/urunler/' . $d['resim' . ($i > 1 ? $i : '')], '../images/urunler/resized_' . $d['resim' . ($i > 1 ? $i : '')]);

							$tempInfo .= adminInfov5('<strong>' . $d['name'] . ' (' . $d['ID'] . ')</strong> ait resim' . ($i > 1 ? $i : '') . ' yeniden boyutlandırıldı.');

							$mi++;

						} else

							$tempInfo .= adminWarnv5('<strong>' . $d['name'] . ' (' . $d['ID'] . ')</strong> ait resim' . ($i > 1 ? $i : '') . ' geçersiz algılandı. Bu paneldenki "Hatalı resimleri sil" seçeneği ile bu resimleri toplu silebilirsiniz.');

					}

				}

			}

			$tempInfo .= adminInfov5('Toplam <strong>' . $mi . '</strong> ürün resmi yeniden boyutlandırıldı.');

			break;

		case 'allpics':

			$ri = 0;

			$ci = 0;

			foreach (glob('../images/urunler/*.*') as $v) {

				$r = basename($v);

				//if(!hq("select ID from urun where resim like '$r' OR resim2 like '$r' OR resim3 like '$r' OR resim4 like '$r' OR resim5 like '$r'"))

				{

					if (getimagesize($v)) {

						$tempInfo .= adminInfov5('<strong>' . $v . '</strong> isimli resim  silindi.');

						$ri++;

						unlink('../images/urunler/' . $v);

					} else {

						$tempInfo .= adminInfov5('<strong>' . $v . '</strong> dosyası bir resim değil. Üzerinde işlem yapılmadı.');

					}

				}

				$ci++;

			}

			$tempInfo .= adminInfov5('Toplam <strong>' . $ci . '</strong> dosya kontrol edildi. <strong>' . $ri . '</strong> resim için silindi.');

			break;

		case 'convertpics':

				$mi = 0;

				$q = my_mysql_query("select name,ID,resim,resim2,resim3,resim4,resim5,seo from urun where resim != '' AND resim not like '%.webp'");

				while ($d = my_mysql_fetch_array($q)) {

					for ($i = 1; $i <= 5; $i++) {

						if ($d['resim' . ($i > 1 ? $i : '')] && (file_exists('../images/urunler/' . $d['resim' . ($i > 1 ? $i : '')]) || getimagesize('../images/urunler/' . $d['resim' . ($i > 1 ? $i : '')]))) {



							$newfile = webpConvert2('../images/urunler/' . $d['resim' . ($i > 1 ? $i : '')],80,$d);

							if($newfile)

							{

								my_mysql_query("update urun set resim" . ($i > 1 ? $i : '') . " = '".basename($newfile)."' where ID ='" . $d['ID'] . "'");

								$tempInfo .= adminInfov5('<strong>' . $d['name'] . ' (' . $d['ID'] . ')</strong> ait resim' . ($i > 1 ? $i : '') . ' webp formatına dönüştürüldü.');

							}

							else

								$tempInfo .= adminErrorv5('<strong>' . $d['name'] . ' (' . $d['ID'] . ')</strong> ait resim' . ($i > 1 ? $i : '') . ' webp formatına dönüştürülemedi.');

							$mi++;

						}

					}

				}

				$tempInfo .= adminInfov5('Toplam <strong>' . $mi . '</strong> ürün resmi webp kontrolü tamamlandı.');

				break;

		case 'brokenpics':

			$mi = 0;

			$q = my_mysql_query("select name,ID,resim,resim2,resim3,resim4,resim5 from urun where resim != ''");

			while ($d = my_mysql_fetch_array($q)) {

				for ($i = 1; $i <= 5; $i++) {

					if ($d['resim' . ($i > 1 ? $i : '')] && (!file_exists('../images/urunler/' . $d['resim' . ($i > 1 ? $i : '')]) || !getimagesize('../images/urunler/' . $d['resim' . ($i > 1 ? $i : '')]))) {

						my_mysql_query("update urun set resim" . ($i > 1 ? $i : '') . " = '' where ID ='" . $d['ID'] . "'");

						$tempInfo .= adminInfov5('<strong>' . $d['name'] . ' (' . $d['ID'] . ')</strong> ait resim' . ($i > 1 ? $i : '') . ' bulunamadığından veya hatalı olduğundan field boşaltıldı.');

						if (!getimagesize('../images/urunler/' . $d['resim' . ($i > 1 ? $i : '')])) {

							unlink('../images/urunler/' . $d['resim' . ($i > 1 ? $i : '')]);

							$tempInfo .= adminInfov5('<strong>' . $d['name'] . ' (' . $d['ID'] . ')</strong> ait resim' . ($i > 1 ? $i : '') . ' hatalı olduğundan silindi.');

						}

						$mi++;

					}

				}

			}

			$tempInfo .= adminInfov5('Toplam <strong>' . $mi . '</strong> ürün resmi bulunamadığı için, resim field\'ı boşaltıldı.');

			break;

		case 'seopics':

			$mi = 0;

			$q = my_mysql_query("select ID,name,resim,resim2,resim3,resim4,resim5 from urun where resim != ''");

			while ($d = my_mysql_fetch_array($q)) {

				for ($i = 1; $i <= 5; $i++) {

					$field = 'resim' . ($i > 1 ? $i : '');

					if (!$d[$field])

						continue;

					

					$ext = pathinfo('../images/urunler/'.$d[$field], PATHINFO_EXTENSION);

					$filename = seoFix($d['name']) . '-' . $d['ID'] . '_' . $i . '.' . $ext;

					if ($d[$field] == $filename)

						continue;



					my_mysql_query("update urun set $field = '$filename' where ID='" . $d['ID'] . "' limit 1");

					if (my_mysql_affected_rows()) {

						rename('../images/urunler/' . $d[$field], '../images/urunler/' . $filename);

						$tempInfo .= adminInfov5('<strong>' . $d['name'] . ' (' . $d['ID'] . ')</strong> ait ' . $field . ' SEO ya uygun olarak "' . $filename . '" dosya adıyla güncellendi.');

						$mi++;

					}

				}

			}

			$tempInfo .= adminInfov5('Toplam <strong>' . $mi . '</strong> ürün resmi SEO uygun bir şekilde güncellendi.');

			break;

		case 'passivepics':

			$ri = 0;

			$ci = 0;

			my_mysql_query("update urun set active = 0 where resim = ''");

			$tempInfo .= adminInfov5('Toplam <strong>' . my_mysql_affected_rows() . '</strong> ürün, resmi olmadığı için pasif edildi.');

			break;

		case 'cleanpics':

			$ri = 0;

			$ci = 0;

			foreach (glob('../images/urunler/*.*') as $v) {

				$r = basename($v);

				if (!hq("select ID from urun where resim like '$r' OR resim2 like '$r' OR resim3 like '$r' OR resim4 like '$r' OR resim5 like '$r'") && !hq("select ID from urun where resim6 like '$r' OR resim7 like '$r' OR resim8 like '$r' OR resim9 like '$r' OR resim10 like '$r'")) {

					if (getimagesize($v)) {

						$tempInfo .= adminInfov5('<strong>' . $v . '</strong> isimli resim kullanılmadığından silindi.');

						$ri++;

						unlink($v);

					} else {

						$tempInfo .= adminInfov5('<strong>' . $v . '</strong> dosyası bir resim değil. Üzerinde işlem yapılmadı.');

					}

				}

				$ci++;

			}

			$tempInfo .= adminInfov5('Toplam <strong>' . $ci . '</strong> dosya kontrol edildi. <strong>' . $ri . '</strong> resim kullanılmadığı için silindi.');

			break;

		case 'cleanimagecache':

			delTree('../images/cache/');

			delTree('images/cache/');

			$tempInfo .= adminInfov5('images/cache dizini boşaltıldı.');

			break;

		case 'emaillogclean':

			my_mysql_query("delete from epostalog");

			$tempInfo .= adminInfov5('E-Posta logları silindi.');

			break;

		case 'query':

			if ($_POST['query']) {

				$_POST['query'] = stripslashes($_POST['query']);

				if (!$_SESSION['admin_isAdmin'] || $shopphp_demo)

					$tempInfo .= adminInfov5('Bu işlem sadece admin yetkisindeki kullanıcılar tarafından kullanılabilir.');

				else {

					require_once('../doc/import-lib.php');

					if (stristr($_POST['query'], ';') === false)

						$_POST['query'] .= ';';

					mysql_import_text($_POST['query']);

					$tempInfo .= adminInfov5('<pre>' . $_POST['query'] . '</pre>Veri tabanı sorgusu çalıştırıldı.', 'data');

				}

			}

			break;

		case 'utf8-bom':

			$check_extensions = array('php');

			// MAIN

			////////////////////////////////////////////////////////////////////////////////

			define('STR_BOM', "\xEF\xBB\xBF");

			$file = null;

			$directory = '../include/';

			$rit = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory), RecursiveIteratorIterator::CHILD_FIRST);

			echo '<h1>BOM Check</h1>';

			try {

				foreach ($rit as $file) {

					if ($file->isFile()) {

						$path_parts = pathinfo($file->getRealPath());

						if (isset($path_parts['extension']) && in_array($path_parts['extension'], $check_extensions)) {

							$object = new SplFileObject($file->getRealPath());

							$line = $object->getCurrentLine();

							if (false !== strpos($line, STR_BOM)) {

								$tempInfo .= adminInfov5($file->getRealPath() . ' Dosyasında UTF8 BOM başlangıcı var.');

							} else if (substr($line, 0, 1) != '<') {

								$tempInfo .= adminInfov5($file->getRealPath() . ' Dosyasında UTF8 BOM yok fakat PHP tag öncesi bir karakter var.');

							}

						}

					}

				}

			} catch (Exception $e) {

				die('Exception caught: ' . $e->getMessage());

			}

			$tempInfo .= adminInfov5('UTF-8 BOM bulunan dosyaların bir editör ile açılıp, BOM Singature \'ın kaldırılması gerekmektedir.');

			break;

		case 'temp-2-utf8':

			//$dirArray = scandir('../templates/');

			//foreach($dirArray as $v)

			{

				$tempName = '../templates/' . $v;

				$tempName = siteConfig('templateName');

				changeDirToUTF8('../templates/' . $tempName . '/');

				changeDirToUTF8('../templates/' . $tempName . '/systemDefault');

				changeDirToUTF8('../templates/' . $tempName . '/blocks');

				changeDirToUTF8('../templates/' . $tempName . '/lists');

			}

			$tempInfo .= adminInfov5('Toplam <strong>' . (int) $editUTF8OK . '</strong> dosya encode UTF-8 olarak güncellendi. Kontrol edilen <strong>' . (int) $editUTF8Skip . '</strong> dosya zaten UTF-8 olduğundan güncellenmedi.');

			break;

		case 'repair-seo':

			setAllSEOFields('urun', 'name');

			setAllSEOFields('kategori', 'name');

			setAllSEOFields('marka', 'name');

			setAllSEOFields('makalekategori', 'name');

			setAllSEOFields('makaleler', 'baslik');

			setAllSEOFields('haberler', 'baslik');

			setAllSEOFields('pages', 'title');



			my_mysql_query("update urun set seo = replace(seo,'--','-')");

			my_mysql_query("update urun set seo = replace(seo,'--','-')");



			$tempInfo .= adminInfov5('Ürun, kategori, marka, makale, makalekategori,haberler ve pages tablolarında SEO fieldları düzenlendi.');

			break;

		case 'update-lang':

			updateTLang();

			break;

		case 'updateuserorder':

			$q = my_mysql_query("select ID,name,lastname from user order by name");

			while ($d = my_mysql_fetch_array($q)) {

				updateUserOrderDB($d['ID']);

				$tempInfo .= adminInfov5('Kullanıcı : ' . $d['name'] . ' ' . $d['lastname'] . ' cirosu güncellendi.');

			}

			break;

		case 'var-filter':

			$q = my_mysql_query("select ID,ozellik from var");

			while ($d = my_mysql_fetch_array($q)) {

				$var[$d[ID]] = $d['ozellik'];

			}



			$q = my_mysql_query("select urunvars.*,urun.name from urunvars,urun where urunvars.urunID=urun.ID AND urunvars.up=1");

			while ($d = my_mysql_fetch_array($q)) {

				$title = $var[$d[varID]];

				filitreAutoKontrol($title, $d['var'], $d['urunID']);

				$tempInfo .= adminInfov5('Ürün ' . $d['name'] . ' (' . $d['urunID'] . ') için <strong>' . $title . '</strong> özelliğinde ve <strong>' . $d['var'] . '</strong> değerinde filtre kontrolü yapıldı.');

			}

			break;

		case 'cronjoblogview':

			$tempInfo .= adminInfov5('

					<div id="cron-job-log">Cron job çalıştırıldı. Lütfen bekleyin ...</div>

					<script>

						$( "#cron-job-log" ).load( "../update.php?up=1" );

					</script>

				');

			break;

		case 'emptycats':

			$q = my_mysql_query("select ID,name,idPath from kategori where active=1 order by namePath", 1);

			$tempInfo .= adminInfov5('Toplam ' . (int) my_mysql_num_rows($q) . ' kategori kontrol edilecek.');

			while ($d = my_mysql_fetch_array($q)) {

				if (!hq("select ID from urun where active = 1 AND (urun.catID='" . $d['ID'] . "' OR urun.virtualCatIDs like '%," . $d['ID'] . ",%' OR showCatIDs like '%|" . $d['ID'] . "|%' or kategori.idPath like '" . $d['idPath'] . "/%') limit 0,1")) {

					my_mysql_query("update kategori set active = 0 where ID='" . $d['ID'] . "'");

					$tempInfo .= adminInfov5('Kategori ' . $d['name'] . ' (' . $d['ID'] . ') içinde aktif ürün bulunmadığından pasif edildi.');

				} else 

						if (!$d['active']) {

					my_mysql_query("update kategori set active = 1 where ID='" . $d['ID'] . "'");

					$tempInfo .= adminInfov5('Kategori ' . $d['name'] . ' (' . $d['ID'] . ') içinde aktif ürün bulunduğundan aktif edildi.');

				}

			}



			break;

		case 'update':

			switch (siteConfig('version')) {

				case '3.0':

					$gArr = array('v30_to_v31_sql.txt', 'v31_to_v32_sql.txt', 'v32_to_v33_sql.txt', 'v33_to_v34_sql.txt', 'v34_to_v35_sql.txt', 'v35_to_v36_sql.txt', 'v36_to_v37_sql.txt', 'v37_to_v38_sql.txt', 'v38_to_v39_sql.txt', 'v39_to_v395_sql.txt', 'v395_to_v4_sql.txt', 'v40_to_v41_sql.txt', 'v41_to_v42_sql.txt', 'v42_to_v43_sql.txt', 'v43_to_v44_sql.txt', 'v44_to_v45_sql.txt', 'v45_to_v46_sql.txt', 'v46_to_v47_sql.txt', 'v47_to_v48_sql.txt', 'v48_to_v49_sql.txt', 'v49_to_v495_sql.txt', 'v495_to_v499_sql.txt', 'v499_to_v500_sql.txt');

					break;

				case '3.1':

					$gArr = array('v31_to_v32_sql.txt', 'v32_to_v33_sql.txt', 'v33_to_v34_sql.txt', 'v34_to_v35_sql.txt', 'v35_to_v36_sql.txt', 'v36_to_v37_sql.txt', 'v37_to_v38_sql.txt', 'v38_to_v39_sql.txt', 'v39_to_v395_sql.txt', 'v395_to_v4_sql.txt', 'v40_to_v41_sql.txt', 'v41_to_v42_sql.txt', 'v42_to_v43_sql.txt', 'v43_to_v44_sql.txt', 'v44_to_v45_sql.txt', 'v45_to_v46_sql.txt', 'v46_to_v47_sql.txt', 'v47_to_v48_sql.txt', 'v48_to_v49_sql.txt', 'v49_to_v495_sql.txt', 'v495_to_v499_sql.txt', 'v499_to_v500_sql.txt');

					break;

				case '3.2':

					$gArr = array('v32_to_v33_sql.txt', 'v33_to_v34_sql.txt', 'v34_to_v35_sql.txt', 'v35_to_v36_sql.txt', 'v36_to_v37_sql.txt', 'v37_to_v38_sql.txt', 'v38_to_v39_sql.txt', 'v39_to_v395_sql.txt', 'v395_to_v4_sql.txt', 'v40_to_v41_sql.txt', 'v41_to_v42_sql.txt', 'v42_to_v43_sql.txt', 'v43_to_v44_sql.txt', 'v44_to_v45_sql.txt', 'v45_to_v46_sql.txt', 'v46_to_v47_sql.txt', 'v47_to_v48_sql.txt', 'v48_to_v49_sql.txt', 'v49_to_v495_sql.txt', 'v495_to_v499_sql.txt', 'v499_to_v500_sql.txt');

					break;

				case '3.3':

					$gArr = array('v33_to_v34_sql.txt', 'v34_to_v35_sql.txt', 'v35_to_v36_sql.txt', 'v36_to_v37_sql.txt', 'v37_to_v38_sql.txt', 'v38_to_v39_sql.txt', 'v39_to_v395_sql.txt', 'v395_to_v4_sql.txt', 'v40_to_v41_sql.txt', 'v41_to_v42_sql.txt', 'v42_to_v43_sql.txt', 'v43_to_v44_sql.txt', 'v44_to_v45_sql.txt', 'v45_to_v46_sql.txt', 'v46_to_v47_sql.txt', 'v47_to_v48_sql.txt', 'v48_to_v49_sql.txt', 'v49_to_v495_sql.txt', 'v495_to_v499_sql.txt', 'v499_to_v500_sql.txt');

					break;

				case '3.4':

					$gArr = array('v34_to_v35_sql.txt', 'v35_to_v36_sql.txt', 'v36_to_v37_sql.txt', 'v37_to_v38_sql.txt', 'v38_to_v39_sql.txt', 'v39_to_v395_sql.txt', 'v395_to_v4_sql.txt', 'v40_to_v41_sql.txt', 'v41_to_v42_sql.txt', 'v42_to_v43_sql.txt', 'v43_to_v44_sql.txt', 'v44_to_v45_sql.txt', 'v45_to_v46_sql.txt', 'v46_to_v47_sql.txt', 'v47_to_v48_sql.txt', 'v48_to_v49_sql.txt', 'v49_to_v495_sql.txt', 'v495_to_v499_sql.txt', 'v499_to_v500_sql.txt');

					break;

				case '3.5':

					$gArr = array('v35_to_v36_sql.txt', 'v36_to_v37_sql.txt', 'v37_to_v38_sql.txt', 'v38_to_v39_sql.txt', 'v39_to_v395_sql.txt', 'v395_to_v4_sql.txt', 'v40_to_v41_sql.txt', 'v41_to_v42_sql.txt', 'v42_to_v43_sql.txt', 'v43_to_v44_sql.txt', 'v44_to_v45_sql.txt', 'v45_to_v46_sql.txt', 'v46_to_v47_sql.txt', 'v47_to_v48_sql.txt', 'v48_to_v49_sql.txt', 'v49_to_v495_sql.txt', 'v495_to_v499_sql.txt', 'v499_to_v500_sql.txt');

					break;

				case '3.6':

					$gArr = array('v36_to_v37_sql.txt', 'v37_to_v38_sql.txt', 'v38_to_v39_sql.txt', 'v39_to_v395_sql.txt', 'v395_to_v4_sql.txt', 'v40_to_v41_sql.txt', 'v41_to_v42_sql.txt', 'v42_to_v43_sql.txt', 'v43_to_v44_sql.txt', 'v44_to_v45_sql.txt', 'v45_to_v46_sql.txt', 'v46_to_v47_sql.txt', 'v47_to_v48_sql.txt', 'v48_to_v49_sql.txt', 'v49_to_v495_sql.txt', 'v495_to_v499_sql.txt', 'v499_to_v500_sql.txt');

					break;

				case '3.7':

					$gArr = array('v37_to_v38_sql.txt', 'v38_to_v39_sql.txt', 'v39_to_v395_sql.txt', 'v395_to_v4_sql.txt', 'v40_to_v41_sql.txt', 'v41_to_v42_sql.txt', 'v42_to_v43_sql.txt', 'v43_to_v44_sql.txt', 'v44_to_v45_sql.txt', 'v45_to_v46_sql.txt', 'v46_to_v47_sql.txt', 'v47_to_v48_sql.txt', 'v48_to_v49_sql.txt', 'v49_to_v495_sql.txt', 'v495_to_v499_sql.txt', 'v499_to_v500_sql.txt');

					break;

				case '3.8':

					$gArr = array('v38_to_v39_sql.txt', 'v39_to_v395_sql.txt', 'v395_to_v4_sql.txt', 'v40_to_v41_sql.txt', 'v41_to_v42_sql.txt', 'v42_to_v43_sql.txt', 'v43_to_v44_sql.txt', 'v44_to_v45_sql.txt', 'v45_to_v46_sql.txt', 'v46_to_v47_sql.txt', 'v47_to_v48_sql.txt', 'v48_to_v49_sql.txt', 'v49_to_v495_sql.txt', 'v495_to_v499_sql.txt', 'v499_to_v500_sql.txt');

					break;

				case '3.9':

					$gArr = array('v39_to_v395_sql.txt', 'v395_to_v4_sql.txt', 'v40_to_v41_sql.txt', 'v41_to_v42_sql.txt', 'v42_to_v43_sql.txt', 'v43_to_v44_sql.txt', 'v44_to_v45_sql.txt', 'v45_to_v46_sql.txt', 'v46_to_v47_sql.txt', 'v47_to_v48_sql.txt', 'v48_to_v49_sql.txt', 'v49_to_v495_sql.txt', 'v495_to_v499_sql.txt', 'v499_to_v500_sql.txt');

					break;

				case '3.95':

					$gArr = array('v395_to_v4_sql.txt', 'v40_to_v41_sql.txt', 'v41_to_v42_sql.txt', 'v42_to_v43_sql.txt', 'v43_to_v44_sql.txt', 'v44_to_v45_sql.txt', 'v45_to_v46_sql.txt', 'v46_to_v47_sql.txt', 'v47_to_v48_sql.txt', 'v48_to_v49_sql.txt', 'v49_to_v495_sql.txt', 'v495_to_v499_sql.txt', 'v499_to_v500_sql.txt');

					break;

				case '4.0':

					$gArr = array('v40_to_v41_sql.txt', 'v41_to_v42_sql.txt', 'v42_to_v43_sql.txt', 'v43_to_v44_sql.txt', 'v44_to_v45_sql.txt', 'v45_to_v46_sql.txt', 'v46_to_v47_sql.txt', 'v47_to_v48_sql.txt', 'v48_to_v49_sql.txt', 'v49_to_v495_sql.txt', 'v495_to_v499_sql.txt', 'v499_to_v500_sql.txt');

					break;

				case '4.1':

					$gArr = array('v41_to_v42_sql.txt', 'v42_to_v43_sql.txt', 'v43_to_v44_sql.txt', 'v44_to_v45_sql.txt', 'v45_to_v46_sql.txt', 'v46_to_v47_sql.txt', 'v47_to_v48_sql.txt', 'v48_to_v49_sql.txt', 'v49_to_v495_sql.txt', 'v495_to_v499_sql.txt', 'v499_to_v500_sql.txt');

					break;

				case '4.2':

					$gArr = array('v42_to_v43_sql.txt', 'v43_to_v44_sql.txt', 'v44_to_v45_sql.txt', 'v45_to_v46_sql.txt', 'v46_to_v47_sql.txt', 'v47_to_v48_sql.txt', 'v48_to_v49_sql.txt', 'v49_to_v495_sql.txt', 'v495_to_v499_sql.txt', 'v499_to_v500_sql.txt');

					break;

				case '4.3':

					$gArr = array('v43_to_v44_sql.txt', 'v44_to_v45_sql.txt', 'v45_to_v46_sql.txt', 'v46_to_v47_sql.txt', 'v47_to_v48_sql.txt', 'v48_to_v49_sql.txt', 'v49_to_v495_sql.txt', 'v495_to_v499_sql.txt', 'v499_to_v500_sql.txt');

					break;

				case '4.4':

					$gArr = array('v44_to_v45_sql.txt', 'v45_to_v46_sql.txt', 'v46_to_v47_sql.txt', 'v47_to_v48_sql.txt', 'v48_to_v49_sql.txt', 'v49_to_v495_sql.txt', 'v495_to_v499_sql.txt', 'v499_to_v500_sql.txt');

					break;

				case '4.5':

					$gArr = array('v45_to_v46_sql.txt', 'v46_to_v47_sql.txt', 'v47_to_v48_sql.txt', 'v48_to_v49_sql.txt', 'v49_to_v495_sql.txt', 'v495_to_v499_sql.txt', 'v499_to_v500_sql.txt');

					break;

				case '4.6':

					$gArr = array('v46_to_v47_sql.txt', 'v47_to_v48_sql.txt', 'v48_to_v49_sql.txt', 'v49_to_v495_sql.txt', 'v495_to_v499_sql.txt', 'v499_to_v500_sql.txt');

					break;

				case '4.7':

					$gArr = array('v47_to_v48_sql.txt', 'v48_to_v49_sql.txt', 'v49_to_v495_sql.txt', 'v495_to_v499_sql.txt', 'v499_to_v500_sql.txt');

					break;

				case '4.8':

					$gArr = array('v48_to_v49_sql.txt', 'v49_to_v495_sql.txt', 'v495_to_v499_sql.txt', 'v499_to_v500_sql.txt');

					break;

				case '4.9':

					$gArr = array('v49_to_v495_sql.txt', 'v495_to_v499_sql.txt', 'v499_to_v500_sql.txt');

					break;

				case '4.95':

					$gArr = array('v495_to_v499_sql.txt', 'v499_to_v500_sql.txt');

					break;

				case '4.99':

					$gArr = array('v499_to_v500_sql.txt');

					break;

				case '5.00':

					$tempInfo .= adminInfov5('Yazılım sürümünüz güncel. <strong>(v' . siteConfig('version') . ')</strong>');

					break;

				default:

					$tempInfo .= adminErrorv3('Desteklenmeyen yazılım sürümü (v' . siteConfig('version') . '). Otomatik güncelleme modülü için, bir önceki sürümünüzün v3.0 ve üzeri olması gerekmektedir.<br><a href="http://sorular.utopiayazilim.com/page.php?act=kategoriGoster&katID=322">Sorguları manuel çalıştırmak için bu siteyi ziyaret edin.</a>.');

					break;

			}





			if (is_array($gArr)) {

				updateTLang();

				require_once('../doc/import-lib.php');

				foreach ($gArr as $file) {

					$gi = 0;

					if (mysql_import('../doc/sql/' . $file)) {

						$tempInfo .= adminInfov5($file . ' sorgusu başarıyla çalıştırıldı.');

						$gi++;

					}

				}

				$tempInfo .= adminInfov5('Toplam ' . $gi . ' sorgu başarıyla çalıştırıldı.');



				changeDirToUTF8('../templates/system/email/');

				$tempName = siteConfig('templateName');

				changeDirToUTF8('../templates/' . $tempName);

				changeDirToUTF8('../templates/' . $tempName . '/systemDefault');

				changeDirToUTF8('../templates/' . $tempName . '/blocks');

				@unlink('../templates/' . $tempName . '/blocks/SepetBlock.php');

				@mkdir('../images/gallery/');



				/*

					setAllSEOFields('urun','name');

					setAllSEOFields('kategori','name');

					setAllSEOFields('marka','name');

					setAllSEOFields('makalekategori','name');

					setAllSEOFields('makaleler','baslik');

					setAllSEOFields('haberler','baslik');

					setAllSEOFields('pages','title');

					*/



				my_mysql_query("delete from stats where k like 'urunhit_%'");

				my_mysql_query("update user set password = md5(password) where length(password) < 30");



				delTree('include/3rdparty/PHPMailer-master/examples/');

				delTree('include/3rdparty/PHPMailer-master/test/');

				delTree('include/3rdparty/PHPMailer-master/docs/');



				$tempInfo .= adminInfov5('Toplam <strong>' . (int) $editUTF8OK . '</strong> dosya encode UTF-8 olarak güncellendi. Kontrol edilen <strong>' . (int) $editUTF8Skip . '</strong> dosya zaten UTF-8 olduğundan güncellenmedi.');

				//	$tempInfo.=adminInfov5('Güncel dil dosyası kontrolü için <a href="s.php?f=teknik.php&act=update-lang"><strong>tıklayın.</strong></a>');

				$tempInfo .= adminInfov5('Şablon dizinideki pasif olan diğer şablonların UTF-8 encode kontrolü için <a href="s.php?f=teknik.php&act=temp-2-utf8"><strong>tıklayın.</strong></a>');

			}

			//	mysql_query("DELETE FROM adminmenu WHERE ID NOT IN (SELECT * FROM (SELECT MAX(n.ID) FROM adminmenu n where n.Aktif = 1 AND n.parentID = adminmenu.parentID GROUP BY n.Adi) x)") or die(mysql_error());

			break;

	}

	echo v5Admin::adminHeader();

	if ($_GET['act'] == 'query') {

		echo v5Admin::fullBlock('Veri tabanı Sorgusu', sqlQueryWindow()) . '<div class="clear-space">&nbsp;</div>';

		unset($tempInfo);

	}

	if ($_GET['act'] == 'updatepics-google' || $_GET['act'] == 'updatepics-bing') {

		echo v5Admin::fullBlock('Resim Güncelle', noPicCatList()) . '<div class="clear-space">&nbsp;</div>';

		unset($tempInfo);

	}

	echo v5Admin::fullBlock('Teknik İşlemler', teknik());

	if ($_GET['act'])

		cleancache();

}



function noPicCatList()

{

	global $tempInfo, $pout;

	$q = my_mysql_query("select * from kategori where active = 1 order by namePath");

	$select = '<select name="catID"  class="teknik-select form-control input-lg mb-md">';

	$totals = 0;

	while ($d = my_mysql_fetch_array($q)) {

		$total = hq("select count(*) from urun,kategori where urun.active = 1 AND kategori.active = 1 AND urun.catID=kategori.ID AND urun.resim = '' AND (urun.catID = '" . $d['ID'] . "' OR urun.showCatIDs like '%|" . $d['ID'] . "|%')");

		$totals += $total;

		if ($total)

			$select .= '<option value="' . $d['ID'] . '" ' . ($d['ID'] == $_POST['catID'] ? 'selected' : '') . '>' . $d['namePath'] . ' (' . $total . ')</option>' . "\n";

	}

	$select .= '</select>';

	if (!$totals)

		$select = 'Resimsiz ürün bulunamadı.';



	$out = '	<form method="post" action="" class="form-horizontal form-bordered">

			' . v5Admin::simpleFormGroup('Resimsiz Ürün Kategorileri', $pout . ' ' . $select) . '			

			' . v5Admin::simpleFormFooter('Resimleri Güncelle') . '



	</form>';

	$tempInfo .= adminInfov5('Resim olmayan <strong>' . (int) $totals . '</strong> ürün bulundu.');

	return $out;

}



function webpConvert2($file, $compression_quality = 80,$d)

{

	global $tempInfo;

    // check if file exists

    if (!file_exists($file)) {

        return false;

    }

    $file_type = exif_imagetype($file);

    //https://www.php.net/manual/en/function.exif-imagetype.php

    //exif_imagetype($file);

    // 1    IMAGETYPE_GIF

    // 2    IMAGETYPE_JPEG

    // 3    IMAGETYPE_PNG

    // 6    IMAGETYPE_BMP

    // 15   IMAGETYPE_WBMP

    // 16   IMAGETYPE_XBM

	$ea = explode('.',basename($file));

	array_pop($ea);

	$filename = implode('.',$ea);

    $output_file =  '../images/urunler/'.$filename . '.webp';

    if (file_exists($output_file)) {

        return $output_file;

    }

    if (function_exists('imagewebp')) {

        switch ($file_type) {

            case '1': //IMAGETYPE_GIF

                $image = imagecreatefromgif($file);

                break;

            case '2': //IMAGETYPE_JPEG

                $image = imagecreatefromjpeg($file);

                break;

            case '3': //IMAGETYPE_PNG

                    $image = imagecreatefrompng($file);

                    imagepalettetotruecolor($image);

                    imagealphablending($image, true);

                    imagesavealpha($image, true);

                    break;

            case '6': // IMAGETYPE_BMP

                $image = imagecreatefrombmp($file);

                break;

            case '15': //IMAGETYPE_Webp

               return $output_file;

                break;

            case '16': //IMAGETYPE_XBM

                $image = imagecreatefromxbm($file);

                break;

            default:

				$tempInfo.=adminError($file.' Hatalı ürün formatı.');

                return false;

        }

        // Save the image

        $result = imagewebp($image, $output_file, $compression_quality);

        if (false === $result) {

			$tempInfo.=adminError($file.' Resim kayıt hatası.');

            return false;

        }

        // Free up memory

        imagedestroy($image);

        return $output_file;

    } elseif (class_exists('Imagick')) {

        $image = new Imagick();

        $image->readImage($file);

        if ($file_type === "3") {

            $image->setImageFormat('webp');

            $image->setImageCompressionQuality($compression_quality);

            $image->setOption('webp:lossless', 'true');

        }

        $image->writeImage($output_file);

        return $output_file;

    }

	$tempInfo.=adminError($file.' Sunucunuzda imagewebp bulunmuyor.');

    return false;

}



function sqlQueryWindow()

{

	$out = '<form method="post" id="SQLQuery" action="">

		<div class="st-form-line">	

        	<span class="st-labeltext">SQL Query : </span><br /><br />

			<textarea class="form-control" rows="30" name="query"></textarea>

		</div>

		' . v5Admin::simpleFormFooter() . '

	</form>';

	return $out;

}



function teknik()

{

	$tArray = array(

		'query' => 'Veri tabanı sorgusu çalıştır',

		'update' => 'Sürüm güncelleme kontrolünü çalıştır',

		'update-lang' => 'Dil güncelleme kontrolünü çalıştır',

		'temp-2-utf8' => 'Şablon dosyası encode düzenle',

		'utf8-bom' => 'UTF-8 BOM veya hatalı PHP başlangıç olan dosyaları göster',

		'repair-seo' => 'SEO URLleri düzenle',

		'repair-basket' => 'Sepet durumlarını güncelle',

		'repairdb' => 'Veritabanını tamir et',

		'optimizedb' => 'Veritabanını optimize et',

		'breadcrumb' => 'Breadcrumb güncelle',

		'var-filter' => 'Ürün varyasyonları, filtreler ile eşitle',

		'remove-empty-cats' => 'Ürünü olmayan kategorileri gizle',

		'updatev3stocks' => 'Ürün v3 varyasyonlarını, v4 varyasyon yapısı ile güncelle',

		'updatestocks' => 'Ürün stoklarını, varyasyon stoklar ile eşitle',

		'updatevarstocks' => 'Olmayan varyason stoklarını, ürün stoğu baz alarak olarak ekle',

		'updateproductIDs' => 'Ürün IDlerini sıfırla (API/XML kullanımında çalıştırılmamalıdır.)',

		'updateproductnames' => 'Ürün başlıklarını düzenle (Ör : İlk Harfleri Büyük Ürün)',

		'updateproductprices' => 'Ürün fiyatlarını yuvarla (Kuruşları kaldırır.)',

		'updateproductsales' => 'Ürün satış adet alanlarını güncelle',

		'cleanproduct' => 'Aynı ürünleri temizle',

		'cleanvars' => 'Gereksiz varyasyon girişlerini temizle',

		'cleancat' => 'Aynı kategorileri temizle',

		'cleanbrand' => 'Aynı markaları temizle',

		'fixgtin' => 'GTIN girilmeyen ürün / varyasyonlara, rastgele GTIN değeri yükle',

		'fixgtin2' => 'Tüm ürün / varyasyonlara, rastgele GTIN değeri yükle',

		'fixbrand' => 'Markasız ürünleri düzenle',

		'emptycats' => 'Ürünsüz kategorileri pasif et',

		'resizepics' => 'Ürün büyük resimleri boyutlandır (1000px)',

		'convertpics' => 'Ürün kaynak resimlerini webp formatına dönüştür',

		'brokenpics' => 'Hatalı resimleri sil',

		'seopics' => 'Ürün resim adlarını SEO ya uygun güncelle',

		'cleanpics' => 'Kullanılmayan resimleri sil',

		'passivepics' => 'Resmi olmayan ürünleri pasif et',

		'allpics' => 'Resim klasörünü boşalt',

		'cleanimagecache' => 'Resim Cache i sil',

		'updateuserorder' => 'Tüm Kullanıcı Cirolarını Güncelle',

		'emaillogclean' => 'E-Posta Loglarını Sil',

		'cronjoblogview' => 'Cron-Job Log Göster',

		'updatepics-google' => 'Resimsiz ürünleri güncelle (Google Images - Manuel)',

		'updatepics-googleall' => 'Resimsiz ürünleri güncelle (Google Images - Otomatik)',



		//'updatepics-bing'=>'Resimsiz ürünleri güncelle (Bing Images - Manuel)',

		//'updatepics-bingall'=>'Resimsiz ürünleri güncelle (Bing Images - Otomatik)',



	);

	uasort($tArray,"Ascending");

	$out = '<div class="button-box"><table class="teknik-table"><tr><td><select id="teknik" class="form-select"><option value="">Lütfen işlemi seçin </option>';

	foreach ($tArray as $k => $v) {

		$out .= "<option value='$k' " . ($k == $_GET['act'] ? 'selected' : '') . ">$v</option>\n";

	}

	$out .= '</select></td><td>&nbsp;</td><td>' . v4Admin::simpleButton('#', 'window.location.href = \'s.php?f=teknik.php&act=\'+$(\'#teknik\').val();', 'btn-primary', 'Gönder', '_self') . '</td></tr></table></div>';

	return $out;

}



function Ascending($a, $b) {   

	static $charOrder = array('a', 'b', 'c', 'ç', 'd', 'e', 'f', 'g', 'ğ', 'h', 'ı', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'ö', 'p', 'r', 's', 'ş','t', 'u', 'ü', 'v', 'y', 'z');



    $a = mb_strtolower($a);

    $b = mb_strtolower($b);



    for($i=0;$i<mb_strlen($a) && $i<mb_strlen($b);$i++) {

        $chA = mb_substr($a, $i, 1);

        $chB = mb_substr($b, $i, 1);

        $valA = array_search($chA, $charOrder);

        $valB = array_search($chB, $charOrder);

        if($valA == $valB) continue;

        if($valA > $valB) return 1;

        return -1;

    }



    if(mb_strlen($a) == mb_strlen($b)) return 0;

    if(mb_strlen($a) > mb_strlen($b))  return -1;

    return 1;

}  



function generateRandomEANCode()

{

	$time = rand(1000000000, 9999999999);



	$code = '20' . str_pad($time, 10, '0');

	$weightflag = true;

	$sum = 0;



	for ($i = strlen($code) - 1; $i >= 0; $i--) {

		$sum += (int)$code[$i] * ($weightflag ? 3 : 1);

		$weightflag = !$weightflag;

	}

	$code .= (10 - ($sum % 10)) % 10;

	return $code;

}



function generateRandomEANCode2()

{

	$no = rand(0, 999999999999);

	$no = str_pad($no, 12, "0", STR_PAD_LEFT);

	return $no;

}



function generateRandomEAN($number)

{

	$code = '8697204' . str_pad($number, 4, '0');

	$weightflag = true;

	$sum = 0;

	// Weight for a digit in the checksum is 3, 1, 3.. starting from the last digit. 

	// loop backwards to make the loop length-agnostic. The same basic functionality 

	// will work for codes of different lengths.

	for ($i = strlen($code) - 1; $i >= 0; $i--) {

		$sum += (int) $code[$i] * ($weightflag ? 3 : 1);

		$weightflag = !$weightflag;

	}

	$code .= (10 - ($sum % 10)) % 10;

	return $code;

}



function updateTLang()

{

	my_mysql_query("ALTER TABLE `lang` ADD UNIQUE(`ID`)");

	my_mysql_query("ALTER TABLE `lang` CHANGE `ID` `ID` INT(11) NOT NULL AUTO_INCREMENT");



	global $tempInfo;

	$url = 'https://v5.shopphpdemo.com/langxml.php';

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);

	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 5);

	curl_setopt($ch, CURLOPT_TIMEOUT, 59);

	$result = curl_exec($ch);

	curl_close($ch);



	$open = simplexml_load_string($result);

	$dili = 0;

	foreach ($open->dil as $dil) {

		$dil->xkey = trim($dil->xkey);

		if (!$dil->xkey)

			continue;



		if (!hq("select ID from lang where `key` like '" . $dil->xkey . "'")) {

			$dil->xvalue = htmlspecialchars_decode(trim($dil->xvalue));

			my_mysql_query("INSERT INTO `lang` (`ID`, `key`, `code`, `value`) VALUES (null, '" . $dil->xkey . "', 'TR', '" . addslashes($dil->xvalue) . "')");

			$tempInfo .= adminInfov5('Dil veri tabanında ' . $dil->xkey . ' olmadığından <xmp>' . $dil->xvalue . '</xmp> değeri ile eklendi.');

			$dili++;

		}

	}

	if ($dili)

		$tempInfo .= adminInfov5('Dil güncelleme kontrolü tamamlandı. Veritabanında bulunmayan toplam ' . $dili . ' satır eklendi.');

	else

		$tempInfo .= adminInfov5('Dil güncelleme kontrolü tamamlandı. Veritabanında eksik dil satırı bulunmuyor.');

}

