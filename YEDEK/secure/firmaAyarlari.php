<?php
$dbase = "siteConfig";
$title = 'Firma Ayarları';
$ozellikler = array(
	ekle => '0',
	baseid => 'ID',
	listDisabled => true,
	listBackMsg => 'Kaydedildi',
	editID => 1,
);

$icerik = array(
	array(
		isim => 'Firma Adı',
		db => 'firma_adi',
		stil => 'normaltext',
		multilang => true,
		gerekli => '0'
	),
	array(
		isim => 'Firma Adresi',
		db => 'firma_adres',
		multilang => true,
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Firma Telefonu',
		db => 'firma_tel',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Sizi Arayalım Formunu Ürün Detay\'da Göster',
		db => 'firmaTelShow',
		stil => 'checkbox',
		width => 29,
		gerekli => '0'
	),
	array(
		isim => 'Firma Cep Telefonu',
		db => 'firma_gsm',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Firma Faksı',
		db => 'firma_faks',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Firma E-Posta',
		db => 'firma_email',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Whatsapp Sipariş Numaranız',
		db => 'whatsappNumber',
		stil => 'normaltext',
		info => 'Numara 0 ile başlamalı.',
		gerekli => '0'
	),
	array(
		isim => 'Whatsapp Sipariş Gösterimi Aktif',
		info => 'Ürün detay sayfasına block olarak eklenir.',
		db => 'whatsappNumberShow',
		stil => 'checkbox',
		width => 29,
		gerekli => '0'
	),

	array(
		isim => 'Whatsapp Destek Hattı Gösterimi Aktif',
		info => 'Tüm sayfalarda footer kısmına eklenir.',
		db => 'whatsappSupportShow',
		stil => 'checkbox',
		width => 29,
		gerekli => '0'
	),

	/*
	array(
	isim => 'Footer Slogan',
	db => 'footerSlogan',
	stil => 'textarea',
	multilang => true,
	intab=>'sozlesme'
),

array(
	isim => 'Footer Text',
	db => 'footerText',
	stil => 'textarea',
	multilang => true,
	intab=>'sozlesme'
),
	*/
);

echo adminv3($dbase, $where, $icerik, $ozellikler);
if ($_POST['y'] == 'du')
	cleanCache();
?>