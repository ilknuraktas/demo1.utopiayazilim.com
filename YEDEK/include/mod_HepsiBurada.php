<?php
@set_time_limit(0);
@ini_set('max_execution_time', 1000);
@ini_set('default_socket_timeout', 1000);

autoAddFormField('urun','nohb','CHECKBOX');
autoAddFormField('urun','hbup','CHECKBOX');


$hb_mID = siteConfig('hb_mID');

function testHBPost()
{
	global $hb_username,$hb_password,$hb_mID;

    $url = 'https://oms-stub-external.hepsiburada.com/orders/merchantid/'.$hb_mID;
	
	$content = '{  
               "OrderNumber":"1164319548",
               "OrderDate":"2018-02-19T09:34:47",
               "Customer":{  
                  "Name":"test name"
               },
               "DeliveryAddress":{  

                  "Name":"Hepsiburada Office",
                  "AddressDetail":"Trump Towers",
                  "Email":"customer@hepsiburada.com.tr",
                  "CountryCode":"TR",
                  "PhoneNumber":"902822613231",
                  "AlternatePhoneNumber":"5321538212",
                  "District":"Sisli",
                  "City":"İstanbul"
               },
               "LineItems":[  
                  {  
                     "Sku":"LEIUGHIBDS",
					 "MerchantId":"'.$hb_mID.'",
                     "Quantity":1,
                     "Price":{  
                        "Amount":1600.50,
                        "Currency":"TRY"
                     },
                     "Vat":0,
                     "TotalPrice":{  
                        "Amount":1605.50,
                        "Currency":"TRY"
                     },
                     "CargoCompanyId":1
                  }
               ]
            }';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$hb_username:$hb_password");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
    return $url.'<pre>'.$content.curl_exec($ch).'</pre>';
}

my_mysql_query("update siparis set kargoTutar = 0 where randStr like 'HB-%'",1);

function getHBPrice($d)
{
	if((int)siteConfig('hb_fiyatAlani') > 0)
	{
		$field = 'fiyat'.siteConfig('hb_fiyatAlani');
		if($d[$field] > 1)
			$d['fiyat'] = $d[$field];
	}
    $d['fiyat']+=$d['hb_e'];
    $kar        = hq("select hbkar from kategori where ID='" . $d['catID'] . "' limit 1");
    if (!$kar)
        $kar = siteConfig('hb_oran');
		
    if(!siteConfig('hb_fiyatBirim'))
		$fiyat = YTLfiyat($d['fiyat'], $d['fiyatBirim']);
	else
		$fiyat = $d['fiyat'];
    $fiyat = ($fiyat * (1 + ((float) $kar)));
    if((float)$fiyat <= (float)siteConfig('hb_azami'))
            $fiyat = ($fiyat + ((float) siteConfig('hb_fiyat')));
            
    if(siteConfig('hb_desi') && ((float) $fiyat <= siteConfig('minKargo')))
    {    
        $desi = (hq('select kargoDesi.fiyat from kargoDesi where firmaID=\''.siteConfig('hb_kargoID').'\' AND desiBaslangic <= ' . $d['desi'] . ' AND desiBitis >= ' . $d['desi'] . ' order by kargoDesi.fiyat desc limit 0,1'));
        $desi = YTLfiyat($desi, hq('select kargoDesi.fiyatBirim from kargoDesi where firmaID=\''.siteConfig('hb_kargoID').'\' AND desiBaslangic <= ' . $d['desi'] . ' AND desiBitis >= ' . $d['desi'] . ' order by kargoDesi.fiyat desc limit 0,1'));
        $fiyat+=$desi;
    }

    $fiyat = my_money_format('', $fiyat);
    $fiyat = str_replace(',', '', $fiyat);
    $fiyat = str_replace('.', ',', $fiyat);
    if(function_exists('hbCustomPrice'))
        $fiyat = hbCustomPrice($d,$fiyat);
    return $fiyat;
}

