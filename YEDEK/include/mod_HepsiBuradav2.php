<?php
@ini_set('max_execution_time', 1000);
@ini_set('default_socket_timeout', 1000);
require_once('3rdparty/hepsiburada.php');

function getHbPrice($d,$f = 'fiyat')
{
    if ((int) siteConfig('hb_fiyatAlani') > 0 && $f == 'fiyat') {
        $field = 'fiyat' . siteConfig('hb_fiyatAlani');
        if ($d[$field] > 1)
            $d['fiyat'] = $d[$field];
    }
    else
        $d['fiyat'] = $d[$f];
  //  $d['fiyat'] = fixFiyat($d['fiyat'], 0, $d);
    $d['fiyat']+=$d['hb_e'];
    $kar = hq("select hbkar from kategori where ID='" . $d['catID'] . "' limit 1");
    if (!$kar)
        $kar = siteConfig('hb_oran');
    $fiyat = YTLfiyat($d['fiyat'], $d['fiyatBirim']);
    $fiyat = ($fiyat * (1 + ((float) $kar)));
    if ((float) $fiyat <= (float) siteConfig('hb_azami'))
    {
        $fiyat = ($fiyat + ((float) siteConfig('hb_fiyat')));
        if(siteConfig('hb_desi') && ((float) $fiyat <= siteConfig('minKargo')))
        {    
            $desi = (hq('select kargoDesi.fiyat from kargoDesi where firmaID=\'' . siteConfig('hb_kargoID') . '\' AND desiBaslangic <= ' . $d['desi'] . ' AND desiBitis >= ' . $d['desi'] . ' order by kargoDesi.fiyat desc limit 0,1'));
            $desi = YTLfiyat($desi, hq('select kargoDesi.fiyatBirim from kargoDesi where firmaID=\'' . siteConfig('hb_kargoID') . '\' AND desiBaslangic <= ' . $d['desi'] . ' AND desiBitis >= ' . $d['desi'] . ' order by kargoDesi.fiyat desc limit 0,1'));
            $fiyat += $desi;
        }
    }
    $fiyat = my_money_format('', $fiyat);
    $fiyat = str_replace(',', '', $fiyat);
    if(function_exists('hbCustomPrice'))
        $fiyat = hbCustomPrice($d,$fiyat);
    return $fiyat;
}
function buildHbProduct($d)
{
    global $siteDizini;
    if (strlen($d['gtin']) < 12 && siteConfig('tygtin'))
        $d['gtin'] = str_pad($d['ID'], 14, '9', STR_PAD_LEFT);
    if (!$d['kargoGun'] && !$d['anindaGonderim'])
        $d['kargoGun'] = siteConfig('hb_kargo_gun');
    $d['IDx'] = $d['ID'];
    if ($d['tedarikciCode'])
        $d['ID'] = $d['tedarikciCode'];
    else if ($d['gtin'])
        $d['ID'] = $d['gtin'];
    if ($d['stok'] < 0 || !$d['active'] || !$d['fiyat'])
        $d['stok'] = 0;
    $d['name'] = substr($d['name'], 0, 64);
    $d['detay'] = siteConfig('hb_header').$d['detay'].siteConfig('hb_footer');
    $d['name'] = str_replace('&#39;', "'", $d['name']);
    if($d['var1'])
    $d['name'].=' '.$d['var1'];
    if($d['var2'])
    $d['name'].=' '.$d['var2'];
    if (function_exists('mb_convert_encoding'))
        $d['name'] = mb_convert_encoding($d['name'], 'UTF-8', 'UTF-8');
    if (function_exists('mb_convert_encoding'))
        $d['listeDetay'] = mb_convert_encoding($d['listeDetay'], 'UTF-8', 'UTF-8');
    //$fiyat = YTLfiyat(((float)$d['piyasafiyat'] > 0?$d['piyasafiyat']:$d['fiyat']), $d['fiyatBirim']);
    $fiyat = getHbPrice($d);
    $piyasaFiyat = getHbPrice($d,'piyasaFiyat');

    $parr['categoryId'] = $d['hb_Kod'];

    $parr['attributes'] = array();
    // sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    $parr['merchant'] = siteConfig('hb_mID');
    $parr['attributes']['merchantSku'] =  ($d['varID']?$d['ID'].'-'.$d['varID']:$d['ID']);
    $parr['attributes']['VaryantGroupID'] = $d['parentID'] ? $d['parentID'] : $d['ID'];
    $parr['attributes']['Barcode'] = ($d['gtin']?$d['gtin']:$d['ID']);
    $parr['attributes']['UrunAdi'] = $d['name'];
    $parr['attributes']['UrunAciklamasi'] = $d['onDetay'].'<hr />'.$d['detay'];
    $parr['attributes']['Marka'] = $d['markaAdi'];
    if($d['garanti'])
        $parr['attributes']['GarantiSuresi'] = $d['garanti'];
    $parr['attributes']['price'] = (string)str_replace('.',',',$fiyat);
    $parr['attributes']['stock'] = $d['stok'];
    $parr['attributes']['kg'] = $d['desi'];
    $parr['attributes']['tax_vat_rate'] = ((float)$d['kdv'] * 100);
    $parr['attributes']['tax_vat_rate'] = ((float)$d['kdv'] * 100);
    if ($d['resimhb'])
        $d['resim'] = $d['resimhb'];
    $n = 1;
    for ($i = 1; $i <= 5; $i++) {
        $rname = 'resim' . ($i > 1 ? $i : '');
        list($width) = getimagesize($_SERVER['DOCUMENT_ROOT'] . $siteDizini . 'images/urunler/' . $d[$rname]);
        if ($width > 150 && $d[$rname]) {
            $parr['attributes']['Image'.($n)]= 'https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'images/urunler/' . $d[$rname];
            $n++;
        }
    }


   //echo hq("select filter from hepsiburada where urunID='" . $d['IDx'] . "' AND ID!='" . rand(1, 99999) . "'");

    $sarr = explode('_', hq("select filter from hepsiburada where urunID='" . $d['IDx'] . "' AND ID!='" . rand(1, 99999) . "'"));
    $spi = 0;

    if (sizeof($sarr)) {

        foreach ($sarr as $s) {
            list($k, $v, $n, $p) = explode('|', $s);
            $value = $v;
            $value = str_replace("&#39;", "'", $value);
            $n = str_replace('?', '–', $n);
            if (!$value)
                continue;
            if ($k && $v) {
                if (!$value || ($k == $v))
                    continue;
                $parr['attributes'][$k.'_variant_property'] = $value;
                $parr['attributes'][$k] = $value;
                $spi++;
            }
        }
    }
    if($d['var1id'])
    {
        $parr['attributes'][$d['var1id']] = $d['var1value'];;
    }
    if($d['var2id'])
    {
        $parr['attributes'][$d['var2id']] = $d['var2value'];;
    }
    //echo debugArray($parr);

    return $parr;
}

