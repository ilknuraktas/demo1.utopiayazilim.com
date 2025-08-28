<?php
error_reporting('~E_NOTICE & ~E_DEPRICATED % E_ALL'); 
ini_set('display_errors', '0');
require_once('../session.php');
require_once(dirname(__FILE__)."/sdk/openpayu.2.0.php");

$account = $_SESSION['payu_DS']['username'];

$orderCreateRequest = array (
	'ReqId' => OpenPayU::gen_uuid(), 
	'CustomerIp' => $_SERVER['REMOTE_ADDR'], //merchant server IP
	'ExtOrderId'=>'ExtOrderId0', //order ref in merchant system
	'MerchantPosId' => $account, // merchant account id
	'Description' => $_POST['Description'],
	'CurrencyCode' => 'TRY',
	'TotalAmount' => $_POST['Amount'], 
	'Buyer' => array(
		'FirstName' => $_POST['FirstName'], 
		'LastName' => $_POST['LastName'], 
		'CountryCode' => 'tr',
		'Email' => $_POST['Email'],
		'PhoneNumber' => $_POST['Phone'],				
		'Language' => 'tr',				
	),
	'Products' => array(
		array (
			'Product' => array(
				'Name' => $_POST['Description'],
				'UnitPrice' => $_POST['Amount'], 
				'Quantity' => '1',
			)
		)
	),
	'PayMethod' => 'DEFAULT'
);

OpenPayU_Configuration::setSignatureKey($_SESSION['payu_DS']['password']);
OpenPayU_Configuration::setEnvironment("https://secure.payu.com.tr/openpayu/v2/");

$orderCreateResponse = OpenPayU_Order::create($orderCreateRequest);
//die($orderCreateResponse);
header('Content-type: application/json');
echo json_encode(new SimpleXMLElement($orderCreateResponse));
die();	
?>