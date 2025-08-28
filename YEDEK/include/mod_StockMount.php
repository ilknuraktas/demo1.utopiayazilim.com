<?php
@set_time_limit(0);
@ini_set('max_execution_time', 1000);
@ini_set('default_socket_timeout', 1000);
include('3rdparty/StockMount/SmOutSampleClass.php');
//error_reporting(E_ALL);
function smSendCargoInformation($d)
{
	$StockMount = new SmOutSample();
	$StockMount->Username=siteConfig('sm_username');
	$StockMount->Password=siteConfig('sm_password');
	
	list($pf,$OrderDetailId,$orderIntID,$StoreId) = explode('-',$d['randStr']);
	list($pf,$Integration) = explode('-',$d['odemeTipi']);
	switch($Integration)
	{
		case 'GiittiGidiyor':
			$IntegrationId = '1';
		break;
		case 'N11':
			$IntegrationId = '2';
		break;
		case 'HepsiBurada':
			$IntegrationId = '3';
		break;		
		case 'OpenCart':
			$IntegrationId = '5';
		break;
		case 'SanalPazar':
			$IntegrationId = '6';
		break;
	}
	
	return $StockMount->setOrderShipmentInformation($StoreId,$IntegrationId,$d['kargoFirma'],$d['kargoSeriNo'],('Online'),$OrderDetailId);
	
	
}

function sm_updateSiparisListFinished()
{
	$Query=array();
	$StockMount = new SmOutSample();
	$StockMount->Username=siteConfig('sm_username');
	$StockMount->Password=siteConfig('sm_password');	
	
	$GetStores=$StockMount->getStores();
	foreach($GetStores as $gs)
	{
		switch($gs->IntegrationName)
		{
			case 'Hepsiburada':
				$Query[$gs->StoreId]=(array)$StockMount->getSales($gs->StoreId,"Open");
				$Query[$gs->StoreId]['PayType'] = $gs->IntegrationName;
			break;	
			case 'GittiGidiyor':
				$Query[$gs->StoreId]=(array)$StockMount->getSales($gs->StoreId,"S");
				$Query[$gs->StoreId]['PayType'] = $gs->IntegrationName;
			break;
			case 'N11':
				$Query[$gs->StoreId]=(array)$StockMount->getSales($gs->StoreId,"Approved");
				$Query[$gs->StoreId]['PayType'] = $gs->IntegrationName;
			break;	
			case 'SanalPazar':
				$Query[$gs->StoreId]=(array)$StockMount->getSales($gs->StoreId,"KARGO_GONDERIMI_BEKLENIYOR");
				$Query[$gs->StoreId]['PayType'] = $gs->IntegrationName;
			break;	
			case 'StocktMount':
				$Query[$gs->StoreId]=(array)$StockMount->getSales($gs->StoreId,"Onaylandý");
				$Query[$gs->StoreId]['PayType'] = $gs->IntegrationName;
			break;	
		}
		
	}
	
	
	foreach($Query as $list)
	{
		
		foreach($list['Orders'] as $storeID=>$l)
		{
			$email = $l->Fullname;			
			$userID = hq("select ID from user where email like '".$email."'");
			
			$tel = $l->Telephone;
			$tel = substr($tel,0,3).'-'.substr($tel,3,7);
				
			if (!$userID)
			{
					$sql = "INSERT INTO `user` (`ID`, `name`, `lastname`, `sex`,`username`, `password`, `email`,`submitedDate`,`data1`,`address`,`city`,`semt`,`ceptel`) VALUES (
														 null,'".($l->Name)."','".($l->Surname)."','','".$email."','".md5($_SESSION['randStr'])."','".$email."',now(),'".$_SERVER['REMOTE_ADDR']."','".($l->Address.' '.$l->District.' / '.$l->City)."','".hq("select plakaID from iller where name like '".($l->City)."'")."','".hq("select ID from ilceler where name like '".($l->District)."' AND parentID='".hq("select plakaID from iller where name like '".($l->City)."'")."'")."','".$tel."');";
					my_mysql_query($sql);
					$userID = my_mysql_insert_id();
			}
			
			$i = $price = 0;
			foreach($l->OrderDetails as $o)
			{
				$sepet[$i]['urunID'] = hq("select ID from urun where tedarikciCode like '".$o->ProductId."' OR tedarikciCode like '".$o->ProductCode."' OR ID = '".$o->ProductId."' OR ID = '".$o->ProductCode."' OR name like '".($o->ProductName)."'");
				$sepet[$i]['urunName'] = ($o->ProductName);
				$sepet[$i]['ytlFiyat'] = $sepet[0]['fiyat'] = ($o->Price / $o->Quantity);
				$sepet[$i]['fiyatBirim'] = 'TL';
				$sepet[$i]['adet'] = $o->Quantity;
				$sepet[$i]['userID'] = $userID;
				$sepet[$i]['ozellik1'] = $o->VariantPhrase;
				$price += $o->Price;
								
				$i++;
			}
			$siparis['name'] = ($l->Name);
			$siparis['userID'] = $userID;
			$siparis['lastname'] = ($l->Surname);
			$siparis['ceptel'] = $tel;
			$siparis['address'] = ($l->Address.' '.$l->District.' / '.$l->City);
			$siparis['city'] = hq("select plakaID from iller where name like '".($l->City)."'");
			$siparis['semt'] = hq("select ID from ilceler where name like '".$l->District."' AND parentID='".$siparis['city']."'");
			$siparis['durum'] = 2;
			$siparis['odemeTipi'] = 'StockMount-'.$list['PayType'];
			
			$siparis['toplamKDVHaric'] = ($price / 1.18);
			$siparis['toplamTutarTL'] = $siparis['toplamIndirimDahil'] = $siparis['toplamKDVDahil'] = $price;
			$siparis['toplamKDV'] = ($price - ($price / 1.18));
	
			siparisVer($sepet,$siparis,'SM-'.$l->OrderId.'-'.$l->IntegrationOrderCode.'-'.$storeID);	
		}
	}
	return debugArray($siparis);

}

function sm_updateSiparisList()
{ 

}
?>