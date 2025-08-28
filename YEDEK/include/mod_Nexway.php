<?php
/* Gelen Siparişler

	if ($oncekiDurum == 1 && $_POST['durum'] > 1)
	{
			require('../include/mod_Nexway.php');
		echo modAfterPayment($_POST['durum'],$_POST['randStr']);
	}	

if ($mailCode == 'Siparis_Iptali')
			{
				ini_set ('soap.wsdl_cache_enabled', '0');
				$soap = new SoapClient(
							'https://webservices.nexway.com/global/order/v2.3/soap?wsdl',
							array(
								'wsdl_cache' =>  0,
								'trace' =>  true,
								'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
							)
				);
				
				$orderCancel = array(
				'secret' => 'civvwr8',
				'request' => array(
					 'partnerOrderNumber' =>  $_POST['randStr'],
							 'reasonCode' =>  2,
						 'comment' =>  'Order Cancelled'
				)
			);
			
			// sending create request
			
			try {
				// cancel order
				$result = $soap->cancel($orderCancel);
			} catch (Exception $e) {                                                            // A SOAP Fault occurs if the secret is not correct
				echo $soap->__getLastResponse();
			
				// handle error
				var_dump($e, $e->faultcode, $e->faultstring, $result);
				echo $e->xdebug_message;
			}

				$q2 = my_mysql_query("select * from sepet where randStr = '$siparisID'");
				while($d2=my_mysql_fetch_array($q2))
				{
					Sepet::urunStokGuncelle($d2['ID'],1);
					$total = (int)hq("select sum(adet) from sepet where urunID='".$d2['urunID']."' AND randStr='$siparisID'");
					my_mysql_query("update urun set sold = (sold - $total)  where ID='".$d['urunID']."'");						
				}			
			}
			
*/

/* Şablon lib.php
if($_POST['data_sn'])
{

ini_set ('soap.wsdl_cache_enabled', '0');
				$soap = new SoapClient(
							'https://webservices.nexway.com/global/order/v2.3/soap?wsdl',
							array(
								'wsdl_cache' =>  0,
								'trace' =>  true,
								'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
							)
				);
				
				$orderCancel = array(
				'secret' => 'civvwr8',
				'request' => array(
					 'partnerOrderNumber' =>  $_POST['data_sn'],
					 'value' =>  date('Y-m-d')
				)
			);
			
			// sending create request
			
			try {
				// cancel order
				$result = $soap->updateDownloadTime ($orderCancel);
			//	echo print_r($result,1);
			} catch (Exception $e) {                                                            // A SOAP Fault occurs if the secret is not correct
				//echo $soap->__getLastResponse();
			
				// handle error
				//var_dump($e, $e->faultcode, $e->faultstring, $result);
				//echo $e->xdebug_message;
			}
}

if($_GET['urunID'])
{
	$code = hq("select tedarikciCode from urun where ID='".$_GET['urunID']."' AND tedarikciID=157");	
	if($code)
	{
			ini_set ('soap.wsdl_cache_enabled', '0');
				$soap = new SoapClient(
							'https://webservices.nexway.com/global/order/v2.3/soap?wsdl',
							array(
								'wsdl_cache' =>  0,
								'trace' =>  true,
								'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
							)
				);
				
				$type = array(
				'secret' => 'civvwr8',
	      	   'request' =>  array(
	                 'productRef' =>  array(
		                0 =>  $code
		            )
			  )
			);		
			$result = $soap->getStockStatus($type);
			$stok = $result->out->productStatus->getStockStatusproductStatusResponseType[0]->status;
			switch($stok)
			{
				case 200:
				case '200':
					$stok = 30;
				break;
				case 300:
				case '300':
					$stok = 0;
				break;	
			}
			
			my_mysql_query("update urun set stok = '$stok' where ID = '".$_GET['urunID']."'");
			//echo "<pre>".print_r($result,1)."</pre>";

	}
}
*/

function modAfterPayment($odemeDurum,$randStr)
{
	global $siteConfig;
	if($odemeDurum > 1)	
	{
		$out = nexwayCreateOrder($randStr);
		if(!$out) return;
		$header = getHeaders(siteConfig('adminMail'));
		$mail = new spEmail();
		$mail->headers = $header;
		$mail->to = hq("select email from siparis where randStr like '".$randStr."' limit 0,1");
		$mail->subject = 'Yazılım Sipariş Bilgileri';
		$mail->body = $out;			
		$mail->send();
		
		$mail->subject = 'Yazılım Sipariş Bilgileri E-Posta Kopyası ('.$randStr.')';
		$mail->to = siteConfig('adminMail');
		$mail->send();		
	}
	return $out.'ÖDeme Durum : '.$odemeDurum;
}

