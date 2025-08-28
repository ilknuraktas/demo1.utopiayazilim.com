<?php
$title = 'XML Ayarları';
$altDizinAc = (!ini_get('safe_mode')); // True olabilmesi için sunucu safe mode off olması gerekir.
$altDizinAc = false;
$dynamicDownload = true;

if (isset($_GET['dilim']) && $shopphp_demo)
	exit('XMLUpdateOK');
if ($_GET['indexResim'] || $_POST['indexResim'])
	$_GET['indexKatalog'] = $_POST['indexKatalog'] = 1;

$_SESSION['xmlLog'] = '';
$_SESSION['XML_urun_guncellenen'] = 0;
$_SESSION['XML_urun_eklenen'] = 0;
$_SESSION['XML_marka_guncellenen'] = 0;
$_SESSION['XML_marka_eklenen'] = 0;
$_SESSION['XML_kategori_guncellenen'] = 0;
$_SESSION['XML_kategori_eklenen'] = 0;
$_SESSION['XML_fiyatstok_guncellenen'] = 0;
$_SESSION['XML_kar'] = '';
$_SESSION['marka'] = '';

if (isset($_GET['dilim']) && (int) $_GET['dilim'] == 0) {
	clearTemp('xmlFile');
	clearTemp('xmlLog');
	clearTemp('xmlKatalog');
	clearTemp('xmlStok');
	clearTemp('xmlKategoriler');
	clearTemp('xmlUrunler');
	clearTemp('xmlMarkalar');
	my_mysql_query("update temp set text = '' where code like 'XML_%'");
	insertTemp('xmlLog', 'XML İstatsitkleri Sıfılrandı.' . ".\n");
}

if ($_GET['xmlCatCache'])
	my_mysql_query("update xmlcatcache set up = '0' where dosya like '" . $_GET['dosya'] . "'");

$_GET['kar'] = str_replace(',', '.', $_GET['kar']);
function getCodeFromName($n)
{
	return substr(md5($n), 0, 10);
}

function xmlCatCacheCats($parentID, $level)
{
	global $shopphp_demo;
	if($shopphp_demo) return;
	$out = '';
	if (!$level)
		$out .= '<div id="treeCheckbox">';
	$out .= '<ul>';
	$q = my_mysql_query("select * from xmlcatcache where dosya like '" . $_GET['dosya'] . "' AND parentID = '$parentID' AND up=1");
	while ($d = my_mysql_fetch_array($q)) {
		$out .= '<li value="' . $d['ID'] . '" data-jstree=\'{  "type" : "file","opened" : true ' . ($d['active'] ? ',"selected" : true' : '') . ' }\'>' . $d['name'] . selectCat($d['ID'], 1) . '' . "\n";
		$out .= xmlCatCacheCats($d['ID'], ($level + 1));
		$out .= '</li>';
	}

	$out .= '</ul>';
	if (!$level)
		$out .= '</div>';
	return $out;
}

function xmlSetDefault()
{
	my_mysql_query("update xmlcatcache set active = 1,remoteID=0 where dosya like '" . $_GET['dosya'] . "'");
}

function xmlRemove()
{
	$_GET['dosya'] = str_replace(array('..', '/', '\\'), '', $_GET['dosya']);
	require('XML/' . basename($_GET['dosya']));
	$q = my_mysql_query("select * from urun where tedarikciID = '$bayiID' AND tedarikciID != ''");

	while ($d = my_mysql_fetch_array($q)) {
		for ($i = 1; $i <= 10; $i++) {
			$check = 'resim' . ($i > 1 ? $i : '');
			if ($d[$check]) {
				unlink('../images/urunler/' . $d[$check]);
				unlink('../../images/urunler/' . $d[$check]);
			}
		}
	}

	my_mysql_query("delete from urun where tedarikciID = '$bayiID' AND tedarikciID != ''");
	my_mysql_query("delete from kategori where tedarikciID = '$bayiID' AND tedarikciID != ''");
}

function spGetURL($url, $post = false, $pass = false)
{
	global $bayiname;
	$fileName = 'bot-' . $bayiname . '-' . substr(md5($post . '_' . $url), 0, 10) . '-' . date('Y-m-d') . '.cache';
	if (!file_exists('bayiXML/' . $fileName)) {
		define('USER_AGENT', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.2309.372 Safari/537.36');
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		if ($pass)
			curl_setopt($curl, CURLOPT_USERPWD, $pass);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_USERAGENT, USER_AGENT);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		if ($post)
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
		$result = curl_exec($curl);
		dosyayaz('bayiXML/' . $fileName, $result);
	} else
		$result = file_get_contents('bayiXML/' . $fileName);
	curl_close($curl);
	return $result;
}

function getImageExt($file)
{
	list($file) = explode('?', $file);
	$extArray = array('jpg', 'jpeg', 'gif', 'png', 'bmp');
	$out = strtolower(pathinfo($file, PATHINFO_EXTENSION));
	return (in_array($out, $extArray) ? $out : 'jpg');
}


function utf82html($str)
{
	$search = array();
	$search[] = "/&#228;/";
	$search[] = "/&#246;/";
	$search[] = "/&#252;/";
	$search[] = "/&#196;/";
	$search[] = "/&#214;/";
	$search[] = "/&#220;/";
	$search[] = "/&#223;/";
	$search[] = "/&#199;/";
	$search[] = "/&#39;/";

	$replace = array();
	$replace[] = "ä";
	$replace[] = "ö";
	$replace[] = "ü";
	$replace[] = "Ä";
	$replace[] = "Ö";
	$replace[] = "ü";
	$replace[] = "ß";
	$replace[] = "Ç";
	$replace[] = "'";

	$str = preg_replace($search, $replace, $str);

	return $str;
}

function selectCat($id, $s)
{
	$out = "<select id='s_$id' class='form-select catCacheSelect " . ($s ? 'autoload' : '') . "'>";
	$out .= "<option value='0'>Yeni Kategori</option>";
	$tedarikciCode = hq("select tedarikciCode from xmlcatcache where ID = '$id'");
	$tedarikciID = hq("select tedarikciID from xmlcatcache where ID = '$id'");
	$remoteID = hq("select remoteID from xmlcatcache where ID = '$id'");
	if ($remoteID)
		$q = my_mysql_query("select ID,name,namePath,tedarikciCode,tedarikciID from kategori " . ($s && $tedarikciCode && $tedarikciID ? 'where (ID = \'' . $remoteID . '\') ' : '') . " order by namePath");
	else
		$q = my_mysql_query("select ID,name,namePath,tedarikciCode,tedarikciID from kategori " . ($s && $tedarikciCode && $tedarikciID ? 'where (tedarikciCode like \'' . $tedarikciCode . '\' AND tedarikciID=\'' . $tedarikciID . '\') ' : '') . " order by namePath");
	while ($d = my_mysql_fetch_array($q)) {
		if ($remoteID)
			$opt .= '<option ' . (hq("select remoteID from xmlcatcache where ID = '$id'") == $d['ID'] || ($remoteID == $d['ID']) ? 'selected="selected"' : '') . ' value="' . $d['ID'] . '">' . $d['namePath'] . '</option>' . "\r\n";
		else
			$opt .= '<option ' . (hq("select remoteID from xmlcatcache where ID = '$id'") == $d['ID'] || ($tedarikciID && $tedarikciCode && $tedarikciCode == $d['tedarikciCode'] && $tedarikciID == $d['tedarikciID']) ? 'selected="selected"' : '') . ' value="' . $d['ID'] . '">' . $d['namePath'] . '</option>' . "\r\n";
		$set = $d['name'];
	}
	if ($s)
		return "<div class='catCacheRow'><div id='s_$id' class='catCacheSelect " . ($s ? 'autoload' : '') . "'>" . ($set ? $set : 'Yeni Kategori') . "</div></div>";
	$out .= $opt;
	$out .= '</select>';
	return $out;
}