$catSpecsArrayCache = null;

function insertTyLog($str)
{
    return;
}

function productVarReplace($d, $out)
{
    autoAddFormField('urunvarstok', 'barkodNo_hb', 'TEXTBOX');
    $q2 = my_mysql_query("select * from urunvarstok where up=1 AND var1 != '' AND urunID='" . $d['ID'] . "'");
    if (my_mysql_num_rows($q2)) {
        $out = array();
    }

    while ($d2 = my_mysql_fetch_array($q2)) {
        $varID = ($d['kod']?$d['kod']:$d2['ID']);
        $var1 = $d2['var1'];
        $var2 = $d2['var2'];
        // $d['name'] = hq("select name from urun where ID='" . $d['ID'] . "'") . ' ' . $var1 . ($var2 && $var1 != $var2 ? ' ' . $var2 : '');
        $d['stok'] = $d2['stok'];
        $d['hb_e'] = (hq("select gg_e from urun where ID='".$d['ID']."'") + $d2['fark']);
        $d['gtin'] = $d2['gtin']?$d2['gtin']:$d2['kod'];
        if (!$d['parentID'])
            $d['parentID'] =  $d['tedarikciCode'];
        if (!$d['parentID'])
            $d['parentID'] =  $d['ID'];
        $d['varCode'] = $d2['kod'];
        $d['varID'] = $varID;
        $d['var1name'] = (trim(hq("select ozellik from var where ID='" . $d['varID1'] . "' limit 0,1")));
        $d['var2name'] = (trim(hq("select ozellik from var where ID='" . $d['varID2'] . "' limit 0,1")));
        $d['var1namet'] = (trim(hq("select tanim from var where ID='" . $d['varID1'] . "' limit 0,1")));
        $d['var2namet'] = (trim(hq("select tanim from var where ID='" . $d['varID2'] . "' limit 0,1")));
        $d['var1'] = $var1;
        $d['var2'] = $var2;
        
        $d = getHBVarCode($d);

     //   echo debugArray($d);



        $q22 = my_mysql_query("select * from urunvar where urunID = '" . (int) $d['ID'] . "' AND (varName like '" . addslashes($var1) . "' OR varName like '" . addslashes($var2) . "')");
        $d22 = my_mysql_fetch_array($q22);
        if ($d22['resim1']) {
            $d['resim'] = $d['resim2'] = $d['resim3'] = $d['resim4'] = $d['resim5'];
        }
        if ($d22['resim1']) $d['resim'] = 'var/' . $d22['resim1'];
        if ($d22['resim2']) $d['resim2'] = 'var/' . $d22['resim2'];
        if ($d22['resim3']) $d['resim3'] = 'var/' . $d22['resim3'];
        if ($d22['resim4']) $d['resim4'] = 'var/' . $d22['resim4'];
        if ($d22['resim5']) $d['resim5'] = 'var/' . $d22['resim5'];
        $out[] = buildHbProduct($d);
    }
    //echo debugArray($out);
    return $out;
}
$catSpecsArrayCache = null;
function getHBVarCode($d)
{
    global $catSpecsArrayCache;
    $hepsiburada = new HepsiBurada;
    $var = array();
    $var[0] = array('numara', 'no', 'beden','beden seçimi');
    $var[1] = array('renk', 'renkler','renk seçimi');
    $renk = $beden = false;
    for($i=1;$i<=2;$i++)
    {
        if(!$d['var'.$i])
            continue;
        $name = $d['var'.$i.'name'];
        if (in_array(strtolower($d['var'.$i.'name']), $var[0]) || in_array(strtolower($d['var1namet']), $var[0]))
        $beden = true;
        if (in_array(strtolower($d['var'.$i.'name']), $var[1]) || in_array(strtolower($d['var1namet']), $var[1]))
        $renk = true;

        if($renk || $beden)
        {
           
            if ($catSpecsArrayCache == null)
                $catSpecsArrayCache = $hepsiburada->getCategoryAttributes($d['hb_Kod']);      
            $vrenk = $vbeden = false;
            foreach ($catSpecsArrayCache->data->variantAttributes as $spec) {
             
                $name = strtolower(trim($spec->name));
                if(!(stristr($name,'renk') === false) || !(stristr($name,'reng') === false) && $renk)
                    $vrenk = true;
                if(!(stristr($name,'numara') === false) || !(stristr($name,'olcu') === false) || !(stristr($name,'beden') === false) && $beden)
                    $vbeden = true;
                
                if(!$vrenk && !$vbeden)
                {
                    continue;   
                }
                $id = trim($spec->id);
                $mandatory = (bool) trim($spec->mandatory);
                $spcArray[$name]['id'] = $id;
                $spcArray[$name]['mandatory'] = $mandatory;
                $spcArray[$name]['type'] = trim($spec->type);
                for ($pi = 0; $pi <= 10; $pi++) {

                    $sArray = $hepsiburada->getCategoryAttributesData($d['hb_Kod'], $id,$pi);


                    if (!sizeof($sArray->data)) {
                        $d['var' . $i . 'id'] = $id;
                        $d['var' . $i . 'value'] = $d['var' . $i];
                    }
                    foreach ($sArray->data as $value) {
                        $spcArray[$name]['values'][] = array($value->id, $value->value);
                        if (($value->value == $d['var' . $i]) || ($value->value == str_replace('-', ' - ', $d['var' . $i])) || ($value->value == str_replace('/', ' - ', $d['var' . $i]))) {
                            $d['var' . $i . 'id'] = $id;
                            $d['var' . $i . 'value'] = $value->id;
                            if ($spcArray[$name]['type'] == 'enum')
                            $d['var' . $i . 'value'] = $value->value;
                        }
                    }
                }
            }    
        }
    }
    return $d;
}

