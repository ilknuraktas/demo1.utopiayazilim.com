<?php
$POST = $_POST;
$GET = $_GET;

if ($_GET['bank'] == 'shopier')
	$_SERVER['HTTPS'] = 'on';
	
include('include/all.php');
include_once "include/3rdparty/BKM/Bex/easy/Bex.php";
use Bex\easy\Bex;

switch ($_GET['bank']) {
	case 'bkm-taksit':
		$_GET['paytype'] = hq("select ID from banka where paymentModulURL like '%BKM%'");

		if(isset($_REQUEST['installment']) && $_REQUEST['installment'] == 'checkout'){ //Mikroservisden gelen isteğin karşılandığı yer.

			header('Content-type: application/json'); //Dönen response application/json formatında olmalıdır.

			$env = \Bex\enums\Environment::PREPROD;
			$merchantID = dbInfo('banka', 'clientID', $_GET['paytype']);
			$privateKey = dbInfo('banka', 'modData1', $_GET['paytype']);

			$bex=Bex::configure($env, $merchantID,$privateKey);

			$bex->installments(function ($installmentArray) {

				$installments = array();
			
				$totalAmountStr = $installmentArray["totalAmount"];
			
			
				$posConfig = BexUtil::vposConfig("vpos.json", $installmentArray['bank']);
			
				// iki taksit yapalım




				$qVade = my_mysql_query("select * from bankaVade where bankaID='".$_GET['paytype']."' order by ay,minfiyat desc");				
				while ($dVade = my_mysql_fetch_array($qVade)) {

					$installmentAmount = BexUtil::formatTurkishLira(
						BexUtil::toFloat($totalAmountStr) / 1.0
					);
					// 1.ci taksiti ayarlayalım.
					array_push($installments, array(
						'numberOfInstallment' => 1,
						'installmentAmount' => $installmentAmount,
						'totalAmount' => $totalAmountStr,
					//	'vposConfig' => $posConfig
					));


				}


			
				// iki taksit yapalım
				$installmentAmount = BexUtil::formatTurkishLira(
					BexUtil::toFloat($totalAmountStr) / 2.0
				);
			
				// 2. Taksiti ayarlayalım.
				array_push($installments, array(
					'numberOfInstallment' => 2,
					'installmentAmount' => $installmentAmount,
					'totalAmount' => $totalAmountStr,
					'vposConfig' => $posConfig
				));
				// Taksitleri bir array olarak dönelim.
				return $installments;
			});

		
	   }

		break;
	case 'shopier':
		if($_POST['platform_order_id'] == $_SESSION['shopierID'] && $_POST['payment_id'])
		{
			$_GET['paytype'] = hq("select ID from banka where paymentModulURL like '%payment_shopier%'");
			$callbackurl = $_SESSION['pt_callbackurl'] = 	("http" . (siteConfig('httpsAktif') ? 's' : 's') . "://" . $_SERVER['HTTP_HOST'] . $siteDizini . "page.php?act=satinal&op=odeme&paytype=" . $_GET['paytype'] . '&shopier-ok-c='.md5($_SESSION['randStr'].'_'.basketInfo('ModulFarkiIle',$_SESSION['randStr'])));
			redirect($callbackurl);
		}
		else
			redirect(slink('sepet'));
		/*
		$_GET['paytype'] = hq("select ID from banka where paymentModulURL like '%payment_shopier%'");
		$key = dbInfo('banka', 'modData3', $_GET['paytype']);
		$username = dbInfo('banka', 'clientID', $_GET['paytype']);
		if (!((isset($_POST['res'])) && (isset($_POST['hash'])))) {
			echo "missing parameter";
			die();
		}
		$hash = hash_hmac('sha256', $_POST['res'] . $username, $key, false);
		if (strcmp($hash, $_POST['hash']) != 0) {
			die();
		}
		$json_result = base64_decode($_POST['res']);
		$array_result = json_decode($json_result, true);
		$email = $array_result['email'];
		$orderid = $array_result['orderid'];
		list($p, $randStr) = explode('_', $orderid);
		$randStr = hq("select randStr from siparis where durum =0 AND email = '" . $array_result['email'] . "' order by ID desc limit 0,1");
		$currency = $array_result['currency']; 
		$price = $array_result['price'];
		$buyername = $array_result['buyername'];
		$buyersurname = $array_result['buyersurname'];
		$productcount = $array_result['productcount'];
		$productid = $array_result['productid'];
		$customernote = $array_result['customernote']; 
		$istest = $array_result['istest']; 
		logPost('notify',json_encode($array_result),$randStr);

		my_mysql_query("update siparis set notYonetici = 'Shopier_Success' where randStr = '" . $randStr . "'", 1);
		exit('success');
		*/
		break;
	case 'iyzico':
		$data = $_SESSION['randStr'] . "\n" . $_SERVER['REMOTE_ADDR'] . "\n" . date('m-d-Y H:i:s') . "\nGET : \n" . print_r($_GET, 1) . "\n JSON : " . debugArray(json_decode(file_get_contents('php://input'), true)) . " POST : \n" . print_r($_POST, 1) . "\n\n";
		file_put_contents("iyzico-" . date("y-m-d") . ".txt", $data, FILE_APPEND);
		$r = json_decode(file_get_contents('php://input'), true);

		$mID = hq("select ID from banka where clientID = '" . addslashes($r['merchantId']) . "'");
		if (!$mid)
			exit('Hatalı Merchant ID');
		if ($r['status'] != 'SUCCESS')
			exit('Başarısız İşlem');

		$durum = (int) hq("select durum from siparis where randStr like '" . addslashes($r['paymentConversationId']) . "'");
		if (!$durum || $durum == 1) {
			$_SESSION['randStr'] = $r['paymentConversationId'];
			$_GET['success'] = 1;
			$_GET['act'] = 'satinal';
			$_GET['op'] = 'odeme';
			$tamamlandi = true;
			$sepetTemizle = true;
			$odemeDurum = 2;
			$modulDosya = hq("select paymentModulURL from banka where paymentModulURL like '%iyzico%' AND active = 1 order by ID desc");
			$odemeTipi = hq("select bankaAdi from banka where paymentModulURL like '%iyzico%' AND active = 1 order by ID desc");
			//spPayment::finalizePayment();
		}
		logPost('notify',json_encode($r),$r['paymentConversationId']);
		mysql_query("update siparis set data1='OK', notYonetici = concat(notYonetici,'Notify : " . debugArray(json_decode(file_get_contents('php://input'), true)) . "' where randStr = '" . addslashes($r['paymentConversationId']) . "'");
		exit('200');
		break;
	case 'gpay':
		if ((sizeof($_GET) || sizeof($_POST)) && basename($_SERVER['SCRIPT_FILENAME']) != 'resize.php') file_put_contents("files/ipn-log-" . date("y-m-d") . ".txt", $data, FILE_APPEND);

		$_GET['paytype'] = hq("select ID from banka where paymentModulURL like '%payment_gpay%'");
		$bayiiKey = hq("select password from banka where ID='" . $_GET['paytype'] . "'");
		$callback_ip = ["185.197.196.99", "185.197.196.51"];

		$has_ip = false;

		/**
		 * Gelen verileri değişkene atıyoruz. Lütfen test ederken ve hatta üretimde dahi bu gelen verilerin logunu tutunuz.
		 */

		$callback_data = $_POST;
		$siparis_id = $callback_data['siparis_id'];
		$tutar = $callback_data['tutar'];
		$islem_sonucu = $callback_data['islem_sonucu'];
		logPost('notify',json_encode($callback_data),$siparis_id);

		$tutarSite = hq("select toplamTutarTL from siparis where data1 = '$siparis_id' OR randStr = '$siparis_id'");

		if ($islem_sonucu == 2)
			my_mysql_query("update siparis set data2='OK' where data1 = '$siparis_id'");
		else
			my_mysql_query("update siparis set data2='" . addslashes(($callback_data['islem_mesaji'])) . "' where data1 = '$siparis_id'");

		$hash = md5(base64_encode(substr($bayiiKey, 0, 7) . substr($siparis_id, 0, 5) . strval($tutar) . $islem_sonucu));

		if (getenv("HTTP_CLIENT_IP")) {
			$ip = getenv("HTTP_CLIENT_IP");
		} elseif (getenv("HTTP_X_FORWARDED_FOR")) {
			$ip = getenv("HTTP_X_FORWARDED_FOR");
			if (strstr($ip, ',')) {
				$tmp = explode(',', $ip);
				$ip = trim($tmp[0]);
			}
		} else {
			$ip = getenv("REMOTE_ADDR");
		}

		foreach ($callback_ip as $c_ip) {
			if ($ip === $c_ip) {
				$has_ip = true;
				break;
			}
		}

		if ($hash != $callback_data['hash']) {
			exit('4 - ' . $hash . ':' . $callback_data['hash']);
		}

		// burada siparis id ye göre diğer verileri çekeceğiz. örn $res = mysql_fetch_object(mysql_query("select * from table where siparis_id='$siparis_id'"))
		// burada örnek bir row yapıyorum burasını yukarıdaki gibi değiştirebilirsiniz
		$res = (object) array('tutar' => "3.50");
		if (!$res->tutar) {
			die('2');
		}
		if ((int)$tutarSite > (int)$tutar) {
			die('5');
		}
		// burada kendinize özel bir kontrol yapıp eğer hatalı sonuç döndürürse ekrana 3 yazabilirsiniz. örn: die('3') gibi...
		// ...
		//	my_mysql_query("update siparis set durum = 2 where data1 = '$siparis_id' OR randStr = '$siparis_id'");
		// eğer tüm kontroller tamamsa
		echo "1";
		exit();
		break;
}

function ArrayExpand($array)
{
	$retval = "";
	for ($i = 0; $i < sizeof($array); $i++) {
		$size       = strlen(StripSlashes($array[$i]));
		$retval .= $size . StripSlashes($array[$i]);
	}

	return $retval;
}

function hmac($key, $data)
{
	$b = 64; // byte length for md5
	if (strlen($key) > $b) {
		$key = pack("H*", md5($key));
	}
	$key  = str_pad($key, $b, chr(0x00));
	$ipad = str_pad('', $b, chr(0x36));
	$opad = str_pad('', $b, chr(0x5c));
	$k_ipad = $key ^ $ipad;
	$k_opad = $key ^ $opad;
	return md5($k_opad  . pack("H*", md5($k_ipad . $data)));
}