function insertTemp($code, $text)
{
	$_SESSION[$code] .= utf8fix($text);
	if (@$_GET['debug-cat'] || @$_GET['debug-xml'] || @$_GET['debug-fiyat']) echo utf8fix($text) . '<br />';
}

function clearTemp($code)
{
	$code = addslashes($code);
	$_SESSION[$code] = '';
	my_mysql_query("update temp set text = '' where code like '$code'");
}

function getTemp($code)
{
	$code = addslashes($code);
	return hq("select text from temp where code like '$code'");
}

function donguDurdur($toplam, $simdi, $dilim)
{
	global $xmldilim;
	$oran = $xmldilim;
	$toplam += 10;
	if (!$oran)
		$oran = 10;
	if (isset($_GET['xmlCatCache']))
		return 'ok';
	$s = ($toplam / $oran);
	$basla = (($s * $dilim) - 2);
	$bitis = (($basla + $s) + 2);
	if ($simdi < $basla) return 'continue';
	else if ($simdi > $bitis) return 'break';
	else return 'ok';
}

$fiyatStokKontrolQueryArray = array();
function fiyatStokKontrol($urunFiyat, $stok, $urunBirim, $urunCode, $piyasaFiyat = 0, $urunBayiFiyat = 0)
{
	return fiyatStokKontrolx($urunFiyat, $stok, $urunBirim, $urunCode, $piyasaFiyat, $urunBayiFiyat);
}

function fiyatStokKontrolx($urunFiyat, $stok, $urunBirim, $urunCode, $piyasaFiyat = 0, $urunBayiFiyat = 0)
{
	global $pazarArray, $bayiID;

	if (!$_SESSION['XML_fiyatstok_guncellenen'] && !(int) $_GET['dilim'] && $bayiID && $urunCode) {
		//my_mysql_query("update urun set stok = 0 where tedarikciID='$bayiID'");
	}

	$_SESSION['XML_fiyatstok_guncellenen']++;
	//if (hq("select noxml from urun where tedarikciCode = '$urunCode' AND tedarikciID = '$bayiID'"))
	//	return;

	$stopFiyat = false;
	$stopStok = false;
	$urunFiyat = (float)trim($urunFiyat);
	$stok = trim($stok);
	$urunBirim = trim($urunBirim);
	$urunCode = trim($urunCode);
	$piyasaFiyat = (float)trim($piyasaFiyat);
	$urunBayiFiyat = (float)trim($urunBayiFiyat);
	$filter = '';

	if (!@$_GET['indexFSFiyat'] && @$_GET['indexFSStok'])
		$stopFiyat = true;
	if (@$_GET['indexFSFiyat'] && !@$_GET['indexFSStok'])
		$stopStok = true;

	$urunBirim = ($urunBirim ? $urunBirim : 'TL');
	if (!$stopFiyat)
		$filter .= "fiyat = '$urunFiyat',fiyatBirim='$urunBirim',";


	$stok += (float)hq("select stoky from urun where tedarikciCode = '$urunCode' AND tedarikciID='$bayiID' limit 0,1");
	if (siteConfig('sepetAsimSuresi') > 100)
		$stok -= (float)hq("select sum(adet) from sepet where durum=0 AND urunID='" . hq("select ID from urun where tedarikciCode = '$urunCode' AND tedarikciID = '$bayiID' limit 0,1") . "'");
	if (!$stopStok)
		$filter .= "stok = '$stok',";
	if ($piyasaFiyat && !$stopFiyat)
		$filter .= "piyasafiyat = '$piyasaFiyat',";
	if ($urunBayiFiyat && !$stopFiyat)
		$filter .= "bayifiyat = '$urunBayiFiyat',";

	my_mysql_query("update urun set " . substr($filter, 0, -1) . " where tedarikciCode = '$urunCode' AND tedarikciID='$bayiID' limit 1");
	if (my_mysql_affected_rows()) {
		foreach ($pazarArray as $p) {
			my_mysql_query("update urun set $p=1 where tedarikciCode = '$urunCode' AND tedarikciID='$bayiID' limit 1");
		}
	}
	if ($stopFiyat)
		my_mysql_query("update urun set fiyat = '$urunFiyat',fiyatBirim='$urunBirim',bayifiyat = '$urunBayiFiyat',piyasafiyat = '$piyasaFiyat' where fiyat=0 AND  tedarikciCode = '$urunCode' AND tedarikciID='$bayiID' limit 1");

	insertTemp('xmlLog', "Fiyat / Stok - Kod : $urunCode Fiyat: $urunFiyat,Stok: $stok,Birim: $urunBirim,Piyasa F: $piyasaFiyat, Alış F: $urunBayiFiyat olarak güncelendi. \n");
}


function fiyatStokKontrolQuery($bayiID)
{
	return;
}

function filitreAutoKontrol($title, $str, $urunID = 0)
{
	if (!$title || !$str)
		return;
	$title = addslashes($title);
	$str = addslashes($str);
	$q = my_mysql_query("select * from filitre where baslik like '$title'");
	if (!my_mysql_num_rows($q)) {
		my_mysql_query("insert into filitre (baslik,icerik) values ('$title','$str')");
		$q = my_mysql_query("select * from filitre where baslik like '$title'");
	}
	$d = my_mysql_fetch_array($q);
	$ID = $d['ID'];
	$arr = explode("\n", $d['icerik']);
	$insert = true;
	$str = trim($str);
	foreach ($arr as $line) {
		$line = trim($line);
		if ($str == $line) {
			$insert = false;
			break;
		}
	}
	if ($insert) {
		$d['icerik'] .= "\n$str";
		my_mysql_query("update filitre set icerik = '" . addslashes(str_replace(',', '-', $d['icerik'])) . "' where ID='$ID' limit 1");
		insertTemp('xmlLog', $d['baslik'] . " filite alanına $str eklendi.\n");
	}
	if ($urunID) {
		my_mysql_query("update urun set filitre = concat(filitre,',[" . $ID . "::" . utf8fix($str) . "]') where ID='$urunID' AND filitre not like '%[" . $ID . "::" . utf8fix($str) . "]%' limit 1");
	}
}