function hb_insertProducts($urunIDs)
{
    if (!is_array($urunIDs))
        $urunIDs = array($urunIDs);
    return hb_products($urunIDs);
}

function hb_products($urunIDs)
{


    $out = '';
    $hb = new HepsiBurada();
    $products = array();
    foreach ($urunIDs as $urunID) {
        $q = my_mysql_query("select urun.*,kategori.hb_Kod,marka.name markaAdi from urun,kategori,marka where urun.noxml != 1 AND urun.barkodNo_HB = '' AND urun.markaID = marka.ID AND urun.catID = kategori.ID AND kategori.hb_Kod != '' AND urun.ID='$urunID' limit 1", 1);
        $d = my_mysql_fetch_array($q);
        if (!$d['ID'])
        {     
            $out .= 'urunYok (' . $urunID . ')';
            continue;
        }
        if((int)$d['barkodNo_hb'] == -1 || $d['nohb'])
        {
            $out .= 'Hepsiburada gönderimine kapalı. (' . $urunID . ')<br />';
            continue;
        }

        if((float)siteConfig('hb_asgari')  > 1 && YTLfiyat($d['fiyat'],$d['fiyatBirim']) < (float)siteConfig('hb_asgari'))
        {
            pazarLog($urunID,'HepsiBurada','Urun fiyat asgari tutardan düşük (' . $urunID . ' : '.YTLfiyat($d['fiyat'],$d['fiyatBirim']).')' ,0);
            continue;
        }  
        $products[] = buildHbProduct($d);
        $products = productVarReplace($d, $products);
    }
    $result = $hb->createProducts($products);


    if($result->success)
    {
        my_mysql_query("insert into hbrapor (ID,trackingId) VALUES (0,'".addslashes($result->data->trackingId)."')",1);
        $out.= adminInfov3('HepsiBurada Ürün Kontrol ID : <a target="_blank" href="s.php?f=hbRaporlari.php&y=d&raporID='.$result->data->trackingId.'">'.$result->data->trackingId.'</a>');
    }
    else $out.= adminErrorv3(debugArray($out));
    return $out;
}

