<?php
@set_time_limit(0);
@ini_set('max_execution_time', 1000);
@ini_set('default_socket_timeout', 1000);
include_once '3rdparty/GittiGidiyor/client.php';
include_once 'lib-pazar.php';
autoAddFormField('urun', 'nogg', 'CHECKBOX');
autoAddFormField('urun', 'ggup', 'CHECKBOX');
autoAddFormField('urun', 'gg_tarih', 'TEXTBOX');
autoAddFormField('urunvarstok', 'barkodNo', 'TEXTBOX');

error_reporting(E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR);
ini_set('display_errors', 1);



function getGGPrice($d)
{
    if ((int) siteConfig('gg_fiyatAlani') > 0) {
        $field = 'fiyat' . siteConfig('gg_fiyatAlani');
        if ($d[$field] > 1) {
            $d['fiyat'] = $d[$field];
        }
    }
    
    //$d['fiyat'] = fixFiyat($d['fiyat'], 0, $d);
    $kar = hq("select ckar from kategori where ID='" . $d['catID'] . "' limit 1");
    if (!$kar) {
        $kar = siteConfig('gg_oran');
    }

    $fiyat = YTLfiyat($d['fiyat'], $d['fiyatBirim']);
    $fiyat = ($fiyat * (1 + ((float) $kar)));
    if ((float) $fiyat <= (float) siteConfig('gg_azami')) {
        $fiyat = ($fiyat + ((float) siteConfig('gg_fiyat')));
        if(siteConfig('gg_desi') && ((float) $fiyat <= siteConfig('minKargo')))
        {    
            $desi = (hq('select kargoDesi.fiyat from kargoDesi where firmaID=\''.siteConfig('gg_kargoID').'\' AND desiBaslangic <= ' . $d['desi'] . ' AND desiBitis >= ' . $d['desi'] . ' order by kargoDesi.fiyat desc limit 0,1'));
            $desi = YTLfiyat($desi, hq('select kargoDesi.fiyatBirim from kargoDesi where firmaID=\''.siteConfig('gg_kargoID').'\' AND desiBaslangic <= ' . $d['desi'] . ' AND desiBitis >= ' . $d['desi'] . ' order by kargoDesi.fiyat desc limit 0,1'));
            $fiyat+=$desi;
        }
    }

    // $fiyat = round($fiyat, 1, PHP_ROUND_HALF_UP);
    $fiyat = my_money_format('', $fiyat);
    $fiyat = str_replace(',', '', $fiyat);
    my_mysql_query("update urun set gg_fiyat = '$fiyat' where ID='".$d['ID']."'");
    return $fiyat;
}
function gg_updateProductPriceAndStock($urunID)
{
    $q = my_mysql_query("select urun.*,kategori.gg_Kod,kategori.gg_Dukkan from urun,kategori where urun.catID = kategori.ID AND kategori.gg_Kod != ''  AND urun.noxml != 1 AND urun.nogg != 1  AND urun.ID='$urunID' limit 1");
    if (!my_mysql_num_rows($q)) {
        return 'Ürün Bulunamadı.';
    }

    $d = my_mysql_fetch_array($q);
    $gg = new ggClient();
    $fiyat = getGGPrice($d);
    $stok = $d['stok'];
    return ($gg->updateStock($d['barkodNo'], '', $stok, 0)->result) . ' - ' . ($gg->updatePrice($d['barkodNo'], '', $fiyat, 0)->result);
}
function gg_updateSiparisList()
{
    $out = '';
    $gg = new ggClient(); {
        @$list = $gg->getSales(1, 100, 1, 'S');
        if (is_array($list->sales->sale)) {
            $take = $list->sales->sale;
        } else {
            $take = $list->sales;
        }

        foreach ($take as $l) {
            if (hq("select ID from siparis where randStr like 'GG-" . $l->saleCode . "'"))
                continue;
            unset($sepet);
            unset($siparis);
            $email = $l->buyerInfo->email;
            $userID = hq("select ID from user where email != '' AND email like '" . $email . "'");
            if (!$userID) {
                $userID = hq("select ID from user where username !='' AND username like '" . $l->buyerInfo->username . "'");
            }

            if (!$userID) {
                $sql = "INSERT INTO `user` (`ID`, `name`, `lastname`, `sex`,`username`, `password`, `email`,`submitedDate`,`data1`,`address`,`city`,`semt`,`ceptel`) VALUES (
														 null,'" . ($l->buyerInfo->name) . "','" . ($l->buyerInfo->surname) . "','','" . ($l->buyerInfo->username) . "','" . md5($l->buyerInfo->username . $l->buyerInfo->username) . "','" . $email . "',now(),'" . $_SERVER['REMOTE_ADDR'] . "','" . ($l->buyerInfo->address . ' ' . $l->buyerInfo->district . ' / ' . $l->buyerInfo->city) . "','" . hq("select plakaID from iller where name like '" . ($l->buyerInfo->city) . "'") . "','" . hq("select ID from ilceler where name like '" . ($l->buyerInfo->district) . "' AND parentID='" . hq("select plakaID from iller where name like '" . ($l->buyerInfo->city) . "'") . "'") . "','" . $l->buyerInfo->phone . "');";
                my_mysql_query($sql);
                $userID = my_mysql_insert_id();
            }

            //$cargoInfo = $gg->getCargoInformation($l->saleCode);
            $siparis['kargoSeriNo'] = $l->cargoCode;

            $sepet[0]['urunID'] = hq("select ID from urun where ID = '" . $l->itemId . "'");
            if (!$sepet[0]['urunID'])
                $sepet[0]['urunID'] = hq("select ID from urun where barkodNo like '" . $l->productId . "'");
            if (!$sepet[0]['urunID'])
                $sepet[0]['urunID'] = hq("select ID from urun where name like '" . ($l->productTitle) . "'");
            if (!$sepet[0]['urunID']) {
                $sepet[0]['urunID'] = hq("select urunID from urunvarstok where barkodNo like '" . $l->barkodNo . "' ");
                my_mysql_query("update urunvarstok set stok = (stok - " . (int) $l->amount . ") where barkodNo like '" . $l->barkodNo . "'");
            }

            $sepet[0]['urunName'] = addslashes($l->productTitle);
            $sepet[0]['ytlFiyat'] = $sepet[0]['fiyat'] = ($l->price / $l->amount);
            $sepet[0]['fiyatBirim'] = 'TL';
            $sepet[0]['adet'] = $l->amount;
            $sepet[0]['userID'] = $userID;
            $sepet[0]['durum'] = 2;
            if (isset($l->variantSpecs->variantSpec->name)) {
                $sepet[0]['ozellik1'] = $l->variantSpecs->variantSpec->value;
            } elseif (isset($l->variantSpecs->variantSpec[0]->name)) {
                $sepet[0]['ozellik1'] = $l->variantSpecs->variantSpec[0]->value;
                if (isset($l->variantSpecs->variantSpec[1]->name)) {
                    $sepet[0]['ozellik2'] = $l->variantSpecs->variantSpec[1]->value;
                }
            }
            $siparis['name'] = ($l->buyerInfo->name);
            $siparis['email'] = $email;
            $siparis['userID'] = $userID;
            $siparis['lastname'] = ($l->buyerInfo->surname);
            $siparis['ceptel'] = str_replace(' ', '-', $l->buyerInfo->phone);
            $siparis['address'] = ($l->buyerInfo->address . ' ' . $l->buyerInfo->district . ' / ' . $l->buyerInfo->city);
            $siparis['city'] = hq("select plakaID from iller where name like '" . ($l->buyerInfo->city) . "'");
            $siparis['semt'] = hq("select ID from ilceler where name like '" . ($l->buyerInfo->district) . "' AND parentID='" . $siparis['city'] . "'");
            if (!$siparis['semt']) {
                my_mysql_query("insert into ilceler (name,parentID) values('" . addslashes($l->buyerInfo->district) . "','" . $siparis['city'] . "')");
                $siparis['semt'] = hq("select ID from ilceler where name like '" . addslashes($l->buyerInfo->district) . "' AND parentID='" . $siparis['city'] . "'");
            }
            $siparis['durum'] = 2;
            $siparis['odemeTipi'] = 'GittiGidiyor';
            $siparis['notAlici'] = $l->cargoPayment;
            $siparis['toplamKDVHaric'] = ($l->price / 1.18);
            $siparis['toplamTutarTL'] = $siparis['toplamIndirimDahil'] = $siparis['toplamKDVDahil'] = $l->price;
            $siparis['toplamKDV'] = ($l->price - ($l->price / 1.18));
            $siparis['randStr'] = 'GG-' . $l->saleCode;
            if (!hq("select ID from siparis where randStr like 'GG-" . $l->saleCode . "'")) {
                $out .= siparisVer($sepet, $siparis, 'GG-' . $l->saleCode);
                if ($_SESSION['admin_isAdmin']) {
                    $out .= 'GG-' . $l->saleCode . " Siparişi Kaydedildi.<br />" . debugArray($sepet) . debugArray($siparis) . "<br />";
                }
            } else {
                unset($sepet);
                $out .= 'GG-' . $l->saleCode . " Siparişi daha önceden kaydedilmiş. Bilgileri güncelleniyor.<br />";
              //  $out .= siparisVer($sepet, $siparis, 'GG-' . $l->saleCode);
                //  my_mysql_query("update siparis set kargoSeriNo = '" . $l->cargoCode . "' where randStr like 'GG-" . $l->saleCode . "'");
                //  my_mysql_query("update siparis set durum  = 51 where randStr like 'GG-" . $l->saleCode . "' AND durum < 51");
            }
        }
    }
    return $out;
}
$ggCatSpecs = $ggVars = $varName1 = $varName2 = '';

