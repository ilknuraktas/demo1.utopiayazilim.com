<?php
$dbase = "ciceksepetirapor";
$title = 'ÇiçekSepeti Raporları';
$listTitle = 'Raporlar';
$ozellikler = array(
	ekle => '1',
	baseid => 'ID',
	orderby => 'ID',
	orderseq => 'desc'
);

$icerik = array(
	array(
		isim => 'Batch Request Id',
		db => 'batchRequestId',
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
	$_GET['ID'] = $_POST['ID'] = hq("select ID from ciceksepetirapor where batchRequestId like '".$_GET['raporID']."'");
}
if ($_GET['ID']) {
	$batchRequestId = hq("select batchRequestId from ciceksepetirapor where ID='" . (int)$_GET['ID'] . "'");
	if ($batchRequestId) {
		require_once('../include/mod_Ciceksepeti.php');
		$tempInfo .= '<textarea class="rapor-goster">' . cs_getBatchRequestResult($batchRequestId) . '</textarea>';
	}
}

admin($dbase, $where, $icerik, $ozellikler);
?>