function hb_updateSiparisList()
{
    autoAddFormField('siparis', 'kargostr', 'TEXTBOX');
    global $hb_username,$hb_password,$hb_mID;

    $url = 'https://oms-external.hepsiburada.com/packages/merchantid/'.$hb_mID.'?timespan=5000';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$hb_username:$hb_password");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    $result = curl_exec($ch);
    
    $siparisler = json_decode($result);
    

	my_mysql_query("update siparis set durum = 51 where randStr like  'HB-%' AND durum < 51");
    foreach ($siparisler as $siparis_bilgileri) {

        $spo = 'HB-' . $siparis_bilgileri->packageNumber;
       // if($siparis_bilgileri->status == 'Unpacked')
       //     continue;
		my_mysql_query("update siparis set durum = 2 where randStr like  '$spo'");
        if (hq("select ID from siparis where randStr like '$spo' LIMIT 1")) {
			
			//if($siparis_bilgileri->cargoCompany)
			//	my_mysql_query("update siparis set durum = 51 where randStr = '$spo' AND durum < 51");
			
				$out.= "$spo Siparişi daha önceden kaydedilmiş.<br />";
           // continue;
        }


        $email  =  $siparis_bilgileri->email;
        $userID = hq("select ID from user where email like '" . $email . "'");
        list($ad,$ad2,$soyad) = explode(' ',$siparis_bilgileri->recipientName);
        if (!$userID) {
            $sql = "INSERT INTO `user` (`ID`, `name`, `lastname`, `sex`,`username`, `password`, `email`,`submitedDate`,`data1`,`address`,`city`,`semt`,`ceptel`) VALUES (
                                                        null,'" . $ad .($soyad?' '.$ad2:''). "','".($soyad?$soyad:$ad2)."','','" . $email . "','" . md5($_SESSION['randStr']) . "','" . $email . "',now(),'" . $_SERVER['REMOTE_ADDR'] . "','" . ($siparis_bilgileri->shippingAddress . ' ' . $siparis_bilgileri->shippingDistrict . ' / ' . $siparis_bilgileri->shippingCity) . "','" . hq("select plakaID from iller where name like '" . ($siparis_bilgileri->shippingCity) . "'") . "','" . hq("select ID from ilceler where name like '" . ( $siparis_bilgileri->shippingAddress->district) . "' AND parentID='" .hq("select plakaID from iller where name like '" . ($siparis_bilgileri->shippingDistrict) . "'") . "'") . "','" . $siparis_bilgileri->phoneNumber. "');";
            my_mysql_query($sql);
            $userID = my_mysql_insert_id();
        }
        $sepetsayi = $toplamtutar = 0;
        $sepet     = array();
        foreach ($siparis_bilgileri->items as $urunler) {
            if (hq("select ID from siparis where randStr like '$spo' LIMIT 1")) 
            continue;
				
			$urunAtr = '';	
			$a = 1;
            $urunler->hbSku = trim($urunler->hbSku);
	

            $price                           = ((float) str_replace(',', '',$urunler->price->amount));
            $name                            = $urunler->productName;
            $pid                             = hq("select ID from urun where tedarikciCode = '".$urunler->merchantSku."' OR gtin = '".$urunler->merchantSku."' OR ID = '".$urunler->merchantSku."' OR barkodNo_HB = '".$urunler->merchantSku."'");
            if(!$pid)
            {    
                $pid                             = hq("select urunID from urunvarstok where kod = '".$urunler->merchantSku."' gtin kod = '".$urunler->merchantSku."' OR ID = '".$urunler->merchantSku."' OR barkodNo_HB = '".$urunler->merchantSku."'");
                if (!hq("select ID from sepet where randStr like '$spo' AND adet = '".(int)$urunler->quantity."' AND urunID='$pid'") && !hq("select ID from siparis where randStr like '$spo'"))
                    my_mysql_query("update urunvarstok set stok = (stok - ".(int)$urunler->quantity.") where kod = '".$urunler->merchantSku."' OR ID = '".$urunler->merchantSku."' OR barkodNo_HB = '".$urunler->merchantSku."'");
            }
            if(!$pid)
                $pid                             = hq("select ID from urun where tedarikciCode = '".$urunler->hbSku."' OR ID = '".$urunler->hbSku."' OR barkodNo_HB = '".$urunler->hbSku."'");
            if(!$pid)
                $pid                             = hq("select urunID from urunvarstok where kod = '".$urunler->hbSku."' OR ID = '".$urunler->hbSku."' OR barkodNo_HB = '".$urunler->hbSku."'");
            if(!$pid)
            {
                $out.='<h3>'.$urunler->merchantSku.' stok koduna ait bir ürün bulunamadı</h3><br/>';
                $pid = $urunler->merchantSku;
            }  
            
            foreach($urunler->properties as $atr)
			{
                $s = $a;
                if($pid)
                {
                    $qx = my_mysql_query("select * from urun where ID='$pid'");
                    $d = my_mysql_fetch_array($qx);
 
                    $d['var1name'] = (trim(hq("select ozellik from var where ID='" . $d['varID1'] . "' limit 0,1")));
                    $d['var2name'] = (trim(hq("select ozellik from var where ID='" . $d['varID2'] . "' limit 0,1")));
            
                    $d['var1namet'] = (trim(hq("select tanim from var where ID='" . $d['varID1'] . "' limit 0,1")));
                    $d['var2namet'] = (trim(hq("select tanim from var where ID='" . $d['varID2'] . "' limit 0,1")));

                    if($atr->name == $d['var1name'] || $atr->name == $d['var1namet'])
                        $s = 1;
                    else if($atr->name == $d['var2name'] || $atr->name == $d['var2namet'])
                        $s = 2;
                }
				$sepet[$sepetsayi]['ozellik'.$s] =  $atr->value;
				if($s==1) $a = 2;
                else if($s==2) $a = 1;
                else $a++;
			}


            $sepet[$sepetsayi]['userID']     = $userID;
			$sepet[$sepetsayi]['durum']   	 = 2;
            $sepet[$sepetsayi]['urunID']     = $pid;
            $sepet[$sepetsayi]['urunName']   = addslashes($name);
            $sepet[$sepetsayi]['ytlFiyat']   = $sepet[$sepetsayi]['fiyat'] = (float)($price);
            $sepet[$sepetsayi]['fiyatBirim'] = $urunler->price->currency;
            $sepet[$sepetsayi]['adet']       = $urunler->quantity;
            $sepet[$sepetsayi]['kdv']        = ($urunler->vatRate)/100;
            if(!$sepet[$sepetsayi]['kdv'])
                $sepet[$sepetsayi]['kdv'] =  hq("select kdv from urun where ID='".$pid."'");
            if(!$sepet[$sepetsayi]['kdv'])
                $sepet[$sepetsayi]['kdv'] = 0.18;
            $toplamtutar += ($price * $urunler->quantity);         
            $sepetsayi++;
            if (($sepet[$sepetsayi]['urunName'] == $sepet[($sepetsayi - 1)]['urunName']) && ($sepet[$sepetsayi]['ozellik1'] == $sepet[($sepetsayi - 1)]['ozellik1']) && ($sepet[$sepetsayi]['ozellik2'] == $sepet[($sepetsayi - 1)]['ozellik2'])) {
                $sepetsayi--;
                $sepet[$sepetsayi]['adet'] += $urunler->quantity;

            }

        }
        if(!$toplamtutar)
            $toplamtutar = $siparis_bilgileri->totalPrice->amount;
        $kargo                               = hq("select ID from kargofirma where name like '".$siparis_bilgileri->cargoCompany."'");
        $toplamKDVHaric                      = ($toplamtutar / 1.18);
        $toplamKDV                           = ($toplamtutar - ($toplamtutar / 1.18));
        $siparisx['kargostr']                = $siparis_bilgileri->cargoCompany;
        $siparisx['userID']                  = $userID;
        $siparisx['toplamKDVHaric']          = $toplamKDVHaric;
        $siparisx['toplamTutarTL']           = $toplamtutar;
        $siparisx['toplamKargoDahil']        = $toplamtutar;
        $siparisx['toplamIndirimDahil']      = $toplamtutar;
        $siparisx['toplamKDVDahil']          = $toplamtutar;
        $siparisx['toplamKDV']               = $toplamKDV;
        $siparisx['kargoTutar'] = 0;  
        $shippingAddress_gsm                 = $siparis_bilgileri->phoneNumber;
        $shippingAddress_address             = $siparis_bilgileri->shippingAddressDetail;
        $shippingAddress_district            = $siparis_bilgileri->shippingTown;
        $shippingAddress_city                = $siparis_bilgileri->shippingCity;
        $billingAddress_address              = $siparis_bilgileri->billingAddress;
        $billingAddress_city                 = $siparis_bilgileri->billingCity;
        $billingAddress_district             = $siparis_bilgileri->billingTown;
        $shippingAddress_fullName            = $siparis_bilgileri->recipientName;
        $siparisx['name']                    = ($shippingAddress_fullName);
        $siparisx['tckNo']                   = $siparis_bilgileri->identityNo;
        $siparisx['vergiDaire']              = $siparis_bilgileri->taxOffice;
        $siparisx['vergiNo']                 = $siparis_bilgileri->taxNumber;
		$siparisx['kargoSeriNo']             = $siparis_bilgileri->barcode;	
		$siparisx['kargoFirma']              = $kargo;
		
        $siparisx['ceptel']                  = str_replace(' ', '-', $shippingAddress_gsm);
        $siparisx['address']                 = addslashes($shippingAddress_address);
        $siparisx['address2']                = addslashes($billingAddress_address . ' ' . $billingAddress_district . ' / ' . $billingAddress_city);
        $siparisx['firmaUnvani']                = addslashes($siparis_bilgileri->companyName);

        $siparisx['city']                    = hq("select plakaID from iller where name like '" . ($shippingAddress_city) . "'");
        $siparisx['semt']                    = hq("select ID from ilceler where name like '" . ($shippingAddress_district) . "' AND parentID='" . $siparisx['city'] . "'");
        $siparisx['city2']                   = hq("select plakaID from iller where name like '" . ($billingAddress_city) . "'");
        $siparisx['semt2']                   = hq("select ID from ilceler where name like '" . ($billingAddress_district) . "' AND parentID='" . $siparisx['city2'] . "'");
        $siparisx['durum']                   = 2;
        $siparisx['email']                   = $email;
        $siparisx['odemeTipi']               = 'HepsiBurada';
        $siparisx['notAlici']                = $promo;;
       // if (hq("select ID from siparis where randStr like '$spo' LIMIT 1"))
         //   unset($sepet);
        siparisVer($sepet, $siparisx, $spo);
        if($_SESSION['admin_isAdmin']) 
			$out.= "$spo Siparişi Kaydedildi.<br />".debugArray($siparis_bilgileri)."<br />";

        $i++;
    }
	return $out;
}


