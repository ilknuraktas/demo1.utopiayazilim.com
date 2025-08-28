<?php 
$dbase = "n11";
$title = 'N11 Log';
$listTitle = 'N11 Log Kayıt';

$ozellikler = array(
	ekle => '0',
	sil => '0',
	baseid => 'ID',
	orderby => 'ID',
	ordersort => 'desc',
);
$icerik = array(
	array(
		isim => 'Ürün',
		db => 'urunID',
		width => 194,
		stil => 'dbpulldown',
		dbpulldown_data => array(
			db => 'urun',
			base => 'ID',
			name => 'name',
			order => 'ID'
		),
		gerekli => '1'
	),
	array(
		isim => 'Filtre',
		db => 'filter',
		maxlength => 512,
		unlist => true,
		stil => 'textarea',
		multilang => true,
		rows => '4',
		cols => '64'
	),
	array(
		isim => 'Log',
		db => 'log',
		maxlength => 512,
		width=>300,
		stil => 'textarea',
		multilang => true,
		rows => '4',
		cols => '64'
	),
);

admin($dbase, $where, $icerik, $ozellikler);
?>