function filitreKontrol($ID, $str, $urunID = 0)
{
	$q = my_mysql_query("select * from filitre where ID='$ID'");
	$d = my_mysql_fetch_array($q);
	$arr = explode("\n", $d['icerik']);
	$insert = true;
	$str = trim($str);
	foreach ($arr as $line) {
		$line = trim($line);
		if ($str == $line) {
			$insert = false;
			break;
		}
	}
	if ($insert) {
		$d['icerik'] .= "\n$str";
		my_mysql_query("update filitre set icerik = '" . addslashes(str_replace(',', '-', $d['icerik'])) . "' where ID='$ID' limit 1");
		insertTemp('xmlLog', $d['baslik'] . " filite alanına $str eklendi.\n");
	}
	if ($urunID) {
		my_mysql_query("update urun set filitre = concat(filitre,',[" . $ID . "::" . addslashes($str) . "]') where ID='$urunID' AND filitre not like '%[" . $ID . "::" . addslashes($str) . "]%' limit 1");
	}
}

function filitreDetayKontrol($title, $img, $det)
{
	$title = addslashes($title);
	$det = addslashes($det);

	$filitreID = hq("select ID from filitredetay where baslik like '$title' limit 0,1");
	if (!$filitreID) {
		my_mysql_query("insert into filitredetay (baslik,icerik) values('$title','" . addslashes($det) . "')");
		$filitreID = my_mysql_insert_id();
	} else {
		my_mysql_query("update filitredetay set baslik='$title',icerik='$det' where ID='$filitreID' limit 1");
	}
	if ($img) {
		$fn = 'filitre_' . $filitreID . '.jpg';
		if (!file_exists('../images/filitre/' . $fn)) {
			XMLdownloadFile($img, '../images/filitre/', $fn);
			my_mysql_query("update filitredetay set resim='$fn' where ID = '$filitreID' limit 1");
		}
	}
	//my_mysql_query("delete from filitredetay where baslik=''");
	//insertTemp('xmlLog',"$title (ID: $filitreID ) filite detayı güncellendi.\n");
	return $filitreID;
}

function XMLdownloadFileCheck($local_path, $newfilename)
{
	global $shopphp_demo;
	if ($shopphp_demo)
		return true;
	$cache_life = (3600);
	$filesize = filesize($local_path . $newfilename);
	list($x, $ext) = explode('.', $newfilename);
	$resimArray = array('jpg', 'gif', 'png', 'jpeg');
	if (in_array(strtolower($ext), $resimArray) && $filesize > 5000) return true;
	if (!$_GET['dilim'] && !siteConfig('cacheSuresi')) return false;

	/*
	if (in_array(strtolower($ext),$resimArray)) 
	{
		unlink($local_path.$newfilename);
		return true;	
	}
	 */
	$filemtime = @filemtime($local_path . $newfilename);
	if ((!(stristr($newfilename, '.jpg') === false) || !(stristr($newfilename, '.gif') === false)) && $filesize > 5000) return true;
	if (!$filemtime or (time() - $filemtime >= $cache_life) or $filesize < 5000) return false;
	return true;
}

function XMLURLFix($url)
{
	$url = trim($url);
	$find = array('ü', 'Ü', 'ö', 'Ö', 'ş', 'Ş', 'ç', 'Ç', 'ı', 'İ', 'ğ', 'Ğ', ' ');
	$replace = array('%c3%Bc', '%C3%9C', '%c3%b6', '%C3%96', '%c5%9f', '%C5%9E', '%c3%a7', '%C3%87', '%c4%b1', '%C4%B0', '%c4%9f', '%C4%9E', '%20');
	$yeni_url = str_replace($find, $replace, $url);
	return $yeni_url;
}

if ($_GET['indexResimMulti'])
	$resimMultiCCT = @curl_multi_init();

function XMLdownloadFile($file, $local_path, $newfilename)
{
	$file = XMLURLFix($file);
	if (!$file || !$newfilename) return;
	if (XMLdownloadFileCheck($local_path, $newfilename)) return false;

	global $copyFiles, $altDizinAc, $downloadType, $resimMultiCCT, $shopphp_demo;
	if ($shopphp_demo)
		return;
	$altDizinAc = false;

	if (!$_GET['indexResimMulti']) {
		if (strtolower($downloadType) == 'fsock') return XMLdownloadFile_Fsock($file, $local_path, $newfilename);
		if (strtolower($downloadType) == 'fgc') return XMLdownloadFile_FGC($file, $local_path, $newfilename);
		if (strtolower($downloadType) == 'copy') return XMLdownloadFile_Copy($file, $local_path, $newfilename);
		if (strtolower($downloadType) == 'fopen') return XMLdownloadFile_Fopen($file, $local_path, $newfilename);
		if ($copyFiles) return copyFile($file, $local_path, $newfilename);
	}

	$err_msg = '';
	if (!$_GET['f'])
		$local_path = str_replace('..', '.', $local_path);
	$out = fopen($local_path . $newfilename, 'wb');
	if ($out == false) {
		echo "Dosya " . $local_path . $newfilename . " açılamadı<br>";
		insertTemp('xmlLog', "Dosya (Curl) $file downloadx edilemedi.\n");
	}
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, true);
	curl_setopt($ch, CURLOPT_FILE, $out);
	//curl_setopt($ch, CURLOPT_HEADER, 0); 
	//curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
	curl_setopt($ch, CURLOPT_URL, $file);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1000);  //yeni ekledim
	//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //yeni ekledim
	//curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);   //yeni ekledim  

	if (!$_GET['indexResimMulti'] || !(stristr(strtolower($newfilename), '.xml') === false)) {
		curl_exec($ch);
		if (curl_error($ch)) {
			echo (adminWarnv3("Hata : " . curl_error($ch) . ' File : ' . $file));
			insertTemp('xmlLog', "Hata (Curl) : " . curl_error($ch) . ' File : ' . $file . "\n");
			curl_close($ch);
			return false;
		}
		curl_close($ch);

		$localFile = $local_path . $newfilename;
		$dosyaUzunlugu = filesize($localFile);
		insertTemp('xmlLog', "Dosya (Curl) $file ($localFile : " . $dosyaUzunlugu . ") byte download edildi.\n");
		if ($dosyaUzunlugu < 500) insertTemp('xmlLog', "Hata (Curl) Dosya $file ($localFile) download edildiği halde $dosyaUzunlugu byte uzunluğunda. Web alanınız dolmuş veya download adresi hatalı olabilir.\n");
	} else {
		curl_multi_add_handle($resimMultiCCT, $ch);
	}

	return true;
}

function XMLdownloadFile_FGC($file, $local_path, $newfilename)
{
	if (XMLdownloadFileCheck($local_path, $newfilename)) return false;
	$localFile = $local_path . $newfilename;
	$ctx = stream_context_create(array(
		'http' => array(
			'timeout' => 300
		)
	));

	if (!file_exists($localFile)) {
		fopen($localFile, 'w');
	}
	if (is_writable($localFile)) {
		if ($fp = fopen($localFile, 'w')) {
			fwrite($fp, file_get_contents($file, 0, $ctx));
			fclose($fp);
			$dosyaUzunlugu = filesize($localFile);
			insertTemp('xmlLog', "Dosya (FGS) $file ($localFile : " . $dosyaUzunlugu . ") byte download edildi.\n");
			if ($dosyaUzunlugu < 500) insertTemp('xmlLog', "Hata (FGS) Dosya $file ($localFile) download edildiği halde $dosyaUzunlugu byte uzunluğunda. Web alanınız dolmuş veya download adresi hatalı olabilir.\n");
		} else {
			insertTemp('xmlLog', "Dosya (FGS) '.$file.' download edilemedi (Açılan dosyaya yazılamadı).\n");
			return false;
		}
	}
	return true;
}

