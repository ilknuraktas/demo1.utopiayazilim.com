<?php
	class SanalPos{
	
		public $Rop		= array('Rop', 'ConfigFile', 'PostData', 'error_code');
		public $ConfigFile	= 'include/sanalpos/est-pos.xml';
		public $PostData	= NULL;
		public $CreditCard;			# Kredi Kart� Numaras�
		public $Expires;				# Son Kullanma Tarihi (05/08)
		public $CVV2;					# G�venlik Numaras�
		public $Total;					# Toplam Tutar
		public $Installment;			# Taksit Say�s�
		public $CurrencyCode	= 949;	# Para Birimi (YTL)
		public $Live			= 'T';	# Demo Mode
		public $Name;					# Kullan�c� �sim/Soyisim
		public $Url;
		public $ClientID;
		public $Username;
		public $Password;
		public $OrderID;
		public $IPAddress;
		public $Email;
		public $Bolum;
		
		private $error_code	= array(
			'00'	=> '��LEM BA�ARISIZ.',
			'01'	=> 'BANKANIZDAN PROV�ZYON ALDINIZ.',
			'02'	=> 'BANKANIZDAN PROV�ZYON ALDINIZ. (visa)',
			'05'	=> '��LEM ONAYLANMADI.',
			'06'	=> '��LEM�N�Z KABUL ED�LMED�.',
			'12'	=> 'GE�ERS�Z ��LEM.',
			'13'	=> 'GE�ERS�Z TUTAR B�LG�S�.',
			'14'	=> 'GE�ERS�Z KART NUMARASI.',
			'16'	=> 'YETERS�Z BAK�YE.',
			'17'	=> '��LEM �PTAL ED�LD�.',
			'38'	=> '�ifre giri� limiti a��ld�.',
			'54'	=> 'VADES� DOLMU� KART.',
			'61'	=> 'Limit a��m�! ��lem ger�ekle�tirilemiyor.',
			'63'	=> 'BU ��LEM� YAPMAYA YETK�L� DEG�LS�N�Z.',
			'65'	=> 'G�NL�K ��LEM L�M�T�N�Z DOLMU�.',
			'76'	=> '�ifre do�rulanam�yor.',
			'82'	=> 'HATALI CVV KODU.',
			'83'	=> '��FRE DOGRULANMIYOR.',
			'86'	=> '��FRE DOGRULANMIYOR.',
			'96'	=> 'S�STAM HATASI.'
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

			return 'Bilinmeyen hata olu�tu. Hata kodu : <strong>'. $code .'</strong><br />';
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