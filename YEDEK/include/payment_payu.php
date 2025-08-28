<?
	//error_reporting(E_ALL);
	function ic($str)
	{
		return iconv('iso-8859-9','utf-8',$str);
	}
	// require_once 'payu/CLASSES/PayuLiveUpdate.class.php';
	
	if (!$_GET['paytype'] && $_GET['type']) $_GET['paytype'] = $_GET['type'];
	if ($_SESSION['taksit'] && !$_POST['taksit']) $_POST['taksit'] = $_SESSION['taksit'];
	if (!($_POST['taksit'] > 1))$_POST['taksit']='1';
	$suAnkiToplamOdeme = basketInfo('ModulFarkiIle',$_SESSION['randStr']);
	$total = my_money_format('%i',taksitliOdemeHesalpa($suAnkiToplamOdeme,$_POST['taksit']?$_POST['taksit']:1,$_GET['paytype']));
	$total = str_replace(',','',$total);
	$taksitString = ($_POST['taksit'] ? $_POST['taksit'].' Taksit':'Peşin');
	$odemeTipi 			=  dbInfo('banka','bankaAdi',$_GET['paytype']).' ('.$taksitString.' - '.$total.')';	
	$odemeDurum = 2;
	
	$qs = my_mysql_query("select * from siparis where randStr like '".$_SESSION['randStr']."' limit 0,1");
	$ds = my_mysql_fetch_array($qs);
	
	$payuTax = 0;
	$qSepet = my_mysql_query("select * from sepet where randStr like '".$_SESSION['randStr']."'");
	while($dSepet = my_mysql_fetch_array($qSepet))
	{
		$tax = hq("select kdv from urun where ID='".$dSepet['urunID']."'");
		$payuTax = max($tax,$payuTax);
	}
	
	$_SESSION['payu_DS'] = $ds;
	$_SESSION['payu_DS']['total'] = $total;
	$_SESSION['payu_DS']['tax'] = ($payuTax * 100);
	$_SESSION['payu_DS']['username'] = hq("select username from banka where ID='".$_GET['paytype']."'");
	$_SESSION['payu_DS']['password'] = hq("select password from banka where ID='".$_GET['paytype']."'");	
	$_SESSION['payu_DS']['cityname'] = hq("select name from iller where plakaID= '".$ds['city']."' limit 0,1");
	$_SESSION['payu_DS']['statename'] = hq("select name from ilceler where ID= '".$ds['semt']."' limit 0,1");
	$type = $_POST["type"];

	$okUrl = $_SESSION['payu_DS']['okUrl'] = ($siteConfig['httpsAktif'] ?'https://':'http://').$_SERVER['HTTP_HOST'].$siteDizini.'page.php?act=posOK';	
	$failUrl =  $_SESSION['payu_DS']['failUrl'] = ($siteConfig['httpsAktif'] ?'https://':'http://').$_SERVER['HTTP_HOST'].$siteDizini.'page.php?act=posFail';
	$_SESSION['okURL'] = $okUrl;
	$_SESSION['failURL'] = $failUrl;
	
	if ($_GET['paytype'])
	{
		$_SESSION["postData"] = $_POST;
		$_SESSION["postData"]['paytype'] = $_GET['paytype'];
		$_SESSION['paytype'] = $_GET['paytype'];
	}
	if ($_GET['result'])
	{
		$tamamlandi = true;
		$sepetTemizle = true;
	}
	
	
	$form = '<br /><br /><form method="post" action="include/payment_payu-gateway.php" id="payu">
				<input type="submit" id="generate" name="submit" value="Lütfen bekleyin" style="border:0; background:none; color:black;">
				</form><script>$(\'#generate\').click();</script>';

	
function payment() {
	global $siteConfig,$stop,$tamamlandi,$msg,$errmsg,$suAnkiToplamOdeme,$bankaMesaj,$numpad,$liveUpdate,$form;
	if ($_POST['errmsg']) $errmsg = $_POST['errmsg'];
	if (!$tamamlandi) {
		$action = ($siteConfig['seoURL'] ? 'satinal_sp__op-odeme,paytype-'.$_GET['paytype'].'.html' : 'page.php?act=satinal&op=odeme&paytype='.$_GET['paytype']);
		$out.='<img src="images/banka/'.hq("select odemeLogo from banka where ID='".$_GET['paytype']."'").'">';
		if ($errmsg) $out.='<br><br><span style="color:red; font-weight:bold;">'.utf8fix($errmsg).'<br>'.utf8fix($bankaMesaj).'</span>';
	$out.=$form;
	
	}
	else {
		
		$out  = 'Durum : Ödeme onaylandı.<br>';
		$out.= spPayment::finalizePayment();
	}
	return $out; 
}
?>