function XMLdownloadFile_Fopen($file, $local_path, $newfilename)
{
	if (XMLdownloadFileCheck($local_path, $newfilename)) return false;
	$localFile = $local_path . $newfilename;

	file_put_contents($localFile, fopen($file, 'r'));
	$dosyaUzunlugu = filesize($localFile);
	if ($dosyaUzunlugu) {
		$dosyaUzunlugu = filesize($localFile);
		insertTemp('xmlLog', "Dosya (Fopen) $file ($localFile : " . $dosyaUzunlugu . ") byte download edildi.\n");
		if ($dosyaUzunlugu < 500) insertTemp('xmlLog', "Hata (Fopen) Dosya $file ($localFile) download edildiği halde $dosyaUzunlugu byte uzunluğunda. Web alanınız dolmuş veya download adresi hatalı olabilir.\n");
	} else {
		insertTemp('xmlLog', "Dosya (Fopen) '.$file.' download edilemedi (Açılan dosyaya yazılamadı).\n");
		return false;
	}
	return true;
}

function XMLdownloadFile_Copy($file, $local_path, $newfilename)
{
	if (XMLdownloadFileCheck($local_path, $newfilename)) return false;
	$localFile = $local_path . $newfilename;
	if (copy($file, $localFile)) {
		$dosyaUzunlugu = filesize($localFile);
		insertTemp('xmlLog', "Dosya (Copy) $file ($localFile : " . $dosyaUzunlugu . ") byte download edildi.\n");
		if ($dosyaUzunlugu < 500) insertTemp('xmlLog', "Hata (Copy) Dosya $file ($localFile) download edildiği halde $dosyaUzunlugu byte uzunluğunda. Web alanınız dolmuş veya download adresi hatalı olabilir.\n");
	} else {
		insertTemp('xmlLog', "Dosya (Copy) '.$file.' download edilemedi (Açılan dosyaya yazılamadı).\n");
		return false;
	}
	return true;
}

function XMLdownloadFile_Fsock($file, $local_path, $newfilename)
{
	if (XMLdownloadFileCheck($local_path, $newfilename)) return false;

	global $copyFiles, $altDizinAc, $downloadType;
	$altDizinAc = false;
	if ((stristr($newfilename, '.txt') === false) && (stristr($newfilename, '.xml') === false) && $altDizinAc) {
		$subdir = substr(md5($newfilename), 0, 2);
		if (!is_dir($local_path . '/' . $subdir)) mkdir($local_path . '/' . $subdir, 777);
		@chmod($local_path . '/' . $subdir, 0777);
		$local_path .= '/' . $subdir . '/';
	}
	$remoteFile = $file;
	$localFile = $local_path . $newfilename;
	unlink($localFile);
	$url = parse_url($remoteFile);
	$host = $url['host'];
	$path = isset($url['path']) ? $url['path'] : '/';

	if (isset($url['query'])) {
		$path .= '?' . $url['query'];
	}

	$port = isset($url['port']) ? $url['port'] : '80';

	$fp = @fsockopen($host);

	// Header Info 
	$header = "GET $path HTTP/1.0\r\n";
	$header .= "Host: $host\r\n";
	$header .= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6\r\n";
	$header .= "Accept: */*\r\n";
	$header .= "Accept-Language: en-us,en;q=0.5\r\n";
	$header .= "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n";
	$header .= "Keep-Alive: 300\r\n";
	$header .= "Connection: keep-alive\r\n";


	$header .= "Referer: http://$host\r\n\r\n";

	$response = '';
	fputs($fp, $header);
	// Get the file content 
	while ($line = fread($fp, 4096)) {
		$response .= $line;
	}
	fclose($fp);

	// Remove Header Info 
	$pos = strpos($response, "\r\n\r\n");
	$response = substr($response, $pos + 4);

	// Save the file content 
	if (!file_exists($localFile)) {
		// Create the file, if it doesn't exist already 
		fopen($localFile, 'w');
	}
	if (is_writable($localFile)) {
		if ($fp = fopen($localFile, 'w')) {
			fwrite($fp, $response);
			fclose($fp);
			$dosyaUzunlugu = filesize($localFile);
			insertTemp('xmlLog', "Dosya (FSOCK) $file ($localFile : " . $dosyaUzunlugu . ") byte download edildi.\n");
			if ($dosyaUzunlugu < 500) insertTemp('xmlLog', "Hata (FSOCK) Dosya $file ($localFile) download edildiği halde $dosyaUzunlugu byte uzunluğunda. Web alanınız dolmuş veya download adresi hatalı olabilir.\n");
		} else insertTemp('xmlLog', "Dosya (FSOCK) '.$file.' download edilemedi (Açılan dosyaya yazılamadı).\n");
	} else insertTemp('xmlLog', "Dosya (FSOCK) '.$file.' download edilemedi (Dosya açılamadı).\n");
	return true;
}

if (!function_exists('iconv')) {
	function iconv($a, $b, $c)
	{
		return $c;
	}
}

