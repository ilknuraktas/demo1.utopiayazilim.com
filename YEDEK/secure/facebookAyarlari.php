<?php
$dbase = "siteConfig";
$title = 'Facebook Ayaları';
$ozellikler = array(
	ekle => '0',
	baseid => 'ID',
	listDisabled => true,
	listBackMsg => 'Kaydedildi',
	editID => 1,
);

$icerik = array(
	array(
		isim => 'Facebook Pixel Code',
		db => 'facebook_pixel',
		stil => 'textarea',
		style => 'min-height:100px;',
		gerekli => '0'
	),
	array(
		isim => 'Facebook Pixel ID',
		db => 'facebook_pixelID',
		stil => 'normaltext',
		gerekli => '0'
	),
	array(
		isim => 'Facebook Pixel Access Token',
		db => 'facebook_token',
		info=> '<a href="https://www.youtube.com/watch?v=UZ4QcGeXACc" target="_blank">Facebook Conversion API Access Token nasıl alabilirim?</a>',
		stil => 'textarea',
		style => 'min-height:70px;',
		gerekli => '0'
	),
);
admin($dbase, $where, $icerik, $ozellikler);
?>