function buildGGProduct($d, $buildUpdate = false)
{
    global $siteDizini, $ggCatSpecs, $ggVars, $varName1, $varName2;
    if (!$d['fiyat'])
        return;
    
    $d['stok'] = max(0,(int)$d['stok']);
    $d['detay'] = siteConfig('gg_header') . $d['detay'] . siteConfig('gg_footer');
    if (!siteConfig('telif-footer'))
        $d['detay'] .= '<hr />Bu ürün <a href="https://www.shopphp.net/" target="_blank"><strong>ShopPHP</strong></a> e-ticaret yazılımı ile listelenmiştir';

    $d['stok'] = min(1000, $d['stok']);
    $ggCatSpecs = $ggVars = $varName1 = $varName2 = '';

    if (!$d['kargoGun'] && !$d['anindaGonderim']) {
        $d['kargoGun'] = siteConfig('kargoGun');
    }

    $ggSubtitle = siteConfig('gg_Subtitle');

    if (!$d['kargoGun'] && !$d['anindaGonderim']) {
        $d['kargoGun'] = siteConfig('kargoGun');
    }

    $specs = '';
    $sarr = explode('_', $d['filtre_gg']);
    $newCatalogSpec = '';
    $newCatalogSpecs = array();

    foreach ($sarr as $s) {
        list($k, $v) = explode('|', $s);
        $value = str_replace("'", '"', $v);
        $value = $v;
        $k = rtrim($k);
        $v = rtrim($v);

        if ($k && $k != $varName1 && $k != $varName2 && $v) {
            $specs .= '<spec name="' . rtrim(str_replace('--', ' ', $k)) . '" value=\'' . $value . '\' type="Combo" required="true" />' . "\n";
            $nnm = str_replace('--', ' ', $k);

            if (in_array($nnm, array('Marka', 'Model'))) {
                $spc = '<item name="' . $nnm . '" value=\'' . $v . '\' />' . "\n";
                $newCatalogSpecs[$nnm] = $v;
                $newCatalogSpec .= $spc;
            }
        }
    }

    $specs = str_replace('&prime;', '', $specs);
    $d['name'] = rtrim(mb_convert_encoding(substr($d['name'], 0, 100), 'UTF-8', 'UTF-8'));

    $newCatalogId = 0;
    if (count($newCatalogSpecs) == 2) {
        $gg = new ggClient();
        $newCatalog = $gg->getSimpleCatalogs(str_replace(' ', '', trim($d['gg_Kod'])), $newCatalogSpec);
        $newCatalogId = $newCatalog->catalogs->catalog->catalogAttributeId;
        // echo $d['gg_Kod'].':'.debugArray($newCatalog);
    }

    $cleanName = iconv("utf-8", "utf-8//ignore", substr(strip_tags($d['name']), 0, 100));
    $cleanName = preg_replace('/[^A-Za-z0-9şıöüğçİŞÖĞÜÇ\_\,\!\%\/\(\)\:\°\*\&\-\."\'\+ ]/s', '', $cleanName);
    $cleanSub = iconv("utf-8", "utf-8//ignore", substr(strip_tags($d['listeDetay']), 0, 100));    
    $cleanSub = preg_replace('/[^A-Za-z0-9şıöüğçİŞÖĞÜÇ\_\,\!\%\/\(\)\:\°\*\&\-\."\'\+ ]/s', '', $cleanSub);    

    $cleanName = rtrim($cleanName);
    $cleanSub = rtrim($cleanSub);

    $cleanName = str_replace(array('prime', '&amp;', '&'), array("'", '', ''), $cleanName);
    $cleanSub = str_replace(array('prime', '&amp;', '&'), array("'", '', ''), $cleanSub);

    if ($ggSubtitle) {
        $cleanSub = '';
    }

    $product = '<product><categoryCode>' . str_replace(' ', '', trim($d['gg_Kod'])) . '</categoryCode>
      <storeCategoryId>' . ($d['gg_Dukkan'] ? $d['gg_Dukkan'] : siteConfig('gg_DukkanNo')) . '</storeCategoryId>
      <title><![CDATA[' . $cleanName . ']]></title>
      <subtitle><![CDATA[' . $cleanSub . ']]></subtitle>
      ' . ($specs ? '<specs>' . $specs . '</specs>' : '') . '
      <photos>';

    //if (!hq("select ID from sepet where urunID='" . $d['ID'] . "' AND durum > 0 AND randStr like 'GG-%'")) 
    {
        for ($i = 1; $i <= 8; $i++) {
            $rname = 'resim' . ($i > 1 ? $i : '');
            if ($d[$rname]) {
                $d[$rname] = str_replace(' ', '%20', $d[$rname]);
                $d[$rname] = str_replace('ı', 'i', $d[$rname]);
                $product .= '
				 <photo photoId="' . ($i - 1) . '">
					<url>https://' . $_SERVER[HTTP_HOST] . $siteDizini . 'images/urunler/' . $d[$rname] . '</url>
					<base64></base64>
				 </photo>';
            }
        }
    }

    $fiyat = getGGPrice($d);
    $kargo_fiyat = my_money_format('', siteConfig('gg_KargoAliciUcreti') ? siteConfig('gg_KargoAliciUcreti') : siteConfig('kargo'));
    $kargo_fiyat = str_replace(',', '', $kargo_fiyat);
    /*
    if(!$kargo_fiyat)
    {
        $desi = (hq('select kargoDesi.fiyat from kargoDesi where firmaID=\''.siteConfig('gg_kargoID').'\' AND desiBaslangic <= ' . $d['desi'] . ' AND desiBitis >= ' . $d['desi'] . ' order by kargoDesi.fiyat desc limit 0,1'));
        $kargo_fiyat = YTLfiyat($desi, hq('select kargoDesi.fiyatBirim from kargoDesi where firmaID=\''.siteConfig('gg_kargoID').'\' AND desiBaslangic <= ' . $d['desi'] . ' AND desiBitis >= ' . $d['desi'] . ' order by kargoDesi.fiyat desc limit 0,1'));    
    }
*/
    if (siteConfig('gg_KargoUcreti') == 'S' || $d['ucretsizKargo']) {
        $kargo_fiyat = 0;
    }

    $product .= '</photos>';

    if ($newCatalogId > 0) {
        $product .= '<newCatalogId>';
        $product .= $newCatalogId;
        $product .= '</newCatalogId>';
    }

    $day = '2-3days';
    if ($d['anindaGonderim']) {
        $day = 'today';
    } else
        if ($d['kargoGun'] < 3) {
        $day = 'tomorrow';
    } else
        if ($d['kargoGun'] > 3) {
        $day = '3-7days';
    }

    $d['detay'] = str_replace(array('<![CDATA[', ']]'), '', $d['detay']);
    $product .= '<pageTemplate>' . siteConfig('gg_SayfaDuzeni') . '</pageTemplate>
      <description><![CDATA[' . $d['name'] . '<br />' . $d['onDetay'] . '<br />' . $d['detay'] . '<br />]]></description>
      <startDate></startDate>
      <catalogId></catalogId>
	 ' . ($d['newCatalogId'] ? ('<newCatalogId>' . $d['newCatalogId'] . '</newCatalogId>') : '') . '
      <catalogDetail></catalogDetail>
      <catalogFilter></catalogFilter>
      <format>' . siteConfig('gg_UrunFormati') . '</format>
      <startPrice></startPrice>
      <buyNowPrice>' . $fiyat . '</buyNowPrice>
      <netEarning></netEarning>
      <listingDays>' . siteConfig('gg_Sure') . '</listingDays>
      <productCount>' . $d['stok'] . '</productCount>

      '.($d['gtin']?'<globalTradeItemNo>'.$d['gtin'].'</globalTradeItemNo>':'').'
      <cargoDetail>
         <city>' . siteConfig('gg_Sehir') . '</city>
         <shippingPayment>' . ($d['ucretsizKargo'] ? 'S' : siteConfig('gg_KargoUcreti')) . '</shippingPayment>
         ' . ($buildUpdate ? '<cargoCompanies>
                  <cargoCompany>' . siteConfig('gg_Kargo') . '</cargoCompany>
               </cargoCompanies>' : '') . '
         <shippingWhere>country</shippingWhere>
         <cargoDescription>' . (siteConfig('gg_KargoUcreti') == 'D' ? siteConfig('gg_KargoAciklamasi') : '') . '</cargoDescription>
         <cargoCompanyDetails>
            <cargoCompanyDetail>
               <name>' . siteConfig('gg_Kargo') . '</name>
               ' . (!$d['ucretsizKargo'] && (int) $kargo_fiyat > 0 ? '<cityPrice>' . $kargo_fiyat . '</cityPrice><countryPrice>' . $kargo_fiyat . '</countryPrice>' : '') . '
            </cargoCompanyDetail>
             </cargoCompanyDetails>
             <shippingTime>
            <days>' . $day . '</days>
            ' . ($day == 'today' ? '<beforeTime>' . (siteConfig('gg_Saat') ? siteConfig('gg_Saat') : '17:00') . '</beforeTime>' : '') . '
             </shippingTime>
      </cargoDetail>
        <catalogOptions>false</catalogOptions>
      <affiliateOption>false</affiliateOption>
      <boldOption>' . (siteConfig('gg_KalinYazi') ? 'true' : 'false') . '</boldOption>
      <catalogOption>' . (siteConfig('gg_Katalog') ? 'true' : 'false') . '</catalogOption>
      <vitrineOption>' . (siteConfig('gg_Vitrin') ? 'true' : 'false') . '</vitrineOption></product>';
    $product = str_replace('&amp ', '&amp; ', $product);
    $product = str_replace('&stick ', '&stick; ', $product);
    $product = str_replace('&jaz ', '&jaz; ', $product);
    $product = str_replace(' & ', ' &amp; ', $product);
    $product = str_replace('P&j', 'P and j', $product);

    if ($_GET['urunID'] && $_SESSION['admin_isAdmin'] && !$_GET['f']) {
        echo ('<textarea style="width:800px; height:800px;">' . ($product) . '</textarea>');
    }

    return $product;
}