function finishXMLImport()
{
	if ($_GET['act'] == 'xmlRemove' || basename($_SERVER['SCRIPT_FILENAME']) == 'ajax.php')
		return;
	if ($_GET['xmlCatCache'])
		exit('XMLUpdateOK');

	global $bayiID, $activeUrunArray, $resimMultiCCT, $xmldilim;
	if (!$xmldilim)
		$xmldilim = 10;

	if (!my_mysql_num_rows(my_mysql_query("select ID from temp where code like 'xmlLog'"))) my_mysql_query("insert into temp values(null,'xmlLog','')");

	insertTemp('xmlLog', ($_GET['dilim'] + 1) . ". bölüm tamamlandı.\n");

	$statsArray = array('XML_urun_guncellenen', 'XML_urun_eklenen', 'XML_marka_guncellenen', 'XML_marka_eklenen', 'XML_kategori_guncellenen', 'XML_kategori_eklenen', 'XML_fiyatstok_guncellenen');
	foreach ($statsArray as $stats) {
		if (!$_SESSION[$stats])
			$_SESSION[$stats] = 0;
		if (hq("select code from temp where code like '" . $stats . "'")) {
			$val = (int) $_SESSION[$stats];
			$val += (int) hq("select text from temp where code like '$stats'");

			my_mysql_query("update temp set text = '" . addslashes($val) . "' where code like '" . $stats . "'");
		} else
			my_mysql_query("insert into temp (code,text) values ('" . $stats . "','" . addslashes($_SESSION[$stats]) . "') ");
	}
	if (hq("select code from temp where code like 'xmlLog'"))
		my_mysql_query("update temp set text = '" . addslashes(getTemp('xmlLog') .
			$_SESSION['xmlLog']) . "' where code like 'xmlLog'");
	else
		my_mysql_query("insert into temp (code,text) values ('xmlLog','" . addslashes($_SESSION['xmlLog']) . "') ");

	$activeWhere = '';
	if ($_POST['indexKatalog']) {
		if ($_GET['indexResimMulti']) {
			$active = null;
			do {
				$mrc = curl_multi_exec($resimMultiCCT, $active);
			} while ($mrc == CURLM_CALL_MULTI_PERFORM);

			while ($active && $mrc == CURLM_OK) {
				if (curl_multi_select($cct) != -1) {
					do {
						$mrc = curl_multi_exec($resimMultiCCT, $active);
					} while ($mrc == CURLM_CALL_MULTI_PERFORM);
				}
			}
			curl_multi_close($resimMultiCCT);
		}
		foreach ($activeUrunArray as $ID) {
			$activeWhere .= 'ID = ' . $ID . ' OR ';
		}
		$activeWhere .= '1=2';
		my_mysql_query("update urun set xmlUpdateStatus = 'OK' where $activeWhere");
	}
	if ($_GET['dilim'] != ($xmldilim - 1)) {
		insertTemp('xmlLog', ($_GET['dilim'] + 1) . ". exit.\n");
		exit('XMLUpdateOK');
	}

	if ($_POST['indexKatalog']) {
		my_mysql_query("update urun set fiyatBirim = 'TL' where fiyatBirim='' OR fiyatBirim='YTL' OR fiyatBirim = 'TRY'");
	}

	if ($_POST['indexKatalog']) {
		setAllSEOFields('urun', 'name');
		setAllSEOFields('kategori', 'name');
		setAllSEOFields('marka', 'name');

		buildBreadCrumb();

		$toplamBos = hq("select count(ID) from urun where xmlUpdateStatus = '" . $bayiID . '-' . date('m-d-Y') . "' AND tedarikciID = '$bayiID'");
		$toplamDolu = hq("select count(ID) from urun where xmlUpdateStatus = 'OK' AND tedarikciID = '$bayiID'");
		insertTemp('xmlLog', "Toplam dolu row : " . $toplamDolu . " . Toplam boş row " . $toplamBos . " .\n");
		if (($toplamDolu - 10) > $toplamBos) {
			my_mysql_query("update urun set  stok = 0 where xmlUpdateStatus = '" . $bayiID . '-' . date('m-d-Y') . "' AND tedarikciID =  '$bayiID'");
			insertTemp('xmlLog', "Toplam " . my_mysql_affected_rows() . " ürün XML servisinden kalktığu için pasif edildi.\n");
		}
		my_mysql_query("update urun set xmlUpdateStatus = 'OK' where tedarikciID = '$bayiID'");
	}


	if (function_exists('updateAutoStock'))
		updateAutoStock();
	if (hq("select code from temp where code like 'xmlLog'"))
		my_mysql_query("update temp set text = '" . addslashes(getTemp('xmlLog') . $_SESSION['xmlLog']) . "' where code like 'xmlLog'", 1);
	else
		my_mysql_query("insert into temp (code,text) values ('xmlLog','" . addslashes($_SESSION['xmlLog']) . "') ", 1);
	exit('XMLUpdateOK');
}
$catActive = array();
$varCache = array();
function varInnerKontrol($i, $vars, $urunID, $stok, $code)
{
	global $varCache, $bayiID;

	$var['var' . $i . '_name'] = addslashes($vars[0]);
	$var['var' . $i . '_var'] = addslashes($vars[1]);
	$var['var' . $i . '_fark'] = addslashes($vars[2]);
	$var['var' . $i . '_resim'] = addslashes($vars[3]);
	$var['var' . $i . '_gtin'] = addslashes($vars[4]);



	if ($var['var' . $i . '_name']) {

		if (!$varCache[$varID[$i]]) {
			$varID[$i] = hqc("select ID from var where tanim like '" . $var['var' . $i . '_name'] . "' OR ozellik like '" . $var['var' . $i . '_name'] . "' limit 0,1");
			$varCache[$varID[$i]] = $varID[$i];
		} else {
			$varID[$i] = $varCache[$varID[$i]];
		}
		if (!$varID[$i]) {
			my_mysql_query("insert into var (tanim,ozellik) values('" . $var['var' . $i . '_name'] . "','" . $var['var' . $i . '_name'] . "')");
			$varID[$i] = my_mysql_insert_id();
			$varCache[$varID[$i]] = $varID[$i];
		}

		my_mysql_query("update urun set varID$i = '" . $varID[$i] . "' where ID='$urunID' limit 1") or (die(my_mysql_error()));
		my_mysql_query("update var set ozellikdetay = concat(ozellikdetay,'\n" . $var['var' . $i . '_var'] . "') where ozellikdetay not like '%" . $var['var' . $i . '_var'] . "\n%' AND ozellikdetay not like '%\n" . $var['var' . $i . '_var'] . "'  AND ID='" . $varID[$i] . "'");

		//if($var['var'.$i.'_fark'])
		{
			$farkID = hqc("select ID from urunvars where urunID='$urunID' AND varID='" . $varID[$i] . "' AND var like '" . $var['var' . $i . '_var'] . "' limit 0,1");
			if (!$farkID) {
				my_mysql_query("insert into urunvars (urunID,varID,var,fark,up) values ('$urunID','" . $varID[$i] . "','" . $var['var' . $i . '_var'] . "','" . $var['var' . $i . '_fark'] . "',1)");
				$farkID = my_mysql_insert_id();
			} else
				if ($_GET['indexFSFiyat'])
				my_mysql_query("update urunvars set fark='" . $var['var' . $i . '_fark'] . "',up=1 where ID='$farkID' limit 1");
		}
	}

	//	
	if ($_GET['indexResim'] && $var['var' . $i . '_resim']) {
		//echo debugArray($var);

		//for ($ii=1;$ii<=5;$ii++) 
		{
			$myFile = $var['var' . $i . '_resim'];
			$resimLocation = str_replace(array('.asp', '.php', '.aspx', '.php5'), '.jpg', strtolower(basename($myFile)));
			$resimLocation = md5($myFile);
			//if (!(stristr($resimLocation,'?') === false))
			{
				$resimLocation = seoFix(substr(utf8fix($resimLocation), 0, 10) . '-' . $urunID) . '.jpg';
			}

			$resimCheck = 1;
			$resimLocation = $bayiID . '_var_' . utf8fix(tr2eu($resimLocation));
			$resimLocation = str_replace(array('İ', 'Ş', 'Ü', 'Ö', 'Ğ', 'ş', 'ı', 'ü', 'ö', 'ğ', ' '), '-', $resimLocation);

			//	echo ("select ID from urunvar where resim1 = '" . $resimLocation . "' AND urunID='$urunID' AND varID='" . $varID[$i] . "' AND varName like '" . $var['var' . $i . '_var'] . "' limit 0,1");
			$resimID = hqc("select ID from urunvar where urunID='$urunID' AND varID='" . $i . "' AND varName like '" . $var['var' . $i . '_var'] . "' limit 0,1");
			if (!$resimID) {
				if (stristr($var['var' . $i . '_resim'], '://') === false) {
					mysql_query("insert into urunvar (urunID,varID,varName,resim1 ) values ('$urunID','" . $i . "','" . $var['var' . $i . '_var'] . "','" . $var['var' . $i . '_resim'] . "')") or die(mysql_error());
				} else {
					XMLdownloadFile($myFile, '../images/urunler/var/', $resimLocation);
					mysql_query("insert into urunvar (urunID,varID,varName,resim1 ) values ('$urunID','" . $i . "','" . $var['var' . $i . '_var'] . "','" . $resimLocation . "')") or die(mysql_error());
				}
			} else {
				if (stristr($var['var' . $i . '_resim'], '://') === false) {
					mysql_query("update urunvar set resim1 = '" . $var['var' . $i . '_resim'] . "' where ID='$resimID' ") or die(mysql_error());
				} else {
				}
			}
		}
	}
	//exit();
}