autoAddFormField('urun', 'hb_tarih', 'TEXTBOX');
function hb_uploadProducts($catID)
{
    $hepsiburada = new HepsiBurada();
    $updateUrunIDs = $insertUrunIDs = array();
    $query = "select urun.*,marka.name markaAdi from urun,kategori,marka where " . ($_GET['urunID'] ? 'urun.ID=' . (int)$_GET['urunID'] . ' AND ' : '') . " urun.markaID=marka.ID AND urun.catID=kategori.ID AND kategori.hb_Kod != '' AND catID = '$catID' AND kategori.active = 1 AND urun.active = 1";
    $q = my_mysql_query($query, 1);
    while ($d = my_mysql_fetch_array($q)) {
        if ($_POST['hb_specs']) {
            my_mysql_query("update hepsiburada set filter = '' where urunID='" . $d['ID'] . "' limit 1", 1);
        }
    }
    $out = 'Toplam gönderilecek ürün : ' . my_mysql_num_rows($q) . '<br />';
    if (!$_POST['hb_specs']) {
        $out .= "<form method='post'><input type='hidden' name='hb_specs' value='true'>";
        $catSpecsArray = $hepsiburada->getCategoryAttributes($_GET['hbcatID']);
    } else {
        $updated = array();
        foreach ($_POST as $k => $v) {
            if (substr($k, 0, 8) == 'hbspecs_') {
                list($prefix, $ID, $name) = explode('_', $k);
                if (!in_array($ID, $updated)) {
                    if (!hq("select ID from hepsiburada where urunID='$ID'"))
                        my_mysql_query("insert into hepsiburada (filter,urunID) VALUES ('','$ID')");
                    else
                        my_mysql_query("update hepsiburada set filter = '' where urunID='$ID' limit 1");
                }
                $updated[] = $ID;
                $older = hq("select filter from hepsiburada where urunID='$ID' AND ID!='" . rand(1, 99999) . "'");
                $xarr = explode('_', $older);
                $filter = '';
                //echo debugArray($_POST);
                foreach ($xarr as $x) {
                    list($s1, $s2, $s3,$s4) = explode('|', $x);
                    //if ($s1 && $s1 != $name && $s3 && $x)
                        $filter .= '_' . $x;
                }
                if ($v) {
                    $specName = $_POST['hbspecs_' . $ID . '_' . str_replace('--', ' ', $name) . '_name'];
                    $specIsVar = $_POST['hbspecs_' . $ID . '_' . str_replace('--', ' ', $name) . '_isVar'];
                    my_mysql_query("update hepsiburada set filter = '" . $filter . "_" . $name . "|" . $v . "|" . $specName . "|".$specIsVar."' where urunID='$ID' limit 1",1);
                 //   echo "update hepsiburada set filter = '" . $filter . "_" . $name . "|" . $v . "|" . $specName . "|".$specIsVar."' where urunID='$ID' limit 1<br />";
                    //echo $filter . "_" . $name . "|" . $v . "|" . $specName . "|".$specIsVar;
                }
            }
        }
    }


  //  echo debugArray($catSpecsArray);
    autoAddFormField('urun', 'hb_cron', 'CHECKBOX');
    $q = my_mysql_query($query);
    $selectcat = array();
    while ($d = my_mysql_fetch_array($q)) {
        if (!$_POST['hb_specs']) {
            $select = $selectcat[$d[$catID]];
            if (!$select) {
                $selectOut = '';
                foreach ($catSpecsArray->data->attributes as $spec) {
                    $name = trim($spec->name);
                    $id = trim($spec->id);
                    $mandatory = (bool) trim($spec->mandatory);
                    $spcArray[$name]['id'] = $id;
                    $spcArray[$name]['mandatory'] = $mandatory;
                    $spcArray[$name]['type'] = trim($spec->type);

                    for($pi=0;$pi<=10;$pi++)
                    {
                        $sArray = $hepsiburada->getCategoryAttributesData($_GET['hbcatID'],$id,$pi);
                        //  echo debugArray($sArray);
                          foreach ($sArray->data as $value) {
                              $spcArray[$name]['values'][] = array($value->id, $value->value);
                          }
                    }

                }
             
                foreach ($catSpecsArray->data->variantAttributes as $spec) {

               //     echo debugArray($spec);
                    $name = trim($spec->name);
                    $id = trim($spec->id);
                    $mandatory = (bool) trim($spec->mandatory);
                    $spcArray[$name]['id'] = $id;
                    $spcArray[$name]['mandatory'] = $mandatory;
                    $spcArray[$name]['type'] = trim($spec->type);
                    for($pi=0;$pi<=10;$pi++)
                    {
                        $sArray = $hepsiburada->getCategoryAttributesData($_GET['hbcatID'],$id,$pi);
                        foreach ($sArray->data as $value) {
                            $spcArray[$name]['values'][] = array($value->id, $value->value);
                        }
                    }
                }

                foreach ($catSpecsArray->data->baseAttributes as $spec) {

                    //     echo debugArray($spec);
                         $name = trim($spec->name);
                         $id = trim($spec->id);
                         $mandatory = (bool) trim($spec->mandatory);
                         $spcArray[$name]['id'] = $id;
                         $spcArray[$name]['mandatory'] = $mandatory;
                         $spcArray[$name]['type'] = trim($spec->type);
                         for($pi=0;$pi<=10;$pi++)
                         {
                            $sArray = $hepsiburada->getCategoryAttributesData($_GET['hbcatID'],$id,$pi);
                            foreach ($sArray->data as $value) {
                                $spcArray[$name]['values'][] = array($value->id, $value->value);
                            }
                         }

                     }

               // echo debugArray($spcArray);
                /*
                foreach ($catSpecsArray->data->variantAttributes as $spec) {
                    $name = trim($spec->name).' (Varyasyon)';
                    $id = trim($spec->id);
                    $mandatory = (bool) trim($spec->mandatory);
                    $spcArray[$name]['id'] = $id;
                    $spcArray[$name]['mandatory'] = $mandatory;
                    $spcArray[$name]['isVar'] = true;

                    $qv = my_mysql_query("select ID, tanim from var");
                    while($dv = my_mysql_fetch_array($qv))
                    {
                        $spcArray[$name]['values'][] = array($dv['ID'], $dv['tanim']);
                    }
                }
                */
                

                foreach ($spcArray as $k => $v) {
                    if (!$v['mandatory'] && !siteConfig('hb_zorunlu'))
                        continue;
                    if(count($v['values']) < 1)
                        continue;
                    $specName = $k;
                    $specID = $v['id'];
                    if ($specName) {

                        if($v['type'] == 'string')
                        {
                            $onkeyup = '';
                            if(stristr($v['id'],'hbspecs') === false)
                            {
                                $onkeyup = "$('.all-input').val($(this).val());";
                            }
                            if($v['isVar'])
                                $selectOut .= '<input type="hidden" name="' . (str_replace(' ', '--', $v['id'])) . '_isVar" value="1" />';
                             $selectOut .= '<input type="hidden" name="' . (str_replace(' ', '--', $v['id'])) . '_name" value="' . $specID . '" /><input placeholder="'.trim($specName).'" style="border: 1px solid #E5E7E9;
                             border-radius: 6px;
                             height: 46px;
                             padding: 12px;
                             outline: none;" type="text" onkeyup="'.$onkeyup.'" class="all-input" name="' . (str_replace(' ', '--', $v['id'])) . '">';
                        }
                        else
                        {
                            if (stristr($selectOut, '<option value="">' . $specName . ' </option>') === false && stristr($selectOut, '<option value="">' . $specName . ' - Zorunlu</option>') === false) {
                                if($v['isVar'])
                                    $selectOut .= '<input type="hidden" name="' . (str_replace(' ', '--', $v['id'])) . '_isVar" value="1" />';
                                $selectOut .= '<input type="hidden" name="' . (str_replace(' ', '--', $v['id'])) . '_name" value="' . $specID . '" /><select name="' . (str_replace(' ', '--', $v['id'])) . '"><option value="">' . $specName . ' ' . ($v['mandatory'] ? '- Zorunlu' : '') . ' / '.$v['type'].'</option>';
                            }
                            foreach ($v['values'] as $value) {
                                $id = $value[0];
                                $name = $value[1];
                                if($v['type'] == 'enum')
                                    $id = $name;
                                $check = '<option value="' . (trim($id)) . '">' . (trim($name)) . '</option>';
                                $selectOut .= $check;
                            }
                            $selectOut .= '</select>';
                        }

                    }
                }
                $select .= $selectOut;
            }
            $selectcat[$d[$catID]] = $select;
            $selectx = str_replace('name="', 'name="hbspecs_' . $d['ID'] . '_', $select);
            $specs = hq("select filter from hepsiburada where urunID='" . $d['ID'] . "'");
            $sarr = explode('_', $specs);
            foreach ($sarr as $s) {
                list($k, $v) = explode('|', $s);
                if ($v)
                    $selectx = str_replace('<option value="' . trim($v) . '">', '<option selected value="' . trim($v) . '">', $selectx);
            }
            $selectx = str_replace('>Sıfır</option>', ' selected>Sıfır</option>', $selectx);
            $selectx = str_replace('<option>Var, Başlamamış</option>', '<option selected>Var, Başlamamış</option>', $selectx);
            $selectx = str_replace('>' . ucfirst(strtolower($d['markaAdi'])) . '</option>', ' selected>' . ucfirst(strtolower($d['markaAdi'])) . '</option>', $selectx);
            $out .= ('<div class="topluSecim"><br/>' . $d['name'] . ' (' . $d['ID'] . ') <br/>' . $selectx . '<div class="clear"></div></div><hr />');
        } else {
            if (!$d['active']) {
                $d['stok'] = 0;
            }
            $ID = $d['ID'];
            $out .= adminInfov3('urunID ' . $d['ID'] . ': Update / Insert için Gönderildi.');
            $insertUrunIDs[] = $d['ID'];
            $out .= hb_insertProducts($insertUrunIDs);        
            unset($updateUrunIDs, $insertUrunIDs);   
        }


    }
    if ($_POST['hb_specs'])
        $out .= adminInfov3('<a target="_blank" href="../cron/cron-hb.php">Buraya tıklayarak</a> cronjob servisi manuel çalıştırabilirsiniz.');
    if (!$_POST['hb_specs']) {
        $out .= v5Admin::simpleFormFooter();
        $out = adminInfov3($out);
        $out .= '<script type="text/javascript">
							$(".topluSecim:first").is(function(){
								$(this).parents(".alert").before("<div class=\"alert alert-info topunuSec\" style=\"overflow:hidden\"><strong>Bilgi : </strong> Toplu Seçim <br><br>' . addslashes(str_replace(array(
            "\n",
            "\r"
        ), '', $select)) . '<div class=\'clear\'></div></div><div class=\'clear\'></div>");
								$(".topunuSec select").each(function(i,e){
                                    var options = $(this).find(\'option:not(:first)\');
                                    var arr = options.map(function(_, o) { return { t: $(o).text(), v: o.value }; }).get();
                                    arr.sort(function(o1, o2) { return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0; });
                                    options.each(function(i, o) {
                                    o.value = arr[i].v;
                                    $(o).text(arr[i].t);
                                    });
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
					</script>';
    }
    return $out;
}
function hb_updateSiparisList()
{
    $hepsiburada = new Hepsiburada();
    $out = '';
    $siparisler = $hepsiburada->getShipmentPackages();
    //  echo debugArray($siparisler);
    foreach ($siparisler->content as $siparis) {
        $siparis_no = $siparis->orderNumber;
        $spo = 'TY-' . $siparis_no;
        if (hq("select ID from siparis where randStr like '$spo' LIMIT 1")) {
            if ($_SESSION['admin_isAdmin'])
                $out .= "$spo Siparişi daha önceden kaydedilmiş. Bilgileri güncelleniyor.<br />";
            //continue;
        }
        $email = $siparis->customerEmail;
        $userID = hq("select ID from user where email like '" . $email . "'");
        $ad = $siparis->customerFirstName;
        $soyad = $siparis->customerLastName;
        if (!$userID) {
            $sql = "INSERT INTO `user` (`ID`, `name`, `lastname`, `sex`,`username`, `password`, `email`,`submitedDate`,`data1`,`address`,`city`,`semt`,`ceptel`) VALUES (
                                                        null,'" . $ad  . "','" . $soyad . "','','" . $email . "','" . md5(microtime()) . "','" . $email . "',now(),'" . $_SERVER['REMOTE_ADDR'] . "','" . ($siparis->shipmentAddress->address1 . ' ' . $siparis->shipmentAddress->address2 . ' / ' . $siparis->shipmentAddress->district . ' ' . $siparis->shipmentAddress->city) . "','" . hq("select plakaID from iller where name like '" . ($siparis->shipmentAddress->city) . "'") . "','" . hq("select ID from ilceler where name like '" . ($siparis->shipmentAddress->district) . "' AND parentID='" . hq("select plakaID from iller where name like '" . ($siparis->shipmentAddress->city) . "'") . "'") . "','');";
            my_mysql_query($sql);
            $userID = my_mysql_insert_id();
        }
        $sepetsayi = 0;
        $sepet = array();
        foreach ($siparis->lines as $urunler) {
            if (!$urunler->quantity)
                continue;
            $sepet[$sepetsayi]['userID'] = $userID;
            if (!$sepet[$sepetsayi]['urunID'])
                $sepet[$sepetsayi]['urunID'] = hq("select ID from urun where tedarikciCode='" . $urunler->merchantSku . "' OR gtin='" . $urunler->merchantSku . "' OR ID='" . $urunler->merchantId . "'");
            if (!$sepet[$sepetsayi]['urunID'])
                $sepet[$sepetsayi]['urunID'] = hq("select urunID from urunvarstok where kod='" . $urunler->merchantSku . "' OR ID='" . $urunler->merchantId . "'");
            $sepet[$sepetsayi]['ozellik1'] = hq("select var1 from urunvarstok where urunID='" . $sepet[$sepetsayi]['urunID'] . "' AND gtin like '" . $urunler->sku . "'");
            $sepet[$sepetsayi]['ozellik2'] = hq("select var2 from urunvarstok where urunID='" . $sepet[$sepetsayi]['urunID'] . "' AND gtin like '" . $urunler->sku . "'");
            $sepet[$sepetsayi]['urunName'] = $urunler->productName;
            $sepet[$sepetsayi]['ytlFiyat'] = $sepet[$sepetsayi]['fiyat'] = (float) ($urunler->price);
            $sepet[$sepetsayi]['ytlFiyatAlis'] = YTLfiyat(hq("select bayifiyat from urun where ID='" . $sepet[$sepetsayi]['urunID'] . "'"), hq("select fiyatBirim from urun where ID='" . $sepet[$sepetsayi]['urunID'] . "'"));
            $sepet[$sepetsayi]['fiyatBirim'] = 'TL';
            $sepet[$sepetsayi]['adet'] = (int) $urunler->quantity;
            $sepet[$sepetsayi]['kdv'] = (float) ($urunler->vatBaseAmount / 100);
            $sepet[$sepetsayi]['durum'] = 2;
            $sepetsayi++;
        }
        $toplamtutar = ((float) $siparis->grossAmount);
        $toplamKDVHaric = ($toplamtutar / 1.18);
        $toplamKDV = ($toplamtutar - ($toplamtutar / 1.18));
        $siparisx['userID'] = $userID;
        $siparisx['toplamKDVHaric'] = $toplamKDVHaric;
        $siparisx['toplamTutarTL'] = ($toplamtutar - $siparis->totalDiscount);
        $siparisx['toplamKargoDahil'] = ($toplamtutar);
        $siparisx['toplamIndirimDahil'] = ($toplamtutar - $siparis->totalDiscount);
        $siparisx['toplamKDVDahil'] = $toplamtutar;
        $siparisx['toplamKDV'] = $toplamKDV;
        $shipmentAddress_gsm = $siparis->shipmentAddress->gsm;
        $shipmentAddress_address = $siparis->shipmentAddress->address1 . ' ' . $siparis->shipmentAddress->address2;
        $shipmentAddress_district = $siparis->shipmentAddress->district;
        $shipmentAddress_city = $siparis->shipmentAddress->city;
        $invoiceAddress_address = $siparis->invoiceAddress->address1 . ' ' . $siparis->invoiceAddress->address2;
        $invoiceAddress_city = $siparis->invoiceAddress->city;
        $invoiceAddress_district = $siparis->invoiceAddress->district;
        $siparisx['name'] = ($siparis->shipmentAddress->firstName);
        $siparisx['lastname'] = ($siparis->shipmentAddress->lastName);
        $siparisx['firmaUnvani'] = $siparis->invoiceAddress->fullName;
        $siparisx['kargoSeriNo'] = $siparis->cargoTrackingNumber;
        $siparisx['ceptel'] = str_replace(' ', '-', $shipmentAddress_gsm);
        $siparisx['address'] = addslashes($shipmentAddress_address . ' ' . $shipmentAddress_district . ' / ' . $shipmentAddress_city);
        $siparisx['city'] = hq("select plakaID from iller where name like '" . ($shipmentAddress_city) . "'");
        $siparisx['semt'] = hq("select ID from ilceler where name like '" . ($invoiceAddress_district) . "' AND parentID='" . $siparisx['city'] . "'");
        $siparisx['address2'] = addslashes($invoiceAddress_address . ' ' . $invoiceAddress_district . ' / ' . $invoiceAddress_city);
        $siparisx['city2'] = hq("select plakaID from iller where name like '" . ($invoiceAddress_city) . "'");
        $siparisx['semt2'] = hq("select ID from ilceler where name like '" . ($invoiceAddress_district) . "' AND parentID='" . $siparisx['city2'] . "'");
        $siparisx['durum'] = 2;
        $siparisx['email'] = $email;
        $siparisx['odemeTipi'] = 'hepsiburada';
        $siparisx['kargoURL'] = $siparis->cargoTrackingLink;
        $siparisx['data5'] = $siparis->id; 
        if (hq("select ID from siparis where randStr like '$spo' LIMIT 1")) {
            unset($sepet);
        }
        //  exit(debugArray($sepet).debugArray($siparisx));
        siparisVer($sepet, $siparisx, $spo);
        if ($_SESSION['admin_isAdmin'])
            $out .= "$spo Siparişi Kaydedildi.<br />" . debugArray($siparis) . "<br />";
    }
    return $out;
}
function hb_getTrackingIDResult($trackingId)
{
    global $tempInfo;
    $hepsiburada = new HepsiBurada();
    $ta = $hepsiburada->getTrackingIDResult($trackingId);    
    $tempInfo .= adminInfov3('Rapor Durum : ' . ($ta->success?'Başarılı':'Beklemede'));
    $tempInfo .= adminInfov3('Rapor Toplam Veri Sayısı : ' . $ta->totalElements);
    foreach ($ta->data as $item) {
        $out = 'Ürün Kodu '.($item->merchantSku . ' : ' . $item->importStatus).'<br />';
        if (sizeof($item->importMessages)) {
            $out .= debugArray($item->importMessages).'<br />';
        }
    }
    $tempInfo .= adminInfov3($out);
    return debugArray($ta);
}