function gg_insertProducts($urunID, $varID = 0)
{
    if (hq("select barkodNo from urun where ID='$urunID' "))
        return;
    if (hq("select ID from urun where gg_tarih = 'UPDATE-" . date('d') . " AND ID='$urunID' "))
        return;
    $q = my_mysql_query("select urun.*,kategori.gg_Kod,kategori.gg_Dukkan,marka.name markaname from urun,kategori,marka where urun.barkodNo = '' AND urun.markaID = marka.ID AND urun.catID = kategori.ID AND kategori.gg_Kod != '' AND urun.stok > 0   AND urun.noxml != 1 AND urun.nogg != 1 AND kategori.noxml != 1  AND urun.ID='$urunID' limit 1");
    if (!my_mysql_num_rows($q)) {
        return 'Urun yok veya daha önce kaydedilmiş (' . $urunID . ')';
    }

    $out = '';
    $d = my_mysql_fetch_array($q);
    $d['stok'] = max(0,(int)$d['stok']);

    if ((float) siteConfig('gg_asgari')  > 1 && YTLfiyat($d['fiyat'], $d['fiyatBirim']) < (float) siteConfig('gg_asgari') && !$d['barkodNo']) {
        pazarLog($urunID, 'GittiGidiyor', 'Urun fiyat asgari tutardan düşük (' . $urunID . ' : ' . YTLfiyat($d['fiyat'], $d['fiyatBirim']) . ')', 0);
        return 'Ürun fiyat asgari tutardan düşük (' . $urunID . ' : ' . YTLfiyat($d['fiyat'], $d['fiyatBirim']) . ')';
    }

    if (!$varID && $d['varID1']) {
        $q2 = my_mysql_query("select ID from urunvarstok where up=1 AND var1 != '' AND urunID='$urunID'");
        while ($d2 = my_mysql_fetch_array($q2)) {
            $out .= gg_insertProducts($urunID, $d2['ID']);
        }
        if (my_mysql_num_rows($q2))
            return $out;
    }

    if ($varID) {
        autoAddFormField('urunvarstok', 'barkodNo', 'TEXTBOX');
        $var1 = hq("select var1 from urunvarstok where ID='$varID'");
        $var2 = hq("select var2 from urunvarstok where ID='$varID'");
        if(!$var1)
            return;
        $d['name'] .= ' ' . $var1 . ($var2 ? ' ' . $var2 : '');
        $d['stok'] = hq("select stok from urunvarstok where ID='$varID'");
        $d['stok'] = max(0,$d['stok']);
        if(!$d['stok'])
            return 'Ürün varyasyon stok 0 olduğu için gönderilmedi.';
        $d['fiyat'] += hq("select fark from urunvarstok where ID='$varID'");
        $d['barkodNo'] = hq("select barkodNo from urunvarstok where ID='$varID'");
        if($d['barkodNo']) 
            return gg_updateProducts($urunID, $varID);

        $resim = hq("select resim1 from urunvar where urunID='$urunID' AND varID='" . $varID . "' AND (varName like '$var1' OR varName like '$var2')");
        if ($resim)
            $d['resim'] = '/var/' . $resim;
        $d['ID'] = ($varID + 1000000);
    }

    $gg = new ggClient();
    $test = $gg->getProduct('',$d['ID']);
    $code = $test->productDetail->productId;
    if ($code) {
        if($varID)
        {
            my_mysql_query("update urunvarstok set barkodNo = '$code' where ID='$varID' limit 1");
           // my_mysql_query("update urun set barkodNo = '$code' where barkodNo='' AND ID='$urunID' limit 1");
        }
        else
            my_mysql_query("update urun set barkodNo = '$code' where ID='$urunID' limit 1");

        return gg_updateProducts($urunID,$varID);
    }

    $product = buildGGProduct($d);
    try {

        if (stristr($product, '<variantGroups>') === false) {
            $l = $gg->insertProductWithNewCargoDetail($d['ID'], $product);
        } else {
            $l = $gg->insertProductWithNewCargoDetail($d['ID'], $product);
        }
    } catch (Exception $e) {
        echo adminErrorv3('GittiGidiyor tarafından INSERT sırasında bağlantı kesildi. ' . $d['name'] . ' (' . $d['ID'] . ') iletilemedi. Lütfen daha sonra tekrar deneyin.');
    }

    if ($l->productId) {
        if (!$varID)
            my_mysql_query("update urun set barkodNo = '" . $l->productId . "' where ID = '$urunID' limit 1");
        else
            my_mysql_query("update urunvarstok set barkodNo = '" . $l->productId . "' where ID = '$varID' limit 1");
    }

    /* Buraya aslında hiç girmemesi gerekiyor. Kontrol amaçlı. */ 
    if (!(stristr(($l->error->message), 'sahip bir ürün bulunmaktadır') === false)) {
        $rs = $gg->relistProducts(array($l->productId),null);
		pazarLog($d['ID'],'GittiGidiyor','Tekrar Listeleme : '.$rs->error->message,($rs->error->message?1:0));
		if(!$rs->error->message)
            my_mysql_query("update urun set ggup =1 ,gg_tarih = '".date('d-m-Y H:i:s')."' where ID='".$d['ID']."'");
        else
        {
            $test = $gg->getProduct('',$d['ID']);
            $code = $test->productDetail->productId;
            if ($code) {
                if($varID)
                    my_mysql_query("update urunvarstok set barkodNo = '$code' where ID='$varID' limit 1");
                else
                    my_mysql_query("update urun set barkodNo = '$code' where ID='$urunID' limit 1");

                return gg_updateProducts($urunID,$varID);
            }
        }
    }

    if (!(stristr(($l->error->message), 'Üründeki newCatalogId alanı ') === false)) {
        pazarLog($d['ID'], 'GittiGidiyor', "(INSERT urunID : $urunID) " . ($l->result . $l->error->message) . "<br /><strong>Seçtiğiniz Marka ve Model değerleri birbiri ile uyumlu olmalıdır. Lütfen seçiminizi kontrol edip, tekrar deneyin", 1);
        return adminErrorv3("(INSERT urunID : $urunID) " . ($l->result . $l->error->message) . "<br /><strong>Seçtiğiniz Marka ve Model değerleri birbiri ile uyumlu olmalıdır. Lütfen seçiminizi kontrol edip, tekrar deneyin.</strong><br />\r\n");
    }
    $info = ($l->result . $l->error->message);
    if (!$info)
        $info = debugArray($l);
    pazarLog($d['ID'], 'GittiGidiyor', "(INSERT urunID : $urunID) " . $info, ($l->error->message ? 1 : 0));
    return adminInfov3("(INSERT urunID : $urunID [$varID]) " . $info  . "<br/>\r\n");
}