function hb_proccessTrackingIDResult($trackingId)
{
    $hepsiburada = new HepsiBurada();
    $ta = $hepsiburada->getTrackingIDResult($trackingId);  
    $out ='İşlem yapılan rapor ('.$ta->totalElements.' '.ürün.'): <b>'.$trackingId.'</b><br />';  
    if(!$ta->success) 
        return;
    if(!$ta->totalElements)
    {
        my_mysql_query("update hbrapor set readok = 1 where trackingId='".addslashes($trackingId)."'");
        $out.='Veri olmadığından kapatıldı.<br />';  
        return;
    }

    foreach ($ta->data as $item) {
        if(!$item->hbSku && $item->importStatus == 'PROCESSING')
            return;
        if($item->hbSku)
        {
            my_mysql_query("update urun set barkodNo_HB = '".addslashes($item->hbSku)."' where ID='".addslashes($item->merchantSku)."' OR tedarikciCode ='".addslashes($item->merchantSku)."' ");
            $out.='Ürün kodu güncellendi. ('.$item->hbSku.' | '.$item->merchantSku.')<br />';  
        }
        my_mysql_query("update hbrapor set readok = 1 where trackingId='".addslashes($trackingId)."'");
        $out.='Güncelleme tamamlandı.<br />';  
    }
    return $out;
}
?>