function nexwayCreateOrder($randStr)
{
	$data1 = hq("select data3 from siparis where randStr like '$randStr'");
	if($data1x) 
		return $data1;
	if($_SESSION['nexwayx_'.$randStr]) 
		return $_SESSION['nexway_'.$randStr];
	$q = my_mysql_query("select * from siparis where randStr like '".$randStr."' limit 0,1");
	$d = my_mysql_fetch_array($q);
	
	$q2 = my_mysql_query("select * from sepet where randStr like '".$randStr."'");
	while($d2 = my_mysql_fetch_array($q2))
	{
		if(hq("select tedarikciID from urun where ID='".$d2['urunID']."'") == '157')
		{
		$orderLinesType[] = array(
						'vatRate'       =>  18,
						'amountTotal'   =>  $d2['fiyat'],
						'productRef'    =>  hq("select tedarikciCode from urun where ID='".$d2['urunID']."'"),                     
						'amountDutyFree'=>  NULL,
						'quantity'      => $d2['adet']
					);
		}
	}
	if(!is_array($orderLinesType))
		return;
	ini_set ('soap.wsdl_cache_enabled', '0');
	$soap = new SoapClient(
				'https://webservices.nexway.com/global/order/v2.3/soap?wsdl',
				array(
					'wsdl_cache' =>  0,
					'trace' =>  true,
					'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
				)
	);
	//echo "<pre>Debug Soap : ".print_r($soap,1)."<br><br></pre>";
	$orderCreate = array(
		'secret' =>  'civvwr8',               // Provide your 'secret'
		'request' =>  array(
			'customer' =>  array(                   // Set your customer details
				 'locationInvoice' =>  array(
					'title'       =>  1,
					'firstName'   =>  tr2eu($d['name']),
					'lastName'    =>  tr2eu($d['lastname']),
					'address1'    =>  tr2eu($d['address']),
					'companyName' =>  NULL,
					'zipCode'     =>  NULL,
					'city'        =>  tr2eu(hq("select name from iller where plakaID='".$d['city']."'")),
					'country'     =>  'TR',
				),
				'email'     =>  $d['email'],
				'language'  =>  'en_XE',
			),
			'partnerOrderNumber' =>  (string)$randStr,     // Provide your system order number
			'marketingProgramId' =>  NULL,
			'orderLines' =>  array(
				'createOrderLinesType' =>  $orderLinesType
			),
			'currency'  =>  'EUR',                                        // Your catalog feed currency
			'orderDate' =>  date('Y-m-d').'T'.date('H:i:s').'+0'.date('I').':00',                  // The order date
		)
	);	

	//echo "<pre>Debug Order Create : ".print_r($orderCreate,1)."<br><br></pre>";
			$result = $soap->create($orderCreate);
			$xml = $soap->__getLastResponse();
	//	echo "<pre>$xml</pre>";
		//print_r($soap->create($orderCreate),1).
	//	echo "<pre>Debugx1 : ".print_r($result,1)."<br><br></pre>";
	try 
	{
	
		// create order
	//	$result = $soap->create($orderCreate);
	//	echo "<pre>Debugx : ".print_r($result,1).$result."<br><br></pre>";
	
		// display xml return
		//$xml = $soap->__getLastResponse();
	
		// xml return handling
		
		if ($result->out->responseCode != '0')
		{
			$dataRequest = array(
				'secret' => 'civvwr8',
				'request' => array(
					'partnerOrderNumber' => $randStr 
				)
			);

			$result = $soap->getData($dataRequest);
		}
	
		if ($result->out->responseCode == '0' || is_array($dataRequest)) {    // If the order processed successfully, we retrieve the data
			my_mysql_query("update siparis set data4 = '".$result->out->orderNumber."' where randStr like '".$_SESSION['randStr']."'");
			$out.="<B>Ödeme Onaylandı</B><BR />";
			$out.="Tedarikçi Sipariş Numarası : "   . $result->out->orderNumber . "<BR />";
			$out.="Alindirkullan.com Sipariş Numarası : "  . $result->out->partnerOrderNumber . "<BR />";
	
			$out.="<B>Sipariş :</B><BR />---<BR />---<BR />";
			
			if(sizeof($result->out->orderLines->getDataOrderLineResponseType))
				$result->out->orderLines->createOrderLineResponseType = $result->out->orderLines->getDataOrderLineResponseType;
				

				
			if(sizeof($result->out->lineItems->getDataLineItemResponseType))
				$result->out->lineItems->createLineItemResponseType = $result->out->lineItems->getDataOrderLineResponseType;
				
			foreach ($result->out->orderLines->createOrderLineResponseType as $orderLine) {
				$out.="<B>Ürün Ref: </B>" . $orderLine->productRef . "<BR />";
				$out.="Tarih ve Download: "  . $orderLine->dateEndDownload . "<BR />";
				
				if(sizeof($orderLine->lineItems->getDataLineItemResponseType))
					$orderLine->lineItems->createLineItemResponseType = $orderLine->lineItems->getDataLineItemResponseType;
				
				foreach ($orderLine->lineItems->createLineItemResponseType as $lineItem) {
					$out.="<B>Aktivasyon Kodu(Kodları): </B><BR />---<BR />";
					
					if(sizeof($lineItem->serials->getDataSerialResponseType))
						$lineItem->serials->createSerialResponseType =$lineItem->serials->getDataSerialResponseType;
					
					
					foreach ($lineItem->serials->createSerialResponseType as $serial) {
						$out.="<LI>Veri : "      . $serial->data . "<BR />";
						$out.="<LI>Kodlama : "  . $serial->encoding . "<BR />";
						$out.="<LI>Karakter Seti : "   . $serial->charset . "<BR />";
						$out.="<LI>Dosya Adı : " . $serial->fileName . "<BR />";
						$out.="---<BR />";
					}
				}
				$out.="<B>Files : </B><BR />---<BR />";
				
									
					if(sizeof($orderLine->files->getDataFileResponseType))
						$orderLine->files->createFileResponseType =$orderLine->files->getDataFileResponseType;
						
				foreach ($orderLine->files->createFileResponseType as $file) {
					$out.="<LI>Adı : "  . $file->label . "<BR />";
					$out.="<LI>Tür : "  . $file->type . "<BR />";
					$out.="<LI>Adres : "   . $file->url . "<BR />";
					$out.="<LI>Uzunluk : "  . $file->size . "<BR />";
					$out.="<LI>Grup : " . $file->group . "<BR />";
					$out.="---<BR />";
				}
				$out.="Not : " . $orderLine->remark . "<BR />---<BR />---<BR />";
			}
	
			$out.="<B>İndirme Yöneticisi : </B><BR />";
			$out.="<UL>";
			$out.="<LI> PC: "   . $result->out->downloadManager->pc;
			$out.="<LI> MAC: "  . $result->out->downloadManager->mac;
			$out.="</UL>";
			//$out.="Dönüş Kodu : "     . $result->out->responseCode . "<BR />";
			//$out.="Dönüş Mesajı  : "  . $result->out->responseMessage . "<BR />";
	
			// $out.="<BR /><B>Real Return:</B><BR />";
			// $out.="<PRE>" . print_r($result,true) . "</PRE>";
		} else {                                                                        // If an error occured in order processing, we have to handle the error
			$out.="Hata Oluştu !!";
			$out.="<BR /> Dönüş Kodu : "      . $result->out->responseCode . "<BR />";
			$out.="<BR /> Dönüş Mesajı : "   . $result->out->responseMessage . "<BR />";
			
		}
	
	} catch (Exception $e) {                                                            // A SOAP Fault occurs if the secret is not correct
		$out.='Hata : '.$soap->__getLastResponse();
	
		// handle error
		echo var_dump($e, $e->faultcode, $e->faultstring, $result);
		$out.=$e->xdebug_message;
	}
	//echo "<pre>Debug : ".print_r($result,1)."<br><br></pre>";
	$out = utf8fix($out);
	my_mysql_query("update siparis set notYonetici = '$out"."<br><br>".addslashes($out)."',data3='".addslashes($out)."' where randStr like '$randStr'");
	//echo "update siparis set notYonetici = '$out"."<br><br>".print_r($result,1)."',data3='".$out."' where randStr like '$randStr'";
	//$_SESSION['nexway_'.$randStr] = $out;
	//echo $out;
	return $out;
}
?>