function gg_updateProducts($urunID, $varID = 0)
{
    $q = my_mysql_query("select urun.*,kategori.gg_Kod,kategori.gg_Dukkan from urun,kategori where urun.catID = kategori.ID AND kategori.gg_Kod != ''  AND urun.noxml != 1 AND urun.nogg != 1 AND kategori.noxml != 1  AND urun.ID='$urunID' limit 1");
    if (!my_mysql_num_rows($q)) {
        return 'Ürün Bulunamadı.';
    }
    $out = '';
    $d = my_mysql_fetch_array($q);
    $d['stok'] = max(0,(int)$d['stok']);
    if (!$varID && $d['varID1']) {
        $q2 = my_mysql_query("select ID from urunvarstok where up=1 AND var1 != '' AND urunID='$urunID'");
        while ($d2 = my_mysql_fetch_array($q2)) {
            $out .= gg_updateProducts($urunID, $d2['ID']);
        }
        if (my_mysql_num_rows($q2))
            return $out;
    }


    if ($varID) {
        autoAddFormField('urunvarstok', 'barkodNo', 'TEXTBOX');
        $var1 = hq("select var1 from urunvarstok where ID='$varID'");
        $var2 = hq("select var2 from urunvarstok where ID='$varID'");
        $d['name'] .= ' ' . $var1 . ($var2 ? ' ' . $var2 : '');
        $d['stok'] = hq("select stok from urunvarstok where ID='$varID'");
        $d['fiyat'] += hq("select fark from urunvarstok where ID='$varID'");
        $d['barkodNo'] = hq("select barkodNo from urunvarstok where ID='$varID'");
        if(!$d['barkodNo'])
            return gg_insertProducts($urunID, $varID);
        $resim = hq("select resim1 from urunvar where urunID='$urunID' AND varID='" . $varID . "' AND (varName like '$var1' OR varName like '$var2')");
        if ($resim)
            $d['resim'] = '/var/' . $resim;
        $d['ID'] = ($varID + 1000000);
    }

    $d['stok'] = min(1000, $d['stok']);
    $gg = new ggClient();
    $product = buildGGProduct($d, true);
    if (!$d['stok'] || !$d['active']) {
        $l = $gg->finishEarly(null, array(
            $d['ID'],
        ));
        //if($l->result)
        //     my_mysql_query("update urun set barkodNo = '' where ID = '$urunID' limit 1");
        pazarLog($d['ID'], 'GittiGidiyor', "(UPDATE URUN : " . $urunID . " Stok olmadığı için varsa bitirilmek için gönderildi.) " . ($l->result . $l->error->message) ,($l->error->message?1:0));
        return ("(UPDATE URUN : " . $urunID . " Stok olmadığı için varsa bitirilmek için gönderildi.) " . ($l->result . $l->error->message) . "<br/>\r\n");
    }
    try {
        $l = $gg->getProductStatuses(array(
            $d['barkodNo'],
        ));
        if (isset($l->ackCode)) {
            $l = $gg->updateProduct(null, $d['barkodNo'], $product);

            $fiyat = getGGPrice($d);
            $fr = $gg->updatePrice($d['barkodNo'], null, $fiyat, null);
            $fs = $gg->updateStock($d['barkodNo'], null, $d['stok'], null);
            pazarLog($d['ID'], 'GittiGidiyor', ($l->result . $l->error->message) . "\n" . $fr->result . "\n" . $fr->error->message . "\n" . $fs->result . "\n" . $fs->error->message, ($fr->error->message || $l->error->message || $fs->error->message ? 1 : 0));
            $out .= $d['ID'] . ' : ' . $d['name'] . ' Gönderildi. Dönüş <strong>Genel</strong> Kodu : <strong>' . $l->result . $l->error->message.'</strong><br />';
            $out .= $d['ID'] . ' : ' . $d['name'] . ' Gönderildi. Dönüş <strong>Fiyat</strong> Kodu : <strong>' . $fr->result . $fr->error->message . '</strong><br />';
            $out .= $d['ID'] . ' : ' . $d['name'] . ' Gönderildi. Dönüş <strong>Stok</strong> Kodu : <strong>' . $fs->result . $fs->error->message . '</strong><br />';
            /*
            if((int)$fr->error->errorId == 176)
            {
                $dr = $gg->deleteProduct(array($d['barkodNo']), null);
                $out .= $d['ID'] . ' : ' . $d['name'] . ' hata alındığu için silinip, yeni bir ürün olarak gönderilecek : <strong>' . $dr->result . '</strong><br />';
                my_mysql_query("update urun set barkodNo = '' where ID='".$urunID."'");
                pazarLog($d['ID'], 'GittiGidiyor',$dr->result."\n",0);
            }
            */
        } else {
            return adminErrorv3('GittiGidiyor tarafından UPDATE sırasında bağlantı kesildi. ' . $d['name'] . ' (' . $d['ID'] . ') iletilemedi. Lütfen daha sonra tekrar deneyin.');
            pazarLog($d['ID'], 'GittiGidiyor', 'GittiGidiyor tarafından UPDATE sırasında bağlantı kesildi. ' . $d['name'] . ' (' . $d['ID'] . ') iletilemedi. Lütfen daha sonra tekrar deneyin.', 1);
        }
        $var = 'Varyantsız';
    } catch (Exception $e) {
        pazarLog($d['ID'], 'GittiGidiyor', 'GittiGidiyor tarafından UPDATE sırasında bağlantı kesildi. ' . $d['name'] . ' (' . $d['ID'] . ') iletilemedi. Lütfen daha sonra tekrar deneyin.' . addslashes($e), 1);
        echo adminErrorv3('GittiGidiyor tarafından UPDATE sırasında bağlantı kesildi. ' . $d['name'] . ' (' . $d['ID'] . ') iletilemedi. Lütfen daha sonra tekrar deneyin.');
    }

    if ($l->productId) {
        if (!$varID)
            my_mysql_query("update urun set barkodNo = '" . $l->productId . "' where ID = '$urunID' limit 1");
        else
            my_mysql_query("update urunvarstok set barkodNo = '" . $l->productId . "' where ID = '$varID' limit 1");
    }
    $fiyat = getGGPrice($d);
    pazarLog($d['ID'], 'GittiGidiyor', "(UPDATE urunID : $urunID - $fiyat TL) " . strip_tags($out) . $l->result . $l->error->message, ($l->error->message ? 1 : 0));
    return adminInfov3("(UPDATE urunID : $urunID - $fiyat TL) " . $out . ($l->result . $l->error->message) . "<br/>\r\n");
}
function gg_updateSiparisListFinished()
{
    $out = '';
    $gg = new ggClient();
    $query = my_mysql_query("SELECT * FROM  `siteConfig` LIMIT 1");
    $config = my_mysql_fetch_array($query);
    $kargoAdi = $config['gg_Kargo'];
    $query = my_mysql_query("SELECT * FROM  `siparis` WHERE `odemeTipi` = 'GittiGidiyor' AND `kargoSeriNo` != '' AND `kargoFirma` != '' AND `durum` != 51 AND `durum` != 91 AND `durum` != 81 LIMIT 30");
    $ilAdi = hq("select name from iller where ID = '" . $config['gg_Sehir'] . "'");
    while ($v = my_mysql_fetch_array($query)) {
        $kargoSeriNo = $v['kargoSeriNo'];
        $ggID = str_replace('GG-', '', $v['randStr']);
        $l = $gg->sendCargoInformation($ggID, $kargoSeriNo, $kargoAdi, $ilAdi, null, $config['gg_KargoUcreti']);
        if (isset($l->ackCode) && $l->ackCode == 'success') {
            $out .= $v['ID'] . " GG kargo güncellemesi gönderildi.\n";
            my_mysql_query("UPDATE siparis SET `durum` = 51, `data5` = 5 WHERE ID = '" . $v['ID'] . "' LIMIT 1");
        } else {
            $out .= $v['ID'] . " GG kargo güncellemesi gönderilemedi.\n";
        }
    } {
        @$list = $gg->getSales(1, 100, 1, 'C');
        if (is_array($list->sales->sale)) {
            $take = $list->sales->sale;
        } else {
            $take = $list->sales;
        }

        foreach ($take as $l) {
            my_mysql_query("UPDATE siparis SET durum = 51 WHERE randStr = 'GG-" . $l->saleCode . "' AND durum != 51 AND (data5 !=5 OR data5 !=6) LIMIT 1");
        }
    } {
        @$list = $gg->getSales(1, 100, 1, 'O');
        if (is_array($list->sales->sale)) {
            $take = $list->sales->sale;
        } else {
            $take = $list->sales;
        }

        foreach ($take as $l) {
            my_mysql_query("UPDATE siparis SET durum = 81 WHERE randStr = 'GG-" . $l->saleCode . "' AND durum != 81 LIMIT 1");
        }
    } {
    }
    return $out;
}

