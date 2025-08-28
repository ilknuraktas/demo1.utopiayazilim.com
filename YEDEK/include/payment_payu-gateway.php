<? @session_start();
error_reporting('~E_NOTICE & ~E_DEPRICATED % E_ALL'); 
ini_set('display_errors', '0');
?>
<html>
<body>
<style>
input { background-color:white; color:black; border:none; }
</style>
<?php
$ds = $_SESSION['payu_DS'];

foreach($ds as $k=>$v)
{
	if(!is_array($d[$k])) $ds[$k] = $v;	
}
//echo '<pre>'.print_r($ds,1).'</pre>';
require_once 'payu/CLASSES/PayuLiveUpdate.class.php';

$liveUpdate = new PayuLu($ds['username'], $ds['password']);
//for see error
$liveUpdate->setDebug(PayuLu::DEBUG_ALL);

$siparis = new PayuProduct($_SESSION['randStr'].' nolu Siparis Odemesi', $_SESSION['randStr'], $_SESSION['randStr'].' nolu Siparis Odemesi', $ds['total'], PayuProduct::PRICE_TYPE_GROSS, '1',$_SESSION['payu_DS']['tax']);
$liveUpdate->addProduct($siparis);

$billing = new PayuAddress();
$billing->setFirstName($ds['name']); //mandatory
$billing->setLastName($ds['lastname']); //mandatory
$billing->setEmail($ds['email']); //mandatory


$billing->setPhone(str_replace('-','',$ds['ceptel']));
$billing->setAddress($ds['address2']?$ds['address2']:$ds['address']);
$billing->setAddress2('');
$billing->setZipCode('12345');
$billing->setCity($ds['cityname2']?$ds['cityname2']:$ds['cityname']);
$billing->setState($ds['statename2']?$ds['statename2']:$ds['statename']);

$liveUpdate->setBillingAddress($billing); //mandatory


$delivery = new PayuAddress();
$delivery->setFirstName($ds['name']);
$delivery->setLastName($ds['lastname']);
$delivery->setEmail($ds['email']);
$delivery->setPhone(str_replace('-','',$ds['ceptel']));
$delivery->setAddress($ds['address']);
$delivery->setAddress2('');
$delivery->setZipCode('12345');
$delivery->setCity($ds['cityname']);
$delivery->setState($ds['statename']);

$liveUpdate->setDeliveryAddress($delivery);

$liveUpdate->setLanguage('TR');

$liveUpdate->setInstalments("");
$liveUpdate->setOrderShipping("");

$liveUpdate->setBackRef($ds['okUrl']);

$liveUpdate->setButtonName('Lutfen bekleyin.. Yonlendiriliyorsunuz..');


$t = $liveUpdate->renderPaymentForm();
echo $t;
?>
<script>
document.getElementById('payForm').submit();
</script>
</body></html>