function hqc($query, $dsb = false)
{
	global $hqCache, $siteConfig, $showSPError;
	$code = substr(md5($query), 0, 5);
	if (isset($hqCache['hq'][$code]))
		return $hqCache['hq'][$code];
	$bib = my_mysql_query($query);
	$go = my_mysql_fetch_array($bib);
	$hqCache['hq'][$code] = $go[0];
	return $go[0];
}

function urunVarKontrol($v1, $v2, $stok, $code, $urunID, $fark = 0, $gtin = '')
{
	/* 
		v1 ve v2 = array
		[0] = Varyasyon Başlık
		[1} = Varyasyon Adı
		[2] = Varyason Fiyat Farkı
	 */
	if (hq("select noxml from urun where ID='$urunID'"))
		return;
	if (!is_array($v1) && is_array($v2))
		return;

	foreach ($v1 as $k => $v) {
		$v1[$k] = trim((string) $v);
	}

	foreach ($v2 as $k => $v) {
		$v2[$k] = trim((string) $v);
	}

	if (!$fark)
		$fark = ((float) $v1[2] + (float) $v2[2]);
	$v1[2] = $v2[2] = '';

	if ($v1[0]) {
		$varID1 = varInnerKontrol(1, $v1, $urunID, $stok, $code);
	}

	if ($v2[0] && ($v1[0] != $v2[0])) {
		$varID2 = varInnerKontrol(2, $v2, $urunID, $stok, $code);
	}

	$v1[1] = addslashes($v1[1]);
	$v2[1] = addslashes($v2[1]);
	$v1[1] = str_replace(',', '-', $v1[1]);
	$v2[1] = str_replace(',', '-', $v2[1]);

	$stok += (float)hq("select stoky from urunvarstok where urunID = '$urunID' AND var1='" . $v1[1] . "' AND var2='" . $v2[1] . "' limit 0,1");

	autoAddFormField('urunvarstok', 'gtin', 'VAR-16');
	$stokID = hq("select ID from urunvarstok where urunID = '$urunID' AND var1='" . $v1[1] . "' AND var2='" . $v2[1] . "' limit 0,1");
	if (!$stokID)
		my_mysql_query("insert into urunvarstok (urunID,var1,var2,kod,stok,fark,gtin,up) VALUES ('$urunID','" . $v1[1] . "','" . $v2[1] . "','$code','$stok','$fark','$gtin',1)");
	else {
		my_mysql_query("update urunvarstok set kod = '$code',stok = '$stok',fark = '$fark',gtin = '$gtin',up=1 where urunID = '$urunID' AND var1='" . $v1[1] . "' AND var2='" . $v2[1] . "' limit 1", 1);
		//echo ("update urunvarstok set kod = '$code',stok = '$stok',fark = '$fark',gtin = '$gtin',up=1 where urunID = '$urunID' AND var1='" . $v1[1] . "' AND var2='" . $v2[1] . "' limit 1");
	}
	//my_mysql_query("update urun set ozellik1='' ozellik1detay ='' where ID='$urunID' limit 1");			

}

function varKontrol($title, $var)
{
	$var = trim($var);
	$varID = hq("select ID from var where ozellik = '" . addslashes($title) . "'");
	if (!$varID) {
		my_mysql_query("insert into var (tanim,ozellik) VALUES ('" . ucfirst(addslashes($var)) . "','" . $var . "')");
		$varID = my_mysql_insert_id();
	}
	my_mysql_query("update var set ozellikdetay = concat(ozellikdetay,'" . addslashes($var) . "\n') where ID='$varID' AND ozellikdetay not like '%" . addslashes($var) . "%'");
	return $varID;
}

$lastCatXMLCode = '';

function isURLImage($url)
{
	$arr = explode("?", $url);
	return preg_match("#\.(jpg|jpeg|gif|png)$# i", $arr[0]);
}

