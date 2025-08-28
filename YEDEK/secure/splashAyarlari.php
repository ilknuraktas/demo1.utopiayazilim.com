<?
$dbase = "siteConfig";
$title = 'Splash Screen Ayarları';
$ozellikler = array(
	ekle => '0',
	baseid => 'ID',
	listDisabled => true,
	listBackMsg => 'Kaydedildi',
	editID => 1,
);

$icerik = array(
	array(
		isim => 'URL Adresi',
		db => 'splash_url',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Resim (PNG: 592x266 px)',
		db => 'splash_resim',
		stil => 'file',
		uploadto => 'images/',
		info=>'Resim veya HTML Body den sadece biri girilmelidir.',
		unlist => true,
		gerekli => '0'
	),

	array(
		isim => 'HTML Body',
		db => 'splash_body',
		stil => 'HTML',
		multilang => true,
		en => '450',
		boy => '150',
		info=>'Resim veya HTML Body den sadece biri girilmelidir.',
		unlist => true,
		intab => 'genel',
		gerekli => '0',
	),
	array(
		isim => 'Padding',
		db => 'splash_padding',
		stil => 'normaltext',
		info=>'Verilen sayı kadar pixel, resim kenarlarında boşluk bırakır.',
		gerekli => '0'
	),
	/*
				array(isim=>'Kapmanya Bitiş Tarihi',
					  db=>'splash_tarih',
					  stil=>'date',
					  unlist=>true,
					  setTime=>true,
					  gerekli=>'0'), 	
				array(isim=>'Tarih Sayacı Gizle',
					  db=>'splash_gizle',
					  stil=>'checkbox',
					  gerekli=>'0'),	
					  */
	array(
		isim => 'Splash Screen Aktif',
		db => 'splash_active',
		stil => 'checkbox',
		gerekli => '0'
	),

);
echo adminInfo('Splash Screen resminin 592x266 px\'den uzak olmaması ve transparan PNG olması tavsiye edilir.');
admin($dbase, $where, $icerik, $ozellikler);
if ($_POST['splash_active'])
{
	$_SESSION['splash_loaded'] = 0;
	cleancache();
} 