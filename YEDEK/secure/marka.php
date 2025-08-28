<?
$dbase = "marka";
$title = 'Marka Yönetimi';
$listTitle = 'Markalar';
$ozellikler = array(
	ekle => '1',
	baseid => 'ID',
	orderby => 'ID',
	excelLoad => 1,
);

$icerik = array(
	array(
		isim => 'Meta Tag Keywords',
		disableFilter => true,
		unlist => true,
		multilang => true,
		maxlength => 320,
		intab => 'seo',
		db => 'metaKeywords',
		stil => 'normaltext'
	),
	array(
		isim => 'Meta Tag Description',
		disableFilter => true,
		unlist => true,
		maxlength => 320,
		multilang => true,
		intab => 'seo',
		db => 'metaDescription',
		stil => 'normaltext'
	),
	array(
		isim => 'Marka Adı',
		db => 'name',
		intab => 'genel',
		stil => 'normaltext',
		width => 593,
		gerekli => '1'
	),
	/*
					  array(
						isim => 'Varsayılan XML Giriş Kar Marjı (0.10 = %10)',
						disableFilter => true,
						db => 'kar',
						unlist => true,
						stil => 'normaltext',
						intab => 'pazaryeri',
						gerekli => '1'
					),
*/

	array(
		isim => 'SEO URL girişi',
		db => 'seo',
		intab => 'seo',
		info=>'Girilmezse, otomatik oluşturulur.',
		multilang => true,
		unlist => true,
		stil => 'normaltext',
		width => 226,
		gerekli => '1'
	),
/*
	array(
		isim => 'Marka İsim Varyasyonları (XML Entegrasyon İçin)',
		db => 'tedarikciCode',
		unlist => true,
		stil => 'normaltext',
		gerekli => '1'
	),
*/
	array(
		isim => 'Sipariş Info Mail',
		db => 'email',
		intab => 'genel',
		stil => 'normaltext',
		gerekli => '1'
	),

	array(
		isim => 'Resim',
		db => 'resim',
		stil => 'file',
		intab => 'genel',
		uploadto => 'images/markalar/',
		unlist => true,
		gerekli => '0'
	),

	array(
		isim => 'Promosyon Ürün için Asgari Marka Sipariş Tutarı',
		db => 'pUrunTutar',
		unlist => true,
		intab => 'genel',
		stil => 'normaltext',
		gerekli => '1'
	),

	array(
		isim => 'Promosyon Ürün',
		db => 'pUrunID',
		width => 369,
		intab => 'genel',
		unlist => true,
		stil => 'dbpulldown',
		dbpulldown_data => array(
			db => 'urun',
			base => 'ID',
			name => 'name',
		),
		gerekli => '1'
	),
	array(
		isim => 'Bu Markada Havale İndirimi Uygulanmaz',
		db => 'nohavale',
		unlist => true,
		intab => 'genel',
		stil => 'checkbox',
		width => 29,
		gerekli => '0'
	),
	array(
		isim => '<img id="google-label" src="images/google.png" />',
		offline => true,
		unlist => true,
		stil => 'customtext',
		intab => 'seo',
		text => '<div name="seo" id="seopreview-google"></div>'
	),
);
/*
if ($siteTipi == 'OZELSATIS') {
	$ozelSatisIcerik = array(
		array(
			isim => 'Liste Resim',
			db => 'private_resim1',
			stil => 'file',
			uploadto => 'images/markalar/',
			unlist => true,
			gerekli => '0'
		),
		array(
			isim => 'Info',
			db => 'private_info',
			stil => 'HTML',
			en => '450',
			boy => '150',
			unlist => true,
			gerekli => '0'
		),
		array(
			isim => 'Marka Listeleme Başlangıç Tarihi',
			db => 'private_start',
			stil => 'date',
			unlist => true,
			setTime => true,
			gerekli => '0'
		),
		array(
			isim => 'Marka Listeleme Bitiş Tarihi',
			db => 'private_tarih',
			stil => 'date',
			unlist => true,
			setTime => true,
			gerekli => '0'
		),
		array(
			isim => 'Öncelik',
			db => 'seq',
			stil => 'normaltext',
			unlist => true,
			gerekli => '1'
		),
		array(
			isim => 'Ürünleri Otomatik Aktif / Pasif Yap',
			db => 'auto',
			stil => 'checkbox',
			width => 29,
			gerekli => '0'
		),
	);
	$icerik = array_merge($icerik, $ozelSatisIcerik);
}
*/

if ($_GET['ID'] && file_exists('../include/mod_Trendyol.php')) {
	$marka = hq("select ty_markaName from marka where ID='" . $_GET['ID'] . "'");
	if (!$marka)
		$marka = hq("select name from marka where ID='" . $_GET['ID'] . "'");
	require_once('../include/mod_Trendyol.php');
	$trendyolIcerik = array(
		array(
			isim => 'Trendyol Marka Arama',
			db => 'ty_markaName',
			intab => 'genel',
			info => 'Eğer marka adı, trendyolda kayıtlı olandan farklı ise buraya girip kaydedin ve tekrar bu markayı düzenleyin.',
			stil => 'normaltext',
			unlist => true
		),

		array(
			isim => 'Trendyol Marka Karşılığı',
			db => 'ty_markaID',
			intab => 'genel',
			stil => 'simplepulldown',
			info => '<a href="https://api.trendyol.com/sapigw/brands/by-name?name=' . urlencode($marka) . '" target="_blank">Json kontrolü</a>',
			align => 'left',
			width => 80,
			simpleValues => Trendyol::getBrands($marka),
			unlist => true
		),
	);
	$icerik = array_merge($icerik, $trendyolIcerik);
}

if ($_GET['y'] == 'd') {
	$url = '//' . $_SERVER["SERVER_NAME"] . markaLink((int)$_GET['ID']);
	$tempInfo .= adminInfov5('Düzenleme yapılan markanın URL adresi :<br /> <a href="' . $url . '" target="_blank">https:' . $url . '</a>','cube');
	$tempInfo .= adminInfov5('<a href="s.php?f=pn.php&y=e&markaID=' . $_GET['ID'] . '">Markayı Push Notification ile göndermek için tıklayın.</a>');
}
echo adminInfo('Markaya info mail ekleyerek, ilgili adrese sadece bu markaya gelen sipariş bilgilerinin gönderilmesini sağlayabilirsiniz.');
echo adminInfo('Markaya ait asgari tutarda ürün satın alındığında, ilgili promosyon ürünün otomatik sepete eklenmesini sağlayabilirsiniz.');
setAdminPostSEOField();

if (($_GET['y'] == 'd' || $_GET['y'] == 'e') && !$_POST['name'])
{
	$adminTabs[0] = array('genel', 'fa-shopping-cart', 'Genel Bilgiler');
	$adminTabs[1] = array('seo', 'fa-search', 'SEO');
	$tempInfo .= v4Admin::generateTabMenu($adminTabs, $icerik, $dbase);
}
	 

admin($dbase, $where, $icerik, $ozellikler);
echo googlePreview('markaID','kategoriGoster',markaLink($_GET['ID']));
?>