function urunKontrol($kod, $ad, $cat, $resim, $resim2, $resim3, $resim4, $resim5, $marka, $garanti, $vergi, $onDetay, $ozltable, $bayiID, $info = array())
{
	global $shopphp_demo;
	if ($shopphp_demo)
		return;
	if ($_GET['xmlCatCache'] || !$kod || !$ad || !$cat) {
		insertTemp('xmlLog', "$kod : $ad : Eksik bilgi var.\n");
		if ($_GET['err'])
			exit(getTemp('xmlLog'));
		return;
	}
	global $activeUrunArray, $dynamicDownload, $catActive, $updateAll, $lastCatXMLCode;
	$xmlUpdateStatusCode = $bayiID . '-' . date('m-d-Y');
	$_SESSION['XML_urun_guncellenen']++;
	$kod = trim($kod);
	$ad = strip_tags(trim($ad));
	$cat = trim($cat);
	$resim = trim($resim);
	$resim2 = trim($resim2);
	$resim3 = trim($resim3);
	$resim4 = trim($resim4);
	$resim5 = trim($resim5);
	$marka = trim($marka);
	$garanti = trim($garanti);
	$vergi = trim($vergi);
	$onDetay = trim($onDetay);
	$ozltable = trim($ozltable);
	$bayiID = trim($bayiID);

	if (!hq("select ID from urun where xmlUpdateStatus= '$xmlUpdateStatusCode' AND tedarikciID = '$bayiID' limit 0,1")) {
		my_mysql_query("update urun set xmlUpdateStatus = '$xmlUpdateStatusCode' where tedarikciID = '$bayiID'");
		insertTemp('xmlLog', "XML Update Status guncellendi.\n");
	}

	$urunID = hq("select ID from urun where tedarikciID = '$bayiID' AND tedarikciCode = '$kod' limit 0,1");
	if ($urunID && hq("select noxml from urun where ID='$urunID'"))
		return;

	if ($info['ckod'])
		$ckod = $info['ckod'];
	else if ($lastCatXMLCode)
		$ckod = $lastCatXMLCode;
	else
		$ckod = (hq("select tedarikciCode from kategori where ID = '$cat'"));

	if (!isset($catActive[$ckod])) {
		$pasif = ($ckod && hq("select ID from xmlcatcache where  tedarikciCode like '$ckod' AND (active = 0 OR up=0)") && !hq("select ID from xmlcatcache where  tedarikciCode like '$ckod' AND (active = 1 AND up=1)"));
		$catActive[$ckod] = $pasif;
	} else
		$pasif = $catActive[$ckod];

	if ($pasif) {
		if ($urunID)
			my_mysql_query("update urun set active='0' where ID='$urunID' limit 1");
		insertTemp('xmlLog', "Kategori, " . hq("select name from kategori where ID = '$cat'") . " ($ckod) - XML güncellemesinde aktif edilmediğinden $ad ($kod) güncellenmedi ve sitede bu ürün pasif edildi. \n");
		return false;
	}


	$yeniurun = false;
	if (!$urunID) {
		$yeniurun = true;
		$kdv = (float) (str_replace('KDV', '', $vergi) / 100);
		my_mysql_query("INSERT INTO urun (  catID , tedarikciID , tedarikciCode , name , markaID , listeDetay , onDetay , detay , resim , resim2 , resim3 , resim4 , resim5 , fiyatBirim , fiyat , kdv , tedarikfiyat , piyasafiyat , garanti , desi , pesinTaksitOrani , anasayfa , ozellik1 , ozellik2 , ozellik3 , ozellik4 ,ozellik5 , ozellik1detay , ozellik2detay , ozellik3detay , ozellik4detay , ozellik5detay ,gtin, video , stok , tarih , seq , hit , sold , puan,active ) 
	VALUES (	 '$cat', '$bayiID', '$kod', '" . addslashes($ad) . "', '$marka', '', '" . addslashes($onDetay) . "', '" . addslashes($ozltable) . "', '', '', '', '', '', 'TL', '', '$kdv', '', '', '$garanti','" . $info['desi'] . "', '', 0, '" . $info['ozellik1'] . "', '" . $info['ozellik2'] . "', '" . $info['ozellik3'] . "','" . $info['ozellik4'] . "','" . $info['ozellik5'] . "', '" . $info['ozellik1detay'] . "', '" . $info['ozellik2detay'] . "', '" . $info['ozellik3detay'] . "', '" . $info['ozellik4detay'] . "','" . $info['ozellik5detay'] . "','" . $info['gtin'] . "','', '1', now(), '', '', '', '',1
	);");
		$urunID = my_mysql_insert_id();
		insertTemp('xmlLog', "Ürün, $ad ($kod) - eklendi.\n");
		$_SESSION['XML_urun_eklenen']++;

		foreach ($info as $k => $v) {
			if (substr($k, 0, 5) != 'resim')
				my_mysql_query("update urun set $k = '" . addslashes($v) . "' where ID='$urunID' AND $k = ''");
		}
	}



	if ($_GET['indexResim']) {

		$detay = $detaycheck = hq("select detay from urun where ID='$urunID'");

		preg_match_all('/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/', $detay, $matches);
		$iarr = $matches[0];
		//echo "<textarea style='width:800px; height:600px;'>$detay</textarea>";
		//echo debugArray($iarr);
		$ri = 1;
		foreach ($iarr as $image) {
			$image = str_replace(array('"', "'"), '', $image);
			if (!isURLImage($image)) {
				echo $image . ' X<br />';
				continue;
			}

			$resimLocation = seoFix($ad) . '_' . $urunID . '_' . $ri . '.jpg';
			XMLdownloadFile($image, '../images/urunler/detay/', $resimLocation);
			$detay = str_replace($image, 'images/urunler/detay/' . $resimLocation, $detay);
			$ri++;
		}
	}

	if ($detay != $detaycheck) {
		my_mysql_query("update urun set detay = '" . addslashes($detay) . "' where ID='$urunID' limit 1");
	}
	//	exit();

	$myFile = '';
	$resimCheck = 0;
	$resim6 = $info['resim6'];
	$resim7 = $info['resim7'];
	$resim8 = $info['resim8'];
	$resim9 = $info['resim9'];
	$resim10 = $info['resim10'];

	if ($_GET['indexResim']) {
		for ($ii = 1; $ii <= 10; $ii++) {
			$str = ($ii == 1 ? '' : $ii);
			$check = 'resim' . $str;
			if (!${$check}) continue;
			$resimLocation = str_replace(array('.asp', '.php', '.aspx', '.php5'), '.jpg', strtolower(basename(${$check})));
			//if (!(stristr($resimLocation,'?') === false))
			{
				$resimLocation = seoFix(substr(utf8fix($ad), 0, 10) . '-' . $urunID) . '_' . $ii . '.jpg';
			}
			$myFile = ${$check};
			$resimCheck = 1;
			$resimLocation = $bayiID . '_' . utf8fix(tr2eu($resimLocation));
			$resimLocation = str_replace(array('İ', 'Ş', 'Ü', 'Ö', 'Ğ', 'ş', 'ı', 'ü', 'ö', 'ğ', ' '), '-', $resimLocation);
			if (!$dynamicDownload) {
				my_mysql_query("update urun set resim$str = '$resimLocation' where resim$str = '' AND ID='$urunID' limit 1");
				XMLdownloadFile($myFile, '../images/urunler/', $resimLocation);
			} else {
				my_mysql_query("update urun set download1='$resim',download2='$resim2',download3='$resim3',download4='$resim4',download5='$resim5' where ID='$urunID' limit 1");
			}
		}
	}

	$detayResim = '';
	for ($r = 10; $r <= 30; $r++) {
		$myFile = 'resim-' . $r;
		$resimLocation = $info['resim' . $r];
		if (!$resimLocation)
			break;
		if (stristr($myFile, 'http') === false) {
			$resimLocation = $myFile;
		} else
			XMLdownloadFile($myFile, '../images/urunler/', $resimLocation);
		//XMLdownloadFile($myFile, '../images/urunler/', $resimLocation);		
		$detayResim .= "<img src='images/urunler/" . $resimLocation . "' alt='' />";
	}

	$activeUrunArray[] = $urunID;
	// my_mysql_query("update urun set xmlUpdateStatus = 'OK',active=1 where ID='$urunID' limit 1");
	if ($_POST['indexKategori']) {
		my_mysql_query("update urun set catID='$cat' where ID='$urunID' limit 1");
		// my_mysql_query("update urun set catID='$cat' where ID='$urunID' AND showCatIDs not like '%|$cat|%' AND showCatIDs not like '|$cat|%' AND showCatIDs not like '%|$cat|' limit 1");
	}
	if (($updateAll || $detayResim) && (stristr($detayResim, '<') === false)) {
		my_mysql_query("update urun set name='" . addslashes($ad) . "',onDetay = '" . addslashes($onDetay) . "',detay='" . addslashes($ozltable) . " " . $detayResim . "',markaID='$marka' where ID='$urunID' limit 1");
	} else if (!$yeniurun) {
		if ($_GET['indexIsim'] || $_GET['indexAciklama']) {
			$set = array();
			if ($_GET['indexIsim'])
				$set[] = "name='" . addslashes($ad) . "'";
			if ($_GET['indexAciklama'] && (stristr($ozltable, '<img') === false))
				$set[] = "detay='" . addslashes($ozltable) . "'";
			my_mysql_query("update urun set " . implode(',', $set) . " where ID='$urunID' limit 1");
		}
	}
	insertTemp('xmlLog', "ID : $urunID - $ad - Kod : $kod - Resim : $resim bilgileri güncellendi.\n");
	return $urunID;
}

function kategoriKontrol($kod, $tanim, $bayiID)
{
	if (!$tanim)
		return $_GET['parentID'];
	return grupKontrol($kod, $tanim, $bayiID, $_GET['parentID']);
}

function grupKontrolMap($exp, $cats, $bayiID, $parentID)
{
	$catArray = explode($exp, $cats);
	$mainCatID = $parentID;
	$parentCatCode = '';
	$level = 0;
	foreach ($catArray as $cat) {
		if (!$cat)
			continue;
		$level++;
		$parentCatID = $mainCatID;
		$code = substr(md5($parentCatCode . '_' . $cat . '_' . $level), 0, 10);
		$mainCatID = grupKontrol($code, $cat, $bayiID, $parentCatID, $parentCatCode);
		$parentCatCode = $code;
	}
	return $mainCatID;
}

$grupKontrol = array();
function grupKontrol($kod, $tanim, $bayiID, $parentID, $parentIDCode = '')
{
	global $lastCatXMLCode, $grupKontrol, $shopphp_demo;
	if ($shopphp_demo)
		return;
	$kod = trim($kod);
	$tanim = addslashes(trim($tanim));
	$bayiID = trim($bayiID);
	$parentID = trim($parentID);
	$parentIDCode = trim($parentIDCode);
	$catActive = array();

	if (!$kod && $tanim)
		$kod = getCodeFromName($tanim);

	$lastCatXMLCode = $kod;

	if (@$_GET['xmlCatCache'])
		return grupKontrolCache($kod, $tanim, $bayiID, $parentID, $parentIDCode);

	//$findCatID = hq("select ID from kategori where name like '$tanim' AND tedarikciCode!='$kod' AND parentID = '$parentID'");		
	$_SESSION['XML_kategori_guncellenen']++;
	if (@$grupKontrol[$kod])
		return $grupKontrol[$kod];
	if (!isset($catActive[$kod])) {

		$fx = hq("select ID from xmlcatcache where tedarikciID = '$bayiID' AND tedarikciCode ='$kod' AND up=1 AND (active = 0)");
		$pasif = ($fx && !hq("select ID from xmlcatcache where tedarikciID = '$bayiID' AND tedarikciCode ='$kod' AND name='" . addslashes($tanim) . "' AND up = 1 AND (active = 1)"));
		//if ($pasif && hq("select ID from xmlcatcache where parentID = '$fx' AND (active = 1)"))
		//	$pasif = false;
		$catActive[$kod] = $pasif;
	} else
		$pasif = $catActive[$kod];
	if ($pasif) {
		//my_mysql_query("update kategori set active='0' where ID='$findCatID' limit 1");
		insertTemp('xmlLog', "Kategori, $tanim ($kod) - XML güncellemesinde aktif edilmediğinden güncellenmedi ve sitede bu kategori pasif edildi. \n");
		return false;
	}
	$remoteID = hq("select remoteID from xmlcatcache where tedarikciID = '$bayiID' AND tedarikciCode ='$kod'");
	if ($remoteID)
		return $remoteID;

	if (strlen($kod) <= 0 || strlen($tanim) <= 0 || $kod == '0')
		return $parentID;
	$catID = hq("select ID from kategori where tedarikciCode='$kod' and tedarikciID='$bayiID' limit 0,1");
	if (!$catID) {
		$tanim = utf8fix($tanim);
		if (!$parentID && $parentIDCode)
			$parentID = hq("select ID from kategori where tedarikciCode like '$parentIDCode' AND tecraikciID='$bayiID'");
		my_mysql_query("Insert into kategori (parentID,tedarikciID,tedarikciCode,name,active) values('$parentID','$bayiID','$kod','$tanim',1)");
		insertTemp('xmlLog', "Kategori, $tanim ($kod) - eklendi \n");
		$catID = hq("select ID from kategori order by ID desc limit 0,1");
		$_SESSION['XML_kategori_eklenen']++;
	}
	if (@$_POST['indexKategori'] && $parentID) {
		my_mysql_query("update kategori set parentID='$parentID' where ID='$catID' limit 1");
		insertTemp('xmlLog', "Kategori, $tanim ($kod) - üst kategori ID $parentID olarak güncellendi. \n");
	}
	$grupKontrol[$kod] = $catID;
	return $catID;
}

$grupKontrolCache = array();
function grupKontrolCache($kod, $tanim, $bayiID, $parentID, $parentIDCode)
{
	global $grupKontrolCache;
	if (strlen($kod) <= 0 || strlen($tanim) <= 0)
		return $parentID;
	if ($grupKontrolCache[$kod])
		return $grupKontrolCache[$kod];
	$catID = hq("Select ID from xmlcatcache where tedarikciCode='$kod' and tedarikciID='$bayiID' limit 0,1");
	if (!$catID) {
		$parentID = hq("select ID from xmlcatcache where tedarikciCode like '$parentIDCode' AND tedarikciID like '$bayiID' limit 0,1");
		my_mysql_query("Insert into xmlcatcache (parentID,tedarikciID,dosya,tedarikciCode,name,active,up) values('$parentID','$bayiID','" . $_GET['dosya'] . "','$kod','$tanim',1,1)");
		$catID = my_mysql_insert_id();
	}
	my_mysql_query("update xmlcatcache set up=1,parentID='$parentID' where ID='$catID' limit 1");
	$grupKontrolCache[$kod] = $catID;
	return $catID;
}
$markaKontrol = array();
function markaKontrol($marka, $kod = 0)
{

	global $markaKontrol, $shopphp_demo;
	if ($shopphp_demo)
		return;
	if (!$marka) $marka = $kod = 'Diger';
	$_SESSION['XML_marka_guncellenen']++;
	if ($markaKontrol[$marka])
		return $markaKontrol[$marka];
	$marka = str_replace("'", '', $marka);
	$kod = str_replace("'", '', $kod);
	$markaID = hq("select ID from marka where name like '$marka' OR (tedarikciCode like '$kod') limit 0,1");
	if (!$markaID) {
		$marka = addslashes($marka);
		$kod = addslashes($marka);
		my_mysql_query("Insert into marka (tedarikciCode,name) values('$kod','$marka')");
		$markaID = my_mysql_insert_id();
		insertTemp('xmlLog', "Marka, $marka - eklendi. ID : $markaID \n");
		$_SESSION['XML_marka_eklenen']++;
	}
	$markaKontrol[$marka] = $markaID;
	return $markaID;
}
//unset($_SESSION['kar']);
function karHesapla($code, $bayiID)
{
	$code = trim($code);
	if (isset($_SESSION['kar'][$code])) {
		$kar = $_SESSION['kar'][$code];
		return ($kar ? $kar : $_GET['kar']);
	}
	$idPath = hq("select kategori.idPath from kategori,urun where urun.catID = kategori.ID AND urun.tedarikciCode like '$code' AND urun.tedarikciID like '$bayiID' limit 0,1");
	$iArr = explode('/', $idPath);
	foreach ($iArr as $c) {
		$karkontrol = hq("select kar from kategori where ID='$c'");
		if ($karkontrol)
			$kar = $karkontrol;
	}
	if (!$kar) {
		hq("select marka.kar from marka,urun where urun.markaID = marka.ID AND urun.tedarikciCode like '$code' AND urun.tedarikciID like '$bayiID' limit 0,1");
	}
	$_SESSION['kar'][$code] = $kar;
	return ($kar ? $kar : $_GET['kar']);
}

function updateBar()
{
	return ('<table id="xmlUpdate"><tr><td>Güncelleme Dururmu :&nbsp;</td><td class="xmlPerTD"><div id="xmlPer"> %00 </div></td><td class="xmlWaitTD"><span id="plsWait"></span></td></tr></table>');
}
