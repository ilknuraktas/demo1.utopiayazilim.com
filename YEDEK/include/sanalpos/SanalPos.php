<?php
	class SanalPos{
	
		public $Rop		= array('Rop', 'ConfigFile', 'PostData', 'error_code');
		public $ConfigFile	= 'include/sanalpos/est-pos.xml';
		public $PostData	= NULL;
		public $CreditCard;			# Kredi Kartý Numarasý
		public $Expires;				# Son Kullanma Tarihi (05/08)
		public $CVV2;					# Güvenlik Numarasý
		public $Total;					# Toplam Tutar
		public $Installment;			# Taksit Sayýsý
		public $CurrencyCode	= 949;	# Para Birimi (YTL)
		public $Live			= 'T';	# Demo Mode
		public $Name;					# Kullanýcý Ýsim/Soyisim
		public $Url;
		public $ClientID;
		public $Username;
		public $Password;
		public $OrderID;
		public $IPAddress;
		public $Email;
		public $Bolum;
		
		private $error_code	= array(
			'00'	=> 'ÝÞLEM BAÞARISIZ.',
			'01'	=> 'BANKANIZDAN PROVÝZYON ALDINIZ.',
			'02'	=> 'BANKANIZDAN PROVÝZYON ALDINIZ. (visa)',
			'05'	=> 'ÝÞLEM ONAYLANMADI.',
			'06'	=> 'ÝÞLEMÝNÝZ KABUL EDÝLMEDÝ.',
			'12'	=> 'GEÇERSÝZ ÝÞLEM.',
			'13'	=> 'GEÇERSÝZ TUTAR BÝLGÝSÝ.',
			'14'	=> 'GEÇERSÝZ KART NUMARASI.',
			'16'	=> 'YETERSÝZ BAKÝYE.',
			'17'	=> 'ÝÞLEM ÝPTAL EDÝLDÝ.',
			'38'	=> 'Þifre giriþ limiti aþýldý.',
			'54'	=> 'VADESÝ DOLMUÞ KART.',
			'61'	=> 'Limit aþýmý! Ýþlem gerçekleþtirilemiyor.',
			'63'	=> 'BU ÝÞLEMÝ YAPMAYA YETKÝLÝ DEGÝLSÝNÝZ.',
			'65'	=> 'GÜNLÜK ÝÞLEM LÝMÝTÝNÝZ DOLMUÞ.',
			'76'	=> 'Þifre doðrulanamýyor.',
			'82'	=> 'HATALI CVV KODU.',
			'83'	=> 'ÞÝFRE DOGRULANMIYOR.',
			'86'	=> 'ÞÝFRE DOGRULANMIYOR.',
			'96'	=> 'SÝSTAM HATASI.'
		);
		
		private function __get($key){
			if(array_key_exists($key, get_class_vars(__CLASS__))){
				return $this->{$key};
			}
			
			//trigger_error('<strong>'. $key .'</strong> property cannot be found in <strong>'. __CLASS__ .'</strong> class', E_USER_ERROR);
		}
		
		private function __set($key, $value){
			if($this->is_readonly($key) === FALSE){
				if(array_key_exists($key, get_class_vars(__CLASS__))){
					$this->{$key} = $value;
				}
				else{
					//trigger_error('<strong>'. $key .'</strong> property cannot be found in '. __CLASS__ .' class', E_USER_ERROR);
				}
			}
			else{
				trigger_error('<strong>'. $key .'</strong> is readyonly!', E_USER_ERROR);
			}
		}

		private function is_readonly($key){
			return in_array($key, $this->Rop) ? TRUE : FALSE;
		}

		public function __construct(){
			if(file_exists($this->ConfigFile)){
				$this->PostData = file_get_contents($this->ConfigFile);
			}
			else{
				trigger_error('<strong>'. $this->ConfigFile .'</strong> is not found!', E_USER_ERROR);
			}
		}
		
		private function this_callback($matches){
			eval('$var = $this->'. $matches[1] .';');
				return $var;
		}

		private function self_callback($matches){
			eval('$var = self::'. $matches[1] .';');
				return $var;
		}

		private function &xml_parser($data){
			if(!class_exists('XmlToArray')){
				require_once('XmlToArray.class.php');
			}

			$xml = new XmlToArray($data);
				return $xml->createArray();
		}

		public function getError($code){
			if(array_key_exists($code, $this->error_code)){
				return $this->error_code[$code];
			}

			return 'Bilinmeyen hata oluþtu. Hata kodu : <strong>'. $code .'</strong><br />';
		}
		
		public function send(){
			if(!empty($this->PostData)){
				$this->PostData = preg_replace_callback("/\{:([a-zA-Z0-9]+):\}/",  array($this, 'this_callback'), $this->PostData);
				// $this->PostData = preg_replace_callback('/\[:([a-zA-Z0-9_]+):\]/', array($this, 'self_callback'), $this->PostData);
				
				$ch =	curl_init();
						curl_setopt($ch, CURLOPT_URL, $this->Url);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
						curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
						curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type' => 'text/xml'));
						// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
						curl_setopt($ch, CURLOPT_POST, TRUE);
						curl_setopt($ch, CURLOPT_POSTFIELDS, 'DATA='. urlencode($this->PostData));

				$result = curl_exec($ch);

				if(curl_errno($ch)){
					return FALSE;
				}
				else{
					$data =& $this->xml_parser($result);
				//	print '<pre>'. print_r($data, TRUE) .'</pre>';
					return $data;
				}

				curl_close($ch);
			}

			return FALSE;
		}
	}
?>