function gg_catSpecs($catID)
{
    return;
    $out = "Aşağıdaki varyasyonlar, ürün girişlerindeki varyasyonlar ile eşleştirilir. Eşleşen varyasyonlar seçim için GittiGidiyor API'si ile iletilir ve siparişlerde kullanıcı seçimlerine sunulur.<br /><br />";
    $gg = new ggClient();
    $l = $gg->getCategoryVariantSpecs($catID);
    if (is_array($l->specs->spec)) {
        $take = $l->specs->spec;
    } else {
        $take = $l->specs;
    }

    foreach ($take as $spec) {
        $out .= '<strong>' . $spec->name . '</strong><br />';
        foreach ($spec->specValues->specValue as $value) {
            $out .= '-- ' . (trim($value->value)) . '<br />' . "\n";
        }
        if (!is_array($spec->specValues->specValue)) {
            $out .= '-- ' . (trim($spec->value)) . '<br />' . "\n";
        }
        $out .= '<br />';
    }
    return $out;
}

function gg_uploadProducts($catID)
{
    $selectcat = array();
    $q = my_mysql_query("select urun.*,marka.name markaAdi from urun,kategori,marka where ".($_GET['urunID']?'urun.ID='.(int)$_GET['urunID'].' AND ':'')." urun.markaID=marka.ID AND urun.catID=kategori.ID AND kategori.gg_Kod != ''   AND urun.noxml != 1 AND urun.nogg != 1  AND (showCatIDs like '%|" . $catID . "|%' OR catID = '$catID' OR showCatIDs like '|" . $catID . "|%' OR showCatIDs like '|" . $catID . "|%' OR showCatIDs like '|" . $catID . "|'  or kategori.idPath like '" . hq("select idPath from kategori where ID='$catID'") . "/%') AND kategori.active = 1");
    $out = 'Toplam gönderilecek ürün : ' . my_mysql_num_rows($q) . '<br />';
    $gg = new ggClient();
    if (!$_POST['gg_specs']) {
        $out .= "<form method='post'><input type='hidden' name='gg_specs' value='true'>";
    } else {
        $updated = array();
        foreach ($_POST as $k => $v) {
            if (substr($k, 0, 8) == 'ggspecs_') {
                list($prefix, $ID, $name, $name2) = explode('_', $k);
                if (!in_array($ID, $updated)) {
                    my_mysql_query("update urun set filtre_gg = '' where ID='$ID'");
                }

                if ($name2) {
                    $name = $name . '.' . $name2;
                }

                $updated[] = $ID;
                $older = hq("select filtre_gg from urun where ID='$ID' AND ID!='" . rand(1, 99999) . "'");
                $xarr = explode('_', $older);
                $filter = '';
                foreach ($xarr as $x) {
                    list($s1, $s2) = explode('|', $x);
                    if ($s1 && $s1 != $name) {
                        $filter .= '_' . $x;
                    }
                }
                if ($v) {
                    my_mysql_query("update urun set filtre_gg = '" . $filter . "_" . $name . "|" . $v . "' where ID='$ID'");
                }
            }
        }
    }
    while ($d = my_mysql_fetch_array($q)) {
        if (!$_POST['gg_specs']) {
            $select = $selectcat[$d[catID]];
            if (!$select) {
                $l = $gg->getCategorySpecs(hq("select gg_Kod  from kategori where ID='" . $d['catID'] . "'"));
                if (is_array($l->specs->spec)) {
                    $take = $l->specs->spec;
                } else {
                    $take = $l->specs;
                }

                foreach ($take as $spec) {
                    if ($spec->required) {
                        $specName = (str_replace(' ', '--', $spec->name));
                        $selectOut = '<select class="form-control mb-md gg-select" name="' . $specName . '"><option value="">' . ($spec->name) . '</option>';
                        foreach ($spec->values->value as $value) {
                            $selectOut .= '<option>' . (trim($value)) . '</option>' . "\r\n";
                        }
                        if (!is_array($spec->values->value)) {
                            $selectOut .= '<option>' . (trim($spec->values->value)) . '</option>' . "\r\n";
                        }
                        $selectOut .= '</select>' . "\n";
                        if ($specName == 'Marka') {
                            if (stristr($selectOut, '<option>' . ucfirst(strtolower($d['markaAdi'])) . '</option>') === false) {
                                $selectOut = str_replace('<option>Diğer</option>', '<option selected>Diğer</option>', $selectOut);
                            } else {
                                $selectOut = str_replace('<option>' . ucfirst(strtolower($d['markaAdi'])) . '</option>', '<option selected>' . ucfirst(strtolower($d['markaAdi'])) . '</option>', $selectOut);
                            }
                        }
                        $select .= $selectOut;
                    }
                }
            }
            $selectcat[$d[catID]] = $select;
            $selectx = str_replace('name="', 'name="ggspecs_' . $d['ID'] . '_', $select);
            $specs = $d['filtre_gg'];
            if(!$specs && siteConfig('gg_esitle'))
                $specs = hq("select filtre_gg from urun where catID='".$d['catID']."' AND filtre_gg != ''");
            $sarr = explode('_', $specs);
            foreach ($sarr as $s) {
                list($k, $v) = explode('|', $s);
                if ($v) {
                    $selectx = str_replace('<option>' . trim($v) . '</option>', '<option selected>' . $v . '</option>', $selectx);
                    $selectx = str_replace('<option value="' . trim($v) . '">', '<option selected value="' . trim($v) . '">' . $v . '</option>', $selectx);
                }
            }
            $selectx = str_replace('<option>Sıfır</option>', '<option selected>Sıfır</option>', $selectx);
            $selectx = str_replace('<option>Var, Başlamamış</option>', '<option selected>Var, Başlamamış</option>', $selectx);
            $out .= ('<div style="white-space:nowrap;" class="topluSecim"><br/>' . $d['name'] . ' :<br/>' . $selectx . '</div>');
            $out .= '<div class="clear-space"></div>';
        } else {
            if (!$d['stok'] || !$d['active']) {
                $l = $gg->finishEarly(null, array(
                    $d['ID'],
                ));
                $out .= adminInfov3("(UPDATE urunID : " . $d['ID'] . " Stok olmadığından, varsa bitirme emri verildi.) " . ($l->result . $l->error->message) . "<br/>\r\n");
            } else {

                if (!siteConfig('gg_hemen')) {
                    $out .= adminInfov3($d['ID'] . ' - ' . $d['name'] . ' : Ürün gün içerisinde <strong>' . ($d['barkodNo'] ? 'update' : 'insert') . '</strong> için cronjob servise kaydedildi. Bu ürünü hemen göndermek için <a target="_blank" href="../cron-gg.php?urunID=' . $d['ID'] . '">tıklayın</a>.');
                    my_mysql_query("update urun set ggup = 1 where ID='" . $d['ID'] . "'");
                } else {
                    $out .= adminInfov3($d['ID'] . ' - ' . $d['name'] . ' : ' . ($d['barkodNo'] ? 'Update için' : 'Insert için') . ' Gönderildi.');
                    if ($d['barkodNo']) {
                        $out .= gg_updateProducts($d['ID']);
                    } else {
                        $out .= gg_insertProducts($d['ID']);
                    }
                }
            }
        }
    }
    if (!$_POST['gg_specs']) {
        $out .= '<div>&nbsp;</div><div class="button-box">
                    	<input type="submit" name="button" value="Gönder" class="st-button"/>
						<input type="reset" name="button" value="Geri Al" class="st-clear"/>

					</div></form>
					<script>
							$(".topluSecim:first").is(function(){
								$(this).parents(".alert").before("<div class=\"alert alert-info topunuSec\" style=\"overflow:hidden\"><strong>Bilgi : </strong> Toplu Seçim <br><br>' . addslashes(str_replace(array(
            "\n",
            "\r",
        ), '', $select)) . '</div>");
								$(".topunuSec select").each(function(i,e){
									$(this).data("i",i);
								});
								$(".topunuSec select").change(function(){
									var thisName = $(this).prop("name");
									var thisSelect = $(this);
									var thisI = $(this).data("i");
									$(".topluSecim").each(function(i,e){
										$("select:eq("+thisI+")",this).val($(thisSelect).val());
									});
								});
							});
					</script>
		';
        $out = adminInfov3($out);
    } else {
        $out .= adminInfov3('<a target="_blank" href="../cron-gg.php">Buraya tıklayarak</a> cronjob servisi manuel çalıştırabilirsiniz.');
    }

    return $out;
}
function gg_catList()
{
    global $siteDizini, $yonetimDizini;
    $out = '';
    $file = $_SERVER['DOCUMENT_ROOT'] . '/' . $siteDizini . $yonetimDizini . 'bayiXML/ggcatlist.txt';
    if ($_SESSION['gg_catList'] && !$_GET['gg_catList']) {
        return $_SESSION['gg_catList'];
    }

    if (!$_GET['gg_catList']) {
        if (file_exists($file) && filesize($file) > 100) {
            return file_get_contents($file);
        }

        return;
    }
    $gg = new ggClient();
    for ($i = 0; $i <= 10000; $i = $i + 100) {
        @$catList = $gg->getCategories($i, 100, 0);
        if (!@sizeof($catList->categories->category)) {
            break;
        }

        foreach ($catList->categories->category as $cat) {
            $arr[$cat->categoryCode] = str_pad('', (strlen($cat->categoryCode) - 1), '--') . '' . ($cat->categoryName);
        }
    }
    ksort($arr);
    foreach ($arr as $k => $v) {
        $out .= $k . '|' . str_replace(array(
            ',',
            '|',
        ), ' + ', $v) . ',';
    }
    dosyayaz($file, $out);
    $_SESSION['gg_catList'] = $out;
    return $out;
}

function object_to_array($data)
{
    if (is_array($data) || is_object($data)) {
        $result = array();
        foreach ($data as $key => $value) {
            $result[$key] = object_to_array($value);
        }
        return $result;
    }
    return $data;
}
