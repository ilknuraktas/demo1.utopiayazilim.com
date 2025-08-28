<?php
require_once("../nusoap/nusoap.php");

class Banka {
	public $kod;
	public $ad;
	public $taksitOranlari;
	//kenan
	public $ek_taksit;
}

class Telpa3DOdemeSistemi {

	private $wsdlAdresi = "https://www.telpabayi.com/3DEntegrasyon/3DPay.asmx?WSDL";
	private $soapAyarlari = array(
					'soap_version' => 2, //SOAP_1_2,
					'exceptions' => false,
					'trace' => true,
					'cache_wsdl' => 0, //WSDL_CACHE_NONE,
					'compression' => 48, //SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
					'encoding' => 'UTF-8'
				);



	public function BankalariAl() {
		$client = $this->SoapClientiHazirla();
		
		$result = $client->call('Banka', array());
		
		$bankalar = array();

		foreach( $result["BankaResult"]["diffgram"]["DocumentElement"]["banka"] as $b){
			$bk = (string)$b["BANKA_KOD"];
			$ba = (string)$b["BANKA"];
			$ts = (int)$b["TAKSIT_SAYISI"];
			$or = (float)$b["ORAN"];
			// kenan
			$es = (string)$b["EK_TAKSIT"];
			
			$banka = '';
			
			if(!array_key_exists($bk,$bankalar)){
				$banka = new Banka();
				$banka->kod = $bk;
				$banka->ad = $ba;
				$banka->taksitOranlari = array();
				// kenan
				$banka->ek_taksit = $es;
			}
			else {
				$banka = $bankalar[$bk];
			}
			
			$banka->taksitOranlari[$ts] = $or;
			
			$bankalar[$bk] = $banka; 
		}

		return $bankalar;
	}

	public function SeansiAc($bayiKodu, $successUrl, $errorUrl){
	
		$client = $this->SoapClientiHazirla();
		
		$result = $client->call('GetSession', array("gsr"=>array("BayiKod" => $bayiKodu, "SuccessURL" => $successUrl, "ErrorURL" => $errorUrl)));

//		var_dump($client->request);
//		var_dump($client->response);

		if($result && isset($result["GetSessionResult"]) && isset($result["GetSessionResult"]["Session"]) && $result["GetSessionResult"]["Session"] && $result["GetSessionResult"]["Session"] != "")
		{
			return $result["GetSessionResult"]["Session"];
		}
		
		if($result && isset($result["GetSessionResult"]) && isset($result["GetSessionResult"]["Error"]) && $result["GetSessionResult"]["Error"] && $result["GetSessionResult"]["Error"] != "")
		{
			throw new Exception("Sunucuda hata oluştu : " .  $result["GetSessionResult"]["Error"]);
		}

		throw new Exception("Bağlantı sırasında hata oluştu : " . $result);
	}
		
	private function SoapClientiHazirla() {
		// return new SoapClient($this->wsdlAdresi,$this->soapAyarlari);
		$a = new nusoap_client($this->wsdlAdresi, 'wsdl', '', '', '', '');		
		$err = $a->getError();
		if ($err) {
			echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
		}
		//var_dump($err);
		$a->soap_defencoding = 'UTF-8';
		$a->decode_utf8 = false;
		return $a;		
	}

}

	//$a = new Telpa3DOdemeSistemi();

	//var_dump($a->BankalariAl());
	//var_dump($a->TaksitleriAl('B0101'));
	//var_dump($a->SeansiAc(54875, 'http://www.telpabayi.com/true', 'http://www.telpabayi.com/false'));
	?>
