<?php
$dbase = "hbrapor";
$title = 'Hepsiburada Raporları';
$listTitle = 'Raporlar';
$ozellikler = array(
	ekle => '1',
	baseid => 'ID',
	orderby => 'ID',
	orderseq => 'desc'
);

$icerik = array(
	array(
		isim => 'Tacking Id',
		db => 'trackingId',
		stil => 'normaltext',
		width=>400,
		gerekli => '0'
	),
	array(
		isim => 'İşlendi',
		db => 'readok',
		intab => 'genel',
		stil => 'checkbox',
		width => 50,
		gerekli => '0'
	),
);


//$tempInfo .= '<textarea class="rapor-goster">' . SpAmazon::generateSubmitFeedXML_Product(665)['feed'] . '</textarea>';
if($_GET['raporID'])
{
	$_GET['ID'] = $_POST['ID'] = hq("select ID from hbrapor where trackingId like '".$_GET['raporID']."'");
}
if ($_GET['ID']) {
	$trackingId = hq("select trackingId from hbrapor where ID='" . (int)$_GET['ID'] . "'");
	if ($trackingId) {
		require_once('../include/mod_HepsiBuradav2.php');
		$tempInfo .= '<textarea class="rapor-goster">' . hb_getTrackingIDResult($trackingId) . '</textarea>';
	}
}

admin($dbase, $where, $icerik, $ozellikler);
?>